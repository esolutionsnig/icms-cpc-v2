<?php
/*
 * Author: Ernest Ibeh
 * Contact: 08020689069
 * Copyright: iCMS Nigeria
 * User Login / Registration Page
 */

/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 */
include("app/core/session.php");
include("app/core/functions.php");
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin()) {
        
$pagename = 'User Registration';
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/css/custom/page-center.css" type="text/css" rel="stylesheet">
    <style type="text/css">

			.as_wrapper{
				margin: 0 auto;
				width: 1000px;
			}
			.mytable{
				margin: 0 auto;
				padding: 20px;
				border:2px solid  #0FF;
			}
			.success{
				color:#009900;
			}
			.errors{
				color:#F33C21;
			}
			.talign_right{
				text-align:right;
			}
			.username_avail_result{
				display:block;
				width:180px;
			}
			.password_strength {
				display:block;
				width:100%;
				padding:3px;
				text-align:center;
				color:#333;
				font-size:12px;
				backface-visibility:#FFF;
				font-weight:bold;
			}
			/* Password strength indicator classes weak, normal, strong, verystrong*/
			.password_strength.weak{
				background:#e84c3d;
			}
			.password_strength.normal{
				background:#f1c40f;
			}
			.password_strength.strong{
				background:#27ae61;
			}
			.password_strength.verystrong{
				background:teal;
				color:#FFF;
			}
		</style>
  </head>
  <body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->
    
    <div id="loginbox" class="row" style="width: 800px;">
        <div class="col s12 center">
            <img src="assets/images/logo/login-logo.png" alt="iCMS" class="responsive-img valign auth-logo">
        </div>
        <div class="col s12 z-depth-4 card-panel">
        	<div class="row">
                <div class="col s12 center">
                	<h5>New User Registration</h5>
                    <p> Please Fill With Accurate Data <i class="ecolor">fields marked as * are required</i> </p>
                    <div id='response'></div>
                </div>
            </div>
            <!-- <form method='post' id='reg-form' action="#" autocomplete="off"> -->
                <div class="row margin">
                    <div class="input-field col l4 m4 s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="surname" name="surname" type="text" class="validate" required autocomplete="off">
                        <label for="surname" class="center-align">Family Name *</label>
                        <span class="helper-text" data-error="FamilyName (Surname) Is Required" data-success=""></span>
                    </div>
                    <div class="input-field col l4 m4 s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="firstname" name="firstname" type="text" class="validate" required autocomplete="off">
                        <label for="firstname" class="center-align">Given Name *</label>
                        <span class="helper-text" data-error="Given Name (First Name) Is Required" data-success=""></span>
                    </div>
                    <div class="input-field col l4 m4 s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="middlename" name="middlename" type="text" class="validate" autocomplete="off">
                        <label for="email" class="center-align">Other Name</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col l4 m4 s12">
                        <i class="material-icons prefix pt-5">call</i>
                        <input id="phoneno" name="phoneno" type="text" class="validate" required autocomplete="off">
                        <label for="phoneno" class="center-align">Mobile Number *</label>
                        <span class="helper-text" data-error="Username Is Required" data-success=""></span>
                        <div class="phoneno_avail_result" id="phoneno_avail_result"></div>
                    </div>
                    <div class="input-field col l8 m8 s12">
                        <i class="material-icons prefix pt-5">email</i>
                        <input id="email" name="email" type="email" class="validate" required autocomplete="off">
                        <label for="email" class="center-align">Email Address *</label>
                        <span class="helper-text" data-error="Username Is Required" data-success=""></span>
                        <div class="emailadd_avail_result" id="emailadd_avail_result"></div>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col l4 m4 s12">
                        <i class="material-icons prefix pt-5">person_outline</i>
                        <input id="username" name="username" type="text" class="validate" required autocomplete="off">
                        <label for="username" class="center-align">Username *</label>
                        <span class="helper-text" data-error="Username Is Required" data-success=""></span>
                        <div class="username_avail_result" id="username_avail_result"></div>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="password" name="password" type="password" class="validate" required autocomplete="off">
                        <label for="password">Password</label>
                        <span class="helper-text" id="passerror" data-error="Password Is Required" data-success=""></span>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="confirmpass" name="confirmpass" type="password" class="validate" required autocomplete="off">
                        <label for="confirmpass">Confirm Password</label>
                        <span class="helper-text" data-error="Confirm Password Is Required" data-success=""></span>
                    </div>
                    <div class="input-field col l2 m2 s2">
                    	<div class="password_strength" id="password_strength"></div>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col l4 m4 s12">
                        <select id="userlevel" class="searchableSelect">>
                            <option value="4">Select User Access Level</option>
                            <?php getUserAccssLevel(); ?>
                        </select>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <?php
		                    $genCap1 = (rand(5,50));
		                    $genCap2 = (rand(10,100));
		                    $sumcap = $genCap1 + $genCap2;
		                ?>
		                <label for="captcha">
		                	What is the sum of <span class="red-text"><?php echo $genCap1.' + '.$genCap2;?> </span>
		                </label>
                    </div>
                    <div class="input-field col l2 m2 s6">
                        <i class="material-icons prefix pt-5">lock_outline</i>
                        <input id="cap3" name="cap3" type="text" class="validate" required autocomplete="off">
                        <label for="confirmpass"> Answer *</label>
                    </div>
                    <div class="col l3 m3 s6">
                        <span id="capfb"></span>
                        <span class="helper-text" data-error="Captcha Answer Is Required" data-success=""></span>
                        <input type="hidden" name="sumcap" id="sumcap" value="<?php echo $sumcap;?>">
                        <input type="hidden" name="location" value="<?php if(isset($_GET['location'])) { echo htmlspecialchars($_GET['location']); } ?>" >
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <input type="hidden" name="sublogin" value="1">
                        <input type="hidden" name="location" value="<?php if (isset($_GET['location'])) { echo htmlspecialchars($_GET['location']); } ?>" >
                        <div class="center">
                            <button id="submitRegister" class="waves-effect waves-light btn primary-btn pull-right submitRegister">
                                <i class="material-icons left">save</i> Create User Account 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12">
                		<div id="add_msg"></div>
                	</div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <div class="center">
                            <button class="btn-flat btn-small waves-effect waves-light blue-grey-text viewUsers">
                                <i class="material-icons left">people</i> View All Users
                            </button>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
        </div>
        <div class="center">
        	<small class="mt-4 blue-grey-text"><?php  echo APP_VERSION; ?></small>
        </div>
    </div>
    
    <?php include 'layouts/foot1.php'; ?>

    <script src="assets/js/register.js"></script>

  </body>
</html>
<?php

} else {
    header("Location: ./");
}
} else {
    header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>