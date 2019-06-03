<?php
	//Include database configuration file
	require_once '../core/session.php';
    require_once '../core/db.php';
	$usern = $session->username;
	
    $cat_info = $_REQUEST['id'];
	//Decrypt sent request
    $cat_info = base64_decode( $cat_info );
   
    //Explode get value
    $pieces = explode("-", $cat_info);
    $c_id = $pieces[1];

    //Explode get value further
    $newpieces = explode("...", $c_id);
    //$cat_name = $newpieces[1];
	$user_id = $newpieces[0];
	
    $query = $con->query("SELECT * FROM  ".TBL_PROFILE." WHERE username = '$user_id'");
	if($query->num_rows == 1){
		while($row = $query->fetch_assoc()){
			$userFullName	= $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		  	$uaddress = $row['address'];
		  	$dob = strtotime($row['dob']);
		  	$gender = $row['gender'];
		  	$phoneNumber = $row['phoneNumber'];
		  	$stateid = $row['state'];
		  	$countryid = $row['country'];
		  	$occupation = $row['occupation'];
		  	$profile = $row['profile'];
			
			$img = $dp = $row['dp'];
	 		if ($img == "") { $dp = "default.png"; } else { $dp  = $img; }
			
			/* Display requested country information*/
			$qnat = $con->query("SELECT * FROM  countries WHERE id = '$countryid'");
		  	if($qnat->num_rows == 1){
				while($rownat = $qnat->fetch_assoc()){
			  		$country  = $rownat['name'];
				}
		  	}
		  	
			//Fetch State Name
		  	$qsoo = $con->query("SELECT * FROM  states WHERE id = '$stateid'");
		  	if($qsoo->num_rows == 1){
				while($rowsoo = $qsoo->fetch_assoc()){
			  		$state  = $rowsoo['name'];
				}
		  	}
			
?>
			
             <div class="modal-header bg-ecolor">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center" class="modal-title">
                	<i class="fa fa-user pull left"></i> 
					<?php echo $userFullName; ?>
                </h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                	<div class="col-md-5">
                    	<h2>Display Picture</h2>
                    	<div class="profile_img">
                        	<div id="crop-avatar" class="showdp">
                            	<!-- Current avatar -->
                              	<img class="img-responsive avatar-view" src="assets/images/users/<?php echo $dp; ?>" alt="User Avatar" width="90%">
                         	</div>
                    	</div>
                    </div>
                    
                    <div class="col-md-7">
                    	<h2>Other Information</h2>
                    	<ul class="list-unstyled user_data">
                            <li><i class="fa fa-calendar user-profile-icon"></i> <?php echo date('l, F Y h:i:s A', $dob); ?> </li>
    
                            <li><i class="fa fa-fork user-profile-icon"></i> <?php echo $gender; ?></li>
                            
                            <li><i class="fa fa-phone user-profile-icon"></i> <?php echo $phoneNumber; ?> </li>
    
                            <li><i class="fa fa-briefcase user-profile-icon"></i> <?php echo $occupation; ?></li>
                            
                            <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $uaddress.' '.$state; ?> </li>
                            
                            <li><i class="fa fa-flag user-profile-icon"></i> <?php echo $country; ?> </li>
    
                            <li><i class="fa fa-briefcase user-profile-icon"></i> <?php echo $profile; ?></li>
    
                    	</ul>
                    </div>
                    
                    
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                	<i class="ace-icon fa fa-times"></i> Close 
                </button>
            </div>
            

<?php
		}
	} else {
?>

		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><center>Failed Request</center></h4>
            </div>
            <div class="modal-body">
                The requested user profile is incomplete
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                	<i class="ace-icon fa fa-times"></i> Close
                </button>
            </div> 

<?php
		
	}
?>