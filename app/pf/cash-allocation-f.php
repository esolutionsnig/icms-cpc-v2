<?php
// Include external files
require_once '../core/db.php';

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt'); // valid extensions
$path = '../../assets/images/attachments/'; // upload directory

if (!empty($_POST['username']) || $_FILES['image']) {
	$img = $_FILES['image']['name'];
	$tmp = $_FILES['image']['tmp_name'];
 
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
 
	$final_image = rand(1000, 1000000) . $img;

	if (in_array($ext, $valid_extensions)) {
		$path = $path . strtolower($final_image);
		if (move_uploaded_file($tmp, $path)) {
			//insert form data in the database
			$caId = $_POST['caId'];
			$fileImage = strtolower($final_image);
			$sql = "UPDATE cashallocations SET evidence = '$fileImage' WHERE id = '$caId'";
			if ($con->query($sql) === TRUE) {
				echo $fileImage;
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