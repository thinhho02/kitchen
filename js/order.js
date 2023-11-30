// function getCookie(cookieName) {
//     const name = cookieName + "=";
//     const decodedCookie = decodeURIComponent(document.cookie);
//     const cookieArray = decodedCookie.split(';');

//     for (let i = 0; i < cookieArray.length; i++) {
//         let cookie = cookieArray[i];
//         while (cookie.charAt(0) === ' ') {
//             cookie = cookie.substring(1);
//         }
//         if (cookie.indexOf(name) === 0) {
//             // console.log(name.length);
//             return cookie.substring(name.length, cookie.length);
//         }
//     }
//     return null;
// }
// // Assume you want to get the value of a cookie named "myCookie"
// const cookieReceipt = getCookie("receipt");
// const cookieNote = (getCookie("note") !== null) ? getCookie("note") : "123";



// if (cookieReceipt !== null) {
//     console.log(cookieReceipt + " " + cookieNote);
// } else {
//     console.log("myCookie not found");
// }
$(document).ready(function(){
    const id = $("#getId").val()
    const getReceipt = async ()=>{
        await $.ajax({
            url: `api/user/fetch_order.php`,
            method: "POST",
            data: {
                id_user : id
            },
            dataType: "JSON",
            success: function(data){
                // console.log(data)
                if(!(data.message)){
                    $(".receipt_id").append(data[0].receipt_id)
                    $(".date_receipt").append(data[0].full_time)
                    $(".right.subtotal").append(`<strong>${Number(data[0].subtotal).toLocaleString("en-US")} VNĐ</strong>`)
                    data[0].status !== 'confirming' ? $(".status_receipt").append(`<b style="color: red">Hóa đơn không tồn tại</b>`) : $(".status_receipt").append(`<b style="color: green">Chờ xác nhận</b>`)
                    $(".note").append(data[0].note)
                    
                    let count = 0
                    for(let i = 1; i < data.length; i++){
                        let tableDetail = `<tr class="menud${data[i].menu_id}">
                                                <td class="center count">${++count}</td>
                                                <td class="left name"></td>
                                                <td class="center quantity">${data[i].quantity}</td>
                                                <td class="right menu_price">${Number(data[i].menu_price).toLocaleString("en-US")} VNĐ</td>
                                                <td class="right receipt_total">${Number(data[i].price).toLocaleString("en-US")} VNĐ</td>
                                            </tr>`
                        $(`.receipt_detail`).append(tableDetail)
                        let arrayMenu = new Array();
                        for(let j = 0; j < data[i].menu_list.length; j++){

                            arrayMenu.push(data[i].menu_list[j].name)
                            
                        }
                        $(`.menud${data[i].menu_id} .name`).append(arrayMenu.join("<br>"))
                    }
                    
                }else{
                    // alert(data.message)
                    location.href = 'cart.php';
                }
            }
        })
    }
    getReceipt()



})