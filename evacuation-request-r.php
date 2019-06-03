<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/evacuation-requests.php';
include 'app/core/session.php';
$pagename = 'Prepared Bags';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isSuperAdmin() || $session->isBanker() || $session->isBankerCmu()) {
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
                                $clientBranch       = $reqClientBranch['name'];
                                //Get consignement Location
                                $reqConsLoc             = getConsignmentLocationById($consignment_location_id);
                                $consignmentLocation    = $reqConsLoc['name'];

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
                                $vehicleName        = $getVehicleData['name'];
                                $vehicleNumber      = $getVehicleData['number'];
                                
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
                      
                            <h5 class="header center blue-grey-text">Cash Prepared</h5>

                            <?php
                                $snum = 1;
                                $currencyIcon = '';
                                $sql = " SELECT DISTINCT seal_number, container_type_id, deposit_type_id, category_id  FROM evacuationpreparations WHERE evacuation_id = '$get_id' ";                              
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                                        echo '<thead>
                                                <tr>
                                                <th>S/No</th>
                                                <th>Seal number</th>
                                                <th>Container Type</th>
                                                <th>Deposit Type</th>
                                                <th>Cash Category</th>
                                                <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>S/No</th>
                                                <th>Seal number</th>
                                                <th>Container Type</th>
                                                <th>Deposit Type</th>
                                                <th>Cash Category</th>
                                                <th>Amount</th>
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
                                        $containerType          = $getContainerType['name'];
                                        // Get Deposit Type Name
                                        $getDepositType         = getDepositTypeById($deposit_type_id);
                                        $depositType            = $getDepositType['name'];
                                        // Get Cash Category Name
                                        $getCategoryType        = getCategoryTypeById($category_id);
                                        $cashCategory           = $getCategoryType['name'];
                                        // Get Bag Content
                                        $reqBagContentz         = getBagContenz($seal_number);
                                        $currency_id            = $reqBagContentz['currency_id'];
                                        $total_amount           = $reqBagContentz['total_amount'];     
                                        // Get Currencies
                                        if ($currency_id == 'naira') {
                                            $currencyName = 'Nigerian Naira';
                                            $currencyIcon = '<small>&#8358;</small>';
                                        } else if ($currency_id == 'euro') {
                                            $currencyName = 'European Euro';
                                            $currencyIcon = '<small>&euro;</small>';
                                        } else if ($currency_id == 'gbp') {
                                            $currencyName = 'British Pounds';
                                            $currencyIcon = '<small>&#163;</small>';
                                        } else if ($currency_id == 'usd') {
                                            $currencyName = 'US Dollars';
                                            $currencyIcon = '<small>&#36;</small>';
                                        } else if ($currency_id == 'cny') {
                                            $currencyName = 'Chinese Yen';
                                            $currencyIcon = '<small>&#165;</small>';
                                        } else if ($currency_id == 'cfa') {
                                            $currencyName = 'Centra African Republic Franc';
                                            $currencyIcon = '<small>CFA</small>';
                                        } else if ($currency_id == 'zar') {
                                            $currencyName = 'South African Rand';
                                            $currencyIcon = '<small>R</small>';
                                        }

                                        echo '<tr>
                                                <td>' . $snum++ . '</td>
                                                <td><small class="grey-text">' . $tymeStamp . '-</small><strong class="teal-text">' . $sealNumber . '</strong></td>
                                                <td>' . $containerType . '</td>
                                                <td>' . $depositType . '</td>
                                                <td>' . $cashCategory . '</td>
                                                <td>'; 
                                                echo '<small class="blue-grey-text uppercase">Denomination (Amount)<br></small> ';
                                                    if ($reqBagContentz['cash_1000_amount'] != ''){ echo '1000 ('; }
                                                    if ($reqBagContentz['cash_1000_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_1000_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_500_amount'] != ''){ echo '500 ('; }
                                                    if ($reqBagContentz['cash_500_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_500_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_200_amount'] != ''){ echo '200 ('; }
                                                    if ($reqBagContentz['cash_200_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_200_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_100_amount'] != ''){ echo '100 ('; }
                                                    if ($reqBagContentz['cash_100_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_100_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_50_amount'] != ''){ echo '50 ('; }
                                                    if ($reqBagContentz['cash_50_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_50_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_20_amount'] != ''){ echo '20 ('; }
                                                    if ($reqBagContentz['cash_20_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_20_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_10_amount'] != ''){ echo '10 ('; }
                                                    if ($reqBagContentz['cash_10_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_10_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_5_amount'] != ''){ echo '5 ('; }
                                                    if ($reqBagContentz['cash_5_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_5_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                    if ($reqBagContentz['cash_1_amount'] != ''){ echo '1 ('; }
                                                    if ($reqBagContentz['cash_1_amount'] != ''){ echo '<b>' . number_format($reqBagContentz['cash_1_amount']) . '</b>) &nbsp; &nbsp; '; }
                                                echo '<br><small class="blue-grey-text">TOTAL: </small>' . $currencyIcon . number_format($total_amount) ;
                                                echo '</td>
                                            </tr>
                                        ';
                                    }
                                    echo '</tbody>
                                    </table>';
                                } else {
                                    echo '<option value="">No Record Found</option>';
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