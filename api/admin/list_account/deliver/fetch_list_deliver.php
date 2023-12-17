<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
$select_employees = mysqli_query($con,"SELECT `employee_id`,CONCAT(`first_name`,' ',`last_name`) as `full_name`
                                        ,`number`,`email`,`id_number`,`birthdate`,DATE_FORMAT(`created_time`,'%Y-%m-%d') as `date`
                                        FROM `employees`
                                        WHERE `roles` = 'deliver'");
if(mysqli_num_rows($select_employees)>0){
    $data_user = [];
    while($row_employees = mysqli_fetch_assoc($select_employees)){
        array_push($data_user,$row_employees);
    }
    $data = ["data" => $data_user];
}else{
    $data = ["data" => ""];
}
echo json_encode($data,true);
