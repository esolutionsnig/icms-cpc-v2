<?php
// Include external files
include("../core/session.php");
require_once '../core/functions.php';
$usern = $session->username;

	
	if($_POST) {
		$username	= mysqli_real_escape_string($con, $_POST['username']);
		$time 		= time();
		
		$sql = "INSERT INTO ".TBL_BANNED_USERS." (username, timestamp) VALUES ('$username', '$time')";
			
		// check for successfull insertion
		if ($con->query($sql) === TRUE) {
			//DELETE FROM USERS TABLE
			$sqld = "DELETE FROM ".TBL_USERS." WHERE username = '$username'";
			if ($con->query($sqld) === TRUE) {
				header("Location:../../allUsers?us=ss");
			} else {
				header("Location:../../allUsers?us=ff");
			}
			//header("Location:../../allUsers?us=ss");
		} else {
			header("Location:../../allUsers?us=ff");
		}
			
		$con->close();
	
	}
?>