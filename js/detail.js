$(document).ready(function () {

    const menuId = $("#getIdMenu").val()
    const userId = $("#getId").val()
    let valueMessage = ''
    // console.log(userId)
    let valueRating = 0;
    let valueDishId = 0;


    $('#rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'sm',
        showClear: false
    });
    $('#rating-input').on('change', function () {
        valueRating = $(this).val();
    });
    $("#input-message").on("input", function () {
        $("#input-message").removeAttr("style")
        valueMessage = $(this).val()
    })
    const getFromMenu = async () => {

        await $.ajax({
            url: `api/user/fetch_detail.php`,
            method: "POST",
            data: {
                menu_id: menuId
            },
            dataType: "JSON",
            success: function (data) {
                console.log(data)
                if (!(data.error)) {
                    if (!(data.nodata)) {
                        valueDishId = data[0].dish_id
                        $('.star-inner').css({
                            "width": (data[0].avg_review / 5) * 100 + "%"
                        })
                        $(".review_dish span").html(data[0].avg_review.toFixed(1))

                        $(".name_dish").html(data[0].name)
                        $(".cate").html(data[0].category)
                        $(".price").html(`${Number(data[0].price).toLocaleString("en-US")} VNĐ`)
                        $(".date_menu").html(data[0].date)
                        $(".resource").html(data[0].resources.join(", "))
                        $(".description").html(data[0].description)
                        $(".image_aside").attr("src", `image/${data[0].image}`)
                        $('.rating__average h1').html(data[0].avg_review.toFixed(1))
                        $('.rating__average p').html(Number(data[0].total_count).toLocaleString("en-US"))
                        for (let i = 0; i < data[0].rating.length; i++) {
                            let rating = `
                                            <div class="rating__progress-value">
                                                <p>${data[0].rating[i].star} <span class="star">&#9733;</span></p>
                                                <div class="progress">
                                                    <div class="bar" style=" width: ${(data[0].rating[i].count / data[0].total_count) * 100}%;"></div>
                                                </div>
                                                <p>${Number(data[0].rating[i].count).toLocaleString("en-US")}</p>
                                            </div>
                                            `;
                            $('.rating__progress').append(rating)
                        }


                    }
                }
            },
            complete: function (data) {
                let dateMenu = data.responseJSON[0].date
                // console.log(dateMenu)
                let valueInput = $(".input_quantity").val()
                $("#button-addon2").off("click").on("click", function () {
                    let inputElement = $(".input_quantity");

                    valueInput = inputElement.val(parseInt(inputElement.val(), 10) + 1).val()
                    console.log(valueInput)
                })

                $("#button-addon1").off("click").on("click", function () {

                    let inputElement = $(".input_quantity");

                    valueInput = inputElement.val(Math.max(parseInt(inputElement.val(), 10) - 1, 1)).val()
                    console.log(valueInput)
                })


                $(".input_quantity").off("change").on("change", function () {

                    valueInput = Math.max(parseInt($(this).val(), 10), 1)

                    $(this).val(valueInput)
                    console.log(valueInput)

                })

                $("#btn_add").off("click").on("click", async function () {
                    $.ajax({
                        url: `api/user/fetch_add_cart.php`,
                        method: "POST",
                        data: {
                            idMenu: menuId,
                            idUser: userId,
                            quantity: valueInput,
                            day: dateMenu
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if (!(data.error)) {
                                alert(data.message)
                                localStorage.setItem("date", dateMenu);

                                location.href = 'cart.php'
                            } else {
                                alert(data.error)
                            }
                        }
                    })
                })
            }
        })
    }
    const getReviewDish = async () => {
        await $.ajax({
            url: `api/user/fetch_review.php`,
            method: "POST",
            data: {
                menu_id: menuId
            },
            dataType: "JSON",
            success: function (data) {
                // console.log(data)
                for (let i = 0; i < data.length; i++) {

                    let rating = `<div class="d-flex border-bottom my-3" style="align-items: flex-start">
                                    <div class="avt_user">
                                        <img src="image/${data[i].avatar}" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 20px"  alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rv_name_user" style="font-size: 19px;">${data[i].full_name}</div>
                                        <div class="rv_rating${(data[i].string_date)}323" style="font-size: 17px; color: gold">
                                            
                                        </div>
                                        <div class="rv_time my-1" style="color: #0000008f;">${data[i].date}</div>
                                        <div class="my-2 rv_message"style="font-size: 20px;" >
                                            ${data[i].comment}
                                        </div>
                                    </div>
                                </div>`
                    $(`.rating_detail`).append(rating);
                    for (let j = 0; j < data[i].review; j++) {
                        $(`.rv_rating${(data[i].string_date)}323`).append(`<ion-icon name="star"></ion-icon>`)
                    }
                    for (let j = 0; j < 5 - data[i].review; j++) {
                        $(`.rv_rating${(data[i].string_date)}323`).append(`<ion-icon name="star-outline"></ion-icon>`)
                    }

                }
            }
        })
    }
    const getReview = async () => {

        const response = await $.ajax({
            url: `api/user/fetch_review.php`,
            method: "POST",
            data: {
                dish_id: valueDishId,
                user_id: userId,
                value_message: valueMessage,
                value_rating: valueRating
            },
            dataType: "JSON",
            success: function (data) { }
        })
        return response

    }
    $("#btn_review").on("click", async function (e) {
        if (valueMessage === '') {
            $("#input-message").attr("style", "border: 1px solid red !important")
        }
        else if (valueRating === 0) {
            alert("Chọn đánh giá sao cho món ăn")
        }
        else {
            await getReview().then((data) => {
                location.href = `detail.php?id=${menuId}`
            })
        }

    })
    getReviewDish()
    getFromMenu()
})