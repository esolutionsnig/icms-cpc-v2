<?php

// $error = false;

// // Start Bundle Confirmation
// if(isset($_POST["startBundleConfirmation"])){

//     require_once('../core/general-functions.php');

//     $addedOn                    = time();
//     $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
//     $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
//     $clientName		            = filter_var($_POST['clientName'], FILTER_SANITIZE_STRING);
//     $conslocation		        = filter_var($_POST['conslocation'], FILTER_SANITIZE_STRING);
    
//     // Basic Username Name Validation
//     if (empty($usertoken)) {
//         $error = true;
//         echo'Unauthorized Request';
//     } else if (strlen($usertoken) < 8) {
//         $error = true;
//         echo'Unauthorized Request';
//     }

//     if (empty($username)) {
//         $error = true;
//         echo'Unauthorized User Request';
//     } else if (strlen($username) < 4) {
//         $error = true;
//         echo'Unauthorized User Request';
//     }

//     if( !$error ) {
//         startBUndleConfirmation($addedOn, $username, $clientName, $conslocation);
//     }
// }

// // Start New Bundle Confirmation function
// function startBUndleConfirmation($addedOn, $username, $clientName, $conslocation)
// {
//     require('../core/db.php');

//     $sql = "INSERT INTO bundle_confirmation_start (client_id, conslocation, audit_trail_number, added_by)
//             VALUES ('$clientName', '$conslocation', '$addedOn', '$username')";

//     if ($con->query($sql) === true) {
//         echo "bcstarted";
//     } else {
//         echo "Error: " . $sql . "<br>" . $con->error;
//     }
// }

// // Load Bag
// if(isset($_POST["loadBag"])){

//     require_once('../core/general-functions.php');

//     $qSealNumber	            = filter_var($_POST['qSealNumber'], FILTER_SANITIZE_STRING);

//     if( !$error ) {
//         loadBag($qSealNumber);
//     }
// }

// // Load Bag Function
// function loadBag($qSealNumber)
// {
//     require('../core/db.php');

//     $accentNumber = 1;
//     $sql = " SELECT * FROM cash_preparations WHERE seal_number = '$qSealNumber' ";
//     $result = $con->query($sql);
//     if ($result->num_rows > 0) {
//         echo '<h5 class="header center blue-grey-text">Bag Content</h5>';
//         while ($row = $result->fetch_assoc()) {
//             $currency_id            = $row['currency_id'];
//             $total_amount           = $row['total_amount'];     
//             // Get Currencies
//             if ($currency_id == 'naira') {
//                 $currencyName = 'Nigerian Naira';
//                 $currencyIcon = '&#8358;';
//             } else if ($currency_id == 'euro') {
//                 $currencyName = 'European Euro';
//                 $currencyIcon = '&euro;';
//             } else if ($currency_id == 'gbp') {
//                 $currencyName = 'British Pounds';
//                 $currencyIcon = '&#163;';
//             } else if ($currency_id == 'usd') {
//                 $currencyName = 'US Dollars';
//                 $currencyIcon = '&#36;';
//             } else if ($currency_id == 'cny') {
//                 $currencyName = 'Chinese Yen';
//                 $currencyIcon = '&#165;';
//             } else if ($currency_id == 'cfa') {
//                 $currencyName = 'Centra African Republic Franc';
//                 $currencyIcon = 'CFA';
//             } else if ($currency_id == 'zar') {
//                 $currencyName = 'South African Rand';
//                 $currencyIcon = 'R';
//             }

