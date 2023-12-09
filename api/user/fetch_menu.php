<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if (isset($_REQUEST['dateMenu']) && $_REQUEST['dateMenu'] !== '') {
    $date_menu = $_REQUEST['dateMenu'];
    $select_menu = mysqli_query($con, "SELECT * FROM `menu` WHERE `date` = '$date_menu' and `status` = 'menu'");
    if (mysqli_num_rows($select_menu) > 0) {
        while ($row_menu = mysqli_fetch_assoc($select_menu)) {
            $data_menu = [];
            $id_menu = $row_menu['menu_id'];
            $select_dish = mysqli_query($con, "SELECT `dishes`.`name`, `dishes`.`dish_id`, `dishes`.`image`,  `categories`.`name` as `category`
                                                FROM `menu_list`
                                                inner join `dishes` on `menu_list`.`dish_id` = `dishes`.`dish_id`
                                                inner join `categories` on `dishes`.`category_id` = `categories`.`id`
                                                Where `menu_list`.`menu_id` = $id_menu and `dishes`.`is_approved` = true and `dishes`.`remove` = false");
            while ($row_dish = mysqli_fetch_assoc($select_dish)) {
                $avg_star = 0;
                $count = 0;
                $data_resource = [];
                $dish_id = $row_dish['dish_id'];
                $select_resource = mysqli_query($con, "SELECT `resources`.`name` 
                                                        FROM  `dishes` 
                                                        INNER JOIN `dish_detail` ON `dishes`.`dish_id` = `dish_detail`.`dish_id`
                                                        INNER JOIN `resources` ON `resources`.`id` = `dish_detail`.`resource_id`
                                                        WHERE `dish_detail`.`dish_id` = $dish_id");

                $select_star_avg = mysqli_query($con, "SELECT COUNT(`review`) as `avg`
                                                        FROM `dishes`
                                                        INNER JOIN `review` on `dishes`.`dish_id` = `review`.`dish_id`
                                                        WHERE `review`.`dish_id` = $dish_id");
                $row_star = mysqli_fetch_assoc($select_star_avg);
                if ($row_star['avg'] != 0) {
                    $array_star = [1, 2, 3, 4, 5];
                    foreach ($array_star as $value) {
                        $select_star = mysqli_query($con, "SELECT `review`.`review`
                                                        FROM `dishes`
                                                        INNER JOIN `review` on `dishes`.`dish_id` = `review`.`dish_id`
                                                        WHERE `review`.`dish_id` = $dish_id and `review`.`review` = $value");
                        if (mysqli_num_rows($select_star) > 0) {
                            $count += mysqli_num_rows($select_star) * $value;
                            // echo "r = " . $count . "<br>";
                        }
                    }
                    // echo "m = " . $count . "<br>";
                    $avg_star = $count / $row_star['avg'];
                }
                while ($row_dish_detail = mysqli_fetch_assoc($select_resource)) {
                    array_push($data_resource, $row_dish_detail['name']);
                }
                $row_dish['resources'] = $data_resource;
                $row_dish['avg_star'] =  $avg_star;
                array_push($data_menu, $row_dish);
            }

            $row_menu["menu_list"] =  $data_menu;
            array_push($data, $row_menu);
        }
    } else {
        $data = ["nodata" => "Không có món ăn trong ngày"];
    }
} else {
    $data = ["error" => "lỗi"];
}
echo json_encode($data, true);
