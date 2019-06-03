<?php
// Include external files
include("..//core/session.php");
require_once '../core/functions.php';
$usern = $session->username;


	$error = false;
	
	if($_POST) {
		$sname	 		= mysqli_real_escape_string($con, $_POST['sname']);
		$fname			= mysqli_real_escape_string($con, $_POST['fname']);
		$mname			= mysqli_real_escape_string($con, $_POST['mname']);
		$dob		 	= mysqli_real_escape_string($con, $_POST['dob']);
		$gender	 		= mysqli_real_escape_string($con, $_POST['gender']);
		$phoneNumber	= mysqli_real_escape_string($con, $_POST['phoneNumber']);
		$country		= mysqli_real_escape_string($con, $_POST['country']);
		$state		 	= mysqli_real_escape_string($con, $_POST['state']);
		$address	 	= mysqli_real_escape_string($con, $_POST['address']);
		$occupation		= mysqli_real_escape_string($con, $_POST['occupation']);
		$profile		= mysqli_real_escape_string($con, $_POST['profile']);
		$username	 	= mysqli_real_escape_string($con, $_POST['username']);
		
		$time	 		= time();
		
		// basic name validation
		if (empty($fname)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> First Name is required. </span><br>';
		} else if (strlen($fname) < 2) {
			$error = true;
			echo'<span class="ecolo"><i class="fa fa-warning"></i> First Name must be 2 characters or more.</span><br>';
		}
		
		if (empty($sname)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Surname Name is required. </span><br>';
		} else if (strlen($sname) < 2) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Surname Name must be 2 characters or more.</span><br>';
		}
		
		if (empty($mname)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Middle Name is required. </span><br>';
		}
		
		if (empty($dob)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Date of Birth is required. </span><br>';
		}
		if (empty($gender)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Gender is required. </span><br>';
		}
		
		if (empty($country)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Country is required. </span><br>';
		}
		
		if (empty($state)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> State is required. </span><br>';
		}
		
		if (empty($address)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Address is required. </span><br>';
		}
		
		if (empty($occupation)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Occupation is required. </span><br>';
		}
		
		if (empty($profile)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Profile is required. </span><br>';
		}
		
		 
		// if there's no error, continue to place order
		if( !$error ) {
			
			// Check if user already exists and update record
			$query = $con->query("SELECT * FROM general WHERE username = '$username'");
			if($query->num_rows == 1){
				//UPDATE EXISTING RECORD
				$sql = "UPDATE general SET surname = '$sname',
				firstname = '$sname',
				middlename = '$mname',
				dob = '$dob',
				gender = '$gender',
				phoneNumber = '$phoneNumber',
				address = '$address',
				state = '$state',
				country = '$country',
				occupation = '$occupation',
				profile = '$profile',
				updatedOn = $time WHERE username='$username'";
				
				// check for successfull update
				if ($con->query($sql) === TRUE) {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-check"></i> Your profile has been successfully updated.
							<a href="profile" class="btn btn-success iamdone"><i class="fa fa-thumbs-up"></i> DONE </a>
						</div>
					</div><br><br>
					';
					
				} else {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-times"></i> The system encountered some errors and your request could not be completed, kindly retry later or CONTACT US if problem persist.<br>
						</div><br><br>
					</div>
					';
				}
					
				$con->close();
				
				
			} else {
				//INSERT NEW RECORD
				$sql = "INSERT INTO general (username, surname, firstname, middlename, dob, gender, phoneNumber, address, state, country, occupation ,profile, updatedOn) 
			VALUES ('$username', '$sname', '$fname', '$mname', '$dob', '$gender', '$phoneNumber', '$address', '$state', '$country', '$occupation', '$profile', '$time')";
				
				// check for successfull insertion
				if ($con->query($sql) === TRUE) {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-check"></i> Your profile has been successfully updated.
							<a href="profile" class="btn btn-success iamdone"><i class="fa fa-thumbs-up"></i> DONE </a>
						</div>
					</div><br><br>
					';
					
				} else {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-times"></i> The system encountered some errors and your request could not be completed, kindly retry later or CONTACT US if problem persist.<br>
						</div><br><br>
					</div>
					';
				}
					
				$con->close();
			}
		
			
		} // END NO ERROR IF
		
	} // End POST IF	
?>