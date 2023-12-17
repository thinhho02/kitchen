<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];
if(isset($_POST['date']) && $_POST['date'] !== ''){
    $date = $_POST['date'];
    $select_payment = mysqli_query($con,"SELECT SUM(`total`) as `total`,DATE_FORMAT(`created_time`,'%m/%Y') as `monthYear` 
                                        FROM `payment` 
                                        WHERE DATE_FORMAT(`created_time`,'%Y') = '$date' 
                                        GROUP BY DATE_FORMAT(`created_time`,'%Y-%m') 
                                        ORDER BY DATE_FORMAT(`created_time`,'%Y-%m') asc");
    if(mysqli_num_rows($select_payment)>0){
        $data_y = [];
        $data_x = [];
        $sum = 0;
        while($row_payment = mysqli_fetch_assoc($select_payment)){
            $sum += $row_payment['total'];
            array_push($data_y,$row_payment['total']);
            array_push($data_x,$row_payment['monthYear']);
        }
        $data = ["x" => $data_x,"y" => $data_y, "sum" => $sum];
    }
}
echo json_encode($data,true);