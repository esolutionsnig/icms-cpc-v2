<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/evacuation-requests.php';
include 'app/core/session.php';
$pagename = 'Prepared Bags';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isBanker() || $session->isBankerCmu()) {
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
            
        } else {
            header("Location: evacuation-requests");
        }
        $cid = getClientId($session->username);
        
        // Get ER Data
        $erData         = getEvacRequestById($get_id);
        $erName         = $erData['er_name'];
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
                    <li><a href="evacuation-requests">Evacuation Requests</a></li>
                    <li class="active"><?php echo $pagename . ' &nbsp; ->  &nbsp; ' . $erName; ?> </li>
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
                    <a href="evacuation-requests" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12">

                    <div class="card">
                        <div class="card-content">
                            <h4 class="header center blue-grey-text">Client Basic Information</h4>
                            <?php
                                $evReq                      = getEvacRequestById($get_id);
                                $er_name                    = $evReq['er_name'];
                                $bank_id                    = $evReq['bank_id'];
                                $branch_rep                 = $evReq['client_rep'];
                                $branch_id                  = $evReq['branch_id'];
                                $location_code              = $evReq['location_code'];
                                $consignment_location_id    = $evReq['consignment_location_id'];
                                $cit_reciever_id        	= $evReq['cit_reciever_id'];
                                $vehicle_id        	        = $evReq['vehicle_id'];

                                //Get Client Name
                                $reqClientName      = getClientNameById($bank_id);
                                $clientName         = $reqClientName['bank_name'];
                                //Get Branch
                                $reqClientBranch    = getClientBranchNameById($branch_id);
                                $clientBranch       = $reqClientBranch['branch_name'];
                                //Get consignement Location
                                $reqConsLoc             = getConsignmentLocationById($consignment_location_id);
                                $consignmentLocation    = $reqConsLoc['location_name'];

                                // Get Bank rep Data
                                $getReqUserInfo         = $database->getUserInfo($branch_rep);
                                $getClientRepFullname   = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'].' '.$getReqUserInfo['middlename'];
                                $getUserId              = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
                                $userUID                = base64_encode($getUserId);

                                // Get CIT Officer Data
                                $getCitData         = $database->getUserInfo($cit_reciever_id);
                                $getCitFullname     = $getCitData['surname'].' '.$getCitData['firstname'].' '.$getCitData['middlename'];
                                $getCitId           = $getCitData['username'].'------'.$getCitData['email'].'------el';
                                $citUID            = base64_encode($getCitId);
                                
                                // Get CIT Vehicle
                                $getVehicleData     = getCitVehicleById($vehicle_id);
                                $vehicleName        = $getVehicleData['vehicle_name'];
                                $vehicleNumber      = $getVehicleData['vehicle_number'];
                                
                            ?>

                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <i class="material-icons left">business</i> Client Name
                                        </div>
                                        <div class="col s6 right-align strong"><?php echo $clientName; ?></div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <i class="material-icons left">store</i> Request Initialized From
                                        </div>
                                        <div class="col s6 right-align strong"><?php echo $clientBranch; ?></div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <i class="material-icons left">person</i> Request Initialized By
                                        </div>
                                        <div class="col s6 right-align strong">
                                            <a href="profile?r=<?php echo $getReqUserInfo['username'].'cprf'.$userUID ; ?>" target="_blank" style="color: #4f2323 !important;">
                                                <?php echo $getClientRepFullname; ?>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <i class="material-icons left">pin_drop</i> Consignement Current Location
                                        </div>
                                        <div class="col s6 right-align strong"><?php echo $consignmentLocation; ?></div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <i class="material-icons left">person</i> Cash In Transit Officer
                                        </div>
                                        <div class="col s6 right-align strong">
                                            <a href="profile?r=<?php echo $getCitData['username'].'cprf'.$citUID ; ?>" target="_blank" style="color: #4f2323 !important;">
                                                <?php echo $getCitFullname; ?>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <i class="material-icons left">local_shipping</i> Cash In Transist Vehicle
                                        </div>
                                        <div class="col s6 right-align strong"><?php if ($vehicleName != '') { echo $vehicleName . '( '. $vehicleNumber .' )'; }  ?></div>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                      
                            <h5 class="header center blue-grey-text">Cash Preparations</h5>

                            <?php
                                $snum = 1;
                                $sql = " SELECT DISTINCT seal_number, container_type_id, deposit_type_id, category_id  FROM cash_preparations WHERE ev_req_id = '$get_id' ";
                                // $sql = "SELECT DISTINCT seal_number FROM cash_preparations WHERE ev_req_id = '$get_id' ";
                                
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                        echo '<thead>
                                                <tr>
                                                <th>S/No</th>
                                                <th>Denomination</th>
                                                <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>S/No</th>
                                                <th>Denomination</th>
                                                <th>ACTIONS</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>';
                                    while ($row = $result->fetch_assoc()) {
                                        $seal_number = $row['seal_number'];
                                        $container_type_id = $row['container_type_id'];
                                        $deposit_type_id = $row['deposit_type_id'];
                                        $category_id = $row['category_id'];
                                        //Split and get main seal number
                                        $sealPieces             = explode("-", $seal_number);
                                        $tymeStamp              = $sealPieces[0];
                                        $sealNumber             = $sealPieces[1];
                                        // Get Container Name
                                        $getContainerType       = getContainerType($container_type_id);
                                        $containerType          = $getContainerType['ct_name'];
                                        // Get Deposit Type Name
                                        $getDepositType         = getDepositTypeById($deposit_type_id);
                                        $depositType            = $getDepositType['dt_name'];
                                        // Get Cash Category Name
                                        $getCategoryType        = getCategoryTypeById($category_id);
                                        $cashCategory           = $getCategoryType['dc_name'];
                                         
                            ?>
                            <div class="col l6 m6 s12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="black-text"><small>Seal Number: </small><span class="grey-text"><?php echo $tymeStamp; ?>-</span><strong class="teal-text"><?php echo $sealNumber; ?></strong></h5>
                                        <h6 class="black-text"><small>Container Type:</small> <?php echo $containerType; ?></h6>
                                        <h6 class="black-text"><small>Deposit Type:</small> <?php echo $depositType; ?></h6>
                                        <h6 class="black-text"><small>Cash Category:</small> <?php echo $cashCategory; ?></h6>
                                    </div>
                                    <div class="card-content">
                                        <ul id="profile-page-about-details" class="collection">
                                            <?php getBagContent($seal_number); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                    echo '</tbody>
                                    </table>';
                                } else {
                                    echo '<option value="">No Record Found</option>';
                                }
                                //Get Total Amounts Naira
                                // $reqTotalAmount    = getTotalAmountNaira($get_id);
                                // $totalAmount       = $reqTotalAmount['total_amount'];

                            ?>
                            

                            <!-- <div class="row">
                                <div class="s12 center">
                                    <a href="evacuation-request-p?r=<?php //echo $get_req ; ?>" class="btns btns-add waves-effect waves-light" style="color: white !important;">
                                        Prepare Cash <i class="material-icons left">local_mall</i>
                                    </a>
                                </div>
                            </div> -->
                      
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

    <script type="text/javascript" src="assets/js/pages/evacuation-requests.js"></script>

    <script>
      $("#isNaira").hide()
      $("#isUsd").hide()
      $("#isEuro").hide()
      $("#isGbp").hide()
      $("#isZar").hide()
      $("#isCfa").hide()
      $("#isCny").hide()
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