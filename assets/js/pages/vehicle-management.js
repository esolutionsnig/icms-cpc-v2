jQuery(document).ready(function($) {

    var vName = ""
    var vSlug = ""
    var uvName = ""
    var uvNumber = ""
    var uvSlug = ""

    $("#vNumber").keyup(function() {
        vNumber = $(this).val()
        vSlug = vNumber.replace(/\s+/g, '-').toLowerCase()
        if (vNumber == '') {
            Materialize.toast('Vehicle  Number Is Required', 3000, 'rounded')
        }
    })

    $("#vName").keyup(function() {
        vName = $(this).val()
        vSlug = vName.replace(/\s+/g, '-').toLowerCase()
        if (vName == '') {
            Materialize.toast('Vehicle  Name Is Required', 3000, 'rounded')
        }
    })

    // Add Vehicle
    $(".addBtn").click(function(event) {
        event.preventDefault();
        vNumber = $("#vNumber").val()
        vName = $("#vName").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (vNumber == '' || vName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly fill all fields', 5000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/vehicle-management.php",
                method: "POST",
                data: { addVehicle: 1, vNumber:vNumber, vName: vName, vSlug:vSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "vadded") {
                        $(".vName").val('')
                        Materialize.toast('New Vehicle ('+vName+') successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='vehicle-management'
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
        var vId = $(this).data('id')
        var vsNumber = $(this).data('number')
        var vsName = $(this).data('name')
        var vsSlug = $(this).data('slug')
        $(".modal-body #uv-id").val( vId )
        $(".modal-body #uv-number").val( vsNumber )
        $(".modal-body #uv-name").val( vsName )
        $(".modal-header #uvname").html( vsName )
        $(".modal-body #uv-slug").val( vsSlug )
    })

    $("#uv-number").keyup(function() {
        uvNumber = $(this).val()
        if (uvNumber == '') {
            Materialize.toast('Vehicle  Number Is Required', 3000, 'rounded')
        }
    })

    $("#uv-name").keyup(function() {
        uvName = $(this).val()
        uvSlug = uvName.replace(/\s+/g, '-').toLowerCase()
        if (uvName == '') {
            Materialize.toast('Vehicle  Name Is Required', 3000, 'rounded')
        }
    })

    // Update Vehicle
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var uvNumber = $("#uv-number").val()
        var uvName = $("#uv-name").val()
        var uvSlug = uvName.replace(/\s+/g, '-').toLowerCase()
        var vId = $("#uv-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (uvNumber == '' || uvName == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly fill all fields', 5000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/vehicle-management.php",
                method: "POST",
                data: { updateVehicle: 1, uvNumber:uvNumber, uvName: uvName, uvSlug:uvSlug,vId:vId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "vupdated") {
                        $(".uvName").val('')
                        Materialize.toast('Vehicle ('+uvName+') successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='vehicle-management'
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
        var vId = $(this).data('id');
        var vsName = $(this).data('name');
        $(".modal-body #dv-id").val( vId );
        $(".modal-body #dv-name").html( vsName );
        $(".modal-header #dvname").html( vsName );
    })

    // Update Vehicle
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var dvId = $("#dv-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dvId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/vehicle-management.php",
                method: "POST",
                data: { deleteVehicle: 1, dvId:dvId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "vdeleted") {
                        $(".VName").val('')
                        Materialize.toast('Vehicle successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='vehicle-management'
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