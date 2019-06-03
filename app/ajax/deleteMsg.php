<?php

	require_once '../core/functions.php';
	require_once '../core/session.php';
	
	if($_POST) {
		$rec = mysqli_real_escape_string($con, $_POST['rec']);
		$msgId = mysqli_real_escape_string($con, $_POST['msgId']);
		
		//DELETE MESSAGE
		$sql = "DELETE FROM message WHERE reciever = '$rec' AND id = '$msgId'";
			
		// check for successfull deletion
		if ($con->query($sql) === TRUE) {
			echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<i class="ace-icon fa fa-check"></i> Your message was successfully deleted
				</div>
			</div><br><br>
			';
		} else {
			echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<i class="ace-icon fa fa-times"></i> There was an erro and your message was not deleted, kindly retry later or contact us if problem persist.
				</div><br><br>
			</div>
			';
		}
			
		$con->close();
	}
		
	
?>