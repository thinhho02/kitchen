<?php
session_start();
include '../connect/connect.php';

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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/apexcharts.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="Shortcut Icon" type="image/png" href="../image/icons8-restaurant-bubbles-96.png">

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

    .card {
        margin-bottom: 30px;
        border: 0px solid #ebf1f6;
        box-shadow: rgba(145, 158, 171, 0.2) 0px 0px 10px 0px, rgba(145, 158, 171, 0.12) 0px 12px 24px -4px;
    }

    .card-body {
        padding: 30px;
        /* padding-bottom: 7px; */
    }

    .form-select {
        padding: 4px 10px 4px 2px;
        border: 1px solid #00000042;
        border-radius: 7px;
    }

    .apexcharts-legend {
        position: absolute;
        top: 0;
        /* Adjust the top position as needed */
        right: -20px;
        /* Adjust the right position as needed */
    }

    #top_buyer td {
        padding-top: 9px;
        vertical-align: middle;
        border: none;
        font-size: 15px;
    }

    .border-avatar-top {
        height: 58px;
        /* margin-right: 4px; */
        padding: 4px 9px;
        width: 40px;
        /* background-image: url(../image/top1.png); */
        background-size: 100%;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        background-position: center;
    }

    .img_avatar {
        width: 24px;
        height: 24px;
    }

    div.dt-buttons>.dt-button {
        background-color: #28a745;
        border-radius: 8px;
        font-size: 13px;
        padding: 4px 8px;
        color: white;
        border: none !important;
    }

    div.dt-buttons>.dt-button:hover {
        background-color: #62a371 !important;
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

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 20px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        padding: 5px 10px;
        cursor: pointer;
        margin-right: 2px;
        color: #666;
        display: inline;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #f0f0f0;
        color: #333;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #f5f5f5;
        color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #e7e7e7;
        color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        cursor: not-allowed;
        color: #ccc;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        background-color: #ffffff;
        color: #ccc;
    }

    .btn-link:focus {
        outline: none;
        background-color: transparent;
        color: #007bff;
    }

    @media screen and (min-width: 1200px) {
        .container {
            max-width: 1230px;
        }
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "layouts/sidebar.php" ?>

            <div class="col-12 col-md-10 right">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 d-flex align-items-strech">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h5 class="font-weight-bold">Doanh Thu</h5>
                                        <select class="form-select" name="" id="selectBar">
                                            <?php
                                            echo '<option value="' . $date . '" selected>Năm ' . $date . '</option>';
                                            ?>
                                            <?php
                                            $select_year_payment = mysqli_query($con, "SELECT DATE_FORMAT(`created_time`,'%Y') as `year` FROM `payment` WHERE DATE_FORMAT(`created_time`,'%Y') < '$date' GROUP BY DATE_FORMAT(`created_time`,'%Y') DESC");
                                            while ($row_year_payment = mysqli_fetch_assoc($select_year_payment)) {
                                            ?>
                                                <option value="<?php echo $row_year_payment['year'] ?>">Năm <?php echo $row_year_payment['year'] ?></option>
                                            <?php
                                            }
                                            ?>
                                            <!-- <option value="2">Năm 2022</option>
                                        <option value="3">Năm 2021</option> -->
                                        </select>
                                    </div>
                                    <div id="chart-bar"></div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <span><b class="mr-2" style="letter-spacing: 0.5px">Tổng doanh thu: </b><span class="total-this-year">0 VNĐ</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 mx-auto">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card overflow-hidden">
                                        <div class="card-body py-4 px-4">
                                            <h5 class="font-weight-bold mx-0">Hàng Năm</h5>
                                            <div class="row align-items-center" style="position: relative;">
                                                <div class="col-8" style="line-height: 2;">
                                                    <p class="font-weight-bold mb-1 value_trending">0 VNĐ</p>
                                                    <div class="d-flex align-items-center">
                                                        <span class="color_trending d-flex align-items-center justify-content-center rounded-circle" style="width: 20px; height: 20px;background-color: rgb(251,242,239);"><ion-icon name="trending-up-outline"></ion-icon></span>
                                                        <p class="mx-1 text-dark p-0 my-0 trending" style="font-size: 0.875rem;">+9%</p>
                                                        <p class="p-0 my-0" style="font-size: 0.875rem;">Năm trước</p>
                                                    </div>
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <?php
                                                        $select_year = mysqli_query($con, "SELECT DATE_FORMAT(`created_time`,'%Y') as `year` FROM `payment` GROUP BY DATE_FORMAT(`created_time`,'%Y') DESC");
                                                        while ($row_year = mysqli_fetch_assoc($select_year)) {
                                                        ?>
                                                            <div class="mr-2">
                                                                <span class="rounded-circle d-inline-block label-donut" style="width: 8px; height: 8px;"></span>
                                                                <span style="font-size: 0.75rem;"><?php echo $row_year['year'] ?></span>
                                                            </div>


                                                        <?php
                                                        }
                                                        ?>


                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-center">
                                                        <div id="chart-pie"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card overflow-hidden">
                                        <div class="cart-body py-4 px-4" style="height: 240px;">
                                            <h5 class="font-weight-bold mx-0">Người mua nhiều nhất trong tháng <span class="top_month">12</span>/<span class="top_year">2023</span></h5>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="top_buyer">
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card w-100">
                                <div class="card-body px-5">
                                    <h5 class="font-weight-bold mb-3 mx-0" style="letter-spacing: 1px;">Đơn Đặt Nhân Viên</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped hover" style="width: 100%;" id="table-user">
                                            <thead>
                                                <tr style="font-size: 15px">
                                                    <th scope="col" class="text-center" style="min-width: 18px;">#</th>
                                                    <th scope="col" class="text-center" style="min-width: 93px;">Mã NV</th>
                                                    <th scope="col" class="text-center" style="min-width: 138px;">Tên Nhân Viên</th>
                                                    <th scope="col" class="text-center" style="min-width: 310px;">Email</th>
                                                    <th scope="col" class="text-center" style="min-width: 127px;">Số Điện Thoại</th>
                                                    <th scope="col" class="text-center" style="min-width: 126px;">Số Lượng Đơn</th>
                                                    <th scope="col" class="text-center" style="min-width: 147px;">Tổng Tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row justify-content-end align-items-center mx-3 mt-3">
                                        <b class="mr-4" style="letter-spacing: 0.5px">Tổng doanh thu trong tháng:</b>
                                        <span class="sub-total-user"></span>
                                    </div>
                                    <div class="row justify-content-end mx-3 mt-3" id="footer-table-user">
                                        <button type="button" class="limit_user btn btn-link">Xem thêm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card w-100">
                                <div class="card-body px-5">
                                    <h5 class="font-weight-bold mb-3 mx-0" style="letter-spacing: 1px;">Nguyên Liệu Được Sử Dụng</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped hover" style="width: 100%" id="table-resources">
                                            <thead>
                                                <tr style="font-size: 15px">
                                                    <th scope="col" class="text-center" style="min-width: 18px;">#</th>
                                                    <th scope="col" class="text-center" style="min-width: 146px;">Tên Nguyên Liệu</th>
                                                    <th scope="col" class="text-center" style="min-width: 98px;">Đơn Vị Tính</th>
                                                    <th scope="col" class="text-center" style="min-width: 88px;">Số Lượng</th>
                                                    <th scope="col" class="text-right px-5" style="min-width: 93px;">Đơn Giá</th>
                                                    <th scope="col" class="text-right px-5" style="min-width: 106px;">Tổng Tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body">

                                            </tbody>
                                            <!-- <tfoot>
                                                <tr>
                                                    <td colspan="6" style="text-align:right;"></td>
                                                </tr> 
                                            </tfoot> -->
                                        </table>
                                    </div>
                                    <div class="row justify-content-end align-items-center mx-3 mt-3">
                                        <b class="mr-4" style="letter-spacing: 0.5px">Tổng tiền:</b>
                                        <span class="sub-total-resource"></span>
                                    </div>
                                    <div class="row justify-content-end mx-3 mt-3" id="footer-table-resources">
                                        <button type="button" class="limit_resources btn btn-link">Xem thêm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-bundle.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <script src="../js/apexcharts.js"></script>
    <script src="js/dashboard.js"></script>
    <!-- <script>
        $(document).ready(function() {
            
            
        })
    </script> -->


</body>

</html>