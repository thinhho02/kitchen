$(document).ready(function () {

    $(".input-field").on("input", function () {
        // $("#email ~ i").css({
        //     "background-color": "white"

        // })
        $(this).siblings(".valid").css({
            "background-color": "white"

        })
    })




    // Page Login
    const getFormLogin = async () => {
        await $.ajax({
            url: `../api/login/fetch_login.php?submit=${$("#submit").val()}`,
            method: "POST",
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },
            dataType: "JSON",
            success: (data) => {
                if (!(data.message)) {
                    if (data.success === 'ok' && data.role === 'employee') {
                        location.href = "../";
                        console.log(data.userId)
                    } else if (data.success === 'ok' && data.role === 'chef') {
                        location.href = "../chef/";
                        console.log(data.userId)
                    } else if (data.success === 'ok' && data.role === 'deliver') {
                        location.href = "../deliver/";
                        console.log(data.userId)
                    } else if (data.success === 'ok' && data.role === 'manager') {
                        location.href = "../admin/";
                        console.log(data.userId)
                    }
                } else {
                    $(".box form .links").append(`<small class="wrong">${data.message}</small>`)
                    if ($(".box form .links .wrong").length == 2) {
                        $(".box form .links .wrong:first").remove()
                    }

                }
            }, complete: function (data) {
                $("#text-btn").removeClass("hidden")
                $("#spinner").css({
                    "opacity": "0"
                })
            }
        })
    }


    // Page Forget
    const getFormForget = async () => {
        const response = await $.ajax({
            url: `../api/login/fetch_forget.php?submit_forget=${$("#submit_forget").val()}`,
            method: "POST",
            data: {
                check: $("#check").val(),

            },
            dataType: "JSON"
        })
        return response
    }

    // PAGE CHECK 

    const getCheckOtp = async () => {
        const response = await $.ajax({
            url: `../api/login/fetch_check.php?submit_check=${$("#submitCheck").val()}`,
            method: "POST",
            data: {
                check_otp: $("#check_otp").val()
            },
            dataType: "JSON"
        })
        return response
    }

    // Page Change
    const getPassword = async () => {
        const response = await $.ajax({
            url: `../api/login/fetch_password.php?submit_change=${$("#submitChange").val()}`,
            method: "POST",
            data: {
                passnew: $("#password").val(),
                check_passnew: $("#confirm-password").val()
            },
            dataType: "JSON"
        })
        return response
    }

    // SUBMIT LOGIN
    $("#submit").click((e) => {
        $("#text-btn").addClass("hidden")
        $("#spinner").css({
            "opacity": "1",

        })
        if ($("#email").val() == '' && $("#password").val() == '') {

            $(".valid").css({
                "background-color": "red",

            })


            // animate()
        } else if ($("#email").val() == '') {
            $("#email ~ .valid").css({
                "background-color": "red",

            })
        }
        else if ($("#password").val() == '') {
            $("#password ~ .valid").css({
                "background-color": "red",

            })
        }
        getFormLogin()
        e.preventDefault();
    })

    // SUBMIT FORGET
    $("#submit_forget").click(async (e) => {
        e.preventDefault();
        $("#text-btn").addClass("hidden")
        $("#spinner").css({
            "opacity": "1",

        })
        if ($("#check").val() == '') {

            $("#check ~ .valid").css({
                "background-color": "red",

            })


            // animate()
        }
        await getFormForget()
            .then((data) => {
                // console.log(data)

                if (data.error) {
                    alert(data.error)

                } else {
                    if (data.message) {
                        $(".box form .links").append(`<small class="wrong">${data.message}</small>`)
                        if ($(".box form .links .wrong").length == 2) {
                            $(".box form .links .wrong:first").remove()
                        }

                    } else {

                        if (data.status === 'success') {

                            alert("Đã gửi mã xác thực đến" + " " + data.email_user)
                            location.href = "../login/check.php";
                        }
                        else {
                            alert(data.e)
                        }
                    }
                }
            }).finally(() => {
                $("#text-btn").removeClass("hidden")
                $("#spinner").css({
                    "opacity": "0"
                })
            })


    })

    // SUBMIT CHECK
    $("#submitCheck").on("click", async function (e) {
        e.preventDefault();
        $("#text-btn").addClass("hidden")
        $("#spinner").css({
            "opacity": "1",

        })
        if ($("#check_otp").val() == '') {
            $("#check_otp ~ .valid").css({
                "background-color": "red",

            })
        }
        await getCheckOtp()
            .then((data) => {
                if (data.message) {
                    $(".box form .links").append(`<small class="wrong">${data.message}</small>`)
                    if ($(".box form .links .wrong").length == 2) {
                        $(".box form .links .wrong:first").remove()
                    }

                } else {
                    alert(data.success)
                    location.href = "../login/changepass.php";
                }

            }).finally(() => {
                $("#text-btn").removeClass("hidden")
                $("#spinner").css({
                    "opacity": "0"
                })
            })
    })

    // SUBMIT CHANGE

    $("#submitChange").on("click", async function (e) {
        e.preventDefault();
        $("#text-btn").addClass("hidden")
        $("#spinner").css({
            "opacity": "1",

        })
        if ($("#confirm-password").val() == '' && $("#password").val() == '') {

            $(".valid").css({
                "background-color": "red",

            })
        } else if ($("#confirm-password").val() == '') {
            $("#confirm-password ~ .valid").css({
                "background-color": "red"
            })
        }
        else if ($("#password").val() == '') {
            $("#password ~ .valid").css({
                "background-color": "red"
            })
        }
        await getPassword()
            .then((data) => {
                if (!(data.error)) {
                    if (data.message) {
                        $(".box form .links").append(`<small class="wrong" style="top: -10px;">${data.message}</small>`)
                        if ($(".box form .links .wrong").length == 2) {
                            $(".box form .links .wrong:first").remove()
                        }

                    } else {
                        alert(data.success)
                        location.href = "../login/";
                    }
                }
            }).finally(() => {
                $("#text-btn").removeClass("hidden")
                $("#spinner").css({
                    "opacity": "0"
                })
            })
    })
})
const seePass = document.getElementById("see_password");
const passWord = document.getElementById("password");
const form = document.getElementById("form");
seePass.addEventListener('click', function () {

    const typePass = passWord.getAttribute("type") === 'password' ? 'text' : 'password';
    passWord.setAttribute("type", typePass);
    passWord.getAttribute("type") === "password" ? seePass.setAttribute("name", "eye-off-outline") : seePass.setAttribute("name", "eye-outline");

});


