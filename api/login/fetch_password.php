<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data_login = [];
if (isset($_REQUEST['submit_change']) && $_REQUEST['submit_change'] === 'change') {
    $passNew = mysqli_real_escape_string($con, $_POST['passnew']);
    $passNew_encode = password_hash($passNew, PASSWORD_ARGON2I); // Mã hóa
    $passNewConfirm = mysqli_real_escape_string($con, $_POST['check_passnew']);
    $userId = $_SESSION['employee_id_check'];
    $select = mysqli_query($con, "SELECT * FROM `employees` where `employee_id` = '$userId'");
    if (mysqli_num_rows($select) > 0) {
        if ($passNew != '' && $passNewConfirm != '') {
            if ($passNew != $passNewConfirm) {
                $data_login = ["message" => "Mật khẩu không trùng khớp"];
            } else {
                mysqli_query($con, "UPDATE `employees` SET `password`='$passNew_encode' WHERE `employee_id` = '$userId';");
                $data_login = ["success" => "Thay đổi mật khẩu thành công"];

                unset($_SESSION['employee_id_check']);
            }
        } else {
            $data_login = ["message" => "Nhập thông tin đầy đủ"];
        }
    } else {
        $data_login = ["error" => "lỗi client"];
    }

    echo json_encode($data_login, true);
}
