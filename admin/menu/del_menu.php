<?php
session_start();
include '../../connect/connect.php';
if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

$menu_id = $_GET['id'];

$sql = "DELETE FROM menu WHERE menu_id='$menu_id'";

if ($con->query($sql) === TRUE) {
    header("Location: add_menu.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}


// // Kiểm tra xem có bản ghi tương ứng trong menu_list không
// $check_sql = "SELECT * FROM menu_list WHERE menu_id='$menu_id'";
// $result = $con->query($check_sql);

// if ($result->num_rows > 0) {
//     // Có bản ghi trong menu_list, xử lý xóa chúng trước khi xóa từ menu
//     $delete_menu_list_sql = "DELETE FROM menu_list WHERE menu_id='$menu_id'";
//     if ($con->query($delete_menu_list_sql) !== TRUE) {
//         echo "Error deleting menu_list records: " . $con->error;
//         exit();
//     }
// }

// // Tiếp tục xóa từ menu
// $sql = "DELETE FROM menu WHERE menu_id='$menu_id'";
// if ($con->query($sql) === TRUE) {
//     // Chuyển hướng về trang menu sau khi xóa
//     header("Location: add_menu.php");
//     exit();
// } else {
//     echo "Error deleting menu: " . $con->error;
// }

?>
