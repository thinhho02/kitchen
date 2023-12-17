<?php
session_start();
include '../../connect/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maxFileSize = 3 * 1024 * 1024;
    $allowedExtensions = ['jpeg', 'jpg', 'png'];

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    if ($fileSize > $maxFileSize) {
        $_SESSION['status'] = 'failure';
        $_SESSION['message'] = 'Kích thước ảnh quá  lớn. Hãy chọn ảnh nhở hơn 3mb!';
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['status'] = "failure";
        $_SESSION['message'] = "Loại file không hợp lệ. Hãy chọn lại file ảnh (.jpeg, .jpg, .png)";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $newFileName = date("Y-m-d") . "-" . date("h-i-sa") . "." . $fileExtension;
    $targetDirectory = "../../image/" . $newFileName;

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetDirectory)) {
        $_SESSION['status'] = 'failure';
        $_SESSION['message'] = 'Đã có lỗi xảy ra. Không thể lưu tệp ảnh.';
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $image = $newFileName;
    $quantity = 1;
    $sql = "INSERT INTO `dishes`(`dish_id`, `category_id`, `name`, `image`, `price`, `description`, `is_approved`, `remove`, `created_time`, `updated_time`) VALUES (NULL,'$category','$name','$image','$price','$description',0,0,current_timestamp(),current_timestamp())";
    $isSuccess = mysqli_query($con, $sql);
    mysqli_close($con);

    $_SESSION['status'] = $isSuccess ? 'success' : 'failure';
    $_SESSION['message'] = $isSuccess ? 'Đề xuất thành công!' : 'Đã có lỗi xảy ra. Đề xuất không thành công!';
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
