const id = $("#getId").val()

$("#confirmPassword").on("input", () => {
    // $("#email ~ i").css({
    //     "background-color": "white"
    //     // "transition" : "all 0.3s ease-in-out",
    //     // "transform": "translateX(10px)"
    // })
    $("#confirmPassword").removeClass("active");
})
$("#oldPassword").on("input", () => {
    // $("#password ~ i").css({
    //     "background-color": "white"
    //     // "transition" : "all 0.3s ease-in-out",
    //     // "transform": "translateX(10px)"
    // })
    $("#oldPassword").removeClass("active")
})

$(".toast-close").click(() => {
    $(".toast").removeClass("active")
    setTimeout(() => {
        $(".progress").removeClass("active")
    }, 300)
})
const getChangeForm = async () => {
    let oldPass = $("#oldPassword").val()
    let newPass = $("#newPassword").val()
    let confirmPass = $("#confirmPassword").val()
    let submitForm = $("#submitForm").val()

    $.ajax({
        url: `api/user/fetch_profile.php?submit=${submitForm}&id=${id}`,
        method: "POST",
        dataType: "JSON",
        data: {
            old_pass: oldPass,
            new_pass: newPass,
            confirm_pass: confirmPass
        },
        success: function (data) {
            // console.log(data)
            if (!(data.error)) {
                if (!(data.message)) {
                    if (!(data.oldpass)) {
                        if (!(data.confirm)) {
                            if (data.status) {
                                // console.log(123)
                                $("#form_profile").css({ "display": "block" })
                                $("#change_password_form").css({ "display": "none" })
                                // $("change_password_form").reset()
                                $(".text-2").html(data.success)
                                $(".toast").addClass("active")
                                $(".progress").addClass("active")
                                // setTimeout(() => {


                                // }, 300)
                                setTimeout(() => {
                                    $(".toast").removeClass("active")
                                }, 5000)
                                setTimeout(() => {
                                    $(".progress").removeClass("active")
                                }, 5300)
                                $("#oldPassword").val("")
                                $("#newPassword").val("")
                                $("#confirmPassword").val("")
                                $("#lableCofirm span").remove()
                                $("#lableOld span").remove()

                            }
                        } else {
                            $("#lableCofirm").append(`<span style="color:red"> ${data.confirm}</span>`)
                            if ($("#lableCofirm span").length == 2) {
                                $("#lableCofirm span:first").remove()
                            }
                            $("#confirmPassword").addClass("active")
                            $("#lableOld span").remove()
                            // alert(data.confirm)
                        }
                    } else {
                        $("#lableOld").append(`<span style="color:red"> ${data.oldpass}</span>`)
                        if ($("#lableOld span").length == 2) {
                            $("#lableOld span:first").remove()
                        }
                        $("#oldPassword").addClass("active")
                        // alert(data.oldpass)
                    }
                } else {
                    alert(data.message)
                }
            }
        }
    })
}


$("#submitForm").on("click", async (e) => {
    // console.log(123)
    await getChangeForm()
})

