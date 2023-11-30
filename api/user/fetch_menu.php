<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if(isset($_REQUEST['dateMenu']) && $_REQUEST['dateMenu'] !== ''){
    $date_menu = $_REQUEST['dateMenu'];
    $select_menu = mysqli_query($con, "SELECT * FROM `menu` WHERE `date` = '$date_menu' and `status` = 'menu'");
    if(mysqli_num_rows($select_menu) > 0){
        while($row_menu = mysqli_fetch_assoc($select_menu)){
            $data_menu =[];
            $id_menu = $row_menu['menu_id'];
            $select_dish = mysqli_query($con,"SELECT `dishes`.`name`, `dishes`.`dish_id`, `dishes`.`image`
                                                FROM `menu_list`
                                                inner join `dishes` on `menu_list`.`dish_id` = `dishes`.`dish_id`
                                                Where `menu_list`.`menu_id` = $id_menu and `dishes`.`is_approved` = true and `dishes`.`remove` = false");
            while($row_dish = mysqli_fetch_assoc($select_dish)){
                array_push($data_menu,$row_dish);
            }
            $row_menu["menu_list"] =  $data_menu;
            array_push($data,$row_menu);
        }
    }
    else{
        $data = ["nodata" => "Không có món ăn trong ngày"];
    }
}
else{
    $data = ["error" => "lỗi"];
}
echo json_encode($data,true);