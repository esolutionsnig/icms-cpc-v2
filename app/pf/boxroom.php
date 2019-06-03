<?php

$error = false;

// Get all Manifest
function getPreManifest()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT DISTINCT evacuation_id, vehicle_id, picked_up_on FROM cits WHERE picked_up_by != '' GROUP BY picked_up_on ORDER BY picked_up_on DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Vehicle Information</th>
                    <th>Picked Up On </th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Vehicle Information</th>
                    <th>Picked Up On </th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $bUID = $row['vehicle_id'].'------'.$row['evacuation_id'].'------'.$row['picked_up_on'];
            $bankUID = base64_encode($bUID);

            //get client name
            $getVehicle         = getCitVehicleById($row['vehicle_id']);
            $vehicleName        = $getVehicle['name'];
            // Check If It Was Pre-Announced
            if ( $vehicleName == '' ) {
                $vehicleName = 'Preannounced Consignment';
            }

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $vehicleName . '</td>
                <td>' . $row['picked_up_on'] . '</td>
                <td>
                    <a href="manifest?r=' . $row['evacuation_id'].'cprf'.$bankUID .'" class="btns btns-add waves-effect waves-light" style="color: white !important;">
                        Generate Manifest  <i class="material-icons right">send</i>
                    </a>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No record found';
    }
    $con->close();
}

// Confirm Consignment Hand Over
if(isset($_POST["confirmReceipt"])){
    
    require_once('../core/general-functions.php');
    
    $erId	 	            = filter_var($_POST['erId'], FILTER_SANITIZE_STRING);
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $citConfirmationDate    = date('m/d/y');

    // Basic Username Name Validation
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
        confirmCHO($erId, $citConfirmationDate, $username);
    }
}

// Confirm Consignment Hand Over function
function confirmCHO($erId, $citConfirmationDate, $username)
{
    require('../core/db.php');
    $sql = "UPDATE cits SET 
            delivery_status = 'Delivered To Boxroom',
            received_by = '$username',
            received_on = '$citConfirmationDate'
            WHERE evacuation_id = '$erId' ";
    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}


// Accept One Consignment
if(isset($_POST["acceptOneConsignment"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $imId                	 	= filter_var($_POST['confirmSealNumberId'], FILTER_SANITIZE_STRING);
    $sealNumber           	 	= filter_var($_POST['sealNumber'], FILTER_SANITIZE_STRING);
    
    // Basic Username Name Validation
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
        confirmConsinment($imId, $sealNumber, $addedOn, $username);
    }
}

// Confirm Consignment
function confirmConsinment($imId, $sealNumber, $addedOn, $username)
{
    require('../core/db.php');

    $acceptStatus = 'Received At Boxroom';

    $sql = "UPDATE cits SET 
            received_by = '$username',
            received_on = '$addedOn',
            delivery_status = '$acceptStatus' 
            WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        $sql = "INSERT INTO internalmovements (source_location, destination_location, seal_number, added_on, added_by, received_by, received_on, movement_status)
        VALUES ('2', '3', '$sealNumber', '$addedOn', '$username', '$username', '$addedOn', 'Confirmed')";

        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "";
        }
        echo "";
    } else {
        // echo "Error";
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}



// Accept Multiple Consignments
if(isset($_POST["confirmSelectedBags"])){

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $selectedSealNumbers        = $_POST['selectedSealNumbers'];
    
    // Basic Username Name Validation
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
    if (empty($selectedSealNumbers)) {
        $error = true;
        echo'Seal Number Is Required';
    }

    if( !$error ) {
        foreach($selectedSealNumbers as $sealNumber){
            confirmSelectedBags($sealNumber, $addedOn, $username);
        }
    }
}

// Confirm Consignment
function confirmSelectedBags($sealNumber, $addedOn, $username)
{
    require('../core/db.php');

    $acceptStatus = 'Received At Boxroom';

    $sql = "UPDATE cits SET 
            received_by = '$username',
            received_on = '$addedOn',
            delivery_status = '$acceptStatus' 
            WHERE seal_number = '$sealNumber' ";
    if ($con->query($sql) === true) {
        $sql = "INSERT INTO internalmovements (source_location, destination_location, seal_number, added_on, added_by, received_by, received_on, movement_status)
        VALUES ('7', '8', '$sealNumber', '$addedOn', '$username', '$username', '$addedOn', 'Confirmed')";

        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "";
        }
        echo "";
    } else {
        // echo "Error";
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}