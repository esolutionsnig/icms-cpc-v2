<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'Client Supply Request';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() || $session->isBanker() || $session->isBankerCmu()) {
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
            header("Location: supply-requests");
        }
        $cid = getClientId($session->username);
        
        // Get Supply Request Data
        $srData         = getSupplyRequestData($get_id);
        $srName         = $srData['sr_title'];
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
                    <li><a href="supply-requests">Supply Requests</a></li>
                    <li class="active"><?php echo $pagename . ' &nbsp; ->  &nbsp; ' . $srName; ?> </li>
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
                    <a href="supply-requests" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12">

                    <div class="card">
                        <div class="card-content">
                            <h4 class="header center blue-grey-text">Supply Request Basic Information</h4>
                            <?php
                                $evReq                      = getSupplyRequestData($get_id);
                                $sr_id                      = $evReq['sr_id'];
                                $sr_title                    = $evReq['sr_title'];
                                $client                    = $evReq['client'];
                                $sr_type                 = $evReq['sr_type'];
                                $sr_date                  = $evReq['sr_date'];
                                $sr_comment              = $evReq['sr_comment'];
                                $sr_status              = $evReq['sr_status'];
                                $cit              = $evReq['cit'];
                                $requested_by              = $evReq['requested_by'];
                                $cit              = $evReq['cit'];
                                $verified_on              = $evReq['verified_on'];
                                $verified_comment              = $evReq['verified_comment'];
                                $approved_on              = $evReq['approved_on'];
                                $approved_comment              = $evReq['approved_comment'];
                                $delivery_status              = $evReq['delivery_status'];

                                //Get Client Name
                                $reqClientName      = getClientNameById($client);
                                $clientName         = $reqClientName['bank_name'];
                                // Get Bank rep Data
                                $getReqUserInfo         = $database->getUserInfo($requested_by);
                                $getClientRepFullname   = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'].' '.$getReqUserInfo['middlename'];
                                $getUserId              = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
                                $userUID                = base64_encode($getUserId);                                
                            ?>
                            <div class="row">
                                <div class="col l6 m6 s12">
                                    <h5 class="uppercase blue-grey-text center">Client</h5>
                                    <ul id="profile-page-about-details" class="collection z-depth-1">
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">business</i> Name
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $clientName; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">label</i> Supply  Title
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_title; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">pin_drop</i> Supply  Type
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_type; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">alarm</i> Supply Date
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_date; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">person</i> Request Initialized By
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong">
                                                    <a href="profile?r=<?php echo $getReqUserInfo['username'].'cprf'.$userUID ; ?>" target="_blank" style="color: #4f2323 !important;">
                                                        <?php echo $getClientRepFullname; ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">chat</i> Request Comment
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_comment; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">announcement</i> Supply Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_status; ?></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col l6 m6 s12">
                                    <h5 class="uppercase blue-grey-text center">ICMS</h5>
                                    <ul id="profile-page-about-details" class="collection z-depth-1">
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">assignment_turned_in</i> Verification Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php if (!empty($verified_on)){ echo 'Request Verified'; } else { echo 'Request Awaiting Verification'; } ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">assignment_turned_in</i> Approval Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php if (!empty($approved_on)){ echo 'Request Approved'; } else { echo 'Request Awaiting Approval'; } ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">local_shipping</i> Dispatch Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php if ($cit == 'NO'){ echo 'Not Dispatched'; } else { echo 'Dispatched. Enroute To Your Requested Branches'; } ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">chat</i> Comment
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_comment; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">announcement</i> Delivery Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php if ($delivery_status == 'NOT DELIVERED'){ echo 'NOT DELIVERED'; } else { echo 'Delivered To Requested Branches'; } ?></div>
                                            </div>
                                        </li>
                                    </ul>
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
                      
                            <h5 class="header center blue-grey-text uppercase">
                                Total Cash Requested: 
                                <strong class="black-text"><?php echo number_format(getTotalSupplyRequest($get_id)); ?></strong>
                            </h5>
                            <?php
                                $snum = 1;
                                $sql = " SELECT *  FROM supply_requests_branch WHERE sr_id = '$get_id' ";                                
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                                        echo '<thead>
                                                <tr>
                                                <th>S/No</th>
                                                <th>Branch</th>
                                                <th>Location</th>
                                                <th>Location Code</th>
                                                <th>Den</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>S/No</th>
                                                <th>Branch</th>
                                                <th>Location</th>
                                                <th>Location Code</th>
                                                <th>Den</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>';
                                    while ($row = $result->fetch_assoc()) {
                                        $currency = $row['currency'];
                                        $denomination = $row['denomination'];
                                        $cash_category = $row['cash_category'];
                                        $branch = $row['branch'];
                                        $amount = $row['amount'];
                                        // Get Branch Data
                                        $bd = getClientBranchNameById($branch);
                                        $branchName = $bd['branch_name'];
                                        $branchLocation = $bd['branch_location'];
                                        $branchLocationCode = $bd['branch_location_code'];
                                        // Get Cash Category Name
                                        $getCategoryType        = getCategoryTypeById($cash_category);
                                        $cashCategory           = $getCategoryType['dc_name'];  
                                        // Get Currencies
                                        $currencyIcon = currencyIcon($currency);
                                        // get Denomintaion Name
                                        $dd = getDenominationById($denomination);
                                        $denoName = $dd['denomination_name'];
                                        echo '<tr>
                                                <td>' . $snum++ . '</td>
                                                <td>' . $branchName . '</td>
                                                <td>' . $branchLocation . '</td>
                                                <td>' . $branchLocationCode . '</td>
                                                <td>' . number_format($denoName) . '</td>
                                                <td>' . $cashCategory . '</td>
                                                <td><span style="font-weight: 100">' . $currencyIcon . '</span><strong>' . number_format($amount) . '</strong></td>
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

    <script type="text/javascript" src="assets/js/pages/supply-requests.js"></script>

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