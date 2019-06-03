<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/bundle-confirmation.php';
include 'app/core/session.php';
$pagename = 'Bundle Confirmation';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isCPA() ||  $session->isCPS() || $session->isTreasuryOfficer() || $session->isTreasurySup()) {
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
                <!--start container-->
                <div class="container">
                    <div class="section">
                        
                        <?php
                            $clientId = $bcId = '';
                            if (bundleConfirmationStatus($username)){
                                echo '';
                                $sql = "SELECT * FROM bundleconfirmations WHERE confirmation_done = 'NO' ";
                                $result = $con->query($sql);
                                if ($result->num_rows == 1) {
                                    while ($row = $result->fetch_assoc()) {
                                        $bcId = $row['id'];
                                        $clientId = $row['client_id'];
                                        // echo '<div class="row"><div class="col s12"><div class="right">';
                                        //     echo '<a href="bundle-confirmation-bag?r=' . $row['client_id'].'cprf'.$bankUID .'" class="btns btns-add waves-effect waves-light" style="color: white !important; margin: 6px !important; background: #6acef3 !important;">
                                        //     Add Bag <i class="material-icons left">add</i>
                                        //     </a>';
                                        // echo '</div></div></div>';
                                    }
                                }
                            } else { ?>
                            <div class="row">
                                <div class="col s12">
                                    <div class="right">
                                        <button data-target="startBundleConfirmation" class="btns btns-add waves-effect waves-teal modal-trigger">
                                            <i class="material-icons left">add</i> Start Bundle Confirmation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <h6 class="header center blue-grey-text uppercase">
                                            Bundle Confirmation Table <small class="black-text">Use The Search Form To Sort / Filter The Records.</small>
                                        </h6>
                                        <?php
                                            $sno = 1;
                                            $status = '';
                                            $sql = "SELECT * FROM bundleconfirmations  ORDER BY id DESC";
                                            $result = $con->query($sql);
                                        
                                            if ($result->num_rows > 0) {
                                                $totalBags = 0;
                                                echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                                echo '<thead>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Title</th>
                                                            <th>Client</th>
                                                            <th>Stream</th>
                                                            <th>Consignment Location</th>
                                                            <th>Confirmation Status</th>
                                                            <th>Reference No</th>
                                                            <th>Bundle Conf. By</th>
                                                            <th class="width-20">ACTIONS</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Title</th>
                                                            <th>Client</th>
                                                            <th>Stream</th>
                                                            <th>Consignment Location</th>
                                                            <th>Confirmation Status</th>
                                                            <th>Reference No</th>
                                                            <th>Bundle Conf. By</th>
                                                            <th>ACTIONS</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>';
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $clientId = $row['client_id'];
                                                    //get client name
                                                    $reqClientName      = getClientNameById($clientId);
                                                    $clientName         = $reqClientName['bank_name'];
                                                    $clientCode         = $reqClientName['bank_code'];
                                                    //get consignement 
                                                    $reqConsLoc             = getConsignmentLocationById($row['conslocation']);
                                                    $consignmentLocation    = $reqConsLoc['name'];
                                                    $consignmentLocationId  = $reqConsLoc['id'];
                                        
                                                    $bUID = $row['id'].'------'.$clientName.'------'.$clientId.'------'.$row['strim'].'------'.$clientCode;
                                                    $bankUID = base64_encode($bUID);
                                        
                                                    $cbUID = $row['id'].'------'.$row['added_by'].'------'.$clientId;
                                                    $cbbUID = base64_encode($cbUID);
                                        
                                                    $countedBy = $row['added_by'];
                                                    //Get Work Status
                                                    if ($row['confirmation_done'] == 'YES') {
                                                        $status = '<div class="fully-done"><i class="material-icons left small" style="padding-top: 4px">done_all</i> Completed</div>';
                                                    } else {
                                                        $status = '<div class="half-done"><i class="material-icons left small" style="padding-top: 4px">launch</i> On-Going</div>';
                                                    }
                                        
                                                    echo '<tr>
                                                        <td>' . $sno++ . '</td>
                                                        <td>' . $row['bc_title'] . '</td>
                                                        <td>' . $clientName . '</td>
                                                        <td>' . $row['strim'] . '</td>
                                                        <td>' . $consignmentLocation . '</td>
                                                        <td>' . $status . '</td>
                                                        <td>' . $clientCode.$row['id'] . '</td>
                                                        <td>' . $row['added_by'] . '</td>
                                                        <td>';
                                                            if ($row['confirmation_done'] == 'YES') {
                                                                echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-red" style="color: teal !important; margin: 3px !important;">View Confirmed Bags <i class="material-icons left">link</i></a>';
                                                                echo 'Bundle Confirmation Closed';
                                                            } else {
                                                                echo '<a href="bundle-confirmation-bags?r=' . $row['added_by'].'cprf'.$bankUID .'" style="margin: 6px;" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">View Confirmed Bags <i class="material-icons left">link</i></a>';
                                                                echo '<a href="bundle-confirmation-bag?r=' . $row['client_id'].'cprf'.$bankUID .'" class="btns btns-add waves-effect waves-light" style="color: white !important; margin: 6px !important; background: #283593 !important;">
                                                                Add Bag <i class="material-icons left">add</i>
                                                                </a>';
                                                                if ( hasExceptionUser($username) ) {
                                                                    echo '<br>You Have Pending Exceptions'; 
                                                                } else {
                                                                    if ( $row['added_by'] == $username )
                                                                    echo '<button data-target="closeConfirmation" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-bcsid="' . $row['id'] . '">
                                                                    End Bundle Confirmation <i class="material-icons left">done_all</i>
                                                                    </button>';
                                                                }
                                                            }
                                                        echo '</td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                </table>';
                                            } else {
                                                echo 'No record found.';
                                            }
                                        ?>
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

    <!-- Start Modal -->
    <div id="startBundleConfirmation" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Start New Bundle Confirmation</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding. You can only have one active bundle confirmation at a time.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12">
                        <input type="text" name="bcTitle" id="bcTitle" required>
                        <label>Bundle Confirmation Title</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="clientName">
                            <?php getBanksList(); ?>
                        </select>
                        <label>Client Name</label>
                    </div>
                    <input type="hidden" name="conslocation" id="conslocation" value="<?php echo $signed_location_id; ?>">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="strim">
                            <option value=""> Select The Bundle Confirmation Stream </option>
                            <option value="CBN"> CBN Bundle Confirmation Stream </option>
                            <option value="Others"> General Bundle Confirmation Stream </option>
                        </select>
                        <label>Confirmation Stream</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text startBundleConfirmation mr-3">
                <i class="material-icons right">send</i>
                Start Bundle Confirmation 
            </button>
        </div>
    </div>

    <!-- Close Bundle Confirmation Modal -->
    <div id="closeConfirmation" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">End This Bundle Confirmation</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12 uppercase">
                        <h6 class="black-text">This Step Is Not Reversible</h6>
                        <p class="red-text">Do Your Really Want To End This Bundle Confirmation?</p>
                    </div>
                    <input type="hidden" name="bcsidId" id="bcsidId">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-teal teal white-text endThisBundleConfirmation mr-3">
                <i class="material-icons left">done_all</i>
                YES END THIS BUNDLE CONFIRMATION 
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

    <script type="text/javascript" src="assets/js/pages/bundle-confirmation.js"></script>

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