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
    const valueMinDate = setupMinDate.toISOString().split("T")[0]
    const valueMaxDate = setupMaxDate.toISOString().split("T")[0]

    // date food
    $("#date").attr({ "min": valueMinDate, "max": valueMaxDate })
    $("#date").val(valueMinDate)

    //date menu
    $("#date_menu").attr({ "min": valueMinDate, "max": valueMaxDate })
    $("#date_menu").val(valueMinDate)

    // END Set DATE MIN MAX

    let btnValue = 1;
    let date = $("#date").val();
    let date_menu = $("#date_menu").val();
    // console.log(date_menu)


    const getFormCart = async (idMenu, idUser, date_cart) => {
        // Tạo một đối tượng Date từ chuỗi ngày
        let dateObject = new Date(date_cart);

        // Lấy năm và tháng từ đối tượng Date
        let nam = dateObject.getFullYear();
        let thang = dateObject.getMonth() + 1; // Tháng bắt đầu từ 0

        // Tạo chuỗi mới với định dạng yêu cầu
        let yearMonth = `${nam}-${thang < 10 ? '0' : ''}${thang}`;

        // 
        let day = date_cart
        console.log(date_cart)
        console.log(yearMonth)
        console.log(idMenu)
        console.log(idUser)
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

    const getFormMenu = async (valueDateMenu) => {
        await $.ajax({
            url: `api/user/fetch_menu.php?dateMenu=${valueDateMenu}`,
            method: "POST",
            dataType: "JSON",
            success: function (data) {
                // data[i].menu_list = undefined;
                console.log(data)
                if (!(data.error)) {
                    if (!(data.nodata)) {
                        $(`#tab-menu`).removeAttr("style")
                        $(`#tab-menu .col-md-12 .menu-wrap`).css({
                            "display": "block"
                        })

                        let combo = 0
                        for (let i = 0; i < data.length; i++) {
                            if (data[i].menu_id !== $(`#menus_id${data[i].menu_id}`).val()) {
                                // console.log(data)

                                let tabMenu =
                                    `<div class="menus menud${data[i].menu_id} fadeInUp ftco-animated">
                                        <div class="link-addNow">
                                            <button type="button" class="btn addNow" value="${data[i].menu_id}">Đặt ngay</button>
                                        </div>
                                    <div class="d-flex link-detail">
                                        <div class="image_menu" type="button" data-toggle="modal" data-target="#modelId">
                                            <div class="menu-img img" style="background-image: url(image/${data[i].menu_list[0].image});"></div>
                                        </div>
                                        <div class="text">
                                            <button type="button" class="d-flex btn btn_modal" value="${data[i].menu_id}" data-toggle="modal" data-target="#modelId">
                                                <div class="one-half">
                                                    <h3>Combo ${++combo}</h3>
                                                </div>
                                                <div class="one-forth">
                                                    <span class="price">${Number(data[i].price).toLocaleString("en-US")}đ</span>
                                                </div>
                                            </button>
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="add-cart">        
                                        <button type="button" class="btnaddcart btn link-add" value="addcart">Thêm giỏ hàng</button>
                                        <input type="hidden" class="menusId" id="menus_id${data[i].menu_id}" value=${data[i].menu_id}>
                                    </div>
                                </div>`

                                if (i < 3) {
                                    // console.log(data)
                                    // $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).empty()
                                    $(`#tab-menu .col-md-12:first .menu-wrap`).append(tabMenu)
                                    $(`#tab-menu .col-md-12:last .menu-wrap`).css({
                                        "opacity": "0"
                                    })

                                } else {
                                    // $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).empty()
                                    $(`#tab-menu .col-md-12:last .menu-wrap`).append(tabMenu)
                                    $(`#tab-menu .col-md-12:last .menu-wrap`).css({
                                        "opacity": "1"
                                    })
                                }
                                let menuList = new Array()
                                // console.log(data[i].menu_list.length)
                                for (let j = 0; j < data[i].menu_list.length; j++) {
                                    menuList.push(`<span>${data[i].menu_list[j].name}</span>`)
                                }
                                $(`#tab-menu .col-md-12 .menu-wrap .menud${data[i].menu_id} .text p`).append(menuList.join(", "))

                            }
                        }
                    } else {
                        $(`#tab-menu .col-md-12 .menu-wrap`).empty()
                        $(`#tab-menu .col-md-12 .menu-wrap`).css({
                            "display": "none"
                        })
                        $(`#tab-menu`).append(`<p class="p fadeInUp ftco-animated" style="width: 100%; text-align: center;">${data.nodata}</p>`)
                    }
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            },
            complete: function (data) {
                // console.log(data.responseJSON)
                function getMenuById(menuId) {
                    return data.responseJSON.find(function (menu) {
                        return menu.menu_id === menuId;
                    });
                }
                $('.btn_modal').off("click").on("click", function () {
                    $(".menu_modal").empty()
                    let count = 0
                    let btnModalValue = $(this).val();
                    let select = getMenuById(btnModalValue);

                    for (i = 0; i < select.menu_list.length; i++) {
                        let addModal = `
                                    <tr>
                                        <th scope="row">${++count}</th>
                                        <td class="image_dish-modal"><img src="image/${select.menu_list[i].image}" style="height: 80px;" width="80px" alt="..." class="img-thumbnail"></td>
                                        <td class="name_dish-modal">${select.menu_list[i].name}</td>
                                        <td class="cate_dish-modal">${select.menu_list[i].category}</td>
                                        <td class="resources_dish-modal${select.menu_list[i].dish_id}">${select.menu_list[i].resources.join(", ")}</td>
                                        <td style="font-size: 20px;">
                                            <span class="d-flex align-items-center review${select.menu_list[i].dish_id}"></span>
                                        </td>
                                    </tr>`
                        $(".menu_modal").append(addModal)
                        if (select.menu_list[i].avg_star != 0) {
                            $(`.review${select.menu_list[i].dish_id}`).append(`<span style="line-height: 1;">${select.menu_list[i].avg_star.toFixed(1)}</span> <ion-icon name="star" style="color: gold; margin-left: 5px; font-size: 21px;"></ion-icon>`)
                        } else {
                            $(`.review${select.menu_list[i].dish_id}`).append(`<span style="font-size: 16px">Chưa có đánh giá</span>`)
                        }
                    }

                });

                $('.image_menu').off("click").on("click", function () {

                    $(".menu_modal").empty()
                    let count = 0
                    let btnModalValue = $(this).next().find('.btn_modal').val();
                    let select = getMenuById(btnModalValue);

                    for (i = 0; i < select.menu_list.length; i++) {
                        let addModal = `
                                    <tr>
                                        <th scope="row">${++count}</th>
                                        <td class="image_dish-modal"><img src="image/${select.menu_list[i].image}" style="height: 80px;" width="80px" alt="..." class="img-thumbnail"></td>
                                        <td class="name_dish-modal">${select.menu_list[i].name}</td>
                                        <td class="cate_dish-modal">${select.menu_list[i].category}</td>
                                        <td class="resources_dish-modal${select.menu_list[i].dish_id}">${select.menu_list[i].resources.join(", ")}</td>
                                        <td style="font-size: 20px;">
                                            <span class="d-flex align-items-center review${select.menu_list[i].dish_id}"></span>
                                        </td>
                                    </tr>`
                        $(".menu_modal").append(addModal)
                        // console.log(select.menu_list[i].avg_star)
                        if (select.menu_list[i].avg_star != 0) {
                            $(`.review${select.menu_list[i].dish_id}`).append(`<span style="line-height: 1;">${select.menu_list[i].avg_star.toFixed(1)}</span> <ion-icon name="star" style="color: gold; margin-left: 5px; font-size: 21px;"></ion-icon>`)
                        } else {
                            $(`.review${select.menu_list[i].dish_id}`).append(`<span style="font-size: 16px">Chưa có đánh giá</span>`)
                        }
                    }
                    // console.log(btnModalValue);
                });

                $(`.addNow`).off("click").on("click", async function () {
                    let idMenu = $(this).val()
                    let idUser = $("#getId").val()
                    date_menu = $("#date_menu").val()

                    await getFormCart(idMenu, idUser, date_menu).then((data) => {
                        localStorage.setItem("date", date_menu);
                        location.href = 'cart.php';
                    })
                })


                $(`#tab-menu`).off("click").on("click", ".btnaddcart",async function () {
                    let idMenu = $(this).siblings(".menusId").val()
                    let idUser = $("#getId").val()
                    date_menu = $("#date_menu").val()
                    console.log(idUser)
                    console.log(idMenu)
                    console.log(date_menu)

                    await getFormCart(idMenu, idUser, date_menu).then((data) => {
                        alert(data.message)
                    })
                })


            }
        })
    }


    const getFormFood = async (valueTab, valueDate) => {


        // console.log(current)
        // console.log(date)
        await $.ajax({
            url: `api/user/fetch_food.php?btnvalue=${valueTab}&date='${valueDate}'`,
            method: "POST",
            dataType: "JSON",
            success: (data) => {
                console.log(data)
                if (!(data.error)) {
                    if (!(data.nodata)) {
                        $(`#tab-${valueTab} .col-md-12 .menu-wrap`).css({
                            "display": "block"
                        })
                        $(`#tab-${valueTab}`).removeAttr("style")
                        // if ($(`#tab-${valueTab} > p`)) {
                        //     $(`#tab-${valueTab} > p`).remove()
                        // }
                        // let menuWrap = `<div class="col-md-12 col-lg-6 col-xl-6">
                        //                             <div class="menu-wrap">

                        //                             </div>
                        //                         </div>`
                        for (let i = 0; i < data.length; i++) {
                            // console.log(data)
                            if (data[i].menu_id !== $(`#menus_id${data[i].menu_id}`).val()) {
                                // console.log(data)

                                let tabFood =
                                    `<div class="menus fadeInUp ftco-animated">
                                    <div class="d-flex link-detail">
                                        <a href="detail.php?id=${data[i].menu_id}" class="menu-img img" style="background-image: url(image/${data[i].image});"></a>
                                        <div class="text">
                                            <a href="detail.php?id=${data[i].menu_id}" class="d-flex">
                                                <div class="one-half">
                                                    <h3>${data[i].name}</h3>
                                                </div>
                                                <div class="one-forth">
                                                    <span class="price">${Number(data[i].price).toLocaleString("en-US")}đ</span>
                                                </div>
                                            </a>
                                            <p><span>${data[i].resources.join(", ")}</span</p>
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
                                    // $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).empty()
                                    $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).append(tabFood)
                                    $(`#tab-${data[0].category_id} .col-md-12:last .menu-wrap`).css({
                                        "opacity": "0"
                                    })
                                } else {
                                    // $(`#tab-${data[0].category_id} .col-md-12:first .menu-wrap`).empty()
                                    $(`#tab-${data[0].category_id} .col-md-12:last .menu-wrap`).append(tabFood)
                                    $(`#tab-${data[0].category_id} .col-md-12:last .menu-wrap`).css({
                                        "opacity": "1"
                                    })
                                }

                            }


                        }
                    }
                    else {
                        $(`.tab-food .col-md-12 .menu-wrap`).css({
                            "display": "none"
                        })
                        $(`#tab-${valueTab}`).append(`<p class="p fadeInUp ftco-animated" style="width: 100%; text-align: center;">${data.nodata}</p>`)


                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            },
            complete: function (data) {
                $(`.tab-food`).off("click").on("click", ".btnaddcart",function () {
                    let idMenu = $(this).siblings(".menusId").val()
                    let idUser = $("#getId").val()
                    date = $("#date").val();
                    // console.log(data.responseJSON)
                    // console.log(idMenu)
                    getFormCart(idMenu, idUser, date).then((data) => {
                        alert(data.message)
                    })
                })


            }
        })
    }
    getFormFood(btnValue, date);
    getFormMenu(date_menu);
    $(".btn-cate").click(function () {
        $(`.tab-food`).attr("style", "height: 60px")
        $(`.tab-food p`).remove()
        $(`.tab-food .col-md-12 .menu-wrap`).css({
            "display": "none"
        })
        $(`.tab-food .col-md-12 .menu-wrap`).empty()
        btnValue = $(this).attr("value");
        // console.log(btnValue)
        getFormFood(btnValue, date)

    })

    $("#date").blur(() => {
        $(`.tab-food`).attr("style", "height: 60px")
        
        $(`.tab-food .col-md-12 .menu-wrap`).empty()
        $(`.tab-food p`).remove()
        const currentMin = $("#date").attr("min")
        const currentMax = $("#date").attr("max")

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
        getFormFood(btnValue, date)
    })


    $("#date_menu").blur(() => {
        $(`#tab-menu`).attr("style", "height: 60px")
        $(`#tab-menu .col-md-12 .menu-wrap`).empty()
        $(`#tab-menu > p`).remove()
        const currentMin = $("#date_menu").attr("min")
        const currentMax = $("#date_menu").attr("max")

        // console
        if ($("#date_menu").val() < currentMin) {
            // console.log(current)
            $("#date_menu").val(currentMin)

            date_menu = currentMin
            // console.log(me)
        } else if ($("#date_menu").val() > currentMax) {
            $("#date_menu").val(currentMax)

            date_menu = currentMax
        }
        else {
            date_menu = $("#date_menu").val()

        }
        // console.log(date_menu)
        getFormMenu(date_menu);
    })

})






