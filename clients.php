<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/clients.php';
include 'app/core/session.php';
$pagename = 'Clients';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() || $session->isExcutive() || $session->isManager() ) {
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
                    <button data-target="addBank" class="btns btn-add waves-effect waves-teal teal white-text modal-trigger"><i class="material-icons left">add</i> Add New Client</button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content" id="load-banks">
                      
                      <?php getBanks(); ?>
                      
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
    <div id="addBank" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Create New Client</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
            <div class="row margin">
                <div class="input-field col s12">
                    <input id="bankName" name="bankName" type="text" class="validate bankName" required autocomplete="off">
                    <label for="bankName">Client Name</label>
                    <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <input id="bankCode" name="bankCode" type="text" class="validate bankCode" required autocomplete="off">
                    <label for="bankCode">Client Accronym</label>
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
    <div id="updateBank" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Update (<strong class="bold" id="ubankname"></strong>) Bank </h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <input type="hidden" name="ubank-id" id="ubank-id">
          <div class="row margin">
            <div class="input-field col s12">
                <input id="ubank-name" name="ubank-name" type="text" class="validate ubank-name" required autocomplete="off">
                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
                <input id="ubank-code" name="ubank-code" type="text" class="validate ubank-code" required autocomplete="off">
                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
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
    <div id="deleteBank" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Delete (<strong class="bold" id="dbankname"></strong>) Client </h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this <strong class="bold" id="dbank-name"></strong> client?</p>
          <input type="hidden" name="dbank-id" id="dbank-id">
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

    <script type="text/javascript" src="assets/js/pages/clients.js"></script>

    <script>
        // Prevent Space
        function AvoidSpace(event) {
            var k = event ? event.which : window.event.keyCode
            if (k == 32) return false
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