<?php
session_start();
include '../../connect/connect.php';
if (isset($_POST["import"])) {
    $maxFileSize = 10 * 1024 * 1024;
    $allowedExtensions = ['xls', 'xlsx', 'csv'];

    $fileName = $_FILES["excel"]["name"];
    $fileSize = $_FILES["excel"]["size"];
    if ($fileSize > $maxFileSize) {
        $_SESSION['status'] = "failure";
        $_SESSION['message'] = "Kích thước file quá lớn. Hãy chọn file nhỏ hơn 10MB!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['status'] = "failure";
        $_SESSION['message'] = "Loại file không hợp lệ. Hãy chọn lại file excel (.csv, .xlsx, .xls)";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $newFileName = date("Y-m-d") . " - " . date("h-i-sa") . "." . $fileExtension;
    $targetDirectory = "upload_tmp/" . $newFileName;
    move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDirectory);
    error_reporting(0);
    ini_set('display_errors', 0);

    require "../../utils/excel/excel_reader2.php";
    require "../../utils/excel/SpreadsheetReader.php";


    $reader = new SpreadsheetReader($targetDirectory);
    $successfulInserts = 0;
    foreach ($reader as $key => $row) {
        $name = $row[0];
        $unit = $row[1];
        $price = $row[2];
        $sql = "INSERT INTO resources (id, name, unit, price) VALUES (NULL, '$name', '$unit', '$price')";
        if (!mysqli_query($con, $sql)) {
            break;
        }
        $successfulInserts++;

    }
    mysqli_close($con);

    // delete file
    unlink($targetDirectory);

    // notify
    if ($successfulInserts > 0) {
        $_SESSION['status'] = "success";
        $_SESSION['message'] = "Thêm thành công $successfulInserts nguyên liệu!";
    }else{
        $_SESSION['status'] = "failure";
        $_SESSION['message'] = "Đã có lỗi xảy ra. Hãy thủ lại sau";
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");
}