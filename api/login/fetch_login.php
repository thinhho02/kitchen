<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data_login = [];
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] === 'Đăng nhập') {
    $name = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);
    if ($name != '' && $pass != '') {
        if (filter_var($name, FILTER_VALIDATE_EMAIL)) {
            $query = mysqli_query($con, "select * from `employees` where `email` = '$name'") or die("connect failed");
            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                $pass_vertify = password_verify($pass, $row['password']);
                if ($pass_vertify && $row['roles'] === 'employee') {

                    $_SESSION['employee_id'] = $row['employee_id'];       // tài khoản nhân viên
                    $data_login = ["success" => "ok", "userId" => $row['employee_id'], "role" => $row['roles']];
                } elseif ($pass_vertify && $row['roles'] === 'manager') {

                    $_SESSION['employee_manager_id'] = $row['employee_id']; // tài khoản quản lý
                    $data_login = ["success" => "ok", "userId" => $row['employee_id'], "role" => $row['roles']];
                } elseif ($pass_vertify && $row['roles'] === 'deliver') {

                    $_SESSION['employee_deliver_id'] = $row['employee_id']; // tài khoản shipper
                    $data_login = ["success" => "ok", "userId" => $row['employee_id'], "role" => $row['roles']];
                } elseif ($pass_vertify && $row['roles'] === 'chef') {

                    $_SESSION['employee_chef_id'] = $row['employee_id']; // tài khoản nhà bếp
                    $data_login = ["success" => "ok", "userId" => $row['employee_id'], "role" => $row['roles']];
                } else {

                    $data_login = ["message" => "Sai email hoặc mật khẩu"];
                }
            } else {

                $data_login = ["message" => "Sai email hoặc mật khẩu"];
            }
        } else {
            $data_login = ["message" => "Email không hợp lệ"];
        }
    }
    else{
        $data_login = ["message" => "Nhập thông tin đầy đủ"];
    }

    echo json_encode($data_login, true);
}
// $query = mysqli_query($con, "select * from `employees`") or die("connect failed");
// while($row = mysqli_fetch_array($query)){
//     echo json_encode($row, true);
// }

