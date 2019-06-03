<?php

// $mainUrl = $_SERVER['SERVER_NAME']; // LIVE
$mainUrl = $_SERVER['SERVER_NAME'] . '/' . 'icms-cpc/';

$username = $session->username;
	
//Get Number Of Users
$getUsers = $database->getNumMembers();
$bannedUsers = $database->getNumBannedMembers();
$activeGuests = $database->calcNumActiveGuests();
$allUsers = $getUsers + $bannedUsers;
	 
// Get user info from users table
$req_user_info  = $database->getUserInfo($username);
$usermail 		= $req_user_info['email'];
$userphone 		= $req_user_info['phoneno'];
$useraddress	= $req_user_info['address'];
$usergender 	= $req_user_info['gender'];
$userlevel		= $req_user_info['userlevel'];
$usertoken		= $req_user_info['userid'];
$todayview		= $req_user_info['todayview'];
$userdp         = $req_user_info['userdp'];
$fname			= $req_user_info['firstname'];
$lname			= $req_user_info['surname'];
$onames			= $req_user_info['middlename'];
	 
$fullname 		= $lname.' '.$fname.' '.$onames;
$shortname   	= $lname.' '.$fname;

//Set Image
if ($userdp == "") { $dp = "avatar-12.png"; } else { $dp  = $userdp; }

// Determine User Shift
$yourCurrentShift = '';
$yourCurrentShift = $_SESSION['yourShift'];
// Determin User Sign In Location
$signedInAs = $signedInLocation = $signed_location_id = '';
$signedInLocation = $_SESSION['signInAs'];
$signed_location_id = $_SESSION['signInAsId'];

// Determin User Level
if ($userlevel == 1) {
	$signedInAs = BR_OFFICER;
} elseif ($userlevel == 2) {
    $signedInAs = V_OFFICER;
} elseif ($userlevel == 3) {
    $signedInAs = V_SUPERVISOR;
} elseif ($userlevel == 4) {
    $signedInAs = CP_OFFICER;
} elseif ($userlevel == 5) {
    $signedInAs = CP_SUPERVISOR;
} elseif ($userlevel == 6) {
    $signedInAs = CP_ADMIN;
} elseif ($userlevel == 7) {
    $signedInAs = TREASURY_OFFICER;
} elseif ($userlevel == 8) {
    $signedInAs = TREASURY_SUPERVISOR;
} elseif ($userlevel == 9) {
    $signedInAs = HOU;
} elseif ($userlevel == 10) {
    $signedInAs = MANAGERS;
} elseif ($userlevel == 11) {
    $signedInAs = EXECUTIVE;
} elseif ($userlevel == 12) {
    $signedInAs = BRS_LEVEL;
} elseif ($userlevel == 19) {
    $signedInAs = ADMIN;
} elseif ($userlevel == 20) {
    $signedInAs = S_ADMIN;
}

/**
* $profileCompletion - Returns the percentage of completed fields
*/
// $profileCompletion = 0;
// $qpp = $con->query("SELECT * FROM  ".TBL_USERS." WHERE username = '$username'");
// if($qpp->num_rows == 1){
// 	$notEmpty =   0;
// 	$totalField = 14;
// 	while($row = $qpp->fetch_assoc()){ 
// 	   $notEmpty +=  ($row['username'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['surname'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['firstname'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['middlename'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['address'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['gender'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['phoneno'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['password'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['userid'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['userlevel'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['email'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['userdp'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['todayview'] != '') ? 1 : 0;
// 	   $notEmpty +=  ($row['timestamp'] != '') ? 1 : 0;
//     }
//     $profileCompletion = number_format($notEmpty/$totalField * 100,1).'%';
// }

?>