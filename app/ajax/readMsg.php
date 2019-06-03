<?php
	//Include database configuration file
    require_once '../core/db.php';
    require_once '../core/functions.php';
	require_once '../core/session.php';
	$usern = $session->username;
	
    $msgId = $_REQUEST['id'];
    $query = $con->query("SELECT * FROM  notifications WHERE username = '$usern' AND id = '$msgId' ");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$id = $row['id'];
			$subject = $row['subject'];
			$message = $row['message'];
			$recOn = $row['recOn'];
			$stats = $row['status'];
			
			
			// Set message status to Read
			$qu = $con->query("UPDATE notifications SET status = 'Read' WHERE id = '$msgId' AND username = '$usern'");
			if ($con->query($qu) === TRUE) {
				echo " ";
			} else {
				echo "";
			}
?>
			
             <div class="modal-header bg-ecolor">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center" class="modal-title">
                	<i class="fa fa-bullhorn pull left"></i> 
					<?php echo $subject; ?>  
                    <small class="pull-right white"> From: Admin &nbsp; &nbsp; &nbsp; </small>
                </h4>
            </div>
            
            <div class="modal-body">
                <font size="+1"><?php echo $message; ?></font>
            </div>
            <div class="modal-footer">
            	Recieved On: <span class="dark"><i class="fa fa-calendar"></i> <?php echo timestamp($recOn);?> </span> &nbsp; &nbsp; 
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