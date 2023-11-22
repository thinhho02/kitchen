<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data_menu = [];
if (isset($_REQUEST['btnvalue']) && isset($_REQUEST['date'])) {

    $date = $_REQUEST['date'];
    // $format_date = date('Y-d-m', strtotime($date));
    $cate = $_REQUEST['btnvalue'];
    // echo var_dump($_REQUEST['date']);
    // echo $date;
    // echo $cate;
    
        // echo $date;
        $select = mysqli_query($con, "SELECT `menu`.`menu_id`,`dishes`.`dish_id`,`dishes`.`name`,`dishes`.`image`,`dishes`.`description`,`menu`.`price`,`dishes`.`category_id`
                                        FROM `dishes` inner join `menu_list` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                        inner join `menu` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                        WHERE `menu`.`status` = 'food' and `menu`.`date` = $date
                                        and `dishes`.`is_approved` = true and `dishes`.`remove` = false and `dishes`.`category_id` = $cate") or die("connect failed");
        // echo $select;
        if (mysqli_num_rows($select) > 0) {
            while ($row = mysqli_fetch_assoc($select)) {
                array_push($data_menu, $row);
            }
        } else {
            $data_menu = ["nodata" => "Không có món ăn trong ngày"];
        }
    
} else {
    $data_menu = ["error" => "lỗi 404"];
}
echo json_encode($data_menu, true);
