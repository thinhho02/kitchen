<?php
include 'connect/connect.php';
$html = '<table border="0" cellpadding="0" cellspacing="0" width="50%" class="d-flex">
<tr>
    <th colspan="2" align="left" bgcolor="#00A4BD"><font size="2" face="Arial, sans-serif">Thông tin đơn hàng</font></th>
</tr>

</table>

<p style="font-size:20px; margin-top:15px;">Chi tiết đơn hàng:</p>
<table border="1" cellpadding="5" cellspacing="0" width="50%">
<tr>
    <th align="left">Tên Món</th>
    <th align="center">Số Lượng</th>
    <th align="right">Giá món</th>
    <th align="right">Tổng tiền</th>
</tr>
';
$select_receipt_detail = mysqli_query($con, "SELECT `receipt_detail`.`quantity`,`receipt_detail`.`price`, `receipt_detail`.`menu_id`,`menu`.`price` as `menu_price`
                                                    FROM `payment` 
                                                    inner join `receipts` on `payment`.`id` = `receipts`.`payment_id` 
                                                    inner join `receipt_detail` on `receipts`.`receipt_id` = `receipt_detail`.`receipt_id`  
                                                    inner join `menu` on `receipt_detail`.`menu_id` = `menu`.`menu_id`
                                                    WHERE `receipt_detail`.`receipt_id` = 'HD342654'
                                                    and `receipts`.`status` = 'confirming'
                                                    and `payment`.`employee_id` = 'NV471102'");
while ($row_receipt_detail = mysqli_fetch_assoc($select_receipt_detail)) {
$data_dish = [];

$menu_id = $row_receipt_detail['menu_id'];
$quantity = $row_receipt_detail['quantity'];
$initial_price = $row_receipt_detail['menu_price'];
$price = $row_receipt_detail['price'];
$select_menu = mysqli_query($con, "SELECT `menu_list`.`dish_id`,`dishes`.`name`
                                        FROM `menu`
                                        inner join `menu_list` on `menu`.`menu_id` = `menu_list`.`menu_id`
                                        inner join `dishes` on `dishes`.`dish_id` = `menu_list`.`dish_id`
                                        WHERE `menu_list`.`menu_id` = 4 and `dishes`.`is_approved` = true and `dishes`.`remove` = false");
while ($row_menu = mysqli_fetch_assoc($select_menu)) {
array_push($data_dish, $row_menu['name']);
}
$name = implode("<br>", $data_dish);
$html .=    '<tr>
        <td>'.$name.'</td>
        <td align="center">'.$quantity.'</td>
        <td align="right">'.$initial_price.'</td>
        <td align="right">'.$price.'</td>
    </tr>';
}
$html .= '</table>';
echo $html;