<?php

$tblName = 'vehicles';
$slug = 'slug';

$error = false;

if(isset($_POST["addVehicle"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $vName	 	    = filter_var($_POST['vName'], FILTER_SANITIZE_STRING);
    $vNumber	 	= filter_var($_POST['vNumber'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $vSlug          = filter_var($_POST['vSlug'], FILTER_SANITIZE_STRING);
    
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

    if (empty($vName)) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (strlen($vName) < 3) {
        $error = true;
        echo'Invalid Vehicle Name';
    }

    if (empty($vNumber)) {
        $error = true;
        echo'Invalid Vehicle NUmber';
    } else if (strlen($vNumber) < 7) {
        $error = true;
        echo'Invalid Vehicle NUmber';
    }

    if (empty($vSlug)) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (strlen($vSlug) < 3) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (alreadyTaken($tblName, $slug, $vSlug)) {
        $error = true;
        echo 'Vehicle Already Exists';
    }

    if( !$error ) {
        addVehicle($vName, $vNumber, $vSlug);
    }
}

if(isset($_POST["updateVehicle"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $uvName	        = filter_var($_POST['uvName'], FILTER_SANITIZE_STRING);
    $uvNumber	    = filter_var($_POST['uvNumber'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $uvSlug         = filter_var($_POST['uvSlug'], FILTER_SANITIZE_STRING);
    $vId            = filter_var($_POST['vId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($uvName)) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (strlen($uvName) < 3) {
        $error = true;
        echo'Invalid Vehicle Name';
    }

    if (empty($uvNumber)) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (strlen($uvNumber) < 3) {
        $error = true;
        echo'Invalid Vehicle Name';
    }

    if (empty($uvSlug)) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (strlen($uvSlug) < 3) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (alreadyTaken($tblName, $slug, $uvSlug)) {
        $error = true;
        echo 'Vehicle Already Exists';
    }

    if( !$error ) {
        updateVehicle($uvName, $uvNumber, $uvSlug, $vId);
    }
}

if(isset($_POST["deleteVehicle"])){

    $vId           = filter_var($_POST['dvId'], FILTER_SANITIZE_STRING);
    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    
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


    if (empty($vId)) {
        $error = true;
        echo'Invalid Vehicle Name';
    } else if (strlen($vId) < 1) {
        $error = true;
        echo'Invalid Vehicle Name';
    }

    if( !$error ) {
        deleteVehicle($vId);
    }
}

// Get all Vehicles
function getVehiclez()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM vehicles ORDER BY id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-50">Vehicle Name</th>
                <th class="width-25">Vehicle Number</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Vehicle Name</th>
                <th>Vehicle Number</th>
                <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['number'] . '</td>
                <td>
                    <button data-target="updateVehicle" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-number="' . $row['number'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteVehicle" class="btns btns-add btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No vehicle found. <button data-target="addVehicle" class="btn waves-effect waves-red white blue-grey-text modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Vehicle</button>';
    }
    $con->close();
}

// Add Vehicle function
function addVehicle($vName, $vNumber, $vSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO vehicles (number, name, slug)
            VALUES ('$vNumber', '$vName', '$vSlug')";

    if ($con->query($sql) === true) {
        echo "vadded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Vehicle
function updateVehicle($uvName, $uvNumber, $uvSlug, $vId)
{
    require('../core/db.php');

    $sql = "UPDATE vehicles SET 
            number = '$uvNumber', 
            name = '$uvName', 
            slug = '$uvSlug' 
            WHERE id = $vId ";

    if ($con->query($sql) === true) {
        echo "vupdated";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete Vehicle
function deleteVehicle($vId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM vehicles WHERE id = $vId";

    if ($con->query($sql) === true) {
        echo "vdeleted";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}