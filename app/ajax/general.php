<?php
// Include external files
include("../core/session.php");
require_once '../core/functions.php';
$usern = $session->username;


	$error = false;

	if($_POST) {
		$surname	 		= mysqli_real_escape_string($con, $_POST['surname']);
		$fname				= mysqli_real_escape_string($con, $_POST['fname']);
		$mname				= mysqli_real_escape_string($con, $_POST['mname']);
		$dob			 	= mysqli_real_escape_string($con, $_POST['dob']);
		$gender	 			= mysqli_real_escape_string($con, $_POST['gender']);
		$phoneNumber		= mysqli_real_escape_string($con, $_POST['phoneNumber']);
		$address		 	= mysqli_real_escape_string($con, $_POST['address']);
		$occupation			= mysqli_real_escape_string($con, $_POST['occupation']);
		$postbody		 	= mysqli_real_escape_string($con, $_POST['postbody']);
		$username		 	= mysqli_real_escape_string($con, $_POST['uname']);
		$updatedOn 			= time();
		
		// basic input validation
		if (empty($surname)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Surname is required. </span><br>';
		}
		
		if (empty($fname)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> First name is required. </span><br>';
		}
		 
		// if there's no error, continue to place order
		if( !$error ) {
			// Check if user already exists and update record
			$query = $con->query("SELECT * FROM general WHERE username = '$username'");
			if($query->num_rows == 1){
				//UPDATE EXISTING RECORD
				$sql = "UPDATE general SET surname = '$surname',
				firstname = '$fname',
				middlename = '$mname',
				dob = '$dob',
				gender = '$gender',
				phoneNumber = '$phoneNumber',
				address = '$address',
				occupation = '$occupation',
				profile = '$profile',
				updatedOn = '$updatedOn' WHERE username='$username'";
				
				// check for successfull update
				if ($con->query($sql) === TRUE) {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-smile-o"></i> Staff record has been successfully updated.
						</div>
					</div><br><br>
					';
					
				} else {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-frown-o"></i> The system encountered some errors and your request could not be completed, kindly retry later or CONTACT US if problem persist.<br>
						</div><br><br>
					</div>
					';
				}
					
				$con->close();
				
				
			} else {
				//INSERT NEW RECORD
				$sql = "INSERT INTO general (username, emp_code, c_emp_code, surname, firstname, middlename, onames, date_employed, department, company, location, state, gradec, gradexl, position, paymode, bankaccno, pfa, pfapin, nhfno, copsocno, passportno, driverslicno, mobileno, faxno, email, updatedOn) 
			VALUES ('$username', '$emp_code', '$c_emp_code', '$surname', '$firstname', '$middlename', '$onames', '$date_employed', '$department', '$company', '$location', '$state', '$gradec', '$gradexl', '$position', '$paymode', '$bankaccno', '$pfa', '$pfapin', '$nhfno', '$copsocno', '$passportno', '$driverslicno', '$mobileno', '$faxno', '$email', '$updatedOn')";
				
				// check for successfull insertion
				if ($con->query($sql) === TRUE) {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-smile-o"></i> Staff record has been successfully updated.
						</div>
					</div><br><br>
					';
					
				} else {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-frown-o"></i> The system encountered some errors and your request could not be completed, ensure you filled the form with accurate data. CONTACT US if problem persist.<br>
						</div><br><br>
					</div>
					';
				}
					
				$con->close();
			}
		
			
		} // END NO ERROR IF
		
	} // End  POST IF	
?>