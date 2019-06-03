<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'New Supply Request';
//Check user loggin stats and user level
if ($session->logged_in) {
  if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isBanker() || $session->isBankerCmu()  ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive() ) {
    $cid = getClientId($session->username);
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
                    <li><a href="supply-requests">Supply Requests</a></li>
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
                    <a href="supply-request" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Cancel &amp; Return</a>
                  </div>
                </div>
              </div>

              <input type="hidden" name="clientId" id="clientId" value="<?php echo $cid; ?>">
              <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
              <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">


              <div class="row">
                <div class="col l8 m8 s12">
                  <div class="card">
                    <div class="card-content">
                      
                      <h4 class="header center blue-grey-text">Cash Supply Request </h4>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="srTitle" name="srTitle" type="text" class="validate" required autocomplete="off">
                                <label for="srTitle">Request Title </label>
                                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="input-field col l8 m8 s12">
                                <small>Requesting Branch</small>
                                <select id="requestType" class="searchableSelect">
                                    <option value="">Select Supply Request Type</option>
                                    <?php getSupplyRequestType(); ?>
                                </select>
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <small>Supply Date</small>
                                <input id="supplyDate" name="supplyDate" type="date" class="validate" required>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="input-field col s12">
                                <textarea name="srComment" id="srComment" placeholder="Enter Commenst / Instruction Here" class="materialize-textarea" cols="30" rows="1"></textarea>
                                <label for="difference">Additional Comment / Instruction</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="s12 right">
                                <button class="btn waves-effect waves-light teal white-text startSupplyRequest">
                                    <i class="material-icons right">send</i>
                                    Start Supply Request
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

    <script type="text/javascript" src="assets/js/pages/supply-requests.js"></script>

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