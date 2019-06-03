jQuery(document).ready(function($) {

    // Take Into Storage 
    $(".takeIntoStorage").click(function(event){
        $(".msgbox").hide()
        $(".viewActualStockPositionDiv").hide()
        $(".viewActualStockCountDiv").hide()
        $(".takeIntoStorageDiv").show()
    })
    $(".acceptOneConsignment").click(function(event) {
        event.preventDefault()
        var confirmSealNumberId = $("#confirmSealNumberId").val()
        var sealNumber = $("#getSealNumberRaw").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (confirmSealNumberId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".acceptOneConsignment").html('<div class="progress"><div class="indeterminate"></div></div> Moving');
            $(".acceptOneConsignment").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/boxroom.php",
                method: "POST",
                data: { acceptOneConsignment: 1, confirmSealNumberId: confirmSealNumberId, sealNumber: sealNumber, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".acceptOneConsignment").html('<i class="material-icons left">done_all</i> Yes I Have The Consignment ')
                    $(".acceptOneConsignment").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Confirmation Completed', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Movement Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

    // View Actual Stock Position
    $(".viewActualStockPosition").click(function(event){
        $(".msgbox").hide()
        $(".takeIntoStorageDiv").hide()
        $(".viewActualStockCountDiv").hide()
        $(".viewActualStockPositionDiv").show()
    })

    // View Actual Stock Count
    $(".viewActualStockCount").click(function(event){
        $(".msgbox").hide()
        $(".takeIntoStorageDiv").hide()
        $(".viewActualStockPositionDiv").hide()
        $(".viewActualStockCountDiv").show()
    })

    // Load Bag
    $("#qSealNumber").change(function() {
        var qSealNumber = $(this).val()
        $(".loadingData").html('<div class="progress"><div class="indeterminate"></div></div> Fetching ');
        $.ajax({
            url: "app/pf/vault.php",
            method: "POST",
            data: { loadBag: 1, qSealNumber: qSealNumber},
            success: function(data) {
                $(".loadingData").html('')
                $("#loadBag").html(data)
            }
        })
    })

    // Take Into Storage
    $(".saveIntoStorage").click(function(event) {
        event.preventDefault()
        var qSealNumber = $('#qSealNumber').val()
        var clientIdd = $('#clientIdd').val()
        var denomination = $('#denomination').val()
        var currency = $('#currency').val()
        var amount = $('#amount').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (qSealNumber == '' || clientIdd == '' || denomination == '' || currency == '' || amount == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 1000, 'rounded');
        } else {
            $(".saveIntoStorage").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".saveIntoStorage").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/vault.php",
                method: "POST",
                data: { saveIntoStorage: 1, qSealNumber: qSealNumber, clientIdd: clientIdd, denomination: denomination, currency: currency, amount: amount, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".saveIntoStorage").html('<i class="material-icons left">save</i> Save Into Storage ')
                    $(".saveIntoStorage").removeAttr('disabled')
                    if (data != "done") {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    } else {
                        Materialize.toast('Stored Successfully', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    }
                }
            })
        }
    })

    //Fetch data from button and pass to modal
    $(".confirmBtn").click(function(event){
        event.preventDefault()
        var boxId = $(this).data('id')
        $(".modal-body #vId").val( boxId )
    })
    // Confirm Vault Count
    $(".confirmVaultCount").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var vId = $("#vId").val()
        if (qSealNumber == '' || username == '' || usertoken == '' || vId == '') {
            Materialize.toast('Invalid Request', 1000, 'rounded');
        } else {
            $.ajax({
                url: "app/pf/vault.php",
                method: "POST",
                data: { confirmVaultCount: 1, username: username, usertoken: usertoken, vId: vId},
                success: function(data) {
                    if (data != "done") {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    } else {
                        Materialize.toast('Confirmed', 1000, 'rounded')
                        window.setTimeout(function() {
                            $('#confirmCount').modal('close')
                            $("#cbtn"+vId).html('<button class="btns waves-effect waves-light default grey-text " disabled >confirmed </button>')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Fetch Stock Position Per Client
    $(".fetchStock").click(function(event) {
        event.preventDefault()
        var clientUid = $("#clientUid").val()
        var categoryUid = $("#categoryUid").val()
        var currencyUid = $("#currencyUid").val()
        var denominationUid = $("#denominationUid").val()
        if (clientUid == '' || categoryUid == '' || currencyUid == '' || denominationUid == '') {
            Materialize.toast('Kindly Select All Fields', 1500, 'rounded');
        } else {
            $(".loadingData").html('<div class="progress"><div class="indeterminate"></div></div> Fetching ');
            $.ajax({
                url: "app/pf/vault.php",
                method: "POST",
                data: { loadStock: 1, clientUid: clientUid, categoryUid: categoryUid, currencyUid: currencyUid, denominationUid: denominationUid},
                success: function(data) {
                    $(".loadingData").html('')
                    $("#loadStock").html(data)
                }
            })
        }
    })
    
})