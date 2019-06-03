<?php
include_once 'sys/register.inc.php';
include_once 'sys/functions.php';
include 'sys/constants.php';
$pagename = 'Registration';
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/css/custom/page-center.css" type="text/css" rel="stylesheet">
  </head>
  <body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->
    
    <div id="login-page" class="row" style="width: 400px;">
        <div class="col s12 z-depth-4 card-panel">
            <div class="row">
                <div class="col s12 center">
                    <img src="assets/images/logo/login-logo.png" alt="iCMS" class="responsive-img valign auth-logo">
                    <p class="center login-form-text">
                        <?php echo PROJECT_SUBTITLE; ?>
                    </p>
                </div>
            </div>

            <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="username" type="text" class="validate" required autocomplete="off">
                        <label for="username" class="center-align">Username</label>
                        <span class="helper-text" data-error="Username is required" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="email" type="email" class="validate" required autocomplete="off">
                        <label for="email" class="center-align">Email Address</label>
                        <span class="helper-text" data-error="Invalid Email Address" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="password" name="password" type="password" class="validate" required autocomplete="off">
                        <label for="password">Password</label>
                        <span class="helper-text" data-error="Password Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="confirmpwd" name="confirmpwd" type="password" class="validate" required autocomplete="off">
                        <label for="confirmpwd">Password</label>
                        <span class="helper-text" data-error="Password Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 offset-s3">
                        <input 
                            type="button"
                            value="Register User" 
                            onclick="return regformhash(this.form,
                                this.form.username,
                                this.form.email,
                                this.form.password,
                                this.form.confirmpwd);" class="button button1"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="sign-feedback">
                            <?php
                            if (!empty($error_msg)) { ?>
                            <div class="alert-box-error"><h4 class="title">Registration Failed</h4>
                                <?php echo $error_msg; ?>
                            </div>
                            <?php
                            }
                            ?> 
                        </div>
                    </div>
                    <div class="col s4">
                        <a class="waves-effect waves-light modal-trigger grey-text" href="#reginfo">Reg Info</a>
                    </div>
                    <div class="col s8">
                        <p class="margin center medium-small sign-up">Already have an account? <a href="auth">Sign In</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="reginfo" class="modal">
        <div class="modal-content">
            <h4>Registration Information</h4>
            <ul>
                <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
                <li>Emails must have a valid email format</li>
                <li>Passwords must be at least 6 characters long</li>
                <li>Passwords must contain
                    <ul>
                        <li>At least one upper case letter (A..Z)</li>
                        <li>At least one lower case letter (a..z)</li>
                        <li>At least one number (0..9)</li>
                    </ul>
                </li>
                <li>Your password and confirmation must match exactly</li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close &amp; Continue</a>
        </div>
    </div>
    
    <?php include 'layouts/foot.php'; ?>

    <script type="text/JavaScript" src="assets/js/sha512.js"></script> 
    <script type="text/JavaScript" src="assets/js/forms.js"></script> 
    
  </body>
</html>