<?php

$error = false;

// Start New Day
if(isset($_POST["startNewDay"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dayStartTitle	 	        = filter_var($_POST['dayStartTitle'], FILTER_SANITIZE_STRING);
    
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

    if (empty($dayStartTitle)) {
        $error = true;
        echo'Title Is Required';
    }

    startNewDay($dayStartTitle, $addedOn, $username);
}

// Start New Day Function
function startNewDay($dayStartTitle, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "INSERT INTO day_shift (dstart_title, dday, dstarted, dstarted_by, dstatus)
            VALUES ('$dayStartTitle', '$addedOn', 'YES', '$username', 'Active')";
    if ($con->query($sql) === true) {
        echo "daystarted";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Close Day
if(isset($_POST["closeThisDayBtn"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dsId	 	                = filter_var($_POST['dsId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($dsId)) {
        $error = true;
        echo 'Invalid Request ID';
    }

    closeThisDay($dsId, $addedOn, $username);
}
// Close Day Function
function closeThisDay($dsId, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "UPDATE day_shift SET 
            dclosed = 'YES', 
            dclosed_by = '$username',
            dclosed_on = '$addedOn',
            dstatus = 'Inactive' 
            WHERE id = $dsId ";
    if ($con->query($sql) === true) {
        echo "dayclosed";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Restor Day
if(isset($_POST["restoreThisDayBtn"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dsId	 	                = filter_var($_POST['dsId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($dsId)) {
        $error = true;
        echo 'Invalid Request ID';
    }

    restoreThisDayBtn($dsId, $addedOn, $username);
}

// Restore Day Function
function restoreThisDayBtn($dsId, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "UPDATE day_shift SET 
            dclosed = 'NO', 
            dclosed_by = '',
            dclosed_on = '',
            dstatus = 'Active' 
            WHERE id = $dsId ";
    if ($con->query($sql) === true) {
        echo "dayrestored";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Start New Shift
if(isset($_POST["startNewShift"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dayId	 	                = filter_var($_POST['dayId'], FILTER_SANITIZE_STRING);
    $shiftStartTitle	 	    = filter_var($_POST['shiftStartTitle'], FILTER_SANITIZE_STRING);
    $sshift	 	                = filter_var($_POST['sshift'], FILTER_SANITIZE_STRING);
    
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

    if (empty($dayId)) {
        $error = true;
        echo'Day Is required';
    }

    if (empty($shiftStartTitle)) {
        $error = true;
        echo'Title Is Required';
    }

    if (empty($sshift)) {
        $error = true;
        echo'Shift Is Required';
    }

    startNewShift($dayId, $shiftStartTitle, $sshift, $addedOn, $username);
}

// Start New Day Function
function startNewShift($dayId, $shiftStartTitle, $sshift, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "INSERT INTO shifts_day (day_id, stitle, sshift, sstarted, sstarted_by, sstarted_on, sstatus)
            VALUES ('$dayId', '$shiftStartTitle', '$sshift', 'YES', '$username', '$addedOn', 'Active')";
    if ($con->query($sql) === true) {
        echo "shiftstarted";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Close Shift
if(isset($_POST["closeThisShiftBtn"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $ssId	 	                = filter_var($_POST['ssId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($ssId)) {
        $error = true;
        echo 'Invalid Request ID';
    }

    closeThisShift($ssId, $addedOn, $username);
}

// Close Shift Function
function closeThisShift($ssId, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "UPDATE shifts_day SET 
            sclosed = 'YES', 
            sclosed_by = '$username',
            sclosed_on = '$addedOn',
            sstatus = 'Inactive' 
            WHERE id = $ssId ";
    if ($con->query($sql) === true) {
        echo "shiftclosed";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Restor Shift
if(isset($_POST["restoreThisShiftBtn"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $ssId	 	                = filter_var($_POST['ssId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($ssId)) {
        $error = true;
        echo 'Invalid Request ID';
    }

    restoreThisShiftBtn($ssId, $addedOn, $username);
}

// Restore Shift Function
function restoreThisShiftBtn($ssId, $addedOn, $username)
{
    require('../core/db.php');

    $sql = "UPDATE shifts_day SET 
            sclosed = 'NO', 
            sclosed_by = '',
            sclosed_on = '',
            sstatus = 'Active' 
            WHERE id = $ssId ";
    if ($con->query($sql) === true) {
        echo "shiftrestored";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}