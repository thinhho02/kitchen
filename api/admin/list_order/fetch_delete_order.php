<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if(isset($_POST['receipt_id']) && $_POST['receipt_id'] !== ''){
    $receipt_id = $_POST['receipt_id'];
    mysqli_query($con,"DELETE FROM `receipts` WHERE `receipt_id` = '$receipt_id'");
    $data = ["success" => "ok"];
}
else{
    $data = ["error" => "lỗi"];
}
echo json_encode($data,true);