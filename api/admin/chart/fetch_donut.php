<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');

$data = [];


$select_payment = mysqli_query($con, "SELECT SUM(`total`) as `total`,DATE_FORMAT(`created_time`,'%Y') as `year` FROM `payment` GROUP BY DATE_FORMAT(`created_time`,'%Y') ORDER BY DATE_FORMAT(`created_time`,'%Y') desc");
if (mysqli_num_rows($select_payment) > 0) {
    $data_y = [];
    $data_x = [];
    $sum = 0;
    $select_sum = mysqli_query($con, "SELECT SUM(`total`) as `sum` FROM `payment` GROUP BY DATE_FORMAT(`created_time`,'%Y') ORDER BY DATE_FORMAT(`created_time`,'%Y') desc limit 2");
    while($row_sum = mysqli_fetch_assoc($select_sum)){
        $sum += $row_sum['sum'];
    }
    while ($row_payment = mysqli_fetch_assoc($select_payment)) {
        array_push($data_y, $row_payment['total']);
        array_push($data_x, $row_payment['year']);
    }
    $data = ["x" => $data_x, "y" => $data_y, "sum" => $sum];
}

echo json_encode($data, true);
