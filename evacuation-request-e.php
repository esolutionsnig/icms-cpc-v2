<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/evacuation-requests.php';
include 'app/core/session.php';
$pagename = 'Update Evacuation Request';
//Check user loggin stats and user level 
if ($session->logged_in) {
  if ($session->isSuperAdmin() || $session->isBankerCmu()) {
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
      $erData                     = getEvacRequestById($get_id);
      $erName                     = $erData['er_name'];
      $evReq                      = getEvacRequestById($get_id);
      $er_id                      = $evReq['id'];
      $er_name                    = $evReq['er_name'];
      $bank_id                    = $evReq['bank_id'];
      $branch_rep                 = $evReq['client_rep'];
      $branch_id                  = $evReq['branch_id'];
      $location_code              = $evReq['location_code'];
      $consignment_location_id    = $evReq['consignment_location_id'];
      $cit_reciever_id        	= $evReq['cit_reciever_id'];
      $vehicle_id        	        = $evReq['vehicle_id'];
      $cit        	            = $evReq['cit'];
      $date_execution           = $evReq['date_execution'];

      //Get Client Name
      $reqClientName              = getClientNameById($bank_id);
      $clientName                 = $reqClientName['bank_name'];
      //Get Branch
      $reqClientBranch            = getClientBranchNameById($branch_id);
      $clientBranch               = $reqClientBranch['name'];
      //Get consignement Location
      $reqConsLoc                 = getConsignmentLocationById($consignment_location_id);
      $consignmentLocation        = $reqConsLoc['name'];
      // Get Bank rep Data
      $getReqUserInfo             = $database->getUserInfo($branch_rep);
      $getClientRepFullname       = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'].' '.$getReqUserInfo['middlename'];
      $getUserId                  = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
      $userUID                    = base64_encode($getUserId);
      $getCitData                 = $database->getUserInfo($cit_reciever_id);
      $getCitFullname             = $getCitData['surname'].' '.$getCitData['firstname'].' '.$getCitData['middlename'];
      $getCitId                   = $getCitData['username'].'------'.$getCitData['email'].'------el';
      $citUID                     = base64_encode($getCitId);
      // Get CIT Vehicle
      $getVehicleData             = getCitVehicleById($vehicle_id);
      $vehicleName                = $getVehicleData['vehicle_name'];
      $vehicleNumber              = $getVehicleData['vehicle_number'];

      // Check If Cash Is In Transit And Disable Edit
      if ( $cit == 'YES' ) {
          header("Location: evacuation-requests");
      } else {
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
                    <li class="active"><?php echo $pagename . ' &nbsp; ->  &nbsp; Updating: ' . $erName; ?> </li>
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
                            
                            <input type="hidden" name="erId" id="erId" value="<?php echo $er_id; ?>">
                            <input type="hidden" name="bankId" id="bankId" value="<?php echo $bank_id; ?>">
                            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">


                            <div class="row">
                                <div class="col l8 m8 s12">
                                    <div class="card">
                                        <div class="card-content">
                                        
                                        <h4 class="header center blue-grey-text">Cash Evacuation Request </h4>

                                        <div class="row">
                                            <div class="col s12">
                                            <div class="row margin">
                                                <div class="input-field col s12">
                                                    <input id="erName" name="erName" type="text" class="validate erName" required autocomplete="off" value="<?php echo $er_name; ?>">
                                                    <label for="erName">Request Title </label>
                                                    <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="row margin">
                                            <div class="input-field col s12">
                                                <select id="clientBranch" required>
                                                    <option  value="<?php echo $branch_id; ?>"><?php echo $clientBranch; ?></option>
                                                    <?php getClientBranhcesList($cid); ?>
                                                </select>
                                                <label>Your Branch</label>
                                                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                            </div>
                                        </div>

                                        <div class="row margin">
                                            <div class="input-field col s12">
                                                <input id="clientBranchL" name="clientBranchL" type="text" class="validate clientBranchL" required autocomplete="off" readonly value="<?php echo $location_code; ?>">
                                                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                            </div>
                                        </div>

                                        <div class="row margin">
                                            <div class="input-field col l8 m8 s12">
                                              <select id="consignmentLocation">
                                                <option  value="<?php echo $consignment_location_id; ?>"><?php echo $consignmentLocation; ?></option>
                                                <?php getConsignmentLocationsBankView(); ?>
                                              </select>
                                              <label>Consignment Destination</label>
                                            </div>
                                            <div class="input-field col l4 m4 s12">
                                              <small>Date Of Execution</small>
                                              <input id="dateOfExecutione" name="dateOfExecutione" type="date" class="validate" required value="<?php echo $date_execution; ?>">
                                            </div>
                                        </div>
                                        <div class="row center">
                                            <div class="col l6 m6 s12">
                                                <a href="#data-table-simple" class="btn waves-effect waves-light orange" style="color: white !important;">
                                                    <i class="material-icons left">local_mall</i>
                                                    Update Prepared Bags
                                                </a>
                                            </div>
                                            <div class="col l6 m6 s12">
                                                <button class="btn waves-effect waves-light teal white-text updateEvacuationRequest">
                                                    <i class="material-icons left">save</i>
                                                    Save Chnages
                                                </button>
                                            </div>
                                        </div>

                                        </div>
                                    </div>

                                    </div>
                                    <div class="col l4 m4 s12">
                                    <div class="card">
                                        <div class="card-content">
                                        
                                        <h4 class="header center blue-grey-text">Information</h4>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                      
                            <h5 class="header center blue-grey-text">Prepared Bags &amp; Content</h5>

                            <?php
                                $snum = 1;
                                $sql = " SELECT DISTINCT id, evacuation_id, seal_number, container_type_id, deposit_type_id, category_id  FROM evacuationpreparations WHERE evacuation_id = '$get_id' AND is_deleted = 'NO' GROUP BY seal_number ";
                                
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                  echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                    echo '<thead>
                                        <tr>
                                          <th>S/No</th>
                                          <th>Seal number</th>
                                          <th>Container Type</th>
                                          <th>Deposit Type</th>
                                          <th>Cash Category</th>
                                          <th>Amount</th>
                                          <th>ACTION</th>
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
                                          <th>ACTION</th>
                                        </tr>
                                      </tfoot>
                                      <tbody>';
                                    while ($row = $result->fetch_assoc()) {
                                        $seal_number = $row['seal_number'];
                                        $container_type_id = $row['container_type_id'];
                                        $deposit_type_id = $row['deposit_type_id'];
                                        $category_id = $row['category_id'];
                                        $bUID = $row['id'].'------'.$seal_number.'------el';
                                        $bankUID = base64_encode($bUID);
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
                                        $currency_id            = $reqBagContentz['id'];
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
                                                <td><button data-target="deleteBag" class="btns btns-delete waves-effect waves-teal delCons modal-trigger" data-id="' . $seal_number.'" ><i class="material-icons left">delete</i> Delete Bag </button></td>
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

    <!-- Remove Modal -->
    <div id="deleteBag" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Delete Bag</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row margin">
            <div class="input-field col s12">
              <h5 class="red-text center uppercase">Do you really want to delete this bag and it's contents? <br> This step is not reversible</h5>
            </div>
          </div>

          <input type="hidden" name="sealNumber" id="sealNumber">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        <button class="btns btns-delete waves-effect waves-light white-text deleteThisBag mr-3">
          <i class="material-icons left">delete_forever</i>
          Yes Delete Bag
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

    <script type="text/javascript" src="assets/js/pages/evacuation-requests.js"></script>

  </body>
</html>
<?php
        }
    } else {
        header("Location: ./");
    }
} else {
    header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>