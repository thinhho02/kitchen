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
        line-height: 1.5;
    }

    .right {
        font-family: "Plus Jakarta Sans", sans-serif;

    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 4px 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        width: 200px;
        border-radius: 8px;
        outline: none;
        margin-top: 5px;
        margin-bottom: 10px;
        margin-right: 10px;
        transition: all 0.3s linear;

    }

    .dataTables_wrapper .dataTables_filter input:focus {
        box-shadow: 0 0 0 0.05rem #c00a27;
        /* outline: 0; */
        border-color: transparent;
    }

    /* .pill-tabContent .active {
        display: inline;
    } */
    /* .dataTables_wrapper {
        width: 100%;
    } */
    #myTabProfile button.nav-link{
        outline: none;
        box-shadow: none;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "../layouts/sidebar.php" ?>

            <div class="col-12 col-md-10 right">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="text-uppercase" style="font-weight: bold;">Danh sách tài khoản</h3>
                    </div>
                </div>
                <div class="my-5">
                    <ul class="nav nav-tabs" id="myTabProfile" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="btn nav-link active" id="employee-tab" data-bs-toggle="tab" data-bs-target="#listEmployees" type="button" role="tab" aria-controls="listEmployees" aria-selected="true">Danh sách nhân viên</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="btn nav-link" id="chef-tab" data-bs-toggle="tab" data-bs-target="#listChef" type="button" role="tab" aria-controls="listChef" aria-selected="false">Danh sách đầu bếp</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="btn nav-link" id="deliver-tab" data-bs-toggle="tab" data-bs-target="#listDeliver" type="button" role="tab" aria-controls="listDeliver" aria-selected="false">Danh sách shipper</button>
                        </li>
                    </ul>
                </div>
                <!-- End: Page header -->




                <!-- Start: Table -->

                <div class="tab-content pill-tabContent mt-4">
                    <div class="tab-pane fade show active" id="listEmployees" role="tabpanel" aria-labelledby="listEmployees-tab">
                        <div class="table-responsive">

                            <table class="table table-striped hover" style="width: 100%" id="table-employees">
                                <thead style="font-size: 15px;">
                                    <tr>
                                        <th scope="col" class="text-center">Mã NV</th>
                                        <th scope="col" class="text-center">Tên NV</th>
                                        <th scope="col" class="text-center">Số Điện Thoại</th>
                                        <th scope="col" class="text-center">Email</th>
                                        <th scope="col" class="text-center">Số Căn Cước</th>
                                        <th scope="col" class="text-center">Ngày Sinh</th>
                                        <th scope="col" class="text-right px-2">Chưa thanh toán</th>
                                        <th scope="col" class="text-center">Ngày tạo</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body" style="font-size: 14px;">


                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="listChef" role="tabpanel" aria-labelledby="listChef-tab">
                        <div class="table-responsive">

                            <table class="table table-striped hover" style="width: 100%" id="table-chef">
                                <thead style="font-size: 15px;">
                                    <tr>
                                        <th scope="col" class="text-center" style="min-width: 82px;">Mã NV</th>
                                        <th scope="col" class="text-center" style="min-width: 122px;">Tên NV</th>
                                        <th scope="col" class="text-center" style="min-width: 120px;">Số Điện Thoại</th>
                                        <th scope="col" class="text-center" style="min-width: 254px;">Email</th>
                                        <th scope="col" class="text-center" style="min-width: 118px;">Số Căn Cước</th>
                                        <th scope="col" class="text-center" style="min-width: 111px;">Ngày Sinh</th>
                                        <th scope="col" class="text-center" style="min-width: 101px;">Ngày tạo</th>
                                        <th scope="col" class="text-center" style="min-width: 33px;"></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body" style="font-size: 14px;">


                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="listDeliver" role="tabpanel" aria-labelledby="listDeliver-tab">
                        <div class="table-responsive">

                            <table class="table table-striped hover" style="width: 100%" id="table-deliver">
                                <thead style="font-size: 15px;">
                                    <tr>
                                        <th scope="col" class="text-center" style="min-width: 82px;">Mã NV</th>
                                        <th scope="col" class="text-center" style="min-width: 122px;">Tên NV</th>
                                        <th scope="col" class="text-center" style="min-width: 120px;">Số Điện Thoại</th>
                                        <th scope="col" class="text-center" style="min-width: 254px;">Email</th>
                                        <th scope="col" class="text-center" style="min-width: 118px;">Số Căn Cước</th>
                                        <th scope="col" class="text-center" style="min-width: 111px;">Ngày Sinh</th>
                                        <th scope="col" class="text-center" style="min-width: 101px;">Ngày tạo</th>
                                        <th scope="col" class="text-center" style="min-width: 33px;"></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body" style="font-size: 14px;">


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>



    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/bootstrap-bundle.min.js"></script>
    <script src="../../js/datatables.min.js"></script>
    <!-- <script src="../../js/apexcharts.js"></script> -->
    <script src="../js/list_account.js"></script>



</body>

</html>