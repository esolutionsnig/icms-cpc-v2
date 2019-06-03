<?php

$error = false;

// Move Selected Consignment
if(isset($_POST["moveSelectedConsignments"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $selectedSealNumbers	 	        = $_POST['searchIDs'];
    $sealNumberCurrentLocationCode	 	= filter_var($_POST['sealNumberCurrentLocationCode'], FILTER_SANITIZE_STRING);
    $sealNumberDestinationLocation         	 	= filter_var($_POST['sealNumberDestinationLocation'], FILTER_SANITIZE_STRING);
    
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
    if (empty($selectedSealNumbers)) {
        $error = true;
        echo'You have to select at least one bag';
    }
    if (empty($sealNumberCurrentLocationCode)) {
        $error = true;
        echo'Invalid Source Location';
    }
    if (empty($sealNumberDestinationLocation)) {
        $error = true;
        echo'Invalid Destination Location';
    }

    if( !$error ) {
        foreach($selectedSealNumbers as $sealNumber){
            require('../core/db.php');
            // Check if the selected bag can be moved
            $sql = "SELECT * FROM internalmovements WHERE seal_number = '$sealNumber' AND movement_status = 'Confirmed' OR movement_status = 'Rejected' AND is_opened = 'NO'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                moveSelectedConsignments($sealNumber, $sealNumberCurrentLocationCode, $sealNumberDestinationLocation, $addedOn, $username);
            } else {
                echo 'Not all bags were moved, next time ensure you select bags ready for movement.';
            }
        }
    }
}

// Move New function
function moveSelectedConsignments($sealNumber, $sealNumberCurrentLocationCode, $sealNumberDestinationLocation, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "UPDATE internalmovements SET 
            source_location = '$sealNumberCurrentLocationCode', 
            destination_location = '$sealNumberDestinationLocation',
            added_on = '$addedOn',
            added_by = '$username',
            received_by = '',
            received_on = '',
            movement_status = 'Pending' 
            WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        echo "";
    } else {
        // echo "Error:";
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Move Selected Consignment
if(isset($_POST["acceptSelectedConsignments"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $selectedSealNumbers	 	        = $_POST['searchIDs'];

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
    if (empty($selectedSealNumbers)) {
        $error = true;
        echo'You have to select at least one bag';
    }

    if( !$error ) {
        foreach($selectedSealNumbers as $sealNumber){
            require('../core/db.php');
            // Check if the selected bag can be accepted
            $sql = "SELECT * FROM internalmovements WHERE seal_number = '$sealNumber' AND movement_status = 'Pending' AND is_opened = 'NO'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                acceptSelectedConsignments($sealNumber, $addedOn, $username);
            } else {
                echo 'Not all bags were accepted, next time ensure you select bags ready for acceptance.';
            }
        }
    }
}

// Move New function
function acceptSelectedConsignments($sealNumber, $addedOn, $username)
{
    require('../core/db.php');

    $acceptStatus = 'Confirmed';

    $sql = "UPDATE internalmovements SET 
            received_by = '$username',
            received_on = '$addedOn',
            movement_status = '$acceptStatus' 
            WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        echo "";
    } else {
        // echo "Error";
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Move Rejected Consignment
if(isset($_POST["rejectSelectedConsignments"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $selectedSealNumbers	 	        = $_POST['searchIDs'];
    $returnLocation	 	= filter_var($_POST['returnLocation'], FILTER_SANITIZE_STRING);
    
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
    if (empty($selectedSealNumbers)) {
        $error = true;
        echo'You have to select at least one bag';
    }
    if (empty($returnLocation)) {
        $error = true;
        echo'Invalid Return Location';
    }

    if( !$error ) {
        foreach($selectedSealNumbers as $sealNumber){
            require('../core/db.php');
            // Check if the selected bag can be returned
            $sql = "SELECT * FROM internalmovements WHERE seal_number = '$sealNumber' AND movement_status = 'Pending' AND is_opened = 'NO'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                rejectSelectedConsignments($sealNumber, $returnLocation, $addedOn, $username);
            } else {
                echo 'Not all bags were returned, next time ensure you select bags ready for rejection.';
            }
        }
    }
}

// Move New function
function rejectSelectedConsignments($sealNumber, $returnLocation, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "UPDATE internalmovements SET 
            destination_location = '$returnLocation',
            added_on = '$addedOn',
            added_by = '$username',
            received_by = '',
            received_on = '',
            movement_status = 'Rejected' 
            WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        echo "";
    } else {
        // echo "Error:";
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Move Selected Consignment
if(isset($_POST["moveToNewLocation"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $sealNumbers	 	        = $_POST['sealNumbers'];
    $destinationLocation	 	= filter_var($_POST['destinationLocation'], FILTER_SANITIZE_STRING);
    $sourceLocation         	 	= filter_var($_POST['sourceLocation'], FILTER_SANITIZE_STRING);
    
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
    if (empty($sealNumbers)) {
        $error = true;
        echo'You have to select at least one bag';
    }
    if (empty($destinationLocation)) {
        $error = true;
        echo'Invalid Destination Location';
    }
    if (empty($sourceLocation)) {
        $error = true;
        echo'Invalid Source Location';
    }

    if( !$error ) {
        foreach($sealNumbers as $sealNumber){
            moveToNewLocation($sealNumber, $destinationLocation, $sourceLocation, $addedOn, $username);
        }
    }
}

// Move New Consignment function
function moveToNewLocation($sealNumber, $destinationLocation, $sourceLocation, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "INSERT INTO internalmovements (source_location, destination_location, seal_number, added_on, added_by, movement_status)
            VALUES ('$sourceLocation', '$destinationLocation', '$sealNumber', '$addedOn', '$username', 'Pending')";

    if ($con->query($sql) === true) {
        echo "";
    } else {
        // echo "Error: " . $sql . "<br>" . $con->error;
        echo "Error";
    }
}