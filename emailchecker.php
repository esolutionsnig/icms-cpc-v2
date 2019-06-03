<?php
// Ensure included file exists
$file = "app/core/db.php";
if ( file_exists($file) && is_readable($file))
{
	include ($file);
} else
{
	$errMsg = "Error: included S file is missing";
}
		
if(isset($_POST['action']) && $_POST['action'] == 'emailadd_availability'){ // Check for the username posted
	$email 		= htmlentities($_POST['email']); // Get the username values
	$q = 'SELECT count(*) FROM users WHERE email = "'.$email.'" ';
	$result = mysqli_query($con, $q);
	//$result	= mysql_query('SELECT count(*) FROM users WHERE username = "'.$username.'" '); // Check the database
	$row = mysqli_fetch_row($result);
	$user_count = $row[0];
	if($user_count >= 1) echo '<span class="red-text">Email Address Already Exists</span>';
	else echo '';
}

?>