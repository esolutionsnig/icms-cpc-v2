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
$pagename = 'Authentication';
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
            <?php 
            $userAvatar = '';
            if ($session->logged_in) { 
                $req_user_dp = user_dp($session->username);
                $userDp	= $req_user_dp['userdp'];
                if ($userDp == '') {
                    $userAvatar = 'avatar-12.png';
                } else {
                    $userAvatar = $userDp;
                }
            ?>
            <div class="row">
                <div class="col s12 center">
                    <h5>&nbsp;</h5>
                    <img src="assets/images/avatar/<?php echo $userAvatar; ?>" alt="avatar" class="circle responsive-img valign profile-image-login">
                    Welcome back <b><?php echo $session->username; ?>
                    <div class="row">
                        <div class="col s6">
                            <a href='./' class='btn waves-effect waves-red primary-btn'> 
                            <i class='material-icons left'>dashboard</i> Access Your Dashboard 
                            </a>
                        </div>
                        <div class="col s6">
                            <a href='process' class='waves-effect waves-red btn-flat'>
                                <i class="material-icons right">exit_to_app</i>
                                Sign Out 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            } else { ?>
                <div class="row">
                    <div class="col s12 center">
                        <h5>&nbsp;</h5>
                        <img src="assets/images/avatar/avatar-12.png" alt="avatar" class="circle responsive-img valign profile-image-login">
                        <p class="center login-form-text">Please Sign In Below </p>
                        <?php
                        /**
                         * User not logged in, display the login form.
                         * If user has already tried to login, but errors were
                         * found, display the total number of errors.
                         * If errors occurred, they will be displayed.
                         */
                        if ($form->num_errors > 0) {
                        ?>
                        <div class="alert-box-error">
                            <h4 class="title">
                                <i class="material-icons">lock</i> Access Denied
                            </h4>
                            <p><?php echo $form->num_errors; ?> error(s) found</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <form action="process.php" method="POST">
                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-5">person_outline</i>
                            <input id="user" name="user" type="text" class="validate" required autocomplete="off" value=' '>
                            <label for="email" class="center-align">Username</label>
                            <span class="helper-text" data-error="Username Is Required" data-success=""><?php echo $form->error("user"); ?></span>
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix pt-5">lock_outline</i>
                            <input id="pass" name="pass" type="password" class="validate" required autocomplete="off" value=' '>
                            <label for="pass">Password</label>
                            <span class="helper-text" data-error="Password Is Required" data-success=""><?php echo $form->error("pass"); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l12 ml-2 mt-3">
                            <input type="checkbox" name="remember" id="remember-me" <?php if ($form->value("remember") != "") { echo "checked"; } ?> />
                            <label for="remember-me">Remember me</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="center">
                                <input type="hidden" name="sublogin" value="1">
                                <input type="hidden" name="location" value="<?php if (isset($_GET['location'])) { echo htmlspecialchars($_GET['location']); } ?>" >
                                <input type="submit" name="submit" id="signinBtn" value="Sign In" class="waves-effect waves-light btn primary-btn pull-right" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <div class="center">
                                <button class="btn-flat btn-small waves-effect waves-light blue-grey-text forgotPassword">Forgot password?</button>
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
            location.href='reset'
        })
    </script>

  </body>
</html>