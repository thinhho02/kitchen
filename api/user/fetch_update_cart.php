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
    // Xóa đơn hàng khi quá ngày thêm giỏ hàng
    $current_date = $_POST['currentDate'];
    $delete = mysqli_query($con, "DELETE FROM `receipts` WHERE `created_time` = '$current_date' and `status` = 'cart'");


    $select_receipt = mysqli_query($con, "SELECT `payment`.`employee_id`,`receipts`.`receipt_id`,`receipts`.`price` 
                                            FROM `payment` inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                            Where `receipts`.`status` = 'cart' 
                                            and `receipts`.`created_time` = '$date'
                                            and `payment`.`employee_id` = '$id_user'");
    if (mysqli_num_rows($select_receipt) > 0) {
        $row_receipt = mysqli_fetch_assoc($select_receipt);
        $price_receipt = $row_receipt['price'];
        $id_receipt = $row_receipt['receipt_id'];

        $data = [["id_receipt" => $id_receipt, "subtotal" => $price_receipt]];
        $select_receipt_detail = mysqli_query($con, "SELECT `receipt_detail`.`quantity`, `receipt_detail`.`price`, `receipt_detail`.`menu_id`, `dishes`.`image`,`dishes`.`name`  
                                                        FROM `payment` inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                                        inner join `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`  
                                                        inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                                        inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                                        inner join `dishes` on `menu_list`.`dish_id` = `dishes`.`dish_id`
                                                        WHERE `receipt_detail`.`receipt_id` = '$id_receipt' 
                                                        and `receipts`.`status` = 'cart'
                                                        and `payment`.`employee_id` = '$id_user'");
        if (mysqli_num_rows($select_receipt_detail) > 0) {
            while ($row_receipt_detail = mysqli_fetch_assoc($select_receipt_detail)) {
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
} elseif (isset($_POST['checkout_receipt']) && $_POST['checkout_receipt'] !== '') {
    $checkout_receipt = $_POST['checkout_receipt'];
    if(isset($_POST['note']) && $_POST['note'] !== ''){
        $note = $_POST['note'];
        mysqli_query($con, "UPDATE `receipts` SET `note` = '$note',`status` = 'confirming' WHERE `receipt_id` = '$checkout_receipt'");
    }else{
        mysqli_query($con, "UPDATE `receipts` SET `status` = 'confirming' WHERE `receipt_id` = '$checkout_receipt'");
    }
    $data = ["success" => "ok"];
    
}
echo json_encode($data, true);
