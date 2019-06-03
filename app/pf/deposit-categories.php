<?php

$tblName = 'depositcategories';
$slug = 'slug';

$error = false;

if(isset($_POST["addDepositCategory"])){

    require_once('../core/general-functions.php');

    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $dcName	 	    = filter_var($_POST['dcName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $dcSlug         = filter_var($_POST['dcSlug'], FILTER_SANITIZE_STRING);
    
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

    if (empty($dcName)) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (strlen($dcName) < 3) {
        $error = true;
        echo'Invalid Deposit category Name';
    }

    if (empty($dcSlug)) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (strlen($dcSlug) < 3) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (alreadyTaken($tblName, $slug, $dcSlug)) {
        $error = true;
        echo 'Deposit Category Already Exists';
    }

    if( !$error ) {
        addDepositCategory($dcName, $dcSlug);
    }
}

if(isset($_POST["updateDepositCategory"])){

    require_once('../core/general-functions.php');

    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $udcName	    = filter_var($_POST['udcName'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $udcSlug        = filter_var($_POST['udcSlug'], FILTER_SANITIZE_STRING);
    $dcId           = filter_var($_POST['dcId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($udcName)) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (strlen($udcName) < 3) {
        $error = true;
        echo'Invalid Deposit category Name';
    }

    if (empty($udcSlug)) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (strlen($udcSlug) < 3) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (alreadyTaken($tblName, $slug, $udcSlug)) {
        $error = true;
        echo 'Deposit Category Already Exists';
    }

    if( !$error ) {
        updateDepositCategory($udcName, $udcSlug, $dcId);
    }
}

if(isset($_POST["deleteDepositCategory"])){

    $dcId           = filter_var($_POST['ddcId'], FILTER_SANITIZE_STRING);
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


    if (empty($dcId)) {
        $error = true;
        echo'Invalid Deposit category Name';
    } else if (strlen($dcId) < 1) {
        $error = true;
        echo'Invalid Deposit category Name';
    }

    if( !$error ) {
        deleteDepositCategory($dcId);
    }
}

// Get all deposit categorys
function getDepositCategories()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM depositcategories ORDER BY id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-75">Deposit Category</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Deposit category</th>
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
                    <button data-target="updateDepositCategory" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-slug="' . $row['slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteDepositCategory" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No deposit category found. <button data-target="addDepositCategory" class="btns btns-add waves-effect waves-red modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Deposit Category</button>';
    }
    $con->close();
}

// Add deposit category function
function addDepositCategory($dcName, $dcSlug)
{
    require('../core/db.php');

    $sql = "INSERT INTO depositcategories (name, slug)
            VALUES ('$dcName', '$dcSlug')";

    if ($con->query($sql) === true) {
        echo "dcadded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update deposit category
function updateDepositCategory($udcName, $udcSlug, $dcId)
{
    require('../core/db.php');

    $sql = "UPDATE depositcategories SET 
            name = '$udcName', 
            slug = '$udcSlug' 
            WHERE id = $dcId ";

    if ($con->query($sql) === true) {
        echo "dcupdated";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete deposit category
function deleteDepositCategory($dcId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM depositcategories WHERE id = $dcId";

    if ($con->query($sql) === true) {
        echo "dcdeleted";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}