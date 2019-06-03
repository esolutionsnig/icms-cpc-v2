<?php
	//Include database configuration file
    require_once '../core/functions.php';
    require_once '../core/db.php';
	require_once '../core/session.php';
	$usern = $session->username;
	
	$query = $con->query("SELECT * FROM  announcements ORDER BY id DESC LIMIT 1");
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$updatedOn	= $row['updatedOn'];
			 echo time_elapsed_string($updatedOn); 
		}
	}
?>