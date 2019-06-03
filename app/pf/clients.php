<?php

$tblName = 'banks';
$slug = 'bank_slug';

$error = false;

if(isset($_POST["addBank"])){

    require_once('../core/general-functions.php');

    $addedOn        = time();
    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $bankName	 	= filter_var($_POST['bankName'], FILTER_SANITIZE_STRING);
    $bankCode	 	= filter_var($_POST['bankCode'], FILTER_SANITIZE_STRING);
    $bankSlug       = filter_var($_POST['bankSlug'], FILTER_SANITIZE_STRING);

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

    if (empty($bankName)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($bankName) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    }

    if (empty($bankCode)) {
        $error = true;
        echo'Invalid Bank Code';
    } else if (strlen($bankCode) < 2) {
        $error = true;
        echo'Invalid Bank Code';
    }

    if (empty($bankSlug)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($bankSlug) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (alreadyTaken($tblName, $slug, $bankSlug)) {
        $error = true;
        echo 'Bank Already Exists';
    }

    if( !$error ) {
        addBank($bankName, $bankCode, $bankSlug, $addedOn, $username);
    }
}

if(isset($_POST["updateBank"])){

    require_once('../core/general-functions.php');

    $updatedOn      = time();
    $username       = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $uBankName	    = filter_var($_POST['ubankName'], FILTER_SANITIZE_STRING);
    $uBankCode	    = filter_var($_POST['ubankCode'], FILTER_SANITIZE_STRING);
    $uBankSlug      = filter_var($_POST['ubankSlug'], FILTER_SANITIZE_STRING);
    $uBankId        = filter_var($_POST['ubankId'], FILTER_SANITIZE_STRING);
    
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

    if (empty($uBankName)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($uBankName) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    }

    if (empty($uBankCode)) {
        $error = true;
        echo'Invalid Bank Code';
    } else if (strlen($uBankCode) < 2) {
        $error = true;
        echo'Invalid Bank Code';
    }

    if (empty($uBankSlug)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($uBankSlug) < 5) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (alreadyTaken($tblName, $slug, $uBankSlug)) {
        $error = true;
        echo 'Bank Already Exists';
    }

    if( !$error ) {
        updateBank($uBankName, $uBankCode, $uBankSlug, $uBankId, $updatedOn, $username);
    }
}

if(isset($_POST["deleteBank"])){
    $dBankId        = filter_var($_POST['dbankId'], FILTER_SANITIZE_STRING);
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

    if (empty($dBankId)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($dBankId) < 1) {
        $error = true;
        echo'Invalid Bank Name';
    }

    if( !$error ) {
        deleteBank($dBankId);
    }
}

// Get all Banks
function getBanks()
{
  // Add DB Connection
    require('./app/core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM banks ORDER BY bank_name ASC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th class="width-5">S/No</th>
                    <th class="width-45">Long Name</th>
                    <th class="width-10">Short Name</th>
                    <th class="width-30">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Long Name</th>
                    <th>Short Name</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $bUID = $row['id'].'------'.$row['bank_slug'].'------el';
            $bankUID = base64_encode($bUID);

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td><a href="client?r=' . $row['bank_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['bank_name'] . '</a></td>
                <td><a href="client?r=' . $row['bank_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['bank_code'] . '</a></td>
                <td>
                    <a href="client?r=' . $row['bank_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important;">
                        View  <i class="material-icons left">link</i>
                    </a>
                    <button data-target="updateBank" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['id'] . '" data-name="' . $row['bank_name'] . '" data-code="' . $row['bank_code'] . '" data-slug="' . $row['bank_slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteBank" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['id'] . '" data-name="' . $row['bank_name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No client found. <button data-target="addBank" class="btns btn-add waves-effect waves-red white blue-grey-text modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Bank</button>';
    }
    $con->close();
}

// Display Requested Bank Name
function getBankName($slug)
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = "SELECT * FROM banks WHERE bank_slug = '$slug' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['bank_name'];
        }
    } else {
        echo 'Client';
    }
    $con->close();
}

// Get Number Requested Bank Branches
function getNumberBankBranches($bankId)
{
    // Add DB Connection
    require('./app/core/db.php');

    $sql = "SELECT * FROM bank_branches WHERE banks_id = '$bankId' ";
    $result = $con->query($sql);
    echo $result->num_rows;
    $con->close();
}

// Get Number Requested Bank Representatives
function getNumberBankReps($bankId)
{
    // Add DB Connection
    require('./app/core/db.php');

    $sql = "SELECT * FROM bankreps WHERE banks_id = '$bankId' ";
    $result = $con->query($sql);
    echo $result->num_rows;
    $con->close();
}

