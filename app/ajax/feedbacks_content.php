<?php
	//Include database configuration file
  require_once '../core/functions.php'; 
  require_once '../core/db.php';
	require_once '../core/session.php';
	$username = $session->username;
	
    $query = $con->query("SELECT * FROM  feedbacks WHERE status = 'Unread' ORDER BY id DESC LIMIT 6");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$id = $row['id'];
      $sender = $row['sender'];
			$subject = $row['subject'];
			$message = $row['message'];
			$sentOn = $row['sentOn'];
			$stats = $row['status'];
			
			// Get Sender's profile
			$senderDP = "default.png";
?>
                          
                          	<li>
                              <a href='app/ajax/readFeedback.php?id=<?php echo $id ?>'  data-id='<?php echo $id ?>' data-toggle='modal' data-target='#readModal' class='readFb'>
                                <span class="image"><img src="assets/images/users/<?php echo $senderDP;?>" alt="admin" /></span>
                                <span>
                                  <span><?php echo $sender; ?></span>
                                  <span class="time"><?php echo timestamp($sentOn);?></span>
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
                        <a href="notifications">
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
                        No new message</strong>
                      </div>
                    </li>
                    <li>
                      <div class="text-center">
                        <a href="feedbacks">
                          <strong>See All Feedbacks</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
<?php
	$con->close();
	}
?>