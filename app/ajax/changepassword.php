<?php
// Include external files
include("../core/session.php");
require_once '../core/db.php';

	$error = false;

	//updatePassword: 1, curpassword: curpassword, newpassword: newpassword, confpassword: confpassword, usertoken: usertoken, username: username
	
	if(isset($_POST["updatePassword"])){
		$curpassword	 	= mysqli_real_escape_string($con, $_POST['curpassword']);
		$newpassword		= mysqli_real_escape_string($con, $_POST['newpassword']);
		$confpassword		= mysqli_real_escape_string($con, $_POST['confpassword']);
		$usertoken	 	    = mysqli_real_escape_string($con, $_POST['usertoken']);
		$username		    = mysqli_real_escape_string($con, $_POST['username']);
		
		// Basic Validation
		if (empty($curpassword)) {
			$error = true;
			echo 'Current Password Is Required';
		} else if (strlen($curpassword) < 8) {
			$error = true;
			echo'Current password is invalid';
		}
		
		// basic password validation
		if (empty($newpassword)) {
			$error = true;
			echo'New password is required.';
		} else if (strlen($newpassword) < 8 && strlen($newpassword) > 30) {
			$error = true;
			echo'New password must be between 8 and 30 digits.';
		} else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#?*$%]{8,30}$/', $newpassword)) {
			$error = true;
			echo 'The new password must contain a alphanumeric, and special character';
		}
		
		if (empty($confpassword)) {
			$error = true;
			echo'Confirm password is required.';
		} else if (strlen($confpassword) < 8 && strlen($confpassword) > 30) {
			$error = true;
			echo'Confirm Password must be between 8 and 30 digits.';
		} else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#?*$%]{8,30}$/', $confpassword)) {
			$error = true;
			echo 'Confirm Password must contain a alphanumeric, and special character';
        }
        
        // Check If Current Password Exists
        $q = 'SELECT count(*) FROM users WHERE username = "'.$username.'" ';
        $result = mysqli_query($con, $q);
        $row = mysqli_fetch_row($result);
        $user_count = $row[0];
        if($user_count == 1) {
            $error = false;
        } else {
            $error = true;
            echo 'Invalid User';
        }
		
		//Confirm New Password 
		if ($newpassword == $confpassword){
			$chosenpass = md5($newpassword);
		} else {
			$error = true;
			echo'Passwords do not match';
		}

		// if there's no error, continue
		if( !$error ) {
			
			//Update DB
			$sql = "UPDATE users SET password = '$chosenpass' WHERE username = '$username' AND userid = '$usertoken'";
				
			// check for successfull insertion
			if ($con->query($sql) === TRUE) {
				echo'ok200';
			} else {
				echo'Failed to update db';
			}
				
			$con->close();
		}
	}
		
	
?>