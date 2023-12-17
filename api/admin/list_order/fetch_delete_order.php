<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if (isset($_POST['receipt_id']) && $_POST['receipt_id'] !== '') {
    $receipt_id = $_POST['receipt_id'];
    $select_paymentId = mysqli_query($con, "SELECT `payment_id` FROM `receipts` WHERE `receipt_id` = '$receipt_id'");
    $row_payment = mysqli_fetch_assoc($select_paymentId);
    $payment_id = $row_payment['payment_id'];
    if (mysqli_query($con, "DELETE FROM `receipts` WHERE `receipt_id` = '$receipt_id'") === true) {
        $select_receipts = mysqli_query($con, "SELECT SUM(`price`) as `price` FROM `receipts` WHERE `payment_id` = $payment_id");
        $row_receipts = mysqli_fetch_assoc($select_receipts);
        if ($row_receipts['price'] != NULL) {
            $total_payment = $row_receipts['price'];
            mysqli_query($con, "UPDATE `payment` SET `total` = $total_payment WHERE `id` = $payment_id");
        } else {
            mysqli_query($con, "UPDATE `payment` SET `total` = 0 WHERE `id` = $payment_id");
        }
        $data = ["success" => "ok"];
    }
} else {
    $data = ["error" => "lỗi"];
}
echo json_encode($data, true);
