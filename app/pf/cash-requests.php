<?php

$tblName = 'bank_requests';
$slug = 'er_slug';

$error = false;

if(isset($_POST["sendER"])){
    
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
        echo'Invalid Evacuation Request Name';
    }

    if (empty($consignmentLocation)) {
        $error = true;
        echo'Invalid Consignment Location';
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
        sendEvacReq($erName, $bankId, $clientBranch, $clientBranchL, $clientBranchLC, $consignmentLocation,  $erSlug, $username, $addedOn);
    }
}
// Add Evacaution Request function
function sendEvacReq($erName, $bankId, $clientBranch, $clientBranchL, $clientBranchLC, $consignmentLocation,  $erSlug, $addedBy, $addedOn)
{
    require('../core/db.php');

    $sql = "INSERT INTO bank_requests (er_name, bank_id, branch_id, location_code, consignment_location_id, er_slug, client_rep, updatedOn)
            VALUES ('$erName', '$bankId', '$clientBranch', '$clientBranchL', '$consignmentLocation', '$erSlug', '$addedBy', '$addedOn')";

    if ($con->query($sql) === true) {
        echo "rsent";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

if(isset($_POST["updateER"])){

    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $erId	 	            = filter_var($_POST['erId'], FILTER_SANITIZE_STRING);
    $erName	 	            = filter_var($_POST['erName'], FILTER_SANITIZE_STRING);
    $bankId	 	            = filter_var($_POST['bankId'], FILTER_SANITIZE_STRING);
    $consignmentLocation    = filter_var($_POST['consignmentLocation'], FILTER_SANITIZE_STRING);
    $clientBranchLC	 	    = filter_var($_POST['clientBranchLC'], FILTER_SANITIZE_STRING);
    $clientBranchL	 	    = filter_var($_POST['clientBranchL'], FILTER_SANITIZE_STRING);
    $clientBranch	 	    = filter_var($_POST['clientBranch'], FILTER_SANITIZE_STRING);
    $erSlug                 = filter_var($_POST['erSlug'], FILTER_SANITIZE_STRING);

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

    if (empty($erId)) {
        $error = true;
        echo'Invalid Evacuation Request ID';
    }

    if (empty($erName)) {
        $error = true;
        echo'Invalid Evacuation Request Name';
    }

    if (empty($consignmentLocation)) {
        $error = true;
        echo'Invalid Consignment Location';
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
        updateEvacReq($erId, $erName, $bankId, $clientBranch, $clientBranchL, $clientBranchLC, $consignmentLocation,  $erSlug, $username, $addedOn);
    }
}
// Update Evacaution Request function
function updateEvacReq($erId, $erName, $bankId, $clientBranch, $clientBranchL, $clientBranchLC, $consignmentLocation,  $erSlug, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "UPDATE bank_requests SET 
    er_name = '$erName',
    bank_id = '$bankId',
    branch_id = '$clientBranch',
    location_code = '$clientBranchL',
    consignment_location_id = '$consignmentLocation',
    client_rep = '$username',
    updatedOn = '$addedOn'
    WHERE er_id = '$erId' ";
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

// CBN Cash Allocation
if(isset($_POST["addCbnCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $cash1000 = 0;
    $cash1000Amount = 0;
    $cash500 = 0;
    $cash500Amount = 0;
    $cash200 = 0;
    $cash200Amount = 0;
    $cash100 = 0;
    $cash100Amount = 0;
    $cash50 = 0;
    $cash50Amount = 0;
    $cash20 = 0;
    $cash20Amount = 0;
    $cash10 = 0;
    $cash10Amount = 0;
    $cash5 = 0;
    $cash5Amount = 0;
    $cash1 = 0;
    $cash1Amount = 0;
    $totalAmountC = 0;

    $addedOn            = time();
    $cbn	 	        = 'naira';
    $evReqId	 	    = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);

    $cash1000 = filter_var($_POST['cash1000'], FILTER_SANITIZE_STRING);
    $cash1000Amount = filter_var($_POST['cash1000Amount'], FILTER_SANITIZE_STRING);
    $cash500 = filter_var($_POST['cash500'], FILTER_SANITIZE_STRING);
    $cash500Amount = filter_var($_POST['cash500Amount'], FILTER_SANITIZE_STRING);
    $cash200 = filter_var($_POST['cash200'], FILTER_SANITIZE_STRING);
    $cash200Amount = filter_var($_POST['cash200Amount'], FILTER_SANITIZE_STRING);
    $cash100 = filter_var($_POST['cash100'], FILTER_SANITIZE_STRING);
    $cash100Amount = filter_var($_POST['cash100Amount'], FILTER_SANITIZE_STRING);
    $cash50 = filter_var($_POST['cash50'], FILTER_SANITIZE_STRING);
    $cash50Amount = filter_var($_POST['cash50Amount'], FILTER_SANITIZE_STRING);
    $cash20 = filter_var($_POST['cash20'], FILTER_SANITIZE_STRING);
    $cash20Amount = filter_var($_POST['cash20Amount'], FILTER_SANITIZE_STRING);
    $cash10 = filter_var($_POST['cash10'], FILTER_SANITIZE_STRING);
    $cash10Amount = filter_var($_POST['cash10Amount'], FILTER_SANITIZE_STRING);
    $cash5 = filter_var($_POST['cash5'], FILTER_SANITIZE_STRING);
    $cash5Amount = filter_var($_POST['cash5Amount'], FILTER_SANITIZE_STRING);
    $cash1 = filter_var($_POST['cash1'], FILTER_SANITIZE_STRING);
    $cash1Amount = filter_var($_POST['cash1Amount'], FILTER_SANITIZE_STRING);
    $totalAmountC = filter_var($_POST['totalAmountC'], FILTER_SANITIZE_STRING);


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
        addCbnCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $cbn, $cash1000, $cash1000Amount, $cash500, $cash500Amount, $cash200, $cash200Amount, $cash100, $cash100Amount, $cash50, $cash50Amount, $cash20, $cash20Amount, $cash10, $cash10Amount, $cash5, $cash5Amount, $cash1, $cash1Amount, $totalAmountC, $username, $addedOn);
    }
}

// Add CBN Cash Allocation function
function addCbnCashAllocation($evReqId, $sealNumber, $depositType, $categoryType, $containerType, $cbn, $cash1000, $cash1000Amount, $cash500, $cash500Amount, $cash200, $cash200Amount, $cash100, $cash100Amount, $cash50, $cash50Amount, $cash20, $cash20Amount, $cash10, $cash10Amount, $cash5, $cash5Amount, $cash1, $cash1Amount, $totalAmountC, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$sealNumber', '$containerType', '$depositType', '$categoryType', '$cbn', '$cash1000', '$cash1000Amount', '$cash500', '$cash500Amount', '$cash200', '$cash200Amount', '$cash100', '$cash100Amount', '$cash50', '$cash50Amount', '$cash20', '$cash20Amount', '$cash10', '$cash10Amount', '$cash5', '$cash5Amount', '$cash1', '$cash1Amount', '$totalAmountC', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "cbnAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $sql = "INSERT INTO cash_preparations (ev_req_id, seal_number, container_type_id, deposit_type_id, category_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, total_amount, client_rep, updatedOn )
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
    $cmo	 	            = filter_var($_POST['cmo'], FILTER_SANITIZE_STRING);
    $erId	 	            = filter_var($_POST['erId'], FILTER_SANITIZE_STRING);
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $citConfirmationToken   = filter_var($_POST['citConfirmationToken'], FILTER_SANITIZE_STRING);
    $vehicle                = filter_var($_POST['vehicle'], FILTER_SANITIZE_STRING);

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
        addCho($cmo, $erId, $citConfirmationToken, $vehicle, $username, $addedOn);
    }
}

// Add Consignment Hand Over function
function addCho($cmo, $erId, $citConfirmationToken, $vehicle, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "UPDATE bank_requests SET 
            cit_reciever_id = '$cmo', 
            cit_confirmation_token = '$citConfirmationToken', 
            vehicle_id = '$vehicle',
            client_rep = '$username',
            cit = 'YES',
            er_status = 'Consignment Picked Up By CIT'
            WHERE er_id = $erId ";
    
    if ($con->query($sql) === true) {
        // Insert Seal Numbers Into CIT Table
        $sql = "SELECT * FROM cash_preparations WHERE ev_req_id = '$erId' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sealNumber = $row['seal_number'];
                $delievryStatus = 'In Transit';
                $sql2 = "INSERT INTO cit (ev_req_id, seal_number, vehicle_id, cit_officer_id, delivery_status, added_on, added_by)
                        VALUES ('$erId', '$sealNumber', '$vehicle', '$cmo', '$delievryStatus', '$addedOn', '$username')";
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
    $sql = "UPDATE bank_requests SET 
            cit_confirmation = 'RECEIVED',
            cit_confirmation_date = '$citConfirmationDate',
            er_status = 'Consignment Picked Up By CIT Confirmed'
            WHERE cit_reciever_id = '$username' AND er_id = '$erId' ";
    if ($con->query($sql) === true) {
        // Update CIT Table
        $sql = "UPDATE cit SET 
            picked_up_by = '$username',
            picked_up_on = '$citConfirmationDate'
            WHERE cit_officer_id = '$username' AND ev_req_id = '$erId' ";
        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
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
    $sql = "UPDATE bank_requests SET 
            cp_done = 'YES',
            er_status = 'Awaiting Consignment Pickup'
            WHERE client_rep = '$username' AND er_id = '$erId' ";
    
    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

if(isset($_POST["deleteThisBag"])){

    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumber	 	    = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);

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

    if (empty($sealNumber)) {
        $error = true;
        echo'Invalid Evacuation Request ID';
    }

    if( !$error ) {
        deleteBag($sealNumber, $username, $addedOn);
    }
}
// Update Evacaution Request function
function deleteBag($sealNumber, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "UPDATE cash_preparations SET 
    is_deleted = 'YES',
    deleted_by = '$username',
    deleted_on = '$addedOn'
    WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Get all Evacuation Requests
function getAllEvacuationRequests()
{
    $totalNaira = $totalEuro = $totalUsd = $totalGbp = $totalZar = $totalCfa = $totalCny = 0;
    // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM bank_requests WHERE preannounced = 'NO' ORDER BY er_id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Request Title</th>
                    <th>Client</th>
                    <th>Branch Location</th>
                    <th>Destination</th>
                    <th>Prepared</th>
                    <th class="width-25">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Request Title</th>
                    <th>Client</th>
                    <th>Branch Location</th>
                    <th>Destination</th>
                    <th>Prepared</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $bUID = $row['er_id'].'------'.$row['er_slug'].'------el';
            $bankUID = base64_encode($bUID);
            //get client name
            $reqClientName      = getClientNameById($row['bank_id']);
            $clientName         = $reqClientName['bank_name'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
            $consignmentLocation    = $reqConsLoc['location_name'];

            $citConfirmationToken = $row['er_id'] . 'cittoken18' . time() . 'cittoken18' . $row['bank_id'];

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td><a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['er_name'] . '</a></td>
                <td>' . $clientName . '</td>
                <td>' . $row['location_code'] . '</td>
                <td>'. $consignmentLocation .'</a></td>';
                echo '<td><strong>'; number_format(getNumberPreparedBagsPerRequest($row['er_id'])); echo '</strong> Bag(s)</td>
                <td>
                    <a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                        View  <i class="material-icons left">link</i>
                    </a>
                    ';
                    if ($row['cp_done'] == 'NO') {
                        echo '<a href="evacuation-request-p?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-edit waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                        Prepare Cash <i class="material-icons left">local_mall</i>
                        </a>';
                    }
                    if ( $row['cit'] == 'NO' && bagExists($row['er_id']) ) {
                        echo '<button data-target="hoc" class="btns btns-add waves-effect waves-teal cho modal-trigger" data-id="' . $row['er_id'].'" data-name="' . $row['er_name'].'" data-ctokn="' . $citConfirmationToken.'"><i class="material-icons left">rv_hookup</i> Hand Over Consignment </button>';
                    }
                    if ($session->isSuperAdmin() || $session->isBankerCmu()) {
                        echo '<a href="evacuation-request-e?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns light-blue waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                        Edit Request <i class="material-icons left">local_mall</i>
                        </a>';
                    }
                    echo '
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No request found. <a href="evacuation-request-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Request</a>';
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
    $sql = " SELECT * FROM bank_branch WHERE bank_id = '$cid' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Your Branch</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Container Types
function getContainerTypeList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM container_types ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Container Type</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['ct_id'].'">'.$row['ct_name'].'</option>';
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
            echo '<option value="'.$row['denomination_id'].'">'.$row['denomination_name'].'</option>';
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
            if ($row['currency_slug'] == 'usd') {
                $curSign = '&#36;';
            } else if ($row['currency_slug'] == 'gbp') {
                $curSign = '&#163;';
            } else if ($row['currency_slug'] == 'cny') {
                $curSign = '&#165;';
            } else if ($row['currency_slug'] == 'euro') {
                $curSign = '&#128;';
            } else if ($row['currency_slug'] == 'zar') {
                $curSign = '';
            } else if ($row['currency_slug'] == 'cfa') {
                $curSign = '';
            } else {
                $curSign = '&#8358;';
            }
            echo '<div class="col s4 m3 l3">
                    <input type="checkbox" id="'.$row['currency_slug'].'" />
                    <label for="'.$row['currency_slug'].'" class="black-text"><strong>'.$curSign.'</strong> '.$row['currency_name'].'</label>
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
    $sql = " SELECT * FROM deposit_types ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Deposit Type </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['dt_id'].'">'.$row['dt_name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Category Types
function getCategoryTypeList()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM deposit_category ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Category Type </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['dc_id'].'">'.$row['dc_name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Consignment Locations
function getConsignmentLocations()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM consignment_locations ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Consignment Location </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
        }
    }
    $con->close();
}

// Get List Of Consignment Locations For Bank View
function getConsignmentLocationsBankView()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM consignment_locations WHERE bankview = 'YES'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Consignment Location </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
        }
    }
    $con->close();
}