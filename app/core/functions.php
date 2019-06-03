<?php
//Secret key
$key = 'icmsibehernestekele'; // 8-32 characters without spaces

// Get Number Of Dispatched Requests
function getNumberOfDispatchedRequests($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM supplybranches WHERE supply_id = '$reqId' AND is_dispatched = 'YES' ";
  $result = $con->query($sql);
  return $result->num_rows;
  $con->close();
}

// Get Number Of Packed Bags Per Request
function getNumberOfPackedBags($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM supplybranches WHERE supply_id = '$reqId' ";
  $result = $con->query($sql);
  return $result->num_rows;
  $con->close();
}


// Get Total Amount Requested
function getTotalSupplyRequest($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM supplybranches WHERE supply_id = '$reqId' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Total MINT Cash 1k In a Location
function getTotalMintCash1k($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '1' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 5h In a Location
function getTotalMintCash5h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '2' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 2h In a Location
function getTotalMintCash2h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '3' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 1h In a Location
function getTotalMintCash1h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '4' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 50 In a Location
function getTotalMintCash50($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '5' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 20 In a Location
function getTotalMintCash20($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '6' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 10 In a Location
function getTotalMintCash10($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '7' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total MINT Cash 5 In a Location
function getTotalMintCash5($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '1' AND denomination_id = '8' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Total Atm Cash 1k In a Location
function getTotalAtmCash1k($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '1' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 5h In a Location
function getTotalAtmCash5h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '2' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 2h In a Location
function getTotalAtmCash2h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '3' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 1h In a Location
function getTotalAtmCash1h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '4' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 50 In a Location
function getTotalAtmCash50($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '5' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 20 In a Location
function getTotalAtmCash20($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '6' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 10 In a Location
function getTotalAtmCash10($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '7' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Atm Cash 5 In a Location
function getTotalAtmCash5($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '3' AND denomination_id = '8' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Total Fit Cash 1k In a Location
function getTotalFitCash1k($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '1' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 5h In a Location
function getTotalFitCash5h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '2' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 2h In a Location
function getTotalFitCash2h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '3' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 1h In a Location
function getTotalFitCash1h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '4' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 50 In a Location
function getTotalFitCash50($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '5' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 20 In a Location
function getTotalFitCash20($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '6' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 10 In a Location
function getTotalFitCash10($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '7' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Fit Cash 5 In a Location
function getTotalFitCash5($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '4' AND denomination_id = '8' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Total Unfit Cash 1k In a Location
function getTotalUnfitCash1k($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '1' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 5h In a Location
function getTotalUnfitCash5h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '2' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 2h In a Location
function getTotalUnfitCash2h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '3' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 1h In a Location
function getTotalUnfitCash1h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '4' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 50 In a Location
function getTotalUnfitCash50($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '5' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 20 In a Location
function getTotalUnfitCash20($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '6' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 10 In a Location
function getTotalUnfitCash10($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '7' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unfit Cash 5 In a Location
function getTotalUnfitCash5($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '2' AND denomination_id = '8' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Total Unprocessed Cash 1k In a Location
function getTotalUnprocessedCash1k($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '1' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 5h In a Location
function getTotalUnprocessedCash5h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '2' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 2h In a Location
function getTotalUnprocessedCash2h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '3' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 1h In a Location
function getTotalUnprocessedCash1h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '4' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 50 In a Location
function getTotalUnprocessedCash50($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '5' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 20 In a Location
function getTotalUnprocessedCash20($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '6' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 10 In a Location
function getTotalUnprocessedCash10($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '7' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total Unprocessed Cash 5 In a Location
function getTotalUnprocessedCash5($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '8' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Total AwConf Cash 1k In a Location
function getTotalAwConfCash1k($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '1' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 5h In a Location
function getTotalAwConfCash5h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '2' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 2h In a Location
function getTotalAwConfCash2h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '3' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 1h In a Location
function getTotalAwConfCash1h($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '4' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 50 In a Location
function getTotalAwConfCash50($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '5' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 20 In a Location
function getTotalAwConfCash20($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '6' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 10 In a Location
function getTotalAwConfCash10($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '7' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}
// Get Total AwConf Cash 5 In a Location
function getTotalAwConfCash5($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' AND category_id = '6' AND denomination_id = '8' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Cash Preparation Per Currency & Seal Number
function getAmountCashPreparationsPerCurrency($sealNumber, $currencySlug)
{
  require('db.php');
  $q = " SELECT SUM(total_amount) AS tamount FROM evacuationpreparations WHERE seal_number = '$sealNumber' AND currency_id = '$currencySlug' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}


// Get Amount By Seal Number
function getAmountBySealNUmberCashPreparations($reqId)
{
  require('db.php');
  $q = " SELECT SUM(total_amount) AS tamount FROM evacuationpreparations WHERE seal_number = '$reqId' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

function getAmountBySealNUmberSealings($reqId)
{
  require('db.php');
  $q = " SELECT SUM(amount) AS tamount FROM sealings WHERE seal_number = '$reqId' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Currency By Seal Number
function getDataCashPreparations($reqId)
{
  require('db.php');
  $q = " SELECT * FROM evacuationpreparations WHERE seal_number = '$reqId' ";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
    return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
function getDataSealings($reqId)
{
  require('db.php');
  $q = " SELECT * FROM sealings WHERE seal_number = '$reqId' ";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
    return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Total Amount In Staff Location
function getAmountWithStaff($reqId)
{
  // Add DB Connection
  require('db.php');
  $totalAmountHolding = $amount = 0;
  $sql = " SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '$reqId' AND is_opened = 'NO' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Get Amount From Cash Preparations
      $totalCP = getAmountBySealNUmberCashPreparations($row['seal_number']);
      $totalS = getAmountBySealNUmberSealings($row['seal_number']);
      $totalAmountHolding += $totalCP + $totalS;
      // $totalAmountHolding += $totalS;
    }
  } 
  return $totalAmountHolding;
  $con->close();
}

function getAmountSealedByUser($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(total_amount_sealed) AS tsamount FROM sealings WHERE seal_batch = '$reqId' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tsamount'];
    }
  }
}

// Get Total Amount With CIT
function getTotalCit($currencySlug)
{
  // Add DB Connection
  require('db.php');
  $totalCP = 0;
  $sql = " SELECT DISTINCT seal_number FROM cits WHERE delivery_status = 'In Transit' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Get Amount From Cash Preparations
      $totalCP += getAmountCashPreparationsPerCurrency($row['seal_number'], $currencySlug);
    }
  } 
  return $totalCP;
  $con->close();
}

// Get Total Amount In Building Executive View
function getTotalAmountExecustiveView()
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(bb_balance) AS tamount FROM bookballances ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Check If All Bags Has Been Accepted CIT
function allBagsCofirmedCIT($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations WHERE evacuation_id = '$reqId' AND is_pickedup = 'YES' ";
  $result = $con->query($sql);
  return $result->num_rows;
}
// Check if all bags has been accepted SR
function allBagsCofirmedCITSR($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT DISTINCT seal_number FROM supplybranches WHERE id = '$reqId' AND is_delivered = 'YES' ";
  $result = $con->query($sql);
  return $result->num_rows;
}

// Get Total Number Of Expected Bags
function getCITBags3($reqId)
{
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM cits WHERE evacuation_id = '$reqId' ";
  $result = $con->query($sql);
  return $result->num_rows;
}
// Get total bags SR
function getCITBags4($reqId)
{
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM supplybranches WHERE supply_id = '$reqId' ";
  $result = $con->query($sql);
  return $result->num_rows;
}

// Check If All Bags Has Been Handed Over
function isAllBagsHandedOver($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations WHERE pickedup_by = '$reqId' AND is_handed_over = 'NO' ";
  $result = $con->query($sql);
  return $result->num_rows;
}

// Get Number Of Deposit Types
function getNumDepositTypes()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM deposittypes";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}
// Get Number Of Deposit Categories
function getNumDepositCategories()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM depositcategories";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}
// Get Number Of Vehicles
function getNumVehicles()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM vehicles";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}
// Get Number Of Consignment Locations
function getNumConsignmentLocations()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM consignmentlocations";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}
// Get Number Of Container Types
function getNumContainerTypes()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM containertypes";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}
// Get Number Of Denominations
function getNumDenominations()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM denominations";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}
// Get Number Of Currencies
function getNumCurrencies()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM currencies";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get NUmber Of Requests
function getClientRequest()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM evacuations";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get NUmber Of Bundle Confirmations
function getBundleConfirmationss()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM bundleconfirmations";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get NUmber Of Cash Allocations
function getCashAllocations()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM cashallocations";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get NUmber Of Sealed Bags
function getSealedContainers()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM sealings WHERE is_opened = 'NO' ";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get NUmber Of Containers In Vault
function getVaultItems()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM sealings WHERE location_id = '4' OR location_id = '5' ";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Check If data Exists and Returns True if name has been taken
function alreadyTaken($tblName, $slug, $requestdSlug)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM $tblName WHERE $slug = '$requestdSlug' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}
// Check If data Exists and Returns True if variables has been taken but  not with the current id
function alreadyTaken2($tblName, $slug, $requestdSlug, $id, $expectedId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM $tblName WHERE $slug = '$requestdSlug' AND $id != '$expectedId' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

// Check If bundle confiirmation is active 
function bundleConfirmationStatus($username)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM bundleconfirmations WHERE added_by = '$username' AND confirmation_done = 'NO' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

// Get Number Of Added Bags Per Client ID
function getNumberCountedBagsPerClient($username, $reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM cits WHERE evacuation_id = '$reqId' AND bundle_confirmed_by = '$username' ";
  $result = $con->query($sql);
  echo $result->num_rows;
}

// Check If data Exists and Returns True if name has been taken
function isBagAdded($username, $clientId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM bundleconfirmations WHERE client_id = '$clientId' AND added_by = '$username' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

// Check If data Exists and Returns True if name has been taken
function bagExists($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations WHERE evacuation_id = '$reqId' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

// Get Number Of Prepared Bags Per Request ID
function getNumberPreparedBagsPerRequest($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT DISTINCT seal_number FROM evacuationpreparations WHERE evacuation_id = '$reqId' ";
  $result = $con->query($sql);
  echo $result->num_rows;
}

// Get Amount Prepared Per Request ID
function getTotalAmountPreparedBagsPerRequest($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(total_amount) AS tamount FROM evacuationpreparations WHERE evacuation_id = '$reqId' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}

// Get Client Book Balance
function getClientBookBalance($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT bb_balance FROM bookballances WHERE banks_id = '$reqId' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['bb_balance'];
    }
  }
}

// Get Number Of Prepared Branch Request
function getTotalBranchSupplyRequest($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM supplybranches WHERE supply_id = '$reqId' ";
  $result = $con->query($sql);
  echo $result->num_rows;
}

// Get Total Amount Per Supply Request Not Delivered
function getUndeliveredSupplyRequest($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(amount) AS supreqamount FROM supplybranches WHERE client = '$reqId' AND is_delivered = 'NO' AND is_splitted = 'NO' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['supreqamount'];
    }
  }
}

// Get Client Total Requests
function getClientTotalPendingSupplyRequests($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(amount) AS supreqamount FROM supplybranches WHERE client = '$reqId' AND is_delivered = 'NO' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['supreqamount'];
    }
  }
}

// Get Pending Evacuation requests
function getClientTotalPendingEvacuationRequests($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(total_amount) AS tamount FROM evacuationpreparations WHERE client_id = '$reqId' AND is_pickedup = 'NO' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['tamount'];
    }
  }
}


// Get Total Amount Per Supply Request
function getTotalAmountPerSupplyRequest($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT SUM(amount) AS supreqamount FROM supplybranches WHERE supply_id = '$reqId' AND is_deleted = 'NO' AND is_splitted = 'NO' ";
  $result = mysqli_query($con, $q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['supreqamount'];
    }
  }
}

//Fetch Users Count
function getNumberUsers()
{
  // Add DB Connection
  require('db2.php');

  $sql = "SELECT * FROM users";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Display Client List
function getClientList()
{
  require('db.php');
  $sql = "SELECT * FROM banks ORDER BY id DESC";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    echo '<ul id="sfUL">';
    while ($row = $result->fetch_assoc()) {
      $bUID = $row['id'].'------'.$row['bank_slug'].'------el';
      $bankUID = base64_encode($bUID);
      echo '<li><a href="client?r=' . $row['bank_slug'].'cprf'.$bankUID .'">' . $row['bank_name'] . '</a></li>';
    }
    echo '</ul>';
  } else {
    echo 'No client found';
  }
  $con->close();
}

// Get Cash Tied To Same bag
function getBagContenz($reqId)
{
  require('db.php');
  $q = " SELECT * FROM evacuationpreparations WHERE seal_number = '$reqId' ";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
    return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Currency Icon
function currencyIcon($currency_id)
{
  if ($currency_id == '1') {
    $currencyIcon = '<small>&#8358;</small>';
  } else if ($currency_id == '2') {
    $currencyIcon = '<small>&euro;</small>';
  } else if ($currency_id == '4') {
    $currencyIcon = '<small>&#163;</small>';
  } else if ($currency_id == '3') {
    $currencyIcon = '<small>&#36;</small>';
  } else if ($currency_id == '7') {
    $currencyIcon = '<small>&#165;</small>';
  } else if ($currency_id == '6') {
    $currencyIcon = '<small>CFA</small>';
  } else if ($currency_id == '5') {
    $currencyIcon = '<small>R</small>';
  }
  return $currencyIcon;
}
function currencyIconn($currency_id)
{
  if ($currency_id == 'naira') {
    $currencyIcon = '<small>&#8358;</small>';
  } else if ($currency_id == 'euro') {
    $currencyIcon = '<small>&euro;</small>';
  } else if ($currency_id == 'gbp') {
    $currencyIcon = '<small>&#163;</small>';
  } else if ($currency_id == 'usd') {
    $currencyIcon = '<small>&#36;</small>';
  } else if ($currency_id == 'cny') {
    $currencyIcon = '<small>&#165;</small>';
  } else if ($currency_id == 'cfa') {
    $currencyIcon = '<small>CFA</small>';
  } else if ($currency_id == 'zaf') {
    $currencyIcon = '<small>R</small>';
  }
  return $currencyIcon;
}

// Get Currency Name
function currencyName($currency_id)
{
  if ($currency_id == '1') {
    $currencyName = 'Nigerian Naira';
  } else if ($currency_id == '2') {
    $currencyName = 'European Euro';
  } else if ($currency_id == '4') {
    $currencyName = 'British Pounds';
  } else if ($currency_id == '3') {
    $currencyName = 'US Dollars';
  } else if ($currency_id == '7') {
    $currencyName = 'Chinese Yen';
  } else if ($currency_id == '6') {
    $currencyName = 'Centra African Republic Franc';
  } else if ($currency_id == '5') {
    $currencyName = 'South African Rand';
  }
  return $currencyName;
}


// Get Cash Tied To Same Bag
function getBagContent($sealNumber)
{
  // Add DB Connection
  require('db.php');
  $currencyIcon = $currencyName = '';
  $sql = " SELECT * FROM evacuationpreparations WHERE seal_number = '$sealNumber' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $currency_id = $row['currency_id'];
      $total_amount = $row['total_amount'];     
      // Get Currencies
      if ($currency_id == 'naira') {
          $currencyName = 'Nigerian Naira';
          $currencyIcon = '<small>&#8358;</small>';
      } else if ($currency_id == 'euro') {
          $currencyName = 'European Euro';
          $currencyIcon = '<small>&euro;</small>';
      } else if ($currency_id == 'gbp') {
          $currencyName = 'British Pounds';
          $currencyIcon = '<small>&#163;</small>';
      } else if ($currency_id == 'usd') {
          $currencyName = 'US Dollars';
          $currencyIcon = '<small>&#36;</small>';
      } else if ($currency_id == 'cny') {
          $currencyName = 'Chinese Yen';
          $currencyIcon = '<small>&#165;</small>';
      } else if ($currency_id == 'cfa') {
          $currencyName = 'Centra African Republic Franc';
          $currencyIcon = '<small>CFA</small>';
      } else if ($currency_id == 'zar') {
          $currencyName = 'South African Rand';
          $currencyIcon = '<small>R</small>';
      }
      echo '<small class="blue-grey-text uppercase">Denomination (Amount)<br></small> ';
                if ($row['cash_1000_amount'] != ''){ echo '1000 ('; }
                if ($row['cash_1000_amount'] != ''){ echo '<b>' . number_format($row['cash_1000_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_500_amount'] != ''){ echo '500 ('; }
                if ($row['cash_500_amount'] != ''){ echo '<b>' . number_format($row['cash_500_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_200_amount'] != ''){ echo '200 ('; }
                if ($row['cash_200_amount'] != ''){ echo '<b>' . number_format($row['cash_200_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_100_amount'] != ''){ echo '100 ('; }
                if ($row['cash_100_amount'] != ''){ echo '<b>' . number_format($row['cash_100_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_50_amount'] != ''){ echo '50 ('; }
                if ($row['cash_50_amount'] != ''){ echo '<b>' . number_format($row['cash_50_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_20_amount'] != ''){ echo '20 ('; }
                if ($row['cash_20_amount'] != ''){ echo '<b>' . number_format($row['cash_20_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_10_amount'] != ''){ echo '10 ('; }
                if ($row['cash_10_amount'] != ''){ echo '<b>' . number_format($row['cash_10_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_5_amount'] != ''){ echo '5 ('; }
                if ($row['cash_5_amount'] != ''){ echo '<b>' . number_format($row['cash_5_amount']) . '</b>) &nbsp; &nbsp; '; }
                if ($row['cash_1_amount'] != ''){ echo '1 ('; }
                if ($row['cash_1_amount'] != ''){ echo '<b>' . number_format($row['cash_1_amount']) . '</b>) &nbsp; &nbsp; '; }
              echo '<small class="blue-grey-text">TOTAL <br> </small>' . $currencyIcon . number_format($total_amount) ;
    }
  }
  $con->close();
}

// Get List Of CMOs
function getCMOs()
{
    // Add DB Connection
    require('db2.php');
    $sql = " SELECT * FROM users WHERE userlevel = '13' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['username'].'">'.$row['surname'].' '.$row['middlename'].' '.$row['firstname'].'</option>';
        }
    } else {
        echo '<option value="">No User Found</option>';
    }
    $con->close();
}

// Get List Of Processors
function getProcessors()
{
    // Add DB Connection
    require('db2.php');
    $sql = " SELECT * FROM users WHERE userlevel = '4' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['username'].'">'.$row['surname'].' '.$row['middlename'].' '.$row['firstname'].'</option>';
        }
    } else {
        echo '<option value="">No User Found</option>';
    }
    $con->close();
}

// Get List Of Days
function getDays()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM dayshifts";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['dstart_title'].'</option>';
    }
  } else {
    echo '<option value="">No User Found</option>';
  }
  $con->close();
}

// Get List Of Clients
function getClients()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM banks";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo '<option value="'.$row['id'].'">'.$row['bank_name'].'</option>';
      }
  } else {
      echo '<option value="">No Client Found</option>';
  }
  $con->close();
}
// Get List Of Status
function getStatus()
{
  $status = array("Awaiting Consignment Pickup", "Consignment Picked Up By CIT Confirmed", "Consignment Picked Up By CIT", "Consignment Received In Box Room", "Consignment Received In AC Vault", "Consignment Confirmed", "Consignment Processed");
  foreach ($status as $value) {
    echo '<option value=" ' . $value . ' "> ' . $value . ' </option>';
  }
}

// Get List Of Vehicles
function getVehicles()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM vehicles";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }
  } else {
      echo '<option value="">No User Found</option>';
  }
  $con->close();
}

// Get Supply Request Type
function getSupplyRequestType()
{
  echo '<option value="Branch Distribution">Branch Distribution</option>';
  echo '<option value="Swap / Sales">Swap / Sales</option>';
  echo '<option value="Deposits To CBN">Deposits To CBN</option>';
  echo '<option value="Wholesale">Wholesale</option>';
}

// Display Denominations Raw
function getDen()
{
  echo '
  <option value="1000">1,000</option>
  <option value="500">500</option>
  <option value="200">200</option>
  <option value="100">100</option>
  <option value="50">50</option>
  <option value="20">20</option>
  <option value="10">10</option>
  <option value="5">5</option>
  <option value="1">1</option>
  ';
}

// Get Pieces
function getPieces()
{
  echo '
  <option value="10000">10,000 Pieces</option>
  <option value="20000">20,000 Pieces</option>
  <option value="30000">30,000 Pieces</option>
  ';
}

// Get User Access Level
function getUserAccssLevel()
{
  echo '<option value="8">Treasury Supervisor</option>';
  echo '<option value="7">Treasury Officer</option>';
  echo '<option value="6">Cash Processing Admin</option>';
  echo '<option value="5">Cash Processing Supervisor</option>';
  echo '<option value="4">Cash Processing Officer</option>';
  echo '<option value="3">Vault Supervisor</option>';
  echo '<option value="2">Vault Officer</option>';
  echo '<option value="12">Box Room Supervisor</option>';
  echo '<option value="1">Box Room Officer</option>';
  echo '<option value="13">Cash Movement Officer</option>';
  echo '<option value="15">Client Representative Supervisor (CMU)</option>';
  echo '<option value="14">Client Representative</option>';
}
function getUserAccssLevelAll()
{
  echo '<option value="9">Head Of Units</option>';
  echo '<option value="10">Manager</option>';
  echo '<option value="10">Executive</option>';
  echo '<option value="8">Treasury Supervisor</option>';
  echo '<option value="7">Treasury Officer</option>';
  echo '<option value="6">Cash Processing Admin</option>';
  echo '<option value="5">Cash Processing Supervisor</option>';
  echo '<option value="4">Cash Processing Officer</option>';
  echo '<option value="3">Vault Supervisor</option>';
  echo '<option value="2">Vault Officer</option>';
  echo '<option value="12">Box Room Supervisor</option>';
  echo '<option value="1">Box Room Officer</option>';
  echo '<option value="13">Cash Movement Officer</option>';
  echo '<option value="15">Client Representative Supervisor (CMU)</option>';
  echo '<option value="14">Client Representative</option>';
}

// function getCITconfirmation
function getCITconfirmation($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number, container_type_id, deposit_type_id, category_id  FROM evacuationpreparations WHERE evacuation_id = '$reqId' ";                        
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $seal_number = $row['seal_number'];
      $container_type_id = $row['container_type_id'];
      $deposit_type_id = $row['deposit_type_id'];
      $category_id = $row['category_id'];
      //Split and get main seal number
      $sealPieces             = explode("-", $seal_number);
      $tymeStamp              = $sealPieces[0];
      $sealNumber             = $sealPieces[1];
      // Get Container Name
      $getContainerType       = getContainerType($container_type_id);
      $containerType          = $getContainerType['ct_name'];
      // Get Deposit Type Name
      $getDepositType         = getDepositTypeById($deposit_type_id);
      $depositType            = $getDepositType['dt_name'];
      // Get Cash Category Name
      $getCategoryType        = getCategoryTypeById($category_id);
      $cashCategory           = $getCategoryType['dc_name'];
      echo '
      <div class="col l6 m6 s12">
        <div class="card">
            <div class="card-header">
                <h5 class="black-text"><small>Seal Number: </small><span class="grey-text"> ' . $tymeStamp . '-</span><strong class="teal-text"> ' . $sealNumber . '</strong></h5>
                <h6 class="black-text"><small>Container Type:</small>  ' . $containerType . '</h6>
                <h6 class="black-text"><small>Deposit Type:</small>  ' . $depositType . '</h6>
                <h6 class="black-text"><small>Cash Category:</small>  ' . $cashCategory . '</h6>
            </div>
            <div class="card-content">
                <ul id="profile-page-about-details" class="collection">' . getBagCIT($seal_number) . '
                </ul>
            </div>
        </div>
    </div>
    ';
    }
  } else {
    echo '';
  }
}

// Get Seal number
function getCITBags($reqId)
{
  require('db.php');
  $q = " SELECT DISTINCT seal_number FROM cits WHERE evacuation_id = '$reqId' ";
  $result = $con->query($q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<b>' . $sealNumber . '</b> &nbsp; &nbsp; ';
    }
  }
}
function getCITBags2($reqId)
{
  require('db.php');
  $q = " SELECT DISTINCT seal_number FROM cits WHERE evacuation_id = '$reqId' ";
  $result = $con->query($q);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo $sealNumber . ' ';
    }
  }
}


// Get Seal Numbers
function getSealNumbers($reqId)
{
  require('db.php');
  $q = " SELECT * FROM evacuationpreparations WHERE evacuation_id = '$reqId' ";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
    return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Day Title
function getDayShift($reqId)
{
  require('db.php');
  $q = " SELECT * FROM dayshifts WHERE id = '$reqId' ";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
    return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Cash Tied To Same Bag
function getBagCIT($sealNumber)
{
  // Add DB Connection
  require('db.php');
  $currencyIcon = $currencyName = '';
  $q = " SELECT * FROM evacuationpreparations WHERE seal_number = '$sealNumber' ";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
    return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
          
// Get CMOs Approvals
function getRequestsConfirmations($cmoId)
{
    //$totalNaira = $totalEuro = $totalUsd = $totalGbp = $totalZar = $totalCfa = $totalCny = 0;
    // Add DB Connection
    require('db.php');
    $sno = 1;
    $acceptedBags = $totalsBags = $sealNumbers = '';
    $totalAmountPrepared = 0;
    $sql = "SELECT * FROM evacuations WHERE cit_reciever_id = '$cmoId' ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Request Title</th>
                    <th>Client</th>
                    <th>Branch Location</th>
                    <th>Consignment Destination</th>
                    <th>Seal Numbers</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Request Title</th>
                    <th>Client</th>
                    <th>Branch Location</th>
                    <th>Consignment Destination</th>
                    <th>Seal Numbers</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            $erId = $row['id'];
            $bUID = $row['id'].'------'.$row['er_slug'].'------el';
            $bankUID = base64_encode($bUID);
            //get client name
            $reqClientName      = getClientNameById($row['bank_id']);
            $clientName         = $reqClientName['bank_name'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
            $consignmentLocation    = $reqConsLoc['name'];

            $citConfirmationToken = $row['id'] . 'cittoken18' . time() . 'cittoken18' . $row['bank_id'];
            // Get Number Of Bags Accepted
            $acceptedBags = allBagsCofirmedCIT($erId);
            // Get Number Of Bags Expected
            $totalsBags = getCITBags3($erId);
            // Get Total Amount Prepared
            $totalAmountPrepared = getTotalAmountPreparedBagsPerRequest($row['id']);
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['er_name'] . '</td>
                <td>' . $clientName . '</td>
                <td>' . $row['location_code'] . '</td>
                <td>'. $consignmentLocation .'</td>
                <td>'; getCITBags2($erId); echo '</td>
                <td>';
                  // Compare Bags And Show Receive Button If Need Be
                  if ( $totalsBags > $acceptedBags ) {
                    echo '<button data-target="recCons" class="btns btns-add waves-effect waves-teal cho modal-trigger" data-id="' . $row['id'].'" data-name="' . $row['er_name'].'" data-ctokn="' . $citConfirmationToken.'" data-tap="'.$totalAmountPrepared.'" data-bbcid="'.$row['bank_id'].'" > Receive Consignment </button>';
                  } else {
                    echo 'All Bags Has Been Recieved By You';
                  }
                  echo '
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No request found';
    }
    $con->close();
}

// Get CMOs Approval Supply Request
function getRequestsConfirmationsSR($cmoId)
{
    //$totalNaira = $totalEuro = $totalUsd = $totalGbp = $totalZar = $totalCfa = $totalCny = 0;
    // Add DB Connection
    require('db.php');
    $snum = 1;
    $acceptedBags = $totalsBags = $sealNumbers = '';
    $totalAmountPrepared = 0;
    $sql = "SELECT * FROM supplybranches WHERE cit_officer = '$cmoId' AND is_delivered = 'NO' ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Client</th>
                    <th>Branch Name</th>
                    <th>Branch Location</th>
                    <th>Seal Numbers</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Client</th>
                    <th>Branch Name</th>
                    <th>Branch Location</th>
                    <th>Seal Numbers</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            $srbId = $row['id'];
            $bUID = $row['id'].'------'.$row['branch'].'------el';
            $bankUID = base64_encode($bUID);
            //get client name
            $reqCD      = getClientNameById($row['client']);
            $cltName         = $reqCD['bank_name'];

            $citConfirmationToken = $row['id'] . 'cittoken18' . time() . 'cittoken18' . $row['client'];
            // Get Number Of Bags Accepted
            $acceptedBags = allBagsCofirmedCITSR($srbId);
            //Split and get main seal number
            $sealPieces   = explode("-", $row['seal_number']);
            $sealNumber   = $sealPieces[1];
            // Get Branch Name
            $reqBN = getClientBranchNameById($row['branch']);
            $branchName = $reqBN['name'];
            $branchLocation = $reqBN['branch_location'];
            echo '<tr>
                <td>' . $snum++ . '</td>
                <td>' . $cltName . '</td>
                <td>'. $branchName .'</td>
                <td>'. $branchLocation .'</td>
                <td>' . $sealNumber . '</td>
                <td>';
                  // Compare Bags And Show Receive Button If Need Be
                  // if ( $totalsBags > $acceptedBags ) {
                    echo '<button data-target="delCons" class="btns btns-add waves-effect waves-teal delCons modal-trigger" data-id="' . $row['id'].'" data-ctoknn="' . $citConfirmationToken.'" data-client="'.$row['client'].'" data-tad="'.$row['amount'].'" > Deliver Consignment </button>';
                  // } else {
                  //   echo 'All Bags Has Been Recieved By You';
                  // }
                  echo '
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No request found';
    }
    $con->close();
}

// Display Branch List
function getBranchesList()
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches ORDER BY id DESC";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    echo '<ul id="bfUL">';
    while ($row = $result->fetch_assoc()) {
      $bUID = $row['id'].'------'.$row['slug'].'------el';
      $bankUID = base64_encode($bUID);
      echo '<li><a href="#">' . $row['name'] . '</a></li>';
    }
    echo '</ul>';
  } else {
    echo 'No client found';
  }
  $con->close();
}

// Display Branch List 
function getAllClientBranchLists()
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches ORDER BY id DESC";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Branch Found</option>';
  }
  $con->close();
}

// Display Branch List Per Client
function getClientBranchesList($clientId)
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches WHERE banks_id = '$clientId' ORDER BY id DESC";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Branch Found</option>';
  }
  $con->close();
}

// Display Users List
function getUserssList()
{
  require('db2.php');
  $sql = "SELECT * FROM users ORDER BY username DESC";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    echo '<ul id="ufUL">';
    while ($row = $result->fetch_assoc()) {
      $userId = $row['username'].'------'.$row['email'].'------el';
      $userUID = base64_encode($userId);
      echo '<li><a href="profile?r=' . $row['username'].'cprf'.$userUID .'">' . $row['surname'] .' '. $row['middlename'] .' '. $row['firstname'] . '</a></li>';
    }
    echo '</ul>';
  } else {
    echo 'No client found';
  }
  $con->close();
}

// Check If User Is Client Rep
function isClientRep($getId)
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches WHERE branch_rep = '$getId' ";
  $result = $con->query($sql);
  
  if ($result->num_rows < 2) {
    while ($row = $result->fetch_assoc()) {
      echo 'YES';
    }
  } else {
    echo 'NO';
  }
  $con->close();
}
// Get Branch Representing
function clientRepn($getId)
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches WHERE branch_rep = '$getId' ";
  $result = $con->query($sql);
  
  if ($result->num_rows < 2) {
    while ($row = $result->fetch_assoc()) {
      echo $row['name'];
    }
  } else {
    echo '';
  }
  $con->close();
}
// Get Client Representing
function clientId($getId)
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches WHERE branch_rep = '$getId' ";
  $result = $con->query($sql);
  
  if ($result->num_rows < 2) {
    while ($row = $result->fetch_assoc()) {
      return $row['banks_id'];
    }
  }
  $con->close();
}
// Get Client Name By Id
function clientName($getId)
{
  require('db.php');
  $sql = "SELECT * FROM banks WHERE id = '$getId' ";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo $row['bank_name'];
    }
  } else {
    echo 'None';
  }
  $con->close();
}
function getClientNameById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM banks WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Bundle Confirmation Start
function getBundleConfirmationStart($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM bundleconfirmations WHERE client_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getConsignmentLocationById
function getConsignmentLocationById($reqId)
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
// Get Signed In Location ID By Name
function getConsignmentLocationByName($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM consignmentlocations WHERE name = '$reqId' LIMIT 1";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get List Of Client Branches
function getClientBranhcesLists($cid)
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM bank_branches WHERE banks_id = '$cid' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// getDepositTypeById
function getDepositTypeById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM deposittypes WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get List Of Category Types
function getCategoryTypeLists()
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM depositcategories ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Category Type </option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// getCategoryTypeById
function getCategoryTypeById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM depositcategories WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getContainerType
function getContainerType($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM containertypes WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getCurrencyById
function getCurrencyById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM currencies WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get List Of Container Types
function getContainerTypeLists()
{
    // Add DB Connection
    require('db.php');
    $sql = " SELECT * FROM containertypes ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Container Type</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    $con->close();
}

// getDenominationById
function getDenominationById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM denominations WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getClientBranchNameById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM bank_branches WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Vehicle Info
function getCitVehicleById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM vehicles WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getEvacRequestById
function getEvacRequestById($reqid)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM evacuations WHERE id = '$reqid'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Supply Request
function getSupplyRequestData($reqid)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM supplies WHERE id = '$reqid'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getEvacRequestByCIT
function getEvacRequestByCIT($reqid)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM evacuations WHERE cit_reciever_id = '$reqid'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// getBundleConfirmationById
function getBundleConfirmationById($reqid)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM bundleconfirmations WHERE id = '$reqid'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Total Amount Per Seal Number
function getTotalAmountReq($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM evacuationpreparations WHERE evacuation_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Total Amount Per Evacuation Request
function getTotalAmountNaira($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_naira WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getTotalAmountEuro($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_euro WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getTotalAmountUsd($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_usd WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getTotalAmountGbp($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_gbp WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getTotalAmountCfa($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_cfa WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getTotalAmountCny($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_cny WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

function getTotalAmountZar($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM cash_preparation_zar WHERE ev_req_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Client ID
function getClientId($username)
{
  require('db.php');
  $sql = "SELECT * FROM bank_branches WHERE branch_rep = '$username' OR branch_cmu = '$username' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['banks_id'];
    }
  }
  $con->close();
}

//Fetch Users Count
function getNumberClientReps()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM bankreps";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get User Fullname
function getUserFullname($reqUser)
{
  // Add DB Connection
  require('db2.php');
  $q = "SELECT * FROM users WHERE username = '$reqUser'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

// Get Sealed Bag Content
function getSealedBagData($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM sealings WHERE seal_number = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

//get User Level
function getUserLevel($getId) {
  require('db2.php');
  $sql = "SELECT * FROM users WHERE username = '$getId'";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $gUserLevel = $row['userlevel'];
      // Determin User Level
      if ($gUserLevel == 1) {
        echo BR_OFFICER;
      } elseif ($gUserLevel == 2) {
        echo V_OFFICER;
      } elseif ($gUserLevel == 3) {
        echo V_SUPERVISOR;
      } elseif ($gUserLevel == 4) {
        echo CP_OFFICER;
      } elseif ($gUserLevel == 5) {
        echo CP_SUPERVISOR;
      } elseif ($gUserLevel == 6) {
        echo CP_ADMIN;
      } elseif ($gUserLevel == 7) {
        echo TREASURY_OFFICER;
      } elseif ($gUserLevel == 8) {
        echo TREASURY_SUPERVISOR;
      } elseif ($gUserLevel == 9) {
        echo HOU;
      } elseif ($gUserLevel == 10) {
        echo MANAGERS;
      } elseif ($gUserLevel == 11) {
        echo EXECUTIVE;
      } elseif ($gUserLevel == 12) {
        echo BR_SUPERVISOR;
      } elseif ($gUserLevel == 13) {
        echo CMO;
      } elseif ($gUserLevel == 14) {
        echo BANKER;
      } elseif ($gUserLevel == 15) {
        echo BANKER_CMU;
      } elseif ($gUserLevel == 19) {
        echo ADMIN;
      } elseif ($gUserLevel == 20) {
        echo S_ADMIN;
      }
    }
  } else {
    echo 'Ghost Worker';
  }
  $con->close();
}

// Get Number Banks
function getNumberOfBanks()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM banks";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get NUmber Of Bank Locations
function getNumberOfBankLocations()
{
  // Add DB Connection
  require('db.php');

  $sql = "SELECT * FROM bank_branches";
  $result = $con->query($sql);
  echo $result->num_rows;
  $con->close();
}

// Get Number Of Bank Branches
function getTotalClientBranches($reqId)
{
  require('db.php');
  $sql = "SELECT DISTINCT name FROM bank_branches WHERE banks_id = '$reqId'";
  $result = $con->query($sql);
  return $result->num_rows;
  $con->close();
}

// Get Dropdown List Of Users
function getUsersList()
{
  // Add DB Connection
  require('db2.php');
  $sql = " SELECT * FROM users ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['username'].'">'.$row['surname'].' '.$row['middlename'].' '.$row['firstname'].'</option>';
    }
  } else {
    echo '<option value="">No User Found</option>';
  }
  $con->close();
}

//Get client user level list
function getUsersListClient()
{
  // Add DB Connection
  require('db2.php');
  $sql = " SELECT * FROM users WHERE userlevel = '14' OR userlevel = '15' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['username'].'">'.$row['surname'].' '.$row['middlename'].' '.$row['firstname'].'</option>';
    }
  } else {
    echo '<option value="">No User Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Banks
function getBanksList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM banks ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['bank_name'].'</option>';
    }
  } else {
    echo '<option value="">No Bank Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Cash Categories
function getCashCategoriesList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM depositcategories ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Cash Category Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Deposit Types
function getDepositTypesList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM deposittypes ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Deposit Type Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Currency Types
function getCurrencyTypesList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM currencies ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Currency Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Denomination Types
function getDenominationTypesList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM denominations ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Denomination Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Consignment Location
function getConsignmentLocationsList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM consignmentlocations WHERE bankview = 'NO' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Consignment Location Found</option>';
  }
  $con->close();
}

// GetDropdown List Of Consignment Locations Excluding Workstations
function getConsignmentLocationsListMinusWorkStations()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM consignmentlocations WHERE bankview = 'NO' AND workstation = 'NO' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Consignment Location Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Seal Numbers
function getListOfSealNUmbers()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM cits WHERE picked_up_on != ''";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No Seal Number Found Found</option>';
  }
  $con->close();
}

// Get Seal Numbers For Internal Movement
function getListOfSealNUmbersIM()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM sealings WHERE is_opened = 'NO' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No Seal Number Found Found</option>';
  }
  $con->close();
}

// Get List Of Seal Numbers In Current Location
function getListOfSealNUmbersCL($reqid, $userId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM sealings WHERE location_id = '$reqid' AND added_by = '$userId' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No new consignment at your location</option>';
  }
  $con->close();
}

// Get Bags That Can Be Cash Allocated
function getListOfCashAllocatableBagsInSupCustody($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '$reqId' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No Bag Found In Your Location</option>';
  }
  $con->close();
}

