jQuery(document).ready(function($) {

    // Cash Preparation Cny
    $(".processRequest").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var clientName = $("#clientName").val()
        var startDate = $("#startDate").val()
        var endDate = $("#endDate").val()

        if (username == '' || usertoken == '' || clientName == '' || startDate == '' || endDate == '') {
            Materialize.toast('Request Denied: Authorization Failed', 1000, 'rounded');
        } else {
            $(".processRequest").html('<div class="progress"><div class="indeterminate"></div></div> Processing...');
            $(".processRequest").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { processRequest: 1, clientName: clientName, startDate: startDate, endDate: endDate, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".processRequest").html('<i class="material-icons right">rv_hookup</i> YES I HAVE ')
                    $(".processRequest").removeAttr('disabled')
                    if (data == "") {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1000, 'rounded')
                    } else {
                        Materialize.toast('Search Completed', 1000, 'rounded')
                        window.setTimeout(function() {
                            $("#queryEvacReqs").modal('close')
                            $('#searchResult').html(data)
                        }, 1000)
                    }
                }
            })
        }
    })
        
})