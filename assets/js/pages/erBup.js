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





if(isset($_POST["addCashAllocation"])){
    
    require_once('../core/general-functions.php');

    $ncash1000 = 0;
    $ncash1000Amount = 0;
    $ncash500 = 0;
    $ncash500Amount = 0;
    $ncash200 = 0;
    $ncash200Amount = 0;
    $ncash100 = 0;
    $ncash100Amount = 0;
    $ncash50 = 0;
    $ncash50Amountt = 0;
    $ncash20 = 0;
    $ncash20Amount = 0;
    $ncash10 = 0;
    $ncash10Amount = 0;
    $ncash5 = 0;
    $ncash5Amount = 0;
    $ncash1 = 0;
    $ncash1Amount = 0;
    $nTotalAmount = 0;

    $ecash1000 = 0;
    $ecash1000Amount = 0;
    $ecash500 = 0;
    $ecash500Amount = 0;
    $ecash200 = 0;
    $ecash200Amount = 0;
    $ecash100 = 0;
    $ecash100Amount = 0;
    $ecash50 = 0;
    $ecash50Amount = 0;
    $ecash20 = 0;
    $ecash20Amount = 0;
    $ecash10 = 0;
    $ecash10Amount = 0;
    $ecash5 = 0;
    $ecash5Amount = 0;
    $ecash1 = 0;
    $ecash1Amount = 0;
    $eTotalAmount = 0;

    $ucash1000 = 0;
    $ucash1000Amount = 0;
    $ucash500 = 0;
    $ucash500Amount = 0;
    $ucash200 = 0;
    $ucash200Amount = 0;
    $ucash100 = 0;
    $ucash100Amount = 0;
    $ucash50 = 0;
    $ucash50Amountt = 0;
    $ucash20 = 0;
    $ucash20Amount = 0;
    $ucash10 = 0;
    $ucash10Amount = 0;
    $ucash5 = 0;
    $ucash5Amount = 0;
    $ucash1 = 0;
    $ucash1Amount = 0;
    $uTotalAmount = 0;

    $gcash1000 = 0;
    $gcash1000Amount = 0;
    $gcash500 = 0;
    $gcash500Amount = 0;
    $gcash200 = 0;
    $gcash200Amount = 0;
    $gcash100 = 0;
    $gcash100Amount = 0;
    $gcash50 = 0;
    $gcash50Amountt = 0;
    $gcash20 = 0;
    $gcash20Amount = 0;
    $gcash10 = 0;
    $gcash10Amount = 0;
    $gcash5 = 0;
    $gcash5Amount = 0;
    $gcash1 = 0;
    $gcash1Amount = 0;
    $gTotalAmount = 0;

    $zcash1000 = 0;
    $zcash1000Amount = 0;
    $zcash500 = 0;
    $zcash500Amount = 0;
    $zcash200 = 0;
    $zcash200Amount = 0;
    $zcash100 = 0;
    $zcash100Amount = 0;
    $zcash50 = 0;
    $zcash50Amountt = 0;
    $zcash20 = 0;
    $zcash20Amount = 0;
    $zcash10 = 0;
    $zcash10Amount = 0;
    $zcash5 = 0;
    $zcash5Amount = 0;
    $zcash1 = 0;
    $zcash1Amount = 0;
    $zTotalAmount = 0;

    $ccash1000 = 0;
    $ccash1000Amount = 0;
    $ccash500 = 0;
    $ccash500Amount = 0;
    $ccash200 = 0;
    $ccash200Amount = 0;
    $ccash100 = 0;
    $ccash100Amount = 0;
    $ccash50 = 0;
    $ccash50Amountt = 0;
    $ccash20 = 0;
    $ccash20Amount = 0;
    $ccash10 = 0;
    $ccash10Amount = 0;
    $ccash5 = 0;
    $ccash5Amount = 0;
    $ccash1 = 0;
    $ccash1Amount = 0;
    $cTotalAmount = 0;

    $ycash1000 = 0;
    $ycash1000Amount = 0;
    $ycash500 = 0;
    $ycash500Amount = 0;
    $ycash200 = 0;
    $ycash200Amount = 0;
    $ycash100 = 0;
    $ycash100Amount = 0;
    $ycash50 = 0;
    $ycash50Amountt = 0;
    $ycash20 = 0;
    $ycash20Amount = 0;
    $ycash10 = 0;
    $ycash10Amount = 0;
    $ycash5 = 0;
    $ycash5Amount = 0;
    $ycash1 = 0;
    $ycash1Amount = 0;
    $yTotalAmount = 0;
    
    $addedOn            = time();
    $username	 	    = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		    = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $naira	 	        = filter_var($_POST['naira'], FILTER_SANITIZE_STRING);
    $evReqId            = filter_var($_POST['evReqId'], FILTER_SANITIZE_STRING);
    $euro	 	        = filter_var($_POST['euro'], FILTER_SANITIZE_STRING);
    $usd                = filter_var($_POST['usd'], FILTER_SANITIZE_STRING);
    $gbp	 	        = filter_var($_POST['gbp'], FILTER_SANITIZE_STRING);
    $zar	 	        = filter_var($_POST['zar'], FILTER_SANITIZE_STRING);
    $cfa	 	        = filter_var($_POST['cfa'], FILTER_SANITIZE_STRING);
    $cny                = filter_var($_POST['cny'], FILTER_SANITIZE_STRING);
    $sealNumber         = filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    $depositType        = filter_var($_POST['depositType'], FILTER_SANITIZE_STRING);
    $categoryType       = filter_var($_POST['categoryType'], FILTER_SANITIZE_STRING);
    $containerType      = filter_var($_POST['containerType'], FILTER_SANITIZE_STRING);
    // $totalAmount        = filter_var($_POST['totalAmount'], FILTER_SANITIZE_STRING);

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

    if ($naira != ''){
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
    }
    if ($euro != ''){
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
    }
    if ($usd != ''){
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
    }
    if ($gbp != ''){
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
    }
    if ($zar != ''){
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
    }
    if ($cfa != ''){
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
    }
    if ($cny != ''){
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
    }

    if( !$error ) {
        addNairaCashAllocation($evReqId, $naira, $euro, $usd, $gbp, $zar, $cfa, $cny, $sealNumber, $depositType, $categoryType, $containerType, $ncash1000, $ncash1000Amount, $ncash500, $ncash500Amount, $ncash200, $ncash200Amount, $ncash100, $ncash100Amount, $ncash50, $ncash50Amount, $ncash20, $ncash20Amount, $ncash10, $ncash10Amount, $ncash5, $ncash5Amount, $ncash1, $ncash1Amount, $nTotalAmount, $username, $addedOn);
    }
}

