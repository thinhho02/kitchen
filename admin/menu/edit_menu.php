<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

// kiểm tra xem id 
if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];
    $result = $con->query("SELECT * FROM menu WHERE menu_id='$menu_id'");
    $item = $result->fetch_assoc();
} else {
    echo "ID không hợp lệ!";
    exit();
}
// Sửa món
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $status = $_POST['status'];
    $price = $_POST['price'];
    $date = $_POST['date'];

    $sql = "UPDATE menu SET status='$status', price='$price', date='$date' WHERE menu_id='$menu_id'";

    if ($con->query($sql) === TRUE) {
        header("Location: add_menu.php");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Món</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        h1 {
            text-align: center; 
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <form method="post" action="">
    <h1>Sửa Món</h1>
        <label for="status">Tên Món:</label>
        <input type="text" id="status" name="status" value="<?= $item['status'] ?>" required>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" value="<?= $item['price'] ?>" required>

        <label for="date">Ngày Tạo:</label>
        <input type="date" id="date" name="date" value="<?= $item['date'] ?>" required>

        <input type="submit" name="edit" value="Lưu">
    </form>
</body>
</html>

