<?php
// Include external files
include("../core/session.php");
require_once '../core/functions.php';
$usern = $session->username;

	
	if($_POST) {
		$username = mysqli_real_escape_string($con, $_POST['username']);
		
		//DELETE FROM USERS TABLE
		$sql = "DELETE FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
			
		// check for successfull insertion
		if ($con->query($sql) === TRUE) {
			header("Location:../../allUsers?q=banned");
		} else {
			header("Location:../../allUsers?us=ff");
		}
			
		$con->close();
	
	}
?>