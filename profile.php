<?php
session_start();
include 'connect/connect.php';
if (!isset($_SESSION['employee_id'])) {
    header("location: login/");
}
$id = $_SESSION['employee_id'];

// echo $id;
$select = mysqli_query($con, "SELECT *, CONCAT(`first_name`, ' ', `last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row = mysqli_fetch_assoc($select);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="Shortcut Icon" type="image/png" href="image/icons8-restaurant-bubbles-96.png">

</head>
<style>
    

    
</style>

<body>
    <div class="toast">
        <div class="toast-content">
            <ion-icon class="toast-check" name="checkmark-outline"></ion-icon>
            <div class="message">
                <span class="message-text text-1">Success</span>
                <span class="message-text text-2"></span>
            </div>
        </div>
        <ion-icon class="toast-close" name="close-outline"></ion-icon>
        <div class="progress"></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light scrolled awake" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="./">Dream</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav1" aria-controls="ftco-nav1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item "><a href="./" class="nav-link">thực đơn</a></li>
                    <li class="nav-item"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
                </ul>
            </div>
            <div id="avatar-user">
                <button class="avatar" type="button" data-toggle="collapse" data-target="#profile" aria-controls="profile" aria-expanded="false" aria-label="Toggle profile">
                    <img src="image/<?php echo $row['avatar'] ?>" class="rounded-circle" style="width: 36px; height: 36px;" alt="avatar">
                </button>
                <div class="row flex-column profile-logout fade collapse" id="profile">
                    <a href="" class="link-profile">
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
                <li class="nav-item"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
            </ul>
        </div>
    </nav>



    <div class="container-xl px-4 mt-4" style="margin-top: 6.5rem !important;margin-bottom: 6.5rem !important;">
        <ul class="nav nav-tabs" id="myTabProfile" role="tablist" style="margin-bottom: 50px">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profileUser" type="button" role="tab" aria-controls="profileUser" aria-selected="true">Thông tin cá nhân</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#orderUser" type="button" role="tab" aria-controls="orderUser" aria-selected="false">Lịch sử đơn hàng</button>
            </li>
        </ul>
        <div class="tab-content pill-tabContent">
            <div class="tab-pane fade show active" id="profileUser" role="tabpanel" aria-labelledby="profileUser-tab">
                <div class="col-xl-4 ftco-animate">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Ảnh đại diện</div>
                        <div class="card-body text-center">

                            <img class="img-account-profile rounded-circle mb-2" src="image/<?php echo $row['avatar'] ?>" style="width: 250px; height: 250px;" alt>

                            <div class="mb-2 mt-4 h5"><?php echo mb_strtoupper($row['full_name'], "UTF-8"); ?></div>

                            <b class="mb-4 h6"> <?php if ($row['roles'] === 'employee') echo "Nhân Viên"; ?></b><small> - </small><b class="h6"><?php echo $id ?></b>
                            <input type="hidden" name="getId" id="getId" value="<?php echo $id; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 ftco-animate">
                    <div class="card mb-4">
                        <div class="card-header">Thông tin chi tiết</div>
                        <div class="card-body">
                            <form method="post" id="form_profile">

                                <div class="row gx-3 mb-3">

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Email</label>
                                        <input class="form-control" id="inputOrgName" type="text" value="<?php echo $row['email'] ?>" aria-label="Disabled input example" disabled readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Số điện thoại</label>
                                        <input class="form-control" id="inputLocation" type="text" value="<?php echo $row['number'] ?>" disabled readonly>
                                    </div>
                                </div>



                                <div class="row gx-3 mb-3">

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Số Căn Cước</label>
                                        <input class="form-control" id="inputPhone" type="tel" value="<?php
                                                $firstString = substr($row['id_number'], 0, 4);
                                                $lastString = substr($row['id_number'], 8);

                                                $remainingChars = strlen($row['id_number']) - 8;
                                                $replacement = str_repeat('*', $remainingChars);
                                                echo $firstString . $replacement.$lastString;                                                         
                                            ?>" disabled readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Birthday</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" value="<?php echo $row['birthdate'] ?>" disabled readonly>
                                    </div>
                                </div>
                                <div class="row gx-3 mb-3 mt-4">
                                    <div class="col-md-6">
                                        <label for="status" style="font-weight: bold;">Trạng thái: </label>
                                        <span id="status"></span>
                                    </div>
                                </div>


                                <button class="btn btn-primary btn-change" id="showChange" type="button" onclick="showChangePasswordForm()">Đổi mật khẩu</button>


                            </form>
                            <form action="" method="post" id="change_password_form" style="display: none;">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-change" id="changeInfo" type="button" onclick="saveNewPassword()">
                                        <ion-icon name="arrow-back-outline"></ion-icon>
                                        <span style="letter-spacing: 1px;">Thông tin chi tiết</span>
                                    </button>
                                </div>
                                <div class="d-flex flex-column gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" id="lableOld" for="oldPassword">Mật khẩu cũ</label>
                                        <input class="form-control" id="oldPassword" type="password" name="oldPassword">
                                    </div>
                                    <div class="col-md-6">

                                        <label class="small mb-1" for="newPassword">Mật khẩu mới</label>
                                        <input class="form-control" id="newPassword" type="password" name="newPassword">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" id="lableCofirm" for="confirmPassword">Xác nhận mật khẩu</label>
                                        <input class="form-control" id="confirmPassword" type="password" name="confirmPassword">
                                    </div>
                                    <!-- Thêm các trường nhập mật khẩu khác nếu cần -->
                                </div>
                                <!-- Nút "Lưu mật khẩu mới" -->
                                <button class="btn btn-primary btn-change" id="submitForm" type="button" name="submit" value="submitform" style="margin-left: 15px;">Lưu mật khẩu mới</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="orderUser" role="tabpanel" aria-labelledby="orderUser-tab">
                <p>Chưa có đơn hàng nào</p>
                
            </div>
        </div>
        <!-- <hr class="mt-0 mb-4"> -->

    </div>
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
    <script>
        function showChangePasswordForm() {
            // Ẩn form thông tin cá nhân
            document.getElementById('form_profile').style.display = 'none';
            // Hiển thị form đổi mật khẩu
            document.getElementById('change_password_form').style.display = 'block';

        }

        function saveNewPassword() {
            // Xử lý việc lưu mật khẩu mới ở đây
            // Sau khi lưu xong, bạn có thể hiển thị lại form thông tin cá nhân và ẩn form đổi mật khẩu
            $("#oldPassword").val("")
            $("#newPassword").val("")
            $("#confirmPassword").val("")
            document.getElementById('form_profile').style.display = 'block';
            document.getElementById('change_password_form').style.display = 'none';
        }
    </script>
    <!-- <script src="js/main.js"></script> -->
    <script src="js/main_nosroll.js"></script>
    <script src="js/profile.js"></script>
</body>

</html>