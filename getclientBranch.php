<?php
$clientBranch = $_POST['depart'];
 
require('app/core/db.php');
$sql = " SELECT branch_location, branch_location_code FROM bank_branches WHERE id = '$clientBranch' ";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branch_location = $row['branch_location'];
        $branch_location_code = $row['branch_location_code'];
        $users_arr[] = array("branch_location" => $branch_location, "branch_location_code" => $branch_location_code);
    }
    // encoding array to json format
    echo json_encode($users_arr);
    
}