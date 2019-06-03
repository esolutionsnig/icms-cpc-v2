jQuery(document).ready(function($) {

    $(".iSelected").change(function(){
        var searchIDs = $("#caTable input:checkbox:checked").map(function(){
            return $(this).val()
        }).get()
        // console.log(searchIDs)
        $("#totalSelected").html(searchIDs.length)
    })

    // Move Consignment
    $(".confirmSelectedBags").click(function(event) {
        event.preventDefault()
        var selectedSealNumbers = $("#caTable input:checkbox:checked").map(function(){
            return $(this).val()
        }).get()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (selectedSealNumbers == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded')
        } else {
            $(".confirmSelectedBags").html('<div class="progress"><div class="indeterminate"></div></div> Moving')
            $(".confirmSelectedBags").attr('disabled', 'disabled')
            $.ajax({
                url: "app/pf/boxroom.php",
                method: "POST",
                data: { confirmSelectedBags: 1, selectedSealNumbers: selectedSealNumbers, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".confirmSelectedBags").html('<i class="material-icons left">done_all</i> Yes I Have The Consignment ')
                    $(".confirmSelectedBags").removeAttr('disabled')
                    if (data == "") {
                        Materialize.toast('Confirmation Completed', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    } else {
                        console.log(data)
                        Materialize.toast('Movement Failed', 1000, 'rounded')
                    }
                }
            })
        }
    })

})