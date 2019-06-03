<?php
// Include external files
include("../core/session.php");
require_once '../core/db.php';
require_once '../core/functions.php';
$usern = $session->username;
	
$query = $con->query("SELECT dp FROM  general WHERE username = '$usern'");
if($query->num_rows == 1){
	while($row = $query->fetch_assoc()){
		$dp = $row['dp'];
		echo '<img class="img-responsive avatar-view" src="assets/images/users/'.$dp.'" alt="User Avatar">';
	}
}