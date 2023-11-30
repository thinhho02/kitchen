<?php
session_start();
include '../../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dishId = $_POST['dish_id'];
    $resourceId = $_POST['resource_id'];
    $quantity = $_POST['quantity'];
    $sql = "INSERT INTO dish_detail(id, dish_id, resource_id, quantity) VALUES (NULL,'$dishId','$resourceId','$quantity')";
    echo $sql;
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Thêm nguyên liệu thành công!' : 'Đã có lỗi xảy ra. Thêm nguyên liệu không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}#resource-table");
}
