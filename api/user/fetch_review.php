<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if (isset($_POST['menu_id']) && $_POST['menu_id'] !== '') {
    $menu_id = $_POST['menu_id'];
    $select = mysqli_query($con, "SELECT `dishes`.`dish_id`,DATE_FORMAT(`review`.`created_time`,'%Y-%m-%d %H:%i') as `date`,DATE_FORMAT(`review`.`created_time`,'%Y-%m-%d-%H-%i') as `string_date`
                                    ,`review`.`review`,`review`.`employee_id`,`review`.`comment`
                                    ,CONCAT(`employees`.`first_name`,' ',`employees`.`last_name`) as `full_name`,`employees`.`avatar`
                                    FROM `menu`
                                    inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                    inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                    inner join `review` on `review`.`dish_id` = `dishes`.`dish_id`
                                    inner join `employees` on `review`.`employee_id` = `employees`.`employee_id`
                                    WHERE `menu`.`menu_id` = $menu_id 
                                    and `dishes`.`is_approved` = true and `dishes`.`remove` = false
                                    ORDER BY `review`.`review` DESC");
    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            array_push($data, $row);
        }
    }
} elseif (
    isset($_POST['dish_id']) && $_POST['dish_id'] !== ''
    && isset($_POST['user_id']) && $_POST['user_id'] !== ''
    && isset($_POST['value_message']) && $_POST['value_message'] !== ''
    && isset($_POST['value_rating']) && $_POST['value_rating'] != 0
) {

    $dish_id = $_POST['dish_id'];
    $user_id = $_POST['user_id'];
    $value_message = $_POST['value_message'];
    $value_rating = $_POST['value_rating'];
    mysqli_query($con,"INSERT INTO `review`(`employee_id`, `dish_id`, `review`, `comment`) VALUES ('$user_id','$dish_id','$value_rating','$value_message')");
    $data = ["success" => "thành công"];
}
echo json_encode($data, true);
