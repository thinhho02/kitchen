$(document).ready(function () {
    $("a.nav-link").removeClass("active")
    $("#list-account").addClass("active")
  
    let tableEmployees = $('#table-employees').DataTable({
        info: false,
        // "pagingType": "full_numbers",
        // "pageLength": 5,
        ordering: false,
        // paging: true,
        autoWidth: true,
        dom: 'tfrt',
        "processing": true,
        "sAjaxSource": "../../api/admin/list_account/employees/fetch_list_employee.php",
        "fnServerData": function (sSource, aoData, fnCallback) {
            // let limit = "limit 5"
            $.ajax({
                url: sSource,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    // Call the DataTables callback with the retrieved data
                    fnCallback(data);
                    // console.log(data.data.length)


                },
                complete: function (data) {

                }
            })
        },

        columns: [{
            "data": "employee_id",
            className: 'dt-body-center align-middle font-weight-bold',
            "render": function(data, type, row, meta) {
                // console.log(meta)
                return `<span>#${data}</span>`
            }
        },
        {
            "data": "full_name",
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
            "data": "number",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "email",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "id_number",
            className: 'dt-body-center align-middle',
            "render": function (data, type, row, meta) {
                const lengthNumber = data.length
                let replaced = data.substring(0, 3) + "****" + data.substring(lengthNumber - 3)
                return `<span>${replaced}</span>`;
            }
        },
        {
            "data": "birthdate",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "debt",
            className: 'dt-body-right align-middle',
            "render": function (data, type, row, meta) {
                return `<span>${Number(data).toLocaleString("en-US")} VNĐ</span>`;
            }
        },
        {
            "data": "date",
            className: 'dt-body-center align-middle'
        },
        {
            "data": null,
            className: 'dt-body-center align-middle',
            "render": function (data, type, row, meta) {
                return '<button type="button" class="d-flex align-items-center justify-content-center btn btn-link delete-employee" data-row=\'' + row.employee_id + '\'><ion-icon name="close-circle-outline" style="color: red"></ion-icon></button>';
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
        // columnDefs: [{
        //     targets: 3,
        //     width: 254,
        // }],
        language: {

            emptyTable: "Không có nhân viên",
            // loading: "Không có đơn hàng trong tháng",
            search: "",
            searchPlaceholder: "Nhập dữ liệu",
            zeroRecords: "Không tìm thấy nhân viên"

        },

    });
    // let receiptId = "";
    $('#table-employees').on('click', '.delete-employee', async function (e) {
        // $(".modal-body .receipt_detail").empty()
        const rowData = $(this).data('row');
        if (confirm("Are u sure?")) {
            await $.ajax({
                url: `../../api/admin/list_account/fetch_delete_account.php`,
                method: "POST",
                dataType: "JSON",
                data: {
                    employee_id: rowData
                },
                success: function (data) {
                    console.log(data);
                    if (!(data.error)) {
                        // alert(data.message)
                        tableEmployees.ajax.reload()
                    } else {
                        alert(data.error)
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    });


    let tableChef = $('#table-chef').DataTable({
        info: false,
        // "pagingType": "full_numbers",
        // "pageLength": 5,
        ordering: false,
        autoWidth: true,
        // paging: true,
        dom: 'tfrt',
        "processing": true,
        "sAjaxSource": "../../api/admin/list_account/chef/fetch_list_chef.php",
        "fnServerData": function (sSource, aoData, fnCallback) {
            // let limit = "limit 5"
            $.ajax({
                url: sSource,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    // Call the DataTables callback with the retrieved data
                    fnCallback(data);
                    // console.log(data.data.length)


                },
                complete: function (data) {

                }
            })
        },

        columns: [{
            "data": "employee_id",
            className: 'dt-body-center align-middle font-weight-bold',

            "render": function(data, type, row, meta) {
                // console.log(meta)
                return `<span>#${data}</span>`
            }
        },
        {
            "data": "full_name",
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
            "data": "number",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "email",
            className: 'dt-body-center align-middle',
            // css: 'min-width',
            "render": function (data, type, row, meta) {
                return `<span>${data}</span>`;
            }
        },
        {
            "data": "id_number",
            className: 'dt-body-center align-middle',
            "render": function (data, type, row, meta) {
                const lengthNumber = data.length
                let replaced = data.substring(0, 3) + "****" + data.substring(lengthNumber - 3)
                return `<span>${replaced}</span>`;
            }
        },
        {
            "data": "birthdate",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "date",
            className: 'dt-body-center align-middle'
        },
        {
            "data": null,
            className: 'dt-body-center align-middle',
            "render": function (data, type, row, meta) {
                return '<button type="button" class="d-flex align-items-center justify-content-center btn btn-link delete-chef" data-row=\'' + row.employee_id + '\'><ion-icon name="close-circle-outline" style="color: red"></ion-icon></button>';
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
            // width: "10%",
            width: 254
        }],
        language: {

            emptyTable: "Không có nhân viên",
            // loading: "Không có đơn hàng trong tháng",
            search: "",
            searchPlaceholder: "Nhập dữ liệu",
            zeroRecords: "Không tìm thấy nhân viên"

        },

    });
    $('#table-chef').on('click', '.delete-chef', async function (e) {
        // $(".modal-body .receipt_detail").empty()
        const rowData = $(this).data('row');
        if (confirm("Are u sure?")) {
            await $.ajax({
                url: `../../api/admin/list_account/fetch_delete_account.php`,
                method: "POST",
                dataType: "JSON",
                data: {
                    employee_id: rowData
                },
                success: function (data) {
                    console.log(data);
                    if (!(data.error)) {
                        // alert(data.message)
                        tableChef.ajax.reload()
                    } else {
                        alert(data.error)
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    });
    let tableDeliver = $('#table-deliver').DataTable({
        info: false,
        // "pagingType": "full_numbers",
        // "pageLength": 5,
        ordering: false,
        autoWidth: true,
        // paging: true,
        dom: 'tfrt',
        "processing": true,
        "sAjaxSource": "../../api/admin/list_account/deliver/fetch_list_deliver.php",
        "fnServerData": function (sSource, aoData, fnCallback) {
            // let limit = "limit 5"
            $.ajax({
                url: sSource,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    // Call the DataTables callback with the retrieved data
                    fnCallback(data);
                    // console.log(data)


                },
                complete: function (data) {

                }
            })
        },

        columns: [{
            "data": "employee_id",
            className: 'dt-body-center align-middle font-weight-bold',

            "render": function(data, type, row, meta) {
                // console.log(meta)
                return `<span>#${data}</span>`
            }
        },
        {
            "data": "full_name",
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
            "data": "number",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "email",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "id_number",
            className: 'dt-body-center align-middle',
            "render": function (data, type, row, meta) {
                const lengthNumber = data.length
                let replaced = data.substring(0, 3) + "****" + data.substring(lengthNumber - 3)
                return `<span>${replaced}</span>`;
            }
        },
        {
            "data": "birthdate",
            className: 'dt-body-center align-middle'
        },
        {
            "data": "date",
            className: 'dt-body-center align-middle'
        },
        {
            "data": null,
            className: 'dt-body-center align-middle',
            "render": function (data, type, row, meta) {
                return '<button type="button" class="d-flex align-items-center justify-content-center btn btn-link delete-deliver" data-row=\'' + row.employee_id + '\'><ion-icon name="close-circle-outline" style="color: red"></ion-icon></button>';
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
        // columnDefs: [{
        //     targets: 3,
        //     width: 254,
        // }],
        language: {

            emptyTable: "Không có nhân viên",
            // loading: "Không có đơn hàng trong tháng",
            search: "",
            searchPlaceholder: "Nhập dữ liệu",
            zeroRecords: "Không tìm thấy nhân viên"

        },

    });
    $('#table-deliver').on('click', '.delete-deliver', async function (e) {
        // $(".modal-body .receipt_detail").empty()
        const rowData = $(this).data('row');
        if (confirm("Are u sure?")) {
            await $.ajax({
                url: `../../api/admin/list_account/fetch_delete_account.php`,
                method: "POST",
                dataType: "JSON",
                data: {
                    employee_id: rowData
                },
                success: function (data) {
                    console.log(data);
                    if (!(data.error)) {
                        // alert(data.message)
                        tableDeliver.ajax.reload()
                    } else {
                        alert(data.error)
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    });
    // $('#table-employees').hide()
    // tableEmployees.destroy().remove()
    $("#employee-tab").on("click", function (e) {
        tableEmployees.draw()
    })
    $("#chef-tab").on("click", function (e) {
        // $('#table-chef').fadeIn(500)
        tableChef.draw()
        // $('#table-employees').hide()
    })
    $("#deliver-tab").on("click", function (e) {
        tableDeliver.draw()
    })
    // $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    //     console.log(e.target)
    //     let targetTableId = $(e.target).attr('data-table-id');
    //     console.log(targetTableId)
    //     // var targetTable = $('#' + targetTableId).DataTable();
    //     // targetTable.columns.adjust().draw();
    // });
    $('#table-chef').on('draw.dt', function () {
        $(this).DataTable().columns.adjust();
        console.log(123)
    });
})