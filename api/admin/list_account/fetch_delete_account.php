<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if(isset($_POST['employee_id']) && $_POST['employee_id'] !== ''){
    $employee_id = $_POST['employee_id'];
    mysqli_query($con,"DELETE FROM `employees` WHERE `employee_id` = '$employee_id'");
    $data = ["success" => "ok"];
}
else{
    $data = ["error" => "lỗi"];
}
echo json_encode($data,true);