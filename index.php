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
	<title>Menu</title>
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
	<link rel="Shortcut Icon" type="image/png" href="image/icons8-restaurant-bubbles-96.png">

</head>

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
					<a href="login/logout.php?id=<?php echo $_SESSION['employee_id'] ?>" class="link-profile">
						<div class="nav align-items-center profile-info" style="color: black">
							<div class="icon-profile">
								<div class="rounded-circle d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; background-color: #887777;">
									<ion-icon name="log-out-outline"></ion-icon>
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
				<li class="nav-item active"><a href="./" class="nav-link">thực đơn</a></li>
				<li class="nav-item"><a href="cart.php" class="nav-link">Giỏ Hàng</a></li>
			</ul>
		</div>
	</nav>
	<!-- END Header -->


	<!-- Start Slide Show -->
	<section class="hero-wrap">
		<div class="home-slider owl-carousel js-fullheight">
			<div class="slider-item js-fullheight" style="background-image:url(images/bg_1.jpg);">
				<div class="overlay"></div>
				<div class="container">
					<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
						<div class="col-md-12 ftco-animate">
							<div class="text w-100 mt-5 text-center">
								<span class="subheading">Taste.it Restaurant</h2></span>
								<h1>Cooking Since</h1>
								<span class="subheading-2">1958</span>
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
								<span class="subheading">Taste.it Restaurant</h2></span>
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
	<section class="ftco-section">
		<div class="container menu-food">
			<!-- START Menu -->
			<div class="d-flex flex-column justify-content-center mb-5 pb-2">
				<div class="col-md-12 text-center heading-section ftco-animate">
					<span class="subheading">Specialties</span>
					<h2 class="mb-4">Our Menu</h2>
				</div>
			</div>
			<div class="tab-content pill-tabContent">
				<div class="tab-pane fade show active">
					<div class="col-md-12 col-lg-6 col-xl-6">
						<div class="menu-wrap">
							<div class="menus ftco-animate">
								<div class="link-addNow">
									<a href="#" class="btn addNow">Đặt ngay</a>
								</div>
								<a href="" class="d-flex">
									<div class="menu-img img" style="background-image: url(images/breakfast-1.jpg);"></div>
									<div class="text">
										<div class="d-flex">
											<div class="one-half">
												<h3>Combo 1</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</div>
										<p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
									</div>
								</a>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							<div class="menus ftco-animate">
								<div class="link-addNow">
									<a href="" class="btn addNow">Đặt ngay</a>
								</div>
								<a href="" class="d-flex">
									<div class="menu-img img" style="background-image: url(images/lunch-2.jpg);"></div>
									<div class="text">
										<div class="d-flex">
											<div class="one-half">
												<h3>Combo 5</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</div>
										<p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
									</div>
								</a>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							<div class="menus ftco-animate">
								<div class="link-addNow">
									<a href="" class="btn addNow">Đặt ngay</a>
								</div>
								<a href="" class="d-flex">
									<div class="menu-img img" style="background-image: url(images/breakfast-3.jpg);"></div>
									<div class="text">
										<div class="d-flex">
											<div class="one-half">
												<h3>Combo 3</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</div>
										<p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
									</div>
								</a>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							<span class="flat flaticon-breakfast" style="right: 0;"></span>

						</div>
					</div>

					<div class="col-md-12 col-lg-6 col-xl-6">
						<div class="menu-wrap">
							<div class="menus ftco-animate">
								<div class="link-addNow">
									<a href="" class="btn addNow">Đặt ngay</a>
								</div>
								<a href="" class="d-flex">
									<div class="menu-img img" style="background-image: url(images/lunch-1.jpg);"></div>
									<div class="text">
										<div class="d-flex">
											<div class="one-half">
												<h3>Combo 4</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</div>
										<p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
									</div>
								</a>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							<div class="menus d-flex ftco-animate">
								<div class="link-addNow">
									<a href="" class="btn addNow">Đặt ngay</a>
								</div>
								<a href="" class="d-flex">
									<div class="menu-img img" style="background-image: url(images/lunch-2.jpg);"></div>
									<div class="text">
										<div class="d-flex">
											<div class="one-half">
												<h3>Combo 5</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</div>
										<p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
									</div>
								</a>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							<div class="menus ftco-animate">
								<div class="link-addNow">
									<a href="" class="btn addNow">Đặt ngay</a>
								</div>
								<a href="" class="d-flex">
									<div class="menu-img img" style="background-image: url(images/lunch-2.jpg);"></div>
									<div class="text">
										<div class="d-flex">
											<div class="one-half">
												<h3>Combo 5</h3>
											</div>
											<div class="one-forth">
												<span class="price">29,000đ</span>
											</div>
										</div>
										<p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
									</div>
								</a>
								<div class="add-cart">

									<a href="" class="btn link-add">Thêm giỏ hàng</a>
								</div>
							</div>
							<span class="flat flaticon-chicken" style="right: 0;"></span>
						</div>
					</div>
				</div>
			</div>
			<!-- END MENU -->

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
								<button type="button" id="tab<?php echo $row['id'] ?>-menu" class="btn-cate nav-link" data-bs-toggle="tab" data-bs-target="#tab-<?php echo $row['id'] ?>" aria-controls="tab-<?php echo $row['id'] ?>" aria-selected="true" name="<?php echo $row['name'] ?>" value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?>

								</button>
							</li>
						<?php
						}
						?>
					</ul>
				</div>
				<div class="col-md-12 ftco-animate input_date">

					<div class="form-group">
						<input type="date" name="date" id="date" placeholder="">
					</div>

				</div>
			</div>
			<div class="tab-content pill-tabContent">
				<?php
				$select_cate = mysqli_query($con, "SELECT * FROM `categories`");
				while ($row_cate = mysqli_fetch_assoc($select_cate)) {
				?>
					<div class="tab-pane tab-food fade" id="tab-<?php echo $row_cate['id'] ?>">
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