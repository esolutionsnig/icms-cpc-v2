<?php
// Include external files
require_once '../core/db.php';

$error = false;

if(isset($_POST["updateOneProfile"])){

	$surname	 		= mysqli_real_escape_string($con, $_POST['surname']);
	$fname				= mysqli_real_escape_string($con, $_POST['fname']);
	$mname				= mysqli_real_escape_string($con, $_POST['mname']);
	$dob			 	= mysqli_real_escape_string($con, $_POST['dob']);
	$gender	 			= mysqli_real_escape_string($con, $_POST['gender']);
	$phoneNumber		= mysqli_real_escape_string($con, $_POST['phoneNumber']);
	$address		 	= mysqli_real_escape_string($con, $_POST['address']);
	$occupation			= mysqli_real_escape_string($con, $_POST['occupation']);
	$profile		 	= mysqli_real_escape_string($con, $_POST['postbody']);
	$username		 	= mysqli_real_escape_string($con, $_POST['uname']);
	$updatedOn 			= time();

	// basic name validation
	if (empty($surname)) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> Surname is required
				</div>
			</div>
		';
	} else if (strlen($surname) < 2) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> Surname must have atleat 2 characters.
				</div>
			</div>
		';
	}

	if (empty($fname)) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> First name is required
				</div>
			</div>
		';
	} else if (strlen($fname) < 2) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> First name must have atleat 2 characters.
				</div>
			</div>
		';
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
				echo'ezielemhaozi';					
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
			$sql = "INSERT INTO general (username, surname, firstname, middlename, dob, gender, phoneNumber, address, occupation, profile, updatedOn) 
			VALUES ('$username', '$surname', '$fname', '$mname', '$dob', '$gender', '$phoneNumber', '$address', '$occupation', '$profile', '$updatedOn')";
			
			// check for successfull insertion
			if ($con->query($sql) === TRUE) {
				echo'ezielemhaozi';
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

}
?>