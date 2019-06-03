<?php
	//Include database configuration file
  require_once '../core/db.php';
  require_once '../core/functions.php';
	require_once '../core/session.php';
	$username = $session->username;
	
    $query = $con->query("SELECT * FROM  notifications WHERE reciever = '$username'  AND status = 'Unread' ORDER BY id DESC LIMIT 5");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$id = $row['id'];
			$subject = $row['subject'];
			$message = $row['message'];
			$recOn = $row['sentOn'];
			$stats = $row['status'];
			$sentBy = $row['sender'];
			
			// Get Sender's profile
			$senderDP = "admin.png";
?>
                          
                          	<li>
                              <a href='app/ajax/readMsgx.php?id=<?php echo $id ?>'  data-id='<?php echo $id ?>' data-toggle='modal' data-target='#readModal'>
                                <span class="image"><img src="assets/images/users/<?php echo $senderDP;?>" alt="..." /></span>
                                <span>
                                  <span><?php echo $sentBy;?></span>
                                  <span class="time"><?php echo timestamp($recOn);?></span>
                                </span>
                                <span class="message">
                                  <p><strong><?php echo $subject; ?></strong></p>
                                </span>
                              </a>
                            </li>
                          

<?php
		}
?>
					<li>
                      <div class="text-center">
                        <a href="messages">
                          <strong>See All Messages</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
<?php		
	} else {
?>
        			<li>
                      <div class="text-center">
                        No new notification</strong>
                      </div>
                    </li>
                    <li>
                      <div class="text-center">
                        <a href="messages">
                          <strong>See All Messages</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
<?php
	$con->close();
	}
?>