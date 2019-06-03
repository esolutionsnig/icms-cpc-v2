<?php

$error = false;

// Move Consignments
if(isset($_POST["sealThisContainer"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealingTitle               = filter_var($_POST['sealingTitle'], FILTER_SANITIZE_STRING);
    $cClientName                = filter_var($_POST['cClientName'], FILTER_SANITIZE_STRING);
    $cCategory                  = filter_var($_POST['cCategory'], FILTER_SANITIZE_STRING);
    $cGenSealNumber             = filter_var($_POST['cGenSealNumber'], FILTER_SANITIZE_STRING);
    $cGenCurSealNumber          = filter_var($_POST['cGenCurSealNumber'], FILTER_SANITIZE_STRING);
    $cLocation                  = filter_var($_POST['cLocation'], FILTER_SANITIZE_STRING);
    $cContainer                 = filter_var($_POST['cContainer'], FILTER_SANITIZE_STRING);
    $cCurrency                  = filter_var($_POST['cCurrency'], FILTER_SANITIZE_STRING);
    $cDenomination              = filter_var($_POST['cDenomination'], FILTER_SANITIZE_STRING);
    $cAmount                    = filter_var($_POST['cAmount'], FILTER_SANITIZE_STRING);
    $strim                      = filter_var($_POST['strim'], FILTER_SANITIZE_STRING);
    $sealBatch                  = filter_var($_POST['sealBatch'], FILTER_SANITIZE_STRING);
    $totalAmountSeal            = filter_var($_POST['totalAmountSealed'], FILTER_SANITIZE_STRING);
    // Get New Total Amount Sealed
    $totalAmountSealed = $totalAmountSeal + $cAmount;
    
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
    if (empty($sealingTitle)){
        $error = true;
        echo 'Invalid Title';
    }
    if (empty($cClientName)){
        $error = true;
        echo 'Invalid Client';
    }
    if (empty($cLocation)){
        $error = true;
        echo 'Invalid Location';
    }
    if (empty($cContainer)){
        $error = true;
        echo 'Invalid Container';
    }
    if (empty($cCurrency)){
        $error = true;
        echo 'Invalid Currency';
    }
    if (empty($cCategory)){
        $error = true;
        echo 'Invalid Cash Category';
    }
    if (empty($cDenomination)){
        $error = true;
        echo 'Invalid Seal Number';
    }
    if (empty($cAmount)){
        $error = true;
        echo 'Invalid Denomination';
    }
    if (empty($cGenSealNumber)){
        $error = true;
        echo 'Invalid Seal Number';
    }
    if (empty($strim)){
        $error = true;
        echo 'Stream Is Required';
    }

    if( !$error ) {
        sealThisContainer($strim, $sealingTitle, $cClientName, $cCategory, $cLocation, $cContainer, $cCurrency, $cDenomination, $cAmount, $cGenSealNumber, $cGenCurSealNumber, $username, $addedOn, $sealBatch, $totalAmountSealed);
    }
}
// Move Existing Consignment
function sealThisContainer($strim, $sealingTitle, $cClientName, $cCategory, $cLocation, $cContainer, $cCurrency, $cDenomination, $cAmount, $cGenSealNumber, $cGenCurSealNumber, $username, $addedOn, $sealBatch, $totalAmountSealed)
{
    require('../core/db.php');

    $sql = "INSERT INTO sealings (strim, sealing_title, client, location_id, category_id, container_id, currency_id, denomination_id, amount, seal_number, old_seal_number, added_by, added_on, seal_batch, total_amount_sealed)
            VALUES ('$strim', '$sealingTitle', '$cClientName', '$cLocation', '$cCategory', '$cContainer', '$cCurrency', '$cDenomination', '$cAmount', '$cGenSealNumber', '$cGenCurSealNumber', '$username', '$addedOn', '$sealBatch', '$totalAmountSealed')";

    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}