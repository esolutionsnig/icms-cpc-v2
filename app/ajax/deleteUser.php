<?php
// Include external files
require_once '../core/db.php';

if (isset($_POST["deleteOneUser"])) {
    $userChosenNames      = mysqli_real_escape_string($con, $_POST['userChosenNames']);

    //INSERT NEW CATEGORY
    $sql = "DELETE FROM users WHERE username = '$userChosenNames'";
    $run_query = mysqli_query($con, $sql);
    if ($run_query) {
        echo'ezielemhaozi';
    }
    //$con->error diplay error message
    $con->close();
}
