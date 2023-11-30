<?php
session_start();
include '../../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $sql = "UPDATE dish_detail SET quantity='$quantity' WHERE id = '$id'";
    echo $sql;
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Cập nhật số lượng thành công!' : 'Đã có lỗi xảy ra. Cập nhật số lượng không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}#resource-table");
}