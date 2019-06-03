<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/evacuation-schedule.php';
include 'app/core/session.php';
$pagename = 'Evacuation Schedule';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin()) {

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
                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content" style="min-height: 500px;">

                                        <div class="row">
                                            <div class="col s12">
                                                <div class="card">
                                                    <div class="card-content">
                                                        <?php
                                                            $sno = 1;
                                                            $sql = "SELECT * FROM bank_requests WHERE preannounced = 'NO' ORDER BY er_id DESC";
                                                            $result = $con->query($sql);
                                                        
                                                            if ($result->num_rows > 0) {
                                                                echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                                                echo '<thead>
                                                                        <tr>
                                                                            <th>S/No</th>
                                                                            <th>Request Title</th>
                                                                            <th>Client</th>
                                                                            <th>Branch Location</th>
                                                                            <th>Destination</th>
                                                                            <th>Prepared</th>
                                                                            <th class="width-25">ACTIONS</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>S/No</th>
                                                                            <th>Request Title</th>
                                                                            <th>Client</th>
                                                                            <th>Branch Location</th>
                                                                            <th>Destination</th>
                                                                            <th>Prepared</th>
                                                                            <th>ACTIONS</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                    <tbody>';
                                                                // output data of each row
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $bUID = $row['er_id'].'------'.$row['er_slug'].'------el';
                                                                    $bankUID = base64_encode($bUID);
                                                                    //get client name
                                                                    $reqClientName      = getClientNameById($row['bank_id']);
                                                                    $clientName         = $reqClientName['bank_name'];
                                                                    //get consignement 
                                                                    $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
                                                                    $consignmentLocation    = $reqConsLoc['location_name'];
                                                        
                                                                    $citConfirmationToken = $row['er_id'] . 'cittoken18' . time() . 'cittoken18' . $row['bank_id'];
                                                        
                                                                    echo '<tr>
                                                                        <td>' . $sno++ . '</td>
                                                                        <td><a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['er_name'] . '</a></td>
                                                                        <td>' . $clientName . '</td>
                                                                        <td>' . $row['location_code'] . '</td>
                                                                        <td>'. $consignmentLocation .'</a></td>';
                                                                        echo '<td><strong>'; number_format(getNumberPreparedBagsPerRequest($row['er_id'])); echo '</strong> Bag(s)</td>
                                                                        <td>
                                                                            <a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                                                                                View  <i class="material-icons left">link</i>
                                                                            </a>
                                                                            ';
                                                                            if ($row['cp_done'] == 'NO') {
                                                                                echo '<a href="evacuation-request-p?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-edit waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                                                                Prepare Cash <i class="material-icons left">local_mall</i>
                                                                                </a>';
                                                                            }
                                                                            if ($session->isSuperAdmin() || $session->isBankerCmu()) {
                                                                            if ( $row['cit_confirmation'] == 'NOT RECEIVED' ) {
                                                                                echo '<a href="evacuation-request-e?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns light-blue waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                                                                Edit Request <i class="material-icons left">edit</i>
                                                                                </a>';
                                                                                }
                                                                            }
                                                                            if ( $row['cit'] == 'NO' && bagExists($row['er_id']) ) {
                                                                                echo '<button data-target="hoc" class="btns btns-add waves-effect waves-teal cho modal-trigger" data-id="' . $row['er_id'].'" data-name="' . $row['er_name'].'" data-ctokn="' . $citConfirmationToken.'"><i class="material-icons left">rv_hookup</i> Hand Over Consignment </button>';
                                                                            }
                                                                            echo '
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo '</tbody>
                                                                </table>';
                                                            } else {
                                                                echo 'No request found. <a href="evacuation-request-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Request</a>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

    <?php include 'layouts/foot.php'; ?>

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/evacuation-schedule.js"></script>

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