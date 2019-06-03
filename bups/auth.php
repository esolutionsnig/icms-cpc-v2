<?php
/*
 * Author: Ernest Ibeh
 * Contact: 08020689069
 * Copyright: iCMS Nigeria
 * User Login / Registration Page
 */
include 'sys/constants.php';
$pagename = 'Authentication';

$error = "";
$msg = "";
error_reporting(0);
if (isset($_GET['method'], $_GET['code']) && $_GET['method'] = "activate") {
    require 'sys/config.php';
    $mysqli = new mysqli($server, $database_user, $database_passwd, $database_name);
    $code = (int)$_GET['code'];
    $query = $mysqli->query("SELECT `id` FROM `users` WHERE `activecode`='$code' AND `status`=0");
    if ($query->num_rows > 0) {
        $mysqli->query("UPDATE `users` SET `status`=1 WHERE `status`=0 AND `activecode`='$code'");
        $msg = '<div class="alert-box-warning"><h4 class="title">Activation Successful</h4>
                        <p>Your account has been successfully activated, you may now Sign In.</p>
                    </div>';
    }
}
if (isset($_POST) && isset($_POST['type'])) {

    require 'sys/config.php';
    $mysqli = new mysqli($server, $database_user, $database_passwd, $database_name);
    if ($mysqli->connect_errno) {
        echo '{"error":1,"message":"Unable to connect with database."}';
        exit();
    }
    if ($_POST['type'] == "login" && isset($_POST['username'], $_POST['password'])) {
        $e = htmlentities($_POST['username'], ENT_QUOTES);
        $p = md5($_POST['password']);
        $query = $mysqli->query("SELECT * FROM `users` WHERE `email`='$e' AND `password`='$p' AND `status`=1");

        if ($query->num_rows == 1) {
            session_start();
            $_SESSION['db_login'] = $query->fetch_assoc();
            echo '{"error":0,"redir":"okk"}';
        } else {
            echo '{"error":1,"message":"Invalid username or password."}';
        }

    } else if ($_POST['type'] == "register" && isset($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['passwd'], $_POST['confpasswd'])) {

        $_POST['firstname'] = htmlentities($_POST['firstname'], ENT_QUOTES);
        $_POST['lastname'] = htmlentities($_POST['lastname'], ENT_QUOTES);
        $_POST['passwd'] = htmlentities($_POST['passwd'], ENT_QUOTES);

        $code = rand(0, 999999999);
        $f = $_POST['firstname'];
        $l = $_POST['lastname'];
        $e = $_POST['email'];
        $p = md5($_POST['passwd']);

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            echo '{"error":1,"message":"Please enter valid email address","focus":"email"}';

        } else {
            $query = $mysqli->query("SELECT `id` FROM `users` WHERE `email`='$e'");
            if ($query->num_rows > 0) {
                echo '{"error":1,"message":"Email address already exists.","focus":"email"}';
            } else if (strlen($_POST['firstname']) < 2 || strlen($_POST['firstname']) > 50) {
                echo '{"error":1,"message":"Firstname must between 2 & 50 characters.","focus":"firstname"}';
            } else if (strlen($_POST['lastname']) < 2 || strlen($_POST['lastname']) > 50) {

                echo '{"error":1,"message":"Lastname must between 2 & 50 characters.","focus":"lastname"}';

            } else if (strlen($_POST['passwd']) < 2 || strlen($_POST['passwd']) > 50) {

                echo '{"error":1,"message":"Password must between 2 & 50 characters.","focus":"passwd"}';

            } else if ($_POST['passwd'] != $_POST['confpasswd']) {

                echo '{"error":1,"message":"Password not matched","focus":"confpasswd"}';

            } else {

                if ($sendmail) {

                    $message = "Hello " . $_POST['firstname'] . " \n Please click on link below to activate your account. \n\n";
                    $message .= "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] . "?method=activate&code=" . $code;
                    $message .= "\n\n\n Integrated Cash Management Services Limited";

                    if (mail($_POST['email'], $mail_subject, $message, $mail_from)) {
                        $mysqli->query("INSERT INTO `users` (`firstname`,`lastname`,`email`,`password`,`status`,`activecode`,`timestamp`) VALUES('$f','$l','$e','$p',0,'$code',UNIX_TIMESTAMP())");
                        echo '{"error":0,"message":"Registration complete, Please check your email to activate your account","redir":"none"}';
                    } else {
                        echo '{"error":1,"message":"Unable to send verfication email"}';
                    }
                } else {
                    $mysqli->query("INSERT INTO `users` (`firstname`,`lastname`,`email`,`password`,`status`,`activecode`,`timestamp`) VALUES('$f','$l','$e','$p',1,'$code',UNIX_TIMESTAMP())") or die($mysqli->error);
                    echo '{"error":0,"message":"Registration complete,<a onclick=\"$(\'#signupbox\').hide();$(\'.panel\').removeClass(\'animated shake\'); $(\'#loginbox\').show()\">Click here</a> to login","redir":"none"}';
                }

            }
        }

    }

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/css/custom/page-center.css" type="text/css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
  </head>
  <body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->
    
    <div id="loginbox" class="row" style="width: 400px;">
        <div class="col s12 z-depth-4 card-panel panel">
            <div class="row">
                <div class="col s12 center">
                    <img src="assets/images/logo/login-logo.png" alt="iCMS" class="responsive-img valign auth-logo">
                    <p class="center login-form-text">
                        <?php echo PROJECT_SUBTITLE; ?> - Sign In
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col s12"><?php echo $msg; ?></div>
                <div style="display:none" id="login-alert" class="col s12"></div>
            </div>
            <form id="loginform">
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="login-username" name="username" type="email" class="validate" required autocomplete="off">
                        <label for="email" class="center-align">Email Address</label>
                        <span class="helper-text" data-error="Invalid Email Address" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="login-password" name="password" type="password" class="validate" required autocomplete="off">
                        <label for="password">Password</label>
                        <span class="helper-text" data-error="Password Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 offset-s3">
                        <input type="hidden" name="type" value="login">
                        <button type="submit" id="btn-login" class="waves-effect waves-light btn"> Sign In </button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col s12">
                    <div style="border-top: 1px solid #bce8f1; padding-top:15px; padding-left:10px; font-size:85%; margin: 0 -15px;">
                        Don't have an account!
                        <a href="#" onClick="$('#loginbox').hide(); $('.panel').removeClass('animated shake'); $('#signupbox').show()">
                            Sign Up Here
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="signupbox" style="display:none; margin-top:50px" class="row" style="width: 400px;">
        <div class="col s12 z-depth-4 card-panel panel">
            <div class="row">
                <div class="col s12 center">
                    <img src="assets/images/logo/login-logo.png" alt="iCMS" class="responsive-img valign auth-logo">
                    <p class="center login-form-text">
                        <?php echo PROJECT_SUBTITLE; ?> - Sign Up
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col s12"><?php echo $msg; ?></div>
                <div id="signupalert" style="display:none" class="col s12">
                    <div class="alert-box-error"><h4 class="title">Registration Failed</h4>
                        <span></span>
                    </div>
                </div>
            </div>
            <form id="signupform">
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input name="firstname" type="text" class="validate" required autocomplete="off">
                        <label for="firstname" class="center-align">Given Name</label>
                        <span class="helper-text" data-error="Given Name Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input name="lastname" type="text" class="validate" required autocomplete="off">
                        <label for="lastname" class="center-align">Family Name</label>
                        <span class="helper-text" data-error="Family Name Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input name="email" type="email" class="validate" required autocomplete="off">
                        <label for="email" class="center-align">Email Address</label>
                        <span class="helper-text" data-error="Invalid Email Address" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="passwd" name="passwd" type="password" class="validate" required autocomplete="off">
                        <label for="password">Password</label>
                        <span class="helper-text" data-error="Password Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="confpasswd" name="confpasswd" type="password" class="validate" required autocomplete="off">
                        <label for="password">Password</label>
                        <span class="helper-text" data-error="Password Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 offset-s3">
                        <input type="hidden" name="type" value="register">
                        <button type="submit" id="btn-signup" class="waves-effect waves-light btn"> Sign Up </button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col s12">
                    <div style="border-top: 1px solid #bce8f1; padding-top:15px; padding-left:10px; font-size:85%; margin: 0 -15px;">
                        Already have an account!
                        <a href="#" onClick="$('#signupbox').hide(); $('.panel').removeClass('animated shake'); $('#loginbox').show()">
                            Sign In Here
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'layouts/foot.php'; ?>

    <script>
    $('form').submit(function (e) {
      e.preventDefault();
      var $this = $(this);
      $this.parent().parent().removeClass('animated shake');
      $this.parent().find('.alert').remove();
      var submit = true;
    //   var btn = $(this).find('button');
      $this.find('input[type="text"],input[type="password"]').attr('style', '');

      $this.find('input[type="text"],input[type="password"]').each(function () {
        if ($(this).val() == "") {
          $(this).focus().css({ 'border-color': '#f44', 'box-shadow': '0 0 8px #f44' });
          submit = false;
          $this.parent().parent().addClass('animated shake');
          return false;
        }
      });
      if (submit == true) {
        // btn.button('loading');
        $("#btn-login").html('Authenticating')
        // $("#btn-login").setAttr('disabled', 'disabled')
        $.post('auth.php', $(this).serialize(), function (data) {
          if (data.error == 1) {
            $this.parent().prepend('<div class="alert alert-danger">' + data.message + '</div>');
            $this.parent().parent().addClass('animated shake');
            if (data.focus && data.focus != "undefined") {
              $('input[name="' + data.focus + '"]').focus().css({ 'border-color': '#f44', 'box-shadow': '0 0 8px #f44' });
            }
          } else {
            if (data.redir == "okk") {
              $this.parent().prepend('<div class="alert alert-success">Login successfull, redirecting...</div>');
              window.location = 'home.php';
            } else {
              $this.parent().prepend('<div class="alert alert-success">' + data.message + '</div>');
            }
          }
        }, "JSON").error(function () {
          alert('Request not complete.');
        }).always(function () {
          btn.button('reset')
        });
      }
      setTimeout(function () {

      }, 100)

    });
  </script>

  </body>
</html>