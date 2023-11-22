
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
    let id = $("#getId").val()
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
                            if($("#lableCofirm span").length == 2){
                                $("#lableCofirm span:first").remove()
                            }
                            $("#confirmPassword").addClass("active")
                            $("#lableOld span").remove()
                            // alert(data.confirm)
                        }
                    } else {
                        $("#lableOld").append(`<span style="color:red"> ${data.oldpass}</span>`)
                        if($("#lableOld span").length == 2){
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


$("#submitForm").click(async (e) => {
    // console.log(123)
    await getChangeForm()


    // $("#confirmPassword").removeClass("active")
    // $("#lableOld").removeClass("active")
})

// $("#showChange").on("focusin", () => {
//     $("#oldPassword").val("")
//     $("#newPassword").val("")
//     $("#confirmPassword").val("")
// })
// $("body").on("mousemove")
