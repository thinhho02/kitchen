<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí thực đơn</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .menu-container {
        width: 80%;
        margin: auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
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

    td a {
        text-decoration: none;
        padding: 5px 10px;
        background-color: #3498db;
        color: #fff;
        border-radius: 4px;
    }

    td a:hover {
        background-color: #2980b9;
    }

    form {
        width: 50%;
        margin: auto;
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

<body>
    
</body>
</html>
<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

$result = $con->query("SELECT * FROM menu");

// Chức năng thêm món
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $menu_id = $_POST['menu_id'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $date = $_POST['date'];

    $sql = "INSERT INTO menu (status, price, date) VALUES ('$status', '$price', '$date')";

    if ($con->query($sql) === TRUE) {
        header("Location: add_menu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý thực đơn</title>
</head>
<body>
    <h1>Quản Lí Thực Đơn </h1>
    
    <div class="menu-container">
        <h2 align="center">Danh Sách Món</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Tên Món</th>
                <th>Giá</th>
                <th>Ngày Tạo</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['menu_id'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['price'] ?> VND</td>
                    <td><?= $row['date'] ?></td>
                    <td><a href="edit_menu.php?id=<?= $row['menu_id'] ?>">Chỉnh sửa</a></td>
                    <td><a href="del_menu.php?id=<?= $row['menu_id'] ?>">Xóa</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <button onclick="toggleForm()">Thêm thủ công</button>
        <button onclick="exportToExcel()">Xuất</button>

        <div id="form-container">
            <form method="post" action="">
                <h2 align="center">Thêm Món</h2>
                <label for="status">Tên Món:</label>
                <input type="text" id="status" name="status" required>

                <label for="price">Giá:</label>
                <input type="number" id="price" name="price" required>

                <label for="date">Ngày Tạo:</label>
                <input type="date" id="date" name="date" required>

                <input type="submit" name="add" value="Thêm">
            </form>
        </div>

    </div>
    <script>
        function toggleForm() {
            var formContainer = document.getElementById('form-container');
            formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
        }
        function exportToExcel() {
        window.location.href = 'export_excel.php';
    }
    </script>
</body>

</html>