//             echo '<div class="card">
//                 <div class="card-content">
//                     <div class="row">
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"> <i class="material-icons left">label</i>Denomination: 1,000 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_1000_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_1000_amount']) ; }
//                             echo '</h4>
//                         </div>
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 500 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_500_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_500_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 200 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_200_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_200_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 100 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_100_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_100_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                     </div>
//                     <div class="row">
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 50 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_50_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_50_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 20 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_20_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_20_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 10 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_10_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_10_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 5 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_5_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_5_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                     </div>
//                     <div class="row">
//                         <div class="col l3 m3 s6">
//                             <p class="card-stats-title"><i class="material-icons left">label</i>Denomination: 1 </p>
//                             <h4 class="card-stats-number">';
//                             if ($row['cash_1_amount'] != ''){ echo '<small>'.$currencyIcon.'</small>' . number_format($row['cash_1_amount']) ; } else { echo '0'; }
//                             echo '</h4>
//                         </div>
//                     </div>
//                 </div>
//                 <div class="card-action red-text">
//                     <div id="sales-compositebar" class="center-align">
//                         <h1><span style="font-size: 24px; font-weight: 300;">TOTAL: </span><span style="font-weight: 100;">'.$currencyIcon .'</span>'. number_format($total_amount).'</h1>
//                     </div>
//                 </div>
//             </div>';
//         }
//     } else {
//         echo 'This Bag Does Not Exist';
//     }
// }

// // Add New Bag
// if(isset($_POST["confirmThisBag"])){

//     require_once('../core/general-functions.php');

//     $addedOn                    = time();
//     $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
//     $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
//     $newSealNumber	            = filter_var($_POST['newSealNumber'], FILTER_SANITIZE_STRING);
//     $confirmSealNumber	        = filter_var($_POST['confirmSealNumber'], FILTER_SANITIZE_STRING);
//     $bundleConfirmationComment	= filter_var($_POST['bundleConfirmationComment'], FILTER_SANITIZE_STRING);

//     // Basic Username Name Validation 
//     if (empty($usertoken)) {
//         $error = true;
//         echo'Unauthorized Request';
//     } else if (strlen($usertoken) < 8) {
//         $error = true;
//         echo'Unauthorized Request';
//     }

//     if (empty($username)) {
//         $error = true;
//         echo'Unauthorized User Request';
//     } else if (strlen($username) < 4) {
//         $error = true;
//         echo'Unauthorized User Request';
//     }

//     if( !$error ) {
//         confirmThisBag($username, $newSealNumber, $confirmSealNumber, $bundleConfirmationComment, $addedOn);
//     }
// }

// // Add New Bag Function
// function confirmThisBag($username, $newSealNumber, $confirmSealNumber, $bundleConfirmationComment, $addedOn)
// {
//     require('../core/db.php');

//     $sql = "UPDATE cit SET 
//             seal_number = '$newSealNumber', 
//             bundle_confirmed = 'YES', 
//             bundle_confirmed_by = '$username', 
//             bundle_confirmed_comment = '$bundleConfirmationComment', 
//             old_seal_number = '$confirmSealNumber',
//             bundle_confirmed_on = '$addedOn'
//             WHERE seal_number = '$confirmSealNumber' ";
//     if ($con->query($sql) === true) {
//         echo "confirmed";
//     } else {
//         echo "Error: " . $sql . "<br>" . $con->error;
//     }
// }

// // Add New Bag
// if(isset($_POST["endThisBundleConfirmation"])){

//     require_once('../core/general-functions.php');

//     $addedOn                    = time();
//     $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
//     $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
//     $bcsidId	                = filter_var($_POST['bcsidId'], FILTER_SANITIZE_STRING);

//     // Basic Username Name Validation
//     if (empty($usertoken)) {
//         $error = true;
//         echo'Unauthorized Request';
//     } else if (strlen($usertoken) < 8) {
//         $error = true;
//         echo'Unauthorized Request';
//     }

//     if (empty($username)) {
//         $error = true;
//         echo'Unauthorized User Request';
//     } else if (strlen($username) < 4) {
//         $error = true;
//         echo'Unauthorized User Request';
//     }

//     if( !$error ) {
//         endThisBundleConfirmation($username, $bcsidId, $addedOn);
//     }
// }

// // Add New Bag Function
// function endThisBundleConfirmation($username, $bcsidId, $addedOn)
// {
//     require('../core/db.php');

