<?php
	//Include database configuration file
    require_once '../core/db.php';
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
						<div class="mail_heading row">
                          	<div class="col-md-8 aero">
                              	<strong>myView</strong>
                                <span>( Admin )</span> to
                                <strong>me</strong>
                            </div>
                            <div class="col-md-4 text-right">
                              <p class="date"> <?php echo $recOn;?> </p>
                            </div>
                            
                            <div class="col-md-12">
                              <h4> <?php echo $subject;?></h4>
                            </div>
                          </div>
                          
                          
                          <div class="view-mail">
                            <p><?php echo $message;?> </p>
                          </div>
                          

<?php
		}
	} else {
		echo '';
	}
?>