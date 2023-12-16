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
    $date = $year . "-". $month;
    $select_receipt = mysqli_query($con,"SELECT `resources`.`name`,`resources`.`unit`,`resources`.`price`
                                        ,SUM(`dish_detail`.`quantity`*`receipt_detail`.`quantity`) as `quantity`
                                        ,SUM(`dish_detail`.`quantity`*`receipt_detail`.`quantity`) * `resources`.`price` as `sum`
                                            FROM `receipts`
                                            INNER JOIN `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`
                                            INNER JOIN `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                            INNER JOIN `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                            INNER JOIN `dishes` on `menu_list`.`dish_id` = `dishes`.`dish_id`
                                            INNER JOIN `dish_detail` on `dishes`.`dish_id` = `dish_detail`.`dish_id`
                                            INNER JOIN `resources` on `dish_detail`.`resource_id` = `resources`.`id`
                                            WHERE DATE_FORMAT(`receipts`.`created_time`,'%Y-%m') = '$date'
                                            and `receipts`.`status` != 'cart'
                                            GROUP BY `resources`.`name`
                                            ORDER BY `sum` DESC");
    if(mysqli_num_rows($select_receipt)>0){
        $data_resources = [];
        while($row_receipt = mysqli_fetch_assoc($select_receipt)){
            array_push($data_resources,$row_receipt);
        }
        $data = ["data"=>$data_resources];
    }else{
        $data = ["data" => ""];
    }
    
}
echo json_encode($data,true);
?>