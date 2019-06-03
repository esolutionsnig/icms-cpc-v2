<?php

$tblName = 'containertypes';
$slug = 'slug';

$error = false;

if(isset($_POST["addContainerType"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $ctName	 	    = filter_var($_POST['ctName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $ctSlug         = filter_var($_POST['ctSlug'], FILTER_SANITIZE_STRING);

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

    if (empty($ctName)) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (strlen($ctName) < 3) {
        $error = true;
        echo'Invalid Container Type Name';
    }

    if (empty($ctSlug)) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (strlen($ctSlug) < 3) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (alreadyTaken($tblName, $slug, $ctSlug)) {
        $error = true;
        echo 'Container Type Already Exists';
    }

    if( !$error ) {
        addContainerType($ctName, $ctSlug);
    }
}

if(isset($_POST["updateContainerType"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $uctName	    = filter_var($_POST['uctName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $uctSlug        = filter_var($_POST['uctSlug'], FILTER_SANITIZE_STRING);
    $ctId           = filter_var($_POST['ctId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($uctName)) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (strlen($uctName) < 3) {
        $error = true;
        echo'Invalid Container Type Name';
    }

    if (empty($uctSlug)) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (strlen($uctSlug) < 3) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (alreadyTaken($tblName, $slug, $uctSlug)) {
        $error = true;
        echo 'Container Type Already Exists';
    }

    if( !$error ) {
        updateContainerType($uctName, $uctSlug, $ctId);
    }
}

if(isset($_POST["deleteContainerType"])){
    $ctId           = filter_var($_POST['dctId'], FILTER_SANITIZE_STRING);
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


    if (empty($ctId)) {
        $error = true;
        echo'Invalid Container Type Name';
    } else if (strlen($ctId) < 1) {
        $error = true;
        echo'Invalid Container Type Name';
    }

    if( !$error ) {
        deleteContainerType($ctId);
    }
}

// Get all Container types
function getContainerTypes()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM containertypes ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-75">Container Type</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Container Type</th>
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
                    <button data-target="updateContainerType" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteContainerType" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No Container type found. <button data-target="addContainerType" class="btns btns-add waves-effect waves-red modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Container Type</button>';
    }
    $con->close();
}

// Add Container type function
function addContainerType($ctName, $ctSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO containertypes (name, slug)
            VALUES ('$ctName', '$ctSlug')";

    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Container type
function updateContainerType($uctName, $uctSlug, $ctId)
{
    require('../core/db.php');

    $sql = "UPDATE containertypes SET 
            name = '$uctName', 
            slug = '$uctSlug' 
            WHERE id = $ctId ";

    if ($con->query($sql) === true) {
        echo "okay200";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete Container type
function deleteContainerType($ctId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM containertypes WHERE id = $ctId";

    if ($con->query($sql) === true) {
        echo "200";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}