<?php

$tblName = 'currencies';
$slug = 'slug';

$error = false;

if(isset($_POST["addCurrency"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $cName	 	    = filter_var($_POST['cName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $cSlug         = filter_var($_POST['cSlug'], FILTER_SANITIZE_STRING);

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

    if (empty($cName)) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (strlen($cName) < 2) {
        $error = true;
        echo'Invalid Currency Name';
    }

    if (empty($cSlug)) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (strlen($cSlug) < 2) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (alreadyTaken($tblName, $slug, $cSlug)) {
        $error = true;
        echo 'Currency Already Exists';
    }

    if( !$error ) {
        addCurrency($cName, $cSlug);
    }
}

if(isset($_POST["updateCurrency"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $ucName	    = filter_var($_POST['ucName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $ucSlug        = filter_var($_POST['ucSlug'], FILTER_SANITIZE_STRING);
    $cId           = filter_var($_POST['cId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($ucName)) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (strlen($ucName) < 2) {
        $error = true;
        echo'Invalid Currency Name';
    }

    if (empty($ucSlug)) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (strlen($ucSlug) < 2) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (alreadyTaken($tblName, $slug, $ucSlug)) {
        $error = true;
        echo 'Currency Already Exists';
    }

    if( !$error ) {
        updateCurrency($ucName, $ucSlug, $cId);
    }
}

if(isset($_POST["deleteCurrency"])){
    $cId           = filter_var($_POST['dcId'], FILTER_SANITIZE_STRING);
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


    if (empty($cId)) {
        $error = true;
        echo'Invalid Currency Name';
    } else if (strlen($cId) < 1) {
        $error = true;
        echo'Invalid Currency Name';
    }

    if( !$error ) {
        deleteCurrency($cId);
    }
}

// Get all Currencies
function getCurrencies()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM currencies ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-75">Currency</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Currency</th>
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
                    <button data-target="updateCurrency" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteCurrency" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No Currency found. <button data-target="addCurrency" class="btns btns-add waves-effect waves-red white blue-grey-text modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Currency</button>';
    }
    $con->close();
}

// Add Currency function
function addCurrency($cName, $cSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO currencies (name, slug)
            VALUES ('$cName', '$cSlug')";

    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Currency
function updateCurrency($ucName, $ucSlug, $cId)
{
    require('../core/db.php');

    $sql = "UPDATE currencies SET 
            name = '$ucName' 
            WHERE id = $cId ";

    if ($con->query($sql) === true) {
        echo "okay200";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete Currency
function deleteCurrency($cId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM currencies WHERE id = $cId";

    if ($con->query($sql) === true) {
        echo "200";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}