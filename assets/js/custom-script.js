/*================================================================================
	Version: 4.2
	Author: ERNEST ibeh
	Author Mobile: +234(0)8020689069
================================================================================  */

// Log Out After Some time
setLogoutTimer();
function setLogoutTimer() {
    var myTimeout;
    if (window.sessionStorage) {
        myTimeout = sessionStorage.timeoutVar;
        if (myTimeout) {
            clearTimeout(myTimeout);
        }
    }
    myTimeout = setTimeout(function () {logoutNow(); }, 28800000);  //adjusted the time to 8 Hours. 1 Hour = 3,600,000 milliseconds. 
    if (window.sessionStorage) {
        sessionStorage.timeoutVar = myTimeout;
    }
}

function logoutNow() {
    if (window.sessionStorage) {
        sessionStorage.timeoutVar = null;
    }
    $.ajax({
        url: 'process.php',
        cache: false,
            async:false,
        type: 'POST',
        success: function (msg) {
            location.reload()
        }
    });
}
// End

$('.modal').modal()

var interval = setInterval(function() {
    var momentNow = moment()
    $('#date-part').html(momentNow.format('DD MMMM YYYY') + ' ' +
        momentNow.format('dddd')
        .substring(0, 3).toUpperCase())
    $('#time-part').html(momentNow.format('hh:mm:ss A'))
}, 100)

function sfFunction() {
    var input, filter, ul, li, a, i
    input = document.getElementById("sfInput")
    filter = input.value.toUpperCase()
    ul = document.getElementById("sfUL")
    li = ul.getElementsByTagName("li")
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0]
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = ""
        } else {
            li[i].style.display = "none"
        }
    }
}

function bfFunction() {
    var input, filter, ul, li, a, i
    input = document.getElementById("bfInput")
    filter = input.value.toUpperCase()
    ul = document.getElementById("bfUL")
    li = ul.getElementsByTagName("li")
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0]
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = ""
        } else {
            li[i].style.display = "none"
        }
    }
}

function ufFunction() {
    var input, filter, ul, li, a, i
    input = document.getElementById("ufInput")
    filter = input.value.toUpperCase()
    ul = document.getElementById("ufUL")
    li = ul.getElementsByTagName("li")
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0]
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = ""
        } else {
            li[i].style.display = "none"
        }
    }
}

// Number Format
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

