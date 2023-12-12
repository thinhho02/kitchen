<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/kitchen/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/kitchen/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/kitchen/phpmailer/src/SMTP.php';

if (isset($_REQUEST['submit_forget']) && $_REQUEST['submit_forget'] === 'Gửi mã xác thực') {

    $email = mysqli_real_escape_string($con, $_POST['check']);
    if ($email === '') {
        $data_forget = ["message" => "Vui lòng nhập Email!"];
    } else {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $select = mysqli_query($con, "SELECT * FROM `employees` where `email` = '$email';") or die("select failed");
            if (mysqli_num_rows($select) > 0) {
                $row = mysqli_fetch_assoc($select);
                $_SESSION['employee_id_check'] = $row["employee_id"];

                $otp = rand(100000, 999999);

                $_SESSION['email'] = $otp;


                

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;

                $mail->Username = "hothinh9234@gmail.com";
                $mail->Password = "shqhoxdpctdmfiwa";
                $mail->SMTPSecure = 'tls';

                $mail->Port = 587;

                $mail->setFrom("hothinh9234@gmail.com");
                $mail->addAddress($email);

                $mail->isHTML(true);

                $mail->Subject = "Verification Code";
                $mail->Body = "mã code : $otp";
                // $mail->Body = $html;
                try {
                    $mail->send();
                    $data_forget = ["status" => "success", "userId" => $row["employee_id"], "email_user" => $_POST['check']];
                } catch (Exception $e) {
                    $data_forget = ["e" => $mail->ErrorInfo, "status" => "fail"];
                }
            } else {

                $data_forget = ["message" => "Không tìm thấy Email!"];
            }
        } else {

            $data_forget = ["message" => "Email không hợp lệ!"];
        }
    }
} else {
    $data_forget = ["error" => "Lỗi 404 not found"];
}
echo json_encode($data_forget, true);
