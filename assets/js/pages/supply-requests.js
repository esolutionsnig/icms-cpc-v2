jQuery(document).ready(function($) {

    var srTitle = ""
    var srSlug = ""

    $("#srTitle").keyup(function() {
        srTitle = $(this).val()
        srSlug = srTitle.replace(/\s+/g, '-').toLowerCase()
        if (srTitle == '') {
            Materialize.toast('Evacuation Request Title Is Required', 3000, 'rounded')
        }
    })

    $(".startSupplyRequest").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var srTitle = $("#srTitle").val()
        var clientId = $("#clientId").val()
        var requestType = $("#requestType").val()
        var supplyDate = $("#supplyDate").val()
        var srComment = $("#srComment").val()
        if (srTitle == '' || requestType == '' || supplyDate == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1500, 'rounded')
        } else {
            $(".startSupplyRequest").html('<div class="progress"><div class="indeterminate"></div></div> Starting Request');
            $(".startSupplyRequest").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { startSupplyRequest: 1, srTitle: srTitle, srSlug: srSlug, clientId: clientId, requestType: requestType, supplyDate: supplyDate, srComment: srComment, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".startSupplyRequest").html('<i class="material-icons right">send</i> Start Supply Request  ')
                    $(".startSupplyRequest").removeAttr('disabled')
                    if (data == "sm") {
                        Materialize.toast('Supply Request Successfully Started', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.href='supply-requests'
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    $(".updateSupplyRequest").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var srTitle = $("#srTitle").val()
        var clientId = $("#clientId").val()
        var requestType = $("#requestType").val()
        var supplyDate = $("#supplyDate").val()
        var srComment = $("#srComment").val()
        var srId = $("#srId").val()
        if (srId == '' || srTitle == '' || requestType == '' || supplyDate == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1500, 'rounded');
        } else {
            $(".updateSupplyRequest").html('<div class="progress"><div class="indeterminate"></div></div> Starting Request');
            $(".updateSupplyRequest").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { updateSupplyRequest: 1, srId: srId, srTitle: srTitle, srSlug: srSlug, clientId: clientId, requestType: requestType, supplyDate: supplyDate, srComment: srComment, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateSupplyRequest").html('<i class="material-icons right">send</i> Start Supply Request  ')
                    $(".updateSupplyRequest").removeAttr('disabled')
                    if (data == "sm") {
                        Materialize.toast('Supply Request Successfully Updated', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.href='supply-requests'
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    // Get amount entered and format output
    $('#amount').keyup(function() {
        var amount = $(this).val()
        // Check if amount is empty
        if (amount == ''){
            Materialize.toast('Warning: Amount Is Required', 1500, 'rounded');
        } else {
            $('#enteredAmount').html('<div class="primary-btn" id="enteredAmount" style="padding: 10px 20px;"><h3 class="white-text bold" id="enteredAmount">'+addCommas(amount)+'</h3></div>')
        }
    })

    // Save Branch Supply Request
    $(".saveBranchRequest").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var clientBranch = $("#clientBranch").val()
        var denomination = $("#denomination").val()
        var cashCategory = $("#cashCategory").val()
        var currency = $("#currency").val()
        var amount = $("#amount").val()
        var srId = $("#srId").val()
        var srClient = $("#srClient").val()
        if (srId == '' || srClient == '' || clientBranch == '' || denomination == '' || currency == '' || amount == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1500, 'rounded');
        } else {
            $(".saveBranchRequest").html('<div class="progress"><div class="indeterminate"></div></div> Saving Branch Request');
            $(".saveBranchRequest").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { saveBranchRequest: 1, srId: srId, srClient: srClient, clientBranch: clientBranch, currency: currency, denomination: denomination, cashCategory: cashCategory, amount: amount, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".saveBranchRequest").html('<i class="material-icons right">save</i> Branch Request Saved ')
                    // $(".saveBranchRequest").removeAttr('disabled')
                    if (data == "sm") {
                        Materialize.toast('Branch Request Saved', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Request failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from butoon and pass to bs-modal
    $(".deleteRequest").click(function(event){
        event.preventDefault()
        var bId = $(this).data('id')
        var branchName = $(this).data('bname')
        $(".modal-body #bId").val( bId )
        $(".modal-body #brnchName").html( branchName )
    })

    // delete Branch Supply Request
    $(".deleteBranchRequest").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var bId = $("#bId").val()
        if (bId == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1500, 'rounded');
        } else {
            $(".deleteBranchRequest").html('<div class="progress"><div class="indeterminate"></div></div> Deleting Branch Request');
            $(".deleteBranchRequest").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { deleteBranchRequest: 1, bId: bId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBranchRequest").html('<i class="material-icons right">delete_forever</i> Yes, Delete This Request ')
                    $(".deleteBranchRequest").removeAttr('disabled')
                    if (data == "sm") {
                        Materialize.toast('Branch Request Deleted', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Request failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    // Add Another Barcnh Request
    $('.doneCloseSupplyRequest').click(function(){
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var supplyId = $("#srId").val()
        if (supplyId == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Inavlid UID', 1500, 'rounded')
        } else {
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { doneCloseSupplyRequest: 1, supplyId: supplyId, username: username, usertoken: usertoken },
                success: function(data) {
                    if (data == "sm") {
                        Materialize.toast('Supply Request Concluded', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.href='supply-requests'
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Request failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    // Verify Supply Request
    $('.vrequest').click(function(){
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var supplyId = $("#srId").val()
        var verComment = $("#verComment").val()
        if (supplyId == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Inavlid UID', 1500, 'rounded')
        } else {
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { verifyThisRequest: 1, supplyId: supplyId, verComment: verComment, username: username, usertoken: usertoken },
                success: function(data) {
                    if (data == "sm") {
                        Materialize.toast('Supply Request Verified', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Request failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    // Approved Supply Request
    $('.arequest').click(function(){
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var supplyId = $("#srId").val()
        var appComment = $("#appComment").val()
        if (supplyId == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Inavlid UID', 1500, 'rounded')
        } else {
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { approveThisRequest: 1, supplyId: supplyId, appComment: appComment, username: username, usertoken: usertoken },
                success: function(data) {
                    if (data == "sm") {
                        Materialize.toast('Supply Request Approved', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Request failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from butoon and pass to bs-modal
    $(".dispatchRequest").click(function(event){
        event.preventDefault()
        var srbranchId = $(this).data('id')
        $(".modal-body #srbranchId").val( srbranchId )
    })

    // Dispatch Supply Request
    $('.drequest').click(function(){
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var srbranchId = $("#srbranchId").val()
        var cmo = $("#cmo").val()
        var vehicle = $("#vehicle").val()
        if (srbranchId == '' || cmo == '' || vehicle == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Inavlid UID', 1500, 'rounded')
        } else {
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { dispatchThisRequest: 1, srbranchId: srbranchId, cmo: cmo, vehicle: vehicle, username: username, usertoken: usertoken },
                success: function(data) {
                    if (data == "sm") {
                        Materialize.toast('Dispatch Successful', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Request failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    $("#sealNumber").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#newSealNumber").html('<span class="deepred-text">Seal Number Can Only Contain Digits Only</span>')
            return false;
        } else {
            $("#newSealNumber").html('')
        }
    })
    $("#sealNumber").keyup(function() {
        currentSealNumber = $(this).val()
        if (currentSealNumber == '') {
            $("#newSealNumber").html('<span class="deepred-text">Seal Number Is Required</span>')
            $("#tstamp").html('')
            $('.packThisBag').hide()
        } else {
            $('.packThisBag').show()
        }
        if (currentSealNumber.length < 6) {
            $('.packThisBag').hide()
        } else {
            var tymStamp = $('#tymStamp').val()
            $("#tstamp").html(tymStamp)
            var gencurrentSealNumber = tymStamp+'-'+currentSealNumber
            $("#newcurrentSealNumber").html(gencurrentSealNumber)
            $('#gencurrentSealNumber').val(gencurrentSealNumber)
            $.ajax({
                url: "app/pf/verify-seal-numbers.php",
                method: "POST",
                data: { verifySealingcurrentSealNumbers: 1, currentSealNumber: currentSealNumber },
                success: function(data) {
                    if (data == ''){
                        $("#newSealNumber").html(tymStamp + '-<span class="teal-text">' + currentSealNumber + '</span>')
                        $("#newSealNumberfb").html('<span class="teal-text">Seal Number Is Valid</span>')
                        $('.packThisBag').show()
                    } else {
                        $("#newSealNumber").html(tymStamp + '-<span class="deepred-text">' + currentSealNumber + '</span>')
                        $("#newSealNumberfb").html('<span class="deepred-text">Seal Number Is Invalid</span>')
                        $('.packThisBag').hide()
                    }
                }
            })
        }
    })

    //Fetch data from button and pass to bs-modal
    $(".packBag").click(function(event){
        event.preventDefault()
        var srUID = $(this).data('id')
        var reqAmount = $(this).data('amount')
        $(".modal-body #srUID").val( srUID )
        $(".modal-body #reqAmount").html( addCommas(reqAmount) )
        $(".modal-body #reqAmountVal").val( reqAmount )
    })

    // Dispatch Supply Request 
    $('.packThisBag').click(function(){
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var srUID = $("#srUID").val()
        var gencurrentSealNumber = $("#gencurrentSealNumber").val()
        if (srUID == '' || gencurrentSealNumber == '' || username == '' || usertoken == '') {
            Materialize.toast('Request Denied: Inavlid UID', 1500, 'rounded')
        } else {
            $(".packThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Packing');
            $(".packThisBag").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/supply-requests.php",
                method: "POST",
                data: { packThisBag: 1, srUID: srUID, gencurrentSealNumber: gencurrentSealNumber, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".packThisBag").html('<i class="material-icons right">work</i> PAck ')
                    $(".packThisBag").removeAttr('disabled')
                    if (data == "sm") {
                        Materialize.toast('Packing Completed', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Packing Failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

    // Get Container Acceptable Amount   
    var numPieces = 0
    var tamount = 0
    var chosenDenomination = 0
    var expectedDenomination = 0
    var chka = 0
    $('#containerType').change(function() {
        var containerType = $(this).val()
        if (containerType == '1'){
            $('#bag').show()
            $('#odbox').hide()
            $('#fbox').hide()
            chka = 1
        } else if (containerType == '2') {
            $('#fbox').show()
            $('#bag').hide()
            $('#odbox').hide()
            chka = 1
        } else {
            $('#odbox').show()
            $('#bag').hide()
            $('#fbox').hide()
            chka = 0
        }
    })

    // Check If Denomination IS The Same
    $('#denomination').change(function() {
        chosenDenomination = $(this).val()
        expectedDenomination = $("#srDen").val()
        // Check If Denomination
        if (chosenDenomination == expectedDenomination){
            $('#packingfeedback').html('')
            $('.getPackedAmount').show()
            $('.packThisBag').show()
        } else {
            $('#packingfeedback').html('<h5 class="deepred-text bold">Expected denomination is: '+addCommas(expectedDenomination)+'. While you have chosen: '+addCommas(chosenDenomination)+'. Kindly choose the appropriate denomination.</h5>')
            $('.getPackedAmount').hide()
            $('.packThisBag').hide()
        }
    })

    $('#numPiecess').keyup(function() {
        numPiecess = $(this).val()
        $("#enteredAmount").html(addCommas(numPiecess))
    })
    // Check If Denomination IS The Same
    $('.getPackedAmount').click(function() {
        if (chka == 0){
            numPieces = $("#numPiecess").val()
        } else {
            numPieces = $("#numPieces").val()
        }
        // Compute Amount
        var tamount = chosenDenomination * numPieces
        $("#totalAmountC").val( tamount )
        $(".totalAmountC").html(addCommas(tamount))
    })

    //Fetch data from button and pass to bs-modal
    $(".splitRequest").click(function(event){
        event.preventDefault()
        var srUID = $(this).data('id')
        var snumnotes = $(this).data('snumnotes')
        var smount = $(this).data('smount')
        var sden = $(this).data('sden')
        var maxamount = sden * 30000
        $(".modal-body #srsUID").val( srUID )
        $(".modal-body #snumnotes").html( addCommas(snumnotes) )
        $(".modal-body #smount").html( addCommas(smount) )
        $(".modal-body #maxamount").html( addCommas(maxamount) )
        $(".modal-body #sden").html( addCommas(sden) )
    })

    // Split Bag
    var i = 1  
    $('#add').click(function(){  
        i++  
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" id="splitname[]" name="splitname[]" placeholder="Enter Amount Here" required autocomplete="off" onkeypress="return AvoidSpace(event)" /></td><td><button type="button" name="remove" id="'+i+'" class="btn waves-effect waves-light btn_remove"><i class="material-icons left">add</i> Remove This Bag</button></td></tr>')  
    })  
    $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id")   
        $('#row'+button_id+'').remove()  
    })  
    // Save Split Request
    $(".splitThisBag").click(function(event) {
        event.preventDefault() 
        $(".splitThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Splitting');
        $(".splitThisBag").attr('disabled', 'disabled');        
        $.ajax({  
            url:"app/pf/supply-requestsplit.php",  
            method:"POST",  
            data:$('#add_name').serialize(),  
            success:function(data)  
            {  
                $(".splitThisBag").html('<i class="material-icons right">save</i> Save ')
                $(".splitThisBag").removeAttr('disabled')
                if (data == "") {
                    Materialize.toast('Split Successful', 1500, 'rounded')
                    window.setTimeout(function() {
                        location.reload()
                    }, 1500)
                } else {
                    console.log(data)
                    Materialize.toast('Split Failed: ' + data, 1500, 'rounded')
                } 
            }  
        })
    })

})