<?php

$tblName = 'consignmentlocations';
$slug = 'slug';

$error = false;

if(isset($_POST["addConsignmentLocation"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $clName	 	    = filter_var($_POST['clName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $clSlug          = filter_var($_POST['clSlug'], FILTER_SANITIZE_STRING);
    
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

    if (empty($clName)) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (strlen($clName) < 3) {
        $error = true;
        echo'Invalid Consignment Location Name';
    }

    if (empty($clSlug)) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (strlen($clSlug) < 3) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (alreadyTaken($tblName, $slug, $clSlug)) {
        $error = true;
        echo 'Consignment Location Already Exists';
    }

    if( !$error ) {
        addConsignmentLocation($clName, $clSlug);
    }
}

if(isset($_POST["updateConsignmentLocation"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $uclName	    = filter_var($_POST['uclName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $uclSlug         = filter_var($_POST['uclSlug'], FILTER_SANITIZE_STRING);
    $clId            = filter_var($_POST['clId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($uclName)) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (strlen($uclName) < 3) {
        $error = true;
        echo'Invalid Consignment Location Name';
    }

    if (empty($uclSlug)) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (strlen($uclSlug) < 3) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (alreadyTaken($tblName, $slug, $uclSlug)) {
        $error = true;
        echo 'Consignment Location Already Exists';
    }

    if( !$error ) {
        updateConsignmentLocation($uclName, $uclSlug, $clId);
    }
}

if(isset($_POST["deleteConsignmentLocation"])){

    $clId           = filter_var($_POST['dclId'], FILTER_SANITIZE_STRING);
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


    if (empty($clId)) {
        $error = true;
        echo'Invalid Consignment Location Name';
    } else if (strlen($clId) < 1) {
        $error = true;
        echo'Invalid Consignment Location Name';
    }

    if( !$error ) {
        deleteConsignmentLocation($clId);
    }
}

// Get all Consignment Locations
function getConsignmentLocations()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM consignmentlocations ORDER BY id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th class="width-5">S/No</th>
                    <th class="width-70">Consignment Location Name</th>
                    <th class="width-25">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Consignment Location Name</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['name'] . '</td>
                <td>
                    <button data-target="updateConsignmentAllocation" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteConsignmentAllocation" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No Consignment location found. <button data-target="addConsignmentAllocation" class="btns btns-add waves-effect waves-teal  modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Consignment Location</button>';
    }
    $con->close();
}

// Add Consignment Location function
function addConsignmentLocation($clName, $clSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO consignmentlocations (name, slug)
            VALUES ('$clName', '$clSlug')";

    if ($con->query($sql) === true) {
        echo "cladded";
        // getConsignmentLocations();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Consignment Location
function updateConsignmentLocation($uclName, $uclSlug, $clId)
{
    require('../core/db.php');

    $sql = "UPDATE consignmentlocations SET 
            name = '$uclName', 
            slug = '$uclSlug' 
            WHERE id = $clId ";

    if ($con->query($sql) === true) {
        echo "clupdated";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete Consignment Location
function deleteConsignmentLocation($clId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM consignmentlocations WHERE id = $clId";

    if ($con->query($sql) === true) {
        echo "cldeleted";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}