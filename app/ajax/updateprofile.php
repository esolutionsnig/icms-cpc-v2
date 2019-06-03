<?php
// Include external files
include("../core/session.php");
require_once '../core/db.php';

	$error = false;

	if(isset($_POST["updateUser"])){
		$username	 	= mysqli_real_escape_string($con, $_POST['username']);
		$surname	 	= mysqli_real_escape_string($con, $_POST['surname']);
		$firstname		= mysqli_real_escape_string($con, $_POST['firstname']);
		$middlename		= mysqli_real_escape_string($con, $_POST['middlename']);
		$gender	 	    = mysqli_real_escape_string($con, $_POST['gender']);
		$address		= mysqli_real_escape_string($con, $_POST['address']);
		$usertoken		= mysqli_real_escape_string($con, $_POST['usertoken']);
		
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
			echo'Unauthorized Request';
		} else if (strlen($surname) < 4) {
			$error = true;
			echo'Unauthorized Request';
        }
        if (empty($surname)) {
			$error = true;
			echo'Surname is required';
		} else if (strlen($surname) < 2) {
			$error = true;
			echo'Surname Invalid';
		}
		if (empty($firstname)) {
			$error = true;
			echo'First Name is required';
		} else if (strlen($firstname) < 2) {
			$error = true;
			echo'First Name Invalid';
		}
		if (empty($middlename)) {
			$error = true;
			echo'Middle Name is required';
		} else if (strlen($middlename) < 2) {
			$error = true;
			echo'Middle Name Invalid';
        }
		if (empty($gender)) {
			$error = true;
			echo'Gender is required';
		} else if (strlen($gender) < 4) {
			$error = true;
			echo'Gender Invalid';
		}        
		if (empty($address)) {
			$error = true;
			echo'Contact Address is required';
		} else if (strlen($address) < 15) {
			$error = true;
			echo'Contact Address Invalid';
		}
		
	  
		// if there's no error, continue to place order
		if( !$error ) {
            // Update User Record
			$sql = "UPDATE users SET surname = '$surname', 
                firstname = '$firstname', 
                middlename = '$middlename', 
                gender = '$gender', 
                address = '$address' WHERE username = '$username' AND userid = '$usertoken'";
				
			// check for successfull insertion
			if ($con->query($sql) === TRUE) {
				echo'ok200';
			} else {
				echo'<div class="alert-box-error">
						<h6 class="title">Update Failed</h6>
						<p>The system encountered some errors and your request could not be completed, kindly retry later.</p>
					</div>';
			}
				
			$con->close();
		}
	}
		
	
?>