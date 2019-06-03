<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/preannouncements.php';
include 'app/core/session.php';
$pagename = 'New Preannouncement';
//Check user loggin stats and user level
if ($session->logged_in) {
  if ($session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ) {
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
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
                  <h5 class="breadcrumbs-title"><?php echo $pagename; ?></h5>
                  <ol class="breadcrumbs">
                    <li><a href="./">Dashboard</a></li>
                    <li><a href="preannouncements">Preannouncements</a></li>
                    <li class="active"><?php echo $pagename; ?></li>
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
            <div class="section">
              <div class="row">
                <div class="col s12">
                  <div class="right">
                    <a href="preannouncements" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a>
                  </div>
                </div>
              </div>

              <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
              <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">


              <div class="row">
                <div class="col l8 m8 s12">
                  <div class="card">
                    <div class="card-content">
                      
                        <h4 class="header center blue-grey-text"> Cash Preannouncement </h4>

                        <div class="row margin">
                            <div class="input-field col s12">
                                <input id="erName" name="erName" type="text" class="validate erName" required autocomplete="off">
                                <label for="erName">Preannouncement Title </label>
                                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                            </div>
                        </div>

                        <div class="row margin">
                          <div class="input-field col s12">
                            <small>Client</small>
                            <select id="clientName" class="searchableSelect cname">
                              <option value="">Select Client</option>
                              <?php getClients(); ?>
                            </select>
                          </div>
                        </div>

                        <div class="row margin">
                          <div class="input-field col s12">
                            <small>Branch</small>
                            <select id="clientBranch" class="searchableSelect cbranch">
                            </select>
                          </div>
                        </div>

                      <div class="row margin">
                        <label>Client Branch Location</label>
                        <div class="input-field col s12">
                          <input id="clientBranchL" name="clientBranchL" type="text" class="validate clientBranchL" required>
                        </div>
                      </div>

                      <div class="row margin">
                          <label>Your Branch Location Code</label>
                        <div class="input-field col s12">
                          <input id="clientBranchLC" name="clientBranchLC" type="text" class="validate clientBranchLC" required>
                        </div>
                      </div>

                      <div class="row margin">
                        <div class="input-field col s12">
                          <select id="consignmentLocation">
                            <?php getConsignmentLocations(); ?>
                          </select>
                          <label>Consignment Destination</label>
                          <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                        </div>
                      </div>

                      <div class="row">
                        <div class="s12 right">
                          <button class="btn waves-effect waves-light teal white-text proceedToCashAllocation">
                            <i class="material-icons right">save</i>
                            Save
                          </button>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
                <div class="col l4 m4 s12">
                  <div class="card">
                    <div class="card-content">
                      
                      <h4 class="header center blue-grey-text">Information</h4>
                      
                    </div>
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

    

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/preannouncements.js"></script>

    <script>
        $("#cashPreparation").hide()
    </script>

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