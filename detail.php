<?php
global $con;
session_start();

include 'connect/connect.php';
if (!isset($_SESSION['employee_id'])) {
    header("location: login/");
}
$id = $_SESSION['employee_id'];
$select = mysqli_query($con, "SELECT * FROM `employees` WHERE `employee_id` = '$id'");
// if(mysqli_num_rows($select)===0) {header("location: login/");}
$row = mysqli_fetch_assoc($select);
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
        width: 40px;
        height: 40px;
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
                    <a href="profile.php" class="link-profile">
                        <div class="nav align-items-center profile-info" style="color: black">
                            <div class="icon-profile">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #887777;">
                                    <ion-icon name="person-circle-outline" role="img" class="md hydrated"></ion-icon>
                                </div>
                            </div>
                            <div class="infor-profile">
                                <span class="p-0">Thông tin</span>
                                <ion-icon name="chevron-forward-outline" role="img" class="p-0 md hydrated" style="font-size: 25px;"></ion-icon>
                            </div>
                        </div>
                    </a>
                    <a href="login/logout.php?id=<?php echo $id ?>" class="link-profile">
                        <div class="nav align-items-center profile-info" style="color: black">
                            <div class="icon-profile">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #887777;">
                                    <ion-icon name="log-out-outline" role="img" class="md hydrated"></ion-icon>
                                </div>
                            </div>
                            <div class="infor-profile">
                                <span class="p-0">Đăng xuất</span>
                                <ion-icon name="chevron-forward-outline" role="img" class="p-0 md hydrated" style="font-size: 25px;"></ion-icon>
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
                    <div class="rounded-4 mb-3 d-flex justify-content-center align-items-center h-100">
                        <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="#">
                            <img style=" margin: auto;" class="rounded-4 fit image-fluid image_aside" src="image/raungot.jpg" />
                        </a>
                    </div>

                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            Quality Men's Hoodie for Winter, Men's Fashion <br />
                            Casual Hoodie
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <div class="text-warning mb-1 me-2 review_dish">
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-half"></ion-icon>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div>

                        </div>
                        <div class="row">
                            <dt class="col-4">Loại món ăn:</dt>
                            <dd class="col-8">Regular</dd>

                            <dt class="col-4">Giá:</dt>
                            <dd class="col-8">Brown</dd>

                            <dt class="col-4">Ngày đặt:</dt>
                            <dd class="col-8">Cotton, Jeans</dd>

                            <dt class="col-4">Nguyên liệu:</dt>
                            <dd class="col-8">Reebook</dd>

                            <dt class="col-4">Mô tả: </dt>
                            <p class="col-8">
                                Modern look and quality demo item is a streetwear-inspired collection that continues to break away from the conventions of mainstream fashion. Made in Italy, these black and brown clothing low-top shirts for
                                men.
                            </p>
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
                                    <input type="number" class="form-control text-center" value="1" min="1" />
                                    <button class="btn px-3" type="button" id="button-addon2" style="border-left: 1px solid black;">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary px-5 shadow-0" style="font-size: 20px;"> <i class="me-1 fa fa-shopping-basket"></i> Thêm giỏ hàng </button>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- content -->
    <section class="bg-light border-top py-4">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <div class="border rounded-2 px-3 py-2 bg-white">
                        <!-- Pills navs -->
                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100 active" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab" aria-controls="ex1-pills-1" aria-selected="true">Specification</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-2" data-mdb-toggle="pill" href="#ex1-pills-2" role="tab" aria-controls="ex1-pills-2" aria-selected="false">Warranty info</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-3" data-mdb-toggle="pill" href="#ex1-pills-3" role="tab" aria-controls="ex1-pills-3" aria-selected="false">Shipping info</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-4" data-mdb-toggle="pill" href="#ex1-pills-4" role="tab" aria-controls="ex1-pills-4" aria-selected="false">Seller profile</a>
                            </li>
                        </ul>
                        <!-- Pills navs -->

                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">
                            <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                                <p>
                                    With supporting text below as a natural lead-in to additional content. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                    enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.
                                </p>
                                <div class="row mb-2">
                                    <div class="col-12 col-md-6">
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="fas fa-check text-success me-2"></i>Some great feature name here</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Lorem ipsum dolor sit amet, consectetur</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Duis aute irure dolor in reprehenderit</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Optical heart sensor</li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-6 mb-0">
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Easy fast and ver good</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Some great feature name here</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Modern style and design</li>
                                        </ul>
                                    </div>
                                </div>
                                <table class="table border mt-3 mb-2">
                                    <tr>
                                        <th class="py-2">Display:</th>
                                        <td class="py-2">13.3-inch LED-backlit display with IPS</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Processor capacity:</th>
                                        <td class="py-2">2.3GHz dual-core Intel Core i5</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Camera quality:</th>
                                        <td class="py-2">720p FaceTime HD camera</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Memory</th>
                                        <td class="py-2">8 GB RAM or 16 GB RAM</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Graphics</th>
                                        <td class="py-2">Intel Iris Plus Graphics 640</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                Tab content or sample information now <br />
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                                Another tab content or sample information now <br />
                                Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-4" role="tabpanel" aria-labelledby="ex1-tab-4">
                                Some other tab content or sample information now <br />
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                        <!-- Pills content -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="ftco-footer ftco-no-pb ftco-section">
        <div class="container ftco-animate">
            <div class="row mb-5">
                <div class="col-md-6 col-lg-3">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Taste.it</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                            <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Open Hours</h2>
                        <ul class="list-unstyled open-hours">
                            <li class="d-flex"><span>Monday</span><span>9:00 - 24:00</span></li>
                            <li class="d-flex"><span>Tuesday</span><span>9:00 - 24:00</span></li>
                            <li class="d-flex"><span>Wednesday</span><span>9:00 - 24:00</span></li>
                            <li class="d-flex"><span>Thursday</span><span>9:00 - 24:00</span></li>
                            <li class="d-flex"><span>Friday</span><span>9:00 - 02:00</span></li>
                            <li class="d-flex"><span>Saturday</span><span>9:00 - 02:00</span></li>
                            <li class="d-flex"><span>Sunday</span><span> Closed</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
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
                <div class="col-md-6 col-lg-3">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Newsletter</h2>
                        <p>Far far away, behind the word mountains, far from the countries.</p>
                        <form action="#" class="subscribe-form">
                            <div class="form-group">
                                <input type="text" class="form-control mb-2 text-center" placeholder="Enter email address">
                                <input type="submit" value="Subscribe" class="form-control submit px-3">
                            </div>
                        </form>
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
    <!-- <script src="js/main.js"></script> -->
    <script src="js/main_nosroll.js"></script>
</body>

</html>