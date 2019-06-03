<?php

$tblName = 'vault';
$slug = 'seal_number';

$error = false;

// Load Bag
if(isset($_POST["loadBag"])){

    require_once('../core/general-functions.php');

    $qSealNumber	            = filter_var($_POST['qSealNumber'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        loadBag($qSealNumber);
    }
}

// Load Bag Function
function loadBag($qSealNumber)
{
    require('../core/db.php');

    $accentNumber = 1;
    $sql = " SELECT * FROM sealings WHERE seal_number = '$qSealNumber' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<p class="center blue-grey-text">Bag Content</p>';
        while ($row = $result->fetch_assoc()) {
            $currency_id            = $row['currency_id'];
            $total_amount           = $row['amount'];     
            // Get Currency Data
            $curRow                 = getCurById($currency_id);
            $currency_slug          = $curRow['currency_slug'];  
            if ($currency_slug == 'naira') {
                $currencyName = 'Nigerian Naira';
                $currencyIcon = '&#8358;';
            } else if ($currency_slug == 'euro') {
                $currencyName = 'European Euro';
                $currencyIcon = '&euro;';
            } else if ($currency_slug == 'gbp') {
                $currencyName = 'British Pounds';
                $currencyIcon = '&#163;';
            } else if ($currency_slug == 'usd') {
                $currencyName = 'US Dollars';
                $currencyIcon = '&#36;';
            } else if ($currency_slug == 'cny') {
                $currencyName = 'Chinese Yen';
                $currencyIcon = '&#165;';
            } else if ($currency_slug == 'cfa') {
                $currencyName = 'Centra African Republic Franc';
                $currencyIcon = 'CFA';
            } else if ($currency_slug == 'zar') {
                $currencyName = 'South African Rand';
                $currencyIcon = 'R';
            }
            // Get Denomination
            $denRow         = getDenById($row['denomination_id']);
            $denomination   = $denRow['denomination_name'];

            echo '<div class="card">
                <div class="card-content">
            ';
                echo '
                    <div class="row center">
                        <div class="col l4 m4 s12">
                            <div id="sales-compositebar" class="center-align">
                                <h1><span style="font-size: 24px; font-weight: 300;">DENOMINATION: </span><br>'. number_format($denomination).'</h1>
                            </div>
                        </div>
                        <div class="col l8 m8 s12">
                            <div id="sales-compositebar" class="center-align">
                                <h1><span style="font-size: 24px; font-weight: 300;">TOTAL AMOUNT: <br></span><span style="font-weight: 100;">'.$currencyIcon .'</span>'. number_format($total_amount).'</h1>
                            </div>
                        </div>
                        <input type="hidden" id="denomination" value="'.$denomination.'">
                        <input type="hidden" id="currency" value="'.$currency_slug.'">
                        <input type="hidden" id="amount" value="'.$total_amount.'">
                    </div>
                </div>
            </div>';
        }
    } else {
        echo 'This Bag Does Not Exist';
    }
}

// getDenominationById
function getDenById($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM denominations WHERE denomination_id = '$reqId'";
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
function getCurById($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM currencies WHERE currency_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}

if(isset($_POST["saveIntoStorage"])){

    require_once('../core/general-functions.php');

    $addedOn        = time();
    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $qSealNumber    = filter_var($_POST['qSealNumber'], FILTER_SANITIZE_STRING);
    $clientIdd      = filter_var($_POST['clientIdd'], FILTER_SANITIZE_STRING);
    $denomination   = filter_var($_POST['denomination'], FILTER_SANITIZE_STRING);
    $currency       = filter_var($_POST['currency'], FILTER_SANITIZE_STRING);
    $amount         = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);

    // Basic Validation
    if (empty($denomination)) {
        $error = true;
        echo'Invalid Request';
    }
    if (empty($currency)) {
        $error = true;
        echo'Invalid Request';
    }
    if (empty($amount)) {
        $error = true;
        echo'Invalid Request';
    }
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }

    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($qSealNumber)) {
        $error = true;
        echo'Seal Number Is Required';
    } else if (strlen($qSealNumber) < 6) {
        $error = true;
        echo'Invalid Seal Number';
    }
    if (empty($clientIdd)){
        $error = true;
        echo 'Invalid Client ID';
    }
    if (alreadyTaken($tblName, $slug, $qSealNumber)) {
        $error = true;
        echo 'This Bag Already Exists';
    }

    if( !$error ) {
        saveIntoStorage($qSealNumber, $clientIdd, $addedOn, $username, $denomination, $currency, $amount);
    }
}

