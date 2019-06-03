jQuery(document).ready(function($) {

    $(".evacuationSchedule").click(function(event) {
        event.preventDefault()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        var queryDate = $("#queryDate").val()
        var queryClients = $("#queryClients").val()
        var queryStatus = $("#queryStatus").val()
        var consignmentLocation = $("#consignmentLocation").val()
        $(".evacuationSchedule").html('<div class="progress"><div class="indeterminate"></div></div> Sending Request');
        $(".evacuationSchedule").attr('disabled', 'disabled');
        $.ajax({
            url: "app/pf/evacuation-schedule.php",
            method: "POST",
            data: { searchES: 1, queryDate: queryDate, queryClients:queryClients, queryStatus:queryStatus, username: username, usertoken: usertoken },
            success: function(data) {
                $(".evacuationSchedule").html('<i class="material-icons left">search</i> Search  ')
                $(".evacuationSchedule").removeAttr('disabled')
                $(".searchResult").html(data)
            }
        })
    })

    // $('.datepicker').datepicker( format = 'mmm dd, yyyy')

})