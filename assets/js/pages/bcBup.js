jQuery(document).ready(function($) {

    $("#qSealNumber").change(function(){
        var qSealNumber = $(this).val()
        var dataString = "qSealNumber="+qSealNumber
        $.ajax({
        type: "POST",
        url: "get-data.php",
        data: dataString,
        success: function(result){ /* GET THE TO BE RETURNED DATA */
            $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
        }
        });

    });
    $("#qSealNumber").change(function() {
        var qSealNumber = $(this).val()
        $(".loadingData").html('<div class="progress"><div class="indeterminate"></div></div> Fetching ');
        $.ajax({
            url: "app/pf/bundle-confirmation.php",
            method: "POST",
            data: { loadBag: 1, qSealNumber: qSealNumber},
            success: function(data) {
                $(".loadingData").html('')
                $("#loadBag").html(data)
            }
        })
    })

    // Start Bundle Confirmatio
    $(".startBundleConfirmation").click(function(event) {
        event.preventDefault()
        var clientName = $("#clientName").val()
        var conslocation = $("#conslocation").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        $.ajax({
            url: "app/pf/bundle-confirmation.php",
            method: "POST",
            data: { startBundleConfirmation: 1, clientName: clientName, conslocation: conslocation, username: username, usertoken: usertoken},
            success: function(data) {
                if (data == "bcstarted") {
                    Materialize.toast('Bundle Confirmation Successfully Started', 3000, 'rounded')
                    window.setTimeout(function() {
                        location.reload()
                    }, 2000)
                } else {
                    console.log(data)
                    Materialize.toast('Transaction Failed: ' + data, 3000, 'rounded')
                }
            }
        })
    })

    // Add Bag
    $(".addThisBag").click(function(event) {
        event.preventDefault()
        var clientId = $("#clientId").val()
        var bcsId = $("#bcsId").val()
        var clientBranchName = $("#clientBranchName").val()
        var depostType = $("#depostType").val()
        var cashCategory = $("#cashCategory").val()
        var currency = $("#currency").val()
        var denomination = $("#denomination").val()
        var sealNumber = $("#sealNumber").val()
        var totalAmount = $("#totalAmount").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (clientBranchName == '' || sealNumber == '' || depostType == '' || totalAmount == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".addThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Adding Bag');
            $(".addThisBag").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { addThisBag: 1, bcsId: bcsId, clientId: clientId, depostType: depostType, cashCategory: cashCategory, currency: currency, denomination: denomination, clientBranchName: clientBranchName, totalAmount: totalAmount, sealNumber: sealNumber, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".addThisBag").html('<i class="material-icons left">save</i> Add Bag ')
                    $(".addThisBag").removeAttr('disabled')
                    if (data == "bagAdded") {
                        Materialize.toast('Bag Addition Successful', 2000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Bag Addition Failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from button and pass to modal
    $(".editBag").click(function(event){
        event.preventDefault();
        var bagId = $(this).data('id');
        var bcsId = $(this).data('bcsid');
        var sealNumber = $(this).data('sealnumber')
        var amount = $(this).data('amount')

        var branchId = $(this).data('branchid')
        var branchName = $(this).data('branchname')

        var currencyId = $(this).data('currency')
        var currencyName = $(this).data('currencyname')

        var denominationId = $(this).data('denomination')
        var denominationName = $(this).data('denominationname')

        var depositTypeId = $(this).data('deposittypeid')
        var depositTypeName = $(this).data('deposittypename')

        var depositCategoryId = $(this).data('categorytypeid')
        var depositCategoryName = $(this).data('categorytypename')

        $(".modal-body #bagId").val( bagId )
        $(".modal-body #bcsId").val( bcsId )
        $(".modal-body #sealNumber").val( sealNumber )
        $(".modal-body #totalAmount").val( amount )

        $(".modal-body #branchId").val( branchId )
        $(".modal-body #branchName").html( branchName )

        $(".modal-body #currencyId").val( currencyId )
        $(".modal-body #currencyName").html( currencyName )

        $(".modal-body #denominationName").html( denominationName )
        $(".modal-body #denominationId").val( denominationId )

        $(".modal-body #depositTypeId").val( depositTypeId )
        $(".modal-body #depositTypeName").html( depositTypeName )

        $(".modal-body #depositCategoryName").html( depositCategoryName )
        $(".modal-body #depositCategoryId").val( depositCategoryId )
    })

    // Update Input Value On Change
    $("#clientBranchName").change(function() {
        $('#branchId').val($('option:selected', this).val())
    })
    $("#depostType").change(function() {
        $('#depositTypeId').val($('option:selected', this).val())
    })
    $("#cashCategory").change(function() {
        $('#depositCategoryId').val($('option:selected', this).val())
    })
    $("#currency").change(function() {
        $('#currencyId').val($('option:selected', this).val())
    })
    $("#denomination").change(function() {
        $('#denominationId').val($('option:selected', this).val())
    })

    // Update Bag
    $(".updateThisBag").click(function(event) {
        event.preventDefault()
        var bagId = $("#bagId").val()
        var clientId = $("#clientId").val()
        var clientBranchName = $("#branchId").val()
        var depostType = $("#depositTypeId").val()
        var cashCategory = $("#depositCategoryId").val()
        var currency = $("#currencyId").val()
        var denomination = $("#denominationId").val()
        var sealNumber = $("#sealNumber").val()
        var totalAmount = $("#totalAmount").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (clientBranchName == '' || sealNumber == '' || depostType == '' || totalAmount == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".updateThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Adding Bag');
            $(".updateThisBag").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { updateThisBag: 1, bagId: bagId, clientId: clientId, depostType: depostType, cashCategory: cashCategory, currency: currency, denomination: denomination, clientBranchName: clientBranchName, totalAmount: totalAmount, sealNumber: sealNumber, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".updateThisBag").html('<i class="material-icons left">save</i> Add Bag ')
                    $(".updateThisBag").removeAttr('disabled')
                    if (data == "bagUpdated") {
                        Materialize.toast('Bag Update Successful', 2000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Bag Update Failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from button and pass to modal
    $(".deleteBag").click(function(event){
        event.preventDefault();
        var bagId = $(this).data('id')
        var bcsId = $(this).data('bcsid')

        $(".modal-body #dbagId").val( bagId )
        $(".modal-body #dbcsId").val( bcsId )
    })

    // Update Bag
    $(".deleteThisBag").click(function(event) {
        event.preventDefault()
        var bagId = $("#bagId").val()
        var clientId = $("#clientId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (bagId == '' || clientId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteThisBag").html('<div class="progress"><div class="indeterminate"></div></div> Deleting Bag');
            $(".deleteThisBag").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { deleteThisBag: 1, bagId: bagId, clientId: clientId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".deleteThisBag").html('<i class="material-icons left">delete</i> Yes Delete Bag ')
                    $(".deleteThisBag").removeAttr('disabled')
                    if (data == "bagDeleted") {
                        Materialize.toast('Bag Deleted', 2000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        console.log(data)
                        Materialize.toast('Bag Failed To Delete: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

})