<?php
session_start();
include '../connect/connect.php';
$id = $_SESSION['employee_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/style.css" rel="stylesheet" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Custom styles for this template -->
    <link href="assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="assets/jquery-1.11.3.min.js"></script>
    <link rel="Shortcut Icon" type="image/png" href="../image/icons8-restaurant-bubbles-96.png">


</head>
<style>
    body {
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f1f1f1;
    }

    .header {
        margin-bottom: 50px;
        /* color: green; */
        font-size: 26px;
        /* text-transform: uppercase; */
        font-weight: bold;
    }

    .header ion-icon {
        /* outline: 2px solid green; */
        font-size: 60px;
    }

    .form-group label {
        width: 150px;
    }

    @media screen and (max-width: 770px) {
        .header span {
            font-size: 20px;
        }

        .header ion-icon {
            /* outline: 2px solid green; */
            font-size: 50px;
        }
    }
</style>

<body>
    <?php
    require_once("./config.php");
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    ?>



    <div class="container border" style="padding: 80px 0;">
        <div class="d-flex flex-column align-items-center">
            <div class="d-flex flex-column align-items-center py-3 header">
                <?php
                if ($secureHash == $vnp_SecureHash) {
                    if ($_GET['vnp_ResponseCode'] == '00') {
                        $trading_code = $_GET['vnp_TxnRef'];
                        $update_pay = mysqli_query($con, "UPDATE `payment` SET `payment_method`='vnpay',`status`= true WHERE `trading_code`='$trading_code'");
                        if ($update_pay === true) {
                            $select_pay = mysqli_query($con, "SELECT `total` FROM `payment` WHERE `employee_id` = '$id' and  `status` = false ");
                            if (mysqli_num_rows($select_pay) > 0) {
                                $sum = 0;
                                while ($row_receipt = mysqli_fetch_assoc($select_pay)) {
                                    $sum += $row_receipt['total'];
                                }
                                mysqli_query($con, "UPDATE `employees` SET `debt`= $sum WHERE `employee_id` = '$id'");
                            }else{
                                mysqli_query($con, "UPDATE `employees` SET `debt`= 0 WHERE `employee_id` = '$id'");
                            }
                        }
                        echo "<ion-icon name='checkmark-circle-outline' style='color:green;'></ion-icon>
                                <span style='color:green;'>THANH TOÁN THÀNH CÔNG</span>";
                    } else {
                        echo "<ion-icon name='close-circle-outline' style='color:red;'></ion-icon>
                                <span style='color:red;'>THANH TOÁN KHÔNG THÀNH CÔNG</span>";
                    }
                } else {
                    echo "<span style='color:red'>Chu ky khong hop le</span>";
                }

                ?>

            </div>
            <div class="d-flex flex-column my-3">
                <div class="form-group">
                    <label>Mã hóa đơn: </label>
                    <b>#<?php echo $_GET['vnp_TxnRef'] ?></b>
                </div>
                <div class="form-group">
                    <label>Tổng tiền: </label>
                    <b><?php $price = $_GET['vnp_Amount'] / 100;
                        echo number_format($price, 0, ',');  ?> VNĐ</b>
                </div>

                <div class="form-group">
                    <label>Kiểu thanh toán: </label>
                    <b>Ví điện tử</b>
                </div>
                <div class="form-group">
                    <label>Thời gian: </label>
                    <b><?php echo date("Y-m-d H:i:s", strtotime($_GET['vnp_PayDate']))  ?></b>
                </div>
            </div>
            <div>
                <a href="../" class="btn btn-primary">Quay về trang menu</a>
            </div>
        </div>
    </div>
    <!--Begin display -->


    </div>
</body>

</html>