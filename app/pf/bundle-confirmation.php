<?php

$error = false;

// Start Bundle Confirmation
if(isset($_POST["startBundleConfirmation"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $bcTitle		            = filter_var($_POST['bcTitle'], FILTER_SANITIZE_STRING);
    $clientName		            = filter_var($_POST['clientName'], FILTER_SANITIZE_STRING);
    $strim		                = filter_var($_POST['strim'], FILTER_SANITIZE_STRING);
    $conslocation		        = filter_var($_POST['conslocation'], FILTER_SANITIZE_STRING);
    
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

    if (empty($bcTitle)) {
        $error = true;
        echo'Bundle Confirmation Title Is Required';
    }

    if( !$error ) {
        startBUndleConfirmation($addedOn, $username, $bcTitle, $clientName, $strim, $conslocation);
    }
}

// Start New Bundle Confirmation function
function startBUndleConfirmation($addedOn, $username, $bcTitle, $clientName, $strim, $conslocation)
{
    require('../core/db.php');

    $sql = "INSERT INTO bundleconfirmations (bc_title, client_id, strim, conslocation, audit_trail_number, added_by)
            VALUES ('$bcTitle', '$clientName', '$strim', '$conslocation', '$addedOn', '$username')";

    if ($con->query($sql) === true) {
        echo "bcstarted";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Load Bag
if(isset($_POST["loadBag"])){

    require_once('../core/general-functions.php');

    $qSealNumber	            = filter_var($_POST['qSealNumber'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        loadBag($qSealNumber);
    }
}

// Load Bag Function
function loadBag($qSealNumber)
{
    require('../core/db.php');
    // Check If Bag Has An Exception
    $sql = " SELECT * FROM thrownexceptions WHERE seal_number = '$qSealNumber' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<h5 class="header center deepred-text">This Bag Has An Exception</h5>';
        echo '<p>Resolve the exception first then try again later.</p>';
    } else {
        $accentNumber = '';
        $sql = " SELECT * FROM evacuationpreparations WHERE seal_number = '$qSealNumber' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            echo '<h5 class="header center blue-grey-text">Bag Content</h5>';
            while ($row = $result->fetch_assoc()) {
                $currency_id            = $row['currency_id'];
                $total_amount           = $row['total_amount'];     
                $total_amount_bc        = $row['total_amount_bc'];    
                $cash_1000        = $row['cash_1000'];    
                $cash_500        = $row['cash_500'];    
                $cash_200        = $row['cash_200'];    
                $cash_100        = $row['cash_100'];    
                $cash_50        = $row['cash_50'];    
                $cash_20        = $row['cash_20'];    
                $cash_10        = $row['cash_10'];    
                $cash_5        = $row['cash_5'];    
                $cash_1        = $row['cash_1'];  
                // Generate Denominations
                if (!empty($cash_1000)){
                    $accentNumber = $cash_1000;
                }
                if (!empty($cash_500)){
                    $accentNumber .= ', ' . $cash_500;
                }
                if (!empty($cash_200)){
                    $accentNumber .= ', ' . $cash_200;
                }
                if (!empty($cash_100)){
                    $accentNumber .= ', ' . $cash_100;
                }
                if (!empty($cash_50)){
                    $accentNumber .= ', ' . $cash_50;
                }
                if (!empty($cash_20)){
                    $accentNumber .= ', ' . $cash_20;
                }
                if (!empty($cash_10)){
                    $accentNumber .= ', ' . $cash_10;
                }
                if (!empty($cash_5)){
                    $accentNumber .= ', ' . $cash_5;
                }
                if (!empty($cash_1)){
                    $accentNumber .= ', ' . $cash_1;
                }  
                // Get Currencies
                if ($currency_id == 'naira') {
                    $currencyName = 'Nigerian Naira';
                    $currencyIcon = '&#8358;';
                } else if ($currency_id == 'euro') {
                    $currencyName = 'European Euro';
                    $currencyIcon = '&euro;';
                } else if ($currency_id == 'gbp') {
                    $currencyName = 'British Pounds';
                    $currencyIcon = '&#163;';
                } else if ($currency_id == 'usd') {
                    $currencyName = 'US Dollars';
                    $currencyIcon = '&#36;';
                } else if ($currency_id == 'cny') {
                    $currencyName = 'Chinese Yen';
                    $currencyIcon = '&#165;';
                } else if ($currency_id == 'cfa') {
                    $currencyName = 'Centra African Republic Franc';
                    $currencyIcon = 'CFA';
                } else if ($currency_id == 'zar') {
                    $currencyName = 'South African Rand';
                    $currencyIcon = 'R';
                }

                echo '<div class="card">
                    <div class="card-content">
                ';
                if ( $total_amount_bc < $total_amount ) {
                    if ($row['cash_1000_amount'] != ''){ 
                    echo '
                        <div class="row center">
                            <div class="col l5 m5 s12">
                                <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 1,000 </h5>
                            </div>
                            <div class="col l7 m7 s12">
                                <h4 class="card-stats-number">';
                                    echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_1000_amount']) ;
                                echo '</h4>
                            </div>
                        </div>
                    ';
                    }
                    if ($row['cash_500_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 500 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_500_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_200_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 200 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_200_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_100_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 100 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_100_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_50_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 50 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_50_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_20_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 20 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_20_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_10_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 10 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_10_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_5_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 5 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_5_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    if ($row['cash_1_amount'] != ''){ 
                        echo '
                            <div class="row center">
                                <div class="col l5 m5 s12">
                                    <h5 class="card-stats-title"> <small><i class="material-icons left">label</i>Denomination:</small> 1 </h5>
                                </div>
                                <div class="col l7 m7 s12">
                                    <h4 class="card-stats-number">';
                                        echo '<small>Amount: '.$currencyIcon.'</small>' . number_format($row['cash_1_amount']) ;
                                    echo '</h4>
                                </div>
                            </div>
                        ';
                    }
                    echo '
                    </div>
                    <div class="card-action red-text">
                        <div class="row">
                            <div class="col s12">
                                <div id="sales-compositebar" class="center-align">
                                    <h2><span style="font-size: 24px; font-weight: 300;">TOTAL AMOUNT: </span><span style="font-weight: 100;">'.$currencyIcon .'</span>'. number_format($total_amount).'</h2>
                                    <h1 class="blue-grey-text"><span style="font-size: 24px; font-weight: 300;">TOTAL BUNDLE CONFIRMED: </span><span style="font-weight: 100;">'.$currencyIcon .'</span>'. number_format($total_amount_bc).'</h1>
                                    <input type="hidden" id="tamount" value="'.$total_amount.'" />
                                    <input type="hidden" id="tamountbc" value="'.$total_amount_bc.'" />
                                    <input type="hidden" id="depType" value="'.$row['deposit_type_id'].'" />
                                    <input type="hidden" id="listDens" value="'.$accentNumber.'" />
                                </div>
                            </div>
                        </div>
                    </div>';
                } else {
                    echo '<h5 class="orange-text"> You Have Bundle Confirmed Contents Of This Bag </h5>';
                }
                echo '
                </div>';
            }
        } else {
            echo 'This Bag Does Not Exist';
        }
    }
}

// Add New Bag 
if(isset($_POST["confirmThisBag"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $qSealNumber	            = filter_var($_POST['qSealNumber'], FILTER_SANITIZE_STRING);
    $tamount	                = filter_var($_POST['tamount'], FILTER_SANITIZE_STRING);
    $tamountbc	                = filter_var($_POST['tamountbc'], FILTER_SANITIZE_STRING);
    $bcsId	                    = filter_var($_POST['bcsId'], FILTER_SANITIZE_STRING);
    $clientId	                = filter_var($_POST['clientId'], FILTER_SANITIZE_STRING);
    $branch	                    = filter_var($_POST['branchId'], FILTER_SANITIZE_STRING);
    $d1000	                    = filter_var($_POST['d1000'], FILTER_SANITIZE_STRING);
    $d1000Amount	            = filter_var($_POST['d1000Amount'], FILTER_SANITIZE_STRING);
    $d1000Category	            = filter_var($_POST['d1000Category'], FILTER_SANITIZE_STRING);
    $d500	                    = filter_var($_POST['d500'], FILTER_SANITIZE_STRING);
    $d500Amount	                = filter_var($_POST['d500Amount'], FILTER_SANITIZE_STRING);
    $d500Category	            = filter_var($_POST['d500Category'], FILTER_SANITIZE_STRING);
    $d200	                    = filter_var($_POST['d200'], FILTER_SANITIZE_STRING);
    $d200Amount	                = filter_var($_POST['d200Amount'], FILTER_SANITIZE_STRING);
    $d200Category	            = filter_var($_POST['d200Category'], FILTER_SANITIZE_STRING);
    $d100	                    = filter_var($_POST['d100'], FILTER_SANITIZE_STRING);
    $d100Amount	                = filter_var($_POST['d100Amount'], FILTER_SANITIZE_STRING);
    $d100Category	            = filter_var($_POST['d100Category'], FILTER_SANITIZE_STRING);
    $d50	                    = filter_var($_POST['d50'], FILTER_SANITIZE_STRING);
    $d50Amount	                = filter_var($_POST['d50Amount'], FILTER_SANITIZE_STRING);
    $d50Category	            = filter_var($_POST['d50Category'], FILTER_SANITIZE_STRING);
    $d20	                    = filter_var($_POST['d20'], FILTER_SANITIZE_STRING);
    $d20Amount	                = filter_var($_POST['d20Amount'], FILTER_SANITIZE_STRING);
    $d20Category	            = filter_var($_POST['d20Category'], FILTER_SANITIZE_STRING);
    $d10	                    = filter_var($_POST['d10'], FILTER_SANITIZE_STRING);
    $d10Amount	                = filter_var($_POST['d10Amount'], FILTER_SANITIZE_STRING);
    $d10Category	            = filter_var($_POST['d10Category'], FILTER_SANITIZE_STRING);
    $d5	                        = filter_var($_POST['d5'], FILTER_SANITIZE_STRING);
    $d5Amount	                = filter_var($_POST['d5Amount'], FILTER_SANITIZE_STRING);
    $d5Category	                = filter_var($_POST['d5Category'], FILTER_SANITIZE_STRING);
    $d1	                        = filter_var($_POST['d1'], FILTER_SANITIZE_STRING);
    $d1Amount	                = filter_var($_POST['d1Amount'], FILTER_SANITIZE_STRING);
    $d1Category	                = filter_var($_POST['d1Category'], FILTER_SANITIZE_STRING);
    $currency	                = filter_var($_POST['currencyId'], FILTER_SANITIZE_STRING);
    $amount	                    = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
    $bundleConfirmationComment	= filter_var($_POST['bundleConfirmationComment'], FILTER_SANITIZE_STRING);
    $tamountbcnew = $tamountbc + $amount;

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

    if (empty($qSealNumber)) {
        $error = true;
        echo'Invalid request Id';
    } else if (strlen($qSealNumber) < 6) {
        $error = true;
        echo'Invalid request Id';
    }
    // Check If Inputed Amount Is Higher Than Expected Amount
    if ( $tamountbcnew > $tamount ) {
        $error = true;
        echo'The Amount Entered Is Higher Than Expected Amount';
    }

    if( !$error ) {
        confirmThisBag($username, $qSealNumber, $tamount, $tamountbcnew, $bcsId, $clientId, $branch, $currency, $d1000, $d1000Amount, $d1000Category, $d500, $d500Amount, $d500Category, $d200, $d200Amount, $d200Category, $d100, $d100Amount, $d100Category, $d50, $d50Amount, $d50Category, $d20, $d20Amount, $d20Category, $d10, $d10Amount, $d10Category, $d5, $d5Amount, $d5Category, $d1, $d1Amount, $d1Category, $amount, $bundleConfirmationComment, $addedOn);
    }
}

// Add New Bag Function
function confirmThisBag($username, $qSealNumber, $tamount, $tamountbcnew, $bcsId, $clientId, $branch, $currency, $d1000, $d1000Amount, $d1000Category, $d500, $d500Amount, $d500Category, $d200, $d200Amount, $d200Category, $d100, $d100Amount, $d100Category, $d50, $d50Amount, $d50Category, $d20, $d20Amount, $d20Category, $d10, $d10Amount, $d10Category, $d5, $d5Amount, $d5Category, $d1, $d1Amount, $d1Category, $amount, $bundleConfirmationComment, $addedOn)
{
    require('../core/db.php');
    $confirmationStatus = '';
    // Check If Seal Number Has a pending excemption
    if (hasException($qSealNumber)) {
        $confirmationStatus = 'Awaiting Supervisor Approval';
    } else {
        $confirmationStatus = 'Confirmed';
    }
    $sql = "UPDATE cits SET 
            bundle_confirmed = 'YES', 
            bundle_confirmed_by = '$username', 
            bundle_confirmed_comment = '$bundleConfirmationComment', 
            bundle_confirmed_on = '$addedOn',
            bundle_confirmation_status = '$confirmationStatus'
            WHERE seal_number = '$qSealNumber' ";
    if ($con->query($sql) === true) {
        // Update Internal Movement
        if ($tamountbcnew < $tamount) {
            $sql = "UPDATE internalmovements SET is_opened = 'YES', bc = 'NO' WHERE seal_number = '$qSealNumber' ";
            if ($con->query($sql) === true) {
                echo "";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        } else {
            $sql = "UPDATE internalmovements SET is_opened = 'YES', bc = 'YES' WHERE seal_number = '$qSealNumber' ";
            if ($con->query($sql) === true) {
                // Update CPs And Set Is Confirmed to YES
                $sql = "UPDATE evacuationpreparations SET 
                is_bceed = 'YES'
                WHERE seal_number = '$qSealNumber' ";
                if ($con->query($sql) === true) {
                    echo "";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
                echo "";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        }
        
        // Update Cash Preparations And Set Total Amount BC
        $sql = "UPDATE evacuationpreparations SET total_amount_bc = '$tamountbcnew', is_opened = 'YES' WHERE seal_number = '$qSealNumber' ";
        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
        // Insert Into Bundle Confirmation Table
        $sql = "INSERT INTO bundleconfirmationbags (bundleconfirmation_id, client, branch, seal_number, currency, d1000, d1000_category, d1000_amount, d500, d500_category, d500_amount, d200, d200_category, d200_amount, d100, d100_category, d100_amount, d50, d50_category, d50_amount, d20, d20_category, d20_amount, d10, d10_category, d10_amount, d5, d5_category, d5_amount, d1, d1_category, d1_amount, amount, added_on, added_by)
            VALUES ('$bcsId', '$clientId', '$branch', '$qSealNumber', '$currency', '$d1000', '$d1000Category', '$d1000Amount', '$d500', '$d500Category', '$d500Amount', '$d200', '$d200Category', '$d200Amount', '$d100', '$d100Category', '$d100Amount', '$d50', '$d50Category', '$d50Amount', '$d20', '$d20Category', '$d20Amount', '$d10', '$d10Category', '$d10Amount', '$d5', '$d5Category', '$d5Amount', '$d1', '$d1Category', '$d1Amount', '$amount', '$addedOn', '$username')";

        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
        echo "confirmed";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Check If Seal Number Is Listed As Exception And Yet To Be Resolved
function hasException($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $sql = "SELECT * FROM thrownexceptions WHERE seal_number = '$reqId' AND ex_status = 'Unresolved' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

// Add New Bag
if(isset($_POST["endThisBundleConfirmation"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $bcsidId	                = filter_var($_POST['bcsidId'], FILTER_SANITIZE_STRING);

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
        endThisBundleConfirmation($username, $bcsidId, $addedOn);
    }
}

// Add New Bag Function
function endThisBundleConfirmation($username, $bcsidId, $addedOn)
{
    require('../core/db.php');

    $sql = "UPDATE bundleconfirmations SET 
            confirmation_done = 'YES', 
            ended_on = '$addedOn'
            WHERE id = '$bcsidId' ";
    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Get all Banks
function getBundleConfirmationPerUser($username)
{
    // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $status = '';
    $sql = "SELECT * FROM bundleconfirmations WHERE added_by = '$username' ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $totalBags = 0;
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Stream</th>
                    <th>Consignment Location</th>
                    <th>Confirmation Status</th>
                    <th>Reference No</th>
                    <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Stream</th>
                    <th>Consignment Location</th>
                    <th>Confirmation Status</th>
                    <th>Reference No</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $clientId = $row['client_id'];
            //get client name
            $reqClientName      = getClientNameById($clientId);
            $clientName         = $reqClientName['bank_name'];
            $clientCode         = $reqClientName['bank_code'];
            //get client branch name
            // $reqBranchData      = getClientBranchNameById($row['branch_id']);
            // $branchName         = $reqBranchData['branch_name'];
            // Get Data From Bundle Confirmation Start
            // $reqStartdata           = getBundleConfirmationStart($clientId);
            // $conssignmentLocation   = $reqStartdata['conslocation'];
            // $confirmationDone       = $reqStartdata['confirmation_done'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($row['conslocation']);
            $consignmentLocation    = $reqConsLoc['name'];
            $consignmentLocationId  = $reqConsLoc['id'];

            $bUID = $row['id'].'------'.$clientName.'------'.$clientId.'------'.$row['strim'].'------'.$clientCode;
            $bankUID = base64_encode($bUID);

            $cbUID = $row['id'].'------'.$row['added_by'].'------'.$clientId;
            $cbbUID = base64_encode($cbUID);

            $countedBy = $row['added_by'];
            //Get Work Status
            if ($row['confirmation_done'] == 'YES') {
                $status = '<div class="fully-done"><i class="material-icons left small" style="padding-top: 4px">done_all</i> Completed</div>';
            } else {
                $status = '<div class="half-done"><i class="material-icons left small" style="padding-top: 4px">launch</i> On-Going</div>';
            }

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['bc_title'] . '</td>
                <td>' . $clientName . '</td>
                <td>' . $row['strim'] . '</td>
                <td>' . $consignmentLocation . '</td>
                <td>' . $status . '</td>
                <td>' . $clientCode.$row['bundleconfirmation_id'] . '</td>
                <td>';
                    if ($row['confirmation_done'] == 'YES') {
                        echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-red" style="color: teal !important; margin: 3px !important;">View Confirmed Bags <i class="material-icons left">link</i></a>';
                        echo 'Bundle Confirmation Closed';
                    } else {
                        echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">View Confirmed Bags <i class="material-icons left">link</i></a>';
                        echo '<a href="bundle-confirmation-bag?r=' . $row['client_id'].'cprf'.$bankUID .'" class="btns btns-add waves-effect waves-light" style="color: white !important; margin: 6px !important; background: #6acef3 !important;">
                        Add Bag <i class="material-icons left">add</i>
                        </a>';
                        if ( hasExceptionUser($username) ) {
                            echo '<br>You Have Pending Exceptions'; 
                        } else {
                            if ( $row['added_by'] == $username )
                            echo '<button data-target="closeConfirmation" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-bcsid="' . $row['bundleconfirmation_id'] . '">
                            End Bundle Confirmation <i class="material-icons left">done_all</i>
                            </button>';
                        }
                    }
                echo '</td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No record found.';
    }
    $con->close();
}

// Get all Banks
function getBundleConfirmations()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $status = '';
    $sql = "SELECT * FROM bundleconfirmationbags ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $totalBags = 0;
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Client Name</th>
                    <th>Consignment Location</th>
                    <th>Started On</th>
                    <th>Confirmation Status</th>
                    <th>Bags Added</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Client Name</th>
                    <th>Consignment Location</th>
                    <th>Started On</th>
                    <th>Confirmation Status</th>
                    <th>Bags Added</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $clientId = $row['client_id'];
            //get client name
            $reqClientName      = getClientNameById($clientId);
            $clientName         = $reqClientName['bank_name'];

            $bUID = $row['bundleconfirmation_id'].'------'.$clientName.'------'.$clientId;
            $bankUID = base64_encode($bUID);

            $cbUID = $row['bundleconfirmation_id'].'------'.$row['added_by'].'------'.$clientId;
            $cbbUID = base64_encode($cbUID);

            $countedBy = $row['added_by'];

            // Get Data From Bundle Confirmation Start
            $reqStartdata           = getBundleConfirmationStart($clientId);
            $conssignmentLocation   = $reqStartdata['conslocation'];
            $confirmationDone       = $reqStartdata['confirmation_done'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($conssignmentLocation);
            $consignmentLocation    = $reqConsLoc['name'];
            //Get Work Status
            if ($confirmationDone == 'YES') {
                $status = '<span class="badge teal white-text"><i class="material-icons left small" style="padding-top: 4px">done_all</i> Completed</span>';
            } else {
                $status = '<span class="badge orange lighten-1 black-text"><i class="material-icons left small" style="padding-top: 4px">launch</i> On-Going</span>';
            }

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $clientName . '</td>
                <td>' . $consignmentLocation . '</td>
                <td>' . $status . '</td>';
                echo '<td>'; number_format(getNumberCountedBagsPerClient($countedBy, $clientId)); echo '</td>
                <td>';
                    if ($confirmationDone == 'YES') {
                        echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                        View Confirmed Bags <i class="material-icons left">link</i>
                        </a>';
                    } else {
                        echo '<button data-target="addBag" style="margin: 6px; background: #6acef3 !important;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-client="' . $clientId . '">
                        Add Bag <i class="material-icons left">add</i>
                        </button>';
                        echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                        View Confirmed Bags <i class="material-icons left">link</i>
                        </a>';
                        echo '<button data-target="closeConfirmation" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-client="' . $clientId . '">
                        End Bundle Confirmation <i class="material-icons left">done_all</i>
                        </button>';
                    }
                echo '</td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No record found.';
    }
    $con->close();
}

// Throw New Exception
if(isset($_POST["addException"])){

    require_once('../core/general-functions.php');

    $number = count($_POST['actualAmount']);
    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $exceptionsealnumber	    = filter_var($_POST['exceptionsealnumber'], FILTER_SANITIZE_STRING);
    $currenc	                = filter_var($_POST['currenc'], FILTER_SANITIZE_STRING);
    $denom	                    = filter_var($_POST['denom'], FILTER_SANITIZE_STRING);
    $thrownComment              = filter_var($_POST['thrownComment'], FILTER_SANITIZE_STRING);
    $expectedAmount             = filter_var($_POST['expectedAmount'], FILTER_SANITIZE_STRING);
    $actualAmount               = filter_var($_POST['actualAmount'], FILTER_SANITIZE_STRING);
    $supo                       = filter_var($_POST['supo'], FILTER_SANITIZE_STRING);

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

    if (empty($exceptionsealnumber)) {
        $error = true;
        echo'Invalid Request Id';
    } else if (strlen($exceptionsealnumber) < 6) {
        $error = true;
        echo'Invalid Request Id';
    }

    if( !$error ) {
        addException($exceptionsealnumber, $supo, $currenc, $denom, $expectedAmount, $actualAmount, $thrownComment, $username, $addedOn);
    }
}

// Add New Bag Function
function addException($exceptionsealnumber, $supo, $currenc, $denom, $expectedAmount, $actualAmount, $thrownComment, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "INSERT INTO thrownexceptions (seal_number, currency, denomination, expected_amount, actual_amount, thrown_by, thrown_on, thrown_comment, thrown_to)
            VALUES ('$exceptionsealnumber', '$currenc', '$denom', '$expectedAmount', '$actualAmount', '$username', '$addedOn', '$thrownComment', '$supo')";
    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Resolve Exception
if(isset($_POST["resolveThisException"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $reviewedComment	        = filter_var($_POST['reviewedComment'], FILTER_SANITIZE_STRING);
    $exId	                    = filter_var($_POST['exId'], FILTER_SANITIZE_STRING);

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

    if (empty($exId)) {
        $error = true;
        echo'Invalid Request ID';
    }

    if (empty($reviewedComment)) {
        $error = true;
        echo'Your Comment Is required';
    }

    if( !$error ) {
        resolveThisException($reviewedComment, $exId, $username, $addedOn);
    }
}

// Add New Bag Function
function resolveThisException($reviewedComment, $exId, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "UPDATE thrownexceptions SET 
            reviewed_by = '$username', 
            reviewed_on = '$addedOn', 
            reviewed_comment = '$reviewedComment', 
            ex_status = 'Resolved'
            WHERE id = '$exId' ";

    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}


// Export Bundle Confirmed Table To Excel
$output = '';
if(isset($_POST['export_excel']))
{
    require('../core/db.php');
    require('../core/session.php');
    require('../core/functions.php');
    $sno = 1;
    $sql = "SELECT * FROM bundleconfirmationbags ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $output .= '
            <table style="border:2px solid black">
                <tr>
                    <th>S/No</th>
                    <th>Seal No</th>
                    <th>Branch</th>
                    <th>Currency</th>
                    <th>1,000</th>
                    <th>Category</th>
                    <th>500</th>
                    <th>Category</th>
                    <th>200</th>
                    <th>Category</th>
                    <th>100</th>
                    <th>Category</th>
                    <th>50</th>
                    <th>Category</th>
                    <th>20</th>
                    <th>Category</th>
                    <th>10</th>
                    <th>Category</th>
                    <th>5</th>
                    <th>Category</th>
                    <th>1</th>
                    <th>Category</th>
                    <th>Total</th>
                    <th>By</th>
                </tr>
        ';
        while ($row = $result->fetch_assoc()) {
            $bagId = $row['bc_id'];
            //Split and get main seal number
            $sealPieces                 = explode("-", $row['seal_number']);
            $sealNumber                 = $sealPieces[1];
            //get currency
            $reqCurrency                = getCurrencyById($row['currency']);
            $currency                   = $reqCurrency['currency_name'];
            //get Category Data
            $d1000C                     = getCategoryTypeById($row['d1000_category']);
            $d1000Category              = $d1000C['dc_name'];
            $d500                       = getCategoryTypeById($row['d500_category']);
            $d500Category               = $d500['dc_name'];
            $d200                       = getCategoryTypeById($row['d200_category']);
            $d200Category               = $d200['dc_name'];
            $d100                       = getCategoryTypeById($row['d100_category']);
            $d100Category               = $d100['dc_name'];
            $d50                        = getCategoryTypeById($row['d50_category']);
            $d50Category                = $d50['dc_name'];
            $d20                        = getCategoryTypeById($row['d20_category']);
            $d20Category                = $d20['dc_name'];
            $d10                        = getCategoryTypeById($row['d10_category']);
            $d10Category                = $d10['dc_name'];
            $d5                         = getCategoryTypeById($row['d5_category']);
            $d5Category                 = $d5['dc_name'];
            $d1                         = getCategoryTypeById($row['d1_category']);
            $d1Category                 = $d1['dc_name'];
            // Get Bank rep Data
            $getReqUserInfo             = $database->getUserInfo($row['added_by']);
            $getClientRepFullname       = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'].' '.$getReqUserInfo['middlename'];
            $getUserId                  = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
            $userUID                    = base64_encode($getUserId);   
            //Get Branch
            $reqClientBranch            = getClientBranchNameById($row['branch']);
            $clientBranch               = $reqClientBranch['name'];
            $output .= '
                    <tr>
                    <td>' . $sno++ . '</td>
                    <td>' . $sealNumber . '</td>
                    <td>' . $clientBranch . '</td>
                    <td>' . $currency . '</td>
                    <td>' . number_format($row['d1000_amount']) . '</td>
                    <td>' . $d1000Category . '</td>
                    <td>' . number_format($row['d500_amount']) . '</td>
                    <td>' . $d500Category . '</td>
                    <td>' . number_format($row['d200_amount']) . '</td>
                    <td>' . $d200Category . '</td>
                    <td>' . number_format($row['d100_amount']) . '</td>
                    <td>' . $d100Category . '</td>
                    <td>' . number_format($row['d50_amount']) . '</td>
                    <td>' . $d50Category . '</td>
                    <td>' . number_format($row['d20_amount']) . '</td>
                    <td>' . $d20Category . '</td>
                    <td>' . number_format($row['d10_amount']) . '</td>
                    <td>' . $d10Category . '</td>
                    <td>' . number_format($row['d5_amount']) . '</td>
                    <td>' . $d5Category . '</td>
                    <td>' . number_format($row['d1_amount']) . '</td>
                    <td>' . $d1Category . '</td>
                    <td>' . number_format($row['amount']) . '</td>
                    <td><a href="profile?r='.$getReqUserInfo['username'].'cprf'.$userUID .'" target="_blank" style="color: #4f2323 !important;">'.$getClientRepFullname.'</a></td>
                </tr>
            ';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename= BundleConfirmationExport.xls");
        header("Pragma: no-cache"); 
        header("Expires: 0");
        echo $output;
    }
}

// Get Branch Per Seal Number
if(isset($_POST["loadBranch"])){

    require_once('../core/db.php');

    $qSealNumber    = filter_var($_POST['qSealNumber'], FILTER_SANITIZE_STRING);

    $sql = "SELECT DISTINCT evacuation_id FROM evacuationpreparations WHERE seal_number = '$qSealNumber'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $erId = $row['evacuation_id'];
            // Get Branch
            $sql = "SELECT * FROM evacuations WHERE id = '$erId'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row['branch_id'];
                }
            }
        }
    }
}