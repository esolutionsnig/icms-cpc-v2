jQuery(document).ready(function($) {

    $('#username').keyup(function() {
        var Username = $(this).val();
        var UsernameAvailResult = $('#username_avail_result');
        if (Username.length > 4) {
            validateText('username');
            UsernameAvailResult.html('<i class="fa fa-spinner fa-pulse red-text"></i>');
            var UrlToPass = 'action=username_availability&username=' + Username;
            $.ajax({
                type: 'POST',
                url: 'checker.php',
                data: UrlToPass,
                success: function(responseText) {
                    UsernameAvailResult.html(responseText);
                }
            });


        } else {
            UsernameAvailResult.html('<span class="red-text">Enter atleast 5 characters</span>');
        }
        if (Username.length == 0) {
            validateText('username');
            UsernameAvailResult.html('');
        }
    });


    $('#phoneno').keyup(function() {
        var Phoneno = $(this).val();
        var PhonenoAvailResult = $('#phoneno_avail_result');
        if (Phoneno.length > 10) {
            validateTextIsNumber('phoneno');
            PhonenoAvailResult.html('<i class="fa fa-spinner fa-pulse red-text"></i>');
            var UrlToPass = 'action=phoneno_availability&phoneno=' + Phoneno;
            $.ajax({
                type: 'POST',
                url: 'phonenochecker.php',
                data: UrlToPass,
                success: function(responseText) { // Get the result and asign to each cases
                    PhonenoAvailResult.html(responseText);
                }
            });


        } else {
            PhonenoAvailResult.html('<span class="red-text">Invalid Number</span>');
        }
        if (Phoneno.length == 0) {
            validateTextIsNumber('phoneno');
            PhonenoAvailResult.html('');
        }
    });


    $('#email').keyup(function() {
        var Emailadd = $(this).val();
        var EmailaddAvailResult = $('#emailadd_avail_result');
        if (Emailadd.length > 10) {
            validateEmail('email');
            EmailaddAvailResult.html('<i class="fa fa-spinner fa-pulse red-text"></i>');
            var UrlToPass = 'action=emailadd_availability&email=' + Emailadd;
            $.ajax({
                type: 'POST',
                url: 'emailchecker.php',
                data: UrlToPass,
                success: function(responseText) { // Get the result and asign to each cases
                    EmailaddAvailResult.html(responseText);
                }
            });


        } else {
            EmailaddAvailResult.html('<span class="red-text">Enter valid email address</span>');
        }
        if (Emailadd.length == 0) {
            validateEmail('email');
            EmailaddAvailResult.html('');
        }
    });


    $('#password, #username').keydown(function(e) { // Dont allow users to enter spaces for their username and passwords
        if (e.which == 32) {
            return false;
        }
    });
    $('#password').keyup(function() { // As same using keyup function for get user action in input
        var PasswordLength = $(this).val().length; // Get the password input using $(this)
        var PasswordStrength = $('#password_strength'); // Get the id of the password indicator display area

        if (PasswordLength <= 0) { // Check is less than 0
            PasswordStrength.html(''); // Empty the HTML
            PasswordStrength.removeClass('normal weak strong verystrong'); //Remove all the indicator classes
        }
        if (PasswordLength > 0 && PasswordLength < 4) { // If string length less than 4 add 'weak' class
            PasswordStrength.html('W');
            PasswordStrength.removeClass('normal strong verystrong').addClass('weak');
        }
        if (PasswordLength > 4 && PasswordLength < 8) { // If string length greater than 4 and less than 8 add 'normal' class
            PasswordStrength.html('N');
            PasswordStrength.removeClass('weak strong verystrong').addClass('normal');
        }
        if (PasswordLength >= 8 && PasswordLength < 12) { // If string length greater than 8 and less than 12 add 'strong' class
            PasswordStrength.html('S');
            PasswordStrength.removeClass('weak normal verystrong').addClass('strong');
        }
        if (PasswordLength >= 12) { // If string length greater than 12 add 'verystrong' class
            PasswordStrength.html('VS');
            PasswordStrength.removeClass('weak normal strong').addClass('verystrong');
        }
    });



    $('#submitRegister').hide();

    var username = "";
    var phoneno = "";
    var password = "";
    var email = "";
    var surname = "";
    var firstname = "";
    var middlename = "";

    $("#surname").keyup(function() {
        var surname = $(this).val();
    });

    $("#firstname").keyup(function() {
        var firstname = $(this).val();
    });

    $("#middlename").keyup(function() {
        var middlename = $(this).val();
    });


    $("#username").keyup(function() {
        var username = $(this).val();
    });

    $("#phoneno").keyup(function() {
        var vall = $(this).val();
        var x = $(this).val();

        if (vall == "") {
            validateTextIsNumber('phoneno');
            phoneno = "";
        } else {
            validateTextIsNumber('phoneno');
            phoneno = vall;
        }
    });

    $("#password").keyup(function() {
        var password = $(this).val();
    });


    $("#confirmpass").keyup(function() {
        var confirmpass = $(this).val();
        if (confirmpass == "") {
            confirmpass = "";
        } else {
            $("#confirmpass, #password").keyup(checkPasswordMatch);
        }
    });


    $("#email").keyup(function() {
        var email = $(this).val();
        if (email == "") {
            validateEmail('email');
            email = "";
        } else {
            validateEmail('email');
        }
    });


    $("#cap3").keyup(function() {
        var cap3 = $(this).val();
        var sumcap = $("#sumcap").val()
        if (cap3 == "") {
            validateCaptcha('cap3');
            cap3 = "";
        } else {
            validateCaptcha('cap3');
        }
    });



    function validate() {
        if ($('#surname').val().length > 0 &&
            $('#firstname').val().length > 0 &&
            // $('#middlename').val().length > 0 &&
            $('#username').val().length > 0 &&
            $('#phoneno').val().length > 0 &&
            $('#password').val().length > 0 &&
            $('#email').val().length > 0 &&
            $('#cap3').val().length > 0) {
            $('#submitRegister').show();
        } else {
            $('#submitRegister').hide();
        }
    }


    function validateCaptcha(id) {
        if ($("#" + id).val() == '') {
            $("#capfb").html('Answer Is Required');
            return false;
        } else {
            if ($("#" + id).val() == $("#sumcap").val()) {
                $("#capfb").html('');
                validate();
                return true;
            } else {
                var div = $("#" + id).closest("div");
                $("#capfb").html('Wrong Answer');
                return false;
            }

        }

    }


    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#confirmpass").val();

        if (password != confirmPassword)
            $("#passerror").html("<span class='red-text'>Passwords do not match! </span>");
        else
            $("#passerror").html("");
    }


    function validateEmail(id) {
        var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
        if (!email_regex.test($("#" + id).val())) {
            var div = $("#" + id).closest("div");
            div.removeClass("has-success");
            $("#glypcn" + id).remove();
            div.addClass("has-error has-feedback");
            div.append('<span id="glypcn' + id + '" class="fa fa-times form-control-feedback"> </span>');
            return false;
        } else {
            var div = $("#" + id).closest("div");
            div.removeClass("has-error");
            $("#glypcn" + id).remove();
            div.addClass("has-success has-feedback");
            div.append(' ');
            return true;
        }

    }

    function validateTextIsNumber(id) {
        if (isNaN($("#" + id).val())) {
            var div = $("#" + id).closest("div");
            div.removeClass("has-success");
            $("#glypcn" + id).remove();
            div.addClass("has-error has-feedback");
            div.append('<span id="glypcn' + id + '" class="fa fa-times form-control-feedback"> </span>');
            return false;
        } else {
            var div = $("#" + id).closest("div");
            div.removeClass("has-error");
            $("#glypcn" + id).remove();
            div.addClass("has-success has-feedback");
            div.append(' ');
            return true;
        }

    }

    function validateText(id) {
        if ($("#" + id).val() == '') {
            var div = $("#" + id).closest("div");
            div.removeClass("has-success");
            $("#glypcn" + id).remove();
            div.addClass("has-error has-feedback");
            div.append('<span id="glypcn' + id + '" class="fa fa-times form-control-feedback"> </span>');
            return false;
        } else {
            var div = $("#" + id).closest("div");
            div.removeClass("has-error");
            $("#glypcn" + id).remove();
            div.addClass("has-success has-feedback");
            div.append('');
            return true;
        }

    }


    //Insert New Category
    $(".submitRegister").click(function(event) {
        $(".submitRegister").html('<i class="fa fa-spin fa-spinner"></i> Creating Account...');
        event.preventDefault();
        var username = $("#username").val();
        var surname = $("#surname").val();
        var firstname = $("#firstname").val();
        var middlename = $("#middlename").val();
        var phoneno = $("#phoneno").val();
        var password = $("#password").val();
        var confirmpass = $("#confirmpass").val();
        var email = $("#email").val();
        var cap3 = $("#cap3").val();
        var sumcap = $("#sumcap").val();
        var email = $("#email").val();
        var userlevel = $("#userlevel").val();

        $.ajax({
            url: "app/ajax/registeruser.php",
            method: "POST",
            data: { addNewUser: 1, username: username, surname: surname, firstname: firstname, middlename: middlename, phoneno: phoneno, password: password, cap3: cap3, sumcap: sumcap, confirmpass: confirmpass, email: email, userlevel: userlevel },
            success: function(data) {
                $(".submitRegister").html('<i class="material-icons left">save</i> Create User Account ');
                if (data == "sm") {
                    $("#add_msg").html('<div class="alert-box-success"><h6 class="title">Registration Successful</h6><p>New user account has been created.</p></div>');
                    $("#username").val('');
                    $("#surname").val('');
                    $("#firstname").val('');
                    $("#middlename").val('');
                    $("#phoneno").val('');
                    $("#password").val('');
                    $("#confirmpass").val('');
                    $("#email").val('');
                    $("#cap3").val('');
                    $("#email").val('');
                    window.setTimeout(function() {
                        location.reload()
                    }, 3000);
                } else {
                    $("#add_msg").html(data);
                }
            }
        });
    });

    $('.viewUsers').click(function(){
        location.href='user-management'
    })

});