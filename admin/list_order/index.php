<?php
session_start();
include '../../connect/connect.php';

if (!isset($_SESSION['employee_manager_id'])) {
    header("location: /kitchen/login/");
}
$id = $_SESSION['employee_manager_id'];

// echo $id;
$select_user = mysqli_query($con, "SELECT *,CONCAT(`first_name`,' ',`last_name`) as `full_name` FROM `employees` WHERE `employee_id` = '$id'");
$row_user = mysqli_fetch_assoc($select_user);


date_default_timezone_set('Asia/Ho_Chi_Minh');
$date = date("Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Pacifico&family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;1,200&family=Poppins:wght@200;300&family=Public+Sans&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- <link rel="stylesheet" href="../../css/apexcharts.css"> -->
    <link rel="stylesheet" href="../../css/datatables.min.css">
    <link rel="Shortcut Icon" type="image/png" href="../../image/icons8-restaurant-bubbles-96.png">

    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

</head>
<style>
    body {
        color: black;
        line-height: 1.5;
    }

    .right {
        font-family: "Plus Jakarta Sans", sans-serif;

    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 4px 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        width: 200px;
        border-radius: 8px;
        outline: none;
        margin-top: 5px;
        margin-bottom: 10px;
        margin-right: 10px;
        transition: all 0.3s linear;

    }

    .dataTables_wrapper .dataTables_filter input:focus {
        box-shadow: 0 0 0 0.05rem #c00a27;
        /* outline: 0; */
        border-color: transparent;
    }

    /* .pill-tabContent .active {
        display: inline;
    } */
    /* .dataTables_wrapper {
        width: 100%;
    } */
    #myTabProfile button.nav-link {
        outline: none;
        box-shadow: none;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row py-4">
            <?php include "../layouts/sidebar.php" ?>

            <div class="col-12 col-md-10 right">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="text-uppercase" style="font-weight: bold;">Danh sách đơn đặt</h3>
                    </div>
                </div>

                <!-- End: Page header -->




                <!-- Start: Table -->


                <div class="table-responsive my-5">

                    <table class="table table-striped hover" style="width: 100%" id="table-orders">
                        <thead style="font-size: 15px;">
                            <tr>
                                <th scope="col" class="text-center">Mã HĐ</th>
                                <th scope="col" class="text-center">Mã NV</th>
                                <th scope="col" class="text-center">Tên Nhân Viên</th>
                                <th scope="col" class="text-center">Ghi Chú</th>
                                <th scope="col" class="text-right pr-3">Tổng Tiền</th>
                                <th scope="col" class="text-center">Trạng Thái</th>
                                <th scope="col" class="text-center">Ngày Nhận</th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="table-body" style="font-size: 14px;">


                        </tbody>
                    </table>

                </div>
                <div class="row justify-content-end mx-3 mt-3" id="footer-table-orders">
                    <button type="button" class="limit_orders btn btn-link">Xem thêm</button>
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
                                                    <th class="text-center" style="min-width: 40px;">#</th>
                                                    <th class="text-left pl-2" style="min-width: 225px;">Tên món</th>
                                                    <th class="text-center" style="min-width: 108px;">Số lượng</th>
                                                    <th class="text-left pl-2" style="min-width: 360px;">Nguyên liệu</th>
                                                </tr>
                                            </thead>
                                            <tbody class="receipt_detail">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                <!-- <button type="button" class="btn btn-primary" id="updateReceipt" data-dismiss="modal">Hoàn Thành</button> -->
                            </div>
                        </div>
                    </div>
                </div>




            </div>

        </div>
    </div>



    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/bootstrap-bundle.min.js"></script>
    <script src="../../js/datatables.min.js"></script>
    <!-- <script src="../../js/apexcharts.js"></script> -->
    <!-- <script src="../js/list_account.js"></script> -->
    <script>
        $(document).ready(function() {
            $("a.nav-link").removeClass("active")
            $("#order-manage").addClass("active")
            $.ajax({
                url: `../../api/admin/list_order/fetch_list_order.php`,
                method: "POST",
                dataType: "JSON",

                success: function(data) {
                    console.log(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
            const tableOrders = $('#table-orders').DataTable({
                info: false,
                // "pagingType": "full_numbers",
                "pageLength": 10,
                ordering: false,
                paging: true,
                dom: 'tfrt',
                "processing": true,
                "sAjaxSource": "../../api/admin/list_order/fetch_list_order.php",
                "fnServerData": function(sSource, aoData, fnCallback) {
                    // let limit = "limit 5"
                    $.ajax({
                        url: sSource,
                        type: "POST",
                        dataType: "JSON",

                        success: function(data) {
                            // Call the DataTables callback with the retrieved data
                            fnCallback(data);
                            // console.log(data.data.length)
                            if (data.data.length < 6) {
                                // console.log(data.data.length)
                                $("#footer-table-user .limit_user").css("display", "none");
                            } else {
                                $("#footer-table-user .limit_user").css("display", "block")
                            }

                        },
                        complete: function(data) {

                        }
                    })
                },

                columns: [{
                        "data": "receipt_id",
                        className: 'dt-body-center align-middle',
                        "render": function(data, type, row, meta) {
                            // console.log(meta)
                            return `<span class="font-weight-bold">#${data}</span>`
                        }
                    },
                    {
                        "data": "employee_id",
                        className: 'dt-body-center align-middle'
                        // "render": function(data) {
                        //     // console.log(data)
                        //     // Combine dish names from menu_list
                        //     return data.map(function(dish) {
                        //         return dish.name;
                        //     }).join("<br>");
                        // }
                    },
                    {
                        "data": "full_name",
                        className: 'dt-body-center align-middle'
                    },
                    {
                        "data": "note",
                        className: 'dt-body-center align-middle'
                    },
                    {
                        "data": "price",
                        className: 'dt-body-right align-middle',
                        "render": function(data, type, row, meta) {
                            return `<span>${Number(data).toLocaleString("en-US")} VNĐ</span>`;
                        }
                    },
                    {
                        "data": "status",
                        className: 'dt-body-center align-middle',
                        "render": function(data, type, row, meta) {
                            if (data == "confirming") {
                                return `<span>Chờ xác nhận</span>`
                            } else if (data == "confirmed") {
                                return `<span>Đã xác nhận</span>`
                            } else if (data == "shipping") {
                                return `<span>Đang giao</span>`
                            } else if (data == "shipped") {
                                return `<span>Đã giao</span>`
                            }
                        }
                    },
                    {
                        "data": "created_time",
                        className: 'dt-body-center align-middle',
                    },
                    {
                        "data": null,
                        className: 'dt-body-right align-middle',
                        "render": function(data, type, row, meta) {
                            // const receiptId = data;
                            // console.log(row)
                            const btn = `<div class="d-flex align-items-center justify-content-center">
                                            <button type="button" class="btn btn-link view-detail" data-toggle="modal" data-target="#modelId" data-row='${JSON.stringify(row)}'><ion-icon name="eye-outline"></ion-icon></button>
                                            <button type="button" class="btn btn-link delete-receipt" data-row='${row.receipt_id}'><ion-icon name="trash-outline" style="color: red"></ion-icon></button>
                                        </div>`
                            return btn;
                            // Combine dish names from menu_list

                        }
                    },

                ],


                // buttons: [{
                //         extend: 'print',
                //         text: 'In danh sách',
                //         title: 'Danh sách đơn đặt',
                //     },
                //     {
                //         extend: 'excel',
                //         text: 'Xuất Excel',
                //         title: `Danh Sách Đơn Hàng_${localMonth.getTime()}`,
                //         sheetName: 'Nguyên liệu',
                //     },
                // ],
                columnDefs: [{
                    targets: 3,
                    width: "20%",
                }],
                language: {

                    emptyTable: "Không có đơn hàng trong tháng",
                    // loading: "Không có đơn hàng trong tháng",
                    search: "",
                    searchPlaceholder: "Nhập dữ liệu",
                    zeroRecords: "Không có dữ liệu"

                },
                footerCallback: function(row, data, start, end, display) {
                    // let api = this.api();

                    // console.log(end)
                    let m = new Array()
                    display.forEach((e) => {
                        m.push(Number(data[e].sum))
                    });


                    total = m.reduce((a, b) => a + b, 0);
                    // console.log(total)
                    // $(".sub-total-user").html(`${total.toLocaleString("en-US")} VNĐ`)
                    // api.column(5).footer().innerHTML = `<span class="mr-4" style="font-weight:bold;letter-spacing: 0.5px">Tổng tiền:</span> ${total.toLocaleString("en-US")} VNĐ`
                }

            });
            $('#table-orders').on('click', '.view-detail', function() {
                $(".modal-body .receipt_detail").empty()
                const rowData = $(this).data('row');
                // receiptId = rowData.receipt_id
                openDetailModal(rowData);
            });

            function openDetailModal(data) {
                // console.log(data)
                data.menu_list.forEach((menu, index) => {
                    let name = menu.menu_detail.map((dish) => {
                        return dish.name
                    }).join("<br>")
                    let resources = menu.menu_detail.map((dish) => {
                        return `<b>${dish.name}</b> : ${dish.resources.join(", ")}`
                    }).join("<br>")
                    const modalReceipt =
                        `<tr class="menu${menu.menu_id}">
                            <td class="text-center align-middle count">${index + 1}</td>
                            <td class="text-left align-middle name">${name}</td>
                            <td class="text-center align-middle quantity">${menu.quantity}</td>
                            <td class="text-left align-middle menu_price">${resources}</td>
                        </tr>`
                    $(".modal-body .receipt_detail").append(modalReceipt)

                })





                console.log(data);
            }
            $("#table-orders").on("click", ".delete-receipt", async function() {
                // valueMinDate = "2023-12-11";
                // console.log(receiptId)
                const btnValue = $(this).data('row');
                if (confirm("Are u sure?")) {
                    await $.ajax({
                        url: `../../api/admin/list_order/fetch_delete_order.php`,
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            receipt_id: btnValue,
                        },
                        success: function(data) {
                            if (!(data.error)) {
                                if (!(data.success)) {
                                    alert(data.success)
                                } else {
                                    tableOrders.ajax.reload();
                                }
                            } else {
                                alert(data.error)
                            }
                        },
                    })
                }
                // console.log(btnValue)

            })
            $("#footer-table-orders").on("click", ".limit_orders", function(e) {
                if ($("#footer-table-orders").find(".see_more").length == 0) {
                    tableOrders.page.len(10000).draw()
                    $(".limit_orders").addClass("see_more")
                    $(".limit_orders").html("Ẩn Bớt")
                } else {
                    tableOrders.page.len(10).draw()
                    $(".limit_orders").removeClass("see_more")
                    $(".limit_orders").html("Xem Thêm")
                }
            })
        })
    </script>


</body>

</html>