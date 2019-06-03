jQuery(document).ready(function($) {

    //Fetch data from button and pass to modal
    $(".cho").click(function(event){
        event.preventDefault()
        var erId = $(this).data('id')
        var erName = $(this).data('name')
        var tap = $(this).data('tap')
        var bbCid = $(this).data('bbcid')
        var citConfirmationToken = $(this).data('ctokn')
        // Fetch Seal Numbers List
        $.ajax({
            url: "app/pf/evacuation-requests.php",
            method: "POST",
            data: { fetchSealNumbersList: 1, erId: erId },
            success: function(data) {
                $('#sealNumberx').html(data)
            }
        })
        $(".modal-body #erId").val( erId )
        $(".modal-body #tap").val( tap )
        $(".modal-body #bbCid").val( bbCid )
        $(".modal-body #citConfirmationToken").val( citConfirmationToken )
        $(".modal-header #erName").html( erName )
    })

    // Handover
    $(".consignmentReceived").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var sealNumberx = $("#sealNumberx").val()
        var erId = $("#erId").val()
        var tap = $("#tap").val()
        var bbCid = $("#bbCid").val()

        if (username == '' || usertoken == '' || erId == '' || tap == '' || bbCid == '' || sealNumberx == '') {
            Materialize.toast('Request Denied: Authorization Failed', 1000, 'rounded');
        } else {
            $(".consignmentReceived").html('<div class="progress"><div class="indeterminate"></div></div> Processing...');
            $(".consignmentReceived").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { confirmReceipt: 1, erId: erId, sealNumberx: sealNumberx, tap: tap, bbCid: bbCid, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".consignmentReceived").html('<i class="material-icons right">rv_hookup</i> YES I HAVE ')
                    $(".consignmentReceived").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Hand Over Completed', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.href='./'
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })

    // Fetch Information And Pass To Modal
    $(".hoconx").click(function(event){
        event.preventDefault()
        var userId = $(this).data('id')
        // Fetch Seal Numbers List
        $.ajax({
            url: "app/pf/evacuation-requests.php",
            method: "POST",
            data: { fetchSealNumbersList2: 1, userId: userId },
            success: function(data) {
                $('#sealNumberxx').html(data)
            }
        })
    })

    //Fetch data from button and pass to modal
    $(".delCons").click(function(event){
        event.preventDefault()
        var srbId = $(this).data('id')
        var client = $(this).data('client')
        var tad = $(this).data('tad')
        var citConfirmationTokenn = $(this).data('ctoknn')
        $(".modal-body #srbId").val( srbId )
        $(".modal-body #client").val( client )
        $(".modal-body #tad").val( tad )
        $(".modal-body #citConfirmationTokenn").val( citConfirmationTokenn )
    })

    // Cash Preparation Cny
    $(".consignmentDelivered").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var sealNumberx = $("#sealNumberx").val()
        var srbId = $("#srbId").val()
        var client = $("#client").val()
        var tad = $("#tad").val()
        var citConfirmationTokenn = $("#citConfirmationTokenn").val()

        if (username == '' || usertoken == '' || srbId == '' || client == '' || citConfirmationTokenn == '' || tad == '') {
            Materialize.toast('Request Denied: Authorization Failed', 1000, 'rounded');
        } else {
            $(".consignmentDelivered").html('<div class="progress"><div class="indeterminate"></div></div> Processing...');
            $(".consignmentDelivered").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { consignmentDelivered: 1, srbId: srbId, client: client, citConfirmationTokenn: citConfirmationTokenn, tad: tad, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".consignmentDelivered").html('<i class="material-icons right">rv_hookup</i> YES I HAVE ')
                    $(".consignmentDelivered").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Consignment Delivered', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })
        
})