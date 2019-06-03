<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/clients.php';
include 'app/core/session.php';
$pagename = 'Client';
//Check user loggin stats and user level
if ($session->logged_in) {
  if ($session->isAdmin() || $session->isSuperAdmin() || $session->isExcutive() || $session->isManager() ) {

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
  } else {
    header("Location: clients");
  }
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
                  <h5 class="breadcrumbs-title"><?php getBankName($get_slug); ?></h5>
                  <ol class="breadcrumbs">
                    <li><a href="./">Dashboard</a></li>
                    <li><a href="clients">Clients</a></li>
                    <li class="active"><?php echo getBankName($get_slug); ?></li>
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
                <div class="s12">
                  <h3 class="uppercase blue-grey-text header">
                    <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isExecutive()  || $session->isManager()  ) {
                      // Computer Book & Account Balance
                      $bookBalance = $clientAccountBalance = 0;
                      $bookBalance = getClientBookBalance($get_id);
                      $undeliveredSupplyRequest = getUndeliveredSupplyRequest($get_id);
                      $clientAccountBalance = $bookBalance - $undeliveredSupplyRequest;
                    ?>
                    <span style="font-weight: 100">Account Balance: <?php echo currencyIconn('naira'); ?></span> 
                    <strong><?php echo number_format($clientAccountBalance); ?></strong>
                    <?php } ?>
                  </h3>
                </div>
              </div>
              <div class="row">
                <div class="col l5 m5 s12">
                  <div class="card">
                    <div class="card-content">

                      <div class="card-header-title">
                        <div class="row">
                          <div class="col l9 m9 s12">
                            <h4>
                              Representatives
                              <span class="ml-2">Total: <strong><?php getNumberBankReps($get_id); ?></strong></span>
                            </h4>
                          </div>
                          <div class="col l3 m3 s12">
                            <button data-target="addBankReps" class="btns btns-add waves-effect waves-red modal-trigger"><i class="material-icons left">add</i> Add </button>
                          </div>
                        </div>
                      </div>

                      <?php getBankReps($get_id); ?>

                    </div>
                  </div>
                </div>
                <div class="col l7 m7 s12">
                  <div class="card">
                    <div class="card-content">

                      <div class="card-header-title">
                        <div class="row">
                          <div class="col l9 m9 s12">
                            <h4>
                              Branches
                              <span class="ml-2">Total: <strong><?php getNumberBankBranches($get_id); ?></strong></span>
                            </h4>
                          </div>
                          <div class="col l3 m3 s12">
                            <button data-target="addBankBranch" class="btns btns-add waves-effect waves-red modal-trigger"><i class="material-icons left">add</i> Add </button>
                          </div>
                        </div>
                      </div>
                      
                      <?php getBankBranches($get_id); ?>
                      
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

    <!-- Add Branch Modal -->
    <div id="addBankBranch" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Add New Bank Branch</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row margin">
            <div class="input-field col s12">
              <input id="bankBranch" name="bankBranch" type="text" class="validate bankBranch" required autocomplete="off">
              <label for="bankBranch">Branch Name</label>
              <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <input id="bankBranchLocation" name="bankBranchLocation" type="text" class="validate bankBranchLocation" required autocomplete="off">
              <label for="bankBranchLocation">Branch Location</label>
              <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <input id="bankBranchLocationCode" name="bankBranchLocationCode" type="text" class="validate bankBranchLocationCode" required autocomplete="off">
              <label for="bankBranchLocationCode">Branch Location Code</label>
              <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <select id="bankBranchCmu">
                <?php getBanksRepsList($get_id); ?>
              </select>
              <label>Select CMU For This Branch</label>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <select id="bankBranchRep">
                <?php getBanksRepsList($get_id); ?>
              </select>
              <label>Select Representative For This Branch</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <input type="hidden" name="bankId" id="bankId" value="<?php echo $get_id; ?>">
        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
        <button class="btn waves-effect waves-light teal white-text addBranchBtn mr-3">
          <i class="material-icons left">save</i>
          Save 
        </button>
      </div>
    </div>

    <!-- Update Branch Modal -->
    <div id="updateBranch" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Update (<strong id="reBranchName"></strong>) Branch</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row margin">
            <div class="input-field col s12">
              <input id="ubankBranch" name="ubankBranch" type="text" class="validate ubankBranch" required autocomplete="off">
              <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <input id="ubankBranchLocation" name="ubankBranchLocation" type="text" class="validate ubankBranchLocation" required autocomplete="off">
              <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <input id="ubankBranchLocationCode" name="ubankBranchLocationCode" type="text" class="validate ubankBranchLocationCode" required autocomplete="off">
              <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
            </div>
          </div>
          <input type="hidden" name="ubranchId" id="ubranchId">
          <input type="hidden" name="ubankBranchSlug" id="ubankBranchSlug">
          <input type="hidden" name="ubankId" id="ubankId" value="<?php echo $get_id; ?>">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
          <div class="row margin">
            <div class="input-field col s12">
              <select id="ubankBranchCmu">
                <?php getBanksRepsList($get_id); ?>
              </select>
              <label>Select CMU For This Branch</label>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <select id="ubankBranchRep">
                <?php getBanksRepsList($get_id); ?>
              </select>
              <label>Select Representative For This Branch</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <button class="btn waves-effect waves-light teal white-text editBranchBtn mr-3">
          <i class="material-icons left">save</i>
          Save 
        </button>
      </div>
    </div>

    <!-- Delete Branch Modal -->
    <div id="deleteBranch" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Remove Bank Branch</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to remove <strong class="bold" id="deBranchName"></strong> as this bank's branch?</p>
          <input type="hidden" name="dbranchId" id="dbranchId">
          </div>

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
          <button class="btn waves-effect waves-light primary-btn white-text removeBranchBtn mr-3">
              <i class="material-icons left">save</i>
              Yes Remove 
          </button>

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
      </div>
    </div>

    <!-- Add Modal -->
    <div id="addBankReps" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Add New Bank Representative</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body" style="min-height: 350px;">
          <div class="row margin">
            <div class="input-field col s12">
              <small>Select User </small>
              <select id="bankRep" class="searchableSelect">
                <?php getUsersListClient(); ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <input type="hidden" name="bankId" id="bankId" value="<?php echo $get_id; ?>">
        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
        <button class="btn waves-effect waves-light teal white-text addRepBtn mr-3">
            <i class="material-icons left">save</i>
            Save 
        </button>
      </div>
    </div>

    <!-- Delete BR Modal -->
    <div id="deleteBankRep" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Remove Bank Representative</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to remove <strong class="bold" id="bankRepName"></strong> as this bank's representative?</p>
          <input type="hidden" name="rBankId" id="rBankId">
          <input type="hidden" name="rUsername" id="rUsername">
          </div>

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
          <button class="btn waves-effect waves-light primary-btn white-text removeBtn mr-3">
              <i class="material-icons left">save</i>
              Yes Remove 
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
      $(document).ready(function() {
        $('#bbTable').DataTable( {
          // "scrollX": true
        })
      })
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