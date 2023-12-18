<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);

if (isset($_POST['submit'])) {
    $api_key = 'b990ef90090947968e8191c56b855318';
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $ch = curl_init();

    // Set the URL that you want to GET by using the CURLOPT_URL option.
    curl_setopt($ch, CURLOPT_URL, 'https://emailvalidation.abstractapi.com/v1/?api_key=' . $api_key . '&email=' . $email . '');

    // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Execute the request.
    $data = curl_exec($ch);

    // Close the cURL handle.
    curl_close($ch);
    // json data
    $result = json_decode($data, true);
    if ($result['deliverability'] === 'UNDELIVERABLE') {
        echo '<script>
        alert("Không tìm thấy email!!!")
        </script>';
    } elseif ($result['is_disposable_email']['value'] === true) {
        echo '<script>
        alert("Không tìm thấy tên miền!!!")
        </script>';
    } else {
        if (isset($_FILES['avatar'])) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("Y-m-d-h-i-s");
            $image_first = $_FILES['avatar']['name'];
            $tmp_imgae_first =  $_FILES['avatar']['tmp_name'];
            // $errors = array();

            $extension = array("jpeg", "jpg", "png");
            $UploadFolder = "../../image/";

            $ext = pathinfo($image_first, PATHINFO_EXTENSION);

            if (in_array($ext, $extension) === false) {
                // echo $image_first.'file không được phép. Chỉ chấp nhận các định dạng JPG, JPEG, PNG';
                echo "<script>
                alert('File $image_first không đúng định dạng cho phép. Chỉ chấp nhận các định dạng JPG, JPEG, PNG!! OK ???')
                </script>";
            } else {
                move_uploaded_file($tmp_imgae_first, $UploadFolder . $image_first);
                $first_img = $image_first;
                $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
                $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
                $phone = mysqli_real_escape_string($con, $_POST['phone']);
                $id_nv = 'NV' . rand(100000, 999999);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $idcard = mysqli_real_escape_string($con, $_POST['idcard']);
                $date = mysqli_real_escape_string($con, $_POST['date']);
                $roles = $_POST['roles'];
                $hash_pass = password_hash($password, PASSWORD_ARGON2I);
                $format_date = date('Y-m-d', strtotime($date));
                // $in_valid = mysqli_query($con, "SELECT * FROM `employees` WHERE `email` = '$email' or `number` = '$phone'");
                $in_valid_email = mysqli_query($con, "SELECT * FROM `employees` WHERE `email` = '$email'");
                $in_valid_phone = mysqli_query($con, "SELECT * FROM `employees` WHERE `number` = '$phone'");
                if (mysqli_num_rows($in_valid_email) > 0) {
                    echo "<script>
                    alert('Đã tồn tại email!');
                </script>";
                } elseif (mysqli_num_rows($in_valid_phone) > 0) {
                    echo "<script>
                    alert('Đã tồn tại số điện thoại!');
                </script>
                ";
                } else {
                    mysqli_query($con, "INSERT INTO `employees`(`employee_id`, `first_name`, `last_name`,`avatar`, `number`, `email`, `password`, `id_number`, `birthdate`,`debt`,`status`,`roles`) 
                    VALUES ('$id_nv','$firstname','$lastname','$first_img','$phone','$email','$hash_pass','$idcard','$format_date',0,0,'$roles')");
                    echo "<script>
                    alert('Tạo tài khoản thành công!');
                </script>
                ";
                }
            }
        } else {
            echo "<script>
                    alert('Vui lòng chọn avatar!');
                </script>
                ";
        }
    }
    // Print the data out onto the page.
    //  echo var_dump($result);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo tài khoản nhân viên</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<style>
    body {
        /* display: flex;
        justify-content: center;
        align-items: center; */
        min-height: 100vh;
        color: black;
        overflow: hidden;
    }

    h5 {
        font-size: 19px !important;
        font-weight: 600 !important;
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 430px;
        background-color: #fff;
        padding: 10px 25px;
        border-radius: 20px;
        position: relative;
    }

    .title {
        font-family: 'Work-san';
        font-size: 28px;
        color: royalblue;
        font-weight: 600;
        letter-spacing: -1px;
        position: relative;
        display: flex;
        align-items: center;
        padding-left: 30px;
    }

    .title::before,
    .title::after {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        border-radius: 50%;
        left: 0px;
        background-color: royalblue;
    }

    .title::before {
        width: 18px;
        height: 18px;
        background-color: royalblue;
    }

    .title::after {
        width: 18px;
        height: 18px;
        animation: pulse 1s linear infinite;
    }

    .message,
    .signin {
        color: rgba(88, 87, 87, 0.822);
        font-size: 18px;
    }

    .signin {
        text-align: center;
    }

    .signin a {
        color: royalblue;
    }

    .signin a:hover {
        text-decoration: underline royalblue;
    }

    .flex {
        display: flex;
        width: 100%;
        gap: 6px;
    }

    .form label {
        position: relative;
    }

    .form label .input {
        width: 100%;
        padding: 6px 9px 10px 9px;
        outline: 0;
        border: 1px solid rgba(105, 105, 105, 0.397);
        border-radius: 10px;
    }

    .form label input[type="date"] {
        width: 100%;
        padding: 8px 9px 8px 9px;
        outline: 0;
        border: 1px solid rgba(105, 105, 105, 0.397);
        border-radius: 10px;
    }

    .form label .input+span {
        position: absolute;
        left: 10px;
        top: 10px;
        color: grey;
        font-size: 0.9em;
        cursor: text;
        transition: 0.2s ease;
    }

    .form label .input:placeholder-shown+span {
        top: 15px;
        font-size: 0.9em;
    }

    .form label .input:focus+span,
    .form label .input:valid+span {
        top: 26px;
        font-size: 0.7em;
        font-weight: 600;
    }

    .form label .input:valid+span {
        color: green;
    }

    .submit {
        border: none;
        outline: none;
        background-color: royalblue;
        padding: 10px;
        border-radius: 10px;
        color: #fff;
        font-size: 16px;
        transform: .3s ease;
    }

    .submit:hover {
        background-color: rgb(56, 90, 194);
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    @keyframes pulse {
        from {
            transform: scale(0.9);
            opacity: 1;
        }

        to {
            transform: scale(1.8);
            opacity: 0;
        }
    }
</style>



<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php
            include '../layouts/sidebar.php';
            ?>
            <div class="col-12 col-md-10 d-flex justify-content-center align-items-center">
                <form class="form border" method="post" action="" enctype="multipart/form-data">
                    <p class="title">Tạo tài khoản</p>
                    <div class="flex">
                        <label>
                            <input required="" placeholder="" name="firstname" type="text" class="input" autocomplete="off">
                            <span>Họ</span>
                        </label>

                        <label>
                            <input required="" placeholder="" name="lastname" type="text" class="input" autocomplete="off">
                            <span>Tên</span>
                        </label>
                    </div>
                    <label>
                        <input required="" placeholder="" name="phone" type="number" class="input" autocomplete="off">
                        <span>Số Điện Thoại</span>
                    </label>
                    <label>
                        <input required="" placeholder="" autocomplete="off" name="email" on type="email" class="input">
                        <span>Email</span>
                    </label>
                    <label>
                        <input required="" placeholder="" name="password" type="password" class="input">
                        <span>Password</span>
                    </label>
                    <label>
                        <input required="" placeholder="" name="idcard" type="number" class="input" autocomplete="off">
                        <span>CMND/CCCD</span>
                    </label>
                    <label>
                        <input required="" placeholder="" name="date" type="date" class="input">
                        <span></span>
                    </label>
                    <label class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" style="margin-bottom:0px;">Chức Vụ</label>
                    <select id="underline_select" name="roles" class="block py-2.5 px-1 w-full text-sm bg-transparent  hover:bg-gray-100 rounded-md border-gray-200 appearance-none  dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer" style="border: 1px solid rgba(105, 105, 105, 0.397);">
                        <option value="" hidden>Chọn chức vụ</option>
                        <option value="employee">Nhân Viên</option>
                        <option value="chef">Đầu Bếp</option>
                        <option value="deliver">Giao Hàng</option>
                    </select>
                    <div class="grid w-full items-center gap-1.5 mt-2">
                        <label class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" style="margin-bottom: 0px;">Hình Ảnh</label>
                        <input id="avatar" name="avatar" type="file" class="flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-sm file:font-medium" style="border: 1px solid rgba(105, 105, 105, 0.397);">
                    </div>
                    </label>
                    <input type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" name="submit" value="Tạo">

                </form>
            </div>

        </div>
    </div>
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/bootstrap-bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass("active")
            $("#add-account").addClass("active")
        })
    </script>
</body>

</html>