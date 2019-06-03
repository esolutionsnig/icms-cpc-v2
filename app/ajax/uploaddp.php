<?php
// Include external files
require_once '../core/db.php';

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt'); // valid extensions
$path = '../../assets/images/avatar/'; // upload directory

if (!empty($_POST['username']) || $_FILES['image']) {
	$img = $_FILES['image']['name'];
	$tmp = $_FILES['image']['tmp_name'];
 
// get uploaded file's extension
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
 
// can upload same image using rand function
	$final_image = rand(1000, 1000000) . $img;
 
// check's valid format
	if (in_array($ext, $valid_extensions)) {
		$path = $path . strtolower($final_image);

		if (move_uploaded_file($tmp, $path)) {
			
			//include database configuration file
			include_once '../core/db.php';
 
			//insert form data in the database
			$usern = $_POST['username'];
			$userdp = strtolower($final_image);
			$sql = "UPDATE users SET userdp = '$userdp' WHERE username = '$usern'";
			if ($con->query($sql) === TRUE) {
				echo $userdp;
			} else {
				echo 'error400';
				// echo $con->error;
			}
		}
	} else {
		echo 'error400';
	}
}

?>