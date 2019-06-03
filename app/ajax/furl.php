<?php
// Include external files
include("../core/session.php");
require_once '../core/functions.php';
$usern = $session->username;


	$error = false;
	
	if($_POST) {
		$furl = mysqli_real_escape_string($con, $_POST['furl']);
		
		// basic name validation
		if (empty($furl)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> YouTube URL is required. </span><br>';
		} else if (strlen($furl) < 30) {
			$error = true;
			echo'<span class="ecolo"><i class="fa fa-warning"></i> YouTube URL is invalid.</span><br>';
		}
		 
		// if there's no error, continue to place order
		if( !$error ) {
			
			// Check if user already exists and update record
			$query = $con->query("SELECT * FROM ".TBL_TALENTS." WHERE username = '$username'");
			if($query->num_rows == 1){
				//UPDATE EXISTING RECORD
				$sql = "UPDATE ".TBL_TALENTS." SET furl = '$furl' WHERE username='$username'";
				
				// check for successfull update
				if ($con->query($sql) === TRUE) {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-check"></i> Your talent profile has been successfully updated.
							<a href="talents" class="btn btn-success iamdone"><i class="fa fa-thumbs-up"></i> DONE </a>
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
				$sql = "INSERT INTO ".TBL_TALENTS." (username, furl) VALUES ('$username', '$furl')";
				
				// check for successfull insertion
				if ($con->query($sql) === TRUE) {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-check"></i> Your talent profile has been successfully updated.
							<a href="talents" class="btn btn-success iamdone"><i class="fa fa-thumbs-up"></i> DONE </a>
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