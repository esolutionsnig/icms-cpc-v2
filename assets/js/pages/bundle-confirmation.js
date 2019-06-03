jQuery(document).ready(function($) {

    $("#qSealNumber").change(function() {
        var qSealNumber = $(this).val()
        //Assign Seal Number To Exception Button data-excsealnumber
        var d = document.getElementById("throwExcept");  //   Javascript
        d.setAttribute('data-id' , qSealNumber);       //
        $(".loadingData").html('<div class="progress"><div class="indeterminate"></div></div> Fetching ');
        $.ajax({
            url: "app/pf/bundle-confirmation.php",
            method: "POST",
            data: { loadBag: 1, qSealNumber: qSealNumber},
            success: function(data) {
                $(".loadingData").html('')
                $("#loadBag").html(data)
                $(".beginBc").removeAttr('disabled')
            }
        })

        // Load Branch
        $("#branchId").val('')
        $.ajax({
            url: 'app/pf/bundle-confirmation.php',
            type: 'post',
            data: {loadBranch: 1, qSealNumber: qSealNumber},
            success:function(response){
                $("#branchId").val(response)
            }
        })
    })

    // Load BC form elements
    var result
    var i
    var fe
    var i1000
    var i500
    var i200
    var i100
    var i50
    var i20
    var i10 
    var i5
    var i1
    $(".beginBc").click(function(event) {
        event.preventDefault()
        $("#currencyId").removeAttr('disabled')
        $("#bundleConfirmationComment").removeAttr('disabled')
        $(".teBtn").removeAttr('disabled')
        $(".confirmThisBag").removeAttr('disabled')
        $(".computeAmount").removeAttr('disabled')
        var listDens = $("#listDens").val()
        result = listDens.split(', ')
        // console.log(result)
        // Loop Through Result
        for(i = 0; i < result.length; i++){
            fe = result[i]
            $('#bcFormElementz').append('<div class="row margin"><div class="input-field col l4 m4 s6"><small for="d'+fe+'">Denomination: '+addCommas(fe)+'</small><input type="text" id="d'+fe+'" value="'+fe+'" readonly></div><div class="input-field col l4 m4 s6"><small for="d'+fe+'Amount">Amount <span id="d'+fe+'AmountF"></span></small><input type="text" id="d'+fe+'Amount" value="0" class="amounts" onkeypress="return isNumber(event)"></div><div class="input-field col l4 m4 s6"><small>Cash Category ID</small><input type="text" id="d'+fe+'Category" placeholder="Number Only" class="amounts" onkeypress="return isNumber(event)"></div></div>')
        }
        // Check If Element Exists In Array
        if(jQuery.inArray('1000',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d1000" value="1000"><input type="hidden" id="d1000Amount" value="0" class="amounts"><input type="hidden" id="d1000Category">')
        }
        if(jQuery.inArray('500',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d500" value="500"><input type="hidden" id="d500Amount" value="0" class="amounts"><input type="hidden" id="d500Category">')
        }
        if(jQuery.inArray('200',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d200" value="200"><input type="hidden" id="d200Amount" value="0" class="amounts"><input type="hidden" id="d200Category">')
        }
        if(jQuery.inArray('100',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d100" value="100"><input type="hidden" id="d100Amount" value="0" class="amounts"><input type="hidden" id="d100Category">')
        }
        if(jQuery.inArray('50',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d50" value="50"><input type="hidden" id="d50Amount" value="0" class="amounts"><input type="hidden" id="d50Category">')
        }
        if(jQuery.inArray('20',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d20" value="20"><input type="hidden" id="d20Amount" value="0" class="amounts"><input type="hidden" id="d20Category">')
        }
        if(jQuery.inArray('10',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d10" value="10"><input type="hidden" id="d10Amount" value="0" class="amounts"><input type="hidden" id="d10Category">')
        }
        if(jQuery.inArray('5',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d5" value="5"><input type="hidden" id="d5Amount" value="0" class="amounts"><input type="hidden" id="d5Category">')
        }
        if(jQuery.inArray('1',result) == -1){
            $('#bcFormElementz').append('<input type="hidden" id="d1" value="1"><input type="hidden" id="d1Amount" value="0" class="amounts"><input type="hidden" id="d1Category">')
        }
    })

    // Start Bundle Confirmatio
    $(".startBundleConfirmation").click(function(event) {
        event.preventDefault()
        var bcTitle = $("#bcTitle").val()
        var clientName = $("#clientName").val()
        var strim = $("#strim").val()
        var conslocation = $("#conslocation").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        $.ajax({
            url: "app/pf/bundle-confirmation.php",
            method: "POST",
            data: { startBundleConfirmation: 1, bcTitle: bcTitle, clientName: clientName, strim: strim, conslocation: conslocation, username: username, usertoken: usertoken},
            success: function(data) {
                if (data == "bcstarted") {
                    Materialize.toast('Bundle Confirmation Successfully Started', 1000, 'rounded')
                    window.setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else {
                    console.log(data)
                    Materialize.toast('Transaction Failed: ' + data, 1000, 'rounded')
                }
            }
        })
    })

    $("#d1000Amount").keyup(function() {
        d1000Amount = $(this).val()
        $("#d1000AmountF").html(addCommas(d1000Amount))
    })
    $("#d500Amount").keyup(function() {
        d500Amount = $(this).val()
        $("#d500AmountF").html(addCommas(d500Amount))
    })
    $("#d200Amount").keyup(function() {
        d200Amount = $(this).val()
        $("#d200AmountF").html(addCommas(d200Amount))
    })
    $("#d100Amount").keyup(function() {
        d100Amount = $(this).val()
        $("#d100AmountF").html(addCommas(d100Amount))
    })
    $("#d50Amount").keyup(function() {
        d50Amount = $(this).val()
        $("#d50AmountF").html(addCommas(d50Amount))
    })
    $("#d20Amount").keyup(function() {
        d20Amount = $(this).val()
        $("#d20AmountF").html(addCommas(d20Amount))
    })
    $("#d10Amount").keyup(function() {
        d10Amount = $(this).val()
        $("#d10AmountF").html(addCommas(d10Amount))
    })
    $("#d5Amount").keyup(function() {
        d5Amount = $(this).val()
        $("#d5AmountF").html(addCommas(d5Amount))
    })
    $("#d1Amount").keyup(function() {
        d1Amount = $(this).val()
        $("#d1AmountF").html(addCommas(d1Amount))
    })

    var sumAll = 0;
    // Grab Value And Feedback
    $(".computeAmount").click(function(event) {
        event.preventDefault()
        var d1000Amount =  $("#d1000Amount").val()
        var d500Amount =  $("#d500Amount").val()
        var d200Amount =  $("#d200Amount").val()
        var d100Amount =  $("#d100Amount").val()
        var d50Amount =  $("#d50Amount").val()
        var d20Amount =  $("#d20Amount").val()
        var d10Amount =  $("#d10Amount").val()
        var d5Amount =  $("#d5Amount").val()
        var d1Amount =  $("#d1Amount").val()
        var tamount =  $("#tamount").val()
        var tamountbc =  $("#tamountbc").val()
        var sumAll = parseInt(d1000Amount) + parseInt(d500Amount) + parseInt(d200Amount) + parseInt(d100Amount) + parseInt(d50Amount) + parseInt(d20Amount) + parseInt(d10Amount) + parseInt(d5Amount) + parseInt(d1Amount)
        $(".totalAmount").html(addCommas(sumAll))
        $("#totalAmount").val(sumAll)
        // Check If Total Amount In Bag Is Different From Amount Inputed
        var expAmount = parseInt(tamount)
        var bundleConfirmed = parseInt(tamountbc)
        // Get The Difference In Amount Between Amount To Be Bundle Confirmed And Inputed value
        var diffInAmount = expAmount - sumAll
        // Get Total Amount Left To Be Bundle Confirmed
        var amountToBC = expAmount - bundleConfirmed
        // Get The Difference In Amount Between Amount Left To Be Confirmed And Total Value Inputed
        var diffInAmountBC = amountToBC - sumAll
        var negateDiffInAmount = sumAll - expAmount
        var negateDiffInAmountBC = sumAll - amountToBC
        // console.log(diffInAmount)
        if ( diffInAmount < 0 ) {
            $('#showErrorInAmountEntered').html('<div class="alert-box-error uppercase"><h5>Warning: Difference In Amount</h5><h6>The System Has Detected That The Amount Entered Is Higher Than The Amount In The Chosen Bag By <strong class="deepred-text">'+addCommas(negateDiffInAmount)+'</strong>, Kindly Confirm Your Inputed Values.</h6></div>')
            $('.confirmThisBag').hide()
        } else {
            $('#showErrorInAmountEntered').html('')
            $('.confirmThisBag').show()
        }
        if ( diffInAmountBC < 0 ) {
            $('#showErrorInAmountEntered').html('<div class="alert-box-error uppercase"><h5>Warning: Difference In Amount</h5><h6>The System Has Detected That The Amount Entered Is Higher Than The Amount In The Chosen Bag By <strong class="deepred-text">'+addCommas(negateDiffInAmountBC)+'</strong>, Kindly Confirm Your Inputed Values.</h6></div>')
            $('.confirmThisBag').hide()
        } else {
            $('#showErrorInAmountEntered').html('')
            $('.confirmThisBag').show()
        }
    })

    // Confirm and Add Bag 
    var d1000Category = ''
    var d500Category = ''
    var d200Category = ''
    var d100Category = ''
    var d50Category = ''
    var d20Category = ''
    var d10Category = ''
    var d5Category = ''
    var d1Category = ''
    var d1000 = ''
    var d500 = ''
    var d200 = ''
    var d100 = ''
    var d50 = ''
    var d20 = ''
    var d10 = ''
    var d5 = ''
    var d1 = ''
    var d1000Amount = 0
    var d500Amount = 0
    var d200Amount = 0
    var d100Amount = 0
    var d50Amount = 0
    var d20Amount = 0
    var d10Amount = 0
    var d5Amount = 0
    var d1Amount = 0
    var dcStream = ''
    $(".confirmThisBag").click(function(event) {
        event.preventDefault()
        var qSealNumber = $("#qSealNumber").val()
        var tamount = $("#tamount").val()
        var tamountbc = $("#tamountbc").val()
        var depType = $("#depType").val()
        var bcsId = $("#bcsId").val()
        var clientId = $("#clientId").val()
        var branchId = $("#branchId").val()
        d1000 = $("#d1000").val()
        d1000Amount = $("#d1000Amount").val()
        d1000Category = $("#d1000Category").val()
        d500 = $("#d500").val()
        d500Amount = $("#d500Amount").val()
        d500Category = $("#d500Category").val()
        d200 = $("#d200").val()
        d200Amount = $("#d200Amount").val()
        d200Category = $("#d200Category").val()
        d100 = $("#d100").val()
        d100Amount = $("#d100Amount").val()
        d100Category = $("#d100Category").val()
        d50 = $("#d50").val()
        d50Amount = $("#d50Amount").val()
        d50Category = $("#d50Category").val()
        d20 = $("#d20").val()
        d20Amount = $("#d20Amount").val()
        d20Category = $("#d20Category").val()
        d10 = $("#d10").val()
        d10Amount = $("#d10Amount").val()
        d10Category = $("#d10Category").val()
        d5 = $("#d5").val()
        d5Amount = $("#d5Amount").val()
        d5Category = $("#d5Category").val()
        d1 = $("#d1").val()
        d1Amount = $("#d1Amount").val()
        d1Category = $("#d1Category").val()
        var currencyId = $("#currencyId").val()
        var amount = $("#totalAmount").val()
        var bundleConfirmationComment = $("#bundleConfirmationComment").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var bcStream = $("#bcStream").val()
        if ( depType == 1 ){
            dcStream = 'CBN'
        } else {
            dcStream = 'Others'
        }
        if ( dcStream != bcStream ){
            Materialize.toast('You Can Only Add Bags From The Same Stream, Your Current Stream Is = ' + bcStream, 5000, 'rounded')
        } else {
            if (qSealNumber == '' || amount == '' || username == '' || usertoken == '') {
                Materialize.toast('Click The Get Total Amount Button', 1000, 'rounded');
            } else {
                if ( parseInt(tamountbc) < parseInt(tamount) ) {
                    $(".confirmThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Confirming ');
                    $(".confirmThisBag").attr('disabled', 'disabled');
                    $.ajax({
                        url: "app/pf/bundle-confirmation.php",
                        method: "POST",
                        data: { confirmThisBag: 1, qSealNumber: qSealNumber, tamount: tamount, tamountbc: tamountbc, bcsId: bcsId, clientId: clientId, branchId: branchId, d1000: d1000, d1000Amount: d1000Amount, d1000Category: d1000Category, d500: d500, d500Amount: d500Amount, d500Category: d500Category, d200: d200, d200Amount: d200Amount, d200Category: d200Category, d100: d100, d100Amount: d100Amount, d100Category: d100Category, d50: d50, d50Amount: d50Amount, d50Category: d50Category, d20: d20, d20Amount: d20Amount, d20Category: d20Category, d10: d10, d10Amount: d10Amount, d10Category: d10Category, d5: d5, d5Amount: d5Amount, d5Category: d5Category, d1: d1, d1Amount: d1Amount, d1Category: d1Category, currencyId: currencyId, amount: amount, bundleConfirmationComment: bundleConfirmationComment, username: username, usertoken: usertoken},
                        success: function(data) {
                            $(".confirmThisBag").html('<i class="material-icons left">save</i> Confirm Bag Content ')
                            $(".confirmThisBag").removeAttr('disabled')
                            if (data == "confirmed") {
                                Materialize.toast('Bundle Confirmed', 1000, 'rounded')
                                window.setTimeout(function() {
                                    location.reload()
                                    // $(".totalAmount").html('')
                                    // $("#bcForm")[0].reset();
                                }, 1000)
                            } else {
                                console.log(data)
                                Materialize.toast('Failed To Save: ' + data, 3000, 'rounded')
                            }
                        }
                    })
                } else {
                    Materialize.toast('You Have Bundle Confirmed Contents Of This Bag', 2000, 'rounded')
                }
            }
        }
    })

    //Fetch data from button and pass to modal
    $(".triggerBtn").click(function(event){
        event.preventDefault();
        var bcsid = $(this).data('bcsid');
        $(".modal-body #bcsidId").val( bcsid );
    })

    // Confirm and Add Bag
    $(".endThisBundleConfirmation").click(function(event) {
        event.preventDefault()
        var bcsidId = $("#bcsidId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (bcsidId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 1000, 'rounded');
        } else {
            $(".endThisBundleConfirmation").html('<div class="progress"><div class="indeterminate"></div></div> Ending');
            $(".endThisBundleConfirmation").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { endThisBundleConfirmation: 1, bcsidId: bcsidId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".endThisBundleConfirmation").html('<i class="material-icons left">done_all</i> YES END THIS BUNDLE CONFIRMATION ')
                    $(".endThisBundleConfirmation").removeAttr('disabled')
                    if (data == "done") {
                        Materialize.toast('Bundle Confirmation Done', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

})