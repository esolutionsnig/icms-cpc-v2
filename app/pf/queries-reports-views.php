<?php

$tblName = 'vault';
$slug = 'seal_number';

$error = false;

// Search Client
if(isset($_POST["searchClients"])){

    require_once('../core/general-functions.php');

    $clientSearchName   = filter_var($_POST['clientSearchName'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchClients($clientSearchName);
    }
}
// Search Client Function
function searchClients($clientSearchName)
{
    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="clients">Click Here To View All</a></small></h5>';
    require('../core/db.php');
    $sno = 1;
    $sql = " SELECT * FROM banks WHERE bank_name LIKE '%" . $clientSearchName . "%' OR bank_code LIKE '%" . $clientSearchName . "%' ORDER BY id DESC";
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
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$clientSearchName.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
}

// Search Client Branches
if(isset($_POST["searchClientBranches"])){

    require_once('../core/general-functions.php');

    $clientBranchSearchName   = filter_var($_POST['clientBranchSearchName'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchClientBranches($clientBranchSearchName);
    }
}
// Search Client Function
function searchClientBranches($clientBranchSearchName)
{
    require('../core/db.php');

    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="clients">Click Here To View All</a></small></h5>';
    $sno = 1;
    $sql = " SELECT * FROM bank_branches WHERE name LIKE '%" . $clientBranchSearchName . "%' OR branch_location  LIKE '%" . $clientBranchSearchName . "%' OR branch_location_code LIKE '%" . $clientBranchSearchName . "%' ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Client Name</th>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th>Location Code</th>
                    <th>Branch Rep</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Client Name</th>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th>Location Code</th>
                    <th>Branch Rep</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            //Get Client Name
            $reqClientName          = getClitnInfo($row['banks_id']);
            $clientName             = $reqClientName['bank_name'];
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $clientName . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['branch_location'] . '</td>
                <td>' . $row['branch_location_code'] . '</td>
                <td>' . $row['branch_rep'] . '</td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$clientBranchSearchName.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
}

// Search Client Evacuation Requests
if(isset($_POST["searchClientEvacReqs"])){

    require_once('../core/general-functions.php');

    $searchER   = filter_var($_POST['searchER'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchClientEvacReqs($searchER);
    }
}
// Search Client Evacuation Requests Function
function searchClientEvacReqs($searchER)
{
    require('../core/db.php');

    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="evacuation-requests">Click Here To View All</a></small></h5>';
    $sno = 1;
    $sql = " SELECT * FROM evacuations WHERE er_name LIKE '%" . $searchER . "%' OR location_code  LIKE '%" . $searchER . "%' ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Branch</th>
                    <th>Destination</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Branch</th>
                    <th>Destination</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $bUID = $row['id'].'------'.$row['er_slug'].'------el';
            $bankUID = base64_encode($bUID);
            //Get Client Name
            $reqClientName          = getClitnInfo($row['id']);
            $clientName             = $reqClientName['bank_name'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
            $consignmentLocation    = $reqConsLoc['location_name'];
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['er_name'] . '</td>
                <td>' . $clientName . '</td>
                <td>' . $row['location_code'] . '</td>
                <td>' . $consignmentLocation . '</td>
                <td><a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                View  <i class="material-icons left">link</i> </a></td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$searchER.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
}

// Search Users
if(isset($_POST["searchUsers"])){

    require_once('../core/general-functions.php');

    $searchPeople   = filter_var($_POST['searchPeople'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchUsers($searchPeople);
    }
}
// Search Users Function
function searchUsers($searchPeople)
{
    require('../core/db2.php');

    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="users">Click Here To View All</a></small></h5>';
    $sno = 1;
    $sql = " SELECT * FROM users WHERE username LIKE '%" . $searchPeople . "%' OR surname  LIKE '%" . $searchPeople . "%' OR firstname  LIKE '%" . $searchPeople . "%' OR middlename  LIKE '%" . $searchPeople . "%' OR phoneno  LIKE '%" . $searchPeople . "%' OR gender  LIKE '%" . $searchPeople . "%' OR address  LIKE '%" . $searchPeople . "%' OR email  LIKE '%" . $searchPeople . "%' ORDER BY username DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Other Names</th>
                    <th>Phone N0.</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Other Names</th>
                    <th>Phone N0.</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $getUserId              = $row['username'].'------'.$row['email'].'------el';
            $userUID                = base64_encode($getUserId);
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['surname'] . '</td>
                <td>' . $row['firstname'] . '</td>
                <td>' . $row['middlename'] . '</td>
                <td><a href="tel:"' . $row['phoneno'] . ' style="color: #000 !important">' . $row['phoneno'] . '</a></td>
                <td>' . $row['gender'] . '</td>
                <td>' . $row['address'] . '</td>
                <td><a href="mailto:"' . $row['email'] . ' style="color: #000 !important">' . $row['email'] . '</a></td>
                <td><a href="profile?r='.$row['username'].'cprf'.$userUID .'" target="_blank" style="color: #4f2323 !important;">View Profile</a></td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$searchER.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
}

// Search Bundle Confirmations
if(isset($_POST["searchBC"])){

    require_once('../core/general-functions.php');

    $searchBCS   = filter_var($_POST['searchBCS'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchBC($searchBCS);
    }
}
// Search Bundle Confirmations Function
function searchBC($searchBCS)
{
    require('../core/db.php');

    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="bundle-confirmation">Click Here To View All</a></small></h5>';
    $sno = 1;
    $sql = " SELECT * FROM bundleconfirmationbags WHERE seal_number LIKE '%" . $searchBCS . "%' ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Client Name</th>
                    <th>Consignment Location</th>
                    <th>Confirmation Status</th>
                    <th>Bags Added</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Client Name</th>
                    <th>Consignment Location</th>
                    <th>Confirmation Status</th>
                    <th>Bags Added</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $clientId = $row['client'];
            //get client name
            $reqClientName      = getClitnInfo($clientId);
            $clientName         = $reqClientName['bank_name'];

            $bUID = $row['bcs_id'].'------'.$clientName.'------'.$clientId;
            $bankUID = base64_encode($bUID);

            $cbUID = $row['bcs_id'].'------'.$row['added_by'].'------'.$clientId;
            $cbbUID = base64_encode($cbUID);

            $countedBy = $row['added_by'];

            // Get Data From Bundle Confirmation Start
            $reqStartdata           = getBundleConfirmationZtart($clientId);
            $conssignmentLocation   = $reqStartdata['conslocation'];
            $confirmationDone       = $reqStartdata['confirmation_done'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($conssignmentLocation);
            $consignmentLocation    = $reqConsLoc['location_name'];
            //Get Work Status
            if ($confirmationDone == 'YES') {
                $status = '<span class="badge teal white-text"><i class="material-icons left small" style="padding-top: 4px">done_all</i> Completed</span>';
            } else {
                $status = '<span class="badge orange lighten-1 black-text"><i class="material-icons left small" style="padding-top: 4px">launch</i> On-Going</span>';
            }

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $clientName . '</td>
                <td>' . $consignmentLocation . '</td>
                <td>' . $status . '</td>';
                echo '<td>'; number_format(getNumberCountedBagsPerClient($countedBy, $clientId)); echo '</td>
                <td>';
                    if ($confirmationDone == 'YES') {
                        echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                        View Confirmed Bags <i class="material-icons left">link</i>
                        </a>';
                    } else {
                        echo '<button data-target="addBag" style="margin: 6px; background: #6acef3 !important;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-client="' . $clientId . '">
                        Add Bag <i class="material-icons left">add</i>
                        </button>';
                        echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                        View Confirmed Bags <i class="material-icons left">link</i>
                        </a>';
                        echo '<button data-target="closeConfirmation" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-client="' . $clientId . '">
                        End Bundle Confirmation <i class="material-icons left">done_all</i>
                        </button>';
                    }
                echo '</td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$searchBCS.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
}

// Search Cash Allocation
if(isset($_POST["searchCA"])){

    require_once('../core/general-functions.php');

    $searchCAS   = filter_var($_POST['searchCAS'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchCA($searchCAS);
    }
}

// Search Cash Allocation Function
function searchCA($searchCAS)
{
    require('../core/db.php');

    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="cash-allocation">Click Here To View All</a></small></h5>';
    $sno = 1;
    $sortingValue = 0;
    $status = $evidence = $bankSealNumber = $transStream = '';
    $sql = " SELECT * FROM cashallocations WHERE workstation LIKE '%" . $searchCAS . "%' OR seal_number LIKE '%" . $searchCAS . "%' OR amount_allocated LIKE '%" . $searchCAS . "%' OR ca_shift LIKE '%" . $searchCAS . "%' OR fake_serial_numbers LIKE '%" . $searchCAS . "%' OR old_seal_number LIKE '%" . $searchCAS . "%' ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="caTable" class="display wrap" width="100%" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Client Code</th>
                    <th>Client Seal No</th>
                    <th>Stream</th>
                    <th>Teller Name</th>
                    <th>Work Station</th>
                    <th>Seal Number</th>
                    <th>Audit Trail Number</th>
                    <th>Den</th>
                    <th>State Of Cash
                    <th>Assigned Cash</th>
                    <th>Assigned By</th>
                    <th>Assigned On</th>
                    <th>Assigned Shift</th>
                    <th>Declared Value</th>
                    <th>Counted Value</th>
                    <th>Shortage</th>
                    <th>Fit</th>
                    <th>Unfit</th>
                    <th>ATM</th>
                    <th>Sorting Value</th>
                    <th>Sorting Shortage</th>
                    <th>Fake Notes (FN) </th>
                    <th>FN Serial Numbers </th>
                    <th>FN Value </th>
                    <th>Processor Comment</th>
                    <th>Attachement</th>
                    <th>Returned Cash</th>
                    <th>Post Sorting Value</th>
                    <th>Post Sorting Shortage</th>
                    <th>Sorting Unfit</th>
                    <th>Returned By</th>
                    <th>Returned On</th>
                    <th>Teller Comment</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $declaredValue = $row['amount_allocated'];

            $bUID = $row['id'].'------'.$row['allocated_by'].'------el';
            $caUID = base64_encode($bUID);
            
            // Get Teller Data
            $getTellerData          = getUserProfileId($row['allocated_to']);
            $tellerFullName         = $getTellerData['surname'].' '.$getTellerData['firstname'].' '.$getTellerData['middlename'];
            $tellerId               = $getTellerData['username'].'------'.$getTellerData['email'].'------el';
            $tellerUID              = base64_encode($tellerId);
            // Get Allocator Data
            $getAllocatorData       = getUserProfileId($row['allocated_by']);
            $allocatorFullName      = $getAllocatorData['surname'].' '.$getAllocatorData['firstname'].' '.$getAllocatorData['middlename'];
            $allocatorId            = $getAllocatorData['username'].'------'.$getAllocatorData['email'].'------el';
            $allocatorUID           = base64_encode($tellerId);
            //Split and get main seal number
            $sealPieces             = explode("-", $row['seal_number']);
            $tymeStamp              = $sealPieces[0];
            $sealNumber             = $sealPieces[1];
            // Split Bank Seal Number
            if ( $row['old_seal_number'] != '' ) {
                $sealPiecess        = explode("-", $row['old_seal_number']);
                $tymeStamps         = $sealPiecess[0];
                $bankSealNumber     = $sealPiecess[1];
                $transStream        = 'CBN';
            }
            //get denomination
            $reqDenomination        = getDenominationId($row['denomination_id']);
            $denomination           = $reqDenomination['denomination_name'];
            // Get ReturnedBy Data
            $getReturnedByData      = getUserProfileId($row['returned_by']);
            $returnedByFullName     = $getReturnedByData['surname'].' '.$getReturnedByData['firstname'].' '.$getReturnedByData['middlename'];
            $returnedById           = $getReturnedByData['username'].'------'.$getReturnedByData['email'].'------el';
            $returnedByUID          = base64_encode($tellerId);

            $retDate                = $row["returned_on"];
            if ($retDate == ''){
                $returnedOn = '';
            } else {
                $returnedOn = date("d/m/y", $retDate);
            }
            //get client name
            $reqClientName      = getClitnInfo($row['client_name']);
            $clientName         = $reqClientName['bank_name'];
            $clientNameCode     = $reqClientName['bank_code'];
            // Get State Of Cash (Cash Category)
            $getCategoryType    = getCategoryTypeId($row['state_of_cash']);
            $stateOfCash        = $getCategoryType['dc_name'];
            // Get Eviden
            if ( $row['evidence'] != '' ) {
                $evidence = '<img src="assets/images/attachments/'.$row['evidence'].'" width="100" />';
            } else {
                $evidence = '<img src="assets/images/attachments/noimage.png" width="100" />';
            }
            // Get Currencies
            $currency = $row['currency_id'];
            if ($currency == '1') {
                $currencyName = 'Nigerian Naira';
                $currencyIcon = '&#8358;';
            } else if ($currency == '2') {
                $currencyName = 'European Euro';
                $currencyIcon = '&euro;';
            } else if ($currency == '3') {
                $currencyName = 'US Dollars';
                $currencyIcon = '&#36;';
            } else if ($currency == '4') {
                $currencyName = 'British Pounds';
                $currencyIcon = '&#163;';
            } else if ($currency == '5') {
                $currencyName = 'South African Rand';
                $currencyIcon = 'R';
            } else if ($currency == '6') {
                $currencyName = 'Centra African Republic Franc';
                $currencyIcon = 'CFA';
            } else if ($currency == '7') {
                $currencyName = 'Chinese Yen';
                $currencyIcon = '&#165;';
            }
            
            /* Compute Counted Values
             * Formula: 
             * CountedValue = FitAmount + UnfitAmount + AtmAmount
             */
            $countedValue = $row['is_fit'] + $row['is_unfit'] + $row['is_atm'];

            /* Compute Mixup Values
             * Formula: 
             * MixUpsVAlues = Sum Of (m1000 -> m1)
             */
            $mixUpValue = $row['m1000'] + $row['m500'] + $row['m200'] + $row['m100'] + $row['m50'] + $row['m20'] + $row['m10'] + $row['m5'] + $row['m1'];

            /* Compute Fakenotes Values
             * Formula: 
             * FakenoteVAlues = fakenotePieces * denomination
             */
            $fakenotesValue = $row['fake_notes'] * $denomination;

            // Get Value Of Mixup And Fake Note
            $mixFnValue = ($row['fake_notes'] + $row['mixups']) * $denomination;

            /*
             * Sorting Unfit = unfit - $mixFnValue
            */
            $sortingUnfit = $row['is_unfit'] - $mixFnValue;

            /* Compute Sorting Value 
             * Formula:
             * SortingValue = $countedValue - $mixFnValue
            */
            $sortingValue = $countedValue - $mixFnValue;

            /* Compute Sorting Shortage
             * Formula: 
             * SortingShortage = CountedVAlue - SortingValue
             */
            $sortingShortage  = $countedValue - $sortingValue ;

            /* Compute Post Sorting Values
             * Formula: 
             * postSortingValue = $sortingValue + $mixUpValue
             */
            $postSortingValue = $sortingValue + $mixUpValue;

            /* Compute Post Sorting Shortage
             * Formula: 
             * postSortingShortage = $postSortingValue + Declared Value
             */
            $postSortingShortage = $postSortingValue - $declaredValue;
            
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $clientNameCode . '</td>
                <td>' . $bankSealNumber . '</td>
                <td>' . $transStream . '</td>
                <td><a href="profile?r=' . $getTellerData['username'].'cprf'.$tellerUID . '" target="_blank" style="color: #4f2323 !important;">' . $tellerFullName . '</a></td>
                <td>' . $row['workstation'] . '</td>
                <td>' . $sealNumber . '</td>
                <td>' . $row['audit_trail_number'] . '</td>
                <td>' . number_format($denomination) . '</td>
                <td>' . $stateOfCash . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($declaredValue) . '</td>
                <td><a href="profile?r=' . $getAllocatorData['username'].'cprf'.$allocatorUID . '" target="_blank" style="color: #4f2323 !important;">' . $allocatorFullName . '</a></td>
                <td>' . date("d/m/y", $row["allocated_on"]) . '</td>
                <td>' . $row['ca_shift'] . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['declared_value']) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($countedValue) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['shortage']) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_fit']) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_unfit']) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_atm']) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($sortingValue) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($sortingShortage) . '</td>
                <td>' . number_format($row['fake_notes']) . '</td>
                <td>' . $row['fake_serial_numbers'] . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($fakenotesValue) . '</td>
                <td>' . $row['comment'] . '</td>
                <td>' . $evidence . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['amount_returned']) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($postSortingValue) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($postSortingShortage) . '</td>
                <td>' . '<small>' . $currencyIcon . '</small>' . number_format($sortingUnfit) . '</td>
                <td><a href="profile?r=' . $getReturnedByData['username'].'cprf'.$returnedByUID . '" target="_blank" style="color: #4f2323 !important;">' . $returnedByFullName . '</a></td>
                <td>' . $returnedOn . '</td>
                <td>' . $row['ca_comment'] . '</td>
                <td>';
                    echo '<a href="cash-allocation-r?r=' . $row['ca_id'] . 'cprf' . $caUID.'" class="btns btns-read waves-effect waves-teal" style="color: teal !important;"><i class="material-icons left">edit</i> View </a>';
                echo '</td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$searchCAS.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
    echo '<script>
        $(document).ready(function() {
            $("#caTable").DataTable( {
                // "scrollY": 300,
                "scrollX": true
            })
        })
    </script>';
}

// Search Sealed Containers
if(isset($_POST["searchSCS"])){

    require_once('../core/general-functions.php');

    $searchSCSS   = filter_var($_POST['searchSCSS'], FILTER_SANITIZE_STRING);

    if( !$error ) {
        searchSCS($searchSCSS);
    }
}
// Search Sealed Containers Function
function searchSCS($searchSCSS)
{
    require('../core/db.php');

    echo '<div class="card">';
        echo '<div class="card-content">';
            echo '<h5>Search Result &nbsp; &nbsp; <small><a href="sealings">Click Here To View All</a></small></h5>';
    $sno = 1;
    $oldSealNumber = '';
    $sql = " SELECT * FROM sealings WHERE sealing_title LIKE '%" . $searchSCSS . "%' OR amount LIKE '%" . $searchSCSS . "%' OR seal_number LIKE '%" . $searchSCSS . "%' OR is_opened LIKE '%" . $searchSCSS . "%' OR total_amount_allocated LIKE '%" . $searchSCSS . "%' OR old_seal_number LIKE '%" . $searchSCSS . "%' ORDER BY s_id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Location</th>
                    <th>Category</th>
                    <th>Container</th>
                    <th>Currency</th>
                    <th>Denomination</th>
                    <th>Amount</th>
                    <th>Old Seal No</th>
                    <th>Seal No</th>
                    <th>Opened?</th>
                    <th>Sealed By</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Location</th>
                    <th>Category</th>
                    <th>Container</th>
                    <th>Currency</th>
                    <th>Denomination</th>
                    <th>Amount</th>
                    <th>Old Seal No</th>
                    <th>Seal No</th>
                    <th>Opened?</th>
                    <th>Sealed By</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            //get client name
            $reqClientName          = getClitnInfo($row['client']);
            $clientName             = $reqClientName['bank_name'];
            //get consignement 
            $reqConsLoc             = getConsignmentLocationById($row['location_id']);
            $consignmentLocation    = $reqConsLoc['location_name'];
            // Get Cash Category
            $getCategoryType        = getCategoryTypeId($row['category_id']);
            $cashCategory           = $getCategoryType['dc_name'];
            //Split and get main seal number
            if ( $row['old_seal_number'] != '' ) {
              $sealPiecess            = explode("-", $row['old_seal_number']);
              $tymeStamps             = $sealPiecess[0];
              $oldSealNumber          = $sealPiecess[1];
            }
            //Split and get main seal number
            $sealPieces             = explode("-", $row['seal_number']);
            $tymeStamp              = $sealPieces[0];
            $sealNumber             = $sealPieces[1];
            // Get Container Name
            $getContainerType       = getContainerTypes($row['container_id']);
            $containerType          = $getContainerType['ct_name'];
            // Get Currency Type Name
            $getCurrency            = getCurrencyId($row['currency_id']);
            $currencyType           = $getCurrency['currency_name'];
            // Get Currency Type Name
            $getDenomination        = getDenominationId($row['denomination_id']);
            $denominationType       = $getDenomination['denomination_name'];
            // Get Sealing Officer Data
            $getCitData             = getUserProfileId($row['added_by']);
            $getCitFullname         = $getCitData['surname'].' '.$getCitData['firstname'].' '.$getCitData['middlename'];
            $getCitId               = $getCitData['username'].'------'.$getCitData['email'].'------el';
            $citUID                 = base64_encode($getCitId);

            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['sealing_title'] . '</td>
                <td>' . $clientName . '</td>
                <td>'. $consignmentLocation .'</td>
                <td>'. $cashCategory .'</td>
                <td>'. $containerType .'</td>
                <td>'. $currencyType .'</td>
                <td>'. $denominationType .'</td>
                <td>'. number_format($row['amount']) .'</td>
                <td>'. $oldSealNumber .'</td>
                <td>'. $sealNumber .'</td>
                <td>'. $row['is_opened'] .'</td>
                <td><a href="profile?r=' . $getCitData['username'].'cprf'.$citUID  . '" target="_blank" style="color: #4f2323 !important;">' . $getCitFullname . '</a></td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo '<p>Your search for client -  &nbsp; <strong>'.$searchSCSS.'</strong> &nbsp;  - did not match any documents.</p>';
        echo '<p>Suggestions: </p>';
        echo '<ul class="custom-counter">';
            echo '<li>Make sure that all words are spelled correctly.</li>';
            echo '<li>Try different keywords.</li>';
            echo '<li>Try more general keywords.</li>';
            echo '<li>Try fewer keywords</li>';
        echo '</ul>';

    }
        echo '</div>';
    echo '</div>';
    echo '<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"><!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>';
}

// getDenominationById
function getDenominationId($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM denominations WHERE denomination_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
// getCategoryTypeById
function getUserProfileId($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM users WHERE username = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
// getCategoryTypeById
function getCategoryTypeId($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM deposit_category WHERE dc_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
// Get Client Info
function getClitnInfo($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM banks WHERE id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
// getConsignmentLocationById
function getConsignmentLocationById($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM consignment_locations WHERE location_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}// Get Bundle Confirmation Start
function getBundleConfirmationZtart($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM bundle_confirmation_start WHERE client_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
// Get Number Of Added Bags Per Client ID
function getNumberCountedBagsPerClient($username, $reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $sql = "SELECT * FROM cit WHERE ev_req_id = '$reqId' AND bundle_confirmed_by = '$username' ";
  $result = $con->query($sql);
  echo $result->num_rows;
}
// getContainerType
function getContainerTypes($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM container_types WHERE ct_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}
// getCurrencyById
function getCurrencyId($reqId)
{
  // Add DB Connection
  require('../core/db.php');
  $q = "SELECT * FROM currencies WHERE currency_id = '$reqId'";
  $result = mysqli_query($con, $q);
  /* Error occurred, return given name by default */
  if(!$result || (mysqli_num_rows($result) < 1)){
     return NULL;
  }
  /* Return result array */
  $dbarray = mysqli_fetch_array($result);
  return $dbarray;
}