<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/sealings.php';
include 'app/core/session.php';
$pagename = 'Consignment Sealings';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive()) {
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
                    <a href="sealing-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Seal New Container </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      
                      <?php
                        $sno = 1;
                        $oldSealNumber = '';
                        $sql = "SELECT * FROM sealings WHERE is_opened = 'NO' ORDER BY id DESC";
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
                                $reqClientName          = getClientNameById($row['client']);
                                $clientName             = $reqClientName['bank_name'];
                                //get consignement 
                                $reqConsLoc             = getConsignmentLocationById($row['location_id']);
                                $consignmentLocation    = $reqConsLoc['name'];
                                // Get Cash Category
                                $getCategoryType        = getCategoryTypeById($row['category_id']);
                                $cashCategory           = $getCategoryType['name'];
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
                                $getContainerType       = getContainerType($row['container_id']);
                                $containerType          = $getContainerType['name'];
                                // Get Currency Type Name
                                $getCurrency            = getCurrencyById($row['currency_id']);
                                $currencyType           = $getCurrency['name'];
                                // Get Currency Type Name
                                $getDenomination        = getDenominationById($row['denomination_id']);
                                $denominationType       = $getDenomination['name'];
                                // Get Sealing Officer Data
                                $getCitData             = $database->getUserInfo($row['added_by']);
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
                            echo 'No request found. <a href="sealing-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Seal New Container</a>';
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

    <!-- Add Branch Modal -->
    <div id="hoc" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Consignement Hand Over for ( <strong id="erName"></strong> )</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row margin">
            <div class="input-field col s12">
              <select id="cmo">
                <?php getCMOs(); ?>
              </select>
              <label>Select Consignment Movement Officer</label>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <select id="vehicle">
                <?php getVehicles(); ?>
              </select>
              <label>Select Vehicle</label>
            </div>
          </div>

          <input type="hidden" name="citConfirmationToken" id="citConfirmationToken">
          <input type="hidden" name="erId" id="erId">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <button class="btn waves-effect waves-light teal white-text consignmentHandOver mr-3">
          <i class="material-icons left">rv_hookup</i>
          Hand Over Consignment 
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

    <script type="text/javascript" src="assets/js/pages/sealings.js"></script>

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