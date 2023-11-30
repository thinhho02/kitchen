<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if (isset($_REQUEST['btnvalue']) && isset($_REQUEST['date'])) {

    $date = $_REQUEST['date'];
    // $format_date = date('Y-d-m', strtotime($date));
    $cate = $_REQUEST['btnvalue'];
    
    $select = mysqli_query($con, "SELECT `menu`.`menu_id`,`dishes`.`dish_id`,`dishes`.`name`,`dishes`.`image`,`dishes`.`description`,`menu`.`price`,`dishes`.`category_id`
                                        FROM `menu`
                                        inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                        inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                        WHERE `menu`.`status` = 'food' and `menu`.`date` = $date
                                        and `dishes`.`is_approved` = true and `dishes`.`remove` = false and `dishes`.`category_id` = $cate") or die("connect failed");
    // echo $select;

    if (mysqli_num_rows($select) > 0) {
        $data_menu = [];
        while ($row = mysqli_fetch_assoc($select)) {
            $dish_id = $row['dish_id'];
            $select_dish_detail = mysqli_query($con, "SELECT `resources`.`name` 
                                                        FROM  `dishes` 
                                                        INNER JOIN `dish_detail` ON `dishes`.`dish_id` = `dish_detail`.`dish_id`
                                                        INNER JOIN `resources` ON `resources`.`id` = `dish_detail`.`resource_id`
                                                        WHERE `dish_detail`.`dish_id` = $dish_id");

            $data_resource = [];
            while ($row_dish_detail = mysqli_fetch_assoc($select_dish_detail)) {
                array_push($data_resource, $row_dish_detail['name']);
            }

            $row['resources'] = $data_resource;
            array_push($data_menu, $row);
        }

        $data = $data_menu;
    } else {
        $data = ["nodata" => "Không có món ăn trong ngày"];
    }
} else {
    $data = ["error" => "lỗi 404"];
}
echo json_encode($data, true);
