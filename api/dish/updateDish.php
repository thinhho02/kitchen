<?php
session_start();
include '../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category_id'];
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $sql = "UPDATE dishes SET category_id='$category',name='$name', description='$description',price='$price',is_approved='1',updated_time=current_timestamp() WHERE dish_id = '$id'";
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Cập nhật món ăn thành công!' : 'Đã có lỗi xảy ra. Cập nhật món ăn không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}");
}