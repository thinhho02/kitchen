<?php
// -------------------------------------------------------------------------SEND MAIL-------------------------------------------------------------------------------------
session_start();


include_once '../connect/connect.php';

if (isset($_SESSION['employee_id'])) {
    header("location:../");
    exit();
} elseif (isset($_SESSION['employee_manager_id'])) {
    header("location:../admin/");
    exit();
} elseif (isset($_SESSION['employee_deliver_id'])) {
    header("location:../deliver/");
    exit();
} elseif (isset($_SESSION['employee_chef_id'])) {
    header("location:../chef/");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Public+Sans&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../css/header.css"> -->
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="Shortcut Icon" type="image/png" href="../image/icons8-restaurant-bubbles-96.png">
</head>

<body>
    <div class="background"></div>
    <div class="box box1" style="height: 300px;">
        <!-- <span class="line"></span> -->
        <form action="" method="post" autocomplete="off" class="form1">
            <h2>Quên mật khẩu</h2>
            <div class="inputBox">
                <input type="text" class="input-field" name="check" id="check" required="required">
                <span>Nhập Email</span>
                <i class="valid"></i>
            </div>
            <div class="links" style="align-items: center;">
                <a style="font-size:13px;" href="../login">Quay lại trang đăng nhập</a>
            </div>

            <button type="submit" name="submit" class="submit_form" id="submit_forget" value="Gửi mã xác thực" style="margin-top: 15px; width: 100%;">
                <span id="text-btn">
                    Gửi mã xác thực
                </span>
                <div class="spinner-border spinner-border-sm" id="spinner" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>


        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/login.js"></script>
</body>

</html>