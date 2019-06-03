<?php
	//Include database configuration file
    require_once '../core/db.php';
    require_once '../core/functions.php';
	require_once '../core/session.php';

	//Grab The Requested ID
	if (isset($_REQUEST['id'])) {
		$staffId = $_REQUEST['id'];
		
    	$query = $con->query("SELECT * FROM  users WHERE username = '$staffId' ");
		if($query->num_rows == 1){
			while($rowu = $query->fetch_assoc()){
				$staffUserName    = $rowu["username"];
	            $staffName        = $rowu["surname"].' '.$rowu["middlename"].' '.$rowu["firstname"];
	            $staffEmail       = $rowu["email"];
	            $staffMobile      = $rowu["phoneno"];
	            $staffLevel       = $rowu["userlevel"];
	            $lastSeen         = $rowu["timestamp"];

	            /* Display requested user information from profile table*/
				$req_user_profile_data 	= $database->getUserProfile($staffUserName);
				$staffOccupation 		= $req_user_profile_data['occupation'];
				$staffProfile 			= $req_user_profile_data['profile'];
				$staffAddress 			= $req_user_profile_data['address'];
				$staffGender 			= $req_user_profile_data['gender'];
				$staffDob 				= $req_user_profile_data['dob'];
				$staffDp				= $req_user_profile_data['dp'];
				//Set Image
				if ($staffDp == "") { $staffDp = "default.png"; } else { $staffDp  = $staffDp; }

?>
	            <div class="row">
	              	<div class="col-lg-5 col-sm-5">
	                	<div class="card hovercard">
		                  	<div class="cardheader"></div>
		                  	<div class="avatarm">
		                    	<img alt="" src="assets/images/staff/<?php echo $staffDp;?>">
		                  	</div>
		                  	<div class="info">
		                    	<div class="title">
		                      		<?php echo $staffName; ?>
		                    	</div>
		                    	<div class="desc">Date of Birth: <strong><?php echo $staffDob; ?></strong></div>
		                    	<div class="desc">Gender: <strong><?php echo $staffGender; ?></strong></div>
		                    	<div class="desc">Phone Number: <strong><?php echo $staffMobile; ?></strong></div>
		                    	<a href="mailto:<?php echo $staffEmail; ?>" class="btn btn-success upcase saveCategory">
	              					<i class="fa fa-envelope"></i> 
	            				</a>
				            	<a href="tel:<?php echo $staffMobile; ?>" class="btn btn-info upcase saveCategory">
				              		<i class="fa fa-phone"></i> 
				            	</a>
		                  	</div>
	                	</div>
	              	</div>
	              	<div class="col-lg-7 col-sm-7">
	                	<div class="card hovercard">
		                  	<div class="info">
		                    	<div class="desc">Address: <strong><?php echo $staffAddress; ?></strong></div>
		                  	</div>
		                  	<div class="info">
		                    	<div class="desc"><strong>Profile</strong></div>
		                    	<div class="desc"><?php echo $staffProfile; ?></div>
		                  	</div>
	                	</div>
	              	</div>
	            </div>


<?php
			}
		} else {
?>
	            <div class="row">
	            	<div class="col-lg-12 col-sm-12">
	              		<h4>The record searched for does no longer exist.</h4>
	              	</div>
	            </div>

<?php		
		}
	}
?>