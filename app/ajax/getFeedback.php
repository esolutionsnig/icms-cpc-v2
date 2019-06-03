<?php
	//Include database configuration file
    require_once '../core/db.php';
    require_once '../core/functions.php';
	require_once '../core/session.php';

	//Grab The Requested ID
	if (isset($_REQUEST['id'])) {
		$staffId = $_REQUEST['id'];
		
    	$query = $con->query("SELECT * FROM  feedbacks WHERE id = '$staffId' ");
		if($query->num_rows == 1){
			while($rowu = $query->fetch_assoc()){
				$fbId       = $rowu["id"];
				$sender     = $rowu["sender"];
				$subject    = $rowu["subject"];
				$message    = $rowu["message"];
				$sentOn     = $rowu["sentOn"];
				$status     = $rowu["status"];
				$phoneno    = $rowu["phoneno"];
				$email      = $rowu["email"];
				$address    = $rowu["address"];


			// Set message status to Read
			$qu = $con->query("UPDATE feedbacks SET status = 'Read' WHERE id = '$staffId'");
			if ($con->query($qu) === TRUE) {
				echo " ";
			} else {
				echo "";
			}

?>
	            <div class="row">
	              	<div class="col-lg-12 col-sm-12">
	                	<div class="card hovercard">
		                  	<div class="info">
		                    	<div class="desc">Sent By: <strong><?php echo $sender; ?></strong></div>
		                    	<div class="desc">Sent On: <strong><?php echo timestamp($sentOn); ?></strong></div>
		                    	<div class="desc">Phone Number: <strong><?php echo $phoneno; ?></strong></div>
		                    	<div class="desc">email: <strong><a href="<?php echo $email; ?>"><?php echo $email; ?></a></strong></div>
		                    	<div class="desc">Address: <strong><?php echo $address; ?></strong></div>
		                  	</div>
		                  	<div class="info">
		                  		<div class="desc">Subject: <strong><?php echo $subject; ?></strong></div>
		                  	</div>
		                  	<div class="info">
		                  		<div class="desc">Message: <strong><?php echo $message; ?></strong></div>
		                  	</div>
	                	</div>
	              	</div>
	            </div>


<?php
			}
		} else {
?>
	            <div class="row">
	            	<div class="col-lg-12 col-sm-12">
	              		<h4>The record searched for does no longer exist.</h4>
	              	</div>
	            </div>

<?php		
		}
	}
?>