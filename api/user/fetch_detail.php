<?php

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];

if (isset($_POST['menu_id']) && $_POST['menu_id'] !== '') {
    $menu_id = $_POST['menu_id'];
    $select = mysqli_query($con, "SELECT `menu`.`menu_id`,`dishes`.`dish_id`,`menu`.`date`,`dishes`.`name`,`dishes`.`image`,`dishes`.`description`,`menu`.`price`,`categories`.`name` as `category`
                                        FROM `menu`
                                        inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                        inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                        inner join `categories` on `categories`.`id` = `dishes`.`category_id`
                                        WHERE `menu`.`menu_id` = $menu_id 
                                        and `dishes`.`is_approved` = true and `dishes`.`remove` = false");
    // echo $select;

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $avg_stars = 0;
            $count = 0;
            $data_resource = [];
            $data_rating = [];
            $dish_id = $row['dish_id'];
            $select_dish_detail = mysqli_query($con, "SELECT `resources`.`name` 
                                                        FROM  `dishes` 
                                                        INNER JOIN `dish_detail` ON `dishes`.`dish_id` = `dish_detail`.`dish_id`
                                                        INNER JOIN `resources` ON `resources`.`id` = `dish_detail`.`resource_id`
                                                        WHERE `dish_detail`.`dish_id` = $dish_id");
            $select_star_avg = mysqli_query($con, "SELECT COUNT(`review`) as `avg`
                                                        FROM `dishes`
                                                        INNER JOIN `review` on `dishes`.`dish_id` = `review`.`dish_id`
                                                        WHERE `review`.`dish_id` = $dish_id");
            $row_star_avg = mysqli_fetch_assoc($select_star_avg);
            if ($row_star_avg['avg'] != 0) {
                $array_star = [5, 4, 3, 2, 1];
                foreach ($array_star as $value) {
                    $select_star = mysqli_query($con, "SELECT `review`.`review` , COUNT(`review`) as `count` 
                                                            FROM `dishes`
                                                            INNER JOIN `review` on `dishes`.`dish_id` = `review`.`dish_id`
                                                            WHERE `review`.`dish_id` = $dish_id and `review`.`review` = $value");
                    $row_star = mysqli_fetch_assoc($select_star);
                    $value_star = ["star" => $value, "count" => $row_star['count']];
                    array_push($data_rating, $value_star);
                    if ($row_star['review'] != null) {
                        $count += $row_star['count'] * $row_star['review'];
                        // echo "r = " . $count . "<br>";
                    }
                }
                // echo "m = " . $count . "<br>";
                $avg_stars = $count / $row_star_avg['avg'];
            }

            while ($row_dish_detail = mysqli_fetch_assoc($select_dish_detail)) {
                array_push($data_resource, $row_dish_detail['name']);
            }

            $row['resources'] = $data_resource;
            $row['avg_review'] = $avg_stars;
            $row['rating'] = $data_rating;
            $row['total_count'] = $row_star_avg['avg'];
            array_push($data, $row);
        }
    } else {
        $data = ["nodata" => "Không có món ăn trong ngày"];
    }
}  else {
    $data = ["error" => "Lỗi"];
}
echo json_encode($data, true);
