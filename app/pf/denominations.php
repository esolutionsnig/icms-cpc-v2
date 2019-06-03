<?php

$tblName = 'denominations';
$slug = 'slug';

$error = false;

if(isset($_POST["addDenomination"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $dName	 	    = filter_var($_POST['dName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dSlug         = filter_var($_POST['dSlug'], FILTER_SANITIZE_STRING);

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

    if (empty($dName)) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (strlen($dName) > 4) {
        $error = true;
        echo'Invalid Denomination Name';
    }

    if (empty($dSlug)) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (strlen($dSlug) > 4) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (alreadyTaken($tblName, $slug, $dSlug)) {
        $error = true;
        echo 'Denomination Already Exists';
    }

    if( !$error ) {
        addDenomination($dName, $dSlug);
    }
}

if(isset($_POST["updateDenomination"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $udName	    = filter_var($_POST['udName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $udSlug        = filter_var($_POST['udSlug'], FILTER_SANITIZE_STRING);
    $dId           = filter_var($_POST['dId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($udName)) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (strlen($udName) > 4) {
        $error = true;
        echo'Invalid Denomination Name';
    }

    if (empty($udSlug)) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (strlen($udSlug) > 4) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (alreadyTaken($tblName, $slug, $udSlug)) {
        $error = true;
        echo 'Denomination Already Exists';
    }

    if( !$error ) {
        updateDenomination($udName, $udSlug, $dId);
    }
}

if(isset($_POST["deleteDenomination"])){
    $dId           = filter_var($_POST['ddId'], FILTER_SANITIZE_STRING);
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


    if (empty($dId)) {
        $error = true;
        echo'Invalid Denomination Name';
    } else if (strlen($dId) < 1) {
        $error = true;
        echo'Invalid Denomination Name';
    }

    if( !$error ) {
        deleteDenomination($dId);
    }
}

// Get all Denominations
function getDenominations()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM denominations ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-75">Denomination</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Denomination</th>
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
                    <button data-target="updateDenomination" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteDenomination" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No Denomination found. <button data-target="addDenomination" class="btns btns-add waves-effect waves-red modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Denomination</button>';
    }
    $con->close();
}

// Add Denomination function
function addDenomination($dName, $dSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO denominations (name, slug)
            VALUES ('$dName', '$dSlug')";

    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Denomination
function updateDenomination($udName, $udSlug, $dId)
{
    require('../core/db.php');

    $sql = "UPDATE denominations SET 
            name = '$udName', 
            slug = '$udSlug' 
            WHERE id = $dId ";

    if ($con->query($sql) === true) {
        echo "okay200";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete Denomination
function deleteDenomination($dId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM denominations WHERE id = $dId";

    if ($con->query($sql) === true) {
        echo "200";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}