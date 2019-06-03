jQuery(document).ready(function($) {

    validate()

    var address = "";
    var gender = "";
    var surname = "";
    var firstname = "";
    var middlename = "";

    $("#surname").keyup(function() {
        var surname = $(this).val();
        validate();
    });

    $("#firstname").keyup(function() {
        var firstname = $(this).val();
        validate();
    });

    $("#middlename").keyup(function() {
        var middlename = $(this).val();
        validate();
    });

    $("#address").keyup(function() {
        var address = $(this).val();
        validate();
    });

    $("#gender").change(function() {
        var gender = $(this).val();
        validate();
    });

    function validate() {
        if (surname == '' ||
            firstname == '' ||
            middlename == '' ||
            address == '' ||
            gender == '') {
            $(".updateProfile").removeAttr('disabled');
        } else {
            $(".updateProfile").attr('disabled', 'disabled');
        }
    }

    //Update User Record
    $(".updateProfile").click(function(event) {
        event.preventDefault();
        var surname = $("#surname").val();
        var firstname = $("#firstname").val();
        var middlename = $("#middlename").val();
        var gender = $("#gender").val();
        var address = $("#address").val();
        var username = $("#username").val();
        var usertoken = $("#usertoken").val();
        if (surname == '' || firstname == '' || middlename == '' || address == '' || gender == '') {
            Materialize.toast('Kindly fill all fields marked as asterisks', 5000, 'rounded');
        } else {
            $(".updateProfile").html('<div class="progress"><div class="indeterminate"></div></div>');
            $(".updateProfile").attr('disabled', 'disabled');
            $.ajax({
                url: "app/ajax/updateprofile.php",
                method: "POST",
                data: { updateUser: 1, surname: surname, firstname: firstname, middlename: middlename, gender: gender, address: address, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateProfile").html('<i class="material-icons left">save</i> Save Changes ');
                    $(".updateProfile").removeAttr('disabled');
                    if (data == "ok200") {
                        $(".lname").html(surname);
                        $(".fname").html(firstname);
                        $(".onames").html(middlename);
                        $(".gender").html(gender);
                        $(".address").html(address);
                        Materialize.toast('Your profile details has been updated successfully', 5000, 'rounded');
                    } else {
                        console.log(data);
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded');
                    }
                }
            });
        }
    });

    // Chamge DP
    $("#dpform").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "app/ajax/uploaddp.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#preview").fadeOut();
                $(".changedp-btn").html('<div class="progress"><div class="indeterminate"></div></div>');
                $(".changedp-btn").attr('disabled', 'disabled');
            },
            success: function(data) {
                $(".changedp-btn").removeAttr('disabled');
                $(".changedp-btn").html('<i class="material-icons left">save</i> Save Changes')
                if (data == 'error400') {
                    Materialize.toast('Your Display Picture Was Not Updated, Kindly Retry Or Contact Support', 4000, 'rounded')
                } else {
                    console.log(data)
                    $(".userdpp").html('<img src="assets/images/avatar/' + data + '" class="circle responsive-img b5" alt="avatar" width="200">')
                    $(".userdpsn").html('<img src="assets/images/avatar/' + data + '" alt="avatar" class="circle responsive-img valign profile-image red darken-4 b2">')
                    $(".userdph").html('<img src="assets/images/avatar/' + data + '" alt="avatar">')
                    $("#preview").html('<img src="assets/images/avatar/' + data + '">');
                    Materialize.toast('Your Display Picture Has Been Updated Successfully', 4000, 'rounded')
                }
            },
            error: function(e) {
                Materialize.toast('System Failed To Update Your Record', 4000, 'rounded')
                console.log(e)
            }
        });
    }));

    //Change Password
    $('#password').keydown(function(e) {
        if (e.which == 32) {
            return false;
        }
    });
    $('#password').keyup(function() {
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

    $('#confpassword').blur(function() {
        checkPasswordMatch()
    });

    function checkPasswordMatch() {
        var password = $("#newpassword").val();
        var confirmPassword = $("#confpassword").val();

        if (password != confirmPassword) {
            $("#passerror").html('<div id="card-alert" class="card orange lighten-5"><div class="card-content orange-text"><p>WARNING : Passwords do not match!</p></div><button type="button" class="close orange-text" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
        } else {
            $("#passerror").html("");
        }
    }

    $(".changepassword-btn").click(function(event) {
        $(".changepassword-btn").html('<div class="progress"><div class="indeterminate"></div></div>');
        $(".changepassword-btn").attr('disabled', 'disabled');
        event.preventDefault();
        var curpassword = $("#curpassword").val();
        var newpassword = $("#newpassword").val();
        var confpassword = $("#confpassword").val();
        var usertoken = $("#usertoken").val();
        var username = $("#username").val();
        $.ajax({
            url: "app/ajax/changepassword.php",
            method: "POST",
            data: { updatePassword: 1, curpassword: curpassword, newpassword: newpassword, confpassword: confpassword, usertoken: usertoken, username: username },
            success: function(data) {
                $(".changepassword-btn").removeAttr('disabled');
                $(".changepassword-btn").html('<i class="material-icons left">save</i> Save Changes')
                if (data == "ok200") {
                    Materialize.toast('Your Account Was Updated Successfully', 4000, 'rounded')
                    $("#curpassword").val('');
                    $("#newpassword").val('');
                    $("#confpassword").val('');
                    window.setTimeout(function() {
                        window.location.href = "process";
                    }, 8000);
                } else {
                    console.log(data);
                    Materialize.toast('There Was An Error Updating Your Account, Contact Support', 6000, 'roundded')
                }
            }
        });
    });

});