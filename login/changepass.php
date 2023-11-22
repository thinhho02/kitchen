<?php
session_start();
include_once '../connect/connect.php';
if (isset($_SESSION['user_id'])) {
    header("location:../product.php");
    exit();
}
if (!isset($_SESSION['employee_id_check'])) {
    header("location:forgetpass.php");
    exit();
}

if (isset($_POST['submit'])) {

    // $passNew = mysqli_real_escape_string($con, md5($_POST['passnew']));
    // $passNewConfirm = mysqli_real_escape_string($con, md5($_POST['check_passnew']));
    $passNew = mysqli_real_escape_string($con, $_POST['passnew']);
    $passNew_encode = password_hash($passNew, PASSWORD_ARGON2I); // Mã hóa
    $passNewConfirm = mysqli_real_escape_string($con, $_POST['check_passnew']);
    $userId = $_SESSION['employee_id_check'];

    $select = mysqli_query($con, "SELECT * FROM `employees` where `employee_id` = '$userId'") or die("select failed");
    if (mysqli_num_rows($select) > 0) {
        if ($passNew != $passNewConfirm) {
            echo "<script> alert('Mật khẩu không trùng khớp!'); </script>";
        } else {
            mysqli_query($con, "UPDATE `employees` SET `password`='$passNew_encode' WHERE `employee_id` = '$userId';") or die("change password fail");
            echo "<script> 
                alert('Thay đổi mật khẩu thành công!'); 
                location.href = '../login' ;
                </script>";
            unset($_SESSION['employee_id_check']);
        }
    }
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
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="Shortcut Icon" type="image/png" href="../image/icons8-restaurant-bubbles-96.png">
</head>

<body>

    <script>
        const userHeader = document.getElementById("user_header");
        const loginLogout = document.querySelector(".login_logout");


        userHeader.addEventListener("click", function() {
            userHeader.classList.toggle("active");
            if (userHeader.classList.contains("active")) {
                loginLogout.style.display = "block";
            } else {
                loginLogout.style.display = "none";
            }

        });
    </script>
    <div class="background"></div>
    <div class="box box1" style="height: 377px;">
        <!-- <span class="line"></span> -->
        <form action="" method="post" autocomplete="off" class="form1">
            <h2>Đổi mật khẩu</h2>

            <div class="inputBox">
                <input type="password" name="passnew" id="password" required="required">
                <span>Mật khẩu mới</span>
                <i></i>
                <ion-icon class="see_pass_word" id="see_password" name="eye-off-outline"></ion-icon>
            </div>
            <div class="inputBox">
                <input type="password" name="check_passnew" id="confirm-password" required="required">
                <span>Xác nhận mật khẩu</span>
                <i></i>
                <ion-icon class="see_pass_word" id="see_confirm_password" name="eye-off-outline"></ion-icon>
            </div>

            <!-- <input type="submit" name="submit" value="Tiếp tục" style="margin-top: 30px;"> -->
            <button type="submit" class="submit_form" name="submit" id="submitChange" value="Tiếp tục" style="margin-top: 30px;">
                <span>
                    Tiếp tục
                </span>
            </button>
        </form>
    </div>
    <script>
        const seePass = document.getElementById("see_password");
        const passWord = document.getElementById("password");
        seePass.addEventListener('click', function() {

            const typePass = passWord.getAttribute("type") === 'password' ? 'text' : 'password';
            passWord.setAttribute("type", typePass);
            passWord.getAttribute("type") === "password" ? seePass.setAttribute("name", "eye-off-outline") : seePass.setAttribute("name", "eye-outline");

        });
        const seeConfirmPass = document.getElementById("see_confirm_password");
        const confirmPassWord = document.getElementById("confirm-password");
        seeConfirmPass.addEventListener('click', function() {

            const typePass = confirmPassWord.getAttribute("type") === 'password' ? 'text' : 'password';
            confirmPassWord.setAttribute("type", typePass);
            confirmPassWord.getAttribute("type") === "password" ? seeConfirmPass.setAttribute("name", "eye-off-outline") : seeConfirmPass.setAttribute("name", "eye-outline");

        });
    </script>

</body>

</html>