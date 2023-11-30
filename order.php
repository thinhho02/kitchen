<?php
global $con;
session_start();
include 'connect/connect.php';

if (!isset($_COOKIE['receipt'])) {
	header("location: cart.php");
}

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
	<title>Thanh Toán</title>
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
<style>
	@import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);

	body{
		color: black;
	}

	.mt-100 {
		margin-top: 10px;
	}

	.mb-100 {
		margin-bottom: 30px;
	}

	.card {
		border-radius: 1px !important;
	}

	.card-header {

		background-color: #fff;
	}

	.card-header:first-child {
		border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
	}

	.btn-sm,
	.btn-group-sm>.btn {
		padding: .25rem .5rem;
		font-size: .765625rem;
		line-height: 1.5;
		border-radius: .2rem;
	}
	.table-responsive-sm { overflow-x: scroll; }
	@media screen and (min-width: 769px){
		.table-responsive-sm { overflow: hidden; }
	}
    /* .table-responsive-sm .table-striped th, td { min-width: 200px; } */
</style>

<body>
	<!-- Get ID -->
	<input type="hidden" name="getId" id="getId" value="<?php echo $id; ?>">
	<!-- Get ID -->

	<!-- Start main -->
	<div class="container mt-100 mb-100">
		<div id="ui-view">
			<div>
				<div class="card">
					<div class="card-header">
						<a href="./" class="btn btn-primary">Trở về trang thực đơn</a>
					</div>
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-sm-4 mb-4 user">
								<h5 class="mb-3"><b>Thông tin người đặt:</b></h5>
								<div><b>Tên :</b> <span class="user_name"><?php echo $row['full_name'] ?></span> - <span class="user_id"><?php echo $id ?></span></div>
								<div><b>Email :</b> <span class="email"><?php echo $row['email']?></span></div>
								<div><b>Số điện thoại :</b> <span class="number"><?php echo $row['number']?></span></div>
							</div>
							<div class="col-sm-4 mb-4 receipt">
								<h5 class="mb-3"><b>Thông tin đơn hàng:</b></h5>
								
								<div class="receipt"><b>Mã đơn hàng :</b> #<span class="receipt_id"></span></div>
								<div><b>Ngày Đặt :</b> <span class="date_receipt"></span></div>
								<div><b>Trạng thái :</b> <span class="status_receipt"></span></div>
							</div>
						</div>

						<div class="table-responsive-sm">
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
						<div class="row mt-3">
							<div class="col-lg-4 col-sm-6">
								<h6><b>Ghi Chú :</b></h6>
								<span class="note"></span>
							</div>
							<div class="col-lg-4 col-sm-6 ml-auto">
								<table class="table table-clear">
									<tbody>
										<tr>
											<td class="left"><strong>Tổng tiền</strong></td>
											<td class="right subtotal"></td>
										</tr>
										<tr>
											<td colspan="2" class="alert alert-danger"><p style="margin-bottom: 0;"><b>Đơn hàng có thể hủy trước ngày đặt món</b></p></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>





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
	<!-- <script src="js/main.js"></script> -->
	<script src="js/main_nosroll.js"></script>
	<script src="js/order.js"></script>
</body>

</html>