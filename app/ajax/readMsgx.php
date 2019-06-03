<?php
	//Include database configuration file
    require_once '../core/functions.php';
	require_once '../core/session.php';
	$usern = $session->username;
	
    $msgId = $_REQUEST['id'];
    $query = $con->query("SELECT * FROM  message WHERE reciever = '$usern' AND id = '$msgId' ");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$id = $row['id'];
			$subject = $row['subject'];
			$message = $row['message'];
			$recOn = $row['sentOn'];
			$stats = $row['status'];
			$sentBy = $row['sender'];
			
			
			// Fetch Name
			$queryn = $con->query("SELECT * FROM  profile WHERE username = '$sentBy'");
			if($queryn->num_rows > 0){
				while($rown = $queryn->fetch_assoc()){
					$sender = $rown['firstname'].' '.$rown['lastname'];
				}
			}
			
			
			// Set message status to Read
			$qu = $con->query("UPDATE message SET status = 'Read' WHERE id = '$msgId' AND reciever = '$usern'");
			if ($con->query($qu) === TRUE) {
				echo " ";
			} else {
				echo "";
			}
?>
			
             <div class="modal-header bg-ecolor">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center" class="modal-title">
                	<i class="fa fa-comments pull left"></i> 
					<?php echo $subject; ?>  
                    <small class="pull-right white"> From: <?php echo $sender;?> &nbsp; &nbsp; &nbsp; </small>
                </h4>
            </div>
            
            <div class="modal-body">
                <p><?php echo $message; ?></p>
            </div>
            <div class="modal-footer">
            	Recieved On: <span class="dark"><i class="fa fa-calendar"></i> <?php echo date("D M j  Y,  G:i:s",$recOn); ?> </span> &nbsp; &nbsp; 
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