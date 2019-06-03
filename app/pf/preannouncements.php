<?php

$tblName = 'evacuations';
$slug = 'er_slug';

$error = false;

if(isset($_POST["initiateP"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $erName	 	            = filter_var($_POST['erName'], FILTER_SANITIZE_STRING);
    $bankId	 	            = filter_var($_POST['bankId'], FILTER_SANITIZE_STRING);
    $consignmentLocation    = filter_var($_POST['consignmentLocation'], FILTER_SANITIZE_STRING);
    $clientBranchLC	 	    = filter_var($_POST['clientBranchLC'], FILTER_SANITIZE_STRING);
    $clientBranchL	 	    = filter_var($_POST['clientBranchL'], FILTER_SANITIZE_STRING);
    $clientBranch	 	    = filter_var($_POST['clientBranch'], FILTER_SANITIZE_STRING);
    $erSlug                 = filter_var($_POST['erSlug'], FILTER_SANITIZE_STRING);
    $preannounced           = 'YES';

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

    if (empty($erName)) {
        $error = true;
        echo'Invalid Preannouncement Title Name';
    }

    if (empty($bankId)) {
        $error = true;
        echo'Invalid Client Name';
    }

    if (empty($consignmentLocation)) {
        $error = true;
        echo'Invalid Consignment Destination';
    }

    if (empty($clientBranchLC)) {
        $error = true;
        echo'Invalid Branch Location Code';
    }

    if (empty($clientBranchL)) {
        $error = true;
        echo'Invalid Branch Location';
    }

    if (empty($clientBranch)) {
        $error = true;
        echo'Invalid Branch';
    }

    if( !$error ) {
        initiateP($erName, $bankId, $clientBranch, $clientBranchL, $clientBranchLC, $consignmentLocation,  $erSlug, $username, $addedOn, $preannounced);
    }
}
// Add Evacaution Request function
function initiateP($erName, $bankId, $clientBranch, $clientBranchL, $clientBranchLC, $consignmentLocation,  $erSlug, $addedBy, $addedOn, $preannounced)
{
    require('../core/db.php');

    $sql = "INSERT INTO evacuations (er_name, bank_id, branch_id, location_code, consignment_location_id, er_slug, client_rep, updatedOn, er_status, preannounced)
            VALUES ('$erName', '$bankId', '$clientBranch', '$clientBranchL', '$consignmentLocation', '$erSlug', '$addedBy', '$addedOn', 'Awaiting Confirmation', '$preannounced')";

    if ($con->query($sql) === true) {
        echo "rsent";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

if(isset($_POST["addEvacReqs"])){

    require_once('../core/general-functions.php');

    $addedOn        = time();
    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $erName	 	= filter_var($_POST['erName'], FILTER_SANITIZE_STRING);
    $currency	 	= filter_var($_POST['currency'], FILTER_SANITIZE_STRING);
    $cash1000	 	= filter_var($_POST['cash1000'], FILTER_SANITIZE_STRING);
    $cash1000Amount       = filter_var($_POST['cash1000Amount'], FILTER_SANITIZE_STRING);
    $cash500	 	= filter_var($_POST['cash500'], FILTER_SANITIZE_STRING);
    $cash500Amount	 	= filter_var($_POST['cash500Amount'], FILTER_SANITIZE_STRING);
    $cash200       = filter_var($_POST['cash200'], FILTER_SANITIZE_STRING);
    $cash200Amount	 	= filter_var($_POST['cash200Amount'], FILTER_SANITIZE_STRING);
    $cash100	 	= filter_var($_POST['cash100'], FILTER_SANITIZE_STRING);
    $cash100Amount       = filter_var($_POST['cash100Amount'], FILTER_SANITIZE_STRING);
    $sealNumber	 	= filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType	 	= filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $bankId	 	= filter_var($_POST['bankId'], FILTER_SANITIZE_STRING);
    $containerType	 	= filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);
    $consignmentLocation       = filter_var($_POST['consignmentLocation'], FILTER_SANITIZE_STRING);

    $clientBranchLC	 	= filter_var($_POST['clientBranchLC'], FILTER_SANITIZE_STRING);
    $clientBranch	 	= filter_var($_POST['clientBranch'], FILTER_SANITIZE_STRING);
    $bankSlug       = filter_var($_POST['bankSlug'], FILTER_SANITIZE_STRING);

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

    if (empty($bankName)) {
        $error = true;
        echo'Invalid Bank Name';
    }

    if (empty($bankSlug)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($bankSlug) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (alreadyTaken($tblName, $slug, $bankSlug)) {
        $error = true;
        echo 'Bank Already Exists';
    }

    if( !$error ) {
        addEvacReq($erName, $bankId, $clientBranch, $clientBranchLC, $consignmentLocation, $containerType, $currency, $cash1000, $cash1000Amount, $cash500, $cash500Amount, $cash200, $cash200Amount, $cash100, $cash100Amount, $sealNumber, $depositType, $categoryType, $total_amount, $er_slug, $username, $addedOn);
    }
}

if(isset($_POST["updateER"])){

    require_once('../core/general-functions.php');

    $updatedOn      = time();
    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $uBankName	    = filter_var($_POST['ubankName'], FILTER_SANITIZE_STRING);
    $uBankCode	    = filter_var($_POST['ubankCode'], FILTER_SANITIZE_STRING);
    $uBankSlug      = filter_var($_POST['ubankSlug'], FILTER_SANITIZE_STRING);
    $uBankId        = filter_var($_POST['ubankId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($uBankName)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($uBankName) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    }

    if (empty($uBankCode)) {
        $error = true;
        echo'Invalid Bank Code';
    } else if (strlen($uBankCode) < 2) {
        $error = true;
        echo'Invalid Bank Code';
    }

    if (empty($uBankSlug)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($uBankSlug) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (alreadyTaken($tblName, $slug, $uBankSlug)) {
        $error = true;
        echo 'Bank Already Exists';
    }

    if( !$error ) {
        updateBank($uBankName, $uBankCode, $uBankSlug, $uBankId, $updatedOn, $username);
    }
}

// Naira Cash Allocation
if(isset($_POST["addNairaCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $ncash1000Amount = 0;
    $ncash500Amount = 0;
    $ncash200Amount = 0;
    $ncash100Amount = 0;
    $ncash50Amountt = 0;
    $ncash20Amount = 0;
    $ncash10Amount = 0;
    $ncash5Amount = 0;
    $ncash1Amount = 0;
    $nTotalAmount = 0;

    $addedOn            = time();
    $naira	 	        = filter_var($_POST['naira'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $ncash1000 = filter_var($_POST['ncash1000'], FILTER_SANITIZE_STRING);
    $ncash1000Amount = filter_var($_POST['ncash1000Amount'], FILTER_SANITIZE_STRING);
    $ncash500 = filter_var($_POST['ncash500'], FILTER_SANITIZE_STRING);
    $ncash500Amount = filter_var($_POST['ncash500Amount'], FILTER_SANITIZE_STRING);
    $ncash200 = filter_var($_POST['ncash200'], FILTER_SANITIZE_STRING);
    $ncash200Amount = filter_var($_POST['ncash200Amount'], FILTER_SANITIZE_STRING);
    $ncash100 = filter_var($_POST['ncash100'], FILTER_SANITIZE_STRING);
    $ncash100Amount = filter_var($_POST['ncash100Amount'], FILTER_SANITIZE_STRING);
    $ncash50 = filter_var($_POST['ncash50'], FILTER_SANITIZE_STRING);
    $ncash50Amount = filter_var($_POST['ncash50Amount'], FILTER_SANITIZE_STRING);
    $ncash20 = filter_var($_POST['ncash20'], FILTER_SANITIZE_STRING);
    $ncash20Amount = filter_var($_POST['ncash20Amount'], FILTER_SANITIZE_STRING);
    $ncash10 = filter_var($_POST['ncash10'], FILTER_SANITIZE_STRING);
    $ncash10Amount = filter_var($_POST['ncash10Amount'], FILTER_SANITIZE_STRING);
    $ncash5 = filter_var($_POST['ncash5'], FILTER_SANITIZE_STRING);
    $ncash5Amount = filter_var($_POST['ncash5Amount'], FILTER_SANITIZE_STRING);
    $ncash1 = filter_var($_POST['ncash1'], FILTER_SANITIZE_STRING);
    $ncash1Amount = filter_var($_POST['ncash1Amount'], FILTER_SANITIZE_STRING);
    $nTotalAmount = filter_var($_POST['nTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addNairaCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $naira, $ncash1000, $ncash1000Amount, $ncash500, $ncash500Amount, $ncash200, $ncash200Amount, $ncash100, $ncash100Amount, $ncash50, $ncash50Amount, $ncash20, $ncash20Amount, $ncash10, $ncash10Amount, $ncash5, $ncash5Amount, $ncash1, $ncash1Amount, $nTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function
function addNairaCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $naira, $ncash1000, $ncash1000Amount, $ncash500, $ncash500Amount, $ncash200, $ncash200Amount, $ncash100, $ncash100Amount, $ncash50, $ncash50Amount, $ncash20, $ncash20Amount, $ncash10, $ncash10Amount, $ncash5, $ncash5Amount, $ncash1, $ncash1Amount, $nTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$naira', '$ncash1000', '$ncash1000Amount', '$ncash500', '$ncash500Amount', '$ncash200', '$ncash200Amount', '$ncash100', '$ncash100Amount', '$ncash50', '$ncash50Amount', '$ncash20', '$ncash20Amount', '$ncash10', '$ncash10Amount', '$ncash5', '$ncash5Amount', '$ncash1', '$ncash1Amount', '$nTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "nAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}


// Dollar Cash Allocation
if(isset($_POST["addDollarCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $ucash1000Amount = 0;
    $ucash500Amount = 0;
    $ucash200Amount = 0;
    $ucash100Amount = 0;
    $ucash50Amountt = 0;
    $ucash20Amount = 0;
    $ucash10Amount = 0;
    $ucash5Amount = 0;
    $ucash1Amount = 0;
    $uTotalAmount = 0;

    $addedOn            = time();
    $usd	 	        = filter_var($_POST['usd'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $ucash1000 = filter_var($_POST['ucash1000'], FILTER_SANITIZE_STRING);
    $ucash1000Amount = filter_var($_POST['ucash1000Amount'], FILTER_SANITIZE_STRING);
    $ucash500 = filter_var($_POST['ucash500'], FILTER_SANITIZE_STRING);
    $ucash500Amount = filter_var($_POST['ucash500Amount'], FILTER_SANITIZE_STRING);
    $ucash200 = filter_var($_POST['ucash200'], FILTER_SANITIZE_STRING);
    $ucash200Amount = filter_var($_POST['ucash200Amount'], FILTER_SANITIZE_STRING);
    $ucash100 = filter_var($_POST['ucash100'], FILTER_SANITIZE_STRING);
    $ucash100Amount = filter_var($_POST['ucash100Amount'], FILTER_SANITIZE_STRING);
    $ucash50 = filter_var($_POST['ucash50'], FILTER_SANITIZE_STRING);
    $ucash50Amount = filter_var($_POST['ucash50Amount'], FILTER_SANITIZE_STRING);
    $ucash20 = filter_var($_POST['ucash20'], FILTER_SANITIZE_STRING);
    $ucash20Amount = filter_var($_POST['ucash20Amount'], FILTER_SANITIZE_STRING);
    $ucash10 = filter_var($_POST['ucash10'], FILTER_SANITIZE_STRING);
    $ucash10Amount = filter_var($_POST['ucash10Amount'], FILTER_SANITIZE_STRING);
    $ucash5 = filter_var($_POST['ucash5'], FILTER_SANITIZE_STRING);
    $ucash5Amount = filter_var($_POST['ucash5Amount'], FILTER_SANITIZE_STRING);
    $ucash1 = filter_var($_POST['ucash1'], FILTER_SANITIZE_STRING);
    $ucash1Amount = filter_var($_POST['ucash1Amount'], FILTER_SANITIZE_STRING);
    $uTotalAmount = filter_var($_POST['uTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addDollarCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $usd, $ucash1000, $ucash1000Amount, $ucash500, $ucash500Amount, $ucash200, $ucash200Amount, $ucash100, $ucash100Amount, $ucash50, $ucash50Amount, $ucash20, $ucash20Amount, $ucash10, $ucash10Amount, $ucash5, $ucash5Amount, $ucash1, $ucash1Amount, $uTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function - Dollar
function addDollarCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $usd, $ucash1000, $ucash1000Amount, $ucash500, $ucash500Amount, $ucash200, $ucash200Amount, $ucash100, $ucash100Amount, $ucash50, $ucash50Amount, $ucash20, $ucash20Amount, $ucash10, $ucash10Amount, $ucash5, $ucash5Amount, $ucash1, $ucash1Amount, $uTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$usd', '$ucash1000', '$ucash1000Amount', '$ucash500', '$ucash500Amount', '$ucash200', '$ucash200Amount', '$ucash100', '$ucash100Amount', '$ucash50', '$ucash50Amount', '$ucash20', '$ucash20Amount', '$ucash10', '$ucash10Amount', '$ucash5', '$ucash5Amount', '$ucash1', '$ucash1Amount', '$uTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "uAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Euro Cash Allocation
if(isset($_POST["addEuroCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $ecash1000Amount = 0;
    $ecash500Amount = 0;
    $ecash200Amount = 0;
    $ecash100Amount = 0;
    $ecash50Amountt = 0;
    $ecash20Amount = 0;
    $ecash10Amount = 0;
    $ecash5Amount = 0;
    $ecash1Amount = 0;
    $eTotalAmount = 0;

    $addedOn            = time();
    $euro	 	        = filter_var($_POST['euro'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $ecash1000 = filter_var($_POST['ecash1000'], FILTER_SANITIZE_STRING);
    $ecash1000Amount = filter_var($_POST['ecash1000Amount'], FILTER_SANITIZE_STRING);
    $ecash500 = filter_var($_POST['ecash500'], FILTER_SANITIZE_STRING);
    $ecash500Amount = filter_var($_POST['ecash500Amount'], FILTER_SANITIZE_STRING);
    $ecash200 = filter_var($_POST['ecash200'], FILTER_SANITIZE_STRING);
    $ecash200Amount = filter_var($_POST['ecash200Amount'], FILTER_SANITIZE_STRING);
    $ecash100 = filter_var($_POST['ecash100'], FILTER_SANITIZE_STRING);
    $ecash100Amount = filter_var($_POST['ecash100Amount'], FILTER_SANITIZE_STRING);
    $ecash50 = filter_var($_POST['ecash50'], FILTER_SANITIZE_STRING);
    $ecash50Amount = filter_var($_POST['ecash50Amount'], FILTER_SANITIZE_STRING);
    $ecash20 = filter_var($_POST['ecash20'], FILTER_SANITIZE_STRING);
    $ecash20Amount = filter_var($_POST['ecash20Amount'], FILTER_SANITIZE_STRING);
    $ecash10 = filter_var($_POST['ecash10'], FILTER_SANITIZE_STRING);
    $ecash10Amount = filter_var($_POST['ecash10Amount'], FILTER_SANITIZE_STRING);
    $ecash5 = filter_var($_POST['ecash5'], FILTER_SANITIZE_STRING);
    $ecash5Amount = filter_var($_POST['ecash5Amount'], FILTER_SANITIZE_STRING);
    $ecash1 = filter_var($_POST['ecash1'], FILTER_SANITIZE_STRING);
    $ecash1Amount = filter_var($_POST['ecash1Amount'], FILTER_SANITIZE_STRING);
    $eTotalAmount = filter_var($_POST['eTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addEuroCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $euro, $ecash1000, $ecash1000Amount, $ecash500, $ecash500Amount, $ecash200, $ecash200Amount, $ecash100, $ecash100Amount, $ecash50, $ecash50Amount, $ecash20, $ecash20Amount, $ecash10, $ecash10Amount, $ecash5, $ecash5Amount, $ecash1, $ecash1Amount, $eTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function - Euro
function addEuroCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $euro, $ecash1000, $ecash1000Amount, $ecash500, $ecash500Amount, $ecash200, $ecash200Amount, $ecash100, $ecash100Amount, $ecash50, $ecash50Amount, $ecash20, $ecash20Amount, $ecash10, $ecash10Amount, $ecash5, $ecash5Amount, $ecash1, $ecash1Amount, $eTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$euro', '$ecash1000', '$ecash1000Amount', '$ecash500', '$ecash500Amount', '$ecash200', '$ecash200Amount', '$ecash100', '$ecash100Amount', '$ecash50', '$ecash50Amount', '$ecash20', '$ecash20Amount', '$ecash10', '$ecash10Amount', '$ecash5', '$ecash5Amount', '$ecash1', '$ecash1Amount', '$eTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "eAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Pounds Cash Allocation
if(isset($_POST["addPoundsCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $gcash1000Amount = 0;
    $gcash500Amount = 0;
    $gcash200Amount = 0;
    $gcash100Amount = 0;
    $gcash50Amountt = 0;
    $gcash20Amount = 0;
    $gcash10Amount = 0;
    $gcash5Amount = 0;
    $gcash1Amount = 0;
    $gTotalAmount = 0;

    $addedOn            = time();
    $gbp	 	        = filter_var($_POST['gbp'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $gcash1000 = filter_var($_POST['gcash1000'], FILTER_SANITIZE_STRING);
    $gcash1000Amount = filter_var($_POST['gcash1000Amount'], FILTER_SANITIZE_STRING);
    $gcash500 = filter_var($_POST['gcash500'], FILTER_SANITIZE_STRING);
    $gcash500Amount = filter_var($_POST['gcash500Amount'], FILTER_SANITIZE_STRING);
    $gcash200 = filter_var($_POST['gcash200'], FILTER_SANITIZE_STRING);
    $gcash200Amount = filter_var($_POST['gcash200Amount'], FILTER_SANITIZE_STRING);
    $gcash100 = filter_var($_POST['gcash100'], FILTER_SANITIZE_STRING);
    $gcash100Amount = filter_var($_POST['gcash100Amount'], FILTER_SANITIZE_STRING);
    $gcash50 = filter_var($_POST['gcash50'], FILTER_SANITIZE_STRING);
    $gcash50Amount = filter_var($_POST['gcash50Amount'], FILTER_SANITIZE_STRING);
    $gcash20 = filter_var($_POST['gcash20'], FILTER_SANITIZE_STRING);
    $gcash20Amount = filter_var($_POST['gcash20Amount'], FILTER_SANITIZE_STRING);
    $gcash10 = filter_var($_POST['gcash10'], FILTER_SANITIZE_STRING);
    $gcash10Amount = filter_var($_POST['gcash10Amount'], FILTER_SANITIZE_STRING);
    $gcash5 = filter_var($_POST['gcash5'], FILTER_SANITIZE_STRING);
    $gcash5Amount = filter_var($_POST['gcash5Amount'], FILTER_SANITIZE_STRING);
    $gcash1 = filter_var($_POST['gcash1'], FILTER_SANITIZE_STRING);
    $gcash1Amount = filter_var($_POST['gcash1Amount'], FILTER_SANITIZE_STRING);
    $gTotalAmount = filter_var($_POST['gTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addPoundsCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $gbp, $gcash1000, $gcash1000Amount, $gcash500, $gcash500Amount, $gcash200, $gcash200Amount, $gcash100, $gcash100Amount, $gcash50, $gcash50Amount, $gcash20, $gcash20Amount, $gcash10, $gcash10Amount, $gcash5, $gcash5Amount, $gcash1, $gcash1Amount, $gTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function - Pounds
function addPoundsCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $gbp, $gcash1000, $gcash1000Amount, $gcash500, $gcash500Amount, $gcash200, $gcash200Amount, $gcash100, $gcash100Amount, $gcash50, $gcash50Amount, $gcash20, $gcash20Amount, $gcash10, $gcash10Amount, $gcash5, $gcash5Amount, $gcash1, $gcash1Amount, $gTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$gbp', '$gcash1000', '$gcash1000Amount', '$gcash500', '$gcash500Amount', '$gcash200', '$gcash200Amount', '$gcash100', '$gcash100Amount', '$gcash50', '$gcash50Amount', '$gcash20', '$gcash20Amount', '$gcash10', '$gcash10Amount', '$gcash5', '$gcash5Amount', '$gcash1', '$gcash1Amount', '$gTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "gAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Zar Cash Allocation
if(isset($_POST["addZarCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $zcash1000Amount = 0;
    $zcash500Amount = 0;
    $zcash200Amount = 0;
    $zcash100Amount = 0;
    $zcash50Amountt = 0;
    $zcash20Amount = 0;
    $zcash10Amount = 0;
    $zcash5Amount = 0;
    $zcash1Amount = 0;
    $zTotalAmount = 0;

    $addedOn            = time();
    $zar	 	        = filter_var($_POST['zar'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $zcash1000 = filter_var($_POST['zcash1000'], FILTER_SANITIZE_STRING);
    $zcash1000Amount = filter_var($_POST['zcash1000Amount'], FILTER_SANITIZE_STRING);
    $zcash500 = filter_var($_POST['zcash500'], FILTER_SANITIZE_STRING);
    $zcash500Amount = filter_var($_POST['zcash500Amount'], FILTER_SANITIZE_STRING);
    $zcash200 = filter_var($_POST['zcash200'], FILTER_SANITIZE_STRING);
    $zcash200Amount = filter_var($_POST['zcash200Amount'], FILTER_SANITIZE_STRING);
    $zcash100 = filter_var($_POST['zcash100'], FILTER_SANITIZE_STRING);
    $zcash100Amount = filter_var($_POST['zcash100Amount'], FILTER_SANITIZE_STRING);
    $zcash50 = filter_var($_POST['zcash50'], FILTER_SANITIZE_STRING);
    $zcash50Amount = filter_var($_POST['zcash50Amount'], FILTER_SANITIZE_STRING);
    $zcash20 = filter_var($_POST['zcash20'], FILTER_SANITIZE_STRING);
    $zcash20Amount = filter_var($_POST['zcash20Amount'], FILTER_SANITIZE_STRING);
    $zcash10 = filter_var($_POST['zcash10'], FILTER_SANITIZE_STRING);
    $zcash10Amount = filter_var($_POST['zcash10Amount'], FILTER_SANITIZE_STRING);
    $zcash5 = filter_var($_POST['zcash5'], FILTER_SANITIZE_STRING);
    $zcash5Amount = filter_var($_POST['zcash5Amount'], FILTER_SANITIZE_STRING);
    $zcash1 = filter_var($_POST['zcash1'], FILTER_SANITIZE_STRING);
    $zcash1Amount = filter_var($_POST['zcash1Amount'], FILTER_SANITIZE_STRING);
    $zTotalAmount = filter_var($_POST['zTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addZarCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $zar, $zcash1000, $zcash1000Amount, $zcash500, $zcash500Amount, $zcash200, $zcash200Amount, $zcash100, $zcash100Amount, $zcash50, $zcash50Amount, $zcash20, $zcash20Amount, $zcash10, $zcash10Amount, $zcash5, $zcash5Amount, $zcash1, $zcash1Amount, $zTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function - Zar
function addZarCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $zar, $zcash1000, $zcash1000Amount, $zcash500, $zcash500Amount, $zcash200, $zcash200Amount, $zcash100, $zcash100Amount, $zcash50, $zcash50Amount, $zcash20, $zcash20Amount, $zcash10, $zcash10Amount, $zcash5, $zcash5Amount, $zcash1, $zcash1Amount, $zTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$zar', '$zcash1000', '$zcash1000Amount', '$zcash500', '$zcash500Amount', '$zcash200', '$zcash200Amount', '$zcash100', '$zcash100Amount', '$zcash50', '$zcash50Amount', '$zcash20', '$zcash20Amount', '$zcash10', '$zcash10Amount', '$zcash5', '$zcash5Amount', '$zcash1', '$zcash1Amount', '$zTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "zAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// CFA Cash Allocation
if(isset($_POST["addCfaCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $ccash1000Amount = 0;
    $ccash500Amount = 0;
    $ccash200Amount = 0;
    $ccash100Amount = 0;
    $ccash50Amountt = 0;
    $ccash20Amount = 0;
    $ccash10Amount = 0;
    $ccash5Amount = 0;
    $ccash1Amount = 0;
    $cTotalAmount = 0;

    $addedOn            = time();
    $cfa	 	        = filter_var($_POST['cfa'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $ccash1000 = filter_var($_POST['ccash1000'], FILTER_SANITIZE_STRING);
    $ccash1000Amount = filter_var($_POST['ccash1000Amount'], FILTER_SANITIZE_STRING);
    $ccash500 = filter_var($_POST['ccash500'], FILTER_SANITIZE_STRING);
    $ccash500Amount = filter_var($_POST['ccash500Amount'], FILTER_SANITIZE_STRING);
    $ccash200 = filter_var($_POST['ccash200'], FILTER_SANITIZE_STRING);
    $ccash200Amount = filter_var($_POST['ccash200Amount'], FILTER_SANITIZE_STRING);
    $ccash100 = filter_var($_POST['ccash100'], FILTER_SANITIZE_STRING);
    $ccash100Amount = filter_var($_POST['ccash100Amount'], FILTER_SANITIZE_STRING);
    $ccash50 = filter_var($_POST['ccash50'], FILTER_SANITIZE_STRING);
    $ccash50Amount = filter_var($_POST['ccash50Amount'], FILTER_SANITIZE_STRING);
    $ccash20 = filter_var($_POST['ccash20'], FILTER_SANITIZE_STRING);
    $ccash20Amount = filter_var($_POST['ccash20Amount'], FILTER_SANITIZE_STRING);
    $ccash10 = filter_var($_POST['ccash10'], FILTER_SANITIZE_STRING);
    $ccash10Amount = filter_var($_POST['ccash10Amount'], FILTER_SANITIZE_STRING);
    $ccash5 = filter_var($_POST['ccash5'], FILTER_SANITIZE_STRING);
    $ccash5Amount = filter_var($_POST['ccash5Amount'], FILTER_SANITIZE_STRING);
    $ccash1 = filter_var($_POST['ccash1'], FILTER_SANITIZE_STRING);
    $ccash1Amount = filter_var($_POST['ccash1Amount'], FILTER_SANITIZE_STRING);
    $cTotalAmount = filter_var($_POST['cTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addCfaCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $cfa, $ccash1000, $ccash1000Amount, $ccash500, $ccash500Amount, $ccash200, $ccash200Amount, $ccash100, $ccash100Amount, $ccash50, $ccash50Amount, $ccash20, $ccash20Amount, $ccash10, $ccash10Amount, $ccash5, $ccash5Amount, $ccash1, $ccash1Amount, $cTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function - Cfa
function addCfaCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $cfa, $ccash1000, $ccash1000Amount, $ccash500, $ccash500Amount, $ccash200, $ccash200Amount, $ccash100, $ccash100Amount, $ccash50, $ccash50Amount, $ccash20, $ccash20Amount, $ccash10, $ccash10Amount, $ccash5, $ccash5Amount, $ccash1, $ccash1Amount, $cTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$cfa', '$ccash1000', '$ccash1000Amount', '$ccash500', '$ccash500Amount', '$ccash200', '$ccash200Amount', '$ccash100', '$ccash100Amount', '$ccash50', '$ccash50Amount', '$ccash20', '$ccash20Amount', '$ccash10', '$ccash10Amount', '$ccash5', '$ccash5Amount', '$ccash1', '$ccash1Amount', '$cTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "cAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// CNY Cash Allocation
if(isset($_POST["addCnyCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $ycash1000Amount = 0;
    $ycash500Amount = 0;
    $ycash200Amount = 0;
    $ycash100Amount = 0;
    $ycash50Amountt = 0;
    $ycash20Amount = 0;
    $ycash10Amount = 0;
    $ycash5Amount = 0;
    $ycash1Amount = 0;
    $yTotalAmount = 0;

    $addedOn            = time();
    $cny	 	        = filter_var($_POST['cny'], FILTER_SANITIZE_STRING);
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

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

    $ycash1000 = filter_var($_POST['ycash1000'], FILTER_SANITIZE_STRING);
    $ycash1000Amount = filter_var($_POST['ycash1000Amount'], FILTER_SANITIZE_STRING);
    $ycash500 = filter_var($_POST['ycash500'], FILTER_SANITIZE_STRING);
    $ycash500Amount = filter_var($_POST['ycash500Amount'], FILTER_SANITIZE_STRING);
    $ycash200 = filter_var($_POST['ycash200'], FILTER_SANITIZE_STRING);
    $ycash200Amount = filter_var($_POST['ycash200Amount'], FILTER_SANITIZE_STRING);
    $ycash100 = filter_var($_POST['ycash100'], FILTER_SANITIZE_STRING);
    $ycash100Amount = filter_var($_POST['ycash100Amount'], FILTER_SANITIZE_STRING);
    $ycash50 = filter_var($_POST['ycash50'], FILTER_SANITIZE_STRING);
    $ycash50Amount = filter_var($_POST['ycash50Amount'], FILTER_SANITIZE_STRING);
    $ycash20 = filter_var($_POST['ycash20'], FILTER_SANITIZE_STRING);
    $ycash20Amount = filter_var($_POST['ycash20Amount'], FILTER_SANITIZE_STRING);
    $ycash10 = filter_var($_POST['ycash10'], FILTER_SANITIZE_STRING);
    $ycash10Amount = filter_var($_POST['ycash10Amount'], FILTER_SANITIZE_STRING);
    $ycash5 = filter_var($_POST['ycash5'], FILTER_SANITIZE_STRING);
    $ycash5Amount = filter_var($_POST['ycash5Amount'], FILTER_SANITIZE_STRING);
    $ycash1 = filter_var($_POST['ycash1'], FILTER_SANITIZE_STRING);
    $ycash1Amount = filter_var($_POST['ycash1Amount'], FILTER_SANITIZE_STRING);
    $yTotalAmount = filter_var($_POST['yTotalAmount'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        addCnyCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $cny, $ycash1000, $ycash1000Amount, $ycash500, $ycash500Amount, $ycash200, $ycash200Amount, $ycash100, $ycash100Amount, $ycash50, $ycash50Amount, $ycash20, $ycash20Amount, $ycash10, $ycash10Amount, $ycash5, $ycash5Amount, $ycash1, $ycash1Amount, $yTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function - Cny
function addCnyCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $cny, $ycash1000, $ycash1000Amount, $ycash500, $ycash500Amount, $ycash200, $ycash200Amount, $ycash100, $ycash100Amount, $ycash50, $ycash50Amount, $ycash20, $ycash20Amount, $ycash10, $ycash10Amount, $ycash5, $ycash5Amount, $ycash1, $ycash1Amount, $yTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO evacuationpreparations (evacuation_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$cny', '$ycash1000', '$ycash1000Amount', '$ycash500', '$ycash500Amount', '$ycash200', '$ycash200Amount', '$ycash100', '$ycash100Amount', '$ycash50', '$ycash50Amount', '$ycash20', '$ycash20Amount', '$ycash10', '$ycash10Amount', '$ycash5', '$ycash5Amount', '$ycash1', '$ycash1Amount', '$yTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "yAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Add Consignment Hand Over
if(isset($_POST["addCHO"])){
    
    require_once('../core/general-functions.php');

    $addedOn                = time();
    $erId	 	            = filter_var($_POST['erId'], FILTER_SANITIZE_STRING);
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $tap   = filter_var($_POST['tap'], FILTER_SANITIZE_STRING);
    $bbCid   = filter_var($_POST['bbCid'], FILTER_SANITIZE_STRING);
    $citConfirmationToken   = filter_var($_POST['citConfirmationToken'], FILTER_SANITIZE_STRING);
    $vehicle                = '';
    $cmo	 	            = '';
    $citConfirmationDate    = date('m/d/y');

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
        addCho($erId, $tap, $bbCid, $citConfirmationToken, $citConfirmationDate, $username, $addedOn);
    }
}

// Add Consignment Hand Over function
function addCho($erId, $tap, $bbCid, $citConfirmationToken, $citConfirmationDate, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "UPDATE evacuations SET 
            cit_reciever_id = '$username', 
            cit_confirmation_token = '$citConfirmationToken', 
            client_rep = '$username',
            cit = 'YES',
            cit_confirmation = 'RECEIVED',
            cit_confirmation_date = '$citConfirmationDate',
            er_status = 'Preannouncement Completed'
            WHERE id = $erId ";
    
    if ($con->query($sql) === true) {
        // Update CLient Book Balance
        $sqlbb = "SELECT * FROM bookballances WHERE banks_id = '$bbCid' LIMIT 1 ";
        $resultbb = $con->query($sqlbb);
        if ($resultbb->num_rows > 0) {
            while ($rowbb = $resultbb->fetch_assoc()) {
                $bb_balance = $rowbb['bb_balance'] + $tap ;
                // Update Existing Record
                $sqlu = "UPDATE bookballances SET 
                bb_balance = '$bb_balance',
                last_update = '$addedOn'
                WHERE banks_id = '$bbCid' ";  
                if ($con->query($sqlu) === true) {
                    echo "";
                } else {
                    echo "Error: " . $sqlu . "<br>" . $con->error;
                }
            }
        } else {
            // Insert New Record
            $sqli = "INSERT INTO bookballances (banks_id, bb_balance, last_update)
                    VALUES ('$bbCid', '$tap', '$addedOn')";
            if ($con->query($sqli) === true) {
                echo "";
            } else {
                echo "Error: " . $sqli . "<br>" . $con->error;
            }
        }
        // Insert Seal Numbers Into CIT Table
        $sql = "SELECT * FROM evacuationpreparations WHERE evacuation_id = '$erId' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sealNumber = $row['seal_number'];
                $delievryStatus = 'Preannouncement Completed';
                $sql2 = "INSERT INTO cits (evacuation_id, seal_number, delivery_status, added_on, added_by, picked_up_by, picked_up_on, received_by, received_on)
                        VALUES ('$erId', '$sealNumber', '$delievryStatus', '$addedOn', '$username', '$username', '$addedOn', '$username', '$addedOn')";
                if ($con->query($sql2) === true) {
                    echo "";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            }
        }
        echo "choAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Add Consignment Hand Over
if(isset($_POST["confirmReceipt"])){
    
    require_once('../core/general-functions.php');

    $erId	 	            = filter_var($_POST['erId'], FILTER_SANITIZE_STRING);
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $citConfirmationDate    = date('m/d/y');

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
        confirmCHO($erId, $citConfirmationDate, $username);
    }
}

// Confirm Consignment Hand Over function
function confirmCHO($erId, $citConfirmationDate, $username)
{
    require('../core/db.php');
    $sql = "UPDATE evacuations SET 
            cit_confirmation = 'RECEIVED',
            cit_confirmation_date = '$citConfirmationDate',
            er_status = 'Consignment Picked Up By CIT Confirmed'
            WHERE cit_reciever_id = '$username' AND id = '$erId' ";
    
    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Done All
if(isset($_POST["doneAll"])){
    
    require_once('../core/general-functions.php');

    $erId	 	            = filter_var($_POST['erId'], FILTER_SANITIZE_STRING);
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);

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
        doneAll($erId, $username);
    }
}
// Done All function
function doneAll($erId, $username)
{
    require('../core/db.php');
    $sql = "UPDATE evacuations SET 
            cp_done = 'YES',
            er_status = 'Awaiting Consignment Pickup'
            WHERE client_rep = '$username' AND id = '$erId' ";
    
    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Display Requested Client Name By slug
function getBankName($slug)
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = "SELECT * FROM banks WHERE bank_slug = '$slug' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['bank_name'];
        }
    } else {
        echo 'Client';
    }
    $con->close();
}

// Get List Of Client Branches
function getClientBranhcesList($cid)
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM bank_branches WHERE banks_id = '$cid' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Container Types
function getContainerTypeList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM containertypes ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Container Type</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Denomination
function getDenominationTypeList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM denominations ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Denomination Type</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Currencies
function getCurrencyList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $curSign = '';
    $sql = " SELECT * FROM currencies ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['slug'] == 'usd') {
                $curSign = '&#36;';
            } else if ($row['slug'] == 'gbp') {
                $curSign = '&#163;';
            } else if ($row['slug'] == 'cny') {
                $curSign = '&#165;';
            } else if ($row['slug'] == 'euro') {
                $curSign = '&#128;';
            } else if ($row['slug'] == 'zar') {
                $curSign = '';
            } else if ($row['slug'] == 'cfa') {
                $curSign = '';
            } else {
                $curSign = '&#8358;';
            }
            echo '<div class="col s4 m3 l3">
                    <input type="checkbox" id="'.$row['slug'].'" />
                    <label for="'.$row['slug'].'" class="black-text"><strong>'.$curSign.'</strong> '.$row['name'].'</label>
                </div>';
        }

    }
    $con->close();
}

// Get List Of Deposit Types
function getDepositTypeList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM deposittypes ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Deposit Type </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Category Types
function getCategoryTypeList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM depositcategories ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Category Type </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Consignment Locations
function getConsignmentLocations()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM consignmentlocations ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Consignment Location </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Consignment Locations For Bank View
function getConsignmentLocationsBankView()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM consignmentlocations WHERE bankview = 'YES'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Consignment Location </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}