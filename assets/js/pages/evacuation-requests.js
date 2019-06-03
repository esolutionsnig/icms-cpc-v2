jQuery(document).ready(function($) {

    var erName = ""
    var erSlug = ""
    
    // $(".doneAll").hide()

    $("#erName").keyup(function() {
        erName = $(this).val()
        erSlug = erName.replace(/\s+/g, '-').toLowerCase()
        if (erName == '') {
            Materialize.toast('Evacuation Request Title Is Required', 3000, 'rounded')
        }
    })

    $("#clientBranch").change(function(){
        var deptid = $(this).val()

        $.ajax({
            url: 'getClientBranch.php',
            type: 'post',
            data: {depart:deptid},
            success:function(response){
                $("#clientBranchL").empty()
                $("#clientBranchLC").empty()
                var obj = jQuery.parseJSON(response);
                $.each(obj, function(key,value) {
                    $("#clientBranchL").val(value.branch_location)
                    $("#clientBranchLC").val(value.branch_location_code)
                })
            }
        })
    })

    $(".proceedToCashAllocation").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var erName = $("#erName").val()
        var bankId = $("#bankId").val()
        var clientBranch = $("#clientBranch").val()
        var clientBranchL = $("#clientBranchL").val()
        var clientBranchLC = $("#clientBranchLC").val()
        var consignmentLocation = $("#consignmentLocation").val()
        var dateOfExecution = $("#dateOfExecution").val()
        if (erName == '' || clientBranch == '' || clientBranchL == '' || clientBranchLC == '' || consignmentLocation == '' || dateOfExecution == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1500, 'rounded');
        } else {
            $(".proceedToCashAllocation").html('<div class="progress"><div class="indeterminate"></div></div> Sending Request');
            $(".proceedToCashAllocation").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { sendER: 1, erName: erName, erSlug: erSlug, bankId:bankId, consignmentLocation:consignmentLocation, clientBranchLC: clientBranchLC, clientBranch:clientBranch, clientBranchL: clientBranchL, dateOfExecution: dateOfExecution, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".proceedToCashAllocation").html('<i class="material-icons right">send</i> Send Evacuation Request  ')
                    $(".proceedToCashAllocation").removeAttr('disabled')
                    if (data == "rsent") {
                        Materialize.toast('Evacuation Request Successfully Sent', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.href='evacuation-requests'
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    $(".updateEvacuationRequest").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var erId = $("#erId").val()
        var erName = $("#erName").val()
        var bankId = $("#bankId").val()
        var clientBranch = $("#clientBranch").val()
        var clientBranchL = $("#clientBranchL").val()
        var clientBranchLC = ''
        var consignmentLocation = $("#consignmentLocation").val()
        var dateOfExecutione = $("#dateOfExecutione").val()
        if (erId == '' || erName == '' || clientBranch == '' || clientBranchL == '' || consignmentLocation == '' || dateOfExecutione == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1000, 'rounded');
        } else {
            $(".updateEvacuationRequest").html('<div class="progress"><div class="indeterminate"></div></div> Saving Changes');
            $(".updateEvacuationRequest").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { updateER: 1, erId: erId, erName: erName, erSlug: erSlug, bankId:bankId, consignmentLocation:consignmentLocation, clientBranchLC: clientBranchLC, clientBranch:clientBranch, clientBranchL: clientBranchL, dateOfExecutione: dateOfExecutione, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateEvacuationRequest").html('<i class="material-icons right">send</i> Save Changes  ')
                    $(".updateEvacuationRequest").removeAttr('disabled')
                    if (data == "rsent") {
                        Materialize.toast('Evacuation Request Successfully Updated', 1000, 'rounded')
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

    $("#depositType").change(function() {
        var depositTypeId = $(this).val()
        if(depositTypeId == '1') {
            $("#iCBN").show()
            $("#nCBN").hide()
            $("#isNaira").hide()
            $("#isUsd").hide()
            $("#isEuro").hide()
            $("#isGbp").hide()
            $("#isZar").hide()
            $("#isCfa").hide()
            $("#isCny").hide()
        } else {
            $("#iCBN").hide()
            $("#nCBN").show()
        }
    })

    // Sum CBN Deposity Type
    $(document).on("change", ".cbnCash", function() {
        var chosenPieces = $('#pieces').val()
        var chosenDenomination = $('#denomination').val()
        var cbnTotal = chosenDenomination * chosenPieces
        $("#totalAmountC").val(cbnTotal)
        $(".totalAmountC").html(addCommas(cbnTotal))
    })

    // Cash Preparation Naira
    $(".cashAllocationCbn").click(function(event) {
        event.preventDefault()
        var cbn = $("#cbn").val()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()
        var chozenDenomination = $('#denomination').val()
        var totalAmountC = $("#totalAmountC").val()

        if (chozenDenomination == '1000'){
            var cash1000 = 1000
            var cash1000Amount = totalAmountC
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '500'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = 500
            var cash500Amount = totalAmountC
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '200'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = 200
            var cash200Amount = totalAmountC
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '100'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = 100
            var cash100Amount = totalAmountC
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '50'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = 50
            var cash50Amount = totalAmountC
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '20'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = 20
            var cash20Amount = totalAmountC
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '10'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = 10
            var cash10Amount = totalAmountC
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '5'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = 5
            var cash5Amount = totalAmountC
            var cash1 = ''
            var cash1Amount = ''
        } else if (chozenDenomination == '1'){
            var cash1000 = ''
            var cash1000Amount = ''
            var cash500 = ''
            var cash500Amount = ''
            var cash200 = ''
            var cash200Amount = ''
            var cash100 = ''
            var cash100Amount = ''
            var cash50 = ''
            var cash50Amount = ''
            var cash20 = ''
            var cash20Amount = ''
            var cash10 = ''
            var cash10Amount = ''
            var cash5 = ''
            var cash5Amount = ''
            var cash1 = 1
            var cash1Amount = totalAmountC
        } else {
            console.log('Failed To Load Denomination Type')
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationCbn").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationCbn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addCbnCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, cbn: cbn, cash1000: cash1000, cash1000Amount: cash1000Amount, cash500: cash500, cash500Amount: cash500Amount, cash200: cash200, cash200Amount: cash200Amount, cash100: cash100, cash100Amount: cash100Amount, cash50: cash50, cash50Amount: cash50Amount, cash20: cash20, cash20Amount: cash20Amount, cash10: cash10, cash10Amount: cash10Amount, cash5: cash5, cash5Amount: cash5Amount, cash1: cash1, cash1Amount: cash1Amount, totalAmountC: totalAmountC, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationCbn").html('<i class="material-icons right">save</i> Save CBN Cash Preparation ')
                    if (data == "cbnAdded") {
                    // $(".cashAllocationCbn").removeAttr('disabled')
                        Materialize.toast('Naira Saved', 1000, 'rounded')
                        // Reset Fields
                        $("#totalAmountC").val('')
                        $(".totalAmountC").html('')
                    } else {
                        $(".cashAllocationCbn").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })

    //Process Prepare Cash
    // Naira Collection
    var ncash1000Amount = 0
    var ncash500Amount = 0
    var ncash200Amount = 0
    var ncash100Amount = 0
    var ncash50Amount = 0
    var ncash20Amount = 0
    var ncash10Amount = 0
    var ncash5Amount = 0
    var ncash1Amount = 0
    var ntotalAmount = 0

    // USD Collection
    var ucash1000Amount = 0
    var ucash500Amount = 0
    var ucash200Amount = 0
    var ucash100Amount = 0
    var ucash50Amount = 0
    var ucash20Amount = 0
    var ucash10Amount = 0
    var ucash5Amount = 0
    var ucash1Amount = 0
    var utotalAmount = 0
    
    // Europ Collection
    var ecash1000Amount = 0
    var ecash500Amount = 0
    var ecash200Amount = 0
    var ecash100Amount = 0
    var ecash50Amount = 0
    var ecash20Amount = 0
    var ecash10Amount = 0
    var ecash5Amount = 0
    var ecash1Amount = 0
    var etotalAmount = 0
    
    // GBP Collection
    var gcash1000Amount = 0
    var gcash500Amount = 0
    var gcash200Amount = 0
    var gcash100Amount = 0
    var gcash50Amount = 0
    var gcash20Amount = 0
    var gcash10Amount = 0
    var gcash5Amount = 0
    var gcash1Amount = 0
    var gtotalAmount = 0
    
    // ZAR Collection
    var zcash1000Amount = 0
    var zcash500Amount = 0
    var zcash200Amount = 0
    var zcash100Amount = 0
    var zcash50Amount = 0
    var zcash20Amount = 0
    var zcash10Amount = 0
    var zcash5Amount = 0
    var zcash1Amount = 0
    var ztotalAmount = 0

    // CFA Collection
    var ccash1000Amount = 0
    var ccash500Amount = 0
    var ccash200Amount = 0
    var ccash100Amount = 0
    var ccash50Amount = 0
    var ccash20Amount = 0
    var ccash10Amount = 0
    var ccash5Amount = 0
    var ccash1Amount = 0
    var ctotalAmount = 0
    
    // CNY Collection
    var ycash1000Amount = 0
    var ycash500Amount = 0
    var ycash200Amount = 0
    var ycash100Amount = 0
    var ycash50Amount = 0
    var ycash20Amount = 0
    var ycash10Amount = 0
    var ycash5Amount = 0
    var ycash1Amount = 0
    var ytotalAmount = 0

    var usd = ''
    var euro = ''
    var naira = ''
    var gbp = ''
    var zar = ''
    var cny = ''
    var cfa = ''
    $("#usd").change(function() {
        if(this.checked) {
            usd = 'usd'
            $('#isUsd').show()
        } else {
            $('#isUsd').hide()
        }
    })
    $("#euro").change(function() {
        if(this.checked) {
            euro = 'euro'
            $('#isEuro').show()
        } else {
            $('#isEuro').hide()
        }
    })
    $("#naira").change(function() {
        if(this.checked) {
            naira = 'naira'
            $('#isNaira').show()
        } else {
            $('#isNaira').hide()
        }
    })
    $("#gbp").change(function() {
        if(this.checked) {
            gbp = 'gbp'
            $('#isGbp').show()
        } else {
            $('#isGbp').hide()
        }
    })
    $("#cny").change(function() {
        if(this.checked) {
            cny = 'cny'
            $('#isCny').show()
        } else {
            $('#isCny').hide()
        }
    })
    $("#cfa").change(function() {
        if(this.checked) {
            cfa = 'cfa'
            $('#isCfa').show()
        } else {
            $('#isCfa').hide()
        }
    })
    $("#zar").change(function() {
        if(this.checked) {
            zar = 'zar'
            $('#isZar').show()
        } else {
            $('#isZar').hide()
        }
    })

    // Sum Naira
    $(document).on("keyup", ".naira", function() {
        var nSum = 0
        $(".naira").each(function(){
            nSum += +$(this).val()
        })
        $("#nTotalAmount").val(nSum)
        $(".nTotalAmount").html(addCommas(nSum))
    })
    // Sum Euro
    $(document).on("keyup", ".euro", function() {
        var eSum = 0
        $(".euro").each(function(){
            eSum += +$(this).val()
        })
        $("#eTotalAmount").val(eSum)
        $(".eTotalAmount").html(addCommas(eSum))
    })
    // Sum Usd
    $(document).on("keyup", ".usd", function() {
        var uSum = 0
        $(".usd").each(function(){
            uSum += +$(this).val()
        })
        $("#uTotalAmount").val(uSum)
        $(".uTotalAmount").html(addCommas(uSum))
    })
    // Sum Gbp
    $(document).on("keyup", ".gbp", function() {
        var gSum = 0
        $(".gbp").each(function(){
            gSum += +$(this).val()
        })
        $("#gTotalAmount").val(gSum)
        $(".gTotalAmount").html(addCommas(gSum))
    })
    // Sum ZAR
    $(document).on("keyup", ".zar", function() {
        var zSum = 0
        $(".zar").each(function(){
            zSum += +$(this).val()
        })
        $("#zTotalAmount").val(zSum)
        $(".zTotalAmount").html(addCommas(zSum))
    })
    // Sum CFA
    $(document).on("keyup", ".cfa", function() {
        var cSum = 0
        $(".cfa").each(function(){
            cSum += +$(this).val()
        })
        $("#cTotalAmount").val(cSum)
        $(".cTotalAmount").html(addCommas(cSum))
    })
    // Sum CNY
    $(document).on("keyup", ".cny", function() {
        var ySum = 0
        $(".cny").each(function(){
            ySum += +$(this).val()
        })
        $("#yTotalAmount").val(ySum)
        $(".yTotalAmount").html(addCommas(ySum))
    })

    // Cash Preparation Naira
    $(".cashAllocationNaira").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (naira != ''){
            ncash1000 = $("#ncash1000").val()
            ncash1000Amount = $("#ncash1000Amount").val()
            ncash500 = $("#ncash500").val()
            ncash500Amount = $("#ncash500Amount").val()
            ncash200 = $("#ncash200").val()
            ncash200Amount = $("#ncash200Amount").val()
            ncash100 = $("#ncash100").val()
            ncash100Amount = $("#ncash100Amount").val()
            ncash50 = $("#ncash50").val()
            ncash50Amount = $("#ncash50Amount").val()
            ncash20 = $("#ncash20").val()
            ncash20Amount = $("#ncash20Amount").val()
            ncash10 = $("#ncash10").val()
            ncash10Amount = $("#ncash10Amount").val()
            ncash5 = $("#ncash5").val()
            ncash5Amount = $("#ncash5Amount").val()
            ncash1 = $("#ncash1").val()
            ncash1Amount = $("#ncash1Amount").val()
            nTotalAmount = $("#nTotalAmount").val()
        } else {
            console.log(89)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationNaira").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationNaira").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addNairaCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, naira: naira, ncash1000:ncash1000, ncash1000Amount: ncash1000Amount, ncash500:ncash500, ncash500Amount: ncash500Amount, ncash200: ncash200, ncash200Amount: ncash200Amount, ncash100: ncash100, ncash100Amount: ncash100Amount, ncash50: ncash50, ncash50Amount: ncash50Amount, ncash20: ncash20, ncash20Amount: ncash20Amount, ncash10: ncash10, ncash10Amount: ncash10Amount, ncash5: ncash5, ncash5Amount: ncash5Amount, ncash1: ncash1, ncash1Amount: ncash1Amount, nTotalAmount:nTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationNaira").html('<i class="material-icons right">save</i> Save Naira Cash Preparation ')
                    if (data == "nAdded") {
                    // $(".cashAllocationNaira").removeAttr('disabled')
                        Materialize.toast('Naira Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#ncash1000Amount").val('')
                        $("#ncash500Amount").val('')
                        $("#ncash200Amount").val('')
                        $("#ncash100Amount").val('')
                        $("#ncash50Amount").val('')
                        $("#ncash20Amount").val('')
                        $("#ncash10Amount").val('')
                        $("#ncash5Amount").val('')
                        $("#ncash1Amount").val('')
                        $("#nTotalAmount").val('')
                        $(".nTotalAmount").html('')
                    } else {
                        $(".cashAllocationNaira").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Cash Preparation Dollar
    $(".cashAllocationDollar").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (usd != ''){
            ucash1000 = $("#ucash1000").val()
            ucash1000Amount = $("#ucash1000Amount").val()
            ucash500 = $("#ucash500").val()
            ucash500Amount = $("#ucash500Amount").val()
            ucash200 = $("#ucash200").val()
            ucash200Amount = $("#ucash200Amount").val()
            ucash100 = $("#ucash100").val()
            ucash100Amount = $("#ucash100Amount").val()
            ucash50 = $("#ucash50").val()
            ucash50Amount = $("#ucash50Amount").val()
            ucash20 = $("#ucash20").val()
            ucash20Amount = $("#ucash20Amount").val()
            ucash10 = $("#ucash10").val()
            ucash10Amount = $("#ucash10Amount").val()
            ucash5 = $("#ucash5").val()
            ucash5Amount = $("#ucash5Amount").val()
            ucash1 = $("#ucash1").val()
            ucash1Amount = $("#ucash1Amount").val()
            uTotalAmount = $("#uTotalAmount").val()
        } else {
            console.log(88)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationDollar").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationDollar").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addDollarCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, usd: usd, ucash1000:ucash1000, ucash1000Amount: ucash1000Amount, ucash500:ucash500, ucash500Amount: ucash500Amount, ucash200: ucash200, ucash200Amount: ucash200Amount, ucash100: ucash100, ucash100Amount: ucash100Amount, ucash50: ucash50, ucash50Amount: ucash50Amount, ucash20: ucash20, ucash20Amount: ucash20Amount, ucash10: ucash10, ucash10Amount: ucash10Amount, ucash5: ucash5, ucash5Amount: ucash5Amount, ucash1: ucash1, ucash1Amount: ucash1Amount, uTotalAmount:uTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationDollar").html('<i class="material-icons right">save</i> Save US Dollar Cash Preparation ')
                    if (data == "uAdded") {
                    // $(".cashAllocationDollar").removeAttr('disabled')
                        Materialize.toast('US Dollar Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#ucash1000Amount").val('')
                        $("#ucash500Amount").val('')
                        $("#ucash200Amount").val('')
                        $("#ucash100Amount").val('')
                        $("#ucash50Amount").val('')
                        $("#ucash20Amount").val('')
                        $("#ucash10Amount").val('')
                        $("#ucash5Amount").val('')
                        $("#ucash1Amount").val('')
                        $("#uTotalAmount").val('')
                        $(".uTotalAmount").html('')
                    } else {
                        $(".cashAllocationDollar").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Cash Preparation Euro
    $(".cashAllocationEuro").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (euro != ''){
            ecash1000 = $("#ecash1000").val()
            ecash1000Amount = $("#ecash1000Amount").val()
            ecash500 = $("#ecash500").val()
            ecash500Amount = $("#ecash500Amount").val()
            ecash200 = $("#ecash200").val()
            ecash200Amount = $("#ecash200Amount").val()
            ecash100 = $("#ecash100").val()
            ecash100Amount = $("#ecash100Amount").val()
            ecash50 = $("#ecash50").val()
            ecash50Amount = $("#ecash50Amount").val()
            ecash20 = $("#ecash20").val()
            ecash20Amount = $("#ecash20Amount").val()
            ecash10 = $("#ecash10").val()
            ecash10Amount = $("#ecash10Amount").val()
            ecash5 = $("#ecash5").val()
            ecash5Amount = $("#ecash5Amount").val()
            ecash1 = $("#ecash1").val()
            ecash1Amount = $("#ecash1Amount").val()
            eTotalAmount = $("#eTotalAmount").val()
        } else {
            console.log(88)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationEuro").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationEuro").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addEuroCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, euro: euro, ecash1000:ecash1000, ecash1000Amount: ecash1000Amount, ecash500:ecash500, ecash500Amount: ecash500Amount, ecash200: ecash200, ecash200Amount: ecash200Amount, ecash100: ecash100, ecash100Amount: ecash100Amount, ecash50: ecash50, ecash50Amount: ecash50Amount, ecash20: ecash20, ecash20Amount: ecash20Amount, ecash10: ecash10, ecash10Amount: ecash10Amount, ecash5: ecash5, ecash5Amount: ecash5Amount, ecash1: ecash1, ecash1Amount: ecash1Amount, eTotalAmount: eTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationEuro").html('<i class="material-icons right">save</i> Save Euro Cash Preparation ')
                    if (data == "eAdded") {
                    // $(".cashAllocationEuro").removeAttr('disabled')
                        Materialize.toast('Euro Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#ecash1000Amount").val('')
                        $("#ecash500Amount").val('')
                        $("#ecash200Amount").val('')
                        $("#ecash100Amount").val('')
                        $("#ecash50Amount").val('')
                        $("#ecash20Amount").val('')
                        $("#ecash10Amount").val('')
                        $("#ecash5Amount").val('')
                        $("#ecash1Amount").val('')
                        $("#eTotalAmount").val('')
                        $(".eTotalAmount").html('')
                    } else {
                        $(".cashAllocationEuro").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Cash Preparation Pounds
    $(".cashAllocationPounds").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (gbp != ''){
            gcash1000 = $("#gcash1000").val()
            gcash1000Amount = $("#gcash1000Amount").val()
            gcash500 = $("#gcash500").val()
            gcash500Amount = $("#gcash500Amount").val()
            gcash200 = $("#gcash200").val()
            gcash200Amount = $("#gcash200Amount").val()
            gcash100 = $("#gcash100").val()
            gcash100Amount = $("#gcash100Amount").val()
            gcash50 = $("#gcash50").val()
            gcash50Amount = $("#gcash50Amount").val()
            gcash20 = $("#gcash20").val()
            gcash20Amount = $("#gcash20Amount").val()
            gcash10 = $("#gcash10").val()
            gcash10Amount = $("#gcash10Amount").val()
            gcash5 = $("#gcash5").val()
            gcash5Amount = $("#gcash5Amount").val()
            gcash1 = $("#gcash1").val()
            gcash1Amount = $("#gcash1Amount").val()
            gTotalAmount = $("#gTotalAmount").val()
        } else {
            console.log(86)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationPounds").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationPounds").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addPoundsCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, gbp: gbp, gcash1000:gcash1000, gcash1000Amount: gcash1000Amount, gcash500:gcash500, gcash500Amount: gcash500Amount, gcash200: gcash200, gcash200Amount: gcash200Amount, gcash100: gcash100, gcash100Amount: gcash100Amount, gcash50: gcash50, gcash50Amount: gcash50Amount, gcash20: gcash20, gcash20Amount: gcash20Amount, gcash10: gcash10, gcash10Amount: gcash10Amount, gcash5: gcash5, gcash5Amount: gcash5Amount, gcash1: gcash1, gcash1Amount: gcash1Amount, gTotalAmount: gTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationPounds").html('<i class="material-icons right">save</i> Save Pounds Cash Preparation ')
                    if (data == "gAdded") {
                    // $(".cashAllocationPounds").removeAttr('disabled')
                        Materialize.toast('Pounds Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#gcash1000Amount").val('')
                        $("#gcash500Amount").val('')
                        $("#gcash200Amount").val('')
                        $("#gcash100Amount").val('')
                        $("#gcash50Amount").val('')
                        $("#gcash20Amount").val('')
                        $("#gcash10Amount").val('')
                        $("#gcash5Amount").val('')
                        $("#gcash1Amount").val('')
                        $("#gTotalAmount").val('')
                        $(".gTotalAmount").html('')
                    } else {
                        $(".cashAllocationPounds").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Cash Preparation Zar
    $(".cashAllocationZar").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (zar != ''){
            zcash1000 = $("#zcash1000").val()
            zcash1000Amount = $("#zcash1000Amount").val()
            zcash500 = $("#zcash500").val()
            zcash500Amount = $("#zcash500Amount").val()
            zcash200 = $("#zcash200").val()
            zcash200Amount = $("#zcash200Amount").val()
            zcash100 = $("#zcash100").val()
            zcash100Amount = $("#zcash100Amount").val()
            zcash50 = $("#zcash50").val()
            zcash50Amount = $("#zcash50Amount").val()
            zcash20 = $("#zcash20").val()
            zcash20Amount = $("#zcash20Amount").val()
            zcash10 = $("#zcash10").val()
            zcash10Amount = $("#zcash10Amount").val()
            zcash5 = $("#zcash5").val()
            zcash5Amount = $("#zcash5Amount").val()
            zcash1 = $("#zcash1").val()
            zcash1Amount = $("#zcash1Amount").val()
            zTotalAmount = $("#zTotalAmount").val()
        } else {
            console.log(86)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationZar").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationZar").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addZarCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, zar: zar, zcash1000:zcash1000, zcash1000Amount: zcash1000Amount, zcash500:zcash500, zcash500Amount: zcash500Amount, zcash200: zcash200, zcash200Amount: zcash200Amount, zcash100: zcash100, zcash100Amount: zcash100Amount, zcash50: zcash50, zcash50Amount: zcash50Amount, zcash20: zcash20, zcash20Amount: zcash20Amount, zcash10: zcash10, zcash10Amount: zcash10Amount, zcash5: zcash5, zcash5Amount: zcash5Amount, zcash1: zcash1, zcash1Amount: zcash1Amount, zTotalAmount: zTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationZar").html('<i class="material-icons right">save</i> Save Zar Cash Preparation ')
                    if (data == "zAdded") {
                    // $(".cashAllocationZar").removeAttr('disabled')
                        Materialize.toast('Zar Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#zcash1000Amount").val('')
                        $("#zcash500Amount").val('')
                        $("#zcash200Amount").val('')
                        $("#zcash100Amount").val('')
                        $("#zcash50Amount").val('')
                        $("#zcash20Amount").val('')
                        $("#zcash10Amount").val('')
                        $("#zcash5Amount").val('')
                        $("#zcash1Amount").val('')
                        $("#zTotalAmount").val('')
                        $(".zTotalAmount").html('')
                    } else {
                        $(".cashAllocationZar").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Cash Preparation Cfa
    $(".cashAllocationCfa").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (cfa != ''){
            ccash1000 = $("#ccash1000").val()
            ccash1000Amount = $("#ccash1000Amount").val()
            ccash500 = $("#ccash500").val()
            ccash500Amount = $("#ccash500Amount").val()
            ccash200 = $("#ccash200").val()
            ccash200Amount = $("#ccash200Amount").val()
            ccash100 = $("#ccash100").val()
            ccash100Amount = $("#ccash100Amount").val()
            ccash50 = $("#ccash50").val()
            ccash50Amount = $("#ccash50Amount").val()
            ccash20 = $("#ccash20").val()
            ccash20Amount = $("#ccash20Amount").val()
            ccash10 = $("#ccash10").val()
            ccash10Amount = $("#ccash10Amount").val()
            ccash5 = $("#ccash5").val()
            ccash5Amount = $("#ccash5Amount").val()
            ccash1 = $("#ccash1").val()
            ccash1Amount = $("#ccash1Amount").val()
            cTotalAmount = $("#cTotalAmount").val()
        } else {
            console.log(85)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationCfa").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationCfa").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addCfaCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, cfa: cfa, ccash1000:ccash1000, ccash1000Amount: ccash1000Amount, ccash500:ccash500, ccash500Amount: ccash500Amount, ccash200: ccash200, ccash200Amount: ccash200Amount, ccash100: ccash100, ccash100Amount: ccash100Amount, ccash50: ccash50, ccash50Amount: ccash50Amount, ccash20: ccash20, ccash20Amount: ccash20Amount, ccash10: ccash10, ccash10Amount: ccash10Amount, ccash5: ccash5, ccash5Amount: ccash5Amount, ccash1: ccash1, ccash1Amount: ccash1Amount, cTotalAmount: cTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationCfa").html('<i class="material-icons right">save</i> Save Cfa Cash Preparation ')
                    if (data == "cAdded") {
                        // $(".cashAllocationCfa").removeAttr('disabled')
                        Materialize.toast('Cfa Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#ccash1000Amount").val('')
                        $("#ccash500Amount").val('')
                        $("#ccash200Amount").val('')
                        $("#ccash100Amount").val('')
                        $("#ccash50Amount").val('')
                        $("#ccash20Amount").val('')
                        $("#ccash10Amount").val('')
                        $("#ccash5Amount").val('')
                        $("#ccash1Amount").val('')
                        $("#cTotalAmount").val('')
                        $(".cTotalAmount").html('')
                    } else {
                        $(".cashAllocationCfa").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Cash Preparation Cny
    $(".cashAllocationCny").click(function(event) {
        event.preventDefault()
        var evReqId = $("#evReqId").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var containerType = $("#containerType").val()
        var sealNumber = $("#genSealNumber").val()
        var depositType = $("#depositType").val()
        var categoryType = $("#categoryType").val()

        if (cny != ''){
            ycash1000 = $("#ycash1000").val()
            ycash1000Amount = $("#ycash1000Amount").val()
            ycash500 = $("#ycash500").val()
            ycash500Amount = $("#ycash500Amount").val()
            ycash200 = $("#ycash200").val()
            ycash200Amount = $("#ycash200Amount").val()
            ycash100 = $("#ycash100").val()
            ycash100Amount = $("#ycash100Amount").val()
            ycash50 = $("#ycash50").val()
            ycash50Amount = $("#ycash50Amount").val()
            ycash20 = $("#ycash20").val()
            ycash20Amount = $("#ycash20Amount").val()
            ycash10 = $("#ycash10").val()
            ycash10Amount = $("#ycash10Amount").val()
            ycash5 = $("#ycash5").val()
            ycash5Amount = $("#ycash5Amount").val()
            ycash1 = $("#ycash1").val()
            ycash1Amount = $("#ycash1Amount").val()
            yTotalAmount = $("#yTotalAmount").val()
        } else {
            console.log(85)
        }   

        if (containerType == '' || sealNumber == '' || depositType == '' || categoryType == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields Under Preannouncement & Sealing To Proceed', 5000, 'rounded');
        } else {
            $(".cashAllocationCny").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
            $(".cashAllocationCny").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addCnyCashAllocation: 1, bankId: bankId, evReqId: evReqId, containerType: containerType, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, cny: cny, ycash1000:ycash1000, ycash1000Amount: ycash1000Amount, ycash500:ycash500, ycash500Amount: ycash500Amount, ycash200: ycash200, ycash200Amount: ycash200Amount, ycash100: ycash100, ycash100Amount: ycash100Amount, ycash50: ycash50, ycash50Amount: ycash50Amount, ycash20: ycash20, ycash20Amount: ycash20Amount, ycash10: ycash10, ycash10Amount: ycash10Amount, ycash5: ycash5, ycash5Amount: ycash5Amount, ycash1: ycash1, ycash1Amount: ycash1Amount, yTotalAmount: yTotalAmount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".cashAllocationCny").html('<i class="material-icons right">save</i> Save Cny Cash Preparation ')
                    if (data == "yAdded") {
                        // $(".cashAllocationCny").removeAttr('disabled')
                        Materialize.toast('Cny Saved', 3000, 'rounded')
                        // Reset Fields
                        $("#ycash1000Amount").val('')
                        $("#ycash500Amount").val('')
                        $("#ycash200Amount").val('')
                        $("#ycash100Amount").val('')
                        $("#ycash50Amount").val('')
                        $("#ycash20Amount").val('')
                        $("#ycash10Amount").val('')
                        $("#ycash5Amount").val('')
                        $("#ycash1Amount").val('')
                        $("#yTotalAmount").val('')
                        $(".yTotalAmount").html('')
                    } else {
                        $(".cashAllocationCny").removeAttr('disabled')
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })
    
    // Done
    $(".donePreparingCash").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var erId = $("#evReqId").val()
        $(".donePreparingCash").html('<div class="progress"><div class="indeterminate"></div></div> Processing...');
        $(".donePreparingCash").attr('disabled', 'disabled');
        $.ajax({
            url: "app/pf/evacuation-requests.php",
            method: "POST",
            data: { doneAll: 1, erId: erId,  username: username, usertoken: usertoken },
            success: function(data) {
                $(".donePreparingCash").html('<i class="material-icons right">done_all</i> Done ')
                $(".donePreparingCash").removeAttr('disabled')
                if (data == "done") {
                    Materialize.toast('Transaction Successfully', 1200, 'rounded')
                    window.setTimeout(function() {
                        location.href='evacuation-requests'
                    }, 1200)
                } else {
                    console.log(data)
                    Materialize.toast('Transaction failed: ' + data, 1200, 'rounded')
                }
            }
        })
    })

    //Fetch data from button and pass to modal
    $(".cho").click(function(event){
        event.preventDefault()
        var erId = $(this).data('id')
        var erName = $(this).data('name')
        var citConfirmationToken = $(this).data('ctokn')
        $(".modal-body #erId").val( erId )
        $(".modal-body #citConfirmationToken").val( citConfirmationToken )
        $(".modal-header #erName").html( erName )
    })

    // Cash Preparation Cny
    $(".consignmentHandOver").click(function(event) {
        event.preventDefault()
        var citConfirmationToken = $("#citConfirmationToken").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var erId = $("#erId").val()
        var cmo = $("#cmo").val()
        var vehicle = $("#vehicle").val()

        if (username == '' || usertoken == '' || erId == '' || citConfirmationToken == '' || cmo == '' || vehicle == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 5000, 'rounded');
        } else {
            $(".consignmentHandOver").html('<div class="progress"><div class="indeterminate"></div></div> Processing...');
            $(".consignmentHandOver").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { addCHO: 1, citConfirmationToken: citConfirmationToken, cmo: cmo, vehicle: vehicle, erId: erId,  username: username, usertoken: usertoken },
                success: function(data) {
                    $(".consignmentHandOver").html('<i class="material-icons right">rv_hookup</i> Hand Over Consignment ')
                    $(".consignmentHandOver").removeAttr('disabled')
                    if (data == "choAdded") {
                        Materialize.toast('Consignment Hand Over Successfully', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.href='evacuation-requests'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from button and pass to modal
    $(".delCons").click(function(event){
        event.preventDefault()
        var sealNumber = $(this).data('id')
        $(".modal-body #sealNumber").val( sealNumber )
    })

    // Delete Bag
    $(".deleteThisBag").click(function(event) {
        event.preventDefault()
        var citConfirmationToken = $("#citConfirmationToken").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var sealNumber = $("#sealNumber").val()
        var cmo = $("#cmo").val()
        var vehicle = $("#vehicle").val()

        if (username == '' || usertoken == '' || sealNumber == '' || citConfirmationToken == '' || cmo == '' || vehicle == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1000, 'rounded');
        } else {
            $(".deleteThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Deleting...');
            $(".deleteThisBag").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/evacuation-requests.php",
                method: "POST",
                data: { deleteThisBag: 1, sealNumber: sealNumber,  username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteThisBag").html('<i class="material-icons right">delete_forever</i> Yes Delete Bag ')
                    $(".deleteThisBag").removeAttr('disabled')
                    if (data == "done") {
                        Materialize.toast('Bag Deleted', 1000, 'rounded')
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
            // $(".doneAll").hide()
            $('.addPreannouncementBtn').hide()
            $('.savePreannouncement').hide()
        }
        if (sealNumber.length < 6) {
            $(".doneAll").hide()
            $('.addPreannouncementBtn').hide()
            $('.savePreannouncement').hide()
        } else {
            var tymStamp = $('#tymStamp').val()
            $("#tstamp").html(tymStamp)
            genSealNumber = tymStamp+'-'+sealNumber
            $("#newSealNumber").html(genSealNumber)
            $('#genSealNumber').val(genSealNumber)
            $.ajax({
                url: "app/pf/verify-seal-numbers.php",
                method: "POST",
                data: { verifyEvacReqSealNUmber: 1, sealNumber: sealNumber },
                success: function(data) {
                    console.log(data)
                    $('#sealFb').html(data)
                    if (data == 'Seal Number Already Exists'){
                        $("#newSealNumber").html(tymStamp + '-<span class="red-text">' + sealNumber + '</span>')
                        $('.addPreannouncementBtn').hide()
                        $('.savePreannouncement').hide()
                        // $(".doneAll").hide()
                    } else {
                        $("#newSealNumber").html(tymStamp + '-<span class="teal-text">' + sealNumber + '</span>')
                        $('.addPreannouncementBtn').show()
                        $('.savePreannouncement').show()
                        // $(".doneAll").show()
                    }
                }
            })
        }
    })

})