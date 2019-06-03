<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/internal-movement.php';
include 'app/core/session.php';
$pagename = 'Internal Movement';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ( $session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive() || $session->isCPO() ) {

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layouts/e.php'; ?>

<head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
</head>

<body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->

    <!-- START HEADER -->
    <?php include 'layouts/header.php'; ?>
    <!-- END HEADER -->

    <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">

            <!-- START LEFT SIDEBAR NAV-->
            <?php include 'layouts/left_sidenav.php'; ?>
            <!-- END LEFT SIDEBAR NAV-->

            <!-- START CONTENT -->
            <section id="content">
                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <!-- Search for small screen -->
                    <?php include 'layouts/searchSmallScreen.php'; ?>
                    <div class="container">
                        <div class="row">
                            <div class="col s10 m8 l8">
                                <h5 class="breadcrumbs-title">
                                    <?php echo $pagename; ?>
                                </h5>
                                <ol class="breadcrumbs">
                                    <li><a href="./">Dashboard</a></li>
                                    <li class="active">
                                        <?php echo $pagename; ?>
                                    </li>
                                </ol>
                            </div>
                            <div class="col s2 m4 l4">
                                <?php include 'layouts/liveClock.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->
                <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                <!--start container-->
                <div class="container">
                    <div class="section">
                        
                    <div class="row">
                        <div class="col s12">
                            <div class="right">
                                <button class="btns btns-add waves-effect waves-teal newMovements">
                                    <i class="material-icons left">add</i> Move Consignments 
                                </button>
                            </div>
                        </div>
                    </div>

                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <h6 class="header center blue-grey-text uppercase">
                                            Internal Movement Table <small class="black-text">Use The Search Form To Sort / Filter The Records.</small>
                                        </h6>
                                        <?php 
                                            // Get Signed In Location ID
                                            $lr = getConsignmentLocationByName($signedInLocation);
                                            $locationId = $lr['id'];

                                            $sn = $sno = 1;
                                            $moveStatus = '';
                                            $sql = "SELECT * FROM internalmovements WHERE destination_location = '$locationId' AND is_opened = 'NO' GROUP BY seal_number ORDER BY id DESC";
                                            $result = $con->query($sql);

                                            if ($result->num_rows > 0) {
                                                echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                                echo '<thead>
                                                        <tr>
                                                            <th class="width-5">S/No</th>
                                                            <th>Seal Number</th>
                                                            <th>Previous Location</th>
                                                            <th>Current Location</th>
                                                            <th>Sent By</th>
                                                            <th>Received By</th>
                                                            <th>Movement Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Seal Number</th>
                                                            <th>Previous Location</th>
                                                            <th>Current Location</th>
                                                            <th>Sent By</th>
                                                            <th>Received By</th>
                                                            <th>Movement Status</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>';
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $seal_number = $row['seal_number'];
                                                    $received_by = $row['received_by'];
                                                    //Split and get main seal number
                                                    $sealPieces             = explode("-", $seal_number);
                                                    $tymeStamp              = $sealPieces[0];
                                                    $sealNumber             = $sealPieces[1];
                                                    //get consignement source location
                                                    $reqConsSource          = getConsignmentLocationById($row['source_location']);
                                                    $sourceLocation         = $reqConsSource['name'];
                                                    //get consignement destination location
                                                    $reqConsDestination     = getConsignmentLocationById($row['destination_location']);
                                                    $destinationLocation    = $reqConsDestination['name'];
                                                    // Confirm If Item Was Accepted Or Not 
                                                    if ( $row['movement_status'] == 'Pending') {
                                                        $moveStatus = 'half-done';
                                                    } else if( $row['movement_status'] == 'Rejected' ) {
                                                        $moveStatus = 'fully-rejected';
                                                    } else {
                                                        $moveStatus = 'fully-done';
                                                    }

                                                    echo '<tr>
                                                        <td><input type="checkbox" name="choseme" id="choseme' . $sn++ . '" value="' . $seal_number . '" class="iSelected" /><label for="choseme' . $sno++ . '"></label></td>
                                                        <td><strong class="teal-text">' . $sealNumber . '</strong></td>
                                                        <td>' . $sourceLocation . '</td>
                                                        <td>' . $destinationLocation . '</td>
                                                        <td>' . $row['added_by'] . '</td>
                                                        <td>' . $received_by . '</td>
                                                        <td><div class="'. $moveStatus .'">' . $row['movement_status'] . '</div></td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                </table>';
                                                if ( $destinationLocation == $signedInLocation ) {
                                                    echo '<div class="row">
                                                        <div class="col s12 center" style="margin-top: 30px">
                                                            <h6 class="uppercase deepred-text">Warning: Ensure You Have The Total Of <strong id="totalSelected"></strong> Selected Bags In Your Custody Before Proceeding</h6>
                                                        </div>
                                                    </div>';
                                                    echo '<div class="row">
                                                        <div class="col l4 m4 s12">
                                                            <div class="center" style="margin-top: 30px">
                                                                <button data-target="rejectBags" class="btn primary-btn waves-effect waves-light white-text modal-trigger">
                                                                    <i class="material-icons left">done_all</i> 
                                                                    Reject Selected Bags 
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col l4 m4 s12">
                                                            <div class="center" style="margin-top: 30px">
                                                                <button data-target="acceptBags" class="btn teal waves-effect waves-light white-text modal-trigger">
                                                                    <i class="material-icons left">done_all</i> 
                                                                    Accept Selected Bags 
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col l4 m4 s12">
                                                            <div class="center" style="margin-top: 30px">
                                                                <button data-target="moveBags" class="btn cyan waves-effect waves-light white-text modal-trigger">
                                                                    <i class="material-icons left">done_all</i> 
                                                                    Move Selected Bags 
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                }
                                            } else {
                                                echo 'No record found. <button class="btns btns-read waves-effect waves-teal newMovements ml-3"><i class="material-icons left">add</i> Move Consignments </button>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col l6 m6 s12">
                                <div class="card">
                                    <div class="card-content" style="min-height: 400px;">
                                        <h6 class="header blue-grey-text center uppercase">
                                            Information
                                        </h6>
                                        <ul class="collection">
                                            <li class="collection-item">Select The Source Location (i.e Where The Consignment Is Coming From)</li>
                                            <li class="collection-item">Select The Destination Location (i.e Where The Consignment Is Going To)</li>
                                            <li class="collection-item">Start Typing The Seal Number And Select The Matched Seal Number</li>
                                            <li class="collection-item">To Remove Seal Numbers, Click The Remove Button or X Icon Beside The Seal Number To Automatically Remove The Seal Number. Your As Well Re-Select It To Remove It</li>
                                            <li class="collection-item">Click The Move Consignment Button To Save Changes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col l6 m6 s12" id="moveConsignments">
                                <div class="card">
                                    <div class="card-content" style="min-height: 400px;">

                                        <h6 class="header center blue-grey-text uppercase">
                                            Internal Movement Form <small class="red-text">Ensure You Confirm The Seal Number Before Send The Consignment</small>
                                        </h6>

                                        <div class="row margin">
                                            <div class="input-field col s12">
                                                <input type="hidden" id="sourceLocation" value="<?php echo $locationId; ?>">
                                            </div>
                                        </div>
                                        <div class="row margin">
                                            <div class="input-field col s12">
                                                <small for="destinationLocation">Destination Location</small>
                                                <select id="destinationLocation" class="searchableSelect">
                                                    <option value="">Which Location Are You Moving This Consignment To?</option>
                                                    <?php getConsignmentLocationsList(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row margin" id="sealRow">
                                            <div class="input-field col s12">
                                                <small>Seal Numbers (Select preferred seal number)</small>
                                                <select multiple id="sealNumbers" class="searchableSelect">
                                                    <?php getListOfSealNUmbersCL($locationId, $username); ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <h5>&nbsp;</h5>

                                        <div class="row margin">
                                            <div class="input-field col s12 center">
                                                <button class="btn waves-effect waves-light teal white-text moveToNewLocation">
                                                    <i class="material-icons right">send</i>
                                                    Move Consignments
                                                </button>
                                            </div>
                                        </div>

                                        <span id="ishere" tabindex='1'></span>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!--end container-->
            </section>
            <!-- END CONTENT -->

            <!-- START RIGHT SIDEBAR NAV-->
            <?php include 'layouts/right_sidenav.php'; ?>
            <!-- END RIGHT SIDEBAR NAV-->

        </div>
        <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->

    <!-- START FOOTER -->
    <?php include 'layouts/footer.php'; ?>
    <!-- END FOOTER -->

    <!-- Accept Modal -->
    <div id="moveBags" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Move Consignment To New Location</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="sealNumberCurrentLocation" name="sealNumberCurrentLocation" type="text" class="validate sealNumberCurrentLocation" required autocomplete="off" readonly value="<?php echo $signedInLocation; ?>">
                        <label for="sealNumberCurrentLocation">Current Location (Source Location)</label>
                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                        <input type="hidden" id="sealNumberCurrentLocationCode" value="<?php echo $locationId; ?>">
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <small>Destination Location</small>
                        <select id="sealNumberDestinationLocation" class="searchableSelect">
                            <option value="">Which Location Are You Moving This Consignment To?</option>
                            <?php getConsignmentLocationsList(); ?>
                        </select>
                    </div>
                </div>
                <div class="row margin" id="sealRow">
                    <input type="hidden" id="selectedSealNumbers">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text moveSelectedConsignments mr-3">
                <i class="material-icons right">send</i>
                Move Consignment(s) 
            </button>
        </div>
    </div>
    
    <div id="acceptBags" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Accept Consignments Sent To Your Locations</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12">
                        <h5 class="deepred-text uppercase">Ensure you have the right consignment in your custody before clicking the accept consignment button below</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text acceptSelectedConsignments mr-3">
                <i class="material-icons right">send</i>
                Accept Consignment(s) 
            </button>
        </div>
    </div>
    
    <div id="rejectBags" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Reject Consignments Sent To Your Locations</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12">
                        <h5 class="deepred-text uppercase">Ensure you have the right consignment in your custody before clicking the reject consignment button below</h5>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <small>Return Location</small>
                        <select id="returnLocation" class="searchableSelect">
                            <option value="">Which Location Are You Moving This Consignment To?</option>
                            <?php getConsignmentLocationsList(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light primary-btn white-text rejectSelectedConsignments mr-3">
                <i class="material-icons left">cancel</i>
                Reject Consignment(s) 
            </button>
        </div>
    </div>

    <?php include 'layouts/foot.php'; ?>

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/internal-movement.js"></script>

</body>

</html>
<?php
    
} else {
    header("Location: ./");
}
} else {
    header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>