const getOrderHistory = async () => {
    await $.ajax({
        url: `api/user/fetch_order_history.php`,
        method: "POST",
        dataType: "JSON",
        data: {
            user_id: id
        },
        success: function (data) {
            console.log(data)
            $("#orderUser .col-sm-12").empty();
            if (!(data.message)) {
                for (let i = 0; i < data.length; i++) {
                    let listOrder =
                        `<div class="d-flex align-items-center justify-content-between btn-dropdown ${data[i].id} header" type="button">
                            <h4 class="px-3 font-weight-bold color-black m-0">${data[i].date}</h4>
                            <ion-icon class="px-3" name="chevron-down"></ion-icon>
                        </div>
    
                        <div class="order_detail ${data[i].id}">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="min-width: 150px;">Mã HĐ</th>
                                            <th scope="col" style="min-width: 140px;">Tổng tiền</th>
                                            <th scope="col" style="min-width: 280px;">Ghi chú</th>
                                            <th scope="col" style="min-width: 150px;">Ngày nhận</th>
                                            <th scope="col" style="min-width: 130px;">Trạng thái</th>
                                            <th scope="col" style="min-width: 120px;"></th>
    
                                        </tr>
                                    </thead>
                                    <tbody class="menu_modal">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
    
                        <div class="d-flex align-items-center justify-content-end p-3 debt_month ${data[i].id}" style="font-size: 18px; color: black">
                            <div class="mx-3"><span class="font-weight-bold">Tổng tiền: </span><span class="number_debt">${Number(data[i].total).toLocaleString("en-US")} VNĐ</span></div>
                            <span class="d-flex align-items-center status-payment"></span>
                        </div>`
                    $("#orderUser .col-sm-12").append(listOrder);
                    let status = data[i].status == 0 ? `<ion-icon class="mx-2" name="close-circle-outline" style="color: red"></ion-icon> Chưa thanh toán` : `<ion-icon class="mx-2" name="checkmark-circle" style="color: green"></ion-icon> Đã thanh toán`
                    $(`.debt_month.${data[i].id} .status-payment`).append(status)

                    for (let j = 0; j < data[i].receipts.length; j++) {
                        let listReceipt =
                            `<tr class="receipt${data[i].receipts[j].receipt_id}">
                                <th scope="row">${data[i].receipts[j].receipt_id}</th>
                                <td>${Number(data[i].receipts[j].price).toLocaleString("en-US")} VNĐ</td>
                                <td>${data[i].receipts[j].note}</td>
                                <td>${data[i].receipts[j].created_time}</td>
                                <td class="status-receipt"></td>
                                <td style="vertical-align: middle;">
                                    <span class="d-flex justify-content-around action">
                                        <button type="button" class="btn action_btn btn_modal" data-toggle="modal" data-target="#modelId" value="${data[i].receipts[j].receipt_id}"><ion-icon name="eye-outline"></ion-icon></button>
                                    </span>
                                </td>
    
                            </tr>`
                        $(`.order_detail.${data[i].id} .menu_modal`).append(listReceipt);
                        if (data[i].receipts[j].status === 'confirming') {
                            $(`.receipt${data[i].receipts[j].receipt_id} .status-receipt`).html("Chờ xác nhận")
                            $(`.receipt${data[i].receipts[j].receipt_id} .action`).append(`<button type="button" class="btn action_btn delete" value="${data[i].receipts[j].receipt_id}"><ion-icon name="trash"></ion-icon></button>`)
                        }
                        else if (data[i].receipts[j].status === 'confirmed') {
                            $(`.receipt${data[i].receipts[j].receipt_id} .status-receipt`).html("Đã xác nhận")
                        }
                        else if (data[i].receipts[j].status === 'shipping') {
                            $(`.receipt${data[i].receipts[j].receipt_id} .status-receipt`).html("Đang giao")
                        }
                        else if (data[i].receipts[j].status === 'shipped') {
                            $(`.receipt${data[i].receipts[j].receipt_id} .status-receipt`).html("Đã giao")
                        }
                        else if (data[i].receipts[j].status === 'success') {
                            $(`.receipt${data[i].receipts[j].receipt_id} .status-receipt`).html("Đã giao")
                        }
                    }
                }
            }
            else{
                $("#orderUser .col-sm-12").append(`<p class="text-center font-weight-bold" style="color: black; font-size: 20px;">${data.message}</p>`)
            }

        },
        complete: function (data) {
            // console.log(data.responseJSON[0].receipts)
            function getReceiptById(receiptId) {
                for (let i = 0; i < data.responseJSON.length; i++) {
                    return data.responseJSON[i].receipts.find(function (receipt) {
                        return receipt.receipt_id === receiptId;
                    });
                }

            }
            $(".order_detail").hide()
            $(`.btn-dropdown`).off("click").on("click", function () {
                if ($(this).find("ion-icon").hasClass("rotated") === false) {
                    $(this).next(".order_detail").show()
                    $(this).find("ion-icon").addClass("rotated").css({
                        "transform": "rotate(180deg)"
                    })
                } else {
                    $(this).next(".order_detail").hide()
                    $(this).find("ion-icon").removeClass("rotated").css({
                        "transform": "rotate(0deg)"
                    })
                }

            })

            $(".btn_modal").off("click").on("click", async function () {
                $(".modal-body .receipt_detail").empty()
                let btnModalReceipt = $(this).val()
                let total = getReceiptById(btnModalReceipt)
                // console.log(total)
                await $.ajax({
                    url: `api/user/fetch_order_history.php`,
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        receipt_id: btnModalReceipt
                    },
                    success: function (data) {
                        $(".modal_total").html(`${Number(total.price).toLocaleString("en-US")} VNĐ`)
                        let conut = 0
                        for (let i = 0; i < data.length; i++) {
                            let modalReceipt =
                                `<tr class="menu${data[i].menu_id}">
                                                    <td class="center count">${++conut}</td>
                                                    <td class="left name"></td>
                                                    <td class="center quantity">${data[i].quantity}</td>
                                                    <td class="right menu_price">${Number(data[i].menu_price).toLocaleString("en-US")} VNĐ</td>
                                                    <td class="right receipt_total">${Number(data[i].price).toLocaleString("en-US")} VNĐ</td>
                                                </tr>`
                            $(".modal-body .receipt_detail").append(modalReceipt)
                            let name = new Array()
                            for (let j = 0; j < data[i].menu_list.length; j++) {
                                name.push(data[i].menu_list[j].name)
                                $(`.modal-body .receipt_detail .menu${data[i].menu_id} .name`).html(name.join("<br>"))
                            }
                        }

                    }
                })
            })

            $(".delete").off("click").on("click", async function () {
                if (confirm("Xóa đơn hàng?")) {
                    let id_delete = $(this).val()
                    await $.ajax({
                        url: `api/user/fetch_order_history.php`,
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            delete_id: id_delete
                        },
                        success: function (data) {
                            getOrderHistory()
                            getPay()

                        }, complete: function (data) {
                            $(`.order_detail.${data.responseJSON.id}`).show()
                        }
                    })
                }

            })
        }
    })
}

