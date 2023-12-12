<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if(isset($_POST['receipt_id']) && $_POST['receipt_id'] !==""){
    $receipt_id =  $_POST['receipt_id'];
    if(mysqli_query($con,"UPDATE `receipts` SET `status`='shipped' WHERE `receipt_id`='$receipt_id'") === true){
        $data = ["success" =>"ok"];
    }else{
        $data = ["fail" => "ok't"];
    }
}else{
    $data = ["error" => "lỗi"];

}
echo json_encode($data,true);