<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/cash-allocation.php';
include 'app/core/session.php';
$pagename = 'Cash Processings';
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
                                    <div class="card-content">
                                        <div class="row" style="border-bottom: 2px solid #af0000; margin-bottom: 20px; padding-bottom: 10px;">
                                            <div class="col l9 m9 s12">
                                                <h6 class="center blue-grey-text uppercase">
                                                    Cash Processing Table <small class="black-text">Use The Search Form To Sort / Filter The Records. </small>
                                                </h6>
                                            </div>
                                            <div class="col l3 m3 s12">
                                                <div class="right">
                                                    <form method="post" action="app/pf/cash-processing.php">
                                                        <button type="submit" class="btns btns-delete waves-effect waves-red" name="export_excel" style="color: white !important;">
                                                        <i class="material-icons left">file_download</i> EXPORT TO EXCEL 
                                                    </button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        $sno = 1;
                                        $status = $evidence = '';
                                        $sql = "SELECT * FROM cash_allocations ORDER BY ca_id DESC";
                                        $result = $con->query($sql);
                                    
                                        if ($result->num_rows > 0) {
                                            echo '<table id="caTable" class="display wrap" width="100%" cellspacing="0">';
                                            echo '<thead>
                                                    <tr>
                                                        <th>S/No</th>
                                                        <th>Teller Name</th>
                                                        <th>Work Station</th>
                                                        <th>Teller Number</th>
                                                        <th>Client Name</th>
                                                        <th>Audit Trail Number</th>
                                                        <th>Denomination</th>
                                                        <th>Assigned Cash</th>
                                                        <th>Assigned By</th>
                                                        <th>Assigned On</th>
                                                        <th>Assigned Shift</th>
                                                        <th>Returned By</th>
                                                        <th>Returned On</th>
                                                        <th>Teller Comment</th>
                                                        <th>Fit</th>
                                                        <th>Unfit</th>
                                                        <th>ATM</th>
                                                        <th>Fake Notes </th>
                                                        <th>Shortage</th>
                                                        <th>Post Sorting Value</th>
                                                        <th>Declared Value</th>
                                                        <th>Counted Value</th>
                                                        <th>Processor Comment</th>
                                                        <th>Attachement</th>
                                                        <th>Returned Cash</th>
                                                        <th>Difference</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                $bUID = $row['ca_id'].'------'.$row['allocated_by'].'------el';
                                                $caUID = base64_encode($bUID);
                                                
                                                // Get Teller Data
                                                $getTellerData          = $database->getUserInfo($row['allocated_to']);
                                                $tellerFullName         = $getTellerData['surname'].' '.$getTellerData['firstname'].' '.$getTellerData['middlename'];
                                                $tellerId               = $getTellerData['username'].'------'.$getTellerData['email'].'------el';
                                                $tellerUID              = base64_encode($tellerId);
                                                // Get Allocator Data
                                                $getAllocatorData       = $database->getUserInfo($row['allocated_by']);
                                                $allocatorFullName      = $getAllocatorData['surname'].' '.$getAllocatorData['firstname'].' '.$getAllocatorData['middlename'];
                                                $allocatorId            = $getAllocatorData['username'].'------'.$getAllocatorData['email'].'------el';
                                                $allocatorUID           = base64_encode($tellerId);
                                                //Split and get main seal number
                                                $sealPieces             = explode("-", $row['seal_number']);
                                                $tymeStamp              = $sealPieces[0];
                                                $sealNumber             = $sealPieces[1];
                                                //get denomination
                                                $reqDenomination        = getDenominationById($row['denomination_id']);
                                                $denomination           = $reqDenomination['denomination_name'];
                                                // Get ReturnedBy Data
                                                $getReturnedByData      = $database->getUserInfo($row['returned_by']);
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
                                                $reqClientName      = getClientNameById($row['client_name']);
                                                $clientName         = $reqClientName['bank_name'];
                                                // Get Eviden
                                                if ( $row['evidence'] != '' ) {
                                                    $evidence = '<img src="assets/images/attachments/'.$row['evidence'].'" />';
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
                                                
                                                echo '<tr>
                                                    <td>' . $sno++ . '</td>
                                                    <td><a href="profile?r=' . $getTellerData['username'].'cprf'.$tellerUID . '" target="_blank" style="color: #4f2323 !important;">' . $tellerFullName . '</a></td>
                                                    <td>' . $row['workstation'] . '</td>
                                                    <td>' . $sealNumber . '</td>
                                                    <td>' . $clientName . '</td>
                                                    <td>' . $row['audit_trail_number'] . '</td>
                                                    <td>' . number_format($denomination) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['amount_allocated']) . '</td>
                                                    <td><a href="profile?r=' . $getAllocatorData['username'].'cprf'.$allocatorUID . '" target="_blank" style="color: #4f2323 !important;">' . $allocatorFullName . '</a></td>
                                                    <td>' . date("d/m/y", $row["allocated_on"]) . '</td>
                                                    <td>' . $row['ca_shift'] . '</td>
                                                    <td><a href="profile?r=' . $getReturnedByData['username'].'cprf'.$returnedByUID . '" target="_blank" style="color: #4f2323 !important;">' . $returnedByFullName . '</a></td>
                                                    <td>' . $returnedOn . '</td>
                                                    <td>' . $row['ca_comment'] . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_fit']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_unfit']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['is_atm']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['fakenotes']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['shortage']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['post_sorting_value']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['declared_value']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['counted_value']) . '</td>
                                                    <td>' . $row['comment'] . '</td>
                                                    <td>' . $evidence . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['amount_returned']) . '</td>
                                                    <td>' . '<small>' . $currencyIcon . '</small>' . number_format($row['difference']) . '</td>
                                                    <td>';
                                                        echo '<a href="cash-processing-r?r=' . $row['ca_id'] . 'cprf' . $caUID.'" class="btns btns-read waves-effect waves-teal" style="color: teal !important;"><i class="material-icons left">edit</i> View </a>';
                                                    echo '</td>
                                                </tr>';
                                            }
                                            echo '</tbody>
                                            </table>';
                                        } else {
                                            echo 'No record found.';
                                        }
                                        $con->close();
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

    <script type="text/javascript" src="assets/js/pages/cash-allocation.js"></script>

    <script>
        $(document).ready(function() {
            $('#caTable').DataTable( {
                // "scrollY": 300,
                "scrollX": true
            })
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