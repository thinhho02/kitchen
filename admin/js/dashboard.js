$(document).ready(function () {

    $(".nav-link").removeClass("active")
    $("#statistic").addClass("active")
    const colorsDonut = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'];


    let currentDate = $("#selectBar").val()

    const localMonth = new Date();
    let currentMonth = localMonth.getMonth() + 1



    $("#selectBar").on("change", function () {
        let SelectColors = [];
        $("#selectBar option").each((index, e) => {
            if ($("#selectBar option")[index].value === $(this).val()) {
                SelectColors = colorsDonut[index]
            }
        })
        currentDate = $(this).val()

        tableUser.ajax.reload()
        tableResources.ajax.reload();

        getTopBuyer(currentMonth, currentDate)
        getBar(currentDate, SelectColors)
    })


    $(".label-donut").each(function (index) {
        if (index < colorsDonut.length) {
            $(this).css("background-color", colorsDonut[index])
        }
    })

    function chartBar(xBar, yBar, color) {

        // let yUnit = y.map((num) => num / 100 + ",K")

        let optionsBar = {
            chart: {
                id: 'chartBar',
                type: 'bar',
                height: '310',
                // width: '350',
                events: {
                    click: function (event, chartContext, config) {

                        // console.log(config)
                        let selectedColumn = config.config.xaxis.categories[config.dataPointIndex];
                        let selectedValue = config.config.series[config.seriesIndex].data[config.dataPointIndex];
                        let splited = selectedColumn.split("/")


                        currentMonth = splited[0]
                        currentDate = splited[1]

                        tableUser.ajax.reload()
                        tableResources.ajax.reload();

                        getTopBuyer(splited[0], splited[1])

                    }
                }
            },
            colors: color,
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 10,
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'last',
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Bán được',
                data: yBar
            }],
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: xBar,
                labels: {
                    style: {
                        colors: '#333',
                        fontSize: '12px',
                    }
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    style: {
                        colors: '#333',
                        fontSize: '12px',
                    }
                },
            },

            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return Number(val).toLocaleString("en-US") + " VNĐ";
                    }
                }
            },

        }
        const chartBar = new ApexCharts(document.querySelector("#chart-bar"), optionsBar);
        // chartBar.resetSeries()

        chartBar.render();
        // chartBar.destroy()

    }






    // console.log(colorsDonut)


    function chartsDonut(x, y) {
        // Chart options


        let optionsDonut = {
            chart: {
                type: 'donut',
                height: '150',
                width: '180',
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        // console.log(config)
                        const selectedLabel = config.w.config.labels[config.dataPointIndex];
                        const selectedColors = config.w.config.colors[config.dataPointIndex];
                        // let selectedValue = config.config.series[0];
                        // console.log(selectedLabel)
                        // console.log(colorsDonut[config.dataPointIndex])
                        if (selectedLabel != currentDate) {
                            currentDate = selectedLabel
                            color = colorsDonut[config.dataPointIndex]
                            $("#selectBar").val(currentDate)

                            getBar(currentDate, color)
                            getTopBuyer(currentMonth, selectedLabel)

                            tableUser.ajax.reload()
                            tableResources.ajax.reload();


                        }



                    },

                },

            },
            // width: "300",
            // height: "150",
            series: y,
            labels: x,
            colors: colorsDonut,
            legend: {
                show: false,
                // floating: true,



            },
            dataLabels: {
                enabled: true,
                // textAnchor: 'middle',
                offset: -10,
                // offsetY: 10,
                style: {
                    fontSize: '10px'
                },

            },
            plotOptions: {
                pie: {
                    customScale: 1,
                    donut: {
                        expandOnClick: true,
                        size: '50%'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return Number(val).toLocaleString("en-US") + " VNĐ";
                    }
                },
                onDatasetHover: {
                    highlightDataSeries: true,
                },
            }

        };


        let chartDonut = new ApexCharts(document.querySelector("#chart-pie"), optionsDonut);


        chartDonut.render();
    }


    const getBar = async (date, colorsDonut) => {
        await $.ajax({
            url: "../api/admin/chart/fetch_bar.php",
            method: "POST",
            dataType: "JSON",
            data: {
                date: date
            },
            success: function (data) {
                // console.log(data)
                $("#chart-bar").empty()
                $(".total-this-year").html(`${Number(data.sum).toLocaleString("en-US")} VNĐ`);
                let xaxis = data.x
                let yaxis = data.y


                chartBar(xaxis, yaxis, colorsDonut)
            }
        })
    }

    const getDonut = async () => {
        await $.ajax({
            url: "../api/admin/chart/fetch_donut.php",
            method: "POST",
            dataType: "JSON",
            success: function (data) {

                let sum = Number(data.sum)
                let xaxis = data.x
                let yaxis = data.y.map(Number)
                let valueYear = yaxis.slice(0, 2)
                let valueTrending = valueYear[0] - valueYear[1]
                let percentIncrease = valueTrending / sum * 100;
                $(".value_trending").html(`${valueTrending.toLocaleString("en-US")} VNĐ`)
                if (Number(percentIncrease.toFixed(1)) > 0) {
                    // <ion-icon name="trending-down-outline"></ion-icon> #dc3545
                    $(".color_trending").css("background-color", "#E6FFFA")
                    $(".color_trending ion-icon").attr("name", "trending-up-outline").css("color", "#28a745")
                    $(".trending").html(`+${Number(percentIncrease.toFixed(1))}%`)
                } else {
                    $(".color_trending").css("background-color", "#fbf2ef")
                    $(".color_trending ion-icon").attr("name", "trending-down-outline").css("color", "#dc3545")
                    $(".trending").html(`${Number(percentIncrease.toFixed(1))}%`)
                }
                chartsDonut(xaxis, yaxis)
            }
        })
    }

    const getTopBuyer = async (month, year) => {

        await $.ajax({
            url: "../api/admin/fetch_top_buyer.php",
            method: "POST",
            dataType: "JSON",
            data: {
                top_m: month,
                top_y: year
            },
            success: function (data) {

                $("#top_buyer tbody").empty()
                let count = 0
                for (let i = 0; i < data.length; i++) {
                    const topBuyer =
                        `<tr>
                                        <td class="border-avatar-top" style="background-image: url(../image/top${++count}.png); padding-bottom: 7px;">
                                            <img src="../image/${data[i].avatar}" class="rounded-circle img_avatar" alt="">
                                        </td>
                                        <td class="px-2">${data[i].employee_id}</td>
                                        <td class="px-2">${data[i].full_name}</td>
                                        <td class="px-2" style="text-align: right">${Number(data[i].total).toLocaleString("en-US")} VNĐ</td>
                                    </tr>`
                    $("#top_buyer tbody").append(topBuyer)
                }

                $(".top_month").html(month)
                $(".top_year").html(year)
            }
        })
    }

    getBar(currentDate, colorsDonut)
    getDonut()
    getTopBuyer(currentMonth, currentDate)



    const tableUser = $('#table-user').DataTable({
        info: false,
        // "pagingType": "full_numbers",
        "pageLength": 5,
        ordering: false,
        paging: true,
        dom: 'Btfrt',
        "processing": true,
        "sAjaxSource": "../api/admin/fetch_user.php",
        "fnServerData": function (sSource, aoData, fnCallback) {
            // let limit = "limit 5"
            $.ajax({
                url: sSource,
                type: "POST",
                dataType: "JSON",
                data: {
                    month: currentMonth,
                    year: currentDate,
                    // limit: limit
                },
                success: function (data) {
                    // Call the DataTables callback with the retrieved data
                    fnCallback(data);
                    // console.log(data.data.length)
                    if (data.data.length < 6) {
                        // console.log(data.data.length)
                        $("#footer-table-user .limit_user").css("display", "none");
                    }
                    else {
                        $("#footer-table-user .limit_user").css("display", "block")
                    }

                }, complete: function (data) {

                }
            })
        },

        columns: [{
            "data": null,
            "render": function (data, type, row, meta) {
                // console.log(meta)
                return `<span>${++meta.row}</span>`
            }
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
            "data": "full_name",
            className: 'dt-body-center'
        },
        {
            "data": "email",
            className: 'dt-body-center'
        },
        {
            "data": "number",
            className: 'dt-body-center'
        },
        {
            "data": "count",
            className: 'dt-body-center'
        },
        {
            "data": "sum",
            className: 'dt-body-right',
            "render": function (data, type, row, meta) {
                return `<span>${Number(data).toLocaleString("en-US")} VNĐ</span>`;
            }
        },

        ],


        buttons: [{
            extend: 'print',
            text: 'In danh sách',
            title: 'Danh sách đơn đặt',
        },
        {
            extend: 'excel',
            text: 'Xuất Excel',
            title: `Danh Sách Đơn Hàng_${localMonth.getTime()}`,
            sheetName: 'Nguyên liệu',
        },
        ],
        columnDefs: [
            { targets: 3, width: "30%", }
        ],
        language: {

            emptyTable: "Không có đơn hàng trong tháng",
            // loading: "Không có đơn hàng trong tháng",
            search: "",
            searchPlaceholder: "Nhập dữ liệu",
            zeroRecords: "Không có dữ liệu"

        },
        footerCallback: function (row, data, start, end, display) {
            // let api = this.api();

            // console.log(end)
            let m = new Array()
            display.forEach((e) => {
                m.push(Number(data[e].sum))
            });


            total = m.reduce((a, b) => a + b, 0);
            // console.log(total)
            $(".sub-total-user").html(`${total.toLocaleString("en-US")} VNĐ`)
            // api.column(5).footer().innerHTML = `<span class="mr-4" style="font-weight:bold;letter-spacing: 0.5px">Tổng tiền:</span> ${total.toLocaleString("en-US")} VNĐ`
        }

    });

    $('#table-user').on('length.dt', function (e, settings, len) {
        console.log(len)
        tableUser.ajax.reload();
    });
    $("#footer-table-user").on("click", ".limit_user", function (e) {
        if ($("#footer-table-user").find(".see_more").length == 0) {
            tableUser.page.len(100).draw()
            $(".limit_user").addClass("see_more")
            $(".limit_user").html("Ẩn Bớt")
        } else {
            tableUser.page.len(5).draw()
            $(".limit_user").removeClass("see_more")
            $(".limit_user").html("Xem Thêm")
        }
    })




    // table resources
    const tableResources = $('#table-resources').DataTable({
        info: false,
        // "pagingType": "full_numbers",
        "pageLength": 5,
        ordering: false,
        paging: true,
        // "scrollX": true,
        dom: 'Btfrt',
        "processing": true,

        "sAjaxSource": "../api/admin/fetch_resource_used.php",
        "fnServerData": function (sSource, aoData, fnCallback) {
            // let limit = "limit 5"
            $.ajax({
                url: sSource,
                type: "POST",
                dataType: "JSON",
                data: {
                    month: currentMonth,
                    year: currentDate,
                    // limit: limit
                },
                success: function (data) {
                    fnCallback(data);
                    // console.log(data)
                    if (data.data.length < 6) {
                        // console.log(data.data.length)
                        $("#footer-table-resources .limit_resources").css("display", "none");
                    }
                    else {
                        $("#footer-table-resources .limit_resources").css("display", "block")
                    }
                }, complete: function (data) {

                }
            })
        },
        columns: [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    // console.log(meta)
                    return `<span>${++meta.row}</span>`
                }
            },
            {
                "data": "name",
                className: 'dt-body-center'
            },
            {
                "data": "unit",
                className: 'dt-body-center'
            },
            {
                "data": "quantity",
                className: 'dt-body-center'
            },
            {
                "data": "price",
                className: 'dt-body-right',
                "render": function (data, type, row, meta) {
                    return `<span class="mr-3">${Number(data).toLocaleString("en-US")} VNĐ</span>`;
                }
            },
            {
                "data": "sum",
                className: 'dt-body-right',
                "render": function (data, type, row, meta) {
                    return `<span>${Number(data).toLocaleString("en-US")} VNĐ</span>`;
                }
            },
        ],

        buttons: [{
            extend: 'print',
            text: 'In danh sách',
            title: 'Danh sách nguyên vật liệu',
        },
        {
            extend: 'excel',
            text: 'Xuất Excel',
            title: `Danh Sách Đơn Hàng_${localMonth.getTime()}`,
            sheetName: 'Nguyên liệu',
        },
        ],
        // columnDefs: [{
        //     targets: 0,
        //     orderable: false,
        // },

        // {
        //     targets: 3,
        //     width: "30%",
        // }
        // ],

        language: {

            emptyTable: "Không có nguyên liệu trong tháng",
            loading: "Không có đơn hàng trong ngày",
            search: "",
            searchPlaceholder: "Nhập dữ liệu",
            zeroRecords: "Không có dữ liệu"

        },
        footerCallback: function (row, data, start, end, display) {
            // let api = this.api();

            // console.log(end)
            let m = new Array()
            display.forEach((e) => {
                m.push(Number(data[e].sum))
            });


            total = m.reduce((a, b) => a + b, 0);
            // console.log(total)
            $(".sub-total-resource").html(`${total.toLocaleString("en-US")} VNĐ`)
            // api.column(5).footer().innerHTML = `<span class="mr-4" style="font-weight:bold;letter-spacing: 0.5px">Tổng tiền:</span> ${total.toLocaleString("en-US")} VNĐ`
        }
    });

    $('#table-resources').on('length.dt', function (e, settings, len) {
        console.log(len)
        tableResources.ajax.reload();
    });
    $("#footer-table-resources").on("click", ".limit_resources", function (e) {
        if ($("#footer-table-resources").find(".see_more").length == 0) {
            tableResources.page.len(100).draw()
            $(".limit_resources").addClass("see_more")
            $(".limit_resources").html("Ẩn Bớt")
        } else {
            tableResources.page.len(5).draw()
            $(".limit_resources").removeClass("see_more")
            $(".limit_resources").html("Xem Thêm")
        }
    })
})