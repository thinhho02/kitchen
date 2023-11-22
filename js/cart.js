$(document).ready(function () {

    //set date +1 cho menu thực đơn 
    let minDate = new Date()
    let maxDate = new Date()

    minDate.setDate(minDate.getDate() + 1)
    maxDate.setDate(maxDate.getDate() + 6)

    const setTimezone = minDate.getTimezoneOffset() * 60000
    // console.log(setTimezone)
    let localMinDate = Number(minDate) - setTimezone
    let localMaxDate = Number(maxDate) - setTimezone

    let setupMinDate = new Date(localMinDate)
    let setupMaxDate = new Date(localMaxDate)
    // console.log(localMinDate)
    let valueMinDate = setupMinDate.toISOString().split("T")[0]
    let valueMaxDate = setupMaxDate.toISOString().split("T")[0]




    // set ngày hiện tại để so sánh database
    let setDate = new Date()
    const offset = setDate.getTimezoneOffset() * 60000
    let c = new Date(setDate.getTime() - offset)
    let currentDate = c.toISOString().split("T")[0]
    // console.log(currentDate)



    $("#date").attr({ "min": valueMinDate, "max": valueMaxDate })
    $("#date").val(valueMinDate)
    let date = $("#date").val()
    let idUser = $("#getId").val()
    // console.log(date)
    const getQuantity = async (valueInput, menuId, receiptId) => {
        const res = await $.ajax({
            url: `api/user/fetch_update_cart.php`,
            method: "POST",
            dataType: "JSON",
            data: {
                quantity: valueInput,
                menu_id: menuId,
                id_receipt: receiptId
            }
        })
        return res
    }

    const getFormCart = async (date) => {
        await $.ajax({
            url: `api/user/fetch_update_cart.php?date=${date}`,
            method: "POST",
            data: {
                idUser: idUser,
                currentDate: currentDate
            },
            dataType: "JSON",
            success: function (data) {
                if (!(data.message)) {
                    $(".cart-footer").attr("style","display: block")

                    // console.log(data)

                    for (let i = 1; i < data.length; i++) {
                        let cart =
                            `<tr class="fadeInUp ftco-animated">
                    <td class="img rounded-circle" style="padding: 20px;">
                        <img src="image/${data[i].image}" alt="" style="width: 70px; height: 70px ">
                    </td>
                    <td class="detail">
                        <span>${data[i].name}</span>
                    </td>
                    <td class="medium-hide right price price_st${data[i].menu_id}">
                        <div class="spinner-border spinner-border-sm spinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="price_menu">${Number(data[i].price).toLocaleString("en-US")}đ</span>
                    </td>
                    <td class="quantity">
                        <div class="row align-items-center btn-quantity" style="margin: 0;">
                            <div class="buy-amount">
                                <button type="button" class="minus-btn" style="border-right: 1px solid black">
                                    <ion-icon name="remove-outline"></ion-icon>
                                </button>
                                <input class="input-quantity" type="number" name="amount" value="${data[i].quantity}" min="1">
                                <input type="hidden" class="menu_id" value="${data[i].menu_id}">
                                <button type="button" class="plus-btn" style="border-left: 1px solid black">
                                    <ion-icon name="add-outline"></ion-icon>
                                </button>
                            </div>
                            <div class="del-product">
                                <input type="hidden" class="delele_menu_id" value="${data[i].menu_id}">
                                <button type="button" class="delete_cart">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </div>
                        </div>

                    </td>
                    <td class="small-hide right price price_st${data[i].menu_id}">
                        <div class="spinner-border spinner-border-sm spinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="price_menu">${Number(data[i].price).toLocaleString("en-US")}đ</span>
                    </td>
                </tr>`
                        // $(".table-cart tbody").remove()
                        $(".table-cart tbody").append(cart)
                    }
                    $(".check-out .subtotal .total p").append(`<span>${Number(data[0].subtotal).toLocaleString("en-US")}đ</span>`)
                } else {

                    let message = `<tr class="fadeInUp ftco-animated"><td colspan="4" style="grid-column: 2/4;"><p style="text-align: center; font-size: 20px;color: #a93737;">${data.message}</p></td></tr>`
                    $(".table-cart tbody").append(message)
                    $(".cart-footer").attr("style","display: none !important")
                }
            },
            complete: function (data) {
                // console.log(data.responseJSON)

                $("#checkout").off("click").on("click", async function () {
                    if (!(data.responseJSON.message)) {
                        console.log(data.responseJSON)
                        let note = $("#addnote").val()
                        await $.ajax({
                            url: `api/user/fetch_update_cart.php`,
                            method: "POST",
                            dataType: "JSON",
                            data: {
                                checkout_receipt: data.responseJSON[0].id_receipt,
                                note: note
                            },
                            success: function (data) {
                                console.log(data)
                                if (data.success === 'ok') {
                                    location.href = "#";
                                }
                            }
                        })
                    }
                    else {
                        // console.log(data.responseJSON)

                        alert("không có đơn hàng nào trong ngày")
                    }
                })


                let receiptId = data.responseJSON[0].id_receipt



                $(".delete_cart").off("click").on("click", async function () {
                    if (confirm("Are u sure?")) {
                        let id_delete = $(this).siblings(".delele_menu_id").val()
                        // console.log(id_delete)
                        await $.ajax({
                            url: `api/user/fetch_update_cart.php`,
                            method: "POST",
                            dataType: "JSON",
                            data: {
                                id_delete: id_delete,
                                id_receipt: receiptId
                            },
                            success: function (data) {
                                $(".table-cart tbody").empty()
                                $(".check-out .subtotal .total p").empty()
                                getFormCart(date)
                            }
                        })
                    }


                })



                $(".plus-btn").off("click").on("click", async function () {
                    $(".check-out .subtotal .total p").empty()
                    let inputElement = $(this).siblings(".input-quantity");
                    let menuId = $(this).siblings(".menu_id").val();
                    $(`.price_st${menuId} .spinner`).css({
                        "opacity": "1"
                    })
                    let valueInput = inputElement.val(parseInt(inputElement.val(), 10) + 1).val()
                    // console.log(inputElement)
                    // console.log(valueInput)

                    await getQuantity(valueInput, menuId, receiptId).then((data) => {
                        // console.log(data)
                        if (!(data.message)) {
                            $(inputElement).val(data.quantity)
                            $(`.price_st${data.menu_id} .price_menu`).html(`${Number(data.price).toLocaleString("en-US")}đ`)
                            $(".check-out .subtotal .total p").append(`<span>${Number(data.subtotal).toLocaleString("en-US")}đ</span>`)

                        }
                    }).catch((e) => console.log(e))
                        .finally(() => {
                            // console.log(data)
                            $(`.price .spinner`).css({
                                "opacity": "0"
                            })
                        })
                })




                $('.minus-btn').off("click").on("click", async function () {
                    $(".check-out .subtotal .total p").empty()
                    let inputElement = $(this).siblings('.input-quantity');
                    let menuId = $(this).siblings(".menu_id").val();
                    $(`.price_st${menuId} .spinner`).css({
                        "opacity": "1"
                    })
                    let valueInput = inputElement.val(Math.max(parseInt(inputElement.val(), 10) - 1, 1)).val()
                    await getQuantity(valueInput, menuId, receiptId).then((data) => {
                        // console.log(data)

                        if (!(data.message)) {
                            $(inputElement).val(data.quantity)
                            $(`.price_st${data.menu_id} .price_menu`).html(`${Number(data.price).toLocaleString("en-US")}đ`)
                            $(".check-out .subtotal .total p").append(`<span>${Number(data.subtotal).toLocaleString("en-US")}đ</span>`)
                        }
                    }).finally(() => {
                        // console.log(data)
                        $(`.price .spinner`).css({
                            "opacity": "0"
                        })
                    })

                });




                $(".input-quantity").off("change").on("change", async function () {
                    $(".check-out .subtotal .total p").empty()
                    let valueInput = Math.max(parseInt($(this).val(), 10), 1)
                    let menuId = $(this).siblings(".menu_id").val();
                    $(`.price_st${menuId} .spinner`).css({
                        "opacity": "1"
                    })
                    $(this).val(valueInput)
                    await getQuantity(valueInput, menuId, receiptId).then((data) => {
                        // console.log(data)
                        if (!(data.message)) {
                            $(this).val(data.quantity)
                            $(`.price_st${data.menu_id} .price_menu`).html(`${Number(data.price).toLocaleString("en-US")}đ`)
                            $(".check-out .subtotal .total p").append(`<span>${Number(data.subtotal).toLocaleString("en-US")}đ</span>`)
                        }
                    }).catch((e) => console.log(e))
                        .finally(() => {
                            // console.log(data)
                            $(`.price .spinner`).css({
                                "opacity": "0"
                            })
                        })
                    // getFormCart(date)

                    // console.log(menuId)

                })
            }
        })
        // return repsonse
    }
    getFormCart(date)





    $("#date").blur(() => {
        $(".table-cart tbody").empty()
        $(".check-out .subtotal .total p").empty()
        let currentMin = $("#date").attr("min")
        let currentMax = $("#date").attr("max")

        // console
        if ($("#date").val() < currentMin) {
            // console.log(current)
            $("#date").val(currentMin)

            date = currentMin
            // console.log(me)
        } else if ($("#date").val() > currentMax) {
            $("#date").val(currentMax)

            date = currentMax
        }
        else {
            date = $("#date").val()

        }
        // console.log(date)
        // console.log(btnValue)
        // getFormMenu(btnValue, date)
        getFormCart(date)
    })



})