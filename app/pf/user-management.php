<?php

$error = false;

if(isset($_POST["updateUserAccessLevel"])){
    $userlevel        = filter_var($_POST['userlevel'], FILTER_SANITIZE_STRING);
    $uUsername        = filter_var($_POST['uUsername'], FILTER_SANITIZE_STRING);
    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);

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
    if (empty($userlevel)) {
        $error = true;
        echo'User Access Level Is Required';
    }
    if (empty($uUsername)) {
        $error = true;
        echo'User UID Is Required';
    }

    if( !$error ) {
        updateUserAccessLevel($userlevel, $uUsername);
    }
}
// Update Access Level
function updateUserAccessLevel($userlevel, $uUsername)
{
    require('../core/db2.php');
    
    // sql to delete a record
    $sql = "UPDATE users SET 
        userlevel = '$userlevel'
        WHERE username = '$uUsername'";

    if ($con->query($sql) === true) {
        echo "sm";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}

// Approve Users
if(isset($_POST["approveUsers"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $getSelectedUsers	 	        = $_POST['getSelectedUsers'];
    
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
    if (empty($getSelectedUsers)) {
        $error = true;
        echo'You have to select at least one user';
    }

    if( !$error ) {
        foreach($getSelectedUsers as $getSelectedUser){
            approveUsers($getSelectedUser, $addedOn, $username);
        }
    }
}

// Move New Consignment function
function approveUsers($getSelectedUser, $addedOn, $username)
{
    require('../core/db2.php');

    $sql = "UPDATE users SET 
        registration_status = 'Approved',
        approved_by = '$username',
        approved_on = '$addedOn'
        WHERE username = '$getSelectedUser'";
    if ($con->query($sql) === true) {
        echo "";
    } else {
        // echo "Error: " . $sql . "<br>" . $con->error;
        echo "Error";
    }
}

// Approve Users
if(isset($_POST["suspendUsers"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $getSelectedUsers	 	        = $_POST['getSelectedUsers'];
    
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
    if (empty($getSelectedUsers)) {
        $error = true;
        echo'You have to select at least one user';
    }

    if( !$error ) {
        foreach($getSelectedUsers as $getSelectedUser){
            suspendUsers($getSelectedUser, $addedOn, $username);
        }
    }
}

// Move New Consignment function
function suspendUsers($getSelectedUser, $addedOn, $username)
{
    require('../core/db2.php');

    $sql = "UPDATE users SET 
        registration_status = 'Pending',
        approved_by = '$username',
        approved_on = '$addedOn'
        WHERE username = '$getSelectedUser'";
    if ($con->query($sql) === true) {
        echo "";
    } else {
        // echo "Error: " . $sql . "<br>" . $con->error;
        echo "Error";
    }
}