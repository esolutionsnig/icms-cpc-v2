<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/sealings.php';
include 'app/core/session.php';
$pagename = 'New Consignment Sealing';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive()) {
      
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
                    <li><a href="sealings">Sealings</a></li>
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
                    <a href="sealings" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Cancel &amp; Return</a>
                  </div>
                </div>
              </div>

              <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
              <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
              <input type="hidden" id="locationId" value="<?php echo $signed_location_id ; ?>">
              <?php
                $todaySealings = $signed_location_id.date("Y-m-d");
                // Get Total Amount In My Location
                $amountInMyLocation = getAmountWithStaff($signed_location_id);
                // Get Amount Sealed By User
                $amountSealedByUser = getAmountSealedByUser($todaySealings);
                // Get remaining Amount
                $remianingAmount = $amountInMyLocation - $amountSealedByUser;
              ?>
              <input type="hidden" name="amountInMyLocation" id="amountInMyLocation" value="<?php echo $amountInMyLocation; ?>">
              <input type="hidden" name="amountSealedByUser" id="amountSealedByUser" value="<?php echo $amountSealedByUser; ?>">
              <input type="hidden" name="todaySealings" id="todaySealings" value="<?php echo $todaySealings; ?>">

              <div class="row">
                <div class="col l4 m4 s12">
                  <div class="card">
                    <div class="card-content">
                      <h4 class="header center blue-grey-text">Cash Information</h4>
                      <div class="row">

                        <div class="col s12">
                          <div class="card teal white-text">
                            <div class="card-content">
                              <p class="uppercase">The Total Amount In Your Location:</p>
                              <h4><strong><?php echo number_format($amountInMyLocation); ?></strong></h4>
                            </div>
                          </div>
                        </div>

                        <div class="col s12">
                          <div class="card orange white-text">
                            <div class="card-content">
                              <p class="uppercase">The Total Amount Sealed In Your Location:</p>
                              <h4><strong><?php echo number_format($amountSealedByUser); ?></strong></h4>
                            </div>
                          </div>
                        </div>

                        <div class="col s12">
                          <div class="card primary-btn white-text">
                            <div class="card-content">
                              <p class="uppercase">The Total Amount To Be Sealed In Your Location:</p>
                              <h4><strong id="remAmount"><?php echo number_format($remianingAmount); ?></strong></h4>
                              <input type="hidden" id="remainAmount" value="<?php echo $remianingAmount; ?>">
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="col l8 m8 s12">
                  <div class="card">
                    <div class="card-content">
                      
                      <h4 class="header center blue-grey-text">Cash Sealing <small class="red-text">All Fields Are Required</small></h4>
                      
                        <div class="row margin">
                            <div class="input-field col l4 m4 s12">
                                <select id="strim">
                                    <option value=""> Select The Sealing Stream / Type </option>
                                    <option value="CBN"> CBN Sealing Stream / Type </option>
                                    <option value="Others"> General Sealing Stream / Type </option>
                                </select>
                                <label>Sealing Stream / Type</label>
                            </div>
                            <div class="input-field col l8 m8 s12">
                                <input id="sealingTitle" name="sealingTitle" type="text" class="validate sealingTitle" required autocomplete="off">
                                <label for="sealingTitle">Sealing Title </label>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="input-field col s12">
                                <small>Client</small>
                                <select id="clientId" class="searchableSelect">
                                    <option value="">Select Client</option>
                                    <?php getClients(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="input-field col l6 m6 s12">
                                <small>Cash category</small>
                                <select id="categoryId" class="searchableSelect">
                                    <option value="">Select Cash Category</option>
                                    <?php getCashCategoriesList(); ?>
                                </select>
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <small>Container Type</small>
                                <select id="containerId" class="searchableSelect">
                                    <?php getContainerTypeLists(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="input-field col l6 m6 s12">
                                <small>Currency TYpe</small>
                                <select id="currencyId" class="searchableSelect">
                                    <option value="">Select Currency Type</option>
                                    <?php getCurrencyTypesList(); ?>
                                </select>
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <small>Denomination Type</small>
                                <select id="denominationId" class="searchableSelect">
                                    <option value="">Select Denomination Type</option>
                                    <?php getDenominationTypesList(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="input-field col l4 m4 s12">
                                <input id="amount" name="amount" type="text" class="validate amount" required autocomplete="off" onkeypress="return AvoidSpace(event)">
                                <label for="amount">Amount  <small id="amountFb" class="helper-text"></small> </label>
                                <h5 id="formatedAmount" class="blue-grey-text center"></h5>
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <input id="currentSealNumber" name="currentSealNumber" type="text" class="validate currentSealNumber" required autocomplete="off" onkeypress="return AvoidSpace(event)" maxlength="6">
                                <label for="currentSealNumber">Client Seal Number <small id="sealFb2" class="helper-text"></small> <br></label>
                                <small>Generated Seal Number: <strong  class="black-text"><span id="newcurrentSealNumber"></span></strong></small>
                                <input type="hidden" id="gencurrentSealNumber">
                            </div>
                            <div class="input-field col l4 m4 s12">
                                <input id="sealNumber" name="sealNumber" type="text" class="validate sealNumber" required autocomplete="off" onkeypress="return AvoidSpace(event)" maxlength="6">
                                <label for="sealNumber">Seal Number <small id="sealFb" class="helper-text"></small> <br></label>
                                <small>Generated Seal Number: <strong  class="black-text"><span id="newSealNumber"></span></strong></small>
                                <input type="hidden" id="genSealNumber">
                            </div>
                        </div>

                        <div class="row">
                            <div class="s12 right mt-5">
                                <button class="btn waves-effect waves-light teal white-text sealThisContainer">
                                    <i class="material-icons left">lock_outline</i> Seal Container
                                </button>
                            </div>
                        </div>

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

    <script type="text/javascript" src="assets/js/pages/sealings.js"></script>

    <script>
      $('.sealThisContainer').hide()
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