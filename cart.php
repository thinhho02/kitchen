<?php
session_start();
include 'connect/connect.php';
if (!isset($_SESSION['employee_id'])) {
    header("location: login/");
}
$id = $_SESSION['employee_id'];

// echo $id;
$select = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row = mysqli_fetch_assoc($select);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cart</title>
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
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="Shortcut Icon" type="image/png" href="image/icons8-restaurant-bubbles-96.png">

</head>
<style>
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

    <main class="ftco-no-pb ftco-section" style="padding-top: 80px; flex:1;">
        <div class="container ftco-animate" id="mainCart">
            <form action="" method="post" id="form-1">
                <div class="header-cart">
                    <span class="ftco-animate text-header">Giỏ hàng</span>
                    <div class="ftco-animate input_date">

                        <div class="form-group">
                            <!-- <label for="date">date</label> -->
                            <input type="date" class="date" name="date" id="date" placeholder="">
                        </div>

                    </div>
                </div>
                <table class="table-cart">
                    <thead>
                        <tr>
                            <th class="first_th" colspan="2" scope="col" style="padding: 0 10px 20px 0;">Món ăn</th>
                            <th class="sec-th" colspan="1" scope="col" style="padding: 0 0 20px 10px;">Số Lượng</th>
                            <th class="right" colspan="1" scope="col" style="padding: 0 0 20px 10px;">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody style="height: 62px;">

                    </tbody>
                </table>
            </form>
            <div class="back-to-menu">
                <a href="./" class="btn-back">Trở về trang menu</a>
            </div>
        </div>
        <div class="container cart-footer">
            <div class="cart-note">
                <div class="d-flex align-items-center" style="font-size: 18px; font-weight: 500;">
                    <ion-icon name="newspaper-outline"></ion-icon>
                    <span>Thêm ghi chú</span>
                </div>
                <textarea name="addnote" id="addnote"></textarea>
            </div>
            <div class="check-out">
                <div class="subtotal">
                    <div class="total">
                        <h6>Tổng tiền</h6>
                        <p></p>
                    </div>
                    <small style="color: red; font-weight: bold">Vui lòng kiểm tra trước khi đặt hàng</small>
                </div>
                <div class="btn-check-out">
                    <button class="btn" type="button" id="checkout" name="checkout">
                        <span id="text-btn">Đặt hàng</span>
                        <div class="spinner-border spinner-border-sm" id="spinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <footer class="ftco-footer ftco-no-pb ftco-section">
        <div class="container ftco-animate fadeInUp ftco-animated">
            <div class="row mb-5">
                <div class="col-md-6 col-lg-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Dream</h2>
                        <p>Hệ thống đặt món của chúng tôi cam kết mang đến cho khách hàng những trải nghiệm ẩm thực tuyệt vời nhất với những tiêu chuẩn cao về chất lượng, vệ sinh, và giá cả hợp lý. Giá cả là một phần quan trọng, chúng tôi hiểu rằng nhân viên muốn tận hưởng những bữa ăn ngon miệng mà vẫn đảm bảo túi tiền.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-1">
                            <li class="ftco-animate fadeInUp ftco-animated"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate fadeInUp ftco-animated"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate fadeInUp ftco-animated"><a href="#"><span class="fa fa-instagram"></span></a></li>
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

    </script>
    <!-- <script src="js/main.js"></script> -->
    <script src="js/main_nosroll.js"></script>
    <script src="js/cart.js"></script>
</body>

</html>