<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
// $id = $_SESSION['employee_manager_id'];

// Hàm xóa món
function deleteMenu($con, $id) {
    $sql = "DELETE FROM menu_list WHERE id='$id'";
    if ($con->query($sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $sql . "<br>" . $con->error;
    }
}

// lấy giá trị id để xóa
$id = $_GET['id'];

// Chức năng xóa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteResult = deleteMenu($con, $id);

    if ($deleteResult === true) {
        header("Location: index.php");
        exit();
    } else {
        echo "Delete Failed: " . $deleteResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Thực Đơn</title>
    <style>
        form {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2 {
            text-align: center;
        }

        input[type="submit"] {
            background-color: #ff0000;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Xóa Thực Đơn</h1>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?= $id ?>">
        
        <h2 align="center">Bạn có chắc muốn xóa thực đơn này?</h2>

        <input type="submit" name="delete" value="Xóa">
    </form>
</body>
</html>
