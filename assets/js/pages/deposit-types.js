jQuery(document).ready(function($) {

    var dtName = ""
    var dtSlug = ""
    var udtName = ""
    var udtSlug = ""

    $("#dt-Name").keyup(function() {
        dtName = $(this).val()
        dtSlug = dtName.replace(/\s+/g, '-').toLowerCase()
        if (dtName == '') {
            Materialize.toast('Deposit Type  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Deposit Type
    $(".addBtn").click(function(event) {
        event.preventDefault();
        var dtName = $("#dt-Name").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dtName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the deposit type name', 4000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/deposit-types.php",
                method: "POST",
                data: { addDepositType: 1, dtName: dtName, dtSlug:dtSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "ok200") {
                        $(".dtName").val('')
                        Materialize.toast('New deposit '+dtName+' type successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='deposit-types'
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
        var dtId = $(this).data('id');
        var dtsName = $(this).data('name');
        var dtsSlug = $(this).data('slug');
        $(".modal-body #udt-id").val( dtId );
        $(".modal-body #udt-name").val( dtsName );
        $(".modal-header #udtname").html( dtsName );
        $(".modal-body #udt-slug").val( dtsSlug );
    })

    $("#udt-nam").keyup(function() {
        udtName = $(this).val()
        udtSlug = udtName.replace(/\s+/g, '-').toLowerCase()
        if (udtName == '') {
            Materialize.toast('Deposit Type  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Deposit Type
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var udtName = $("#udt-name").val()
        var udtSlug = udtName.replace(/\s+/g, '-').toLowerCase()
        var dtId = $("#udt-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (udtName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the deposit type name', 4000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/deposit-types.php",
                method: "POST",
                data: { updateDepositType: 1, udtName: udtName, udtSlug:udtSlug,dtId:dtId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "okay200") {
                        $(".dtName").val('')
                        Materialize.toast('New deposit '+udtName+' type successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='deposit-types'
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
        var dtId = $(this).data('id');
        var dtsName = $(this).data('name');
        $(".modal-body #ddt-id").val( dtId );
        $(".modal-body #ddt-name").html( dtsName );
        $(".modal-header #ddtname").html( dtsName );
    })

    // Update Deposit Type
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var ddtId = $("#ddt-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ddtId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/deposit-types.php",
                method: "POST",
                data: { deleteDepositType: 1, ddtId:ddtId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "200") {
                        $(".dtName").val('')
                        Materialize.toast('Deposit type successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='deposit-types'
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