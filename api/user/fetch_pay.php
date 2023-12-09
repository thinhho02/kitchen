<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data = [];

if (
    isset($_POST['current_date']) && $_POST['current_date'] !== ''
    && isset($_POST['user_id']) && $_POST['user_id'] !== ''
) {
    $user_id = $_POST['user_id'];
    $select_user = mysqli_query($con, "SELECT * FROM `employees` WHERE `employee_id` = '$user_id' and `roles` = 'employee'");
    if (mysqli_num_rows($select_user) > 0) {
        $current_date = $_POST['current_date'];
        $date = date_create($current_date);
        $date_format = date_format($date, 'Y-m');
        $select_pay = mysqli_query($con, "SELECT `id`,`employee_id`,`status`,`total`,DATE_FORMAT(`created_time`,'%m/%Y') as `date` FROM `payment` WHERE `employee_id` = '$user_id' and DATE_FORMAT(`created_time`,'%Y-%m') < '$date_format' and `status` = false ");
        if (mysqli_num_rows($select_pay) > 0) {
            while ($row_pay = mysqli_fetch_assoc($select_pay)) {
                array_push($data, $row_pay);
            }
        } else {
            $data = ["message" => "Đã thanh toán đầy đủ"];
        }
    }
}
echo json_encode($data, true);
