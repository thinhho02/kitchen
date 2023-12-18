<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/kitchen/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/kitchen/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/kitchen/phpmailer/src/SMTP.php';
$data = [];
if (
    isset($_REQUEST['date']) && $_REQUEST['date'] !== ''
    && isset($_POST['idUser']) && $_POST['idUser'] !== ''
) {
    $date = $_REQUEST['date'];
    $id_user = $_POST['idUser'];

    $select_receipt = mysqli_query($con, "SELECT `payment`.`employee_id`,`receipts`.`receipt_id`,`receipts`.`price` 
                                            FROM `payment` 
                                            inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                            Where `receipts`.`status` = 'cart' 
                                            and `receipts`.`created_time` = '$date'
                                            and `payment`.`employee_id` = '$id_user'");
    if (mysqli_num_rows($select_receipt) > 0) {
        $row_receipt = mysqli_fetch_assoc($select_receipt);
        $price_receipt = $row_receipt['price'];
        $id_receipt = $row_receipt['receipt_id'];

        $data = [["id_receipt" => $id_receipt, "subtotal" => $price_receipt]];
        $select_receipt_detail = mysqli_query($con, "SELECT `receipt_detail`.`quantity`, `receipt_detail`.`price`, `receipt_detail`.`menu_id`
                                                        FROM `payment` 
                                                        inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                                        inner join `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`  
                                                        inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                                        WHERE `receipt_detail`.`receipt_id` = '$id_receipt' 
                                                        and `receipts`.`status` = 'cart'
                                                        and `payment`.`employee_id` = '$id_user'");
        if (mysqli_num_rows($select_receipt_detail) > 0) {
            while ($row_receipt_detail = mysqli_fetch_assoc($select_receipt_detail)) {
                $data_menu = [];
                $id_menu = $row_receipt_detail['menu_id'];
                $select_menu_list = mysqli_query($con, "SELECT `menu_list`.`dish_id`, `dishes`.`image`, `dishes`.`name`
                                                            FROM `menu_list`
                                                            inner join `dishes` on `menu_list`.`dish_id` = `dishes`.`dish_id`
                                                            WHERE `menu_list`.`menu_id` = $id_menu");
                while ($row_menu_list = mysqli_fetch_assoc($select_menu_list)) {
                    array_push($data_menu, $row_menu_list);
                }
                $row_receipt_detail['menu_list'] = $data_menu;
                array_push($data, $row_receipt_detail);
            }
        } else {
            $data = ["message" => "Không có đơn hàng"];
        }
    } else {
        $data = ["message" => "Không có đơn hàng"];
    }
} elseif (
    isset($_POST['quantity']) && $_POST['quantity'] !== ''
    && isset($_POST['menu_id']) && $_POST['menu_id'] !== ''
    && isset($_POST['id_receipt']) && $_POST['id_receipt'] !== ''
) {
    $quantity_menu = $_POST['quantity'];
    $menu_id = $_POST['menu_id'];
    $id_receipt = $_POST['id_receipt'];
    $select_menu = mysqli_query($con, "SELECT `menu`.`price` FROM 
                                                `receipt_detail` inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id` 
                                                WHERE `menu`.`menu_id` = $menu_id and `receipt_detail`.`receipt_id` = '$id_receipt'");
    $row_menu = mysqli_fetch_assoc($select_menu);
    $price_menu = $row_menu['price'];
    $total_menuid = $quantity_menu * $price_menu;
    $update_receipt_detail = mysqli_query($con, "UPDATE `receipt_detail` SET `quantity` = $quantity_menu, `price` = $total_menuid WHERE `menu_id` = $menu_id and `receipt_id` = '$id_receipt' ");
    if ($update_receipt_detail === true) {
        $sum = 0;
        $select_receipts = mysqli_query($con, "SELECT * FROM `receipt_detail` WHERE `receipt_id` = '$id_receipt'");
        while ($row_receipts = mysqli_fetch_assoc($select_receipts)) {
            $sum += $row_receipts['price'];
            mysqli_query($con, "UPDATE `receipts` SET `price` = $sum WHERE `receipt_id` = '$id_receipt' ");
        }
        $data = ["success" => "ok", "price" => $total_menuid, "quantity" => $quantity_menu, "menu_id" => $menu_id, "receipt_id" => $id_receipt, "subtotal" => $sum];
    } else {
        $data = ["message" => "Cập nhật thất bại"];
    }
} elseif (
    isset($_POST['id_delete']) && $_POST['id_delete'] !== ''
    && isset($_POST['id_receipt']) && $_POST['id_receipt'] !== ''
) {
    $delete_menu = $_POST['id_delete'];
    $id_receipt = $_POST['id_receipt'];
    if (mysqli_query($con, "DELETE FROM `receipt_detail` WHERE `receipt_id` = '$id_receipt' and `menu_id` = $delete_menu") === true) {
        $select_receipts = mysqli_query($con, "SELECT * FROM `receipt_detail` WHERE `receipt_id` = '$id_receipt'");
        if (mysqli_num_rows($select_receipts) > 0) {
            $sum = 0;
            while ($row_receipts = mysqli_fetch_assoc($select_receipts)) {
                $sum += $row_receipts['price'];
                mysqli_query($con, "UPDATE `receipts` SET `price` = $sum WHERE `receipt_id` = '$id_receipt'");
            }
        } else {
            mysqli_query($con, "DELETE FROM `receipts` WHERE `receipt_id` = '$id_receipt'");
        }
    }
} elseif (
    isset($_POST['checkout_receipt']) && $_POST['checkout_receipt'] !== ''
    && isset($_POST['yearMonth']) && $_POST['yearMonth'] !== ''
    && isset($_POST['idUser']) && $_POST['idUser'] !== ''
) {
    //idUser
    $idUser = $_POST['idUser'];
    $checkout_receipt = $_POST['checkout_receipt'];
    $note = ($_POST['note'] !== '') ? addslashes($_POST['note']) : '';
    $yearMonth = addslashes($_POST['yearMonth']);


    if (mysqli_query($con, "UPDATE `receipts` SET `note` = '$note',`status` = 'confirming' WHERE `receipt_id` = '$checkout_receipt'") === true) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $updateDateRecetipt = date('H:i:s');
        mysqli_query($con, "UPDATE `receipt_detail` SET `created_time` = '$updateDateRecetipt' WHERE `receipt_id` = '$checkout_receipt'");
        $select_receipt = mysqli_query($con, "SELECT `receipts`.`price`,`payment`.`id` 
                                                FROM `receipts` INNER JOIN `payment` on `payment`.`id` = `receipts`.`payment_id`
                                                WHERE `payment`.`employee_id` = '$idUser' and DATE_FORMAT(`receipts`.`created_time`, '%Y-%m') = '$yearMonth' and `receipts`.`status` != 'cart' ");
        if (mysqli_num_rows($select_receipt) > 0) {
            $sum_receipts = 0;
            $id_payment = 0;
            while ($row_receipt = mysqli_fetch_assoc($select_receipt)) {
                $sum_receipts += $row_receipt['price'];
                $id_payment = $row_receipt['id'];
            }
            if (mysqli_query($con, "UPDATE `payment` SET `total` = $sum_receipts 
                                    WHERE `id` = $id_payment 
                                    and `employee_id` = '$idUser' 
                                    and DATE_FORMAT(`created_time`, '%Y-%m') = '$yearMonth'") === true) {

                $data = ["success" => "ok", "message" => "Đã đặt hàng thành công"];
                setcookie("receipt", $checkout_receipt, time() + 3600, "/");

                $select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$idUser' and `roles` = 'employee'");
                $row_user = mysqli_fetch_assoc($select_user);
                $select_receipt_table = mysqli_query($con, "SELECT * FROM `receipts` WHERE `receipt_id` = '$checkout_receipt' and `status` = 'confirming'");
                $row_receipt_table = mysqli_fetch_assoc($select_receipt_table);
                //  Gửi hóa đơn qua imail
                //     $html = '<table border="1" cellpadding="5" cellspacing="0">
                //     <tr>
                //       <th align="left">Dish Name</th>
                //       <th align="center">Quantity</th>
                //       <th align="right">Price</th>
                //     </tr>
                //     <tr>
                //       <td>Appetizer</td>
                //       <td align="center">2</td>
                //       <td align="right">$15.00</td>
                //     </tr>
                //     <tr>
                //       <td>Entree</td>
                //       <td align="center">1</td>
                //       <td align="right">25.00</td>
                //     </tr>
                //     <tr>
                //       <td>Side Dish</td>
                //       <td align="center">3</td>
                //       <td align="right">$10.00</td>
                //     </tr>
                //     <tr>
                //       <td>Dessert</td>
                //       <td align="center">1</td>
                //       <td align="right">$8.00</td>
                //     </tr>
                //     <tr>
                //       <td colspan="2" align="right">Total:</td>
                //       <td align="right">$68.00</td>
                //     </tr>
                //   </table>';
                // $date = date();
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $date = date("Y-m-d h:i");
                // $total = 
                $html = '<table border="0" cellpadding="0" cellspacing="0" width="50%" class="d-flex">
                            <tr>
                                <th colspan="2" align="left" bgcolor="#00A4BD"><font size="2" face="Arial, sans-serif">Thông tin đơn hàng</font></th>
                            </tr>
                            
                            
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Tên nhân viên:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $row_user['full_name'] . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Mã nhân viên:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $idUser . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Số điện thoại:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $row_user['number'] . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Email:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $row_user['email'] . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Mã đơn hàng:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $checkout_receipt . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Ngày đặt:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $date . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Ngày nhận:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . $row_receipt_table['created_time'] . '</font></td>
                            </tr>
                            <tr>
                                <td width="30%" align="left" valign="top" bgcolor="#F7F7F7"><font size="1" face="Arial, sans-serif">Tổng tiền:</font></td>
                                <td width="70%" align="left" valign="top" bgcolor="#FFFFFF"><font size="1" face="Arial, sans-serif">' . number_format($row_receipt_table['price']) . ' VNĐ</font></td>
                            </tr>
                        </table>

                        <p style="font-size:20px; margin-top:15px;">Chi tiết đơn hàng:</p>
                        <table border="1" cellpadding="5" cellspacing="0" width="50%">
                            <tr>
                                <th align="left">Tên Món</th>
                                <th align="center">Số Lượng</th>
                                <th align="right">Giá món</th>
                                <th align="right">Tổng tiền</th>
                            </tr>
                            ';
                $select_receipt_detail = mysqli_query($con, "SELECT `receipt_detail`.`quantity`,`receipt_detail`.`price`, `receipt_detail`.`menu_id`,`menu`.`price` as `menu_price`
                                                                                FROM `payment` 
                                                                                inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                                                                inner join `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`  
                                                                                inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                                                                WHERE `receipt_detail`.`receipt_id` = '$checkout_receipt'
                                                                                and `receipts`.`status` = 'confirming'
                                                                                and `payment`.`employee_id` = '$idUser'");
                while ($row_receipt_detail = mysqli_fetch_assoc($select_receipt_detail)) {
                    $data_dish = [];

                    $menu_id = $row_receipt_detail['menu_id'];
                    $quantity = $row_receipt_detail['quantity'];
                    $initial_price = $row_receipt_detail['menu_price'];
                    $price = $row_receipt_detail['price'];
                    $select_menu = mysqli_query($con, "SELECT `menu_list`.`dish_id`,`dishes`.`name`
                                                                    FROM `menu`
                                                                    inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                                                    inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                                                    WHERE `menu_list`.`menu_id` = $menu_id and `dishes`.`is_approved` = true and `dishes`.`remove` = false");
                    while ($row_menu = mysqli_fetch_assoc($select_menu)) {
                        array_push($data_dish, $row_menu['name']);
                    }
                    $name = implode("<br>", $data_dish);
                    $html .=    '<tr>
                                    <td>'.$name.'</td>
                                    <td align="center">'.$quantity.'</td>
                                    <td align="right">'.$initial_price.'</td>
                                    <td align="right">'.$price.'</td>
                                </tr>';
                }
                $html .= '</table>';
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;

                $mail->Username = "hothinh9234@gmail.com";
                $mail->Password = "shqhoxdpctdmfiwa";
                $mail->SMTPSecure = 'tls';

                $mail->Port = 587;

                $mail->setFrom("hothinh9234@gmail.com");
                $mail->addAddress($row_user['email']);

                $mail->isHTML(true);

                $mail->Subject = "Order Information";
                // $mail->Body = "mã code : $otp";
                $mail->Body = $html;
                try {
                    $mail->send();
                    // $data_forget = ["status" => "success", "userId" => $row["employee_id"], "email_user" => $_POST['check']];
                } catch (Exception $e) {
                    // $data_forget = ["e" => $mail->ErrorInfo, "status" => "fail"];
                }
            }
        }
    }
}
echo json_encode($data, true);
