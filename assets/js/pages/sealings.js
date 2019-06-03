jQuery(document).ready(function($) {

    $("#strim").change(function() {
        var strim = $(this).val()
        // Check Stream Type And Enbale/Disbale Field
        if ( strim != 'CBN' ) {
            $("#currentSealNumber").attr('disabled', 'disabled')
        } else {
            $("#currentSealNumber").removeAttr('disabled')
        }
    })

    $("#amount").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#amountFb").html("Digits Only").show().fadeOut("very-slow");
                return false;
        }
    })

    $("#amount").keyup(function(){
        var amount = $(this).val()
        $("#formatedAmount").html( addCommas(amount) )
        var remainAmount = $("#remainAmount").val()
        var difAmount = parseInt(remainAmount) - parseInt(amount)
        $("#remAmount").html(addCommas(difAmount))
        // Check If Amount Is Higher Than Expected
        if ( difAmount >= 0 ) {
            $('.sealThisContainer').show()
        } else {
            $('.sealThisContainer').hide()
        }
    })

    $("#currentSealNumber").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#sealFb").html("Digits Only").show().fadeOut("slow");
                return false;
        }
    })

    $("#currentSealNumber").keyup(function() {
        currentSealNumber = $(this).val()
        currentSealNumberSlug = currentSealNumber.replace(/\s+/g, '-').toLowerCase()
        if (currentSealNumber == '') {
            Materialize.toast('Seal Number Is Required', 2000, 'rounded')
            $("#tstamp").html('')
            $('.sealThisContainer').hide()
        }
        if (currentSealNumber.length < 6) {
            $('.sealThisContainer').hide()
        } else {
            var tymStamp = $('#tymStamp').val()
            $("#tstamp").html(tymStamp)
            gencurrentSealNumber = tymStamp+'-'+currentSealNumber
            $("#newcurrentSealNumber").html(gencurrentSealNumber)
            $('#gencurrentSealNumber').val(gencurrentSealNumber)
            $.ajax({
                url: "app/pf/verify-seal-numbers.php",
                method: "POST",
                data: { verifySealingcurrentSealNumber: 1, currentSealNumber: currentSealNumber },
                success: function(data) {
                    console.log(data)
                    $('#sealFb').html(data)
                    if (data == 'Seal Number Valid'){
                        $("#newcurrentSealNumber").html(tymStamp + '-<span class="teal-text">' + currentSealNumber + '</span>')
                        $('.sealThisContainer').show()
                    } else {
                        $("#newcurrentSealNumber").html(tymStamp + '-<span class="red-text">' + currentSealNumber + '</span>')
                        $('.sealThisContainer').hide()
                    }
                }
            })
        }
    })

    $("#sealNumber").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#sealFb").html("Digits Only").show().fadeOut("slow");
                return false;
        }
    })

    $("#sealNumber").keyup(function() {
        sealNumber = $(this).val()
        sealNumberSlug = sealNumber.replace(/\s+/g, '-').toLowerCase()
        if (sealNumber == '') {
            Materialize.toast('Seal Number Is Required', 2000, 'rounded')
            $("#tstamp").html('')
            $('.sealThisContainer').hide()
        }
        if (sealNumber.length < 6) {
            $('.sealThisContainer').hide()
        } else {
            var tymStamp = $('#tymStamp').val()
            $("#tstamp").html(tymStamp)
            genSealNumber = tymStamp+'-'+sealNumber
            $("#newSealNumber").html(genSealNumber)
            $('#genSealNumber').val(genSealNumber)
            $.ajax({
                url: "app/pf/verify-seal-numbers.php",
                method: "POST",
                data: { verifySealingSealNUmber: 1, sealNumber: sealNumber },
                success: function(data) {
                    console.log(data)
                    $('#sealFb').html(data)
                    if (data == 'Seal Number Already Exists'){
                        $("#newSealNumber").html(tymStamp + '-<span class="red-text">' + sealNumber + '</span>')
                        $('.sealThisContainer').hide()
                    } else {
                        $("#newSealNumber").html(tymStamp + '-<span class="teal-text">' + sealNumber + '</span>')
                        $('.sealThisContainer').show()
                    }
                }
            })
        }
    })
    
    // var totalAmountSealed = 0

    // Seal Container
    $(".sealThisContainer").click(function(event) {
        event.preventDefault()
        var strim = $("#strim").val()
        var sealingTitle = $("#sealingTitle").val()
        var cClientName = $("#clientId").val()
        var cGenCurSealNumber = $("#gencurrentSealNumber").val()
        var cGenSealNumber = $("#genSealNumber").val()
        var cLocation = $("#locationId").val()
        var cCategory = $("#categoryId").val()
        var cContainer = $("#containerId").val()
        var cCurrency = $("#currencyId").val()
        var cDenomination = $("#denominationId").val()
        var cAmount = $("#amount").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var sealBatch = $("#todaySealings").val()
        var totalAmountSealed = username + $("#amountSealedByUser").val()
        if (totalAmountSealed == '' || strim == '' || cAmount == '' || sealingTitle == '' || cClientName == '' || cCategory == '' || cGenSealNumber == '' || cContainer == '' || cLocation == '' || cCurrency == '' || cDenomination == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded');
        } else {
            $(".sealThisContainer").html('<div class="progress"><div class="indeterminate"></div></div> Sealing');
            $(".sealThisContainer").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/sealings.php",
                method: "POST",
                data: { sealThisContainer: 1, strim: strim, sealingTitle: sealingTitle, cClientName: cClientName, cCategory: cCategory, cGenCurSealNumber: cGenCurSealNumber, cGenSealNumber: cGenSealNumber, cLocation: cLocation, cContainer: cContainer, cCurrency: cCurrency, cDenomination: cDenomination, cAmount: cAmount, sealBatch: sealBatch, totalAmountSealed: totalAmountSealed, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".sealThisContainer").html('<i class="material-icons left">lock_outline</i> Seal Container ')
                    $(".sealThisContainer").removeAttr('disabled')
                    if (data == "done") {
                        Materialize.toast('Sealing Successful', 1000, 'rounded')
                        window.setTimeout(function() {
                            // $('#sealConsignment').modal('close') // Close modal
                            location.href="sealings"
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Sealing Failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    console.log(localStorage.getItem('amountSealed'))

})