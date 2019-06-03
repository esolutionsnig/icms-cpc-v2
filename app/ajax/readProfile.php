<?php
	//Include database configuration file
    require_once '../core/functions.php';
	require_once '../core/session.php';
	$usern = $session->username;

	
if($_GET['edit_id'])
{
	$profileId = $_GET['edit_id'];	
	
    $query = $con->query("SELECT * FROM  profile WHERE username = '$profileId' ");
	if($query->num_rows  == 1){
		while($row = $query->fetch_assoc()){
			$refName = $row['firstname'].' '.$row['othernames'].' '.$row['lastname'];
			$refgender = $row['gender'];
			$refaddress = $row['address'].' '.$row['ustate'];
			$refdp = $row['dp'];
			
			if ($refdp == "") { $refrdp = "default.png"; } else { $refrdp  = $refdp; }
			
?>
			<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="bg-green col-md-12" style="padding: 10px 40px 10px 40px; margin-top: 20px; margin-bottom: 20px;">
                    <h4 align="center">
                        <?php echo $refName; ?>
                    </h4>
                </div>
            
            	<div class="col-md-12">
                    <div class="col-md-4" style="padding: 20px 40px 20px 40px; margin-top: 20px; margin-bottom: 20px;">
                        <img class="img-responsive avatar-view" src="assets/images/users/<?php echo $refrdp; ?>" width="90%" alt="User Avatar">
                    </div>
                    
                    <div class="col-md-8" style="padding: 10px 40px 10px 40px; margin-top: 20px; margin-bottom: 20px;">
                    	<p>Name: <strong><?php echo $refName;?></strong></p>
                        <p>Gender: <strong><?php echo $refgender;?></strong></p>
                        <p>Address: <strong><?php echo $refaddress;?></strong></p>
                        <br />
                        
                    </div>
                </div>
                
                <hr /> 
                
            </div>
            
<?php
		}
	} else {
?>

            
            <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="bg-ecolor col-md-12" style="padding: 20px 40px 20px 40px; margin-top: 20px; margin-bottom: 20px;">
                    <h4 align="center" class="modal-title">
                        Profile Empty
                    </h4>
                </div>
            
            	<div class="col-md-12">
                    The profile searched for is still very empty, contact your downline to update his/her profile information.
                </div>
                
            </div>
            
<?php
		
	}
} else {
	header("Location: referrals");
}
?>