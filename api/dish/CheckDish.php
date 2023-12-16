<?php
session_start();
include '../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "UPDATE dishes SET is_approved = '1' WHERE dish_id = '$id'";
    echo $sql;
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Xác nhận món thành công!' : 'Đã có lỗi xảy ra. Xác nhận món không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}");
}