//     $sql = "UPDATE bundle_confirmation_start SET 
//             confirmation_done = 'YES', 
//             ended_on = '$addedOn'
//             WHERE bcs_id = '$bcsidId' ";
//     if ($con->query($sql) === true) {
//         echo "done";
//     } else {
//         echo "Error: " . $sql . "<br>" . $con->error;
//     }
// }

// // Get all Banks
// function getBundleConfirmationPerUser($username)
// {
//   // Add DB Connection
//     require('./app/core/db.php');
//     $sno = 1;
//     $status = '';
//     $sql = "SELECT * FROM bundle_confirmation_start WHERE added_by = '$username' ORDER BY bcs_id DESC";
//     $result = $con->query($sql);

//     if ($result->num_rows > 0) {
//         $totalBags = 0;
//         echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
//         echo '<thead>
//                 <tr>
//                     <th>S/No</th>
//                     <th>Client Name</th>
//                     <th>Consignment Location</th>
//                     <th>Confirmation Status</th>
//                     <th class="width-20">ACTIONS</th>
//                 </tr>
//             </thead>
//             <tfoot>
//                 <tr>
//                     <th>S/No</th>
//                     <th>Client Name</th>
//                     <th>Consignment Location</th>
//                     <th>Confirmation Status</th>
//                     <th>ACTIONS</th>
//                 </tr>
//             </tfoot>
//             <tbody>';
//         // output data of each row
//         while ($row = $result->fetch_assoc()) {
//             $clientId = $row['client_id'];
//             //get client name
//             $reqClientName      = getClientNameById($clientId);
//             $clientName         = $reqClientName['bank_name'];
//             // Get Data From Bundle Confirmation Start
//             $reqStartdata           = getBundleConfirmationStart($clientId);
//             $conssignmentLocation   = $reqStartdata['conslocation'];
//             $confirmationDone       = $reqStartdata['confirmation_done'];
//             //get consignement 
//             $reqConsLoc             = getConsignmentLocationById($conssignmentLocation);
//             $consignmentLocation    = $reqConsLoc['location_name'];
//             $consignmentLocationId  = $reqConsLoc['location_id'];

//             $bUID = $row['bcs_id'].'------'.$clientName.'------'.$clientId.'------'.$consignmentLocationId;
//             $bankUID = base64_encode($bUID);

//             $cbUID = $row['bcs_id'].'------'.$row['added_by'].'------'.$clientId;
//             $cbbUID = base64_encode($cbUID);

//             $countedBy = $row['added_by'];
//             //Get Work Status
//             if ($confirmationDone == 'YES') {
//                 $status = '<div class="fully-done"><i class="material-icons left small" style="padding-top: 4px">done_all</i> Completed</div>';
//             } else {
//                 $status = '<div class="half-done"><i class="material-icons left small" style="padding-top: 4px">launch</i> On-Going</div>';
//             }

//             echo '<tr>
//                 <td>' . $sno++ . '</td>
//                 <td>' . $clientName . '</td>
//                 <td>' . $consignmentLocation . '</td>
//                 <td>' . $status . '</td>
//                 <td>';
//                     if ($confirmationDone == 'YES') {
//                         //echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">View Confirmed Bags <i class="material-icons left">link</i></a>';
//                         echo 'Bundle Confirmation Closed';
//                     } else {
//                         //echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">View Confirmed Bags <i class="material-icons left">link</i></a>';
//                         echo '<a href="bundle-confirmation-bag?r=' . $row['client_id'].'cprf'.$bankUID .'" class="btns btns-add waves-effect waves-light" style="color: white !important; margin: 6px !important; background: #6acef3 !important;">
//                         Add Bag <i class="material-icons left">add</i>
//                         </a>';
//                         echo '<button data-target="closeConfirmation" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-bcsid="' . $row['bcs_id'] . '">
//                         End Bundle Confirmation <i class="material-icons left">done_all</i>
//                         </button>';
//                     }
//                 echo '</td>
//             </tr>';
//         }
//         echo '</tbody>
//         </table>';
//     } else {
//         echo 'No record found.';
//     }
//     $con->close();
// }