// Get Dropdown List Of Seal Numbers
function getListOfResealedNUmbers()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM sealings";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No Seal Number Found Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Seal Numbers For CIT
function getListOfSealNUmbersCit()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM cits WHERE picked_up_on != '' AND delivery_status != 'Sent To Boxroom, Awaiting Confirmation'";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">You Have Handed Over All Bags In Your Custody</option>';
  }
  $con->close();
}

// Get Container Content
function getContainerContent($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = " SELECT * FROM sealings WHERE seal_number = '$reqId'";
  $result = mysqli_query($con, $q) or die(mysqli_error($con));
    /* Error occurred, return search id by default */
  if (!$result || (mysqli_num_rows($result) == 1)) {
    return null;
  }
  /* Return result array */
  $dbarray = mysqli_num_rows($result);
  return $dbarray;
}

// Check If Seal Number Is Listed As Exception And Yet To Be Resolved By User and Supo
function hasExceptionUser($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = "SELECT * FROM thrownexceptions WHERE thrown_by = '$reqId' AND ex_status = 'Unresolved' ";
  $result = $con->query($sql);
  return ($result->num_rows > 0);
}

// Get Dropdown List Of Seal Numbers Not Bundle Confirmed
function getListOfSealNUmbersNotBundleConfirmed($reqId)
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '$reqId' AND bc = 'NO' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No Bag Found In Your Location</option>';
  }
  $con->close();
}

