<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
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
                while($row_menu_list = mysqli_fetch_assoc($select_menu_list)){
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


    if(mysqli_query($con, "UPDATE `receipts` SET `note` = '$note',`status` = 'confirming' WHERE `receipt_id` = '$checkout_receipt'") === true){
        $select_receipt = mysqli_query($con,"SELECT * 
                                                FROM `receipts` 
                                                WHERE `status` = 'confirming'
                                                and DATE_FORMAT(`created_time`, '%Y-%m') = '$yearMonth' ");
        if(mysqli_num_rows($select_receipt)>0){
            $sum_receipts = 0;
            $id_payment = 0;
            while($row_receipt = mysqli_fetch_assoc($select_receipt)){
                $sum_receipts += $row_receipt['price'];
                $id_payment = $row_receipt['payment_id'];
            }
            if(mysqli_query($con,"UPDATE `payment` SET `total` = $sum_receipts 
                                    WHERE `id` = $id_payment 
                                    and `employee_id` = '$idUser' 
                                    and DATE_FORMAT(`created_time`, '%Y-%m') = '$yearMonth'") === true){

                $data = ["success" => "ok", "message" => "Đã đặt hàng thành công"];
                setcookie("receipt",$checkout_receipt,time() + 3600,"/");
            }
        } 

    }
}
echo json_encode($data, true);
