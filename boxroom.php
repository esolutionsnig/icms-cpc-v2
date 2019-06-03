<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/boxroom.php';
include 'app/core/session.php';
$pagename = 'Box Room';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ) {

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
                            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                            <div class="col l8 m8 s12">
                                <div class="card">
                                    <div class="card-content">
                                        <div>
                                            <h5 class="header">
                                                <strong class="uppercase blue-grey-text">Pre-Manifest Table</strong>
                                            </h5>
                                        </div>
                                        <?php getPreManifest(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col l4 m4 s12">
                                <div class="card">
                                    <div class="card-content">
                                        <div>
                                            <h5 class="header">
                                                <strong class="uppercase blue-grey-text">Consignment Acceptance </strong>
                                            </h5>
                                        </div>
                                        <?php
                                        $sno = $sn = 1;
                                        $moveStatus = $deliveryStatus = '';
                                        $sql = "SELECT * FROM cits WHERE delivery_status = 'Sent To Boxroom, Awaiting Confirmation' GROUP BY seal_number ORDER BY id DESC";
                                        $result = $con->query($sql);
                                    
                                        if ($result->num_rows > 0) {
                                            echo '<table id="caTable" class="responsive-table display" cellspacing="0">';
                                            echo '<thead>
                                                    <tr>
                                                        <th class="width-5">S/No</th>
                                                        <th>Seal Number</th>
                                                        <th>Movement Status</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>S/No</th>
                                                        <th>Seal Number</th>
                                                        <th>Movement Status</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>';
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $seal_number = $row['seal_number'];
                                                    //Split and get main seal number
                                                    $sealPieces             = explode("-", $seal_number);
                                                    $tymeStamp              = $sealPieces[0];
                                                    $sealNumber             = $sealPieces[1];
                                                    // Confirm If Item Was Accepted Or Not 
                                                    if ( $row['delivery_status'] == 'Sent To Boxroom, Awaiting Confirmation') {
                                                        $moveStatus = 'half-done';
                                                        $deliveryStatus = 'Awaiting Confirmation';
                                                    } else {
                                                        $moveStatus = 'fully-done';
                                                        $deliveryStatus = 'Received At Box';
                                                    }
                                                    echo '<tr>
                                                        <td><input type="checkbox" name="choseme" id="choseme' . $sn++ . '" value="' . $seal_number . '" class="iSelected" /><label for="choseme' . $sno++ . '"></label></td>
                                                        <td><strong class="teal-text">' . $sealNumber . '</strong></td>
                                                        <td><div class="'. $moveStatus .'">' . $deliveryStatus . '</div></td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                </table>';
                                                echo '<div class="row">
                                                    <div class="col s12">
                                                        <div class="center" style="margin-top: 30px">
                                                            <h6 class="uppercase deepred-text">Warning: Ensure You Have The Selected Bags In Your Custody Before Confirming</h6>
                                                            <button class="btn teal waves-effect waves-light white-text confirmSelectedBags">
                                                                <i class="material-icons left">done_all</i> 
                                                                Confirm <strong id="totalSelected"></strong> Seal NUmbers 
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>';
                                            } else {
                                                echo 'No Pending Request';
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

    <?php include 'layouts/foot.php'; ?>

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/boxroom.js"></script>

    <script>
        $(document).ready(function() {
            $('#caTable').DataTable()
        })
    </script>

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