// Get Newly Sealed Bags
function getNewlySealedBags($reqId){
  // Add DB Connection
  require('db.php');
  $sql = " SELECT DISTINCT seal_number FROM sealings WHERE location_id = '$reqId' AND is_opened = 'NO' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //Split and get main seal number
      $sealPieces   = explode("-", $row['seal_number']);
      $tymeStamp    = $sealPieces[0];
      $sealNumber   = $sealPieces[1];
      echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
    }
  } else {
    echo '<option value="">No Bag Found In Your Location</option>';
  }
  $con->close();
}
// function getListOfSealNUmbersNotBundleConfirmed()
// {
//   // Add DB Connection
//   require('db.php');
//   $sql = " SELECT * FROM cit WHERE received_on != '' AND bundle_confirmed = 'NO' ";
//   $result = $con->query($sql);
//   if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//       //Split and get main seal number
//       $sealPieces   = explode("-", $row['seal_number']);
//       $tymeStamp    = $sealPieces[0];
//       $sealNumber   = $sealPieces[1];
//       echo '<option value="'.$row['seal_number'].'">'.$sealNumber.'</option>';
//     }
//   } else {
//     echo '<option value="">No Seal Number Found</option>';
//   }
//   $con->close();
// }

// Get Dropdown List Of Work Stations
function getWorkStationLists()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM consignmentlocations WHERE workstation = 'YES' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
    }
  } else {
    echo '<option value="">No Work Station Found</option>';
  }
  $con->close();
}

