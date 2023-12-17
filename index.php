<?php
global $con;
session_start();

include 'connect/connect.php';
if (!isset($_SESSION['employee_id'])) {
	header("location: login/");
}
$id = $_SESSION['employee_id'];
$select = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
// if(mysqli_num_rows($select)===0) {header("location: login/");}
$row = mysqli_fetch_assoc($select);
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Menu</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Arimo&family=Pacifico&family=Poppins:wght@200;300&family=Public+Sans&family=Work+Sans&display=swap" rel="stylesheet">
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
	<link rel="Shortcut Icon" type="image/png" href="image/icons8-restaurant-bubbles-96.png">

</head>
<style>
	.table-responsive .table th,
	.table-responsive .table td {
		vertical-align: middle;
	}

	@media (min-width: 576px) {
		.modal-dialog {
			max-width: 980px;
			margin: 1.75rem auto;
		}
	}
</style>

<body>
	<!-- Get ID -->
	<input type="hidden" name="getId" id="getId" value="<?php echo $id; ?>">
	<!-- Get ID -->

	<!-- Start Header  -->
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="./">Dream</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav1" aria-controls="ftco-nav1" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>

			<div class="navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">

					<li class="nav-item active"><a href="./" class="nav-link">Thực đơn</a></li>
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
							<span class="name" style="font-size: 23px;font-family: 'Poppin';letter-spacing: 0.5px;"><?php echo $row['full_name']; ?></span>
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
				<li class="nav-item active"><a href="./" class="nav-link">thực đơn</a></li>
				<li class="nav-item"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
			</ul>
		</div>
	</nav>
	<!-- END Header -->
	<!-- Button trigger modal -->


	<!-- Start Slide Show -->
	<section class="hero-wrap">
		<div class="home-slider owl-carousel js-fullheight">
			<div class="slider-item js-fullheight" style="background-image:url(images/bg_1.jpg);">
				<div class="overlay"></div>
				<div class="container">
					<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
						<div class="col-md-12 ftco-animate">
							<div class="text w-100 mt-5 text-center">
								<span class="subheading">Dream Company</h2></span>
								<h1>Cooking Since</h1>
								<span class="subheading-2">2021</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="slider-item js-fullheight" style="background-image:url(images/bg_2.jpg);">
				<div class="overlay"></div>
				<div class="container">
					<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
						<div class="col-md-12 ftco-animate">
							<div class="text w-100 mt-5 text-center">
								<span class="subheading">Dream Company</h2></span>
								<h1>Best Quality</h1>
								<span class="subheading-2 sub">Food</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- END Slide Show -->

	<!-- Start Main -->
	<section class="ftco-section" style="flex: 1;">
		<div class="container menu-food">
			<!-- START Menu -->
			<div class="d-flex flex-column justify-content-center mb-5 pb-2">
				<div class="col-md-12 text-center heading-section ftco-animate">
					<span class="subheading">Specialties</span>
					<h2 class="mb-4">Our Menu</h2>
				</div>
				<div class="col-md-12 ftco-animate input_date">
					<div class="form-group">
						<input type="date" class="date" name="date_menu" id="date_menu" placeholder="">
					</div>
				</div>
			</div>

			<div class="tab-content pill-tabContent">
				<div class="tab-pane fade show active" id="tab-menu" style="height: 60px;">
					<div class="col-md-12 col-lg-6 col-xl-6">
						<div class="menu-wrap">

							<!-- <div class="menus ftco-animate">
								<div class="link-addNow">
									<button type="button" class="btn addNow">Đặt ngay</button>
								</div>
								<div class="d-flex">
									<div class="image_menu btn-modal" type="button">
										<div class="menu-img img" style="background-image: url(images/lunch-2.jpg);"></div>
									</div>
									<div class="text">
										<a href="" class="d-flex">
											<div class="one-half">
												<h3>Combo 5</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</a>
										<p><a href="">Meat</a>, <a href="">Potatoes</a>, <a>Rice</a>, <a>Tomatoe</a></p>
									</div>
								</div>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							
							<span class="flat flaticon-breakfast" style="right: 0;"></span> -->

						</div>
					</div>

					<div class="col-md-12 col-lg-6 col-xl-6">
						<div class="menu-wrap">

						</div>
					</div>
				</div>
			</div>
			<!-- END MENU -->

			<!-- Modal -->
			<div class="modal fade" id="modelId" style="padding-right: 0;" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" style="font-size: 25px; color: black;">Chi tiết món ăn</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" style="font-size: 35px;">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th scope="col" style="min-width: 50px;">#</th>
												<th scope="col" style="min-width: 120px;">Hình ảnh</th>
												<th scope="col" style="min-width: 200px;">Tên món ăn</th>
												<th scope="col" style="min-width: 150px;">Loại món ăn</th>
												<th scope="col" style="min-width: 200px;">Nguyên liệu</th>
												<th scope="col" style="min-width: 160px;">Đánh giá</th>
											</tr>
										</thead>
										<tbody class="menu_modal">

										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- END MODAL -->

			<!-- Start Food -->

			<div class="d-flex flex-column justify-content-center mb-5 pb-2" style="margin-top: 100px;">
				<div class="col-md-12 text-center heading-section ftco-animate">
					<span class="subheading">Specialties</span>
					<h2 class="mb-4">Our Food</h2>
				</div>
				<div class="row justify-content-center nav-our-menu  ftco-animate">
					<ul class="col-md-12 justify-content-center nav nav-pills" id="mytab" style="gap: 10px" role="tablist">
						<?php
						$select = mysqli_query($con, "SELECT * FROM `categories`");
						while ($row = mysqli_fetch_assoc($select)) {
						?>

							<li class="nav-item" role="presentation">
								<button type="button" id="tab<?php echo $row['id'] ?>-menu" class="btn-cate nav-link"  data-bs-toggle="tab" data-bs-target="#tab-<?php echo $row['id'] ?>" aria-controls="tab-<?php echo $row['id'] ?>" aria-selected="true" name="<?php echo $row['name'] ?>" value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?>

								</button>
							</li>
						<?php
						}
						?>
					</ul>
				</div>
				<div class="col-md-12 ftco-animate input_date">

					<div class="form-group">
						<input type="date" class="date" name="date" id="date" placeholder="">
					</div>

				</div>
			</div>
			<div class="tab-content pill-tabContent">
				<?php
				$select_cate = mysqli_query($con, "SELECT * FROM `categories`");
				while ($row_cate = mysqli_fetch_assoc($select_cate)) {
				?>
					<div class="tab-pane tab-food fade" style="height: 60px;" id="tab-<?php echo $row_cate['id'] ?>">
						<div class="col-md-12 col-lg-6 col-xl-6">
							<div class="menu-wrap"></div>
						</div>
						<div class="col-md-12 col-lg-6 col-xl-6">
							<div class="menu-wrap"></div>
						</div>
					</div>
				<?php
				}
				?>
			</div>
			<!-- END Food -->
		</div>

	</section>
	<!-- END Main -->

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


	<!-- loader -->
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
	<script src="js/main.js"></script>
	<script src="js/main_nosroll.js"></script>
	<script src="js/menu.js"></script>
</body>

</html>