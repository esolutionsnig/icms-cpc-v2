<?php
	//Include database configuration file
	require_once '../core/session.php';
    require_once '../core/functions.php';
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
	
	$query = $con->query("SELECT * FROM  ".TBL_USERS." WHERE username = '$user_id'");
	if($query->num_rows == 1){
		while($row = $query->fetch_assoc()){
			$userFullName	= $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		}
	}
?>
			
            <div class="modal-header bg-ecolor">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center" class="modal-title">
                	<i class="fa fa-user pull left"></i> 
					User Account Management
                </h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                	
                    <form class="form-horizontal" novalidate method='post' action="sys/ajax/banaccount.php">
                		<div class="col-md-8">
                        	<div class="item form-group">
                            	<label class="control-label" for="name">
                                	Are You Sure You Want To Suspend <strong><?php echo $userFullName;?></strong>'s Account?
                                </label>
                          	</div>
                        </div>
                        <div class="col-md-4">
                        	<input type="hidden" name="username" id="username" value="<?php echo $user_id; ?>">
                            <button type="submit" class="btn btn-danger banaccounts" id="btn-profile">
                            	<i class="fa fa-times"></i> YES SUSPEND USER ACCOUNT
                           	</button>
                    	</div>
                   	</form>
                    
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-info pull-left" data-dismiss="modal">
                	<i class="ace-icon fa fa-arrow-left"></i> Close 
                </button>
            </div>
         
<script>
$( document ).ready(function() {
	$(".banaccount").click(function() {
		$('#btn-profile').prop('disabled', true);
		$("#btn-profile").html('<i class="fa fa-spinner fa-spin"></i> PROCESSING');
	});
});
</script>