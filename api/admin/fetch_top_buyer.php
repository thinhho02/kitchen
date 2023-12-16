<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if(isset($_POST['top_m']) && $_POST['top_m'] !== ''
&& isset($_POST['top_y']) && $_POST['top_y'] !== ''){
    $month = $_POST['top_m'];
    $year = $_POST['top_y'];
    $date = $year . "-" . $month;
    // echo $date;
    $select_user = mysqli_query($con,"SELECT `employees`.`employee_id`,`employees`.`avatar`,CONCAT(`employees`.`first_name`,' ',`employees`.`last_name`) as `full_name`,`payment`.`total`
                                        FROM `payment` INNER JOIN `employees` on `payment`.`employee_id` = `employees`.`employee_id`
                                        WHERE DATE_FORMAT(`payment`.`created_time`,'%Y-%m') = '$date'
                                        ORDER BY `payment`.`total` desc LIMIT 3");
    if(mysqli_num_rows($select_user)>0){
        while($row_user = mysqli_fetch_assoc($select_user)){
            array_push($data,$row_user);
        }
    }
    else{
        $data = ["message"=>"Không có nhân viên mua"];
    }
}
echo json_encode($data,true);