// Add Bank function
function saveIntoStorage($qSealNumber, $clientIdd, $addedOn, $username, $denomination, $currency, $amount)
{
    require('../core/db.php');
    $sql = "INSERT INTO vault (client_id, seal_number, added_by, added_on, currency, denomination, amount)
            VALUES ('$clientIdd', '$qSealNumber', '$username', '$addedOn', '$currency', '$denomination', '$amount')";
    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}

// Confirm Stock Count
if(isset($_POST["confirmVaultCount"])){

    require_once('../core/general-functions.php');

    $addedOn        = time();
    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $vId		    = filter_var($_POST['vId'], FILTER_SANITIZE_STRING);

    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }

    if( !$error ) {
        confirmStockCount($addedOn, $username, $vId);
    }
}

// Update Bank
function confirmStockCount($addedOn, $username, $vId)
{
    require('../core/db.php');

    $sql = "UPDATE vault SET 
            counted = 'YES', 
            counted_by = '$username', 
            counted_on = '$addedOn'
            WHERE id = $vId ";

    if ($con->query($sql) === true) {
        echo "done";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}


// Load Stock
if(isset($_POST["loadStock"])){

    require_once('../core/general-functions.php');

    $clientUid      = filter_var($_POST['clientUid'], FILTER_SANITIZE_STRING);
    $currency       = filter_var($_POST['currencyUid'], FILTER_SANITIZE_STRING);
    $denomination   = filter_var($_POST['denominationUid'], FILTER_SANITIZE_STRING);
    $category       = filter_var($_POST['categoryUid'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        loadStock($clientUid, $currency, $denomination, $category);
    }
}

// Load Stock Function
function loadStock($clientUid, $currency, $denomination, $category)
{
    require('../core/db.php');
    $sum1000 = $sum500 = $sum200 = $sum100 = $sum50 = $sum20 = $sum10 = $sum5 = $sum1 = $sumAmount = 0;
    $sql = " SELECT * FROM sealings WHERE client = '$clientUid' AND currency_id = '$currency' AND denomination_id = '$denomination' AND location_id = '4' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Get Currencies
            if ($currency == '1') {
                $currencyName = 'Nigerian Naira';
                $currencyIcon = '&#8358;';
            } else if ($currency == '2') {
                $currencyName = 'European Euro';
                $currencyIcon = '&euro;';
            } else if ($currency == '3') {
                $currencyName = 'US Dollars';
                $currencyIcon = '&#36;';
            } else if ($currency == '4') {
                $currencyName = 'British Pounds';
                $currencyIcon = '&#163;';
            } else if ($currency == '5') {
                $currencyName = 'South African Rand';
                $currencyIcon = 'R';
            } else if ($currency == '6') {
                $currencyName = 'Centra African Republic Franc';
                $currencyIcon = 'CFA';
            } else if ($currency == '7') {
                $currencyName = 'Chinese Yen';
                $currencyIcon = '&#165;';
            }
            $sumAmount += $row['amount'];
        }
        echo '
            <div class="row center">
                <div class="col s12">
                    <h3 class="card-stats-number">';
                        echo '<span style="font-weight: 100;">Amount: '.$currencyIcon.'</span>' . number_format($sumAmount) ;
                    echo '</h3>
                </div>
            </div>
        ';
    } else {
        echo 'No record found. ';
    }
}