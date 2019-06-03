<?php
// Include external files
include("..//core/session.php");
require_once '../core/db.php';
require_once '../core/functions.php';
$usern = $session->username;

// Get user email from users table
	$req_user_info = $database->getUserInfo($usern);
	$usermail 		= $req_user_info['email'];
	$userphone 		= $req_user_info['phoneno'];
	
	
$query = $con->query("SELECT * FROM  profile WHERE username = '$usern'");
if($query->num_rows == 1){
	while($row = $query->fetch_assoc()){
		$dp = $row['dp'];
		$names = $row['firstname'].' '.$row['lastname'].' '.$row['othernames'];
		$address = $row['address'].' '.$row['ustate'];
		$occupation = $row['occupation'];
		echo '
		<li>
                        	<i class="fa fa-map-marker fa-1x ecolor"></i> '.$address.'
                        </li>

                        <li>
                          <i class="fa fa-briefcase fa-1x ecolor"></i> '.$occupation.'
                        </li>
                        
                        <li>
                        	<i class="fa fa-mobile fa-1x ecolor"></i> '.$userphone.'
                        </li>

                        <li class="m-top-xs">
                          <i class="fa fa-envelope fa-1x ecolor"></i>
                          <a href="mailto:<?php echo $usermail;?>">'.$usermail.'</a>
                        </li>
		';
	}
}
?>