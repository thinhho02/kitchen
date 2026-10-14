<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}

$result = $con->query("SELECT * FROM menu");

// định dạng
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="menu_data.csv"');
header('Cache-Control: max-age=0');

// Mở tệp tin để ghi
$output = fopen('php://output', 'w');

// Ghi tiêu đề cột vào file CSV
fputcsv($output, array('ID', 'Tên Món', 'Giá', 'Ngày Tạo'));

// Ghi dữ liệu từ cơ sở dữ liệu vào file CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit();
?>
