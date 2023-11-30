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
    }
    // $status = $_POST['statusUser'];
    // $data = ["status" => $status];

}
echo json_encode($data, true);

// echo $id;
// $select = mysqli_query($con, "SELECT *, CONCAT(`first_name`, ' ', `last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
// $row = mysqli_fetch_assoc($select);
// // echo var_dump($row);
