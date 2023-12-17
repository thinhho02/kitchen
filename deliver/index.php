<?php
session_start();
include '../connect/connect.php';
if (!isset($_SESSION['employee_deliver_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_deliver_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen | Món ăn</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="stylesheet" href="../css/vanillaSelectBox.css">
</head>
<style>
    body {
        color: black;
        line-height: 1.5;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "layouts/sidebar_kitchen.php" ?>

            <div class="col-12 col-md-10">
                <!-- Start: Page header -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="text-uppercase">Đơn hàng cần giao</h3>
                    </div>
                </div>
                <!-- End: Page header -->




                <!-- Start: Table -->
                <div class="mt-5 my-3">
                    <!-- <div class="table-responsive"> -->

                    <table class="table table-striped table-bordered hover" style="width: 100%" id="dishes-table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Mã ĐH</th>
                                <th scope="col" class="text-center">Mã NV</th>
                                <th scope="col" class="text-center">Tên NV</th>
                                <th scope="col" class="text-center">Ghi chú</th>
                                <th scope="col" class="text-center">Ngày đặt</th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="table-body">


                        </tbody>
                    </table>

                    <!-- </div> -->
                </div>


                <!-- End: Table -->
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chi tiết đơn hàng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="center" style="min-width: 40px;">#</th>
                                                <th style="min-width: 225px;">Tên món</th>
                                                <th class="center" style="min-width: 108px;">Số lượng</th>
                                                <th class="right" style="min-width: 360px;">Nguyên liệu</th>
                                            </tr>
                                        </thead>
                                        <tbody class="receipt_detail">


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Xóa</button>
                            <button type="button" class="btn btn-primary" id="updateReceipt" data-dismiss="modal">Đã giao</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-bundle.min.js"></script>
    <script src="../js/datatables.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            // validation form
            const minDate = new Date()
            // const maxDate = new Date()

            minDate.setDate(minDate.getDate() + 1)
            // maxDate.setDate(maxDate.getDate() + 6)

            const setTimezone = minDate.getTimezoneOffset() * 60000
            // console.log(setTimezone)
            const localMinDate = Number(minDate) - setTimezone
            // const localMaxDate = Number(maxDate) - setTimezone

            const setupMinDate = new Date(localMinDate)
            // const setupMaxDate = new Date(localMaxDate)
            // console.log(localMinDate)
            let valueMinDate = setupMinDate.toISOString().split("T")[0]
            // const valueMaxDate = setupMaxDate.toISOString().split("T")[0]
            console.log(valueMinDate)
            $.ajax({
                url: `../api/deliver/fetch_order.php`,
                method: "POST",
                dataType: "JSON",
                data: {
                    date: valueMinDate,
                },
                success: function(data) {
                    console.log(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
            const table = $('#dishes-table').DataTable({
                dom: 'frt',
                "processing": true,
                // "serverSide": true,
                ajax: {
                    url: `../api/deliver/fetch_order.php`,
                    type: "POST",
                    data: {
                        date: valueMinDate,
                    },
                },
                columns: [{
                        "data": "receipt_id",
                        className: 'dt-body-center'
                    },
                    {
                        "data": "employee_id",
                        className: 'dt-body-center'
                        // "render": function(data) {
                        //     // console.log(data)
                        //     // Combine dish names from menu_list
                        //     return data.map(function(dish) {
                        //         return dish.name;
                        //     }).join("<br>");
                        // }
                    },
                    {
                        "data": "orderer.full_name",
                        className: 'dt-body-center'
                    },
                    {
                        "data": "note",
                        className: 'dt-body-left'
                    },
                    {
                        "data": "created_time",
                        className: 'dt-body-center'
                    },
                    {
                        "data": "receipt_id",
                        className: 'dt-body-center',
                        "render": function(data, type, row) {
                            const receiptId = data;
                            // console.log(data)
                            return '<button type="button" class="btn btn-link view-detail" data-toggle="modal" data-target="#modelId" data-row=\'' + JSON.stringify(row) + '\'><ion-icon name="eye-outline"></ion-icon></button>';
                            // Combine dish names from menu_list

                        }
                    },
                ],
                // rowCallback: function(row, data, index) {
                //     $(row).on('click', function() {
                //         // Đây là nơi bạn có thể thực hiện các hành động khi click vào hàng
                //         // Ví dụ: mở modal
                //         openModal(data); // Chú ý: bạn cần định nghĩa hàm openModal() để mở modal
                //     });
                // },
                // "scrollX": true,
                buttons: [{
                        extend: 'print',
                        text: 'In đơn hàng',
                        title: 'Danh sách đơn hàng',
                    },
                    {
                        extend: 'excel',
                        text: 'Xuất Excel',
                        title: `Danh Sách Đơn Hàng_${valueMinDate}`,
                        sheetName: 'Nguyên liệu',
                    },
                ],
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                    },

                    {
                        targets: 3,
                        width: "30%",
                    }
                ],
                language: {
                    emptyTable: "Không có đơn hàng trong ngày",
                    loading: "Không có đơn hàng trong ngày",
                    search: "Tìm:"
                },
            });
            let receiptId = "";
            $('#dishes-table').on('click', '.view-detail', function() {
                $(".modal-body .receipt_detail").empty()
                const rowData = $(this).data('row');
                receiptId = rowData.receipt_id
                openDetailModal(rowData);
            });


            function openDetailModal(data) {

                data.menu_list.forEach((menu, index) => {
                    let name = menu.menu_detail.map((dish) => {
                        return dish.name
                    }).join("<br>")
                    let resources = menu.menu_detail.map((dish) => {
                        return `${dish.name} : ${dish.resources.join(", ")}`
                    }).join("<br>")
                    const modalReceipt =
                        `<tr class="menu${menu.menu_id}">
                                            <td class="center count">${index + 1}</td>
                                            <td class="left name">${name}</td>
                                            <td class="center quantity">${menu.quantity}</td>
                                            <td class="right menu_price">${resources}</td>
                                        </tr>`
                    $(".modal-body .receipt_detail").append(modalReceipt)

                })





                console.log(data);
            }
            // console.log(table.settings())
            $("#updateReceipt").on("click", async function() {
                // valueMinDate = "2023-12-11";
                // console.log(receiptId)
                await $.ajax({
                    url: `../api/deliver/fetch_update_order.php`,
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        receipt_id: receiptId,
                    },
                    success: function(data) {
                        if(!(data.error)){
                            if(data.fail){
                                alert(data.fail)
                            }
                        }else{
                            alert(data.error)
                        }
                    },
                })
                table.ajax.reload();
            })

        });
    </script>

</body>

</html>