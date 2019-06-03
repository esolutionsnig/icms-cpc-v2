<?php
// Include external files
include("../core/session.php");
require_once '../core/functions.php';
$usern = $session->username;

if($_GET['did']){
	$setid = $_GET['did'];

    //UPDATE RECORD
	$sql = "UPDATE users SET todayview = '$setid' WHERE username = '$usern'";
	
	// check for successfull insertion
	if ($con->query($sql) === TRUE) {
		header("Location: ../../dashboard");
	} else {
		header("Location: ../../dashboard");
	}		
	$con->close();
} else {
	header("Location: ../../dashboard");
}