// // Get all Banks
// function getBundleConfirmations()
// {
//   // Add DB Connection
//     require('./app/core/db.php');
//     $sno = 1;
//     $status = '';
//     $sql = "SELECT * FROM bundle_confirmations ORDER BY bc_id DESC";
//     $result = $con->query($sql);

//     if ($result->num_rows > 0) {
//         $totalBags = 0;
//         echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
//         echo '<thead>
//                 <tr>
//                     <th>S/No</th>
//                     <th>Client Name</th>
//                     <th>Consignment Location</th>
//                     <th>Started On</th>
//                     <th>Confirmation Status</th>
//                     <th>Bags Added</th>
//                     <th>ACTIONS</th>
//                 </tr>
//             </thead>
//             <tfoot>
//                 <tr>
//                     <th>S/No</th>
//                     <th>Client Name</th>
//                     <th>Consignment Location</th>
//                     <th>Started On</th>
//                     <th>Confirmation Status</th>
//                     <th>Bags Added</th>
//                     <th>ACTIONS</th>
//                 </tr>
//             </tfoot>
//             <tbody>';
//         // output data of each row
//         while ($row = $result->fetch_assoc()) {
//             $clientId = $row['client_id'];
//             //get client name
//             $reqClientName      = getClientNameById($clientId);
//             $clientName         = $reqClientName['bank_name'];

//             $bUID = $row['bcs_id'].'------'.$clientName.'------'.$clientId;
//             $bankUID = base64_encode($bUID);

//             $cbUID = $row['bcs_id'].'------'.$row['added_by'].'------'.$clientId;
//             $cbbUID = base64_encode($cbUID);

//             $countedBy = $row['added_by'];

//             // Get Data From Bundle Confirmation Start
//             $reqStartdata           = getBundleConfirmationStart($clientId);
//             $conssignmentLocation   = $reqStartdata['conslocation'];
//             $confirmationDone       = $reqStartdata['confirmation_done'];
//             //get consignement 
//             $reqConsLoc             = getConsignmentLocationById($conssignmentLocation);
//             $consignmentLocation    = $reqConsLoc['location_name'];
//             //Get Work Status
//             if ($confirmationDone == 'YES') {
//                 $status = '<span class="badge teal white-text"><i class="material-icons left small" style="padding-top: 4px">done_all</i> Completed</span>';
//             } else {
//                 $status = '<span class="badge orange lighten-1 black-text"><i class="material-icons left small" style="padding-top: 4px">launch</i> On-Going</span>';
//             }

//             echo '<tr>
//                 <td>' . $sno++ . '</td>
//                 <td>' . $clientName . '</td>
//                 <td>' . $consignmentLocation . '</td>
//                 <td>' . $status . '</td>';
//                 echo '<td>'; number_format(getNumberCountedBagsPerClient($countedBy, $clientId)); echo '</td>
//                 <td>';
//                     if ($confirmationDone == 'YES') {
//                         echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
//                         View Confirmed Bags <i class="material-icons left">link</i>
//                         </a>';
//                     } else {
//                         echo '<button data-target="addBag" style="margin: 6px; background: #6acef3 !important;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-client="' . $clientId . '">
//                         Add Bag <i class="material-icons left">add</i>
//                         </button>';
//                         echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
//                         View Confirmed Bags <i class="material-icons left">link</i>
//                         </a>';
//                         echo '<button data-target="closeConfirmation" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-client="' . $clientId . '">
//                         End Bundle Confirmation <i class="material-icons left">done_all</i>
//                         </button>';
//                     }
//                 echo '</td>
//             </tr>';
//         }
//         echo '</tbody>
//         </table>';
//     } else {
//         echo 'No record found.';
//     }
//     $con->close();
// }
