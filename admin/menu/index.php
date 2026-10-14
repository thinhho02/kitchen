<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];
$result = $con->query("SELECT * FROM menu_list");

// Chức năng thêm món
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $list_describe = $_POST['list_describe'];
    $menu_id = $_POST['menu_id'];
    $dish_id = $_POST['dish_id'];

    $sql = "INSERT INTO menu_list (name, list_describe, menu_id, dish_id) VALUES ('$name', '$list_describe', '$menu_id', '$dish_id')";
    
    if ($con->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
     }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Thực Đơn</title>
    <style>
        #dish_id,#menu_id {
        width: 50px; 
        height: 30px; 
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
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
        #form-container {
            display: none;
            margin-top: 20px;
        }
        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            animation: fadeIn 0.5s ease-in-out;

            margin-left: 150px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        #form-container {
            display: none;
            margin-top: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <h2>QUẢN LÍ THỰC ĐƠN </h2>
        
    <div class="menu-container">
        <h3 align="center">Danh Sách Thực Đơn</h3>
        <button onclick="toggleForm()">Thêm thủ công</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên Thực Đơn</th>
                <th>Mô tả</th>
                <!-- <th></th>
                <th></th> -->
                <Th></Th>
                <th></th>
                <th></th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['list_describe'] ?></td>
                    <!-- <td><?= $row['menu_id'] ?></td>
                    <td><?= $row['dish_id'] ?></td> -->
                    <td><a href="add_menu.php?id=<?= $row['menu_id'] ?>">Xem</a></td>
                    <td><a href="edit_list.php?id=<?= $row['menu_id'] ?>">Chỉnh sửa</a></td>
                    <td><a href="del_list.php?id=<?= $row['menu_id'] ?>">Xóa</a></td>
                </tr>
            <?php endwhile; ?>
        </table>


    <div id="form-container">
        <form method="post" action="">
            <h2 align="center">Thêm Thực Đơn</h2>
            <label for="name">Tên Thực Đơn :</label>
            <input type="text" id="name" name="name" required>

            <label for="list_describe">Mô tả:</label>
            <input type="text" id="list_describe" name="list_describe" required>

            <label for="menu_id"></label>
            <input type="hidden" id="menu_id" name="menu_id" required value="1">

            <label for="dish_id"></label>
            <input type="hidden" id="dish_id" name="dish_id" required value="3">

            <input type="submit" name="add" value="Thêm">
        </form>
    </div>

    </div>
    <script>
        function toggleForm() {
            var formContainer = document.getElementById('form-container');
            formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>
</html>
