<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
$pagename = 'The Manifest';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer()) {

      if (isset($_GET['r'])) {
          $get_req = $_GET['r'];
          // Pieces GR
          $piecesgr = explode("cprf", $get_req);
          $get_slug = $piecesgr[0];
          $get_uid = $piecesgr[1];
          // DeCrypt back uid
          $decrypted = base64_decode($get_uid);
          //Explode get value
          $piecesDecrypted = explode("------", $decrypted);
          $get_id = $piecesDecrypted[0];
          $get_er_id = $piecesDecrypted[1];
          $cit_confirmation_date = $piecesDecrypted[2];

          //get client name
          $getVehicle         = getCitVehicleById($get_id);
          $vehicleName        = $getVehicle['name'];

      } else {
          header("Location: boxroom");
      }
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
    <link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"> 
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" type="text/css" rel="stylesheet"> 
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
                    <li><a href="boxroom">Box Room</a></li>
                    <li class="active">Generated Manifest</li>
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
                            <a href="boxroom" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a> 
                            &nbsp; &nbsp; 
                            <a href="manifest?r=<?php echo $get_req; ?>" class="btns btns-read waves-effect waves-teal" style="color: teal !important"><i class="material-icons left">refresh</i> Reload Page</a>
                        </div>
                    </div>
                </div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">

                        <h4 class="header blue-grey-text center">
                            Client To ICMS Manifest
                            <small>Vehicle: <strong class="black-text"><?php echo $vehicleName; ?></strong>. Date: <strong class="black-text"><?php echo $cit_confirmation_date; ?></strong></small>
                        </h4>

                        <input type="hidden" id="erId" name="erId" value="<?php echo $get_id; ?>">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

                        <?php
                            $sealNumbers = '';
                            $sno = 1;
                            $sql = "SELECT * FROM evacuations WHERE cit_confirmation_date = '$cit_confirmation_date' AND vehicle_id = '$get_id'";
                            $result = $con->query($sql);
                        
                            if ($result->num_rows > 0) {
                                echo '<table class="blueTable mt-1"  id="printJS-form">
                                <thead>
                                    <tr>
                                        <th>S/No</th>
                                        <th>Client Name</th>
                                        <th>Branch Name</th>
                                        <th>Branch Code</th>
                                        <th>Seal Number (s)</th>
                                        <th>Type 1</th>
                                        <th>Type 2</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                while ($row = $result->fetch_assoc()) {
                                    //get client name
                                    $reqClientName      = getClientNameById($row['bank_id']);
                                    $clientName         = $reqClientName['bank_name'];
                                    //get client branch name
                                    $reqClientBranchName    = getClientBranchNameById($row['branch_id']);
                                    $clientBranchName       = $reqClientBranchName['name'];
                                    $clientBranchCode       = $reqClientBranchName['branch_location_code'];
                                    //get consignment location name
                                    $reqConsignmeLocation      = getConsignmentLocationById($row['consignment_location_id']);
                                    $consignmentLocation       = $reqConsignmeLocation['location_name'];
                        ?>
                                <tr>
                                    <td><?php echo $sno++; ?></td>
                                    <td><?php echo $clientName; ?></td>
                                    <td><?php echo $clientBranchName; ?></td>
                                    <td><?php echo $clientBranchCode; ?></td>
                                    <td><?php getCITBags($row['er_id']); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $row['er_status']; ?></td>
                                </tr>
                            
                        <?php
                                }
                                echo '</tbody>
                                </table>';
                            }
                        ?>

                        <div class="row mt-5">
                            <div class="col l6 m6 s12 center">
                                CIT Officer Signature &amp; Date: ________________________________________
                            </div>
                            <div class="col l6 m6 s12 center">
                                Box Room Officer Signature &amp; Date: ________________________________________
                            </div>
                        </div>
                        <div class="center mt-5">
                            <button class="btn teal waves-effect waves-light consignmentReceived"  onclick="printJS('printJS-form', 'html')">
                                Print Manifest  <i class="material-icons right">send</i>
                            </button>
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

    <!-- <script type="text/javascript" src="assets/js/printthis/print.js"></script> -->
    <script type="text/javascript" src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/manifest.js"></script>

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