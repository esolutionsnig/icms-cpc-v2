jQuery(document).ready(function($) {

    var ctName = ""
    var ctSlug = ""
    var uctName = ""
    var uctSlug = ""

    $("#ctName").keyup(function() {
        ctName = $(this).val()
        ctSlug = ctName.replace(/\s+/g, '-').toLowerCase()
        if (ctName == '') {
            Materialize.toast('Container Type  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Container Type
    $(".addBtn").click(function(event) {
        event.preventDefault();
        var ctName = $("#ctName").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ctName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the Container type name', 4000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/container-types.php",
                method: "POST",
                data: { addContainerType: 1, ctName: ctName, ctSlug:ctSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "ok200") {
                        $(".ctName").val('')
                        Materialize.toast('New container '+ctName+' type successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='container-types'
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
        var ctId = $(this).data('id');
        var ctsName = $(this).data('name');
        var ctsSlug = $(this).data('slug');
        $(".modal-body #uct-id").val( ctId );
        $(".modal-body #uct-name").val( ctsName );
        $(".modal-header #uctname").html( ctsName );
        $(".modal-body #uct-slug").val( ctsSlug );
    })

    $("#uct-nam").keyup(function() {
        uctName = $(this).val()
        uctSlug = uctName.replace(/\s+/g, '-').toLowerCase()
        if (uctName == '') {
            Materialize.toast('Container Type  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Container Type
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var uctName = $("#uct-name").val()
        var uctSlug = uctName.replace(/\s+/g, '-').toLowerCase()
        var ctId = $("#uct-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (uctName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the Container type name', 4000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/container-types.php",
                method: "POST",
                data: { updateContainerType: 1, uctName: uctName, uctSlug:uctSlug,ctId:ctId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "okay200") {
                        $(".ctName").val('')
                        Materialize.toast('New container '+uctName+' type successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='container-types'
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
        var ctId = $(this).data('id');
        var ctsName = $(this).data('name');
        $(".modal-body #dct-id").val( ctId );
        $(".modal-body #dct-name").html( ctsName );
        $(".modal-header #dctname").html( ctsName );
    })

    // Update Container Type
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var dctId = $("#dct-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dctId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/container-types.php",
                method: "POST",
                data: { deleteContainerType: 1, dctId:dctId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "200") {
                        $(".ctName").val('')
                        Materialize.toast('Container type successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='container-types'
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