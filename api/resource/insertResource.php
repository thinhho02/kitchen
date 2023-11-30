<?php
session_start();
include '../../connect/connect.php';
$name = $_POST['name'];
$unit = $_POST['unit'];
$price = $_POST['price'];

$sql = "INSERT INTO resources (id, name, unit, price) VALUES (NULL, '$name', '$unit', '$price')";
$success = mysqli_query($con, $sql);
mysqli_close($con);

$_SESSION['status'] = $success ? 'success' : 'failure';
$_SESSION['message'] = $success ? 'Thêm nguyên vật liệu thành công!' : 'Thêm nguyên vật liệu không thành công!';

header("Location: {$_SERVER['HTTP_REFERER']}");
?>

