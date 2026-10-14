<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thực đơn</title>
    <style>
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

        .dish-image {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <h2 align="center">Danh sách Món</h2>

    <?php

   
    // Lấy danh sách món từ bảng dishes
    $dishes_result = $con->query("SELECT * FROM dishes");

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['dish_id'])) {
        // Lấy thông tin món từ bảng dishes dựa trên dish_id được truyền vào
        $dish_id = $_GET['dish_id'];
        $dish_result = $con->query("SELECT * FROM dishes WHERE dish_id='$dish_id'");

        if ($dish = $dish_result->fetch_assoc()) {
            // Lấy thông tin món để thêm vào bảng menu
            $status = $dish['name']; // Sử dụng name của bảng dishes làm status của bảng menu
            $price = 25000; // Giá mặc định là 2500
            $date = date('Y-m-d'); // Ngày tạo mặc định là ngày hiện tại

            // Thêm món vào bảng menu
            $insert_sql = "INSERT INTO menu (status, price, date) VALUES ('$status', '$price', '$date')";

            if ($con->query($insert_sql) === TRUE) {
                echo "Món đã được thêm vào thực đơn thành công!";
            } else {
                echo "Error: " . $insert_sql . "<br>" . $con->error;
            }
        } else {
            echo "Không tìm thấy thông tin món!";
        }
    } else {
        echo "oke á";
    }

?>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên Món</th>
            <th>Ảnh</th>
            <th>Thêm món vào thực đơn</th>
        </tr>

        <?php while ($dish = $dishes_result->fetch_assoc()): ?>
            <tr>
                <td><?= $dish['dish_id'] ?></td>
                <td><?= $dish['name'] ?></td>
                <td><img class="dish-image" src="<?= $dish['image'] ?>" alt="<?= $dish['name'] ?>"></td>
                <td><a href="add_menu1.php?dish_id=<?= $dish['dish_id'] ?>">Thêm vào thực đơn</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
