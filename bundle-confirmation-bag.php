<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/bundle-confirmation.php';
include 'app/core/session.php';
$pagename = 'Bags';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isCPA() ||  $session->isCPS() || $session->isTreasuryOfficer() || $session->isTreasurySup() ) {
        if (isset($_GET['r'])) {
            $get_req = $_GET['r'];
            // Pieces GR
            $piecesgr = explode("cprf", $get_req);
            $clientId = $piecesgr[0];
            $get_uid = $piecesgr[1];
            // DeCrypt back uid
            $decrypted = base64_decode($get_uid);
            //Explode get value
            $piecesDecrypted = explode("------", $decrypted);
            $get_id = $piecesDecrypted[0];
            $get_client = $piecesDecrypted[1];
            $get_client_id = $piecesDecrypted[2];            
            $get_stream = $piecesDecrypted[3];            
        } else {
            header("Location: bundle-confirmation");
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
                  <h5 class="breadcrumbs-title"><?php echo $pagename; ?></h5>
                  <ol class="breadcrumbs">
                    <li><a href="./">Dashboard</a></li>
                    <li><a href="bundle-confirmation">Bundle Confirmations</a></li>
                    <li class="active"><?php echo $get_client; ?> </li>
                    <li class="active"><?php echo $pagename; ?> </li>
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
                    <a href="bundle-confirmation" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a>
                  </div>
                </div>
              </div>

                <div class="row">

                    <div class="col l3 m3 s12">
                        <div class="card">
                            <div class="card-content">

                                <h5 class="uppercase blue-grey-text header">Confirmed Bags</h5>
                                <?php
                                    $status = '';
                                    $sql = "SELECT * FROM bundleconfirmationbags WHERE bundleconfirmation_id = '$get_id' ORDER BY id DESC";
                                    $result = $con->query($sql);
                                    if ($result->num_rows > 0) {
                                        $totalBags = 0;
                                        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                        echo '<thead>
                                                <tr>
                                                    <th>Seal Number</th>
                                                    <th>Amount Confirmed</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Seal Number</th>
                                                    <th>Amount Confirmed</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>';
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            //Split and get main seal number
                                            $sealPiecex   = explode("-", $row['seal_number']);
                                            $sealNumba   = $sealPiecex[1];
                                            // Get Currency Icon
                                            $currencyIcon = currencyIcon($row['currency']);
                                            echo '<tr>
                                                <td>' . $sealNumba . '</td>
                                                <td>' . $currencyIcon . number_format($row['amount']) . '</td>
                                            </tr>';
                                        }
                                        echo '</tbody>
                                        </table>';
                                    } else {
                                        echo 'No consignment has been confirmed for this batch.';
                                    }
                                ?>
                                <h5 class="uppercase blue-grey-text header">Category ID &amp; Name</h5>
                                <div class="row">
                                    <div class="col s12">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Category ID</th>
                                                    <th>Category Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td>1</td><td>Mint</td></tr>
                                                <tr><td>2</td><td>Unfit Notes</td></tr>
                                                <tr><td>3</td><td>ATM Fit Notes</td></tr>
                                                <tr><td>4</td><td>Teller Fit Notes</td></tr>
                                                <tr><td>5</td><td>Mutilated Notes</td></tr>
                                                <tr><td>6</td><td>Awaiting Evaluation (Unprocessed)</td></tr>
                                                <tr><td>7</td><td>Awaiting Evaluation (Vault)</td></tr>
                                                <tr><td>8</td><td>Awaiting Evaluation (Processing Floor)</td></tr>
                                                <tr><td>9</td><td>Others</td></tr>
                                                <tr><td>10</td><td>AC Awaiting Confirmation</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col l4 m4 s12">
                        <div class="card">
                            <div class="card-content" style="min-height: 650px;">
                                <div class="row margin" id="sealRow">
                                    <div class="input-field col l10 m10 s10">
                                        <small>Seal Number</small>
                                        <select id="qSealNumber" class="searchableSelect">
                                            <option value="">Select Seal Number</option>
                                            <?php getListOfSealNUmbersNotBundleConfirmed($signed_location_id); ?>
                                        </select>
                                    </div>
                                    <div class="input-field col l2 m2 s2 loadingData"></div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="hidden" id="branchId" required readonly>
                                    </div>
                                </div>

                                <h6>&nbsp;</h6>
                                
                                <div class="row">
                                    <div class="col s12">
                                        <div id="loadBag"></div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col s12">
                                        <div class="right">
                                            <button class="btn white  teal-text waves-effect waves-teal beginBc">
                                                <i class="material-icons right">arrow_forward</i> Proceed
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col l5 m5 s12">
                        <div class="card">
                            <div class="card-content" style="min-height: 650px;">
                                <h4 class="header blue-grey-text center uppercase">Bag Confirmation</h4>
                                <form id="bcForm">

                                    <div id="bcFormElementz"></div>

                                    <div class="row">
                                        <div class="input-field col l4 m4 s6">
                                            <small>Currency</small>
                                            <select id="currencyId" class="searchableSelect">
                                                <?php getCurrencyTypesList(); ?>
                                            </select>
                                        </div>
                                        <div class="input-field col l8 m8 s12">
                                            <textarea name="bundleConfirmationComment" id="bundleConfirmationComment" placeholder="Enter Commenst/Observations Here" class="materialize-textarea" cols="30" rows="1"></textarea>
                                            <label for="bundleConfirmationComment">Comment</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col l5 m5 s12">
                                            <button class="btns white waves-effect waves-light teal-text computeAmount glowingBtn">
                                                <i class="material-icons left">functions</i>
                                                Get Total Amount 
                                            </button>
                                        </div>
                                        <div class="col s12 center">
                                            <input type="hidden" id="totalAmount">
                                            <h5 class="blue-grey-text totalAmount"></h5>
                                        </div>
                                    </div>
                                    <h1>&nbsp;</h1>
                                </form>
                                <div class="row">
                                    <div class="col s12">
                                        <div id="showErrorInAmountEntered"></div>
                                    </div>
                                </div>
                                <div class="row margin" style="margin-top: 50px;">
                                    <div class="col l5 m5 s12">
                                        <button data-target="throwExc" id="throwExcept" class="btns btns-delete waves-effect waves-light white-text teBtn modal-trigger">
                                            <i class="material-icons left">money_off</i>
                                            Flag This Bag 
                                        </button>
                                    </div>
                                    <div class="col l7 m5 s12">
                                        <div class="right">
                                            <input type="hidden" name="bcStream" id="bcStream" value="<?php echo $get_stream; ?>">
                                            <input type="hidden" name="bcsId" id="bcsId" value="<?php echo $get_id; ?>">
                                            <input type="hidden" name="clientId" id="clientId" value="<?php echo $clientId; ?>">
                                            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                                            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                                            <button class="btn teal white-text waves-effect waves-teal confirmThisBag">
                                                <i class="material-icons left">save</i> Confirm Bag Content
                                            </button>
                                        </div>
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

    <!-- Start Modal -->
    <div id="throwExc" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Throw An Exception</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding. Use The Form Below To Report Any Issue With The Content Of The Bag You Are Confirming</p>
            </div>
            <div class="modal-body">
                <h6>&nbsp;</h6>
                <input type="hidden" name="exceptionsealnumber" id="exceptionsealnumber">
                <div class="row margin">
                    <div class="input-field col l5 m5 s12">
                        <select  class="searchableSelect" id="supo">
                            <option value="">Select Your Supervisor's Name</option>
                            <?php getUsersList(); ?>
                        </select>
                    </div>
                    <div class="input-field col l5 m5 s12">
                        <select id="currenc">
                            <?php getCurrencyTypesList(); ?>
                        </select>
                        <label>Currency</label>
                    </div>
                    <div class="input-field col l2 m2 s12">
                        <select id="denom">
                            <?php getDenominationTypesList(); ?>
                        </select>
                        <label>Denomination</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s12">
                        <input id="expectedAmount" type="text" class="validate">
                        <label for="expectedAmount">Expected Amount </label>
                        <h5 class="blue-grey-text bold" id="showExpectedAmount"></h5>
                    </div>
                    <div class="input-field col l6 m6 s12">
                        <input id="actualAmount" type="text" class="validate">
                        <label for="actualAmount">Actual Amount</label>
                        <h5 class="blue-grey-text bold" id="showActualAmount"></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="thrownComment" class="materialize-textarea validate"></textarea>
                        <label for="expectedAmount">Your Reasons </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text addException mr-3">
                <i class="material-icons right">send</i>
                Send Exception 
            </button>
        </div>
    </div>


    <?php include 'layouts/foot.php'; ?>

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/bundle-confirmation.js"></script>

    <script>
        $("#confBtn").hide()
        $(".beginBc").attr('disabled', 'disabled');
        $(".computeAmount").attr('disabled', 'disabled');
        $("#currencyId").attr('disabled', 'disabled');
        $("#bundleConfirmationComment").attr('disabled', 'disabled');
        $(".teBtn").attr('disabled', 'disabled');
        $(".confirmThisBag").attr('disabled', 'disabled');
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