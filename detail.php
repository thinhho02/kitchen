<?php
global $con;
session_start();

include 'connect/connect.php';
if (!isset($_SESSION['employee_id'])) {
    header("location: login/");
    exit();
}
$id = $_SESSION['employee_id'];
$select = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
// if(mysqli_num_rows($select)===0) {header("location: login/");}
$row = mysqli_fetch_assoc($select);

if (!isset($_REQUEST['id'])) {
    header("location: ./");
    exit();
}

// select id menu
$id_menu = $_REQUEST['id'];
$select_menu = mysqli_query($con, "SELECT * FROM `menu` WHERE `menu_id` = $id_menu and `status` = 'food'");
if (mysqli_num_rows($select_menu) == 0) {
    header("location: ./");
    exit();
}
$row_menu = mysqli_fetch_assoc($select_menu);
date_default_timezone_set('Asia/Ho_Chi_Minh');
if ($row_menu['date'] <= date("Y-m-d")) {
    header("location: ./");
    exit();
}





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chi tiết món ăn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/star-rating.css">
    <link href="themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="Shortcut Icon" type="image/png" href="image/icons8-restaurant-bubbles-96.png">

</head>
<style>
    body {
        color: black;
    }

    .icon-hover:hover {
        border-color: #3b71ca !important;
        background-color: white !important;
        color: #3b71ca !important;
    }

    .icon-hover:hover i {
        color: #3b71ca !important;
    }

    .image_aside {
        height: 400px;
    }

    .review_dish ion-icon {
        font-size: 20px;
    }

    .review_dish span {
        font-size: 23px;
    }

    .quantity {
        border: 1px solid black;
        padding: 0;
    }

    .quantity button {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 !important;
        border: none;
        width: 35px;
        padding: 0 !important;
        /* border-right: 1px solid black; */
        border-radius: 0;
    }

    .quantity button:hover {
        background-color: #ffc107;
    }

    .quantity button:focus {
        background-color: #ffc107;
        color: black;
        box-shadow: none;
    }

    .quantity input {
        border: none;

    }

    .rating_review {
        display: flex;
        align-items: center;
        column-gap: 2rem;
    }

    .rating__average {
        width: 30%;
        background-color: var(--secondary);
        padding: 1rem;
        border-radius: .8rem;
        text-align: center;
    }

    .rating__average h1 {
        font-size: 3rem;
        /* line-height: 0; */
        margin: 0;
        padding: 0;
    }

    .rating__averag p {
        margin: 0;
        padding: 0;
    }

    .star-outer {
        position: relative;
        font-size: 2rem;

        display: inline-block;
    }

    .star-outer::before {
        content: "\2605 \2605 \2605 \2605 \2605";
        color: #02020221;
    }

    .star-inner {
        position: absolute;
        top: 0;
        left: 0;

        width: 0%;
        overflow: hidden;
    }

    .star-inner::before {
        content: "\2605 \2605 \2605 \2605 \2605";
        color: gold;
    }

    .rating__progress {
        width: 70%;
    }

    .rating__progress-value {
        height: 47px;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        column-gap: 1rem;
    }

    .rating__progress-value p:first-child {
        padding: 0;
        margin: 0;
        font-size: 20px;
    }

    .rating__progress-value .star {
        font-size: 25px;
        color: gold;
    }

    .rating__progress-value p:last-child {
        width: 10%;
        padding: 0;
        margin: 0;
        font-size: 20px;
    }

    .rating__progress .progress {
        flex: 1 1 0;
        height: .5rem;
        border-radius: .5rem;
        background-color: #ff02;

    }

    .bar {
        height: 100%;
        background-color: gold;
        border-radius: .5rem;
    }

    .bar:nth-child(1) {
        width: 80%;
    }

    .rating_detail .content {
        width: 100%;
    }

    .message #input-message {
        width: 100%;
        height: 80px;
        border-radius: 5px;
    }

    .message #input-message:focus {
        outline: 1px solid #ffb302 !important;
    }

    @media screen and (min-width: 991px) and (max-width: 1200px) {
        .image_aside {
            height: 350px;
        }
    }

    #ftco-navbar {
        margin: 0;
        position: fixed;
        right: 0;
        left: 0;
        top: 0;
        background: #fff !important;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        z-index: 3;
        padding: 0 !important;
        margin: 0 !important;
    }
