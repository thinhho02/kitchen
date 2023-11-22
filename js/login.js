$(document).ready(function () {

    $("#email").on("input", () => {
        $("#email ~ i").css({
            "background-color": "white"

        })
    })
    $("#password").on("input", () => {
        $("#password ~ i").css({
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
                        // location.href = "../test_chef.php";
                        console.log(data.userId)
                    } else if (data.success === 'ok' && data.role === 'deliver') {
                        // location.href = "../";
                        console.log(data.userId)
                    } else if (data.success === 'ok' && data.role === 'manager') {
                        // location.href = "../";
                        console.log(data.userId)
                    }
                } else {
                    $(".box form .links").append(`<small class="wrong">${data.message}</small>`)
                    if ($(".box form .links .wrong").length == 2) {
                        $(".box form .links .wrong:first").remove()
                    }

                }
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


    // SUBMIT LOGIN
    $("#submit").click((e) => {
        if ($("#email").val() == '' && $("#password").val() == '') {

            $("i").css({
                "background-color": "red",

            })


            // animate()
        } else if ($("#email").val() == '') {
            $("#email ~ i").css({
                "background-color": "red",

            })
        }
        else if ($("#password").val() == '') {
            $("#password ~ i").css({
                "background-color": "red",

            })
        }


        getFormLogin()

        e.preventDefault();
    })
    $("#submit_forget").click(async (e) => {
        $("#text-btn").addClass("hidden")
        $("#spinner").css({
            "opacity": "1",

        })
        await getFormForget()
            .then((data) => {
                // console.log(data)

                if (data.error) {
                    alert(data.error)

                } else {
                    if (data.message) {
                        alert(data.message)

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
})
const seePass = document.getElementById("see_password");
const passWord = document.getElementById("password");
const form = document.getElementById("form");
seePass.addEventListener('click', function () {

    const typePass = passWord.getAttribute("type") === 'password' ? 'text' : 'password';
    passWord.setAttribute("type", typePass);
    passWord.getAttribute("type") === "password" ? seePass.setAttribute("name", "eye-off-outline") : seePass.setAttribute("name", "eye-outline");

});


