<?php
// Include external files
include("../core/session.php");
require_once '../core/functions.php';
$usern = $session->username;

	
	if($_POST) {
		$ulevel	 	= mysqli_real_escape_string($con, $_POST['ulevel']);
		$username	= mysqli_real_escape_string($con, $_POST['username']);
		
		// if there's no error, continue to place order
		if( !$error ) {
			
		$sql = "UPDATE ".TBL_USERS." SET userlevel = '$ulevel' WHERE username = '$username'";
			
		// check for successfull insertion
		if ($con->query($sql) === TRUE) {
			header("Location:../../allUsers?us=ss");
		} else {
			header("Location:../../allUsers?us=ff");
		}
			
		$con->close();
	}
		
}
?>