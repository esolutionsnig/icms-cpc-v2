<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
$pagename = 'Overview Of Activities';
//Check user loggin stats and user level
if($session->logged_in){
    if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isExecutive() || $session->isManager() ) { 
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
                    <li><a href="executive-dashboard"><?php echo $pagename; ?></a></li>
                    <li class="active">On This Platform</li>
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

                        <?php
                            // Get Amount In The Building
                            $amountInBuilding = $amountInTransit = $grandTotal = 0;
                            $grandTotal = getTotalAmountExecustiveView();
                            $amountInTransit = getTotalCit('naira');
                            $amountInBuilding = $grandTotal - $amountInTransit;
                        ?>

                        <!-- Expecting -->
                        <div class="col l3 m3 s12">
                            <h4 class="header uppercase blue-grey-text">
                                <i class="material-icons left deepred-text">local_shipping</i> Cash In Transit 
                            </h4>
                            <div class="card  gradient-shadow min-height-100">
                                <div class="padding-4">
                                    <div class="col s3 m3">
                                        <small>&nbsp;<br></small>
                                        <span class="background-round mt-5"><?php echo currencyIconn('naira'); ?></span>
                                        <p>Naira</p>
                                    </div>
                                    <div class="col s9 m9 right-align">
                                        <h4 class="mb-0"><?php echo number_format($amountInTransit); ?></h4>
                                        <p class="no-margin">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- In The Building -->
                        <div class="col l4 m4 s12">
                            <h4 class="header uppercase blue-grey-text">
                                <i class="material-icons left deepred-text">home</i> Cash In Building 
                            </h4>
                            <div class="card  gradient-shadow min-height-100">
                                <div class="padding-4">
                                    <div class="col s3 m3">
                                        <small>&nbsp;<br></small>
                                        <span class="background-round mt-5"><?php echo currencyIconn('naira'); ?></span>
                                        <p>Naira</p>
                                    </div>
                                    <div class="col s9 m9 right-align">
                                        <h4 class="mb-0"><?php echo number_format($amountInBuilding); ?></h4>
                                        <p class="no-margin">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Total Amount -->
                        <div class="col l5 m5 s12">
                            <h4 class="header uppercase blue-grey-text">
                                <i class="material-icons left deepred-text">account_balance_wallet</i> Total Amount In ICMS Custody 
                            </h4>
                            <div class="card  gradient-shadow min-height-100">
                                <div class="padding-4">
                                    <div class="col s3 m3">
                                        <small>&nbsp;<br></small>
                                        <span class="background-round mt-5"><?php echo currencyIconn('naira'); ?></span>
                                        <p>Naira</p>
                                    </div>
                                    <div class="col s9 m9 right-align">
                                        <h4 class="mb-0"><?php echo number_format($grandTotal); ?></h4>
                                        <p class="no-margin">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                </div>
          </div>
          <!--end container-->

            <div class="container">
                <div class="section">

                    <!--card widgets start-->
                    <div id="card-widgets">
                        <div class="row">
                            <div class="col s12 m4 l4">
                                <div class="card" style="border-left: 6px solid #0288d1;">
                                    <div class="card-content">
                                        <h5 class="header uppercase">
                                            <?php number_format(getNumberOfBanks()); ?> Clients <br>
                                            <small>Use the quick filter to search through client list</small>
                                        </h5>
                                        <input type="text" id="sfInput" onkeyup="sfFunction()" placeholder="Search for names..." title="Type in a name to begin search">
                                        <div style="min-height:450px; height:450px; overflow-y: scroll;">
                                            <?php getClientList(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card" style="border-left: 6px solid #ff5252;">
                                    <div class="card-content">
                                        <h5 class="header uppercase">
                                        <?php number_format(getNumberOfBankLocations()); ?> Branches <br>
                                            <small>Use the quick filter to search through branch list</small>
                                        </h5>
                                        <input type="text" id="bfInput" onkeyup="bfFunction()" placeholder="Search for names..." title="Type in a name to begin search">
                                        <div style="min-height:450px; height:450px; overflow-y: scroll;">
                                            <?php getBranchesList(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card" style="border-left: 6px solid #43a047;">
                                    <div class="card-content">
                                        <h5 class="header uppercase">
                                        <?php number_format(getNumberUsers()); ?> Users <br>
                                            <small>Use the quick filter to search through users list</small>
                                        </h5>
                                        <input type="text" id="ufInput" onkeyup="ufFunction()" placeholder="Search for names..." title="Type in a name to begin search">
                                        <div style="min-height:450px; height:450px; overflow-y: scroll;">
                                            <?php getUserssList(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--card widgets end-->
                
                </div>
            </div>

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
        header("Location: ./");
    }
} else {
  header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>