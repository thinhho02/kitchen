<?php
session_start();
include '../../connect/connect.php';

if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);


date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date("Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Pacifico&family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;1,200&family=Poppins:wght@200;300&family=Public+Sans&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- <link rel="stylesheet" href="../../css/apexcharts.css"> -->
    <link rel="stylesheet" href="../../css/datatables.min.css">
    <link rel="Shortcut Icon" type="image/png" href="../../image/icons8-restaurant-bubbles-96.png">

    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

</head>
<style>
    body {
        color: black;
    }

    .right {
        font-family: "Plus Jakarta Sans", sans-serif;

    }
</style>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "../layouts/sidebar.php" ?>

            <div class="col-12 col-md-10 right">

            </div>

        </div>
    </div>



    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/bootstrap-bundle.min.js"></script>
    <script src="../../js/datatables.min.js"></script>
    <!-- <script src="../../js/apexcharts.js"></script> -->
    <!-- <script src="js/dashboard.js"></script> -->
    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass("active")
            $("#list-account").addClass("active")

        })
    </script>


</body>

</html>