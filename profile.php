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
                <li class="nav-item"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
            </ul>
        </div>
    </nav>



    <div class="container-xl px-4" style="padding-top: 6.5rem !important;margin-bottom: 6.5rem !important; flex: 1;">
        <ul class="nav nav-tabs" id="myTabProfile" role="tablist" style="margin-bottom: 50px">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profileUser" type="button" role="tab" aria-controls="profileUser" aria-selected="true">Thông tin cá nhân</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#orderUser" type="button" role="tab" aria-controls="orderUser" aria-selected="false">Lịch sử đơn hàng</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="debt-tab" data-bs-toggle="tab" data-bs-target="#debtUser" type="button" role="tab" aria-controls="debtUser" aria-selected="false">Thanh toán</button>
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
                                                                                                        echo $firstString . $replacement . $lastString;
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
                <div class="col-sm-12">
                    
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chi tiết đơn hàng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="center" style="min-width: 40px;">#</th>
                                                    <th style="min-width: 225px;">Tên món</th>
                                                    <th class="center" style="min-width: 108px;">Số lượng</th>
                                                    <th class="right" style="min-width: 132px;">Giá</th>
                                                    <th class="right" style="min-width: 143px;">Tổng tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody class="receipt_detail">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="d-flex justify-content-end" style="color: black; font-size: 18px">
                                    <div><b>Tổng tiền:</b><span class="mx-2 modal_total"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="debtUser" role="tabpanel" aria-labelledby="debtUser-tab">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tổng tiền trong tháng</th>
                                    <th scope="col">Tháng/Năm</th>
                                </tr>
                            </thead>
                            <tbody class="pay_body">


                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center justify-content-end border-top py-3" id="checkout-payment">
                        <div class="d-flex align-items-center"><span class="px-3">Thanh toán: </span> <span class="total_debt">0 VNĐ</span></div>
                        <button class="btn btn-primary mx-5 btn_checkout">
                            Thanh toán
                        </button>
                    </div>


                </div>

            </div>
        </div>
        <!-- debtUser -->

    </div>
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