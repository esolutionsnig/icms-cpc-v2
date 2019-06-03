jQuery(document).ready(function($) {

    var dcName = ""
    var dcSlug = ""
    var udcName = ""
    var udcSlug = ""

    $("#dcName").keyup(function() {
        dcName = $(this).val()
        dcSlug = dcName.replace(/\s+/g, '-').toLowerCase()
        if (dcName == '') {
            Materialize.toast('Deposit Category  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Deposit Category
    $(".addBtn").click(function(event) {
        event.preventDefault();
        var dcName = $("#dcName").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dcName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the deposit category name', 5000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/deposit-categories.php",
                method: "POST",
                data: { addDepositCategory: 1, dcName: dcName, dcSlug:dcSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "dcadded") {
                        $(".dcName").val('')
                        Materialize.toast('New deposit category '+dcName+' successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='deposit-categories'
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
        var dcId = $(this).data('id');
        var dcsName = $(this).data('name');
        var dcsSlug = $(this).data('slug');
        $(".modal-body #udc-id").val( dcId );
        $(".modal-body #udc-name").val( dcsName );
        $(".modal-header #udcname").html( dcsName );
        $(".modal-body #udc-slug").val( dcsSlug );
    })

    $("#udc-nam").keyup(function() {
        udcName = $(this).val()
        udcSlug = udcName.replace(/\s+/g, '-').toLowerCase()
        if (udcName == '') {
            Materialize.toast('Deposit Category  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Deposit Category
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var udcName = $("#udc-name").val()
        var udcSlug = udcName.replace(/\s+/g, '-').toLowerCase()
        var dcId = $("#udc-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (udcName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the deposit category name', 5000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/deposit-categories.php",
                method: "POST",
                data: { updateDepositCategory: 1, udcName: udcName, udcSlug:udcSlug,dcId:dcId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "dcupdated") {
                        $(".udcName").val('')
                        Materialize.toast('New deposit category '+dcName+' successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='deposit-categories'
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
        var dcId = $(this).data('id');
        var dcsName = $(this).data('name');
        $(".modal-body #ddc-id").val( dcId );
        $(".modal-body #ddc-name").html( dcsName );
        $(".modal-header #ddcname").html( dcsName );
    })

    // Update Deposit category
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var ddcId = $("#ddc-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ddcId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/deposit-categories.php",
                method: "POST",
                data: { deleteDepositCategory: 1, ddcId:ddcId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "dcdeleted") {
                        Materialize.toast('Deposit category successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='deposit-categories'
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