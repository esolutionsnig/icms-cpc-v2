<?php
// Include external files
require_once '../core/db.php';

$error = false;

if(isset($_POST["updateNotification"])){

	$recOn	 		= mysqli_real_escape_string($con, $_POST['recOn']);
	$notTitle	 	= mysqli_real_escape_string($con, $_POST['unotTitle']);
	$notBody	 	= mysqli_real_escape_string($con, $_POST['unotBody']);
	$created_at 	= time();

	// basic name validation
	if (empty($notTitle)) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> Please enter notfication title
				</div>
			</div>
		';
	} else if (strlen($notTitle) < 2) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> Notification title must have atleat 2 characters.
				</div>
			</div>
		';
	}

	if (empty($notBody)) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> Please enter notfication title
				</div>
			</div>
		';
	} else if (strlen($notBody) < 20) {
		$error = true;
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-warning"></i> Notification title must have atleat 20 characters.
				</div>
			</div>
		';
	}


	// if there's no error, continue to place order
	if( !$error ) {
		//FETCH ALL USERS
		$sqla = "SELECT * FROM users";
		$run_querya = mysqli_query($con,$sqla);
		$counta = mysqli_num_rows($run_querya);
		if($counta > 0){
			while($rowa = mysqli_fetch_array($run_querya)){
				$recName = $rowa["username"];

				$sql = "UPDATE notifications SET subject = '$notTitle', message = '$notBody', status = 'Unread', recOn = '$created_at' WHERE recOn = '$recOn' ";

				// check for successfull insertion
				if ($con->query($sql) === TRUE) {
					echo'';
				} else {
					echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-block alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="fa fa-times"></i>
							</button>
							<i class="fa fa-times"></i> The system encountered some errors and your request could not be completed, kindly retry later or CONTACT US if problem persist.
						</div>
					</div>
					';
				}
				//$con->error diplay error message
			}
		}

	}
}
?>