</style>

<body>
    <!-- Get ID -->
    <input type="hidden" name="getId" id="getId" value="<?php echo $id; ?>">
    <input type="hidden" name="getIdMenu" id="getIdMenu" value="<?php echo $id_menu; ?>">
    <!-- Get ID -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light scrolled awake" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="./">Dream</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav1" aria-controls="ftco-nav1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item"><a href="./" class="nav-link">thực đơn</a></li>
                    <li class="nav-item active"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
                </ul>
            </div>
            <div id="avatar-user">
                <button class="avatar" type="button" data-toggle="collapse" data-target="#profile" aria-controls="profile" aria-expanded="false" aria-label="Toggle profile">
                    <img src="image/<?php echo $row['avatar'] ?>" class="rounded-circle" style="width: 36px; height: 36px;" alt="avatar">
                </button>
                <div class="row flex-column profile-logout fade collapse" id="profile">
                    <div class="name_user" style="padding: 8px 0;">
                        <div class="d-flex align-items-center" style="gap: 30px; padding: 0 8px; color: white">
                            <img src="image/<?php echo $row['avatar'] ?>" class="rounded-circle" style="width: 36px; height: 36px;" alt="avatar">
                            <span class="name" style="font-size: 23px;"><?php echo $row['full_name']; ?></span>
                        </div>
                    </div>
                    <a href="profile.php" class="link-profile">
                        <div class="nav align-items-center profile-info" style="color: white">
                            <div class="icon-profile">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #a9a9a9;">
                                    <ion-icon name="person-circle-outline" role="img" class="md hydrated"></ion-icon>
                                </div>
                            </div>
                            <div class="infor-profile">
                                <span class="p-0">Thông tin</span>
                                <ion-icon class="icon-active" name="chevron-forward-outline" role="img" class="p-0 md hydrated" style="font-size: 25px;"></ion-icon>
                            </div>
                        </div>
                    </a>
                    <a href="login/logout.php?id=<?php echo $_SESSION['employee_id'] ?>" class="link-profile">
                        <div class="nav align-items-center profile-info" style="color: white">
                            <div class="icon-profile">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #a9a9a9;">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                            </div>
                            <div class="infor-profile">
                                <span class="p-0">Đăng xuất</span>
                                <ion-icon class="icon-active" name="chevron-forward-outline" role="img" class="p-0 md hydrated" style="font-size: 25px;"></ion-icon>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="collapse navbar-collapse" id="ftco-nav1">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="./" class="nav-link">thực đơn</a></li>
                <li class="nav-item active"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
            </ul>
        </div>
    </nav>
    <!-- END Header -->
    <!-- content -->
    <section class="py-5" style="margin-top: 50px;">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="rounded-4 mb-3 d-flex flex-column">
                        <div data-fslightbox="mygalley" class="d-flex rounded-4" target="_blank" data-type="image">
                            <img style=" margin: auto;" class="rounded-4 fit image-fluid image_aside" />
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <span class="col-sm-12" style="font-size: 20px; font-weight: bold;">Mô tả: </span>
                            <p class="col-sm-12 description">

                            </p>
                        </div>
                    </div>

                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <div class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark font-weight-bold name_dish">

                        </h4>
                        <div class="d-flex flex-row">
                            <div class="text-warning mb-1 review_dish">
                                <div class="star-outer">
                                    <div class="star-inner" style="width: 80%"></div>
                                </div>
                                <span class="ms-1 font-weight-bold">

                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <dt class="col-4">Loại món ăn:</dt>
                            <dd class="col-8 cate"></dd>

                            <dt class="col-4">Giá:</dt>
                            <dd class="col-8 price"></dd>

                            <dt class="col-4">Ngày đặt:</dt>
                            <dd class="col-8 date_menu"></dd>

                            <dt class="col-4">Nguyên liệu:</dt>
                            <dd class="col-8 resource"></dd>


                        </div>

                        <hr />

                        <div class="col-md-12 mb-4">
                            <!-- col.// -->
                            <div class="row mb-3 align-items-center">
                                <label class="col-3 mb-3 font-weight-bold" style="padding: 0; font-size: 20px;">Quantity</label>
                                <div class="col-3 input-group mb-3 quantity">
                                    <button class="btn px-3" type="button" id="button-addon1" style="border-right: 1px solid black;">
                                        <ion-icon name="remove-outline"></ion-icon>
                                    </button>
                                    <input type="number" class="form-control text-center input_quantity" value="1" min="1" />
                                    <button class="btn px-3" type="button" id="button-addon2" style="border-left: 1px solid black;">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary px-5 shadow-0" id="btn_add" style="font-size: 20px;"> <i class="me-1 fa fa-shopping-basket"></i> Thêm giỏ hàng </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
    <section class="bg-light border-top py-4">

        <div class="container my-3">
            <h3>Đánh giá món ăn</h3>

            <div class="rating_review">
                <div class="rating__average">
                    <h1></h1>
                    <div class="star-outer">
                        <div class="star-inner"></div>
                    </div>
                    <p style="font-size: 20px; margin: 0;"></p>
                </div>
                <div class="rating__progress">


                </div>
            </div>
            <div class="row gx-4">
                <div class="col-sm-12 my-4 mr-auto rating_detail">
                    <div class="d-flex border-bottom my-3" style="align-items: flex-start">
                        <div class="avt_user">
                            <img src="image/<?php echo $row['avatar'] ?>" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 20px" alt="">
                        </div>
                        <div class="content">
                            <div class="rv_name_user" style="font-size: 19px;"><?php echo $row['full_name'] ?></div>
                            <div class="rating_user">
                                <input id="rating-input" type="number" title="" />
                            </div>
                            <div class="my-2 message">
                                <input type="text" class="px-3 border" id="input-message" placeholder="Nhập đánh giá">
                            </div>
                            <div class="my-2 d-flex justify-content-end">
                                <button class="mx-3 btn btn-primary" id="btn_review">Đánh giá</button>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

    </section>


    <!-- Footer -->
    <footer class="ftco-footer ftco-no-pb ftco-section">
        <div class="container ftco-animate">
            <div class="row mb-5">
                <div class="col-md-6 col-lg-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Dream</h2>
                        <p>Hệ thống đặt món của chúng tôi cam kết mang đến cho khách hàng những trải nghiệm ẩm thực tuyệt vời nhất với những tiêu chuẩn cao về chất lượng, vệ sinh, và giá cả hợp lý. Giá cả là một phần quan trọng, chúng tôi hiểu rằng nhân viên muốn tận hưởng những bữa ăn ngon miệng mà vẫn đảm bảo túi tiền.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-1">
                            <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Giờ hoạt động</h2>
                        <ul class="list-unstyled open-hours">
                            <li class="d-flex"><span>Thứ Hai</span><span>24/24</span></li>
                            <li class="d-flex"><span>Thứ Ba</span><span>24/24</span></li>
                            <li class="d-flex"><span>Thứ Tư</span><span>24/24</span></li>
                            <li class="d-flex"><span>Thứ Năm</span><span>24/24</span></li>
                            <li class="d-flex"><span>Thứ Sáu</span><span>24/24</span></li>
                            <li class="d-flex"><span>Thứ Bảy</span><span>24/24</span></li>
                            <li class="d-flex"><span>Chủ Nhật</span><span> Đóng cửa</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Instagram</h2>
                        <div class="thumb d-sm-flex">
                            <a href="#" class="thumb-menu img" style="background-image: url(images/insta-1.jpg);">
                            </a>
                            <a href="#" class="thumb-menu img" style="background-image: url(images/insta-2.jpg);">
                            </a>
                            <a href="#" class="thumb-menu img" style="background-image: url(images/insta-3.jpg);">
                            </a>
                        </div>
                        <div class="thumb d-flex">
                            <a href="#" class="thumb-menu img" style="background-image: url(images/insta-4.jpg);">
                            </a>
                            <a href="#" class="thumb-menu img" style="background-image: url(images/insta-5.jpg);">
                            </a>
                            <a href="#" class="thumb-menu img" style="background-image: url(images/insta-6.jpg);">
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </footer>
    <!-- Footer -->


    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>


    <script src="js/jquery.min.js"></script>

    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="js/bootstrap-bundle.min.js"></script>
    <script src="js/star-rating.js"></script>
    <script src="themes/krajee-svg/theme.js" type="text/javascript"></script>
    <!-- <script src="js/main.js"></script> -->
    <script src="js/main_nosroll.js"></script>
    <script src="js/detail.js"></script>
</body>

</html>