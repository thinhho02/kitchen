<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data_login = [];
if (isset($_REQUEST['submit_check']) && $_REQUEST['submit_check'] === 'Tiếp tục') {
    $otp = $_SESSION['email'];
    $check = mysqli_real_escape_string($con, $_POST["check_otp"]);
    if ($check != '') {
        if ($check == $otp) {
            $data_login = ["success" => "Xác thực thành công"];
            unset($_SESSION['email']);
        } else {
            $data_login = ["message" => "Mã xác thực không chính xác"];
        }
    } else {
        $data_login = ["message" => "Nhập mã xác thực"];
    }
    echo json_encode($data_login, true);
}

