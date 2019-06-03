<?php

	require_once '../core/functions.php';
	require_once '../core/session.php';
	
	$output_dir = "../../assets/images/uploads/";	//Set Upload Folder
		
	if($_POST) {
		$sender = mysqli_real_escape_string($con, $_POST['sender']);
		$rec = 'etech';
		$subject = mysqli_real_escape_string($con, $_POST['subject']);
		$message = mysqli_real_escape_string($con, $_POST['message']);
		$sentOn = time();
		$status = 'Unread';
		
		$attachedFile = '';
		if(is_array($_FILES)) {
			$ret = array();
 
			$error =$_FILES["myfile"]["error"];
		   {
		 
				if(!is_array($_FILES["myfile"]['name'])) //single file
				{
					$RandomNum   = time();
		 
					$ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
					$ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
		 
					$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
					$ImageExt       = str_replace('.','',$ImageExt);
					$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
					$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
					
					$attachedFile = $NewImageName;
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $NewImageName);
					 //echo "<br> Error: ".$_FILES["myfile"]["error"];
		 
						 $ret[$fileName]= $output_dir.$NewImageName;
				}
				else
				{
					$fileCount = count($_FILES["myfile"]['name']);
					for($i=0; $i < $fileCount; $i++)
					{
						$RandomNum   = time();
		 
						$ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name'][$i]));
						$ImageType      = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.
		 
						$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
						$ImageExt       = str_replace('.','',$ImageExt);
						$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
						$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
		 
						$ret[$NewImageName]= $output_dir.$NewImageName;
						
						move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$NewImageName );
					}
				}
				$attachedFile = $NewImageName;
			}
		} else {
			$attachedFile = '';
		}
		
		//CHeck AttachedFile stats
		$sntLabel = '-'.$sentOn; //Get the -Time()
		if($attachedFile == $sntLabel){ $attachedFile = ''; }
		
		//INSERT NEW MESSAGE
		$sql = "INSERT INTO message (sender, subject, message, attachFile, sentOn, status, reciever) VALUES ('$sender', '$subject', '$message', '$attachedFile', '$sentOn', '$status', '$rec')";
			
		// check for successfull insertion
		if ($con->query($sql) === TRUE) {
			//header("Location:../../profile?us=".$user);
			echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<i class="ace-icon fa fa-check"></i> Your message was successfully sent
				</div>
			</div><br><br>
			';
		} else {
			//header("Location:../../profile?uf=".$user. $conn->error);
			//echo "Error updating record: " . $con->error;
			echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<i class="ace-icon fa fa-times"></i> Your message was not sent, kindly retry later or contact us if problem persist.
				</div><br><br>
			</div>
			';
		}
			
		$con->close();
	}
		
	
?>