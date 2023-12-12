<?php
session_start();
include '../../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM dish_detail WHERE id = '$id'";
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Xóa nguyên liệu thành công!' : 'Đã có lỗi xảy ra. Xóa nguyên liệu không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}#resource-table");
}