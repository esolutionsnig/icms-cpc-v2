<?php
	//Include database configuration file
    require_once '../core/db.php';
    require_once '../core/functions.php';
	require_once '../core/session.php';
	$usern = $session->username;
	
    $msgId = $_REQUEST['id'];
    $query = $con->query("SELECT * FROM  feedbacks WHERE id = '$msgId' ");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$id = $row['id'];
			$sender = $row['sender'];
			$subject = $row['subject'];
			$message = $row['message'];
			$sentOn = $row['sentOn'];
			$phoneno = $row['phoneno'];
			$email = $row['email'];
			$address = $row['address'];
			
			
			// Set message status to Read
			$qu = $con->query("UPDATE feedbacks SET status = 'Read' WHERE id = '$msgId'");
			if ($con->query($qu) === TRUE) {
				echo " ";
			} else {
				echo "";
			}
?>
			
             <div class="modal-header bg-ecolor">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center" class="modal-title">
                	<i class="fa fa-envelope pull left"></i> 
					<?php echo $subject; ?>  
                    <small class="pull-right white"> From: <?php echo $sender; ?> &nbsp; &nbsp; &nbsp; </small>
                </h4>
            </div>
            
            <div class="modal-body">
            	<div class="row">
            		<div class="col-sm-4 md mr-10 p-10">
            			<h4>Contact Information</h4>
            			<hr>
            			<p>Phone Number: <strong><a href="tel:<?php echo $phoneno; ?>"><?php echo $phoneno; ?></a></strong></p>
            			<p>Email Address: <strong><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></strong></p>
            			<p>Contact Address: <strong><?php echo $address; ?></strong></p>
            		</div>
            		<div class="col-sm-7 md p-10">
            			<h4>Message</h4>
            			<hr>
            			<?php echo $message; ?>
            		</div>
            	</div>
            </div>
            <div class="modal-footer">
            	Recieved On: <span class="dark"><i class="fa fa-calendar"></i> <?php echo timestamp($sentOn);?> </span> &nbsp; &nbsp; 
                <button type="button" id="<?php echo $id; ?>" class="btn btn-danger readMsg pull-left" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Close </button>
                
            </div>
            

<?php
		}
	} else {
?>

		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><center>Invalid Request</center></h4>
            </div>
            <div class="modal-body">
                The record searched for does not exist
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Close</button>
            </div> 

<?php
		
	}
?>