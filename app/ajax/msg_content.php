<?php
	//Include database configuration file
  require_once '../core/functions.php';
  require_once '../core/db.php';
	require_once '../core/session.php';
	$username = $session->username;
	
    $query = $con->query("SELECT * FROM  notifications WHERE username = '$username'  AND status = 'Unread' ORDER BY id DESC LIMIT 5");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$id = $row['id'];
			$subject = $row['subject'];
			$message = $row['message'];
			$recOn = $row['recOn'];
			$stats = $row['status'];
			
			// Get Sender's profile
			$senderDP = "admin.png";
?>
                          
                          	<li>
                              <a href='app/ajax/readMsg.php?id=<?php echo $id ?>'  data-id='<?php echo $id ?>' data-toggle='modal' data-target='#readModal'>
                                <span class="image"><img src="assets/images/users/<?php echo $senderDP;?>" alt="admin" /></span>
                                <span>
                                  <span>Admin</span>
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
                        No new notification</strong>
                      </div>
                    </li>
                    <li>
                      <div class="text-center">
                        <a href="notifications">
                          <strong>See All Messages</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
<?php
	$con->close();
	}
?>