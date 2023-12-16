<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data = [];
if (isset($_REQUEST['id']) && isset($_POST['statusUser']) && $_REQUEST['id'] !== '') {
    $id = $_REQUEST['id'];
    $status = $_POST['statusUser'];
    // Xóa đơn hàng khi quá ngày thêm giỏ hàng
    $current_date = $_POST['currentDate'];
    $delete = mysqli_query($con, "DELETE FROM `receipts` WHERE `created_time` <= '$current_date' and `status` = 'cart'");

    if (mysqli_query($con, "UPDATE `employees` set `status` = $status WHERE `employee_id` = '$id'") === true) {
        $data = ["active" => $status, "userId" => "$id"];
    } else {
        $data = ["message" => "Kết nối thất bại"];
        session_destroy();
    }
    //cập nhật đơn hàng khi qua 24h
    $update_receipt = mysqli_query($con, "UPDATE `receipts` SET `status`='confirmed' WHERE `created_time` <= '$current_date' and `status` = 'confirming'");

    $select_receipt = mysqli_query($con, "SELECT `total` FROM `payment` WHERE `employee_id` = '$id' and  `status` = false ");
    if (mysqli_num_rows($select_receipt) > 0) {
        $sum = 0;
        while ($row_receipt = mysqli_fetch_assoc($select_receipt)) {
            $sum += $row_receipt['total'];
        }
        mysqli_query($con, "UPDATE `employees` SET `debt`= $sum WHERE `employee_id` = '$id'");
    }
}
echo json_encode($data, true);
