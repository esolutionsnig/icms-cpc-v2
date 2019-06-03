<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/session.php';
include 'app/core/functions.php';
$pagename = 'Profile';
//Check user loggin stats and user level
if ($session->logged_in) {
  if (isset($_GET['r'])) {
    $get_req = $_GET['r'];
    // Pieces GR
    $piecesgr = explode("cprf", $get_req);
    $get_slug = $piecesgr[0];
    $get_uid = $piecesgr[1];
    // DeCrypt back uid
    $decrypted = base64_decode($get_uid);
    //Explode get value
    $piecesDecrypted = explode("------", $decrypted);
    $get_id = $piecesDecrypted[0];

    // get requested user record
    $reqDp = '';
    $getReqUserInfo   = $database->getUserInfo($get_id);
    $reqUsermail 	  	= $getReqUserInfo['email'];
    $reqUserphone 		= $getReqUserInfo['phoneno'];
    $reqUseraddress	  = $getReqUserInfo['address'];
    $reqUsergender 	  = $getReqUserInfo['gender'];
    $reqUserlevel		  = $getReqUserInfo['userlevel'];
    $reqUserLastSeen  = $getReqUserInfo['timestamp'];
    $reqUserdp        = $getReqUserInfo['userdp'];
    $reqFname			    = $getReqUserInfo['firstname'];
    $reqLname			    = $getReqUserInfo['surname'];
    $reqOnames			  = $getReqUserInfo['middlename'];
      
    $reqFullname 		  = $reqLname.' '.$reqFname.' '.$reqOnames;
    $reqShortname   	= $reqLname.' '.$reqFname;

    //Set Image
    if ($reqUserdp == "") { $reqDp = "avatar-12.png"; } else { $reqDp  = $reqUserdp; }
?>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
  </head>
  <body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->
    
    <!-- START HEADER -->
    <?php include 'layouts/header.php'; ?>
    <!-- END HEADER -->
    
    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">

        <!-- START LEFT SIDEBAR NAV-->
        <?php include 'layouts/left_sidenav.php'; ?>
        <!-- END LEFT SIDEBAR NAV-->
        
        <!-- START CONTENT -->
        <section id="content">
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <?php include 'layouts/searchSmallScreen.php'; ?>
            <div class="container">
              <div class="row">
                <div class="col s10 m8 l8">
                  <h5 class="breadcrumbs-title">Profile</h5>
                  <ol class="breadcrumbs">
                    <li><a href="./">Dashboard</a></li>
                    <li><a href="profile?r=<?php echo $get_req; ?>">Profile</a></li>
                    <li class="active"><?php echo $reqFullname; ?></li>
                  </ol>
                </div>
                <div class="col s2 m4 l4">
                  <?php include 'layouts/liveClock.php'; ?>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div id="profile-page" class="section">
              <!-- profile-page-content -->
              <div id="profile-page-content" class="row">
                <!-- profile-page-sidebar-->
                <div id="profile-page-sidebar" class="col s12 m5">
                  <h4 class="header center">Personal Information</h4>
                  <!-- Profile About Details  -->
                  <div class="red lighten-5 z-depth-2 padding-4 center userdpp">
                    <img src="assets/images/avatar/<?php echo $reqDp; ?>" class="circle responsive-img b5" alt="avatar" width="200">
                  </div>
                  
                  <ul id="profile-page-about-details" class="collection z-depth-1">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> Family Name</div>
                        <div class="col s6 right-align lname"><?php echo $reqLname; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> Given Name</div>
                        <div class="col s6 right-align fname"><?php echo $reqFname; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> Middle Name</div>
                        <div class="col s6 right-align onames"><?php echo $reqOnames; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">wc</i> Gender</div>
                        <div class="col s6 right-align gender"><?php echo $reqUsergender; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">call</i> Phone Number</div>
                        <div class="col s6 right-align"><?php echo $reqUserphone; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">email</i> Email Address</div>
                        <div class="col s6 right-align"><?php echo $reqUsermail; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">store</i> Contact Address</div>
                        <div class="col s6 right-align address"><?php echo $reqUseraddress; ?></div>
                      </div>
                    </li>
                  </ul>
                  <!--/ Profile About Details  -->
                </div>

                <div class="col s12 m7">
                  <h4 class="header center">Other Information</h4>
                  <ul id="profile-page-about-details" class="collection z-depth-1">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left blue-grey-text">assignment_ind</i> Assigned Level</div>
                        <div class="col s6 right-align lname"><?php getUserLevel($get_id); ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left blue-grey-text">brightness_1</i> Last Seen</div>
                        <div class="col s6 right-align fname"><?php timestamp($reqUserLastSeen); ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left blue-grey-text">person</i> Serves As Client Representative? </div>
                        <div class="col s6 right-align onames"><?php isClientRep($get_id); ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left blue-grey-text">store</i> Assigned Client Branch </div>
                        <div class="col s6 right-align onames"><?php clientRepn($get_id); ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left blue-grey-text">business</i> Assigned Client </div>
                        <div class="col s6 right-align onames">
                          <?php 
                            $bnkId = clientId($get_id);
                            clientName($bnkId); 
                          ?>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
      </div>
      <!--end container-->
      </section>
      <!-- END CONTENT -->

        <!-- START RIGHT SIDEBAR NAV-->
        <?php include 'layouts/right_sidenav.php'; ?>
        <!-- END RIGHT SIDEBAR NAV-->

      </div>
      <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->
    
    <!-- START FOOTER -->
    <?php include 'layouts/footer.php'; ?>
    <!-- END FOOTER -->
    
    <?php include 'layouts/foot.php'; ?>

    <!--profile page js-->
    <script type="text/javascript" src="assets/js/pages/profile.js"></script>

  </body>
</html>
<?php
  } else {

?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
  </head>
  <body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->
    
    <!-- START HEADER -->
    <?php include 'layouts/header.php'; ?>
    <!-- END HEADER -->
    
    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">

        <!-- START LEFT SIDEBAR NAV-->
        <?php include 'layouts/left_sidenav.php'; ?>
        <!-- END LEFT SIDEBAR NAV-->
        
        <!-- START CONTENT -->
        <section id="content">
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <?php include 'layouts/searchSmallScreen.php'; ?>
            <div class="container">
              <div class="row">
                <div class="col s10 m8 l8">
                  <h5 class="breadcrumbs-title">Profile</h5>
                  <ol class="breadcrumbs">
                    <li><a href="./">Dashboard</a></li>
                    <li><a href="profile">Profile</a></li>
                    <li class="active"><?php echo $fullname; ?></li>
                  </ol>
                </div>
                <div class="col s2 m4 l4">
                  <?php include 'layouts/liveClock.php'; ?>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div id="profile-page" class="section">
              <!-- profile-page-content -->
              <div id="profile-page-content" class="row">
                <!-- profile-page-sidebar-->
                <div id="profile-page-sidebar" class="col s12 m5">
                  <!-- Profile About Details  -->
                  <div class="red lighten-5 z-depth-2 padding-4 center userdpp">
                      <img src="assets/images/avatar/<?php echo $dp; ?>" class="circle responsive-img b5" alt="avatar" width="200">
                    </div>
                  
                  <ul id="profile-page-about-details" class="collection z-depth-1">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> Family Name</div>
                        <div class="col s6 right-align lname"><?php echo $lname; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> Given Name</div>
                        <div class="col s6 right-align fname"><?php echo $fname; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> Middle Name</div>
                        <div class="col s6 right-align onames"><?php echo $onames; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">person</i> User Level</div>
                        <div class="col s6 right-align"><?php echo $signedInAs; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">wc</i> Gender</div>
                        <div class="col s6 right-align gender"><?php echo $usergender; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">call</i> Phone Number</div>
                        <div class="col s6 right-align"><?php echo $userphone; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">email</i> Email Address</div>
                        <div class="col s6 right-align"><?php echo $usermail; ?></div>
                      </div>
                    </li>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <i class="material-icons left">store</i> Contact Address</div>
                        <div class="col s6 right-align address"><?php echo $useraddress; ?></div>
                      </div>
                    </li>
                  </ul>
                  <!--/ Profile About Details  -->
                </div>
                <!-- profile-page-sidebar-->
                <!-- profile-page-wall -->
                <div id="profile-page-wall" class="col s12 m7">
                  <!-- profile-page-wall-share -->
                  <div id="profile-page-wall-share" class="row">
                    <div class="col s12">
                      <ul class="tabs tab-profile z-depth-1 red darken-4">
                        <li class="tab col s3">
                          <a class="white-text waves-effect waves-light active" href="#UpdateProfile">
                            <i class="material-icons tiny">border_color</i> Profile</a>
                        </li>
                        <li class="tab col s3">
                          <a class="white-text waves-effect waves-light" href="#ChangeDisplayPicture">
                            <i class="material-icons tiny">camera_alt</i> Picture</a>
                        </li>
                        <li class="tab col s3">
                          <a class="white-text waves-effect waves-light" href="#ChangePassword">
                            <i class="material-icons tiny">lock</i> Password </a>
                        </li>
                      </ul>
                      <!-- UpdateProfile-->
                      <div id="UpdateProfile" class="tab-content col s12  white padding-3 z-depth-2">
                        <div class="row">
                          <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <input id="firstname" name="firstname" type="text" class="validate" required value="<?php echo $fname;?>">
                                    <label for="firstname">Given Name (First Name) * </label>
                                    <span class="helper-text" data-error="Given Name Is Required" data-success=""></span>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="surname" name="surname" type="text" class="validate" required value="<?php echo $lname;?>">
                                    <label for="surname">Family Name (surname) * </label>
                                    <span class="helper-text" data-error="Family Name Is Required" data-success=""></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <input id="middlename" name="middlename" type="text" value="<?php echo $onames;?>">
                                    <label for="middlename">Any Other Name * </label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <select name="gender" id="gender" class="validate grey-text" required>
                                    <?php if ($usergender == '') { echo '<option value="" disabled selected>Choose Your Gender</option>'; } else { echo '<option value="'.$usergender.'">'.$usergender.'</option>'; }?>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                    </select>
                                    <label>Gender * </label>
                                    <span class="helper-text" data-error="Gender Is Required" data-success=""></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="address" class="materialize-textarea" class="validate" required><?php echo $useraddress;?></textarea>
                                    <label for="firstname">Contact Address * </label>
                                    <span class="helper-text" data-error="Contact Address Is Required" data-success=""></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                                    <button class="btn waves-effect waves-light primary-btn updateProfile">
                                        <i class="material-icons left">save</i>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ChangeDisplayPicture -->
                      <div id="ChangeDisplayPicture" class="tab-content col s12  white padding-3 z-depth-2">
                        <div class="row">
                          <div class="col s12">
                            <form id="dpform" action="app/ajax/uploaddp.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" id="username" name="username" value="<?php echo $username; ?>"/>
                                <div class="row">
                                    <div class="file-field input-field">
                                        <div class="btn grey lighten-3 black-text">
                                            <span>File</span>
                                            <input id="uploadImage" type="file" accept="image/*" name="image" >
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div id="preview"><img src="assets/images/avatar/<?php echo $dp; ?>" width="250" /></div><br>
                                <button class="btn  waves-effect waves-light primary-btn changedp-btn" type="submit">
                                    <i class="material-icons">save</i>
                                    Save Changes
                                </button>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- ChangePassword -->
                      <div id="ChangePassword" class="tab-content col s12  white padding-3 z-depth-2">
                        <div class="row">
                            <div class="col s12">
                                <p>Note that you will be signed out once your password change is successul. Then you will have to sign in again using your new password.</p>
                                <p>Password must contain at least one of the following: Number, Alphabet, Special Character.</p>
                                <div class="divider"></div>
                                <div id="passerror"></div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix pt-5">lock_outline</i>
                                        <input id="curpassword" name="curpassword" type="password" autocomplete="off" class="validate" required>
                                        <label for="curpassword">Current Password * </label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s5">
                                        <i class="material-icons prefix pt-5">lock_outline</i>
                                        <input id="newpassword" name="newpassword" type="password" class="validate" required autocomplete="off">
                                        <label for="newpassword">New Password</label>
                                        <span class="helper-text" id="passerror" data-error="Password Is Required" data-success=""></span>
                                    </div>
                                    <div class="input-field col s5">
                                        <i class="material-icons prefix pt-5">lock_outline</i>
                                        <input id="confpassword" name="confpassword" type="password" class="validate" required autocomplete="off">
                                        <label for="confpassword">Confirm New Password</label>
                                        <span class="helper-text" data-error="Confirm Password Is Required" data-success=""></span>
                                    </div>
                                    <div class="input-field col s2">
                                        <div class="password_strength" id="password_strength"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 center">
                                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                                        <button class="btn waves-effect waves-light primary-btn changepassword-btn">
                                            <i class="material-icons left">save</i>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/ profile-page-wall-share -->
                </div>
                <!--/ profile-page-wall -->
              </div>
            </div>
          </div>
      </div>
      <!--end container-->
      </section>
      <!-- END CONTENT -->

        <!-- START RIGHT SIDEBAR NAV-->
        <?php include 'layouts/right_sidenav.php'; ?>
        <!-- END RIGHT SIDEBAR NAV-->

      </div>
      <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->
    
    <!-- START FOOTER -->
    <?php include 'layouts/footer.php'; ?>
    <!-- END FOOTER -->
    
    <?php include 'layouts/foot.php'; ?>

    <!--profile page js-->
    <script type="text/javascript" src="assets/js/pages/profile.js"></script>

  </body>
</html>
<?php
  }
} else {
    header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>