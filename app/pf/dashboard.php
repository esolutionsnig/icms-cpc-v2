<?php

$error = false;


// Move Consignments
if(isset($_POST["moveToBoxRoom"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumberxx                = $_POST['sealNumberxx'];
    
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
    if (empty($sealNumberxx)){
        $error = true;
        echo 'Invalid Seal Number';
        // echo $sealNumberxx;
    }

    if( !$error ) {
        // moveExistingConsinmentCit($sealNumber);
        foreach($sealNumberxx as $sealNumber){
            moveExistingConsinmentCit($sealNumber, $username, $addedOn);
        }
    }
}
// Move Existing Consignment
function moveExistingConsinmentCit($sealNumber, $username, $addedOn)
{
    require('../core/db.php');

    $sql = "UPDATE cits SET
        delivery_status = 'Sent To Boxroom, Awaiting Confirmation'
        WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        // Update Cash Preparation Table
        $sql2 = "UPDATE evacuationpreparations SET 
            is_handed_over = 'YES',
            handed_over_by = '$username',
            handed_over_on = '$addedOn'
            WHERE seal_number = '$sealNumber' ";
        if ($con->query($sql2) === true) {
            echo "";
        } else {
            echo "Error";
            // echo "Error: " . $sql . "<br>" . $con->error;
        }
        echo "";
    } else {
        echo "Error";
        // echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Set Shift And Location
if(isset($_POST["setShiftLocation"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $yourShift                  = $_POST['yourShift'];
    $signInA                    = $_POST['signInAs'];
    $getSignLocation            = getConsignmentLocationByIdGF($signInA);
    $signInAs                   = $getSignLocation['name'];
    $signInAsId                 = $getSignLocation['id'];
    
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
    if (empty($signInAs)){
        $error = true;
        echo 'Invalid Location';
    }
    if (empty($yourShift)){
        $error = true;
        echo 'Invalid Shift';
    }

    if( !$error ) {
        setShiftLocation($yourShift, $signInAs, $signInAsId);
    }
}
// Move Existing Consignment
function setShiftLocation($yourShift, $signInAs, $signInAsId)
{
    session_start();
    $_SESSION['yourShift'] = $yourShift;
    $_SESSION['signInAs'] = $signInAs;
    $_SESSION['signInAsId'] = $signInAsId;
    // Check If Session is set
    if(isset($_SESSION['yourShift']) && !empty($_SESSION['yourShift']) && isset($_SESSION['signInAs']) && !empty($_SESSION['signInAs'])) {
        echo 'DoneSet';
    } else {
        echo 'Shift And Location Not Set, Please Contact Support';
    }
}