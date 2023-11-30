<?php
session_start();
include "../../connect/connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST["name"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];

    $updateSql = "UPDATE resources SET name = '$name', unit = '$unit', price = $price WHERE id = $id";

    if (mysqli_query($con, $updateSql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Cập nhật nguyên liệu thành công';
    } else {
        $_SESSION['status'] = 'failure';
        $_SESSION['message'] = 'Cập nhật nguyên liệu không thành công';
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