const getPay = async () => {
    const setDate = new Date()
    const offset = setDate.getTimezoneOffset() * 60000
    const c = new Date(setDate.getTime() - offset)
    const currentDate = c.toISOString().split("T")[0]
    // console.log(currentDate)
    await $.ajax({
        url: `api/user/fetch_pay.php`,
        method: "POST",
        dataType: "JSON",
        data: {
            user_id: id,
            current_date: '2024-1-1'
        },
        success: function (data) {
            $(".pay_body").empty()
            $("#checkout-payment").removeAttr("style")
            $(".btn_checkout").removeAttr("disabled")
            if (!(data.message)) {
                for (let i = 0; i < data.length; i++) {
                    let listDebt = `<tr class="debt${data[i].id}">
                                        <th scope="row">
                                            <label class="labelIdCheck" for="payIdCheck${data[i].id}"></label>
                                            <input type="checkbox" class="check-id" id="payIdCheck${data[i].id}" value="${data[i].id}">
                                        </th>
                                        <td>${Number(data[i].total).toLocaleString("en-US")} VNĐ</td>
                                        <td>${data[i].date}</td>
                                    </tr>`
                    $(".pay_body").append(listDebt)
                }
            } else {
                $("#checkout-payment").attr("style", "display: none !important;")
                $(".btn_checkout").attr("disabled", "disabled")
                $(".pay_body").html(`<tr>
                                            <td class="text-center" colspan="3"><span>${data.message}</span></td>
                                    </tr>`)
            }
        },
        complete: function (data) {

            function getPayById(payId) {
                let payTotal = data.responseJSON.find(function (pay) {
                    return pay.id === payId;
                });
                return Number(payTotal.total)
            }

            let payTotalPrice = 0
            let paymentId = new Array()
            $(".check-id").on("change", function () {
                let o = $(this).val()
                if ($(this).is(":checked")) {
                    paymentId.push(o)
                    payTotalPrice += getPayById(o)
                } else {
                    const index = paymentId.indexOf(o);
                    if (index > -1) { // only splice array when item is found
                        paymentId.splice(index, 1); // 2nd parameter means remove one item only
                    }
                    payTotalPrice -= getPayById(o)
                }
                // console.log(paymentId)
                $(".total_debt").html(`${Number(payTotalPrice).toLocaleString("en-US")} VNĐ`)

            })
            $(".btn_checkout").off("click").on("click", async function () {
                if (payTotalPrice === 0 || paymentId == []) {
                    alert("Vui lòng chọn kỳ để thanh toán");
                } else {
                    await $.ajax({
                        url: `vnpay_php/vnpay_create_payment.php`,
                        method: 'POST',
                        dataType: "JSON",
                        data: {
                            total: payTotalPrice,
                            payment_id: paymentId.join(","),
                            bank_code: ""
                        },
                        success: function (data) {
                            if (!(data.message)) {
                                location.href = `${data.url}`
                            } else {
                                alert(data.message)
                            }
                            // console.log(data)
                        }
                    })
                    // alert("123")
                }
            })
        }
    })
}
getPay()

getOrderHistory()
