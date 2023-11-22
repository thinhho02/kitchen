<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data = [];
if(isset($_REQUEST['submit']) && $_REQUEST['submit'] !== ''){
    if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ''){
        if(isset($_POST['old_pass']) && $_POST['old_pass'] !== '' && 
        isset($_POST['new_pass']) && $_POST['new_pass'] !== '' && 
        isset($_POST['confirm_pass']) && $_POST['confirm_pass'] !== '')
        {
            $id = $_REQUEST['id'];
            $oldPass = mysqli_real_escape_string($con, $_POST['old_pass']);
            // $status = $_POST['statusUser'];
            if($select = mysqli_query($con ,"SELECT * FROM `employees` WHERE `employee_id` = '$id'")){
                // $select = mysqli_query($con, "SELECT `status` FROM `employees` WHERE `employee_id` = '$id'");
                $row = mysqli_fetch_assoc($select);
                if(password_verify($oldPass, $row['password'])){
                    $newPass = mysqli_real_escape_string($con, $_POST['new_pass']);
                    $hash_pass = password_hash($newPass, PASSWORD_ARGON2I);
                    $confirmPass = mysqli_real_escape_string($con, $_POST['confirm_pass']);
                    if($newPass === $confirmPass){
                        mysqli_query($con, "UPDATE `employees` SET `password` = '$hash_pass' WHERE `employee_id` = '$id'");
                        $data = ["success" => "Thay đổi mật khẩu thành công", "status" => "changed"];
                    }else{
                        $data = ["confirm" => "Mật khẩu không trùng khớp"];
                    }
                    
                }else{
                    $data = ["oldpass" => "Mật khẩu không chính xác"];
                }
                
            }else{
                $data = ["message" => "Kết nối thất bại"];
            }
        }else{
            $data = ["message" => "Vui lòng nhập đầy đủ thông tin"];
        }
        
        // $status = $_POST['statusUser'];
        // $data = ["status" => $status];
        
    }else{
        $data = ["error" => "Vô đây chi"];
    }
}else{
    $data = ["error" => "Vô đây chi"];
}

echo json_encode($data, true);