// Add Cash Allocation function
function addNairaCashAllocation($evReqId, $naira, $euro, $usd, $gbp, $zar, $cfa, $cny, $sealNumber, $depositType, $categoryType, $containerType, $ncash1000, $ncash1000Amount, $ncash500, $ncash500Amount, $ncash200, $ncash200Amount, $ncash100, $ncash100Amount, $ncash50, $ncash50Amount, $ncash20, $ncash20Amount, $ncash10, $ncash10Amount, $ncash5, $ncash5Amount, $ncash1, $ncash1Amount, $nTotalAmount, $username, $addedOn)
{
    require('../core/db.php');
    $sql = "INSERT INTO cash_preparation_naira (ev_req_id, container_type_id, currency_id, cash_1000, cash_1000_amount, cash_500, cash_500_amount, cash_200, cash_200_amount, cash_100, cash_100_amount, cash_50, cash_50_amount, cash_20, cash_20_amount, cash_10, cash_10_amount, cash_5, cash_5_amount, cash_1, cash_1_amount, seal_number, deposit_type_id, category_id, total_amount, client_rep, updatedOn )
        VALUES ('$evReqId', '$containerType', '$naira', '$ncash1000', '$ncash1000Amount', '$ncash500', '$ncash500Amount', '$ncash200', '$ncash200Amount', '$ncash100', '$ncash100Amount', '$ncash50', '$ncash50Amount', '$ncash20', '$ncash20Amount', '$ncash10', '$ncash10Amount', '$ncash5', '$ncash5Amount', '$ncash1', '$ncash1Amount', '$sealNumber', '$depositType', '$categoryType', '$nTotalAmount', '$username', '$addedOn')";
    
    if ($con->query($sql) === true) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Get all Evacuation Requests
function getAllEvacuationRequests()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM bank_requests ORDER BY er_id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Request Title</th>
                    <th>Client</th>
                    <th>Branch Location</th>
                    <th>Consignment Location</th>
                    <th>Total Amount</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Request Title</th>
                    <th>Client</th>
                    <th>Branch Location</th>
                    <th>Consignment Location</th>
                    <th>Total Amount</th>
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
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td><a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['er_name'] . '</a></td>
                <td>' . $clientName . '</td>
                <td>' . $row['location_code'] . '</td>
                <td>'. $consignmentLocation .'</a></td>
                <td>' . number_format($row['total_amount']) . '</a></td>
                <td>
                    <a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important;">
                        View  <i class="material-icons left">link</i>
                    </a>
                    <a href="evacuation-request-p?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-add waves-effect waves-light" style="color: white !important;">
                        Prepare Cash <i class="material-icons left">local_mall</i>
                    </a>
                    <a href="evacuation-request-u?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-edit waves-effect waves-light" style="color: #333 !important;">
                        Edit <i class="material-icons left">edit</i>
                    </a>
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
    $sql = " SELECT * FROM bank_branch WHERE '$cid' ";
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