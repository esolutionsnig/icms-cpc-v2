<?php
	//Include database configuration file
    require_once '../core/functions.php';
    require_once '../core/db.php';
	require_once '../core/session.php';
	$usern = $session->username;
	
	$query = $con->query("SELECT  COUNT(id) as `num` FROM  notifications WHERE username = '$usern' AND status = 'Unread' ");
	$row = $query->fetch_assoc();
	$newMsg = $row['num'];
	echo $newMsg;
	
	$con->close();
	
?>