// Get Dropdown List Of Work Stations
function getWorkStationList()
{
  // Add DB Connection
  require('db.php');
  $sql = " SELECT * FROM consignmentlocations WHERE workstation = 'YES' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
    }
  } else {
    echo '<option value="">No Work Station Found</option>';
  }
  $con->close();
}
// get work station per id
function getWorkstationById($reqId)
{
  // Add DB Connection
  require('db.php');
  $q = "SELECT * FROM consignmentlocations WHERE workstation = 'YES' AND location_id = '$reqId'";
  $result = mysqli_query($con, $q) or die(mysqli_error($con));
    /* Error occurred, return search id by default */
  if (!$result || (mysqli_num_rows($result) == 1)) {
    return null;
  }
  /* Return result array */
  $dbarray = mysqli_num_rows($result);
  return $dbarray;
}

//Fetch Users Count
function user_dp($username)
{
  // Add DB Connection
  require('db2.php');
  $q = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($con, $q) or die(mysqli_error($con));
    /* Error occurred, return search id by default */
  if (!$result || (mysqli_num_rows($result) == 1)) {
    return null;
  }
  /* Return result array */
  $dbarray = mysqli_num_rows($result);
  return $dbarray;
}

//Convert timestamp to date only
function getDateOnly($thistime)
{
  return date('D F j, Y', $thistime);
}

