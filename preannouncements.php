<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/preannouncements.php';
include 'app/core/session.php';
$pagename = 'Preannouncements';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ) {
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
                  <h5 class="breadcrumbs-title"><?php echo $pagename; ?></h5>
                  <ol class="breadcrumbs">
                    <li><a href="./">Dashboard</a></li>
                    <li class="active"><?php echo $pagename; ?></li>
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
                  <div class="right">
                    <a href="preannouncement-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> New Preannouncement </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      
                      <?php 
                        $sno = 1;
                        $totalAmountPrepared = 0;
                        $sql = "SELECT * FROM evacuations WHERE preannounced = 'YES' ORDER BY id DESC";
                        $result = $con->query($sql);
                    
                        if ($result->num_rows > 0) {
                            echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                            echo '<thead>
                                    <tr>
                                        <th>S/No</th>
                                        <th>Request Title</th>
                                        <th>Client</th>
                                        <th>Branch Location</th>
                                        <th>Destination</th>
                                        <th>Prepared</th>
                                        <th>Total Amount</th>
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
                                        <th>Total Amount</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </tfoot>
                                <tbody>';
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                                $bUID = $row['id'].'------'.$row['er_slug'].'------el';
                                $bankUID = base64_encode($bUID);
                                //get consignement 
                                $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
                                $consignmentLocation    = $reqConsLoc['name'];
                    
                                $citConfirmationToken = $row['id'] . 'cittoken18' . time() . 'cittoken18' . $row['bank_id'];
                                //get client name
                                $reqClientName      = getClientNameById($row['bank_id']);
                                $clientName         = $reqClientName['bank_name'];
                                // Get Total Amount Prepared
                                $totalAmountPrepared = getTotalAmountPreparedBagsPerRequest($row['id']);
                                echo '<tr>
                                    <td>' . $sno++ . '</td>
                                    <td>' . $row['er_name'] . '</td>
                                    <td>' . $clientName . '</td>
                                    <td>' . $row['location_code'] . '</td>
                                    <td>'. $consignmentLocation .'</a></td>';
                                    echo '<td><strong>'; number_format(getNumberPreparedBagsPerRequest($row['id'])); echo '</strong> Bag(s)</td>
                                    <td><h5>'.number_format($totalAmountPrepared).'</h5></td>
                                    <td>
                                        <a href="preannouncement-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                                            View  <i class="material-icons left">link</i>
                                        </a>
                                        ';
                                        if ($row['cp_done'] == 'NO') {
                                            echo '
                                        <a href="preannouncement-p?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-edit waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                            Prepare Cash <i class="material-icons left">local_mall</i>
                                        </a>';
                                        }
                                        if ( $row['er_status'] == 'Awaiting Consignment Pickup' && bagExists($row['id']) ) {
                                            echo '<button data-target="confirmCons" class="btns btns-add waves-effect waves-teal cho modal-trigger" data-id="' . $row['id'].'" data-name="' . $row['er_name'].'" data-ctokn="' . $citConfirmationToken.'" data-tap="'.$totalAmountPrepared.'" data-bbcid="'.$row['bank_id'].'"><i class="material-icons left">rv_hookup</i> Confirm Consignment </button>';
                                        }
                                        echo '
                                    </td>
                                </tr>';
                            }
                            echo '</tbody>
                            </table>';
                        } else {
                            echo 'No preannouncement record found. <a href="preannouncement-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Preannouncement</a>';
                        }
                      ?>

                      <!-- Modal Structure -->
                      <div id="confirmCons" class="modal">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="title">Consignement Confirmation for ( <strong id="erName"></strong> )</h4>
                              <p class="subtitle">Ensure you have the right permission before proceeding</p>
                            </div>
                            <div class="modal-body">
                              <div class="row margin">
                                <div class="col s12">
                                  <h5 class="black-text">Do You Really Want To Confirm This Consignment?</h5>
                                </div>
                              </div>
                              <input type="hidden" name="citConfirmationToken" id="citConfirmationToken">
                              <input type="hidden" name="erId" id="erId">
                              <input type="hidden" name="tap" id="tap">
                              <input type="hidden" name="bbCid" id="bbCid">
                              <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                              <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

                            </div>
                          </div>
                          <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
                            <button class="btn waves-effect waves-light teal white-text consignmentHandOver mr-3">
                              <i class="material-icons left">done_all</i>
                              YES, CONFIRM Consignment 
                            </button>
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

    <script type="text/javascript" src="assets/js/pages/preannouncements.js"></script>

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