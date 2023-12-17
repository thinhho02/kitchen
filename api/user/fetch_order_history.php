<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data = [];
if (isset($_POST['user_id']) && $_POST['user_id'] !== '') {
    $user_id = $_POST['user_id'];
    $select_receipt = mysqli_query($con, "SELECT `total` FROM `payment` WHERE `employee_id` = '$user_id' and  `status` = false ");
    if (mysqli_num_rows($select_receipt) > 0) {
        $sum = 0;
        while ($row_receipt = mysqli_fetch_assoc($select_receipt)) {
            $sum += $row_receipt['total'];
        }
        mysqli_query($con, "UPDATE `employees` SET `debt`= $sum WHERE `employee_id` = '$user_id'");
    }
    $select_pay = mysqli_query($con, "SELECT `id`,`employee_id`,`status`,`total`,DATE_FORMAT(`created_time`,'%Y/%m') as `date` FROM `payment` WHERE `employee_id` = '$user_id' order by `created_time` desc");
    if (mysqli_num_rows($select_pay) > 0) {
        while ($row_pay = mysqli_fetch_assoc($select_pay)) {
            $data_receipt = [];
            $pay_id = $row_pay['id'];
            $select_receipt = mysqli_query($con, "SELECT `receipt_id`,`price`,`note`,`status`,`created_time` FROM `receipts` WHERE `payment_id` = $pay_id and `status` != 'cart' order by `created_time` desc ");
            while ($row_receipt = mysqli_fetch_assoc($select_receipt)) {
                array_push($data_receipt, $row_receipt);
            }
            $row_pay['receipts'] = $data_receipt;
            array_push($data, $row_pay);
        }
    }else{
        $data = ["message" => "Chưa có đơn hàng"];
    }
}
// delete order
elseif (isset($_POST['delete_id']) && $_POST['delete_id'] !== '') {
    $delete_id = $_POST['delete_id'];
    $select_pay = mysqli_query($con, "SELECT `payment`.`id` FROM `payment` INNER JOIN `receipts` on `payment`.`id` = `receipts`.`payment_id` WHERE `receipt_id` = '$delete_id'");
    $row_pay = mysqli_fetch_assoc($select_pay);
    $pay_id = $row_pay['id'];
    $data = ["pay_id" => $pay_id];
    if (mysqli_query($con, "DELETE FROM `receipts` WHERE `receipt_id` = '$delete_id'") === true) {
        $sum = 0;
        $select_receipt = mysqli_query($con, "SELECT `receipts`.`price` FROM `payment` INNER JOIN `receipts` on `payment`.`id` = `receipts`.`payment_id` Where `payment`.`id` =  $pay_id and `receipts`.`status` != 'cart'");
        if (mysqli_num_rows($select_receipt) > 0) {
            while ($row_receipt = mysqli_fetch_assoc($select_receipt)) {
                $sum += $row_receipt['price'];
                mysqli_query($con, "UPDATE `payment` SET `total`= $sum WHERE `id` = $pay_id");
            }
        } else {
            mysqli_query($con, "UPDATE `payment` SET `total`= $sum WHERE `id` = $pay_id");
        }
    }
}
// modal order
elseif (isset($_POST['receipt_id']) && $_POST['receipt_id'] !== '') {
    $receipt_id = $_POST['receipt_id'];
    $select_receipt = mysqli_query($con, "SELECT * FROM `receipts` WHERE `receipt_id` = '$receipt_id'");
    if (mysqli_num_rows($select_receipt) > 0) {
        $row = mysqli_fetch_assoc($select_receipt);

        // lấy giá trị của chi tiết món ăn

        $select_receipt_detail = mysqli_query($con, "SELECT `receipt_detail`.`quantity`,`receipt_detail`.`price`, `receipt_detail`.`menu_id`,`menu`.`price` as `menu_price`
                                            FROM `receipts` 
                                            inner join `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`  
                                            inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                            WHERE `receipt_detail`.`receipt_id` = '$receipt_id'");
        if (mysqli_num_rows($select_receipt_detail) > 0) {
            while ($row_receipt = mysqli_fetch_assoc($select_receipt_detail)) {
                $data_menu = [];
                $menu_id = $row_receipt['menu_id'];
                $select_menu = mysqli_query($con, "SELECT `menu_list`.`dish_id`,`dishes`.`name`
                                                    FROM `menu`
                                                    inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                                    inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                                    WHERE `menu_list`.`menu_id` = $menu_id and `dishes`.`is_approved` = true and `dishes`.`remove` = false");

                while ($row_menu = mysqli_fetch_assoc($select_menu)) {
                    array_push($data_menu, $row_menu);
                }
                $row_receipt['menu_list'] = $data_menu;
                array_push($data, $row_receipt);
            }
        }
    }
}
echo json_encode($data, true);
