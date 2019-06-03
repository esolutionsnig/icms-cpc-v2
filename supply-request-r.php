<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'View Supply Request';
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

                <input type="hidden" name="srId" id="srId" value="<?php echo $get_id; ?>">
                <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

              <div class="row">
                <div class="col s12">

                    <div class="card">
                        <div class="card-content">
                            <h4 class="header center blue-grey-text">Supply Request Basic Information</h4>
                            <?php
                                $dispatchedRequests = $packedRequests = $disStatus = '';
                                $evReq                      = getSupplyRequestData($get_id);
                                $sr_id                      = $evReq['id'];
                                $sr_title                    = $evReq['sr_title'];
                                $client                    = $evReq['client_id'];
                                $sr_type                 = $evReq['sr_type'];
                                $sr_date                  = $evReq['sr_date'];
                                $sr_comment              = $evReq['sr_comment'];
                                $sr_status              = $evReq['sr_status'];
                                $cit              = $evReq['cit'];
                                $requested_by              = $evReq['requested_by'];
                                $sr_verified              = $evReq['sr_verified'];
                                $verified_on              = $evReq['verified_on'];
                                $verified_comment              = $evReq['verified_comment'];
                                $sr_approved              = $evReq['sr_approved'];
                                $approved_on              = $evReq['approved_on'];
                                $approved_comment              = $evReq['approved_comment'];
                                $approved_comment              = $evReq['approved_comment'];
                                $delivery_status              = $evReq['delivery_status'];
                                $sr_dispatch_comment              = $evReq['sr_dispatch_comment'];

                                //Get Client Name 
                                $reqClientName      = getClientNameById($client);
                                $clientName         = $reqClientName['bank_name'];
                                // Get Bank rep Data
                                $getReqUserInfo         = $database->getUserInfo($requested_by);
                                $getClientRepFullname   = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'].' '.$getReqUserInfo['middlename'];
                                $getUserId              = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
                                $userUID                = base64_encode($getUserId);  
                                // Get Number Of Dispatched Requests
                                $dispatchedRequests = getNumberOfDispatchedRequests($sr_id);
                                // Get Total Number Of Packed Bags
                                $packedRequests = getNumberOfPackedBags($sr_id); 
                                // Check if all bags has been dispatched
                                if ($packedRequests == $dispatchedRequests ) {
                                    $disStatus = '<span class="teal-text">Dispatched. Enroute To Your Requested Branches</span>';
                                } else {
                                    $disStatus = '<span class="deepred-text">Not Dispatched</span>';
                                }                             
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
                                                <div class="col l9 m9 s12 right-align strong"><?php if ($sr_verified == 'YES'){ echo '<span class="teal-text">Request Verified</span>'; } else { echo '<span class="deepred-text">Request Awaiting Verification</span>'; } ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">assignment_turned_in</i> Approval Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php if ($sr_approved == 'YES'){ echo '<span class="teal-text">Request Approved</span>'; } else { echo '<span class="deepred-text">Request Awaiting Approval</span>'; } ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">local_shipping</i> Dispatch Status
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $disStatus; ?></div>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col l3 m3 s12">
                                                    <i class="material-icons left">chat</i> Comment
                                                </div>
                                                <div class="col l9 m9 s12 right-align strong"><?php echo $sr_dispatch_comment; ?></div>
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
                      
                            <h5 class="header center blue-grey-text uppercase">Cash Requested Per Branch</h5>
                            <?php
                                $snum = 1;
                                $totalRequest = 0;
                                $dispatchStatus = '';
                                $sql = " SELECT *  FROM supplybranches WHERE supply_id = '$get_id' ";                                
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
                                                    <th>Status</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                    while ($row = $result->fetch_assoc()) {
                                        $srb_id = $row['id'];
                                        $currency = $row['currency'];
                                        $denomination = $row['denomination'];
                                        $cash_category = $row['cash_category'];
                                        $branch = $row['branch'];
                                        $amount = $row['amount'];
                                        $processed_amount = $row['processed_amount'];
                                        $is_dispatched = $row['is_dispatched'];
                                        $srb_status = $row['srb_status'];
                                        $is_packed = $row['is_packed'];
                                        $is_delivered = $row['is_delivered'];
                                        // Get Branch Data
                                        $bd = getClientBranchNameById($branch);
                                        $branchName = $bd['name'];
                                        $branchLocation = $bd['branch_location'];
                                        $branchLocationCode = $bd['branch_location_code'];
                                        // Get Cash Category Name
                                        $getCategoryType        = getCategoryTypeById($cash_category);
                                        $cashCategory           = $getCategoryType['name'];  
                                        // Get Currencies
                                        $currencyIcon = currencyIcon($currency);
                                        // get Denomintaion Name
                                        $dd = getDenominationById($denomination);
                                        $denoName = $dd['name'];
                                        // Get Total Amount Requested
                                        $totalRequest += $amount;
                                        echo '<tr>
                                                <td>' . $snum++ . '</td>
                                                <td>' . $branchName . '</td>
                                                <td>' . $branchLocation . '</td>
                                                <td>' . $branchLocationCode . '</td>
                                                <td>' . number_format($denoName) . '</td>
                                                <td>' . $cashCategory . '</td>
                                                <td><span style="font-weight: 100">' . $currencyIcon . '</span><strong>' . number_format($amount) . '</strong></td>
                                                <td>'. $srb_status .'</td>
                                                <td>';
                                                if ( $session->isAdmin() || $session->isSuperAdmin() ){
                                                    echo '';
                                                } else {
                                                    // Client Action
                                                    if ( $is_delivered == 'NO' ) {
                                                        echo '<button data-target="confirmDelivery" class="btns waves-effect waves-teal primary-btn white-text confirmDelivery modal-trigger" data-id="'.$srb_id.'">
                                                            <i class="material-icons left">done_all</i>
                                                            Confirm Delivery 
                                                        </button>';
                                                    } else {
                                                        echo 'Completed';
                                                    }
                                                }
                                            echo '</tr>
                                        ';
                                    }
                                    echo '</tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6">TOTAL</th>
                                                <th><h5 class="teal-text">'.number_format($totalRequest).'</h5></th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tfoot>
                                    </table>';
                                } else {
                                    echo '<option value="">No Record Found</option>';
                                }
                            ?>
                            <?php if ( $session->isAdmin() || $session->isSuperAdmin() ){ ?>
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col l4 m4 s12">
                                        <div class="">
                                            <?php if ($sr_verified == 'NO'){ ?>
                                                <button data-target="verifyRequest" class="btns waves-effect waves-blue darken-3 blue white-text verifyRequest modal-trigger">
                                                    <i class="material-icons left">assignment_turned_in</i>
                                                    Verify Request
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col l4 m4 s12">
                                        <div class="center">
                                            <?php if ($sr_approved == 'NO'){ ?>
                                                <button data-target="approveRequest" class="btns waves-effect waves-cyan cyan white-text approveRequest modal-trigger">
                                                    <i class="material-icons left">done_all</i>
                                                    Approve Request 
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col l4 m4 s12">
                                        <div class="right">
                                            <a href="supply-request-x?r=<?php echo $get_req; ?>" class="btns btns-add waves-effect waves-teal" style="color: #fff !important;" >
                                                <i class="material-icons left">business_center</i>
                                                Execute Request
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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
    
    <!-- Verify Modal -->
    <div id="verifyRequest" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Verify Supply Request</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col s12">
                <h5 class="red-text">Have you completely verified this supply requests?</h5>
                <div class="row margin">
                    <div class="input-field col s12">
                        <textarea name="verComment" id="verComment" placeholder="Enter Commenst/Observations Here" class="materialize-textarea" cols="30" rows="1"></textarea>
                        <label for="difference">Additional Comment</label>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No</a>
        <button class="btn waves-effect waves-light blue darken-3 white-text vrequest mr-3">
          <i class="material-icons left">assignment_turned_in</i>
          Yes
        </button>
      </div>
    </div>
    
    <!-- approve Modal -->
    <div id="approveRequest" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Approve Supply Request</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col s12">
                <h5 class="red-text">Do you really want to approve this supply requests?</h5>
                <div class="row margin">
                    <div class="input-field col s12">
                        <textarea name="appComment" id="appComment" placeholder="Enter Commenst/Observations Here" class="materialize-textarea" cols="30" rows="1"></textarea>
                        <label for="difference">Additional Comment</label>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No</a>
        <button class="btn waves-effect waves-light cyan white-text arequest mr-3">
          <i class="material-icons left">done_all</i>
          Yes
        </button>
      </div>
    </div>

    <!-- Pack Bag Modal -->
    <div id="packBag" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title"> Supply Request Bag Packing</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col l6 m6 s12">
                        <div class="card primary-btn white-text">
                            <div class="card-content uppercase">
                                <h5><span style="font-weight: 100">Requested Amount:</span></h5>
                                <h4 id="reqAmount"></h4>
                                <input type="hidden" id="reqAmountVal">
                            </div>
                        </div>
                    </div>
                    <div class="col l6 m6 s12">
                        <div class="card teal white-text">
                            <div class="card-content uppercase">
                                <h5><span style="font-weight: 100">Proccessed Amount:</span></h5>
                                <h4 id="procAmount"></h4>
                                <input type="hidden" id="procAmountVal">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="srUID">
                <input type="hidden" id="srDen">
                <div class="row margin">
                    <div class="input-field col l4 m4 s12">
                        <small>Container Type</small>
                        <select id="containerType" class="searchableSelect">
                            <?php getContainerTypeLists(); ?>
                        </select>
                    </div>
                    <div class="input-field col l4 m4 s12">
                        <small>Select Denomination</small>
                        <select id="denomination" class="searchableSelect">
                            <option value="">Select Packing Denomination</option>
                            <?php getDen(); ?>
                        </select>
                    </div>
                    <div id="bag">
                        <div class="input-field col l4 m4 s12">
                            <small>Number Of Notes</small>
                            <select id="numPieces" class="searchableSelect">
                                <?php getPieces(); ?>
                            </select>
                        </div>
                    </div>
                    <div id="fbox">
                        <div class="input-field col l4 m4 s12">
                            <small>Number Of Notes</small>
                            <select id="numPieces" class="searchableSelect">
                                <option value="10000">10,000</option>
                            </select>
                        </div>
                    </div>
                    <div id="odbox">
                        <div class="input-field col l4 m4 s12">
                            <input id="numPiecess" name="numPieces" type="text" class="validate numPieces" required autocomplete="off" onkeypress="return AvoidSpace(event)" maxlenght="4">
                            <label for="numPieces">Number Of Pieces <small id="enteredAmount" class="helper-text"></small> </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div id="packingfeedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4 m5 s12">
                        <button class="btn waves-effect waves-light white teal-text getPackedAmount glowingBtn">
                            <i class="material-icons left">functions</i>
                            Compute
                        </button>
                    </div>
                    <div class="col l8 m7 s12">
                        <h4 class="totalAmountC teal-text"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text packThisBag mr-3">
                <i class="material-icons left">save</i>
                Save
            </button>
        </div>
    </div>

    <!-- dispatch Modal -->
    <div id="dispatchRequest" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Dispatch Supply Request</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
            <input type="hidden" id="srbranchId">
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
                    <label>Select Assigned Vehicle</label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No</a>
        <button class="btn waves-effect waves-light teal white-text drequest mr-3">
          <i class="material-icons left">local_shipping</i>
          Send Dispatch
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

    <script type="text/javascript" src="assets/js/pages/supply-requests.js"></script>

    <script>
        $('#bag').hide()
        $('#odbox').hide()
        $('#fbox').hide()
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