<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/kitchen/connect/connect.php');
$data = [];
if(isset($_COOKIE['receipt'])){
    $id_receipt = $_COOKIE['receipt'];
    $id_user = $_POST['id_user'];
    // lấy giá trị mã đơn hàng
    $select_receipt = mysqli_query($con, "SELECT * FROM `receipts` WHERE `receipt_id` = '$id_receipt' and `status` = 'confirming'");
    if(mysqli_num_rows($select_receipt)>0){
        $row = mysqli_fetch_assoc($select_receipt);
        $data = [["receipt_id" => $row['receipt_id'], "subtotal" => $row['price'], "full_time" => $row['created_time'], "status" => 'confirming', "note" => $row['note']]];
        // lấy giá trị của chi tiết món ăn
        
        $select_receipt_detail = mysqli_query($con,"SELECT `receipt_detail`.`quantity`,`receipt_detail`.`price`, `receipt_detail`.`menu_id`,`menu`.`price` as `menu_price`
                                            FROM `payment` 
                                            inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                            inner join `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`  
                                            inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                            WHERE `receipt_detail`.`receipt_id` = '$id_receipt'
                                            and `receipts`.`status` = 'confirming'
                                            and `payment`.`employee_id` = '$id_user'");
        if(mysqli_num_rows($select_receipt_detail) > 0){
            while($row_receipt = mysqli_fetch_assoc($select_receipt_detail)){
                $data_menu = [];
                $menu_id = $row_receipt['menu_id'];
                $select_menu = mysqli_query($con, "SELECT `menu_list`.`dish_id`,`dishes`.`name`,`dishes`.`category_id`
                                                    FROM `menu`
                                                    inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                                    inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                                    WHERE `menu_list`.`menu_id` = $menu_id and `dishes`.`is_approved` = true and `dishes`.`remove` = false");
                
                while ($row_menu = mysqli_fetch_assoc($select_menu)){
                    $data_dish = [];
                    $dish_id = $row_menu['dish_id'];
                    $select_dish = mysqli_query($con,"SELECT `resources`.`name` 
                                                        FROM  `dishes` 
                                                        INNER JOIN `dish_detail` ON `dishes`.`dish_id` = `dish_detail`.`dish_id`
                                                        INNER JOIN `resources` ON `resources`.`id` = `dish_detail`.`resource_id`
                                                        WHERE `dish_detail`.`dish_id` = $dish_id");
                    while($row_dish = mysqli_fetch_assoc($select_dish)){
                        array_push($data_dish,$row_dish['name']);
                    }
                    $row_menu['resource'] = $data_dish;
                    array_push($data_menu,$row_menu);
                }
                $row_receipt['menu_list'] = $data_menu;
                array_push($data, $row_receipt);
            }
        }
    }else{
        setcookie("receipt","", time() - 3600, "/");
        $data = ["message" => "không có hóa đơn trong ngày"];
    }
    
    
}
echo json_encode($data);
?>