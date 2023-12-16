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


if (!isset($_SESSION['employee_id_check'])) {
    header("location:forgetpass.php");
    exit();
}
if (isset($_SESSION['email'])) {
    header("location:forgetpass.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thay Đổi Mật Khẩu</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="Shortcut Icon" type="image/png" href="../image/icons8-restaurant-bubbles-96.png">
</head>

<body>


    <div class="background"></div>
    <div class="box box1" style="height: 377px;">
        <!-- <span class="line"></span> -->
        <form action="" method="post" autocomplete="off" class="form1">
            <h2>Đổi mật khẩu</h2>

            <div class="inputBox">
                <input type="password" class="input-field" name="passnew" id="password" required="required">
                <span>Mật khẩu mới</span>
                <i class="valid"></i>
                <ion-icon class="see_pass_word" id="see_password" name="eye-off-outline"></ion-icon>
            </div>
            <div class="inputBox">
                <input type="password" class="input-field" name="check_passnew" id="confirm-password" required="required">
                <span>Xác nhận mật khẩu</span>
                <i class="valid"></i>
                <ion-icon class="see_pass_word" id="see_confirm_password" name="eye-off-outline"></ion-icon>
            </div>
            <div class="links" style="margin-top: 20px">

            </div>
            <!-- <input type="submit" name="submit" value="Tiếp tục" style="margin-top: 30px;"> -->
            <button type="submit" class="submit_form" name="submit" id="submitChange" value="change" style="margin-top: 30px;">
                <span id="text-btn">
                    Tiếp tục
                </span>
                <div class="spinner-border spinner-border-sm" id="spinner" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>
        </form>
    </div>
    <script>
        const seeConfirmPass = document.getElementById("see_confirm_password");
        const confirmPassWord = document.getElementById("confirm-password");
        seeConfirmPass.addEventListener('click', function() {

            const typePass = confirmPassWord.getAttribute("type") === 'password' ? 'text' : 'password';
            confirmPassWord.setAttribute("type", typePass);
            confirmPassWord.getAttribute("type") === "password" ? seeConfirmPass.setAttribute("name", "eye-off-outline") : seeConfirmPass.setAttribute("name", "eye-outline");

        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/login.js"></script>
</body>

</html>