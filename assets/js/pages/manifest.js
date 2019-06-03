jQuery(document).ready(function($) {

    // Cash Preparation Cny
    $(".consignmentReceived").click(function(event) {
        event.preventDefault()
        printJS('printJS-form', 'html')
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var erId = $("#erId").val()

        if (username == '' || usertoken == '' || erId == '') {
            Materialize.toast('Request Denied: Authorization Failed', 5000, 'rounded');
        } else {
            $.ajax({
                url: "app/pf/boxroom.php",
                method: "POST",
                data: { confirmReceipt: 1, erId: erId,  username: username, usertoken: usertoken },
                success: function(data) {
                    console.log(data)
                }
            })
        }
    })
})