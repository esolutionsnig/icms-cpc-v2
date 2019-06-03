jQuery(document).ready(function($) {

    var clName = ""
    var clSlug = ""
    var uclName = ""
    var uclSlug = ""

    $("#clName").keyup(function() {
        clName = $(this).val()
        clSlug = clName.replace(/\s+/g, '-').toLowerCase()
        if (clName == '') {
            Materialize.toast('Consignment Location  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Vehicle
    $(".addBtn").click(function(event) {
        event.preventDefault()
        clName = $("#clName").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (clName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly fill all fields', 3000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/consignment-locations.php",
                method: "POST",
                data: { addConsignmentLocation: 1, clName: clName, clSlug:clSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "cladded") {
                        $(".clName").val('')
                        Materialize.toast('New Consignment Location ('+clName+') successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='consignment-locations'
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
        event.preventDefault()
        var clId = $(this).data('id')
        var clsName = $(this).data('name')
        var clsSlug = $(this).data('slug')
        $(".modal-body #ucl-id").val( clId )
        $(".modal-body #ucl-name").val( clsName )
        $(".modal-header #uclname").html( clsName )
        $(".modal-body #ucl-slug").val( clsSlug )
    })

    $("#ucl-name").keyup(function() {
        uclName = $(this).val()
        uclSlug = uclName.replace(/\s+/g, '-').toLowerCase()
        if (uclName == '') {
            Materialize.toast('Consignment Location  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Vehicle
    $(".updateBtn").click(function(event) {
        event.preventDefault()
        var uclName = $("#ucl-name").val()
        var uclSlug = uclName.replace(/\s+/g, '-').toLowerCase()
        var clId = $("#ucl-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (uclName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly fill all fields', 5000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/consignment-locations.php",
                method: "POST",
                data: { updateConsignmentLocation: 1, uclName: uclName, uclSlug:uclSlug, clId:clId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "clupdated") {
                        $(".uclName").val('')
                        Materialize.toast('Consignment Location ('+uclName+') successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='consignment-locations'
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
        event.preventDefault()
        var clId = $(this).data('id')
        var clsName = $(this).data('name')
        $(".modal-body #dcl-id").val( clId )
        $(".modal-body #dcl-name").html( clsName )
        $(".modal-header #dclname").html( clsName )
    })

    // Update Vehicle
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var dclId = $("#dcl-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dclId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded')
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/consignment-locations.php",
                method: "POST",
                data: { deleteConsignmentLocation: 1, dclId:dclId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "cldeleted") {
                        Materialize.toast('Consignment location successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='consignment-locations'
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