<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];

$select_receipts = mysqli_query($con, "SELECT `employees`.`employee_id`,`receipts`.`receipt_id`, CONCAT(`employees`.`first_name`,' ',`employees`.`last_name`) as `full_name`
                                        ,`receipts`.`note`,`receipts`.`price`,`receipts`.`status`,`receipts`.`created_time`
                                        FROM `employees` 
                                        INNER JOIN `payment` on `employees`.`employee_id` = `payment`.`employee_id`
                                        INNER JOIN `receipts` on `payment`.`id` = `receipts`.`payment_id`
                                        WHERE `receipts`.`status` != 'cart'
                                        GROUP BY `receipts`.`receipt_id`
                                        ORDER BY `receipts`.`created_time` DESC");
if (mysqli_num_rows($select_receipts) > 0) {
    $data_receipts = [];
    while ($row_receipts = mysqli_fetch_assoc($select_receipts)) {
        $data_menu = [];
        // $employee_id = $row_receipts['employee_id'];
        $receipt_id = $row_receipts['receipt_id'];
        $select_receipt_detail = mysqli_query($con, "SELECT `receipt_detail`.`menu_id`,`receipt_detail`.`quantity`,`receipt_detail`.`price`
                                                        FROM `receipt_detail` 
                                                        inner join  `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                                        WHERE `receipt_detail`.`receipt_id` = '$receipt_id'");
        while ($row_receipt_detail = mysqli_fetch_assoc($select_receipt_detail)) {
            $data_dish = [];
            $menu_id = $row_receipt_detail['menu_id'];
            $select_menu_detail = mysqli_query($con, "SELECT `dishes`.`dish_id`,`dishes`.`name`
                                                        FROM `menu`
                                                        INNER JOIN `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                                        INNER JOIN `dishes` on `menu_list`.`dish_id` = `dishes`.`dish_id`
                                                        WHERE `menu_list`.`menu_id` = $menu_id
                                                        and `dishes`.`is_approved` = true
                                                        and `dishes`.`remove` = false");
            while ($row_menu_detail = mysqli_fetch_assoc($select_menu_detail)) {
                $data_resources = [];
                $dish_id = $row_menu_detail['dish_id'];
                $select_dish_detail = mysqli_query($con, "SELECT `resources`.`name` 
                                                            FROM  `dishes` 
                                                            INNER JOIN `dish_detail` ON `dishes`.`dish_id` = `dish_detail`.`dish_id`
                                                            INNER JOIN `resources` ON `resources`.`id` = `dish_detail`.`resource_id`
                                                            WHERE `dish_detail`.`dish_id` = $dish_id");


                while ($row_dish_detail = mysqli_fetch_assoc($select_dish_detail)) {
                    array_push($data_resources, $row_dish_detail['name']);
                }
                $row_menu_detail['resources'] = $data_resources;
                array_push($data_dish, $row_menu_detail);
            }
            $row_receipt_detail["menu_detail"] = $data_dish;
            array_push($data_menu, $row_receipt_detail);
        }
        // $select_user = mysqli_query($con, "SELECT CONCAT(`first_name`,' ',`last_name`) as `full_name`, `number`, `email` FROM `employees` WHERE `employee_id` = '$employee_id'");
        // $row_user = mysqli_fetch_assoc($select_user);


        $row_receipts['menu_list'] = $data_menu;
        // $row_receipts['orderer'] = $row_user;
        array_push($data_receipts, $row_receipts);
    }
    $data = ["data" => $data_receipts];
} else {
    $data = ["data" => ""];
}

echo json_encode($data, true);
