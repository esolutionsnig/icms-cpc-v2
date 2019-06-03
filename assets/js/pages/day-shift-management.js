jQuery(document).ready(function($) {

    // Start New Day
    $(".startNewDay").click(function(event) {
        event.preventDefault()
        var dayStartTitle = $('#dayStartTitle').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dayStartTitle == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request, All Fields Are Required', 1000, 'rounded');
        } else {
            $(".startNewDay").html('<div class="progress"><div class="indeterminate"></div></div> Starting');
            $(".startNewDay").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/day-shift-management.php",
                method: "POST",
                data: { startNewDay: 1, dayStartTitle: dayStartTitle, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".startNewDay").html('<i class="material-icons right">send</i> Start New Day ')
                    $(".startNewDay").removeAttr('disabled')
                    if (data == "daystarted") {
                        Materialize.toast('Day Successfully Started', 1200, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })
    
    //Fetch data from button and pass to input
    $(".closeDayBtn").click(function(event){
        event.preventDefault()
        var dsId = $(this).data('id')
        $(".modal-body #dsId").val( dsId )
    })

    // Close Day
    $(".closeThisDayBtn").click(function(event) {
        event.preventDefault()
        var dsId = $('#dsId').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dsId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request, All Fields Are Required', 1000, 'rounded');
        } else {
            $(".closeThisDayBtn").html('<div class="progress"><div class="indeterminate"></div></div> Closing');
            $(".closeThisDayBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/day-shift-management.php",
                method: "POST",
                data: { closeThisDayBtn: 1, dsId: dsId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".closeThisDayBtn").html('<i class="material-icons right">send</i> Close This Day ')
                    $(".closeThisDayBtn").removeAttr('disabled')
                    if (data == "dayclosed") {
                        Materialize.toast('Day Successfully Closed', 1200, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })
    
    //Fetch data from button and pass to input
    $(".openDayBtn").click(function(event){
        event.preventDefault()
        var dsId = $(this).data('id')
        $(".modal-body #dsId").val( dsId )
    })

    // Open Day
    $(".restoreThisDayBtn").click(function(event) {
        event.preventDefault()
        var dsId = $('#dsId').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dsId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request, All Fields Are Required', 1000, 'rounded');
        } else {
            $(".restoreThisDayBtn").html('<div class="progress"><div class="indeterminate"></div></div> Restoring ');
            $(".restoreThisDayBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/day-shift-management.php",
                method: "POST",
                data: { restoreThisDayBtn: 1, dsId: dsId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".restoreThisDayBtn").html('<i class="material-icons right">send</i> Yes Restore This Day ')
                    $(".restoreThisDayBtn").removeAttr('disabled')
                    if (data == "dayrestored") {
                        Materialize.toast('Day Successfully Restored', 1200, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })

    // Start New Shift
    $(".startNewShift").click(function(event) {
        event.preventDefault()
        var dayId = $('#dayId').val()
        var shiftStartTitle = $('#shiftStartTitle').val()
        var sshift = $('#sshift').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dayId == '' || shiftStartTitle == '' || sshift == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request, All Fields Are Required', 1000, 'rounded');
        } else {
            $(".startNewShift").html('<div class="progress"><div class="indeterminate"></div></div> Starting');
            $(".startNewShift").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/day-shift-management.php",
                method: "POST",
                data: { startNewShift: 1, dayId: dayId, shiftStartTitle: shiftStartTitle, sshift: sshift, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".startNewShift").html('<i class="material-icons right">send</i> Start New Shift ')
                    $(".startNewShift").removeAttr('disabled')
                    if (data == "shiftstarted") {
                        Materialize.toast('Shift Successfully Started', 1200, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })
    
    //Fetch data from button and pass to input
    $(".closeShiftBtn").click(function(event){
        event.preventDefault()
        var ssId = $(this).data('id')
        $(".modal-body #ssId").val( ssId )
    })

    // Close Shift
    $(".closeThisShiftBtn").click(function(event) {
        event.preventDefault()
        var ssId = $('#ssId').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ssId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request, All Fields Are Required', 1000, 'rounded');
        } else {
            $(".closeThisShiftBtn").html('<div class="progress"><div class="indeterminate"></div></div> Closing');
            $(".closeThisShiftBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/day-shift-management.php",
                method: "POST",
                data: { closeThisShiftBtn: 1, ssId: ssId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".closeThisShiftBtn").html('<i class="material-icons right">send</i> Close This Shift ')
                    $(".closeThisShiftBtn").removeAttr('disabled')
                    if (data == "shiftclosed") {
                        Materialize.toast('Shift Successfully Closed', 1200, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })
    
    //Fetch data from button and pass to input
    $(".openShiftBtn").click(function(event){
        event.preventDefault()
        var ssId = $(this).data('id')
        $(".modal-body #ssId").val( ssId )
    })

    // Open Shift
    $(".restoreThisShiftBtn").click(function(event) {
        event.preventDefault()
        var ssId = $('#ssId').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ssId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 1000, 'rounded');
        } else {
            $(".restoreThisShiftBtn").html('<div class="progress"><div class="indeterminate"></div></div> Restoring ');
            $(".restoreThisShiftBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/day-shift-management.php",
                method: "POST",
                data: { restoreThisShiftBtn: 1, ssId: ssId, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".restoreThisShiftBtn").html('<i class="material-icons right">send</i> Yes Restore This Day ')
                    $(".restoreThisShiftBtn").removeAttr('disabled')
                    if (data == "shiftrestored") {
                        Materialize.toast('Shift Successfully Restored', 1200, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Failed: ' + data, 1000, 'rounded')
                    }
                }
            })
        }
    })

})