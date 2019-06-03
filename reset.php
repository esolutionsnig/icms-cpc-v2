<?php
/*
 * Author: Ernest Ibeh
 * Contact: 08020689069
 * Copyright: iCMS Nigeria
 * User Login / Registration Page
 */

/**
 * Index.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 */
include("app/core/session.php");
include("app/core/functions.php");
$pagename = 'Reset Password';
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
    
    <div id="loginbox" class="row" style="width: 500px;">
        <div class="col s12 center">
            <img src="assets/images/logo/login-logo.png" alt="iCMS" class="responsive-img valign auth-logo">
        </div>
        <div class="col s12 z-depth-4 card-panel">
            <h5>&nbsp;</h5>
            <?php
                /**
                * Forgot Password form has been submitted and no errors
                * were found with the form (the username is in the database)
                */
                if(isset($_SESSION['forgotpass'])){
                    /**
                    * New password was generated for user and sent to user's
                    * email address.
                    */
                    if($_SESSION['forgotpass']){
            ?>
            <div class="row">
                <div class="col s12 center">
                    <h5>&nbsp;</h5>
                    <h5>New Password Generated</h5>
                    <p>Your new password has been generated and sent to the email associated with your account.</p>
                    <div class="row">
                        <div class="col s12">
                            <a href='authentication' class='btn waves-effect waves-red primary-btn'> 
                            <i class='material-icons left'>dashboard</i> Sign In Here 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                     /**
                     * Email could not be sent, therefore password was not  edited in the database.
                     */
                    else {
            ?>
            <div class="row">
                <div class="col s12 center">
                    <h5>&nbsp;</h5>
                    <h5>New Password Generation Failed</h5>
                    <p>There was an error sending you the email with the new password, so your password has not been changed.</p>
                    <div class="row">
                        <div class="col s12">
                            <a href='reset' class='btn waves-effect waves-red primary-btn'> 
                            <i class='material-icons left'>refresh</i> Try Again
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                    unset($_SESSION['forgotpass']);
                } else {
                    /**
                    * Forgot password form is displayed, if error found it is displayed.
                    */
                ?>
                <div class="row">
                    <div class="col s12 center">
                        <img src="assets/images/avatar/avatar-12.png" alt="avatar" class="circle responsive-img valign profile-image-login">
                        <p class="center login-form-text">A new password will be generated for you and sent to the email address associated with your account, all you have to do is enter your username. </p>
                    </div>
                </div>
                <form action="process.php" method="POST" required autocomplete="off">
                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-5">person_outline</i>
                            <input id="user" name="user" type="text" class="validate" required autocomplete="off">
                            <label for="email" class="center-align">Username</label>
                            <span class="helper-text" data-error="Username Is Required" data-success=""><?php echo $form->error("user"); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="center">
                                <input type="hidden" name="subforgot" value="1">
                                <input type="hidden" name="location" value="<?php if(isset($_GET['location'])) { echo htmlspecialchars($_GET['location']); } ?>" >
                                <button id="submitReset" type="submit" class="waves-effect waves-light btn primary-btn pull-right"> 
                                    Reset Password <i class="material-icons left">save</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <div class="center">
                                <button class="btn-flat btn-small waves-effect waves-light blue-grey-text forgotPassword">Sign In</button>
                            </div>
                        </div>
                    </div>

                </form>
            <?php  } ?>
        </div>
        <div class="center">
            <small class="mt-4 blue-grey-text"><?php  echo APP_VERSION; ?></small>
        </div>
    </div>
    
    <?php include 'layouts/foot1.php'; ?>

    <script>
        $('.forgotPassword').click(function(){
            location.href='authentication'
        })
    </script>

  </body>
</html>