jQuery(document).ready(function($) {

    //Fetch data from butoon and pass to modal
    $(".changeAccessLevel").click(function(event){
        event.preventDefault()
        var username = $(this).data('id')
        var ufname = $(this).data('ufname')
        $(".modal-body #uusername").val( username )
        $(".modal-body #ufname").html( ufname )
    })

    // Update User Access Level
    $(".updateUserAccessLevel").click(function(event) {
        event.preventDefault()
        var userlevel = $("#userlevel").val()
        var uUsername = $("#uusername").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (userlevel == '' || uUsername == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".updateUserAccessLevel").html('<div class="progress"><div class="indeterminate"></div></div> Saving')
            $(".updateUserAccessLevel").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/user-management.php",
                method: "POST",
                data: { updateUserAccessLevel: 1, userlevel:userlevel, uUsername: uUsername, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateUserAccessLevel").html('<i class="material-icons left">save</i> Save Changes ')
                    $(".updateUserAccessLevel").removeAttr('disabled')
                    if (data == "sm") {
                        Materialize.toast('Changes Saved', 1500, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 2000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Move Multiple At Once
    var getSelectedUsers = '';
    $(".iSelected").change(function(){
        getSelectedUsers = $("#caTable input:checkbox:checked").map(function(){
            return $(this).val()
        }).get()
        console.log(getSelectedUsers)
        $("#totalSelected").html(getSelectedUsers.length)
    })

    // Approve Selected Users
    $(".approveUsers").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (getSelectedUsers == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".approveUsers").html('<div class="progress"><div class="indeterminate"></div></div> Approving')
            $(".approveUsers").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/user-management.php",
                method: "POST",
                data: { approveUsers: 1, getSelectedUsers: getSelectedUsers, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".approveUsers").html('<i class="material-icons left">done_all</i> Approve Selected Users ')
                    $(".approveUsers").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Approval Successful', 2000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 2100)
                    } else {
                        console.log(data)
                        Materialize.toast('Approval Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

    // Suspend Selected Users
    $(".suspendUsers").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (getSelectedUsers == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded')
        } else {
            $(".suspendUsers").html('<div class="progress"><div class="indeterminate"></div></div> Moving')
            $(".suspendUsers").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/user-management.php",
                method: "POST",
                data: { suspendUsers: 1, getSelectedUsers: getSelectedUsers, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".suspendUsers").html('<i class="material-icons left">ban</i> Suspend Selected Users ');
                    $(".suspendUsers").removeAttr('disabled');
                    if (data == "") {
                        Materialize.toast('Suspension Successful', 2000, 'rounded');
                        window.setTimeout(function() {
                            location.reload();
                        }, 2100);
                    } else {
                        console.log(data);
                        Materialize.toast('Movement Failed', 1000, 'rounded');
                    }
                }
            });
        }
    });

});