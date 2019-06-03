<?php
	//Include database configuration file
	require_once '../core/session.php';
    require_once '../core/functions.php';
	$usern = $session->username;
	
    $user_id = $_REQUEST['id'];
    $query = $con->query("SELECT * FROM  ".TBL_USERS." WHERE username = '$user_id'");
	if($query->num_rows == 1){
		while($row = $query->fetch_assoc()){
			$ulevel = $row['userlevel'];
			
			//Generate User Level Name
			if ($ulevel == 9){
				$ulevelName = ADMIN_NAME;
			} else if ($ulevel == 8){
				$ulevelName = GM_NAME;
			} else if ($ulevel == 7){
				$ulevelName = MOD_NAME;
			} else if ($ulevel == 6){
				$ulevelName = CONT_NAME;
			} else {
				$ulevelName = M_NAME;
			}
			
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
                	<div class="col-md-6">
                    	<h2>Change User Registration Status</h2>
                    	<hr />
                        <form class="form-horizontal" novalidate method='post' action="sys/ajax/cancelregistration.php">
                        	<div class="item form-group">
                            	<label class="control-label col-md-5" for="name">Account Levels </label>
                                <div class="col-md-7">
                                	<div style="border-bottom: 1px solid #333;">
                                    	<select name="ulevel" id="ulevel" class="form-control levelinfo">
                                        	<option value="<?php if($ulevel == ""){ echo "1";} else { echo $ulevel; } ?>"><?php if($ulevel == ""){ echo "Choose new user level...";} else { echo $ulevelName; } ?></option>
                                            <option>---------------------------------</option>
                                           	<option value="9">Administrator</option>
                                          	<option value="8">Managing Director</option>
                                            <option value="7">Moderator</option>
                                          	<option value="1">Member</option>
                                      	</select>
                                    </div>
                             	</div>
                          	</div>
                            
                            <div class="col-md-6" id="pfeed"> </div>
                            <div class="col-md-6">
                            	<input type="hidden" name="username" id="username" value="<?php echo $user_id; ?>">
                               	<button type="submit" class="btn btn-success upaccount" id="btn-profile">
                               		<i class="fa fa-save"></i> CANCEL REGISTRATION
                               	</button>
                          	</div>
                    	</form>
                                                    
                    </div>
                    
                    <div class="col-md-6">
                    	<h2 class="yoscolor">Important Information</h2>
                        <hr />
                    	
                        <p id="levelinfofb"> </p>
                        
                    </div>
                    
                    
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-danger" data-dismiss="modal">
                	<i class="ace-icon fa fa-times"></i> Close 
                </button>
            </div>
         
<script>
$( document ).ready(function() {
	$(".levelinfo").change(function() {
		var levelinfo = $(this).val();
		if (levelinfo == 9){
			$("#levelinfofb").html('<strong>ADMINISTRATOR LEVEL</strong><br>This level will give the user access to do site wide changes. Do not assign this level to unauthorised individual. Proceed with extreme caution.');
        } else if (levelinfo == 8){
			$("#levelinfofb").html('<strong>MANAGER LEVEL</strong><br>This level will give the user access to make some important changes. Proceed with caution.');
        } else if (levelinfo == 7){
			$("#levelinfofb").html('<strong>MODERATOR LEVEL</strong><br>This level will give the user access act as moderators. Proceed with caution.');
        } else if (levelinfo == 6){
			$("#levelinfofb").html('<strong>CONTESTANT LEVEL</strong><br>This level will give the user access to participate on the YoTalent show as a contestant. Proceed with caution.');
        } else {
			$("#levelinfofb").html('<strong>MEMBER LEVEL</strong><br>This level will give the user minimal access.');
        }
	});
	
	$(".upaccount").click(function() {
		$("#btn-profile").html('<i class="fa fa-spinner fa-spin"></i> PROCESSING');
	});
});
</script>