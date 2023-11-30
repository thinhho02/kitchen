<?php
session_start();
include '../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "UPDATE dishes SET remove = '1' WHERE dish_id = '$id'";
    echo $sql;
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Xóa nguyên liệu thành công!' : 'Đã có lỗi xảy ra. Xóa nguyên liệu không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}");
}