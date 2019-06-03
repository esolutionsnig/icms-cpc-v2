jQuery(document).ready(function($) {

    //Fetch data from button and pass to modal
    $(".triggerBtn").click(function(event){
        event.preventDefault();
        var exid = $(this).data('exid');
        $(".modal-body #exId").val( exid );
    })

    // Resolve Exception
    $(".resolveThisException").click(function(event) {
        event.preventDefault()
        var exId = $("#exId").val()
        var reviewedComment = $("#reviewedComment").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (exId == '' || reviewedComment == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 1000, 'rounded');
        } else {
            $(".resolveThisException").html('<div class="progress"><div class="indeterminate"></div></div> Resolving');
            $(".resolveThisException").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { resolveThisException: 1, exId: exId, reviewedComment: reviewedComment, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".resolveThisException").html('<i class="material-icons left">local_pharmacy</i> Resolve ')
                    $(".resolveThisException").removeAttr('disabled')
                    if (data == "done") {
                        Materialize.toast('Exception Resolved', 1000, 'rounded')
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

    // Throw Exception 
    $(".addExceptions").click(function(event) {
        event.preventDefault()
        var exceptionsealnumber = $("#exceptionsealnumber").val()
        var supo = $("#supo").val()
        var currenc = $("#currenc").val()
        var denom = $("#denom").val()
        var expectedAmount = $("#expectedAmount").val()
        var actualAmount = $("#actualAmount").val()
        var thrownComment = $("#thrownComment").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (exceptionsealnumber == '' || supo == '' || denom == '' || currenc == '' || expectedAmount == '' || actualAmount == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded');
        } else {
            $(".addExceptions").html('<div class="progress"><div class="indeterminate"></div></div> Sending Exception');
            $(".addExceptions").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { addException: 1, exceptionsealnumber: exceptionsealnumber, supo: supo, currenc: currenc, denom: denom, expectedAmount: expectedAmount, actualAmount: actualAmount, thrownComment: thrownComment, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".addExceptions").html('<i class="material-icons right">send</i> Send Exception ')
                    $(".addExceptions").removeAttr('disabled')
                    if (data == "done") {
                        Materialize.toast('Exception Sent', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Bag Addition Failed: ' + data, 1500, 'rounded')
                    }
                }
            })
        }
    })

})