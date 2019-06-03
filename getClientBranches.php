<?php
$cid = $_POST['cid'];
 
require('app/core/db.php');
$sql = " SELECT id, name FROM bank_branches WHERE banks_id = '$cid' ";
$result = $con->query($sql);
if ($result->num_rows > 0) {
  // echo '<option value="">Select Requesting Branch</option>';
  while ($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $id = $row['id'];
    echo '<option value="'.$id.'">'.$name.'</option>';
  }
}