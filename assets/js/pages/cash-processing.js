jQuery(document).ready(function($) {

    $("#allocatedCash").keyup(function() {
        var allocatedCash = $(this).val()
        $(".amountAllocated").html(addCommas(allocatedCash))
        $("#amountAllocated").val(allocatedCash)
    })
    $("#allocatedTo").change(function() {
        var allocatedTo = $(this).val()
        $("#allocatee").html(allocatedTo)
    })

    // Load Bag Content
    $("#sealNumber").change(function() {
        var sealNumber = $(this).val()
        var ret = sealNumber.split("-")
        var tymStamp = ret[0]
        var mainSealNumber = ret[1]
        $("#currentSealNumber").html('You Are Allocating Bag With Seal Number: <strong>' + mainSealNumber + ' </strong>')
        $("#chosenSealNumber").val(sealNumber)
        $(".loadingData").html('<div class="progress"><div class="indeterminate"></div></div> Fetching ')
        $.ajax({
            url: "app/pf/cash-allocation.php",
            method: "POST",
            data: { loadBag: 1, sealNumber: sealNumber},
            success: function(data) {
                $(".loadingData").html('');
                if (data == 'nodey') {
                    $("#assignment").hide()
                    $("#loadBag").html('This Bag Does Not Exist')
                } else {
                    if (data == 'allDone') {
                        $("#loadNoBag").show()
                    } else {
                        $("#loadBag").html(data)
                        $("#assignment").show()
                    }
                }
            }
        })
    })

    // Confirm Bundle
    $(".saveCashAllocation").click(function(event) {
        event.preventDefault()
        var shift = $("#shift").val()
        var allocatedTo = $("#allocatedTo").val()
        var workstation = $("#workstation").val()
        var sealNumber = $("#chosenSealNumber").val()
        var clientName = $("#clientName").val()
        var currency = $("#currencyId").val()
        var denomination = $("#denominationId").val()
        var maxAmount = $("#maxAmount").val()
        var allocatedCash = $("#amountAllocated").val()
        var totalAmountAlloactedBeforeNow = $("#totalAmountAlloactedBeforeNow").val()
        var totalProcessorsBeforeNow = $("#totalProcessorsBeforeNow").val()
        var sealNumberId = $("#sealNumberId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (workstation == '' || clientName == '' || maxAmount == '' || sealNumber == '' || allocatedCash == '' || denomination == '' || allocatedCash == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".saveCashAllocation").html('<div class="progress"><div class="indeterminate"></div></div> Confirming Bundle');
            $(".saveCashAllocation").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/cash-allocation.php",
                method: "POST",
                data: { saveCashAllocation: 1, shift: shift, allocatedTo: allocatedTo, sealNumber: sealNumber, workstation: workstation, currency: currency, denomination: denomination, maxAmount: maxAmount, clientName: clientName, allocatedCash: allocatedCash, totalAmountAlloactedBeforeNow: totalAmountAlloactedBeforeNow, totalProcessorsBeforeNow: totalProcessorsBeforeNow, sealNumberId: sealNumberId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".saveCashAllocation").html('<i class="material-icons right">save</i> Save Cash Allocation ')
                    $(".saveCashAllocation").removeAttr('disabled')
                    if (data == "caa") {
                        Materialize.toast('Cash Allocation Successful', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Cash Allocation Failed: ' + data, 5000, 'rounded')
                    }
                }
            })
        }
    })

    // Grab Value And Feedback
    $("#amountReturned").keyup(function() {
        var amountReturned =  $(this).val()
        var expAmount =  $("#expAmount").val()
        $(".totalAmountReturned").html(addCommas(amountReturned))
        // Subtract Amount returned From Expected Amount
        var difference = parseInt(expAmount) - parseInt(amountReturned)
        var difference2 = parseInt(amountReturned) - parseInt(expAmount)
        // Check If Value Is -ve
        if ( parseInt(amountReturned) > parseInt(expAmount) ) {
            $(".totalDifference").html('0 &nbsp; Exceeded By ' + addCommas(difference2))
            $("#difference").val(0)
        } else {
            $(".totalDifference").html(addCommas(difference))
            $("#difference").val(difference)
        }
    })

    // Confirm Bundle
    $(".saveCashReturned").click(function(event) {
        event.preventDefault()
        var expAmount = $("#expAmount").val()
        var amountReturned = $("#amountReturned").val()
        var difference = $("#difference").val()
        var comment = $("#comment").val()
        var caId = $("#caId").val()
        var returnedBy = $("#returnedBy").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val() 
        if (expAmount == '' || amountReturned == '' || difference == '' || caId == '' || returnedBy == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 1000, 'rounded');
        } else {
            $(".saveCashReturned").html('<div class="progress"><div class="indeterminate"></div></div> Saving ');
            $(".saveCashReturned").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/cash-allocation.php",
                method: "POST",
                data: { saveCashReturned: 1, expAmount: expAmount, amountReturned: amountReturned, difference: difference, comment: comment, caId: caId,  returnedBy: returnedBy, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".saveCashReturned").html('<i class="material-icons right">save</i> Save Cash Allocation ')
                    $(".saveCashReturned").removeAttr('disabled')
                    if (data == "cas") {
                        Materialize.toast('Saved', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Cash Allocation Failed: ' + data, 2000, 'rounded')
                    }
                }
            })
        }
    })

})