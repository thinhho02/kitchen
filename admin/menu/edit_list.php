<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
// $id = $_SESSION['employee_manager_id'];

// Hàm chỉnh sửa
function editMenu($con, $id, $name, $list_describe, $menu_id, $dish_id) {
    $sql = "UPDATE menu_list SET name='$name', list_describe='$list_describe', menu_id='$menu_id', dish_id='$dish_id' WHERE id='$id'";
    
    if ($con->query($sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $sql . "<br>" . $con->error;
    }
}

$id = $_GET['id'];
$result = $con->query("SELECT * FROM menu_list WHERE id='$id'");
$item = $result->fetch_assoc();

// Chức năng chỉnh sửa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $list_describe = $_POST['list_describe'];
    $menu_id = $_POST['menu_id'];
    $dish_id = $_POST['dish_id'];

    $editResult = editMenu($con, $id, $name, $list_describe, $menu_id, $dish_id);

    if ($editResult === true) {
        header("Location: index.php");
        exit();
    } else {
        echo "Edit Failed: " . $editResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Thực Đơn</title>
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

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
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
    <h1>Chỉnh Sửa Thực Đơn</h1>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?= $item['id'] ?>">
        
        <label for="name">Tên Thực Đơn:</label>
        <input type="text" id="name" name="name" value="<?= $item['name'] ?>" required>

        <label for="list_describe">Mô tả:</label>
        <input type="text" id="list_describe" name="list_describe" value="<?= $item['list_describe'] ?>" required>

        <label for="menu_id"></label>
        <input type="hidden" id="menu_id" name="menu_id" value="<?= $item['menu_id'] ?>" required>

        <label for="dish_id"></label>
        <input type="hidden" id="dish_id" name="dish_id" value="<?= $item['dish_id'] ?>" required>

        <input type="submit" name="edit" value="Lưu Chỉnh Sửa">
    </form>
</body>
</html>
