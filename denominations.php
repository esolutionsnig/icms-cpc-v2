<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/denominations.php';
include 'app/core/session.php';
$pagename = 'Denominations';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin()) {
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
                    <li><a href="settings">Settings</a></li>
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
                    <button data-target="addDenomination" class="btns btns-add waves-effect waves-teal modal-trigger"><i class="material-icons left">add</i> Add New Denomination</button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content" id="load-denominations">
                      
                      <?php getDenominations(); ?>
                      
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

    <!-- Add Modal -->
    <div id="addDenomination" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Create New Denomination</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row margin">
            <div class="input-field col s12">
                <input id="dName" name="dName" type="text" class="validate dName" required autocomplete="off" onkeypress="return isNumber(event)">
                <label for="dName">Denomination Name</label>
                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
        <button class="btn waves-effect waves-light teal white-text addBtn mr-3">
            <i class="material-icons left">save</i>
            Save 
        </button>
      </div>
    </div>

    <!-- Update Modal -->
    <div id="updateDenomination" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Update (<strong class="bold" id="udname"></strong>) Denomination </h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <input type="hidden" name="ud-id" id="ud-id">
          <div class="row margin">
            <div class="input-field col s12">
                <input id="ud-name" name="ud-name" type="text" class="validate ud-name" required autocomplete="off" placeholder="Denomination Name" onkeypress="return isNumber(event)">
                <span class="helper-text" data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
        <button class="btn waves-effect waves-light teal white-text updateBtn mr-3">
            <i class="material-icons left">save</i>
            Save 
        </button>
      </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteDenomination" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Delete (<strong class="bold" id="ddname"></strong>) Denomination </h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete <strong class="bold" id="dd-name"></strong> Denomination?</p>
          <input type="hidden" name="dd-id" id="dd-id">
          </div>

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
          <button class="btn waves-effect waves-light primary-btn white-text deleteBtn mr-3">
              <i class="material-icons left">save</i>
              Yes Delete 
          </button>

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        
      </div>
    </div>
    
    <?php include 'layouts/foot.php'; ?>

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/denominations.js"></script>

    <script>
        // Prevent Space
        function AvoidSpace(event) {
            var k = event ? event.which : window.event.keyCode
            if (k == 32) return false
        }
        // Allow Number Only
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
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