// Get List Of Bank Representatives
function getBanksRepsList($bankId)
{
    // Add DB Connection
    require('./app/core/db.php');
    $sql = " SELECT * FROM bankreps WHERE banks_id = '$bankId' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $req_user_detail  = getUserFullname($row['username']);
            $bankRepName      = $req_user_detail['surname'].' '.$req_user_detail['middlename'].' '.$req_user_detail['firstname'];
            echo '<option value="'.$row['username'].'">'.$bankRepName.'</option>';
        }
    } else {
        echo '<option value="">No User Found</option>';
    }
    $con->close();
}

// Get Requested Bank Representatives
function getBankReps($bankId)
{
    // Add DB Connection
    require('./app/core/db.php');

    $sno = 1;
    $sql = "SELECT * FROM bankreps WHERE banks_id = '$bankId' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th class="width-5">S/No</th>
                    <th>Name</th>
                    <th>User Access Level</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Name</th>
                    <th>User Access Level</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        while ($row = $result->fetch_assoc()) {
            $req_user_detail  = getUserFullname($row['username']);
            $bankRepName      = $req_user_detail['surname'].' '.$req_user_detail['middlename'].' '.$req_user_detail['firstname'];
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $bankRepName . '</td>
                <td>'; getUserLevel($row['username']); echo '</td>
                <td>
                    <button data-target="deleteBankRep" class="btns btns-delete waves-effect waves-light primary-btn modal-trigger removeBankRep" data-username="' . $row['username'] . '" data-bankrepname="' . $bankRepName . '" data-id="' . $row['id'] . '">
                        Delete
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No record found. <button data-target="addBankReps" class="btns btn-add waves-effect waves-red white blue-grey-text modal-trigger ml-1"><i class="material-icons left">add</i> Add Representative</button>';
    }
    $con->close();
}

