<?php

$error = false;

// Load Bag
if(isset($_POST["loadBag"])){

    require_once('../core/general-functions.php');

    $qSealNumber	            = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        loadBag($qSealNumber);
    }
}

// Load Bag Function
function loadBag($qSealNumber)
{
    require('../core/db.php');

    $accentNumber = 1;
    $total_amount_allocated = 0;
    $sql = " SELECT * FROM sealings WHERE seal_number = '$qSealNumber' ";
    $result = $con->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $total_amount           = $row['amount'];  
            // Get Denomination
            $drow   = getDenomById($row['denomination_id']);
            $denomination = $drow['name'];  
            // Get Currency
            $drow   = getCurById($row['currency_id']);
            $currency_slug = $drow['slug'];   
            // Get Currencies
            if ($currency_slug == 'naira') {
                $currencyName = 'Nigerian Naira';
                $currencyIcon = '&#8358;';
            } else if ($currency_slug == 'euro') {
                $currencyName = 'European Euro';
                $currencyIcon = '&euro;';
            } else if ($currency_slug == 'gbp') {
                $currencyName = 'British Pounds';
                $currencyIcon = '&#163;';
            } else if ($currency_slug == 'usd') {
                $currencyName = 'US Dollars';
                $currencyIcon = '&#36;';
            } else if ($currency_slug == 'cny') {
                $currencyName = 'Chinese Yen';
                $currencyIcon = '&#165;';
            } else if ($currency_slug == 'cfa') {
                $currencyName = 'Centra African Republic Franc';
                $currencyIcon = 'CFA';
            } else if ($currency_slug == 'zar') {
                $currencyName = 'South African Rand';
                $currencyIcon = 'R';
            }

            // Check If Amount Has Been Exhausted
            if ( $row['total_amount_allocated'] >= $total_amount) {
                echo 'allDone';
            } else {
                echo '<div class="card">
                    <div class="card-content">
                        <div class="row center">
                            <div class="col s12">
                                <input type="hidden" id="clientName" value="' . $row['client'] . '">
                                <input type="hidden" id="dSealNUmber" value="' . $qSealNumber . '">
                                <input type="hidden" id="sealNumberId" value="' . $row['id'] . '">
                                <input type="hidden" id="categoryId" value="' . $row['category_id'] . '">
                                <input type="hidden" id="oldSealNumber" value="' . $row['old_seal_number'] . '">
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
}


// getDenominationById
function getDenomById($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM denominations WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getCurrencyById
function getCurById($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM currencies WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Start Bundle Confirmation
if(isset($_POST["saveCashAllocation"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $shift		                = filter_var($_POST['shift'], FILTER_SANITIZE_STRING);
    $allocatedTo		        = filter_var($_POST['allocatedTo'], FILTER_SANITIZE_STRING);
    $sealNumber		            = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $oldSealNumber		        = filter_var($_POST['oldSealNumber'], FILTER_SANITIZE_STRING);
    $workstation		        = filter_var($_POST['workstation'], FILTER_SANITIZE_STRING);
    $denomination		        = filter_var($_POST['denomination'], FILTER_SANITIZE_STRING);
    $categoryId		            = filter_var($_POST['categoryId'], FILTER_SANITIZE_STRING);
    $maxAmount		            = filter_var($_POST['maxAmount'], FILTER_SANITIZE_STRING);
    $clientName		            = filter_var($_POST['clientName'], FILTER_SANITIZE_STRING);
    $allocatedCash		        = filter_var($_POST['allocatedCash'], FILTER_SANITIZE_STRING);
    $currency   		        = filter_var($_POST['currency'], FILTER_SANITIZE_STRING);
    $taabn   		            = filter_var($_POST['totalAmountAlloactedBeforeNow'], FILTER_SANITIZE_STRING);
    $tpbn   		            = filter_var($_POST['totalProcessorsBeforeNow'], FILTER_SANITIZE_STRING);
    $sealNumberId   		    = filter_var($_POST['sealNumberId'], FILTER_SANITIZE_STRING);

    $totalAmountAlloacted       = $taabn + $allocatedCash;
    $totalProcessors            = $tpbn + 1;

    // Check If Amount Is Higher Than Bag Content
    // if ( $totalAmountAlloacted > $maxAmount ) {
    //     $error = true;
    //     echo 'The Amount You Have Allocated Is Higher Than The Amount In The Chosen Bag';
    // }
    
    // Basic Username Name Validation 
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }

    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }

    if( !$error ) {
        startBUndleConfirmation($addedOn, $username, $shift, $allocatedTo, $sealNumber, $oldSealNumber, $workstation, $categoryId, $currency, $denomination, $clientName, $allocatedCash, $totalAmountAlloacted, $totalProcessors, $sealNumberId);
    }
}

// Start New Bundle Confirmation function
function startBUndleConfirmation($addedOn, $username, $shift, $allocatedTo, $sealNumber, $oldSealNumber, $workstation, $categoryId, $currency, $denomination, $clientName, $allocatedCash, $totalAmountAlloacted, $totalProcessors, $sealNumberId)
{
    require('../core/db.php');

    $sql = "INSERT INTO cashallocations (allocated_to, workstation, seal_number, client_name, audit_trail_number, currency_id, denomination_id, amount_allocated, allocated_by, allocated_on, ca_shift, state_of_cash, old_seal_number)
            VALUES ('$allocatedTo', '$workstation', '$sealNumber', '$clientName', '$addedOn', '$currency', '$denomination', '$allocatedCash', '$username', '$addedOn', '$shift', '$categoryId', '$oldSealNumber')";

    if ($con->query($sql) === true) {
        $sql = "UPDATE sealings SET 
                total_amount_allocated = '$totalAmountAlloacted', 
                total_processors = '$totalProcessors', 
                is_opened = 'YES' 
                WHERE id = $sealNumberId ";
        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
        echo "caa";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Bundle Confirmation
if(isset($_POST["confirmThisBundleConfirmation"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $depostType		            = filter_var($_POST['depostType'], FILTER_SANITIZE_STRING);
    $clientBranchName		    = filter_var($_POST['clientBranchName'], FILTER_SANITIZE_STRING);
    $totalAmount		        = filter_var($_POST['totalAmount'], FILTER_SANITIZE_STRING);
    $sealNumber		            = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $bcId		                = filter_var($_POST['bcId'], FILTER_SANITIZE_STRING);
    
    // Basic Username Name Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }

    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }

    if( !$error ) {
        confirmBundle($addedOn, $username, $depostType, $clientBranchName, $totalAmount, $sealNumber, $bcId);
    }
}

// Move Existing Consignment
function confirmBundle($addedOn, $username, $depostType, $clientBranchName, $totalAmount, $sealNumber, $bcId)
{
    require('../core/db.php');

    $sql = "UPDATE bundleconfirmationbags SET 
            branch_id = '$clientBranchName', 
            seal_number = '$sealNumber', 
            amount = '$totalAmount',
            deposit_type_id = '$depostType',
            added_on = '$addedOn',
            confirmation_done = 'YES' 
            WHERE id = $bcId ";
    if ($con->query($sql) === true) {
        echo "confirmed";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Export Table To Excel
$output = '';
if(isset($_POST['export_excel']))
{
    require('../core/db.php');
    require('../core/session.php');
    require('../core/functions.php');
    $sno = 1;
    $sql = "SELECT * FROM cashallocations ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $output .= '
            <table style="border:2px solid black">
                <tr>
                    <th>S/No</th>
                    <th>Teller Name</th>
                    <th>Work Station</th>
                    <th>Teller Number</th>
                    <th>Client Name</th>
                    <th>Audit Trail Number</th>
                    <th>Denomination</th>
                    <th>Assigned Cash</th>
                    <th>Assigned By</th>
                    <th>Assigned On</th>
                    <th>Assigned Shift</th>
                    <th>Returned Cash</th>
                    <th>Difference</th>
                    <th>Returned By</th>
                    <th>Returned On</th>
                    <th>Comment</th>
                </tr>
        ';
        while ($row = $result->fetch_assoc()) {
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
            //get denomination
            $reqDenomination        = getDenominationById($row['denomination_id']);
            $denomination           = $reqDenomination['denomination_name'];
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
            $output .= '
                <tr>
                    <td>' . $sno++ . '</td>
                    <td><a href="profile?r=' . $getTellerData['username'].'cprf'.$tellerUID . '" target="_blank" style="color: #4f2323 !important;">' . $tellerFullName . '</a></td>
                    <td>' . $row['workstation'] . '</td>
                    <td>' . $sealNumber . '</td>
                    <td>' . $row['client_name'] . '</td>
                    <td>' . $row['audit_trail_number'] . '</td>
                    <td>' . number_format($denomination) . '</td>
                    <td>' . number_format($row['amount_allocated']) . '</td>
                    <td><a href="profile?r=' . $getAllocatorData['username'].'cprf'.$allocatorUID . '" target="_blank" style="color: #4f2323 !important;">' . $allocatorFullName . '</a></td>
                    <td>' . date("d/m/y", $row["allocated_on"]) . '</td>
                    <td>' . $row['ca_shift'] . '</td>
                    <td>' . number_format($row['amount_returned']) . '</td>
                    <td>' . number_format($row['difference']) . '</td>
                    <td><a href="profile?r=' . $getReturnedByData['username'].'cprf'.$returnedByUID . '" target="_blank" style="color: #4f2323 !important;">' . $returnedByFullName . '</a></td>
                    <td>' . $returnedOn . '</td>
                    <td>' . $row['ca_comment'] . '</td>
                </tr>
            ';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename= CashAllocationExport.xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");
        echo $output;
    }
}

// Save Cash Returned
if(isset($_POST["saveCashReturned"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $returnedBy		            = filter_var($_POST['returnedBy'], FILTER_SANITIZE_STRING);
    $comment		            = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $caId		                = filter_var($_POST['caId'], FILTER_SANITIZE_STRING);
    
    // Basic Username Name Validation  
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }

    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }

    if( !$error ) {
        saveCashReturned($addedOn, $username, $returnedBy, $comment, $caId);
    }
}

// Start New Bundle Confirmation function
function saveCashReturned($addedOn, $username, $returnedBy, $comment, $caId)
{
    require('../core/db.php');

    $sql = "UPDATE cashallocations SET 
            returned_by = '$returnedBy', 
            returned_on = '$addedOn', 
            ca_comment = '$comment', 
            returned_user = '$username' 
            WHERE id = $caId ";
    if ($con->query($sql) === true) {
        echo "cas";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Save Cash Processed
if(isset($_POST["saveCashProcessed"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $returnedBy		            = filter_var($_POST['returnedBy'], FILTER_SANITIZE_STRING);
    $declaredValue		        = filter_var($_POST['declaredValue'], FILTER_SANITIZE_STRING);
    $countedValue		        = filter_var($_POST['countedValue'], FILTER_SANITIZE_STRING);
    $fit		                = filter_var($_POST['fit'], FILTER_SANITIZE_STRING);
    $unfit		                = filter_var($_POST['unfit'], FILTER_SANITIZE_STRING);
    $atm		                = filter_var($_POST['atm'], FILTER_SANITIZE_STRING);
    $mixup		                = filter_var($_POST['mixup'], FILTER_SANITIZE_STRING);
    $m1000		                = filter_var($_POST['m1000'], FILTER_SANITIZE_STRING);
    $m500		                = filter_var($_POST['m500'], FILTER_SANITIZE_STRING);
    $m200		                = filter_var($_POST['m200'], FILTER_SANITIZE_STRING);
    $m100		                = filter_var($_POST['m100'], FILTER_SANITIZE_STRING);
    $m50		                = filter_var($_POST['m50'], FILTER_SANITIZE_STRING);
    $m20		                = filter_var($_POST['m20'], FILTER_SANITIZE_STRING);
    $m10		                = filter_var($_POST['m10'], FILTER_SANITIZE_STRING);
    $m5		                    = filter_var($_POST['m5'], FILTER_SANITIZE_STRING);
    $m1		                    = filter_var($_POST['m1'], FILTER_SANITIZE_STRING);
    $fakenotes		            = filter_var($_POST['fakenotes'], FILTER_SANITIZE_STRING);
    $fakenotesSerialNumbers		= filter_var($_POST['fakenotesSerialNumbers'], FILTER_SANITIZE_STRING);
    $shortage		            = filter_var($_POST['shortage'], FILTER_SANITIZE_STRING);
    $cpComment		            = filter_var($_POST['cpComment'], FILTER_SANITIZE_STRING);
    $caId		                = filter_var($_POST['caId'], FILTER_SANITIZE_STRING);

    // Check If Amount Is Higher Than Bag Content
    if ( $countedValue > $declaredValue ) {
        $error = true;
        echo 'The Amount You Have Processed Is Higher Than The Expected Amount';
    }
    
    // Basic Username Name Validation  
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }

    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }

    if( !$error ) {
        saveCashProcessed($addedOn, $username, $returnedBy, $declaredValue, $countedValue, $fit, $unfit, $atm, $mixup, $m1000, $m500, $m200, $m100, $m50, $m20, $m10, $m5, $m1, $fakenotes, $fakenotesSerialNumbers, $shortage, $cpComment, $caId);
    }
}

// Save Cash Processed
function saveCashProcessed($addedOn, $username, $returnedBy, $declaredValue, $countedValue, $fit, $unfit, $atm, $mixup, $m1000, $m500, $m200, $m100, $m50, $m20, $m10, $m5, $m1, $fakenotes, $fakenotesSerialNumbers, $shortage, $cpComment, $caId)
{
    require('../core/db.php');
    
    $sql = "UPDATE cashallocations SET 
            is_fit = '$fit', 
            is_unfit = '$unfit', 
            is_atm = '$atm',  
            shortage = '$shortage', 
            mixups = '$mixup', 
            m1000 = '$m1000', 
            m500 = '$m500', 
            m200 = '$m200', 
            m100 = '$m100', 
            m50 = '$m50', 
            m20 = '$m20', 
            m10 = '$m10', 
            m5 = '$m5', 
            m1 = '$m1', 
            fake_notes = '$fakenotes', 
            fake_serial_numbers = '$fakenotesSerialNumbers',  
            declared_value = '$declaredValue',
            comment = '$cpComment' 
            WHERE id = $caId ";
    if ($con->query($sql) === true) {
        echo "cap";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}