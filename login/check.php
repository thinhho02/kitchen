<?php
session_start();

include_once '../connect/connect.php';
if (isset($_SESSION['user_id'])) {
    header("location:../product.php");
    exit();
}
if (!isset($_SESSION['email'])) {
    header("location:forgetpass.php");
    exit();
}

if (isset($_POST["submit"])) {
    $otp = $_SESSION['email'];
    $check = mysqli_real_escape_string($con, $_POST["check"]);
    if ($check == $otp) {
        echo "<script>
        alert('Xác thực thành công!');
        location.href = 'changepass.php';
        </script>";
        unset($_SESSION['email']);
        exit();
    } else {
        echo "<script>
                alert('Mã xác thực không đúng!');
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực</title>
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
    <div class="background"></div>
    <div class="box box1" style="height: 300px;">
        <!-- <span class="line"></span> -->
        <form action="" method="post" autocomplete="off" class="form1">
            <h2>Nhập mã xác thực</h2>
            <div class="inputBox">
                <input type="text" name="check" id="check" required="required">
                <span>Mã xác thực</span>
                <i></i>
            </div>

            <!-- <input type="submit" name="submit" value="Tiếp tục" style="margin-top: 30px;"> -->
            <button type="submit" class="submit_form" name="submit" id="submitCheck" value="Tiếp tục" style="margin-top: 30px;">
                <span>
                    Tiếp tục
                </span>
            </button>
        </form>
    </div>

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
</body>

</html>