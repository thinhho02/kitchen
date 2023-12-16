<?php
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

<script>

</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Public+Sans&family=Work+Sans&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="../css/header.css"> -->
    <link rel="stylesheet" href="../css/style1.css">

    <link rel="Shortcut Icon" type="image/png" href="../image/icons8-restaurant-bubbles-96.png">
</head>



<body>

    <div class="background"></div>
    <div class="box">
        <form action="" method="post" autocomplete="off" id="form">
            <h2>Đăng Nhập</h2>
            <div class="inputBox">
                <input type="text" class="input-field" name="email" id="email" required="required">
                <span>Tên đăng nhập</span>
                <i class="valid"></i>
            </div>
            <div class="inputBox">
                <input type="password" class="input-field" name="password" id="password" required="required">
                <span>Mật khẩu</span>
                <ion-icon class="see_pass_word" id="see_password" name="eye-off-outline"></ion-icon>
                <i class="valid"></i>
            </div>
            <div class="links">
                <!-- <p class="wrong">sai</p> -->
                <a href="./forgetpass.php">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="submit_form" name="submit" id="submit" value="Đăng nhập" style="margin-top: 30px;">
                <span id="text-btn">
                    Đăng nhập
                </span>
                <div class="spinner-border spinner-border-sm" id="spinner" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>
        </form>
        <div class="right">
            <h1>Welcome</h1>
            <!-- <p>Say something..</p> -->
        </div>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/login.js"></script>


</html>
<?php

?>