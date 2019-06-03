<?php
// Include external files
require_once '../core/db.php';

if(isset($_POST["deleteOneNotification"])){

	$recOn	 	= mysqli_real_escape_string($con, $_POST['notiId']);
	// echo $recOn;

	// INSERT NEW CATEGORY
	$sql = "DELETE FROM notifications WHERE recOn = '$recOn' ";
	$run_query = mysqli_query($con,$sql);
	if($run_query){
		echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-times"></i> Notification Deleted
				</div>
			</div><hr>
			';
	}
	//$con->error diplay error message
	// $con->close();
}
?>