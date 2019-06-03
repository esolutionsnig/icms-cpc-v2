<?php
// Include external files
include("../core/session.php");
require_once '../core/db2.php';

	$error = false;

	if(isset($_POST["addNewUser"])){
		$surname	 	= mysqli_real_escape_string($con, $_POST['surname']);
		$firstname		= mysqli_real_escape_string($con, $_POST['firstname']);
		$middlename		= mysqli_real_escape_string($con, $_POST['middlename']);
		$usernam	 	= mysqli_real_escape_string($con, $_POST['username']);
		$phoneno		= mysqli_real_escape_string($con, $_POST['phoneno']);
		$password		= mysqli_real_escape_string($con, $_POST['password']);
		$conpass		= mysqli_real_escape_string($con, $_POST['confirmpass']);
		$email		 	= mysqli_real_escape_string($con, $_POST['email']);
		$userlevel		= mysqli_real_escape_string($con, $_POST['userlevel']);
		$cap3		 	= mysqli_real_escape_string($con, $_POST['cap3']);
		$sumcap		 	= mysqli_real_escape_string($con, $_POST['sumcap']);
		$time 			= time();
		$username		= strtolower($usernam);
		
		$staffname = $surname.' '.$firstname.' '.$middlename.' ('.$username.') ';
		
		// Basic Username Name Validation
		if (empty($surname)) {
			$error = true;
			echo'<span class="red-text"> Surname is required</span><br>';
		} else if (strlen($surname) < 2) {
			$error = true;
			echo'<span class="red-text"> Surname Invalid</span><br>';
		}
		if (empty($firstname)) {
			$error = true;
			echo'<span class="red-text"> First Name is required</span><br>';
		} else if (strlen($firstname) < 2) {
			$error = true;
			echo'<span class="red-text"> First Name Invalid</span><br>';
		}
		if (empty($userlevel)) {
			$error = true;
			echo'<span class="red-text"> User Level is required</span><br>';
		}
		$username = strtolower($username);
		if (empty($username)) {
			$error = true;
			echo'<span class="red-text"> Username is required</span><br>';
		} else if (strlen($username) < 5) {
			$error = true;
			echo'<span class="red-text"> Username must be minimum 5 characters.</span><br>';
		} else if(strlen($username) > 30){
			$error = true;
			echo'<span class="red-text"> Username must be maximum 30 characters.</span><br>';
         }
         /* Check if username is not alphanumeric */
         else if(!preg_match("/^([0-9a-z_])+$/", $username)){
			$error = true;
			echo'<span class="red-text">Username not alphanumeric.</span><br>';
         }
         /* Check if username is reserved */
         else if(strcasecmp($username, GUEST_NAME) == 0){
            $error = true;
			echo'<span class="red-text"> Username can not be a reserved word.</span><br>';
         }
         /* Check if username is already in use */
         else if($database->usernameTaken($username)){
			$error = true;
			echo'<span class="red-text"> Username already in use.</span><br>';
         }
         /* Check if username is banned */
         else if($database->usernameBanned($username)){
			$error = true;
			echo'<span class="red-text"> Username banned.</span><br>';
         }
		 
		 
		/* Phone Number error checking */
		if (empty($phoneno)) {
			$error = true;
			echo'<span class="red-text"> Mobile Number is required.</span><br>';
		} else if (strlen($phoneno) < 11 && strlen($phoneno) > 11) {
			$error = true;
			echo'<span class="red-text"> Mobile Number must be 11 digits</span><br>';
		} else if (!is_numeric($phoneno)){
			$error = true;
			echo'<span class="red-text"> Mobile Number not numeric</span><br>';
        } else if($database->phonenoTaken($phoneno)){
			$error = true;
			echo'<span class="red-text"> Mobile Number already in use</span><br>';
        }
				
		
		// basic password validation
		if (empty($password)) {
			$error = true;
			echo'<span class="red-text"> Password is required.</span><br>';
		} else if (strlen($password) < 8 && strlen($password) > 30) {
			$error = true;
			echo'<span class="red-text"> Password must be between 8 and 30 digits.</span><br>';
		} else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#?*$%]{8,30}$/', $password)) {
			$error = true;
			echo '<span class="red-text"> The password must contain a alphanumeric, and special character</span><br>';
		}
		
		
		if (empty($conpass)) {
			$error = true;
			echo'<span class="red-text"> Confirm password is required.</span><br>';
		} else if (strlen($conpass) < 8 && strlen($conpass) > 30) {
			$error = true;
			echo'<span class="red-text"> Confirm Password must be between 8 and 30 digits.</span><br>';
		} else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#?*$%]{8,30}$/', $conpass)) {
			$error = true;
			echo '<span class="red-text"> Confirm Password must contain a alphanumeric, and special character</span><br>';
		}
		
		//Confirm New Password 
		if ($password == $conpass){
			$chosenpass = md5($password);
		} else {
			$error = true;
			echo'<span class="red-text"> Passwords do not match</span><br>';
		}

		//Human Test
		if ($cap3 != $sumcap){
			echo'<span class="red-text"> Your Human Test Answer Is Incorrect</span><br>';
		}
		
		
		/* Email error checking */
		if (empty($email)) {
			$error = true;
			echo'<span class="red-text"> Email Address is required.</span><br>';
		} else{
         	/* Check if valid email address */
			 $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
					 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
					 ."\.([a-z]{2,}){1}$/";
			 if(!preg_match($regex,$email)){
				$error = true;
				echo'<span class="red-text"> Email Address is invalid.</span><br>';
			 }
			 /* Check if phoneno is already in use */
			 else if($database->emailTaken($email)){
				$error = true;
				echo'<span class="red-text"> Email Address already in use.</span><br>';
			 }
		}
	  
	  
		// if there's no error, continue to place order
		if( !$error ) {
			
			$finalpass = md5($chosenpass);
			
			//INSERT NEW ORDER
			$sql = "INSERT INTO users (username, surname, firstname, middlename, phoneno, password, userid, userlevel, email, timestamp) VALUES ('$username', '$surname', '$firstname', '$middlename', '$phoneno', '$chosenpass', '0', '$userlevel', '$email', $time)";
				
			// check for successfull insertion
			if ($con->query($sql) === TRUE) {
				echo'sm';
			} else {
				echo'<div class="alert-box-error">
						<h6 class="title">Registration Failed</h6>
						<p>The system encountered some errors and your request could not be completed, kindly retry later.</p>
					</div>';
			}
				
			$con->close();
		}
	}
		
	
?>