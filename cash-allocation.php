<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/cash-allocation.php';
include 'app/core/session.php';
$pagename = 'Cash Allocations And Processing';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() || $session->isCPA() ||  $session->isCPS() || $session->isTreasuryOfficer() || $session->isTreasurySup() ) {
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/e.php'; ?>

<head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">    
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
                                <h5 class="breadcrumbs-title">
                                    <?php echo $pagename; ?>
                                </h5>
                                <ol class="breadcrumbs">
                                    <li><a href="./">Dashboard</a></li>
                                    <li class="active">
                                        <?php echo $pagename; ?>
                                    </li>
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
                                    <a href="cash-allocation-c" class="btns btns-add waves-effect waves-teal" style="color: white !important;">
                                        <i class="material-icons left">add</i> Assign Cash Processor
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="row" style="border-bottom: 2px solid #af0000; margin-bottom: 20px; padding-bottom: 10px;">
                                            <div class="col s12">
                                                <h6 class="center blue-grey-text uppercase">
                                                    Cash Allocation Table <small class="black-text">Use The Search Form To Sort / Filter The Records. </small>
                                                </h6>
                                            </div>
                                        </div>
                                        <?php 
                                        $sno = 1;
                                        $sortingValue = 0;
                                        $status = $evidence = $bankSealNumber = $transStream = '';
                                        $sql = "SELECT * FROM cashallocations ORDER BY id DESC";
                                        $result = $con->query($sql);
                                    
                                        if ($result->num_rows > 0) {
                                            echo '<table id="caTable" class="display wrap" width="100%" cellspacing="0">';
                                            echo '<thead>
                                                    <tr>
                                                        <th>S/No</th>
                                                        <th>Client Code</th>
                                                        <th>Client Seal</th>
                                                        <th>Stream</th>
                                                        <th>Teller Name</th>
                                                        <th>Work Station</th>
                                                        <th>ICMS Seal </th>
                                                        <th>Audit Trail Number</th>
                                                        <th>Den</th>
                                                        <th>CP Operation Type</th>
                                                        <th>Assigned Cash</th>
                                                        <th>Assigned By</th>
                                                        <th>Assigned On</th>
                                                        <th>Assigned Shift</th>
                                                        <th>Declared Value</th>
                                                        <th>Counted Value</th>
                                                        <th>Pre-Count Shortage</th>
                                                        <th>Fit</th>
                                                        <th>Unfit</th>
                                                        <th>ATM</th>
                                                        <th>Sorting Value</th>
                                                        <th>Sorting Shortage</th>
                                                        <th>Fake Notes (FN) </th>
                                                        <th>FN Serial Numbers </th>
                                                        <th>FN Value </th>
                                                        <th>Processor Comment</th>
                                                        <th>Attachement</th>
                                                        <th>Returned Cash</th>
                                                        <th>Mixup 1,000</th>
                                                        <th>Mixup 500</th>
                                                        <th>Mixup 200</th>
                                                        <th>Mixup 100</th>
                                                        <th>Mixup 50</th>
                                                        <th>Mixup 20</th>
                                                        <th>Mixup 10</th>
                                                        <th>Mixup 5</th>
                                                        <th>Mixup Total</th>
                                                        <th>Post Sorting Value</th>
                                                        <th>Post Sorting Shortage</th>
                                                        <th>Sorting Unfit</th>
                                                        <th>Returned By</th>
                                                        <th>Returned On</th>
                                                        <th>Teller Comment</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                $declaredValue = $row['amount_allocated'];

                                                $bUID = $row['id'].'------'.$row['allocated_by'].'------el';
                                                $caUID = base64_encode($bUID);
                                                
                                                // Get Teller Data
                                                $getTellerData          = $database->getUserInfo($row['allocated_to']);
                                                $tellerFullName         = $getTellerData['surname'].' '.$getTellerData['firstname'].' '.$getTellerData['middlename'];
                                                $tellerId               = $getTellerData['username'].'------'.$getTellerData['email'].'------el';
                                                $tellerUID              = base64_encode($tellerId);
                                                // Get Allocator Data
                                                $getAllocatorData       = $database->getUserInfo($row['allocated_by']);
                                                $allocatorFullName      = $getAllocatorData['surname'].' '.$getAllocatorData['firstname'].' '.$getAllocatorData['middlename'];
                                                $allocatorId            = $getAllocatorData['username'].'------'.$getAllocatorData['email'].'------el';
                                                $allocatorUID           = base64_encode($tellerId);
                                                //Split and get main seal number
                                                $sealPieces             = explode("-", $row['seal_number']);
                                                $tymeStamp              = $sealPieces[0];
                                                $sealNumber             = $sealPieces[1];
                                                // Split Bank Seal Number
                                                if ( $row['old_seal_number'] != '' ) {
                                                    $sealPiecess        = explode("-", $row['old_seal_number']);
                                                    $tymeStamps         = $sealPiecess[0];
                                                    $bankSealNumber     = $sealPiecess[1];
                                                    $transStream        = 'CBN';
                                                }
                                                //get denomination
                                                $reqDenomination        = getDenominationById($row['denomination_id']);
                                                $denomination           = $reqDenomination['name'];
                                                // Get ReturnedBy Data
                                                $getReturnedByData      = $database->getUserInfo($row['returned_by']);
                                                $returnedByFullName     = $getReturnedByData['surname'].' '.$getReturnedByData['firstname'].' '.$getReturnedByData['middlename'];
                                                $returnedById           = $getReturnedByData['username'].'------'.$getReturnedByData['email'].'------el';
                                                $returnedByUID          = base64_encode($tellerId);

                                                $retDate                = $row["returned_on"];
                                                if ($retDate == ''){
                                                    $returnedOn = '';
                                                } else {
                                                    $returnedOn = date("d/m/y", $retDate);
                                                }
                                                //get client name
                                                $reqClientName      = getClientNameById($row['client_name']);
                                                $clientName         = $reqClientName['bank_name'];
                                                $clientNameCode     = $reqClientName['bank_code'];
                                                // Get State Of Cash (Cash Category)
                                                $getCategoryType    = getCategoryTypeById($row['state_of_cash']);
                                                $stateOfCash        = $getCategoryType['name'];
                                                // Get Eviden
                                                if ( $row['evidence'] != '' ) {
                                                    $evidence = '<img src="assets/images/attachments/'.$row['evidence'].'" width="100" />';
                                                } else {
                                                    $evidence = '<img src="assets/images/attachments/noimage.png" width="100" />';
                                                }
                                                // Get Currencies
                                                $currency = $row['currency_id'];
                                                if ($currency == '1') {
                                                    $currencyName = 'Nigerian Naira';
                                                    $currencyIcon = '&#8358;';
                                                } else if ($currency == '2') {
                                                    $currencyName = 'European Euro';
                                                    $currencyIcon = '&euro;';
                                                } else if ($currency == '3') {
                                                    $currencyName = 'US Dollars';
                                                    $currencyIcon = '&#36;';
                                                } else if ($currency == '4') {
                                                    $currencyName = 'British Pounds';
                                                    $currencyIcon = '&#163;';
                                                } else if ($currency == '5') {
                                                    $currencyName = 'South African Rand';
                                                    $currencyIcon = 'R';
                                                } else if ($currency == '6') {
                                                    $currencyName = 'Centra African Republic Franc';
                                                    $currencyIcon = 'CFA';
                                                } else if ($currency == '7') {
                                                    $currencyName = 'Chinese Yen';
                                                    $currencyIcon = '&#165;';
                                                }
                                                $declared_value = $row['declared_value'];
                                                 /* Cash Processing */
                                                // Get Fake Notes Value
                                                $fakeNotesValue = $row['fake_notes'] * $denomination;
                                                // Get Mixups Value
                                                $mixupsValue = $row['mixups'] * $denomination;
                                                // Get Sum Of Mixup Values
                                                $sumMixupsValues = $row['m1000'] + $row['m500'] + $row['m200'] + $row['m100'] + $row['m50'] + $row['m20'] + $row['m10'] + $row['m5'] + $row['m1'];
                                                // Get Counted Value
                                                $countedValue = $row['is_fit'] + $row['is_unfit'] + $row['is_atm'];
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

                                                // Get Value Of Mixup And Fake Note
                                                $mixFnValue = ($row['fake_notes'] + $row['mixups']) * $denomination;
                                                // Sorting Unfit = unfit - $mixFnValue 
                                                $sortingUnfit = $row['is_unfit'] - $mixFnValue;
                                                // SortingValue = $countedValue - $mixFnValue
                                                $sortingValue = $countedValue - $mixFnValue;
                                                
                                                echo '<tr>
                                                    <td>' . $sno++ . '</td>
                                                    <td>' . $clientNameCode . '</td>
                                                    <td>' . $bankSealNumber . '</td>
                                                    <td>' . $transStream . '</td>
                                                    <td><a href="profile?r=' . $getTellerData['username'].'cprf'.$tellerUID . '" target="_blank" style="color: #4f2323 !important;">' . $tellerFullName . '</a></td>
                                                    <td>' . $row['workstation'] . '</td>
                                                    <td>' . $sealNumber . '</td>
                                                    <td>' . $row['audit_trail_number'] . '</td>
                                                    <td>N' . number_format($denomination) . '</td>
                                                    <td>' . $stateOfCash . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($declaredValue) . '</td>
                                                    <td><a href="profile?r=' . $getAllocatorData['username'].'cprf'.$allocatorUID . '" target="_blank" style="color: #4f2323 !important;">' . $allocatorFullName . '</a></td>
                                                    <td>' . date("d/m/y", $row["allocated_on"]) . '</td>
                                                    <td>' . $row['ca_shift'] . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['declared_value']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($countedValue) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['shortage']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_fit']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_unfit']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_atm']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($sortingValue) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($sortingShortage) . '</td>
                                                    <td>' . number_format($row['fake_notes']) . '</td>
                                                    <td>' . $row['fake_serial_numbers'] . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($fakeNotesValue) . '</td>
                                                    <td>' . $row['comment'] . '</td>
                                                    <td>' . $evidence . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($countedValue) . '</td>
                                                    <td>' . number_format($row['m1000']) . '</td>
                                                    <td>' . number_format($row['m500']) . '</td>
                                                    <td>' . number_format($row['m200']) . '</td>
                                                    <td>' . number_format($row['m100']) . '</td>
                                                    <td>' . number_format($row['m50']) . '</td>
                                                    <td>' . number_format($row['m20']) . '</td>
                                                    <td>' . number_format($row['m10']) . '</td>
                                                    <td>' . number_format($row['m5']) . '</td>
                                                    <td>' . number_format($sumMixupsValues) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($postSortingValue) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($postSortingShortage) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($sortingUnfit) . '</td>
                                                    <td><a href="profile?r=' . $getReturnedByData['username'].'cprf'.$returnedByUID . '" target="_blank" style="color: #4f2323 !important;">' . $returnedByFullName . '</a></td>
                                                    <td>' . $returnedOn . '</td>
                                                    <td>' . $row['ca_comment'] . '</td>
                                                    <td>';
                                                        echo '<a href="cash-allocation-r?r=' . $row['id'] . 'cprf' . $caUID.'" class="btns btns-read waves-effect waves-teal" style="color: teal !important;"><i class="material-icons left">edit</i> View </a>';
                                                    echo '</td>
                                                </tr>';
                                            }
                                            echo '</tbody>
                                            </table>';
                                        } else {
                                            echo 'No record found.';
                                        }
                                        $con->close();
                                        ?>
    
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