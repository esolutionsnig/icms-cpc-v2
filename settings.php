<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
$pagename = 'Settings';
//Check user loggin stats and user level
if($session->logged_in){
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
                    <li><a href="./"><?php echo $pagename; ?></a></li>
                    <li class="active">Overview Of Page Settings</li>
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
              <!--card stats start-->
              <div id="card-stats">

                <div class="row mt-1">
                  <div class="col s12 m6 l3">
                    <a href="deposit-types" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">add_to_photos</i>
                            <p>Deposit Types</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumDepositTypes()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a href="deposit-categories" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">add_box</i>
                            <p>Deposit Categories</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumDepositCategories()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a href="container-types" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s8 m8">
                            <i class="material-icons background-round mt-5">business_center</i>
                            <p>Container Types</p>
                          </div>
                          <div class="col s4 m4 right-align">
                            <h5 class="mb-0"><?php number_format(getNumContainerTypes()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a href="vehicle-management" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">local_shipping</i>
                            <p>Vehicle Management</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumVehicles()); ?></h5>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>

                <div class="row mt-1">
                  <div class="col s12 m6 l4">
                    <a href="consignment-locations" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">location_on</i>
                            <p>Consignment Locations</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumConsignmentLocations()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a href="denominations" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">call_split</i>
                            <p>Denominations</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumDenominations()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a href="currencies" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">monetization_on</i>
                            <p>Currencies</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumCurrencies()); ?></h5>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <!-- <div class="col s12 m6 l3">
                    <a href="vault" target="_blank" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">account_balance</i>
                            <p>Containers In Vault</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumberUsers()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div> -->
                </div>

              </div>

              <div class="row">
                <div class="col s12" id="searchResult"></div>
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

    <script type="text/javascript" src="assets/js/pages/queries-reports-views.js"></script>

  </body>
</html>
<?php
} else {
  header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>