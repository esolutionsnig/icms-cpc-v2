jQuery(document).ready(function($) {

    $("#allocatedCash").keyup(function() {
        var allocatedCash = $(this).val()
        $(".amountAllocated").html(addCommas(allocatedCash))
        $("#amountAllocated").val(allocatedCash)
        // Get Total Amount In Bag
        var maxAmount = parseInt($("#maxAmount").val())
        // Get Total Amount Aloocated
        var prevAllocatedAmount = $("#totalAmountAlloactedBeforeNow").val()
        var totalAmountNowAllocated = parseInt(allocatedCash) + parseInt(prevAllocatedAmount)
        // Get The Difference In Amount
        var difInAmount = totalAmountNowAllocated - maxAmount
        // Check If Amount Allocated Is Higher Than Max Amount
        if ( maxAmount < totalAmountNowAllocated ) {
            $('.saveCashAllocation').hide()
            $('#showError').html('<div class="alert-box-error uppercase"><h5>Warning: Difference In Amount</h5><h6>The System Has Detected That The Amount Entered Is Higher Than The Amount In The Chosen Bag By <strong class="deepred-text">' + addCommas(difInAmount) + '</strong>, Kindly Confirm Your Inputed Values.</h6></div>')
        } else {
            $('.saveCashAllocation').show()
            $('#showError').html('')
        }
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
        var categoryId = $("#categoryId").val()
        var maxAmount = $("#maxAmount").val()
        var allocatedCash = $("#amountAllocated").val()
        var totalAmountAlloactedBeforeNow = $("#totalAmountAlloactedBeforeNow").val()
        var totalProcessorsBeforeNow = $("#totalProcessorsBeforeNow").val()
        var sealNumberId = $("#sealNumberId").val()
        var oldSealNumber = $("#oldSealNumber").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (workstation == '' || clientName == '' || maxAmount == '' || sealNumber == '' || allocatedCash == '' || categoryId == '' || denomination == '' || allocatedCash == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".saveCashAllocation").html('<div class="progress"><div class="indeterminate"></div></div> Confirming Bundle');
            $(".saveCashAllocation").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/cash-allocation.php",
                method: "POST",
                data: { saveCashAllocation: 1, shift: shift, allocatedTo: allocatedTo, sealNumber: sealNumber, workstation: workstation, categoryId: categoryId, currency: currency, denomination: denomination, maxAmount: maxAmount, clientName: clientName, allocatedCash: allocatedCash, totalAmountAlloactedBeforeNow: totalAmountAlloactedBeforeNow, totalProcessorsBeforeNow: totalProcessorsBeforeNow, sealNumberId: sealNumberId, oldSealNumber: oldSealNumber, username: username, usertoken: usertoken},
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

    $("#fit").keyup(function() {
        var fit =  $(this).val()
        if (fit == '') { fit = 0 }
        $("#fitnotes").html(addCommas(fit))
    })
    $("#unfit").keyup(function() {
        var unfit =  $(this).val()
        if (unfit == '') { unfit = 0 }
        $("#unfitnotes").html(addCommas(unfit))
    })
    $("#atm").keyup(function() {
        var atm =  $(this).val()
        if (atm == '') { atm = 0 }
        $("#atmnotes").html(addCommas(atm))
    })
    $("#fakenotes").keyup(function() {
        var fakenotes =  $(this).val()
        if (fakenotes == '') { fakenotes = 0 }
        $("#fakenotess").html(addCommas(fakenotes))
    })
    $("#shortage").keyup(function() {
        var shortage =  $(this).val()
        if (shortage == '') { shortage = 0 }
        $("#shortagenotes").html(addCommas(shortage))
    })
    $("#m1000").keyup(function() {
        var m1000 =  $(this).val()
        if (m1000 == '') { m1000 = 0 }
        $("#m1000s").html(addCommas(m1000))
    })
    $("#m500").keyup(function() {
        var m500 =  $(this).val()
        if (m500 == '') { m500 = 0 }
        $("#m500s").html(addCommas(m500))
    })
    $("#m200").keyup(function() {
        var m200 =  $(this).val()
        if (m200 == '') { m200 = 0 }
        $("#m200s").html(addCommas(m200))
    })
    $("#m100").keyup(function() {
        var m100 =  $(this).val()
        if (m100 == '') { m100 = 0 }
        $("#m100s").html(addCommas(m100))
    })
    $("#m50").keyup(function() {
        var m50 =  $(this).val()
        if (m50 == '') { m50 = 0 }
        $("#m50s").html(addCommas(m50))
    })
    $("#m20").keyup(function() {
        var m20 =  $(this).val()
        if (m20 == '') { m20 = 0 }
        $("#m20s").html(addCommas(m20))
    })
    $("#m10").keyup(function() {
        var m10 =  $(this).val()
        if (m10 == '') { m10 = 0 }
        $("#m10s").html(addCommas(m10))
    })
    $("#m5").keyup(function() {
        var m5 =  $(this).val()
        if (m5 == '') { m5 = 0 }
        $("#m5s").html(addCommas(m5))
    })
    $("#m1").keyup(function() {
        var m1 =  $(this).val()
        if (m1 == '') { m1 = 0 }
        $("#m1s").html(addCommas(m1))
    })

    var sumAll = 0;
    // Grab Value And Feedback
    $(".getAmountProcessed").click(function(event) {
        event.preventDefault()
        var denomination =  $("#denomination").val()
        var declaredValue =  $("#declaredValue").val()
        var fit =  $("#fit").val()
        var unfit =  $("#unfit").val()
        var atm =  $("#atm").val()
        var shortage =  $("#shortage").val()
        var mixup =  $("#mixup").val()
        var m1000 =  $("#m1000").val()
        var m500 =  $("#m500").val()
        var m200 =  $("#m200").val()
        var m100 =  $("#m100").val()
        var m50 =  $("#m50").val()
        var m20 =  $("#m20").val()
        var m10 =  $("#m10").val()
        var m5 =  $("#m5").val()
        var m1 =  $("#m1").val()
        var fakenotes =  $("#fakenotes").val()

        // Mutliply Fakenote count by denomination to get FakenoteValue
        var fakenotesValue =  parseInt(fakenotes) * parseInt(denomination)

        // Add Up All Mixup Values
        var mixupDen = parseInt(mixup) * parseInt(denomination)
        var mixupValues = parseInt(m1000) + parseInt(m500) + parseInt(m200) + parseInt(m100) + parseInt(m50) + parseInt(m20) + parseInt(m10) + parseInt(m5) + parseInt(m1) 
        // Get Counted Value
        var countedValue  = parseInt(fit) + parseInt(unfit) + parseInt(atm)
        $("#countedValue").val(countedValue)
        $(".amountCounted").html(countedValue)
        // Get Pre-Count Shortage
        var preCountShortage = declaredValue - countedValue
        $("#shortage").val(preCountShortage)
        $("#shortagenotes").html(addCommas(preCountShortage))
        $(".preCountShortage").html(addCommas(preCountShortage))
        var negatepreCountShortage = countedValue - declaredValue
        // Get Sorting Shortage
        var sortingShortage = (fakenotesValue + mixupDen) - mixupValues
        $('.sortingShortage').html(sortingShortage)
        // Get Post Sorting Shortage
        var postSortingShortage = sortingShortage + preCountShortage
        $('.postSortingShortage').html(addCommas(postSortingShortage))
        // Get Post Sorting Value
        var postSortingValue = declaredValue - postSortingShortage
        $(".postSortingValue").html(addCommas(postSortingValue))

        // Check If Value Is -ve
        if ( parseInt(countedValue) > parseInt(declaredValue) ) {
            $(".totalDiff").html('+ ' + addCommas(preCountShortage) )
        } else {
            $(".totalDiff").html(addCommas(negatepreCountShortage) )
        }

        
        // var totalAmountCountedB4MixUpFN = fua + parseInt(shortage)

        // Subtract Fakenotes Values From FUA
        // var fuaMinusFNMinusMixupDen = fua - fakenotesValue - mixupDen
        // shtg = declaredValue - ( parseInt(fit) + parseInt(unfit) + parseInt(atm) )
        // var amountCounted = fuaMinusFNMinusMixupDen + mixupValues + parseInt(shtg)
        // Assign Values to IDs
        // $(".amountCounted").html(fua)
        // $("#shortage").val(shtg)
        // $("#shortagenotes").html(addCommas(shtg))
        // $("#countedValue").val(amountCounted)
        // Subtract Amount Processed From Declared Amount
        // var dif = parseInt(declaredValue) - parseInt(amountCounted)
        // var dif2 = parseInt(amountCounted) - parseInt(declaredValue)
        
        // PSS = (DeclaredValue - AmountCounted) + 
        // var pss = dif + shtg
        // var pss = dif + fuaMinusFNMinusMixupDen

        //POst Sorting Value
        // var psv = amountCounted - pss

        // $(".totalAmountProcessed").html(addCommas(psv))
        // $('.pss').html(addCommas(pss))
        // // Check If Value Is -ve
        // if ( parseInt(amountCounted) > parseInt(declaredValue) ) {
        //     $(".totalDiff").html('+ ' + addCommas(dif2) )
        // } else {
        //     $(".totalDiff").html(addCommas(dif) )
        // }
    })

    // Tags Input
    $('#fakenotesSerialNumbers').tagsInput();

    // Save Processed cash
    $(".saveCashProcessed").click(function(event) {
        event.preventDefault()
        var declaredValue = $("#declaredValue").val()
        var countedValue = $("#countedValue").val()
        var fit = $("#fit").val()
        var unfit = $("#unfit").val()
        var atm = $("#atm").val()
        var mixup = $("#mixup").val()
        var m1000 =  $("#m1000").val()
        var m500 =  $("#m500").val()
        var m200 =  $("#m200").val()
        var m100 =  $("#m100").val()
        var m50 =  $("#m50").val()
        var m20 =  $("#m20").val()
        var m10 =  $("#m10").val()
        var m5 =  $("#m5").val()
        var m1 =  $("#m1").val()
        var fakenotes = $("#fakenotes").val()
        var fakenotesSerialNumbers =  $("#fakenotesSerialNumbers").val()
        var shortage = $("#shortage").val()
        var cpComment = $("#cpComment").val()
        var caId = $("#caId").val()
        var returnedBy = $("#returnedBy").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val() 
        // if (declaredValue == '' || countedValue == '' || caId == '' || returnedBy == '' || username == '' || usertoken == '') {
        //     Materialize.toast('Invalid Request', 1000, 'rounded');
        // } else {
            $(".saveCashProcessed").html('<div class="progress"><div class="indeterminate"></div></div> Saving ');
            $(".saveCashProcessed").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/cash-allocation.php",
                method: "POST",
                data: { saveCashProcessed: 1, declaredValue: declaredValue, countedValue: countedValue, fit: fit, unfit: unfit, atm: atm, mixup: mixup, m1000: m1000, m500: m500, m200: m200, m100: m100, m50: m50, m20: m20, m10: m10, m5: m5, m1: m1, fakenotes: fakenotes, fakenotesSerialNumbers: fakenotesSerialNumbers, shortage: shortage, cpComment: cpComment, caId: caId,  returnedBy: returnedBy, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".saveCashProcessed").html('<i class="material-icons right">save</i> Save Cash Processed ')
                    $(".saveCashProcessed").removeAttr('disabled')
                    if (data == "cap") {
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
        // }
    })

    // Confirm Bundle
    $(".saveCashReturned").click(function(event) {
        event.preventDefault()
        var comment = $("#comment").val()
        var caId = $("#caId").val()
        var returnedBy = $("#returnedBy").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val() 
        // if (caId == '' || returnedBy == '' || username == '' || usertoken == '') {
        //     Materialize.toast('Invalid Request', 1000, 'rounded');
        // } else {
            $(".saveCashReturned").html('<div class="progress"><div class="indeterminate"></div></div> Saving ');
            $(".saveCashReturned").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/cash-allocation.php",
                method: "POST",
                data: { saveCashReturned: 1, comment: comment, caId: caId,  returnedBy: returnedBy, username: username, usertoken: usertoken},
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
        // }
    })

    // Change File
    $("#fileform").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "app/pf/cash-allocation-f.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#preview").fadeOut();
                $(".changefilebtn").html('<div class="progress"><div class="indeterminate"></div></div>');
                $(".changefilebtn").attr('disabled', 'disabled');
            },
            success: function(data) {
                $(".changefilebtn").removeAttr('disabled');
                $(".changefilebtn").html('<i class="material-icons left">save</i> Save Changes')
                if (data == 'error400') {
                    Materialize.toast('File Was Not Updated, Kindly Retry Or Contact Support', 2000, 'rounded')
                } else {
                    console.log(data)
                    $("#fileImg").html('<img src="assets/images/attachments/' + data + '" width="100%">');
                    Materialize.toast('File Update Successfully', 2000, 'rounded')
                    window.setTimeout(function() {
                        $("#uploadFile").modal('close')
                    }, 2000)
                }
            },
            error: function(e) {
                Materialize.toast('System Failed To Update Your Record', 2000, 'rounded')
                console.log(e)
            }
        });
    }));

    // Download File
    $('.downloadFile').click(function(e) {
        e.preventDefault();
        var fileToDownload = $("#fileToDownload").val()
        // var pathname = window.location.pathname; // Returns path only (/path/example.html)
        // var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
        var origin   = window.location.origin;   // Returns base URL (https://example.com)
        filePath = origin + '/icms-cpc/assets/images/attachments/' + fileToDownload
        window.location.href = filePath
    })


})