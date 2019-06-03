<?php
//Secret key
$key = 'icmsibehernestekele'; // 8-32 characters without spaces

// Check If data Exists and Returns True if name has been taken
function alreadyTaken($tblName, $slug, $requestdSlug)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM $tblName WHERE $slug = '$requestdSlug' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

function getConsignmentLocationByIdGF($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM consignmentlocations WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

