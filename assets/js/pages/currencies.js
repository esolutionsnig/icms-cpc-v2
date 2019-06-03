jQuery(document).ready(function($) {

    var cName = ""
    var cSlug = ""
    var ucName = ""
    var ucSlug = ""

    $("#cName").keyup(function() {
        cName = $(this).val()
        cSlug = cName.replace(/\s+/g, '-').toLowerCase()
        if (cName == '') {
            Materialize.toast('Currency  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Currency
    $(".addBtn").click(function(event) {
        event.preventDefault();
        var cName = $("#cName").val()
        // cName = cName.toLowerCase()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (cName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the Currency name', 4000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/currencies.php",
                method: "POST",
                data: { addCurrency: 1, cName: cName, cSlug:cSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "ok200") {
                        $(".cName").val('')
                        Materialize.toast('New Currency '+cName+' type successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='currencies'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from butoon and pass to bs-modal
    $(".updateRecord").click(function(event){
        event.preventDefault();
        var cId = $(this).data('id');
        var csName = $(this).data('name');
        var csSlug = $(this).data('slug');
        $(".modal-body #uc-id").val( cId );
        $(".modal-body #uc-name").val( csName );
        $(".modal-header #ucname").html( csName );
        $(".modal-body #uc-slug").val( csSlug );
    })

    $("#uc-nam").keyup(function() {
        ucName = $(this).val()
        ucSlug = ucName.replace(/\s+/g, '-').toLowerCase()
        if (ucName == '') {
            Materialize.toast('Currency  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Currency
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var ucName = $("#uc-name").val()
        // ucName = ucName.toLowerCase()
        var ucSlug = ucName.replace(/\s+/g, '-').toLowerCase()
        var cId = $("#uc-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ucName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the Currency name', 4000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/currencies.php",
                method: "POST",
                data: { updateCurrency: 1, ucName: ucName, ucSlug:ucSlug, cId:cId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "okay200") {
                        $(".cName").val('')
                        Materialize.toast('Currency '+ucName+' type successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='currencies'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from butoon and pass to modal
    $(".deleteRecord").click(function(event){
        event.preventDefault();
        var cId = $(this).data('id');
        var csName = $(this).data('name');
        $(".modal-body #dc-id").val( cId );
        $(".modal-body #dc-name").html( csName );
        $(".modal-header #dcname").html( csName );
    })

    // Update Currency
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var dcId = $("#dc-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dcId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/currencies.php",
                method: "POST",
                data: { deleteCurrency: 1, dcId:dcId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "200") {
                        $(".cName").val('')
                        Materialize.toast('New Currency successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='currencies'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

})