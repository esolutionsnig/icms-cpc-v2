<?php
// Ensure included file exists
$file = "../core/functions.php";
if ( file_exists($file) && is_readable($file))
{
	include ($file);
} else
{
	$errMsg = "Error: included S file is missing";
}
if($_POST) {
		$captcha1	 = mysqli_real_escape_string($con, $_POST['captcha1']);
		$captcha2	 = mysqli_real_escape_string($con, $_POST['captcha2']);
		$captcha3	 = mysqli_real_escape_string($con, $_POST['captcha3']);
		//Add Captcha1 and Captcha2 and check if it sums up to Captcha3
		$sumCaptcha = $captcha1 + $captcha2;
		if ($captcha3 == $sumCaptcha){
			echo '<span class="green">&nbsp; <i class="fa fa-check"></i> Correct</span>';
		} else {
			echo '<span class="ecolor">&nbsp; <i class="fa fa-times"></i>  Wrong</span>';
		}
		
		
}

?>