<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data = [];
if (
    isset($_POST['idMenu']) && $_POST['idMenu'] !== ''
    && isset($_POST['idUser']) && $_POST['idUser'] !== ''
    && isset($_POST['yearMonth']) && $_POST['yearMonth'] !== ''
    && isset($_POST['day']) && $_POST['day'] !== ''
) {
    // lát so sánh ngày trong bảng menu
    $id_menu = $_POST['idMenu'];
    $id_user = $_POST['idUser'];
    $payment_yearMonth = $_POST['yearMonth'];
    $receipt_day = $_POST['day'];
    // select id của dish
    $select_menu = mysqli_query($con, "SELECT * FROM `menu` WHERE `menu_id` = $id_menu and `date` = '$receipt_day'");
    if (mysqli_num_rows($select_menu) > 0) {
        $row_menu = mysqli_fetch_assoc($select_menu);
        $price_menu = $row_menu['price'];

        // select payment
        $select_payment = mysqli_query($con, "SELECT * FROM `payment` WHERE `employee_id` = '$id_user' and DATE_FORMAT(`created_time`, '%Y-%m') = '$payment_yearMonth'");
        if (mysqli_num_rows($select_payment) > 0) {
            $row_payment = mysqli_fetch_assoc($select_payment);
            $id_payment = $row_payment['id'];
            $select_receipt = mysqli_query($con, "SELECT * FROM `receipts` WHERE `payment_id` = $id_payment and `created_time` = '$receipt_day' and `status` = 'cart'");
            // id đơn hàng mới & so sánh csdl của dishes detail
            if (mysqli_num_rows($select_receipt) > 0) {
                $row_receipt = mysqli_fetch_assoc($select_receipt);
                $id_receipt = $row_receipt['receipt_id'];
                $sum_receipt = 0; // để update số lượng
                $select_dishDetail = mysqli_query($con, "SELECT * FROM `receipt_detail` WHERE `receipt_id` = '$id_receipt' and `menu_id` = $id_menu");
                if (mysqli_num_rows($select_dishDetail) > 0) {
                    $row_detail = mysqli_fetch_assoc($select_dishDetail);
                    $id_detail = $row_detail['id'];
                    $quantity_detail = $row_detail['quantity'] + 1;
                    $price_detail = $price_menu * $quantity_detail;
                    $upate_quantity = mysqli_query($con, "UPDATE `receipt_detail` SET `quantity`= $quantity_detail,`price`= $price_detail WHERE `id`= $id_detail");
                    if ($upate_quantity === true) {
                        $select2_receiptDetail = mysqli_query($con, "SELECT * FROM `receipt_detail` WHERE `receipt_id` = '$id_receipt'");
                        while ($row_sum_receipt = mysqli_fetch_assoc($select2_receiptDetail)) {
                            $sum_receipt += $row_sum_receipt['price'];
                            mysqli_query($con, "UPDATE `receipts` SET `price` = $sum_receipt WHERE `payment_id` = $id_payment and `created_time` = '$receipt_day' and `status`='cart'");
                        }
                        $data = ["message" => "Thêm giỏ hàng thành công"];
                    }
                    // update receipts


                } else {
                    $insert_detail = mysqli_query($con, "INSERT INTO `receipt_detail`(`receipt_id`, `menu_id`, `quantity`, `price`) VALUES ('$id_receipt',$id_menu,1,$price_menu)");
                    if ($insert_detail === true) {
                        $select2_receiptDetail = mysqli_query($con, "SELECT * FROM `receipt_detail` WHERE `receipt_id` = '$id_receipt'");
                        while ($row_sum_receipt = mysqli_fetch_assoc($select2_receiptDetail)) {
                            $sum_receipt += $row_sum_receipt['price'];
                            mysqli_query($con, "UPDATE `receipts` SET `price` = $sum_receipt WHERE `payment_id` = $id_payment and `created_time` = '$receipt_day' and `status`='cart'");
                        }
                        $data = ["message" => "Thêm giỏ hàng thành công"];
                    }
                }
            } else {
                $id_receiptTable = 'HD' . rand(100000, 999999);
                if (mysqli_query($con, "INSERT INTO `receipts`(`receipt_id`, `payment_id`, `price`, `status`,`created_time`) VALUES ('$id_receiptTable',$id_payment,$price_menu,'cart','$receipt_day')") === true) {
                    // insert vào id của receipts đã tạo trước đó vào bảng này
                    mysqli_query($con, "INSERT INTO `receipt_detail`(`receipt_id`, `menu_id`, `quantity`, `price`) VALUES ('$id_receiptTable',$id_menu,1,$price_menu)");
                    $data = ["message" => "thành công"];
                }
            }
        } else {
            // insert dữ liệu id người dùng vào payment nếu đã sang tháng mới

            if (mysqli_query($con, "INSERT INTO `payment`(`employee_id`,`status`, `total`,`created_time`) VALUES ('$id_user',false,0,'$receipt_day')") === true) {
                $select2_payment = mysqli_query($con, "SELECT * FROM `payment` WHERE `employee_id` = '$id_user' and DATE_FORMAT(`created_time`, '%Y-%m') = '$payment_yearMonth'");
                $row2_payment = mysqli_fetch_assoc($select2_payment);
                $id2_payment = $row2_payment['id'];
                $id2_receiptTable = 'HD' . rand(100000, 999999);
                if (mysqli_query($con, "INSERT INTO `receipts`(`receipt_id`, `payment_id`, `price`, `status`,`created_time`) VALUES ('$id2_receiptTable',$id2_payment,$price_menu,'cart','$receipt_day')") === true) {
                    // insert vào id của receipts đã tạo trước đó vào bảng này
                    mysqli_query($con, "INSERT INTO `receipt_detail`(`receipt_id`, `menu_id`, `quantity`, `price`) VALUES ('$id2_receiptTable',$id_menu,1,$price_menu)");
                    $data = ["message" => "thành công"];
                }
            }
        }
    }else {
        $data = ["error" => "không thấy dữ liệu"];
    }
} else {
    $data = ["error" => "không thấy dữ liệu"];
}
echo json_encode($data, true);