//Convert timestamp to day month year
function timestamp($thistime)
{
  echo date('D F j, Y, g:i a', $thistime);
}

//Word Limiter
function limit_text($text, $limit)
{
  if (str_word_count($text, 0) > $limit) {
    $words = str_word_count($text, 2);
    $pos = array_keys($words);
    $text = substr($text, 0, $pos[$limit]) . '...';
  }
  return $text;
}

// Return the number of days between the two dates
function dateDiff($start, $end)
{
  $start_ts = strtotime($start);
  $end_ts = strtotime($end);
  $diff = $end_ts - $start_ts;
  return round($diff / 86400);
}

//Function Time Ago
function time_elapsed_string($datetime, $full = false)
{
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hour',
    'i' => 'minute',
    's' => 'second',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) {
    $string = array_slice($string, 0, 1);
  }
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getUser($unam)
{
  // Add DB Connection
  require('db2.php');
  $sql = "SELECT * FROM users WHERE username = '$unam'";
  $result = $con->query($sql);

  if ($result->num_rows > 0) {
    echo "<table><tr><th>username</th><th>Name</th></tr>";
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>" . $row["username"] . "</td><td>" . $row["surname"] . " " . $row["firstname"] . " " . $row["middlename"] . "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
  $con->close();
}


// get work station per id
function getUserById($reqId)
{
  // Add DB Connection
  require('db2.php');
  $q = "SELECT * FROM users WHERE username = '$reqId'";
  $result = mysqli_query($con, $q) or die(mysqli_error($con));
    /* Error occurred, return search id by default */
  if (!$result || (mysqli_num_rows($result) == 1)) {
    return null;
  }
  /* Return result array */
  $dbarray = mysqli_num_rows($result);
  return $dbarray;
}