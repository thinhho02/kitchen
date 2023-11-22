$(document).ready(function () {
    // const dishId = '';
    $(".btn-cate:first").addClass('active')
    $(".tab-food:first").addClass('show').addClass('active')
    // console.log($(".price").val())
    // START Set DATE min max
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

    $("#date").attr({ "min": valueMinDate, "max": valueMaxDate })
    $("#date").val(valueMinDate)

    // END Set DATE MIN MAX

    let btnValue = 1;
    let date = $("#date").val();
    // console.log(date)


    const getFormCart = async (idMenu, idUser) => {
        // Tạo một đối tượng Date từ chuỗi ngày
        let dateObject = new Date(date);

        // Lấy năm và tháng từ đối tượng Date
        let nam = dateObject.getFullYear();
        let thang = dateObject.getMonth() + 1; // Tháng bắt đầu từ 0

        // Tạo chuỗi mới với định dạng yêu cầu
        let yearMonth = `${nam}-${thang < 10 ? '0' : ''}${thang}`;

        // 
        let day = date
        // console.log(day)
        // console.log(yearMonth)

        const response = await $.ajax({
            url: `api/user/fetch_cart.php`,
            method: "POST",
            data: {
                idMenu: idMenu,
                idUser: idUser,
                yearMonth: yearMonth,
                day: day
            },
            dataType: "JSON"
        })
        return response
    }


    const getFormMenu = async (valueTab, valueDate) => {


        // console.log(current)
        // console.log(date)
        await $.ajax({
            url: `api/user/fetch_menu.php?btnvalue=${valueTab}&date='${valueDate}'`,
            method: "POST",
            dataType: "JSON",
            success: (data) => {
                // console.log(data)
                if (!(data.error)) {
                    if (!(data.nodata)) {
                        $(`#tab-${valueTab} .col-md-12 .menu-wrap`).css({
                            "display": "block"
                        })
                        if ($(`#tab-${valueTab} > p`)) {
                            $(`#tab-${valueTab} > p`).remove()
                        }
                        // let menuWrap = `<div class="col-md-12 col-lg-6 col-xl-6">
                        //                             <div class="menu-wrap">

                        //                             </div>
                        //                         </div>`
                        for (let i = 0; i < data.length; i++) {
                            // console.log(data)
                            if (data[i].menu_id !== $(`#menus_id${data[i].menu_id}`).val()) {
                                // console.log(data)

                                let tab1 =
                                    `<div class="menus fadeInUp ftco-animated">
                                    <div class="link-addNow">
                                        <a href="" class="btn addNow">Đặt ngay</a>
                                    </div>
                                    <div class="d-flex link-detail">
                                        <a href="#" class="menu-img img" style="background-image: url(image/${data[i].image});"></a>
                                        <div class="text">
                                            <div class="d-flex">
                                                <div class="one-half">
                                                    <h3>${data[i].name}</h3>
                                                </div>
                                                <div class="one-forth">
                                                    <span class="price">${Number(data[i].price).toLocaleString("en-US")}đ</span>
                                                </div>
                                            </div>
                                            <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>, <span>Tomatoe</span></p>
                                        </div>
                                    </div>
                                    <div class="add-cart">        
                                        <button type="button" class="btnaddcart btn link-add" value="addcart">Thêm giỏ hàng</button>
                                        <input type="hidden" class="dishesId" id="dishes_id${data[i].dish_id}" name="dishes_id" value=${data[i].dish_id}>
                                        <input type="hidden" class="menusId" id="menus_id${data[i].menu_id}" name="menus_id" value=${data[i].menu_id}>
                                    </div>
                                </div>`
                                if (i < 3) {
                                    // console.log(data)
                                    $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).empty()
                                    $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).append(tab1)
                                    $(`#tab-${data[0].category_id} .col-md-12:last .menu-wrap`).css({
                                        "opacity": "0"
                                    })
                                } else {
                                    $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).empty()
                                    $(`#tab-${data[0].category_id} .col-md-12:last .menu-wrap`).append(tab1)
                                    $(`#tab-${data[0].category_id} .col-md-12:last .menu-wrap`).css({
                                        "opacity": "1"
                                    })
                                }
                                // dishId = $(".dishes_id3")
                            }
                            // let size = data.length/3 


                        }
                    }
                    else {
                        // console.log(data)
                        $(`#tab-${valueTab} .col-md-12 .menu-wrap`).empty()
                        $(`#tab-${valueTab} .col-md-12 .menu-wrap`).css({
                            "display": "none"
                        })
                        if ($(`#tab-${valueTab} p`).length < 1) {
                            $(`#tab-${valueTab}`).append(`<p class="p fadeInUp ftco-animated" style="width: 100%; text-align: center;">${data.nodata}</p>`)
                            // $(`#tab-${valueTab} p:last`).remove()
                        }

                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            },
            complete: function (data) {
                $(`.btnaddcart`).off("click").on("click", function () {
                    let idMenu = $(this).siblings(".menusId").val()
                    let idUser = $("#getId").val()
                    // console.log(data.responseJSON)
                    // console.log(idMenu)
                    getFormCart(idMenu, idUser).then((data) => {
                        alert(data.message)
                    })
                })


            }
        })
    }
    getFormMenu(btnValue, date);
    $(".btn-cate").click(function () {

        btnValue = $(this).attr("value");
        // console.log(btnValue)
        getFormMenu(btnValue, date)

    })

    $("#date").blur(() => {
        $(`.tab-food .col-md-12 .menu-wrap`).empty()
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
        getFormMenu(btnValue, date)
    })
    // getFormMenu();
    // console.log(dishId)
})