// Add Bank function
function addBank($bankName, $bankCode, $bankSlug, $addedOn, $addedBy)
{
    require('../core/db.php');

    $sql = "INSERT INTO banks (bank_name, bank_code, bank_slug, added_on, added_by)
            VALUES ('$bankName', '$bankCode','$bankSlug', '$addedOn', '$addedBy')";

    if ($con->query($sql) === true) {
        echo "ok200";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Bank
function updateBank($uBankName, $uBankCode, $uBankSlug, $uBankId, $updatedOn, $updatedBy)
{
    require('../core/db.php');

    $sql = "UPDATE banks SET 
            bank_name = '$uBankName', 
            bank_code = '$uBankCode', 
            bank_slug = '$uBankSlug',
            added_on = '$updatedOn',
            added_by = '$updatedBy' 
            WHERE id = $uBankId ";

    if ($con->query($sql) === true) {
        echo "okay200";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

// Delete Bank
function deleteBank($dBankId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM banks WHERE id = '$dBankId'";

    if ($con->query($sql) === true) {
        echo "200";
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}

// Add Bank Rep
if(isset($_POST["addBankRep"])){

    require_once('../core/general-functions.php');

    $addedOn        = time();
    $username	 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		= filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $bankId	 	    = filter_var($_POST['bankId'], FILTER_SANITIZE_STRING);
    $selectedUser	= filter_var($_POST['bankRep'], FILTER_SANITIZE_STRING);

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

    if (empty($bankId)) {
        $error = true;
        echo'Invalid Bank';
    }

    if (empty($selectedUser)) {
        $error = true;
        echo'Kindly Select A User';
    } else if (strlen($selectedUser) < 4) {
        $error = true;
        echo'Kindly Select A User n';
    }

    if (alreadyTaken('bankreps', 'username', $selectedUser)) {
        $error = true;
        echo 'This User Already Belongs To A Bank';
    }

    if( !$error ) {
        addBankRep($bankId, $selectedUser, $addedOn, $username);
    }
}

if(isset($_POST["removeBankRepresentative"])){
    $rBankId        = filter_var($_POST['rBankId'], FILTER_SANITIZE_STRING);
    $rUsername      = filter_var($_POST['rUsername'], FILTER_SANITIZE_STRING);
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

    if (empty($rBankId)) {
        $error = true;
        echo'Invalid Bank Name';
    } else if (strlen($rBankId) < 1) {
        $error = true;
        echo'Invalid Bank Name';
    }

    if (empty($rUsername)) {
        $error = true;
        echo'Invalid Bank Representative';
    } else if (strlen($rUsername) < 4) {
        $error = true;
        echo'Invalid Bank Representative';
    }

    if( !$error ) {
        removeBankRep($rBankId, $rUsername);
    }
}
// Add Bank Representative function
function addBankRep($bankId, $selectedUser, $addedOn, $addedBy)
{
    require('../core/db.php');

    $sql = "INSERT INTO bankreps (username, banks_id, added_on, added_by)
            VALUES ('$selectedUser', '$bankId', '$addedOn', '$addedBy')";

    if ($con->query($sql) === true) {
        echo "repAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Remove Rep
function removeBankRep($rBankId, $rBankRep)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM bankreps WHERE banks_id = '$rBankId' AND username = '$rBankRep'";

    if ($con->query($sql) === true) {
        echo "repRemoved";
    } else {
        echo "Error removing bank representative: " . $con->error;
    }

    $con->close();
}

// Add Bank Branch
if(isset($_POST["addBankBranch"]))
{

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $bankBranch	 	            = filter_var($_POST['bankBranch'], FILTER_SANITIZE_STRING);
    $bankBranchLocation	 	    = filter_var($_POST['bankBranchLocation'], FILTER_SANITIZE_STRING);
    $bankBranchLocationCode	 	= filter_var($_POST['bankBranchLocationCode'], FILTER_SANITIZE_STRING);
    $bankBranchCmu	 	        = filter_var($_POST['bankBranchCmu'], FILTER_SANITIZE_STRING);
    $bankBranchRep	 	        = filter_var($_POST['bankBranchRep'], FILTER_SANITIZE_STRING);
    $bankBranchSlug	 	        = filter_var($_POST['bankBranchSlug'], FILTER_SANITIZE_STRING);
    $bankId	 	                = filter_var($_POST['bankId'], FILTER_SANITIZE_STRING);

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

    if (empty($bankId)) {
        $error = true;
        echo'Invalid Bank';
    }

    if (empty($bankBranch)) {
        $error = true;
        echo'Branch Name Is Required';
    }

    if (empty($bankBranchLocation)) {
        $error = true;
        echo'Branch Location Is Required';
    }

    if (empty($bankBranchLocationCode)) {
        $error = true;
        echo'Branch Location Code Is Required';
    }
    if (empty($bankBranchCmu)) {
        $error = true;
        echo'Branch CMU Is Required';
    }
    if (empty($bankBranchRep)) {
        $error = true;
        echo'Branch Representative Is Required';
    }

    if (empty($bankBranchSlug)) {
        $error = true;
        echo'Invalid Bank Name sl';
    }

    if (alreadyTaken('bank_branches', 'slug', $bankBranchSlug)) {
        $error = true;
        echo 'This Branch Already Exists';
    }

    if( !$error ) {
        addBankBranch($bankId, $bankBranch, $bankBranchLocation, $bankBranchLocationCode, $bankBranchCmu, $bankBranchRep, $bankBranchSlug, $addedOn, $username);
    }
}
// Add Bank Branch function
function addBankBranch($bankId, $bankBranch, $bankBranchLocation, $bankBranchLocationCode, $bankBranchCmu, $bankBranchRep, $bankBranchSlug, $addedOn, $addedBy)
{
    require('../core/db.php');

    $sql = "INSERT INTO bank_branches (banks_id, name, branch_location, branch_location_code, branch_cmu, branch_rep, slug, added_on, added_by)
            VALUES ('$bankId', '$bankBranch', '$bankBranchLocation','$bankBranchLocationCode', '$bankBranchCmu', '$bankBranchRep', '$bankBranchSlug', '$addedOn', '$addedBy')";

    if ($con->query($sql) === true) {
        echo "branchAdded";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}

// Update Branch
if(isset($_POST["updateBankBranch"]))
{

    require_once('../core/general-functions.php');

    $addedOn                    = time();
    $username	 	            = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		            = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $ubranchId	 	            = filter_var($_POST['ubranchId'], FILTER_SANITIZE_STRING);
    $ubankBranch	 	        = filter_var($_POST['ubankBranch'], FILTER_SANITIZE_STRING);
    $ubankBranchLocation	 	= filter_var($_POST['ubankBranchLocation'], FILTER_SANITIZE_STRING);
    $ubankBranchLocationCode	= filter_var($_POST['ubankBranchLocationCode'], FILTER_SANITIZE_STRING);
    $ubankBranchRep	 	        = filter_var($_POST['ubankBranchRep'], FILTER_SANITIZE_STRING);
    $ubankBranchSlug	 	    = filter_var($_POST['ubankBranchSlug'], FILTER_SANITIZE_STRING);
    $ubankId	 	            = filter_var($_POST['ubankId'], FILTER_SANITIZE_STRING);

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

    if (empty($ubranchId)) {
        $error = true;
        echo'Invalid Branch Id';
    }

    if (empty($ubankId)) {
        $error = true;
        echo'Invalid Bank';
    }

    if (empty($ubankBranch)) {
        $error = true;
        echo'Branch Name Is Required';
    }

    if (empty($ubankBranchLocation)) {
        $error = true;
        echo'Branch Location Is Required';
    }

    if (empty($ubankBranchLocationCode)) {
        $error = true;
        echo'Branch Location Code Is Required';
    }

    if (empty($ubankBranchRep)) {
        $error = true;
        echo'Branch Representative Is Required';
    }

    if (empty($ubankBranchSlug)) {
        $error = true;
        echo'Invalid Bank Name sl';
    }

    if (alreadyTaken('bank_branches', 'slug', $ubankBranchSlug)) {
        $error = true;
        echo 'This Branch Already Exists';
    }

    if( !$error ) {
        updateBranch($ubranchId, $ubankId, $ubankBranch, $ubankBranchLocation, $ubankBranchLocationCode, $ubankBranchRep, $ubankBranchSlug, $addedOn, $username);
    }
}

// Update Branch Function
function updateBranch($branchId, $ubankId, $ubankBranch, $ubankBranchLocation, $ubankBranchLocationCode, $ubankBranchRep, $ubankBranchSlug, $updatedOn, $updatedBy)
{
    require('../core/db.php');

    $sql = "UPDATE bank_branches SET 
            name = '$ubankBranch', 
            branch_location = '$ubankBranchLocation', 
            branch_location_code = '$ubankBranchLocationCode',
            branch_rep = '$ubankBranchRep',
            slug = '$ubankBranchSlug',
            added_on = '$updatedOn',
            added_by = '$updatedBy' 
            WHERE id = $branchId ";

    if ($con->query($sql) === true) {
        echo "branchUpdated";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $con->close();
}

if(isset($_POST["removeBranch"])){
    $rBranchId        = filter_var($_POST['dbranchId'], FILTER_SANITIZE_STRING);
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

    if (empty($rBranchId)) {
        $error = true;
        echo'Invalid Branch';
    } else if (strlen($rBranchId) < 1) {
        $error = true;
        echo'Invalid Branch';
    }

    if( !$error ) {
        removeBranch($rBranchId);
    }
}
// Remove Rep
function removeBranch($rBranchId)
{
    require('../core/db.php');
    
    // sql to delete a record
    $sql = "DELETE FROM bank_branches WHERE id = '$rBranchId' ";

    if ($con->query($sql) === true) {
        echo "branchRemoved";
    } else {
        echo "Error removing branch: " . $con->error;
    }

    $con->close();
}

// Get Requested Bank Branches
function getBankBranches($bankId)
{
    // Add DB Connection
    require('./app/core/db.php');

    $sno = 1;
    $sql = "SELECT * FROM bank_branches WHERE banks_id = '$bankId' ORDER BY branch_location_code ASC ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="bbTable" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th class="width-5">S/No</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Code</th>
                    <th>Representative</th>
                    <th>CMU</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Code</th>
                    <th>Representative</th>
                    <th>CMU</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        while ($row = $result->fetch_assoc()) {
            $req_user_data1  = getUserFullname($row['branch_cmu']);
            $branchCmuName      = $req_user_data1['surname'].' '.$req_user_data1['firstname'];
            $req_user_data  = getUserFullname($row['branch_rep']);
            $branchRepName      = $req_user_data['surname'].' '.$req_user_data['firstname'];
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['branch_location'] . '</td>
                <td>' . $row['branch_location_code'] . '</td>
                <td>' . $branchRepName . '</td>
                <td>' . $branchCmuName . '</td>
                <td>
                    <button data-target="deleteBranch" class="btns btns-delete waves-effect waves-light modal-trigger mb-1 removeBranch m-5" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">
                        Delete 
                    </button>
                </td>
            </tr>';
        }
        // echo '<button data-target="updateBranch" class="btns btns-edit waves-effect waves-light modal-trigger mb-1 editBranch m-5" data-ids="' . $row['id'] . '" data-name="' . $row['name'] . '" data-location="' . $row['branch_location'] . '" data-locationcode="' . $row['branch_location_code'] . '" data-rep="' . $row['branch_rep'] . '" data-slug="' . $row['slug'] . '">
        // Edit 
        // </button>';
        echo '</tbody>
        </table>';
    } else {
        echo 'No record found. <button data-target="addBankBranch" class="btns btn-add waves-effect waves-red white blue-grey-text modal-trigger ml-1"><i class="material-icons left">add</i> Add Branch</button>';
    }
    $con->close();
}