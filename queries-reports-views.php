<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
$pagename = 'Search Engine';
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
                    <li class="active">Search For Any Record Existing On This Platform</li>
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
                    <a class="modal-trigger" href="#searchClients" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">business</i>
                            <p>Registered Clients</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumberOfBanks()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a class="modal-trigger" href="#searchClientBranches" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">store</i>
                            <p>Client Branches</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumberOfBankLocations()); ?></h5>
                            <p class="no-margin">Total</p>
                            <p>From: <?php number_format(getNumberOfBanks()); ?></p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a class="modal-trigger" href="#searchClientEvacReqs" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">timeline</i>
                            <p>Client Requests</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getClientRequest()); ?></h5>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a class="modal-trigger" href="#searchUsers" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">people</i>
                            <p>Registered Users</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumberUsers()); ?></h5>
                            <p class="no-margin">Total</p>
                            <p>Client : <?php number_format(getNumberClientReps()); ?></p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>

                <div class="row mt-1">
                  <div class="col s12 m6 l3">
                    <a class="modal-trigger" href="#searchBC" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s8 m8">
                            <i class="material-icons background-round mt-5">done_all</i>
                            <p>Bundle Confirmations</p>
                          </div>
                          <div class="col s4 m4 right-align">
                            <h5 class="mb-0"><?php number_format(getBundleConfirmationss()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a class="modal-trigger" href="#searchCA" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">monetization_on</i>
                            <p>Cash Allocations</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getCashAllocations()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a class="modal-trigger" href="#searchSCS" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">lock_outline</i>
                            <p>Sealed Containers</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getSealedContainers()); ?></h5>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col s12 m6 l3">
                    <a href="vault" style="color: #000 !important;">
                      <div class="card  gradient-shadow min-height-100">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">account_balance</i>
                            <p>Containers In Vault</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getVaultItems()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
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

    <div id="searchClients" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="erId" id="erId">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="clientSearchName" class="clientSearchName" placeholder="Enter Client Name Here...">
              <label for="clientSearchName">Client Name</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchClients">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

    <div id="searchClientBranches" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="erId" id="erId">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="clientBranchSearchName" class="clientBranchSearchName" placeholder="Enter Client Branch Rep, Name, Location or Location Code...">
              <label for="clientBranchSearchName">Client Branch Rep, Name, Location or Location Code</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchClientBranches">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

    <div id="searchClientEvacReqs" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="searchER" class="searchER" placeholder="Enter Request Title or Branch Location ...">
              <label for="searchER">Request Title or Branch Location</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchClientEvacReqs">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

    <div id="searchUsers" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="searchPeople" class="searchPeople" placeholder="Enter User First Name or Any Other Information ...">
              <label for="searchPeople">Username Information</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchUsers">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

    <div id="searchBC" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="searchBCS" class="searchBCS" placeholder="Enter Bundle Confirmation Seal Number ...">
              <label for="searchBCS">Seal Number</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchBC">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

    <div id="searchCA" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="searchCAS" class="searchCAS" placeholder="Enter Work Station or  Seal Number or Amount Allocated or Shift or Fake Currency Serial Number ...">
              <label for="searchCAS">Search Variable</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchCA">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

    <div id="searchSCS" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Pop's Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col l9 m9 s12">
              <input type="text" id="searchSCSS" class="searchSCSS" placeholder="Enter Sealing Title, Amount, Seal Number, Bag Open or Closed Amount Allocated ...">
              <label for="searchSCSS">Search Variable</label>
            </div>
            <div class="input-field col l3 m3 s12">
              <button class="btn waves-effect waves-light teal white-text searchSCS">
                <i class="material-icons left">search</i> Search
              </button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
      </div>
    </div>

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