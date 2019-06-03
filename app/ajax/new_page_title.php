<?php
	//Include database configuration file
    require_once '../core/functions.php';
    require_once '../core/db.php';
	require_once '../core/session.php';
	$usern = $session->username;
	
	$query = $con->query("SELECT  COUNT(id) as `num` FROM  notifications WHERE username = '$usern' AND status = 'Unread' ");
	$row = $query->fetch_assoc();
	$newMsg = $row['num'];
	
	$querys = $con->query("SELECT  COUNT(id) as `num` FROM  message WHERE reciever = '$usern' AND status = 'Unread' ");
	$rows = $querys->fetch_assoc();
	$newMsgs = $rows['num'];

	$querys = $con->query("SELECT  COUNT(id) as `num` FROM  feedbacks WHERE status = 'Unread' ");
	$rows = $querys->fetch_assoc();
	$newFeedbacks = $rows['num'];

	$querys = $con->query("SELECT  COUNT(id) as `num` FROM  history WHERE deliveryStatus = '0' OR deliveryStatus = '1' ");
	$rows = $querys->fetch_assoc();
	$newTransactions = $rows['num'];

	// Sum Both
	$notifs = $newMsgs + $newMsg + $newFeedbacks + $newTransactions;
	echo $notifs;
?>