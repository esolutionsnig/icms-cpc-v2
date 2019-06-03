jQuery(document).ready(function($) {

    var dName = ""
    var dSlug = ""
    var udName = ""
    var udSlug = ""

    $("#dName").keyup(function() {
        dName = $(this).val()
        dSlug = dName.replace(/\s+/g, '-').toLowerCase()
        if (dName == '') {
            Materialize.toast('Denomination  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Denomination
    $(".addBtn").click(function(event) {
        event.preventDefault();
        var dName = $("#dName").val()
        dName = dName.toLowerCase()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the Denomination name', 4000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/denominations.php",
                method: "POST",
                data: { addDenomination: 1, dName: dName, dSlug:dSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "ok200") {
                        $(".dName").val('')
                        Materialize.toast('New denomination '+dName+' type successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='denominations'
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
        var dId = $(this).data('id');
        var dsName = $(this).data('name');
        var dsSlug = $(this).data('slug');
        $(".modal-body #ud-id").val( dId );
        $(".modal-body #ud-name").val( dsName );
        $(".modal-header #udname").html( dsName );
        $(".modal-body #ud-slug").val( dsSlug );
    })

    $("#ud-nam").keyup(function() {
        udName = $(this).val()
        udSlug = udName.replace(/\s+/g, '-').toLowerCase()
        if (udName == '') {
            Materialize.toast('Denomination  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Denomination
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var udName = $("#ud-name").val()
        udName = udName.toLowerCase()
        var udSlug = udName.replace(/\s+/g, '-').toLowerCase()
        var dId = $("#ud-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (udName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter the Denomination name', 4000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/denominations.php",
                method: "POST",
                data: { updateDenomination: 1, udName: udName, udSlug:udSlug, dId:dId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "okay200") {
                        $(".dName").val('')
                        Materialize.toast('Denomination '+udName+' type successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='denominations'
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
        var dId = $(this).data('id');
        var dsName = $(this).data('name');
        $(".modal-body #dd-id").val( dId );
        $(".modal-body #dd-name").html( dsName );
        $(".modal-header #ddname").html( dsName );
    })

    // Update Denomination
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var ddId = $("#dd-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ddId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/denominations.php",
                method: "POST",
                data: { deleteDenomination: 1, ddId:ddId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "200") {
                        $(".dName").val('')
                        Materialize.toast('Denomination successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='denominations'
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