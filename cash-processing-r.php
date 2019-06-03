<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/cash-allocation.php';
include 'app/core/session.php';
$pagename = 'Viewing Cash Processing';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin()) {
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

            // Fetch Cash Processing Record
            $currencyIcon = '';
            $amountProcessed = 0;
            $sql = "SELECT * FROM cash_allocations WHERE ca_id = '$get_id' ";
            $result = $con->query($sql);
            if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $bUID = $row['ca_id'].'------'.$row['allocated_by'].'------el';
                    $caUID = base64_encode($bUID);
                    $clientId               = $row['client_name'];
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
                    $is_fit                 = $row['is_fit'];
                    $is_unfit               = $row['is_unfit'];
                    $is_atm                 = $row['is_atm'];
                    $fakenotes              = $row['fakenotes'];
                    $shortage               = $row['shortage'];
                    $post_sorting_value     = $row['post_sorting_value'];
                    $declared_value         = $row['declared_value'];
                    $counted_value          = $row['counted_value'];
                    $cp_comment             = $row['comment'];
                    // Get Amount Processed
                    $amountProcessed = $is_fit + $is_atm + $is_unfit + $fakenotes + $shortage + $post_sorting_value;
                    //get client name
                    $reqClientName          = getClientNameById($clientId);
                    $clientName             = $reqClientName['bank_name'];
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
                    // Get Eviden
                    if ( $row['evidence'] != '' ) {
                        $evidence = '<img src="assets/images/attachments/'.$row['evidence'].'" />';
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
                    <li><a href="cash-processing">Cash Processings</a></li>
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
                                <a href="cash-processing" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a> &nbsp; &nbsp; 
                                <a href="cash-processing-r?r=<?php echo $row['ca_id'] . 'cprf' . $caUID; ?>" class="btns btns-read waves-effect waves-light" style="color: teal !important"><i class="material-icons left">refresh</i> Refresh </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                            
                                    <h6 class="header uppercase center blue-grey-text">
                                        Cash Allocated To: <?php echo '<a href="profile?r=' . $allocatedTo.'cprf'.$tellerUID . '" target="_blank" style="color: #4f2323 !important;">' . $tellerFullName . '</a>'; ?>
                                    </h6>

                                    <div class="row">
                                        <div class="col l6 m6 s12">
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">business</i> Client Name
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $clientName; ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">person</i> Cash Allocated By
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<a href="profile?r=' . $allocatedBy.'cprf'.$allocatorUID . '" target="_blank" style="color: #4f2323 !important;">' . $allocatorFullName . '</a>'; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">access_time</i> Cash Allocated On
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo timestamp($allocatedOn); ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">access_alarm</i> Audit Trail Number
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $auditTrailNumber; ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">label</i> Seal Number
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $sealNumber; ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">label</i> Cash Denomination
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo number_format($denomination); ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">account_balance_wallet</i> Amount Allocated
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $currencyIcon.number_format($amountAllocated); ?></div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">person</i> Cash Allocated To
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<a href="profile?r=' . $allocatedTo.'cprf'.$tellerUID . '" target="_blank" style="color: #4f2323 !important;">' . $tellerFullName . '</a>'; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">airplay</i> Working
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $caShift; ?> Shift</div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">airplay</i> Workstation
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $workstation; ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">account_balance_wallet</i> Cash Returned
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $currencyIcon.number_format($amountReturned); ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">account_balance_wallet</i> Cash Difference (Exception)
                                                        </div>
                                                        <div class="col s6 right-align strong"><?php echo $currencyIcon.number_format($cashDifference); ?></div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">label</i> Cash Returned By
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<a href="profile?r=' . $returnedBy.'cprf'.$returneeUID . '" target="_blank" style="color: #4f2323 !important;">' . $returneeFullName . '</a>'; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">access_alarm</i> Returned On
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php 
                                                                if ( $returnedOn != '' ) {
                                                                    echo timestamp($returnedOn);
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">chat</i> Teller's Comment
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo $ca_comment; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col l6 m6 s12">
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Fit Notes
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($is_fit) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Unfit Notes
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($is_fit) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> ATM Notes
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($is_atm) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Fake Notes
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($fakenotes) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Shortages
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($is_fit) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Post Sorting Value
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($post_sorting_value) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Declared Value
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($declared_value) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Counted Value
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($counted_value) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">attach_file</i> Attachement
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo $cp_comment; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">chat</i> Cash Processor's Comment
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo $cp_comment; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col s12">
                                            <div class="right">
                                                <button data-target="processCash" style="margin: 6px !important;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger uppercase"> <i class="material-icons right">send</i> Process Cash Returned By  <?php echo $tellerFullName ; ?> </button>
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
    <div id="processCash" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Process Cash Returned By <strong><?php echo $tellerFullName; ?></strong></h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <h6>&nbsp;</h6>
                <input type="hidden" id="caId" value="<?php echo $get_id; ?>">
                <input type="hidden" id="returnedBy" value="<?php echo $allocatedTo; ?>">
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="amountReturned" name="amountReturned" type="text" class="validate" required autocomplete="off">
                        <label for="amountReturned">Amount Returned</label>
                    </div>
                </div>
                <div class="row margin">
                    <input type="hidden" id="expAmount" value="<?php echo $amountAllocated; ?>">
                    <div class="col l6 m6 s12">
                        <h4 class="uppercase center">
                            <small>Amount Allocated: </small><br>
                            <span class="black-text bold"><?php echo $currencyIcon.number_format($amountAllocated); ?></span>
                        </h4>
                    </div>
                    <div class="col l6 m6 s12">
                        <h4 class="uppercase center">
                            <small>Amount Processed: </small><br>
                            <span class="teal-text bold"><?php echo $currencyIcon.number_format($amountProcessed); ?></span>
                        </h4>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <textarea name="comment" id="comment" placeholder="Enter Commenst/Observations Here" class="materialize-textarea" cols="30" rows="1"></textarea>
                        <label for="difference">Comment</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text saveCashReturned mr-3">
                <i class="material-icons left">save</i>
                Save 
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