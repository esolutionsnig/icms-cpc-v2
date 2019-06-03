jQuery(document).ready(function($) {

    // Move Multiple At Once
    var searchIDs = '';
    $(".iSelected").change(function(){
        searchIDs = $("#data-table-simple input:checkbox:checked").map(function(){
            return $(this).val()
        }).get()
        // console.log(searchIDs)
        $("#totalSelected").html(searchIDs.length)
    })

    // Confirm Selected Bags
    $(".moveSelectedConsignments").click(function(event) {
        event.preventDefault()
        var sealNumberCurrentLocationCode = $("#sealNumberCurrentLocationCode").val()
        var sealNumberDestinationLocation = $("#sealNumberDestinationLocation").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (sealNumberCurrentLocationCode == '' || sealNumberDestinationLocation == '' || searchIDs == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".moveSelectedConsignments").html('<div class="progress"><div class="indeterminate"></div></div> Moving')
            $(".moveSelectedConsignments").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/internal-movement.php",
                method: "POST",
                data: { moveSelectedConsignments: 1, searchIDs: searchIDs, sealNumberCurrentLocationCode: sealNumberCurrentLocationCode, sealNumberDestinationLocation: sealNumberDestinationLocation, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".moveSelectedConsignments").html('<i class="material-icons left">done_all</i> Move Consignment(s) ')
                    $(".moveSelectedConsignments").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Movement Initiated, To Be Completed By Recipient', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Movement Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

    // Accept Selected Bags
    $(".acceptSelectedConsignments").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchIDs == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".acceptSelectedConsignments").html('<div class="progress"><div class="indeterminate"></div></div> Accepting')
            $(".acceptSelectedConsignments").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/internal-movement.php",
                method: "POST",
                data: { acceptSelectedConsignments: 1, searchIDs: searchIDs, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".acceptSelectedConsignments").html('<i class="material-icons left">done_all</i> Accept Consignments(s) ')
                    $(".acceptSelectedConsignments").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Movement Completed', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Acceptance Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

    // Reject Selected Bags
    $(".rejectSelectedConsignments").click(function(event) {
        event.preventDefault()
        var returnLocation = $("#returnLocation").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchIDs == '' || returnLocation == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".rejectSelectedConsignments").html('<div class="progress"><div class="indeterminate"></div></div> Rejecting')
            $(".rejectSelectedConsignments").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/internal-movement.php",
                method: "POST",
                data: { rejectSelectedConsignments: 1, searchIDs: searchIDs, returnLocation: returnLocation, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".rejectSelectedConsignments").html('<i class="material-icons left">done_all</i> Reject Consignments(s) ')
                    $(".rejectSelectedConsignments").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Rejection Completed', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Rejection Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

    $(".newMovements").click(function () {
        $('#ishere').focus()
    })

    // Confirm Selected Bags
    $(".moveToNewLocation").click(function(event) {
        event.preventDefault()
        var sourceLocation = $("#sourceLocation").val()
        var destinationLocation = $("#destinationLocation").val()
        var sealNumbers = $("#sealNumbers").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (sourceLocation == '' || destinationLocation == '' || sealNumbers == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".moveToNewLocation").html('<div class="progress"><div class="indeterminate"></div></div> Moving')
            $(".moveToNewLocation").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/internal-movement.php",
                method: "POST",
                data: { moveToNewLocation: 1, sealNumbers: sealNumbers, sourceLocation: sourceLocation, destinationLocation: destinationLocation, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".moveToNewLocation").html('<i class="material-icons left">done_all</i> Move Consignment(s) ')
                    $(".moveToNewLocation").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Movement Initiated, To Be Completed By Recipient', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Movement Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

})