<?php
// Include external files
include("..//core/session.php");
require_once '../core/functions.php';
$usern = $session->username;


	$error = false;
	$chosenpass = $currentpass = '';
	
	if($_POST) {
		$curpass	 	= mysqli_real_escape_string($con, $_POST['curpass']);
		$newpass		= mysqli_real_escape_string($con, $_POST['newpass']);
		$confirmpass	= mysqli_real_escape_string($con, $_POST['confirmpass']);
		$email		 	= mysqli_real_escape_string($con, $_POST['email']);
		
		//Convert to MD hAshInG
		$currentpass = md5($curpass);
		
		// basic name validation
		if (empty($curpass)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Enter your current password.</span><br>';
		} else if (strlen($curpass) < 8) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Current Password must be 8 characters or more.</span><br>';
		}
		
		if (empty($newpass)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Enter your new password.</span><br>';
		} else if (strlen($newpass) < 8) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> New Password must be 8 characters or more.</span><br>';
		} else if(!preg_match("/[^A-Za-z0-9]+/", ($newpass = trim($newpass)))){
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> New Password must be alphanumeric with special character.</span><br>';
        }
		
		if (empty($confirmpass)) {
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Confirm your new password.</span><br>';
		} else if (strlen($confirmpass) < 8) {
			$error = true;
			echo'<span class="ecolo"><i class="fa fa-warning"></i> Confirm password must be 8 characters or more.</span><br>';
		} else if(!preg_match("/[^A-Za-z0-9]+/", ($newpass = trim($newpass)))){
			$error = true;
			echo'<span class="ecolor"><i class="fa fa-warning"></i> Confirm password must be alphanumeric with special character.</span><br>';
         }
		
		//Confirm New Password 
		if ($newpass == $confirmpass){
			$chosenpass = $newpass;
		} else {
			$chosenpass = '';
			$error = true;
		}
		
		/* Check if password entered is incorrect */
		$query = $con->query("SELECT password FROM  users WHERE username = '$usern'");
		if($query->num_rows == 1){
			while($row = $query->fetch_assoc()){
				$oldpass = $row['password'];
				
				if ($oldpass != $currentpass){
					$error = true;
					echo'<span class="ecolor"><i class="fa fa-warning"></i> Current password does not exist.</span><br>';
				}
				
			}
		}
           
		// if there's no error, continue to place order
		if( !$error ) {
			
			$finalpass = md5($chosenpass);
			
			//INSERT NEW ORDER
			$sql = "UPDATE users SET password = '$finalpass' WHERE username = '$usern'";
				
			// check for successfull insertion
			if ($con->query($sql) === TRUE) {
				echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
					<div class="alert alert-block alert-success">
						<button type="button" class="close" data-dismiss="alert">
							<i class="fa fa-times"></i>
						</button>
						<i class="fa fa-check"></i> Your password has been successfully updated. Next login witll require your new password.
					</div>
				</div><br><br>
				';
				
			} else {
				echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
					<div class="alert alert-block alert-danger">
						<button type="button" class="close" data-dismiss="alert">
							<i class="fa fa-times"></i>
						</button>
						<i class="fa fa-times"></i> The system encountered some errors and your request could not be completed, kindly retry later or CONTACT US if problem persist.<br>'. $con->error.'
					</div><br><br>
				</div>
				';
			}
				
			$con->close();
		}
	}
		
	
?>