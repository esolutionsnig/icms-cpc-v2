<?php
// Include external files
require_once '../core/db.php';

$error = false;

if (isset($_POST["changeOneLevel"])) {
    $userChosenName  = mysqli_real_escape_string($con, $_POST['userChosenName']);
    $newAccessLevel  = mysqli_real_escape_string($con, $_POST['newAccessLevel']);

    // if there's no error, continue to place order
    if (!$error) {
        //UPDATE CATEGORY
        $sql = "UPDATE users SET userlevel = '$newAccessLevel' WHERE username = '$userChosenName' ";
        // check for successfull update
        if ($con->query($sql) === true) {
            echo'ezielemhaozi';
        } else {
            echo'<br><div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-block alert-danger">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-times"></i> The system encountered some errors and your request could not be completed, kindly retry later or CONTACT US if problem persist.
				</div>
			</div>
			';
        }
        //$con->error diplay error message
        $con->close();
    }
}
