<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/cash-allocation.php';
include 'app/core/session.php';
$pagename = 'Viewing Cash Processing';
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

            // Fetch Cash Processing Record
            $currencyIcon = $mixups = $mn1000 =  $mn500 =  $mn200 =  $mn100 =  $mn50 =  $mn20 =  $mn10 =  $mn5 =  $mn1 = '' ;
            $amountProcessed = $mixup = $m1000 = $m500 = $m200 = $m100 = $m50 = $m20 = $m10 = $m5 = $m1 = $fakenotes = $is_atm = $is_fit = $is_unfit = 0;
            $sql = "SELECT * FROM cashallocations WHERE id = '$get_id' ";
            $result = $con->query($sql);
            if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $bUID = $row['id'].'------'.$row['allocated_by'].'------el';
                    $caUID = base64_encode($bUID);
                    $clientId               = $row['client_name'];
                    $allocatedBy            = $row['allocated_by'];
                    $allocatedOn            = $row['allocated_on'];
                    $amountAllocated        = $row['amount_allocated'];
                    $amountReturned         = $row['amount_returned'];
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
                    $shortage               = $row['shortage'];
                    $declared_value         = $row['declared_value'];
                    $cp_comment             = $row['comment'];
                    $attachFile             = $row['evidence'];
                    $mixup                  = $row['mixups'];
                    $m1000                  = $row['m1000'];
                    $m500                   = $row['m500'];
                    $m200                   = $row['m200'];
                    $m100                   = $row['m100'];
                    $m50                    = $row['m50'];
                    $m20                    = $row['m20'];
                    $m10                    = $row['m10'];
                    $m5                     = $row['m5'];
                    $m1                     = $row['m1'];
                    $fake_notes             = $row['fake_notes'];
                    $fake_serial_numbers    = $row['fake_serial_numbers'];
                    //get denomination
                    $reqDenomination        = getDenominationById($row['denomination_id']);
                    $denomination           = $reqDenomination['name'];
                    // Get All Mixup Note Denomination
                    if ( $m1000 > 0 ) { $mn1000 = '1,000'; }
                    if ( $m500 > 0 ) { $mn500 = '500'; }
                    if ( $m200 > 0 ) { $mn200 = '200'; }
                    if ( $m100 > 0 ) { $mn100 = '100'; }
                    if ( $m50 > 0 ) { $mn50 = '50'; }
                    if ( $m20 > 0 ) { $mn20 = '20'; }
                    if ( $m10 > 0 ) { $mn10 = '10'; }
                    if ( $m5 > 0 ) { $mn5 = '5'; }
                    if ( $m1 > 0 ) { $mn1 = '1'; }
                    $mixups = $mn1000 . ' &nbsp; &nbsp; ' .  $mn500 . ' &nbsp; &nbsp; ' .  $mn200 . ' &nbsp; &nbsp; ' .  $mn100 . ' &nbsp; &nbsp; ' .  $mn50 . ' &nbsp; &nbsp; ' .  $mn20 . ' &nbsp; &nbsp; '  .  $mn10 . ' &nbsp; &nbsp; ' .  $mn5 . ' &nbsp; &nbsp; ' .  $mn1 ;

                    /* Cash Processing */
                    // Get Fake Notes Value
                    $fakeNotesValue = $fake_notes * $denomination;
                    // Get Mixups Value
                    $mixupsValue = $mixup * $denomination;
                    // Get Sum Of Mixup Values
                    $sumMixupsValues = $m1000 + $m500 + $m200 + $m100 + $m50 + $m20 + $m10 + $m5 + $m1;
                    // Get Counted Value
                    $countedValue = $is_fit + $is_unfit + $is_atm;
                    // Get PreCount Shortage
                    $preCountShortage = $declared_value - $countedValue;
                    // Get Inverse Of Pre Count Shortage
                    $negatePreCountShortage = $countedValue - $declared_value;
                    // Get Sorting Shortage
                    $sortingShortage = ( $fakeNotesValue + $mixupsValue ) - $sumMixupsValues;
                    // Get Post Sorting Shortage
                    $postSortingShortage = $sortingShortage + $preCountShortage;
                    // Get Post Sorting Value
                    $postSortingValue = $declared_value - $postSortingShortage;

                    //get client name
                    $reqClientName          = getClientNameById($clientId);
                    $clientName             = $reqClientName['bank_name'];
                    // Get Teller Data 
                    $getTellerData          = $database->getUserInfo($allocatedTo);
                    $tellerFullName         = $getTellerData['surname'].' '.$getTellerData['firstname'].' '.$getTellerData['middlename'];
                    $tellerId               = $getTellerData['username'].'------'.$getTellerData['email'].'------el';
                    $tellerUID              = base64_encode($tellerId);
                    // Get Returnee Data 
                    $getReturneeData        = $database->getUserInfo($returnedBy);
                    $returneeFullName       = $getReturneeData['surname'].' '.$getReturneeData['firstname'].' '.$getReturneeData['middlename'];
                    $returneeId             = $getReturneeData['username'].'------'.$getReturneeData['email'].'------el';
                    $returneeUID            = base64_encode($returneeId);
                    // Get Allocator Data
                    $getAllocatorData       = $database->getUserInfo($allocatedBy);
                    $allocatorFullName      = $getAllocatorData['surname'].' '.$getAllocatorData['firstname'].' '.$getAllocatorData['middlename'];
                    $allocatorId            = $getAllocatorData['username'].'------'.$getAllocatorData['email'].'------el';
                    $allocatorUID           = base64_encode($tellerId);
                    //Split and get main seal number
                    $sealPieces             = explode("-", $row['seal_number']);
                    $tymeStamp              = $sealPieces[0];
                    $sealNumber             = $sealPieces[1];
                    // Get ReturnedBy Data
                    $getReturnedByData      = $database->getUserInfo($returnedBy);
                    $returnedByFullName     = $getReturnedByData['surname'].' '.$getReturnedByData['firstname'].' '.$getReturnedByData['middlename'];
                    $returnedById           = $getReturnedByData['username'].'------'.$getReturnedByData['email'].'------el';
                    $returnedByUID          = base64_encode($tellerId);
                    // Get Currencies
                    $getCurrency            = getCurrencyById($currency_id);
                    $currency_slug          = $getCurrency['slug'];
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
                        $evidence = '<img src="assets/images/attachments/'.$row['evidence'].'" width="100%" />';
                    } else {
                        $evidence = '<img src="assets/images/attachments/noimage.png" width="100%" />';
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
                    <li><a href="cash-allocation">Cash Allocations & Processing</a></li>
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
                                <a href="cash-allocation" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a> &nbsp; &nbsp; 
                                <a href="cash-allocation-r?r=<?php echo $row['id'] . 'cprf' . $caUID; ?>" class="btns btns-read waves-effect waves-light" style="color: teal !important"><i class="material-icons left">refresh</i> Refresh </a>
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
                                                            <i class="material-icons left">note</i> Mixup Notes
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo $mixups ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Mixup Value
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($mixupsValue) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Fake Notes
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo number_format($fake_notes) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Fake Notes Value
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($fakeNotesValue) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Sum Mixup Values
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($sumMixupsValues) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Pre-Count Shortage
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($preCountShortage) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Sorting Shortage
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($sortingShortage) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Post Sorting Shortage
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($postSortingShortage) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            <i class="material-icons left">note</i> Post Sorting Value
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($postSortingValue) ; ?>
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
                                                            <?php echo '<small>' . $currencyIcon . '</small>' . number_format($countedValue) ; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col l3 m3 s12">
                                                            <i class="material-icons left">attach_file</i> Attachment
                                                        </div>
                                                        <div class="col l9 m9 s12 right-align strong show-image">
                                                            <span id="fileImg"><?php echo $evidence; ?></span>
                                                            <button data-target="uploadFile" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger uppercase update"> <i class="material-icons left">file_upload</i> Upload </button>
                                                            <input type="hidden" id="fileToDownload" value="<?php echo $attachFile; ?>">
                                                            <button class="btns btns-read teal-text waves-effect waves-light triggerBtn uppercase download downloadFile"> <i class="material-icons left">cloud_download</i> View &amp; Download </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="right">
                                                        <button data-target="processCash" style="margin: 6px !important;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger uppercase"> <i class="material-icons right">send</i> Process Cash Returned By  <?php echo $tellerFullName ; ?> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
                                                        <div class="col s6 right-align strong"><?php echo $currencyIcon.number_format($countedValue); ?></div>
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
                                                            <i class="material-icons left">chat</i> Cash Processor's Comment
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
                                                            <i class="material-icons left">chat</i> Teller's Comment
                                                        </div>
                                                        <div class="col s6 right-align strong">
                                                            <?php echo $ca_comment; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <?php if( $row['returned_user'] == '' ) { ?>
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="right">
                                                        <button data-target="returnCashAllocated" style="margin: 6px !important;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger uppercase"> <i class="material-icons right">send</i> Returned Cash Allocated To  <?php echo $tellerFullName ; ?> </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            
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
                <input type="hidden" id="denomination" value="<?php echo $denomination; ?>">
                <div class="row margin">
                    <div class="input-field col l3 m3 s12">
                        <input id="fit" name="fit" type="text" class="validate" value="<?php echo $is_fit ;?>" required autocomplete="off">
                        <label for="fit">Fit Notes &nbsp; <span id="fitnotes"></span></label>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <input id="unfit" name="unfit" type="text" class="validate" value="<?php echo $is_unfit ;?>" required autocomplete="off">
                        <label for="unfit">Unfit Notes &nbsp; <span id="unfitnotes"></span></label>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <input id="atm" name="atm" type="text" class="validate" value="<?php echo $is_atm ;?>" required autocomplete="off">
                        <label for="atm">ATM Notes &nbsp;  <span id="atmnotes"></span></label>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <input id="shortage" name="shortage" type="text" class="validate" value="<?php echo $preCountShortage ;?>" required autocomplete="off" readonly>
                        <label for="shortage">Pre-Count Shortage &nbsp;  <span id="shortagenotes"></span></label>
                    </div>
                </div>
                <h6>&nbsp;</h6>
                <div class="row margin">
                    <div class="input-field col l3 m3 s6">
                        <input id="mixup" name="mixup" type="text" class="validate" value="<?php echo $mixup ;?>" required autocomplete="off">
                        <label for="mixup">Mixup Notes &nbsp;  <span id="mixups"></span></label>
                    </div>
                    <div class="input-field col l3 m3 s6">
                        <input id="m1000" name="m1000" type="text" class="validate" value="<?php echo $m1000 ;?>" required autocomplete="off">
                        <label for="m1000">Mixup 1,000 &nbsp;  <span id="m1000s"></span></label>
                    </div>
                    <div class="input-field col l2 m2 s4">
                        <input id="m500" name="m500" type="text" class="validate" value="<?php echo $m500 ;?>" required autocomplete="off">
                        <label for="m500">Mixup 500 &nbsp;  <span id="m500s"></span></label>
                    </div>
                    <div class="input-field col l2 m2 s4">
                        <input id="m200" name="m200" type="text" class="validate" value="<?php echo $m200 ;?>" required autocomplete="off">
                        <label for="m200">Mixup 200 &nbsp;  <span id="m200s"></span></label>
                    </div>
                    <div class="input-field col l2 m2 s4">
                        <input id="m100" name="m100" type="text" class="validate" value="<?php echo $m100 ;?>" required autocomplete="off">
                        <label for="m100">Mixup 100 &nbsp;  <span id="m100s"></span></label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col l3 m3 s6">
                        <input id="m50" name="m50" type="text" class="validate" value="<?php echo $m50 ;?>" required autocomplete="off">
                        <label for="m50">Mixup 50 &nbsp;  <span id="m50s"></span></label>
                    </div>
                    <div class="input-field col l3 m3 s6">
                        <input id="m20" name="m20" type="text" class="validate" value="<?php echo $m20 ;?>" required autocomplete="off">
                        <label for="m20">Mixup 20 &nbsp;  <span id="m20s"></span></label>
                    </div>
                    <div class="input-field col l2 m2 s4">
                        <input id="m10" name="m10" type="text" class="validate" value="<?php echo $m10 ;?>" required autocomplete="off">
                        <label for="m10">Mixup 10 &nbsp;  <span id="m10s"></span></label>
                    </div>
                    <div class="input-field col l2 m2 s4">
                        <input id="m5" name="m5" type="text" class="validate" value="<?php echo $m5 ;?>" required autocomplete="off">
                        <label for="m5">Mixup 5 &nbsp;  <span id="m5s"></span></label>
                    </div>
                    <div class="input-field col l2 m2 s4">
                        <input id="m1" name="m1" type="text" class="validate" value="<?php echo $m1 ;?>" required autocomplete="off">
                        <label for="m1">Mixup 1 &nbsp;  <span id="m1s"></span></label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col l2 m2 s3">
                        <input id="fakenotes" name="fakenotes" type="text" class="validate" value="<?php echo $fake_notes ;?>" required autocomplete="off">
                        <label for="fakenotes">Fake Notes &nbsp;  <span id="fakenotess"></span></label>
                    </div>
                    <div class="input-field col l10 m10 s9" id="tagsn">
                        <input id="fakenotesSerialNumbers" name="fakenotesSerialNumbers" type="text" class="validate" value="<?php echo $fake_serial_numbers ;?>" required autocomplete="off" placeholder="Seperate Each Serial Number With Comma">
                    </div>
                </div>
                <input id="declaredValue" name="declaredValue" type="hidden" class="validate" required readonly autocomplete="off" value="<?php echo $amountAllocated ; ?>">
                <input id="countedValue" name="countedValue" type="hidden" class="validate" required readonly autocomplete="off" value="0">
                <h6>&nbsp;</h6>
                <div class="row margin">
                    <div class="col s12 center">
                        <button class="btn waves-effect waves-light white teal-text getAmountProcessed glowingBtn">
                            <i class="material-icons left">functions</i>
                            Compute Values
                        </button>
                    </div>
                </div>
                <div class="row margin">
                    <div class="col l4 m4 s12">
                        <h4 class="uppercase center">
                            <small>Declared Value: </small><br>
                            <span class="black-text bold"><?php echo $currencyIcon.number_format($amountAllocated); ?></span>
                        </h4>
                    </div>
                    <div class="col l4 m4 s12">
                        <h4 class="uppercase center">
                            <small>Counted Value: </small><br>
                            <span class="teal-text bold"><?php echo $currencyIcon; ?><span class="amountCounted"><?php echo  number_format($countedValue); ?></span></span>
                        </h4>
                    </div>
                    <div class="col l4 m4 s12">
                        <h5 class="uppercase center">
                            <small>Pre-Count Shortage: </small><br>
                            <span class="orange-text bold"><?php echo $currencyIcon; ?><span class="preCountShortage"><?php echo  number_format($preCountShortage); ?></span></span>
                        </h5>
                    </div>
                </div>
                <div class="row margin">
                    <div class="col l4 m4 s12">
                        <h5 class="uppercase center">
                            <small>Sorting Shortage: </small><br>
                            <span class="orange-text bold"><?php echo $currencyIcon; ?><span class="sortingShortage"><?php echo  number_format($sortingShortage); ?></span></span>
                        </h5>
                    </div>
                    <div class="col l4 m4 s12">
                        <h4 class="uppercase center">
                            <small>Post Sorting Shortage: </small><br>
                            <span class="teal-text bold"><?php echo $currencyIcon; ?><span class="postSortingShortage"><?php  echo number_format($postSortingShortage); ?></span></span>
                        </h4>
                    </div>
                    <div class="col l4 m4 s12">
                        <h4 class="uppercase center">
                            <small>Post Sorting Value: </small><br>
                            <span class="teal-text bold"><?php echo $currencyIcon; ?><span class="postSortingValue"><?php echo number_format($postSortingValue); ?></span></span>
                        </h4>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <textarea name="cpComment" id="cpComment" placeholder="Enter Commenst/Observations Here" class="materialize-textarea" cols="30" rows="1"><?php $cp_comment; ?></textarea>
                        <label for="cpComment">Comment</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text saveCashProcessed mr-3">
                <i class="material-icons left">save</i>
                Save Cash Processed
            </button>
        </div>
    </div>

    <!-- Start Modal -->
    <div id="uploadFile" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Process Cash Returned By <strong><?php echo $tellerFullName; ?></strong></h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <h6>&nbsp;</h6>
                <form id="fileform" action="app/ajax/uploaddp.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="caId" name="caId" value="<?php echo $get_id; ?>">
                    <input type="hidden" id="returnedBy" value="<?php echo $allocatedTo; ?>">
                    <div class="row margin">
                        <div class="file-field input-field">
                            <div class="btn grey lighten-3 black-text">
                                <span>File</span>
                                <input id="uploadImage" type="file" accept="image/*" name="image" >
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>
                    <div id="preview"><?php echo $evidence; ?></div><br>
                    <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                    <button class="btn  waves-effect waves-light primary-btn changefilebtn" type="submit">
                        <i class="material-icons">save</i>
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="right">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            </div>
        </div>
    </div>

    <!-- Start Modal -->
    <div id="returnCashAllocated" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Return Cash Allocated To <strong><?php echo $tellerFullName; ?></strong></h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <h6>&nbsp;</h6>
                <h5 class="center"><small class="uppercase"><?php echo $tellerFullName; ?> Is Expected To Return:</small> <span  class="black-text"><?php echo $currencyIcon.number_format($declared_value); ?></span></h5>
                <input type="hidden" id="caId" value="<?php echo $get_id; ?>">
                <input type="hidden" id="returnedBy" value="<?php echo $allocatedTo; ?>">
                <div class="row margin">
                    <input type="hidden" id="expAmount" value="<?php echo $declared_value; ?>">
                    <input type="hidden" id="difference">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <textarea name="comment" id="comment" placeholder="Enter Commenst/Observations Here" class="materialize-textarea" cols="30" rows="1"></textarea>
                        <label for="difference">What Do You Have To Say About This?</label>
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
                Save Cash Allocation 
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