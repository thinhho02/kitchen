<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if (
    isset($_POST['month']) && $_POST['month'] !== ''
    && isset($_POST['year']) && $_POST['year'] !== ''
) {
    $month = $_POST['month'];
    $year = $_POST['year'];
    // $limit = $_POST['limit'];
    $year_month = $year . "-" . $month;
    $select_user = mysqli_query($con, "SELECT `employees`.`employee_id`,`employees`.`email`,`employees`.`number`,CONCAT(`employees`.`first_name`,' ',`employees`.`last_name`) as `full_name`,COUNT(`payment`.`id`) as `count`,SUM(`receipts`.`price`) as `sum` 
                                        FROM `employees` 
                                        INNER JOIN `payment` on `payment`.`employee_id` = `employees`.`employee_id` 
                                        INNER JOIN `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                        WHERE DATE_FORMAT(`receipts`.`created_time`,'%Y-%m') = '$year_month' and `receipts`.`status` != 'cart'
                                        GROUP BY `employees`.`employee_id` 
                                        ORDER BY `sum` desc");
    if(mysqli_num_rows($select_user)>0){
        $data_user = [];
        while($row_user = mysqli_fetch_assoc($select_user)){
            array_push($data_user,$row_user);
        }
        $data = ["data" => $data_user];
    }
    else
    {
        $data = ["data" => ""];
    }
}
echo json_encode($data,true);