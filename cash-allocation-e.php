<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/cash-allocation.php';
include 'app/core/session.php';
$pagename = 'Update Cash Allocation';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() || $session->isCPA() ||  $session->isCPS() || $session->isTreasuryOfficer() || $session->isTreasurySup() ) {
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

            // Fetch Cash Allocation Record
            $currencyIcon = '';
            $sql = "SELECT * FROM cash_allocations WHERE ca_id = '$get_id' ";
            $result = $con->query($sql);
            if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $bUID = $row['ca_id'].'------'.$row['allocated_by'].'------el';
                    $caUID = base64_encode($bUID);
                    $clientName             = $row['client_name'];
                    $allocatedBy            = $row['allocated_by'];
                    $allocatedOn            = $row['allocated_on'];
                    $amountAllocated        = $row['amount_allocated'];
                    $amountReturned         = $row['amount_returned'];
                    $cashDifference         = $row['difference'];
                    $sealNumber             = $row['seal_number'];
                    $auditTrailNumber       = $row['audit_trail_number'];
                    $currency_id            = $row['currency_id'];
                    $allocatedTo            = $row['allocated_to'];
                    $returnedBy             = $row['returned_by'];
                    $returnedOn             = $row['returned_on'];
                    $workstation            = $row['workstation'];
                    $caShift                = $row['ca_shift'];
                    $ca_comment             = $row['ca_comment'];
                    // Get Teller Data 
                    $getTellerData          = $database->getUserInfo($row['allocated_to']);
                    $tellerFullName         = $getTellerData['surname'].' '.$getTellerData['firstname'].' '.$getTellerData['middlename'];
                    $tellerId               = $getTellerData['username'].'------'.$getTellerData['email'].'------el';
                    $tellerUID              = base64_encode($tellerId);
                    // Get Returnee Data 
                    $getReturneeData        = $database->getUserInfo($row['returned_by']);
                    $returneeFullName       = $getReturneeData['surname'].' '.$getReturneeData['firstname'].' '.$getReturneeData['middlename'];
                    $returneeId             = $getReturneeData['username'].'------'.$getReturneeData['email'].'------el';
                    $returneeUID            = base64_encode($returneeId);
                    // Get Allocator Data
                    $getAllocatorData       = $database->getUserInfo($row['allocated_by']);
                    $allocatorFullName      = $getAllocatorData['surname'].' '.$getAllocatorData['firstname'].' '.$getAllocatorData['middlename'];
                    $allocatorId            = $getAllocatorData['username'].'------'.$getAllocatorData['email'].'------el';
                    $allocatorUID           = base64_encode($tellerId);
                    //Split and get main seal number
                    $sealPieces             = explode("-", $row['seal_number']);
                    $tymeStamp              = $sealPieces[0];
                    $sealNumber             = $sealPieces[1];
                    //get denomination
                    $reqDenomination        = getDenominationById($row['denomination_id']);
                    $denomination           = $reqDenomination['denomination_name'];
                    // Get ReturnedBy Data
                    $getReturnedByData      = $database->getUserInfo($row['returned_by']);
                    $returnedByFullName     = $getReturnedByData['surname'].' '.$getReturnedByData['firstname'].' '.$getReturnedByData['middlename'];
                    $returnedById           = $getReturnedByData['username'].'------'.$getReturnedByData['email'].'------el';
                    $returnedByUID          = base64_encode($tellerId);
                    // Get Currencies
                    $getCurrency            = getCurrencyById($currency_id);
                    $currency_slug          = $getCurrency['currency_slug'];
                    if ($currency_slug == 'naira') {
                        $currencyIcon = '<small>&#8358;</small>';
                    } else if ($currency_slug == 'euro') {
                        $currencyIcon = '<small>&euro;</small>';
                    } else if ($currency_slug == 'gbp') {
                        $currencyIcon = '<small>&#163;</small>';
                    } else if ($currency_slug == 'usd') {
                        $currencyIcon = '<small>&#36;</small>';
                    } else if ($currency_slug == 'cny') {
                        $currencyIcon = '<small>&#165;</small>';
                    } else if ($currency_slug == 'cfa') {
                        $currencyIcon = '<small>CFA</small>';
                    } else if ($currency_slug == 'zar') {
                        $currencyIcon = '<small>R</small>';
                    }
                }
            }  
        } else {
            header("Location: cash-allocation");
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
                    <li><a href="cash-allocation">Cash Allocations</a></li>
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
                                <a href="cash-allocation" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">


                    <div class="row">
                        <div class="col l8 m8 s12">
                            <div class="card">
                                <div class="card-content" style="min-height: 600px;">

                                    <div id="loadBage">
                                        <?php
                                            $total_amount_allocated = 0;
                                            $sql = " SELECT * FROM sealings WHERE seal_number = '1545563524-000010' ";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $total_amount           = $row['amount'];  
                                                    
                                                    // Check If Amount Has Been Exhausted
                                                    if ( $row['total_amount_allocated'] >= $total_amount) {
                                                        echo 'allDone';
                                                    } else {
                                                        echo '<div class="card">
                                                            <div class="card-content">
                                                                <div class="row center">
                                                                    <div class="col s12">
                                                                        <h4 class="card-stats-number">' . $row['client'] . '</h4>
                                                                        <input type="hidden" id="clientName" value="' . $row['client'] . '">
                                                                        <input type="hidden" id="dSealNUmber" value="' . $qSealNumber . '">
                                                                        <input type="hidden" id="sealNumberId" value="' . $row['s_id'] . '">
                                                                    </div>
                                                                </div>
                                                                <div class="row center">
                                                                    <div class="col l2 m2 s12">
                                                                        <h4 class="card-stats-number"> <small>Denomination:</small> <br> ' . number_format($denomination) . ' </h4>
                                                                        <input type="hidden" id="denominationId" value="' . $row['denomination_id'] . '">
                                                                        <input type="hidden" id="currencyId" value="' . $row['currency_id'] . '">
                                                                    </div>
                                                                    <div class="col l4 m4 s12">
                                                                        <h4 class="card-stats-number"> <small>Total Amount: <br> <strong class="teal-text">'.$currencyIcon.'</small>' . number_format($total_amount) . '</strong></h4>
                                                                        <input type="hidden" id="maxAmount" value="' . $total_amount . '">
                                                                    </div>
                                                                    <div class="col l4 m4 s12">
                                                                        <h4 class="card-stats-number"> <small>Amount Allocated: <br> '.$currencyIcon.'</small><strong class="red-text" id="amountAllokated">' . number_format($row['total_amount_allocated']) . '</strong></h4>
                                                                        <input type="hidden" id="amountAllocated">
                                                                        <input type="hidden" id="totalAmountAlloactedBeforeNow" value="' . $row['total_amount_allocated'] . '">
                                                                    </div>
                                                                    <div class="col l2 m2 s12">
                                                                        <h4 class="card-stats-number"> <small>Allocated To: <br></small> <strong>' . number_format($row['total_processors']) . ' <small>Processor(s)</small></strong></h4>
                                                                        <input type="hidden" id="totalProcessorsBeforeNow" value="' . $row['total_processors'] . '">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                    }
                                                }
                                            } else {
                                                echo 'nodey';
                                            }
                                        ?>
                                    </div>

                                    <div id="assignment" class="card">
                                        <div class="card-content">
                                            <h4 class="header center blue-grey-text">Cash Allocation Form </h4>
                                            <div class="row margin">
                                                <div class="input-field col l6 m6 s12">
                                                    <select id="allocatedTo" required>
                                                        <option value="<?php echo $allocatedTo; ?>"><?php echo $tellerFullName; ?></option>
                                                        <?php getProcessors(); ?>
                                                    </select>
                                                    <label>Processor (Teller)</label>
                                                </div>
                                                <div class="input-field col l6 m6 s12">
                                                    <select id="workstation" required>
                                                        <option value="<?php echo $workstation; ?>"><?php echo $workstation; ?></option>
                                                        <?php getWorkStationLists(); ?>
                                                    </select>
                                                    <label>Processor's Work Station</label>
                                                </div>
                                            </div>
                                            <div class="row margin">
                                                <div class="input-field col l4 m4 s12">
                                                    <input type="text" id="allocatedCash" placeholder="Enter The Amount Of Cash Being Allocated">
                                                    <label for="assignedCash">Allocate Cash</label>
                                                    <h5 class="blue-grey-text amountAllocated"></h5>
                                                    <input type="hidden" id="shift" value="<?php echo $yourCurrentShift; ?>">
                                                </div>
                                                <div class="col l8 m8 s12">
                                                    <div class="right" style="margin-top: 30px;">
                                                        <button class="btn waves-effect waves-light teal white-text saveCashAllocation">
                                                            <i class="material-icons left">save</i>
                                                            Allocate Cash To <span id="allocatee"><?php echo $allocatedTo; ?></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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

    <script type="text/javascript" src="assets/js/pages/cash-allocation.js"></script>

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