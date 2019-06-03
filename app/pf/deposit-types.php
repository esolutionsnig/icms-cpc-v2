<?php

$tblName = 'deposittypes';
$slug = 'slug';

$error = false;

if(isset($_POST["addDepositType"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $dtName	 	    = filter_var($_POST['dtName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dtSlug         = filter_var($_POST['dtSlug'], FILTER_SANITIZE_STRING);
    
    // Basic Username Name Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request ';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request ts ';
    }

    if (empty($username)) {
        $error = true;
        echo'Unauthorized User ';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }

    if (empty($dtName)) {
        $error = true;
        echo'Invalid Deposit Type Name';
    } else if (strlen($dtName) < 3) {
        $error = true;
        echo'Invalid Deposit Type Name ts';
    }

    if (empty($dtSlug)) {
        $error = true;
        echo'Invalid Deposit Type Name ns';
    } else if (strlen($dtSlug) < 3) {
        $error = true;
        echo'Invalid Deposit Type Name ns ts';
    } else if (alreadyTaken($tblName, $slug, $dtSlug)) {
        $error = true;
        echo 'Deposit Type Already Exists';
    }

    if( !$error ) {
        addDepositType($dtName, $dtSlug);
    }
}

if(isset($_POST["updateDepositType"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $udtName	    = filter_var($_POST['udtName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $udtSlug        = filter_var($_POST['udtSlug'], FILTER_SANITIZE_STRING);
    $dtId           = filter_var($_POST['dtId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($udtName)) {
        $error = true;
        echo'Invalid Deposit Type Name';
    } else if (strlen($udtName) < 3) {
        $error = true;
        echo'Invalid Deposit Type Name';
    }

    if (empty($udtSlug)) {
        $error = true;
        echo'Invalid Deposit Type Name';
    } else if (strlen($udtSlug) < 3) {
        $error = true;
        echo'Invalid Deposit Type Name';
    } else if (alreadyTaken($tblName, $slug, $udtSlug)) {
        $error = true;
        echo 'Deposit Type Already Exists';
    }

    if( !$error ) {
        updateDepositType($udtName, $udtSlug, $dtId);
    }
}

if(isset($_POST["deleteDepositType"])){
    
    $dtId           = filter_var($_POST['ddtId'], FILTER_SANITIZE_STRING);
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


    if (empty($dtId)) {
        $error = true;
        echo'Invalid Deposit Type Name';
    } else if (strlen($dtId) < 1) {
        $error = true;
        echo'Invalid Deposit Type Name';
    }

    if( !$error ) {
        deleteDepositType($dtId);
    }
}

// Get all deposit types
function getDepositTypes()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM deposittypes ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-75">Deposit Type</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Deposit Type</th>
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
                    <button data-target="updateDepositType" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteDepositType" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No deposit type found. <button data-target="addDepositType" class="btns btns-add waves-effect waves-red modal-trigger"><i class="material-icons left">add</i> Click Here To Add New Deposit Type</button>';
    }
    $con->close();
}

// Add deposit type function
function addDepositType($dtName, $dtSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO deposittypes (name, slug)
            VALUES ('$dtName', '$dtSlug')";

    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update deposit type
function updateDepositType($udtName, $udtSlug, $dtId)
{
    require('../core/db.php');

    $sql = "UPDATE deposittypes SET 
            name = '$udtName', 
            slug = '$udtSlug' 
            WHERE id = $dtId ";

    if ($con->query($sql) === true) {
        echo "okay200";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete deposit type
function deleteDepositType($dtId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM deposittypes WHERE id = $dtId";

    if ($con->query($sql) === true) {
        echo "200";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}