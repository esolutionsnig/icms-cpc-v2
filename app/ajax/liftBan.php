<?php
	//Include database configuration file
	require_once '../core/session.php';
    require_once '../core/db.php';
    require_once '../core/functions.php';
	$usern = $session->username;
	
    $user_id = $_REQUEST['id'];
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
                	
                    <form class="form-horizontal" novalidate method='post' action="sys/ajax/unban.php">
                		<div class="col-md-8">
                        	<div class="item form-group">
                            	<label class="control-label" for="name">
                                	Are You Sure You Want To Delete <strong><?php echo $user_id;?></strong>'s Account?
                                </label>
                          	</div>
                        </div>
                        <div class="col-md-4">
                        	<input type="hidden" name="username" id="username" value="<?php echo $user_id; ?>">
                            <button type="submit" class="btn btn-danger banaccount" id="btn-profile">
                            	<i class="fa fa-save"></i> YES, DELETE THIS ACCOUNT
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