// Only Input Number
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Preannouncement SN
$(".addPreannouncementBtn").click(function(event) {
    event.preventDefault()
    var username = $("#username").val()
    var usertoken = $("#usertoken").val()
    var containerType = $("#containerType").val()
    var sealNumber = $("#genSealNumber").val()
    var depositType = $("#depositType").val()
    var categoryType = $("#categoryType").val()

    if (username == '' || usertoken == '' || containerType == '' || sealNumber == '' || depositType == '' || categoryType == '') {
        Materialize.toast('Request Denied: Kindly Fill All Fields To Proceed', 1500, 'rounded');
    } else {
        $(".addPreannouncementBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving...');
        $(".addPreannouncementBtn").attr('disabled', 'disabled');
        $.ajax({
            url: "app/pf/preannouncement.php",
            method: "POST",
            data: { addPreannouncementSN: 1, sealNumber: sealNumber, depositType: depositType, categoryType: categoryType, containerType: containerType, username: username, usertoken: usertoken },
            success: function(data) {
                $(".addPreannouncementBtn").html('<i class="material-icons right">save</i> Save &amp; Continue ')
                $(".addPreannouncementBtn").removeAttr('disabled')
                if (data == "savedsaved") {
                    Materialize.toast('Preannouncement Saved', 1000, 'rounded')
                    window.setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else {
                    $(".addPreannouncementBtn").removeAttr('disabled')
                    console.log(data)
                    Materialize.toast('Failed To Save', 1000, 'rounded')
                }
            }
        })
    }
})

jQuery(document).ready(function($) {

    // Add another Bag
    $(".savePreannouncement").click(function(event){
        event.preventDefault()
        location.reload();
    })

    //Fetch data from button and pass to modal
    $(".teBtn").click(function(event){
        event.preventDefault(event);
        var exceptionsealnumber = $(this).data('id');
        $(".modal-body #exceptionsealnumber").val( exceptionsealnumber );
    });

    // Dynamically Add Exception Rows
    // var i = 1  
    // $('#addExcepRow').click(function(){  
    //     i++  
    //     $('#dynamic_field').append('<div id="removRow'+i+'" style="margin: 20px 0; border-bottom: 1px solid #efefef"><div class="row"><div class="input-field col l5 m5 s12"><input id="expectedAmount[]" type="text" class="validate"><label for="expectedAmount">Expected Amount </label></div><div class="input-field col l5 m5 s12"><input id="actualAmount[]" type="text" class="validate"><label for="actualAmount">Actual Amount</label></div><div class="input-field col l2 m2 s12"><button id="'+i+'" class="btns btns-delete waves-effect waves-light red white-text btn_remove"><i class="material-icons left">remove</i> Remove </button></div></div></div>')  
    // })
    // $(document).on('click', '.btn_remove', function(){  
    //     var button_id = $(this).attr("id")   
    //     $('#removRow'+button_id+'').remove()  
    // })

    $("#expectedAmount").keyup(function() {
        var expectedAmount = $(this).val();
        $("#showExpectedAmount").html(addCommas(expectedAmount));
    });

    $("#actualAmount").keyup(function() {
        var actualAmount = $(this).val();
        $("#showActualAmount").html(addCommas(actualAmount));
    });

    // Throw Exception 
    $(".addException").click(function(event) {
        event.preventDefault();
        var exceptionsealnumber = $("#exceptionsealnumber").val();
        var supo = $("#supo").val();
        var currenc = $("#currenc").val();
        var denom = $("#denom").val();
        var expectedAmount = $("#expectedAmount").val();
        var actualAmount = $("#actualAmount").val();
        var thrownComment = $("#thrownComment").val();
        var username = $("#username").val();
        var usertoken = $("#usertoken").val();
        if (exceptionsealnumber == '' || supo == '' || denom == '' || currenc == '' || expectedAmount == '' || actualAmount == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded');
        } else {
            $(".addException").html('<div class="progress"><div class="indeterminate"></div></div> Sending Exception');
            $(".addException").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/bundle-confirmation.php",
                method: "POST",
                data: { addException: 1, exceptionsealnumber: exceptionsealnumber, supo: supo, currenc: currenc, denom: denom, expectedAmount: expectedAmount, actualAmount: actualAmount, thrownComment: thrownComment, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".addException").html('<i class="material-icons right">send</i> Send Exception ');
                    $(".addException").removeAttr('disabled');
                    if (data == "done") {
                        Materialize.toast('Exception Sent', 1000, 'rounded');
                        window.setTimeout(function() {
                            $("#expectedAmount").val('');
                            $("#actualAmount").val('');
                            $("#thrownComment").val('');
                            // $('#throwExc').modal('close')
                            location.reload();
                        }, 1000);
                    } else {
                        console.log(data);
                        Materialize.toast('Bag Addition Failed: ' + data, 1500, 'rounded');
                    }
                }
            });
        }
    });

    // Sealing
    $("#cAmount").keyup(function() {
        var cAmount = $(this).val();
        $("#showCAmount").html(addCommas(cAmount));
    });

    // Set Shift And Sign In Location
    $(".setShiftLocation").click(function(event) {
        event.preventDefault();
        var yourShift = $("#yourShift").val();
        var signInAs = $("#signInAs").val();
        var username = $("#username").val();
        var usertoken = $("#usertoken").val();
        if (signInAs == '' || yourShift == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 2000, 'rounded');
        } else {
            $(".setShiftLocation").html('<div class="progress"><div class="indeterminate"></div></div> Processing');
            $(".setShiftLocation").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/dashboard.php",
                method: "POST",
                data: { setShiftLocation: 1, yourShift: yourShift, signInAs: signInAs, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".setShiftLocation").html('<i class="material-icons right">input</i> Set Shift &amp; Location ');
                    $(".setShiftLocation").removeAttr('disabled');
                    if (data == "DoneSet") {
                        Materialize.toast('Shift &amp; Location Successfully Set', 1500, 'rounded');
                        window.setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        console.log(data);
                        Materialize.toast('Failed: ' + data, 1500, 'rounded');
                    }
                }
            });
        }
    });
});