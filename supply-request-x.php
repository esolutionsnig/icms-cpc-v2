<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'Execute Supply Request';
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
        $evReq         = getSupplyRequestData($get_id);
        $sr_id                      = $evReq['id'];
        $sr_title                    = $evReq['sr_title'];
        $srName         = $evReq['sr_title'];
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
                    <li><a href="supply-request-r?r=<?php echo $get_req; ?>"><?php echo $srName; ?></a></li>
                    <li class="active"><?php echo $pagename; ?> </li>
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
                    <a href="supply-request-r?r=<?php echo $get_req; ?>" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a>
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
                      
                            <h5 class="header center blue-grey-text uppercase">Cash Requested Per Branch</h5>
                            <?php
                                $snum = 1;
                                $dispatchStatus = $sealNumber = '';
                                $numNotes = 0;
                                $totalRequest = 0;
                                $sql = " SELECT *  FROM supplybranches WHERE supply_id = '$get_id' AND is_deleted = 'NO' AND is_splitted = 'NO' ";                                
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
                                                    <th>Seal Number</th>
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
                                        $seal_number = $row['seal_number'];
                                        //Split and get main seal number
                                        if(!empty($seal_number)){
                                            $sealPieces   = explode("-", $seal_number);
                                            $sealNumber   = $sealPieces[1];
                                        }
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
                                        // Get Number Of Notes
                                        $numNotes = $amount / $denoName;
                                        // echo $numNotes;
                                        // Get Total Amount Requested
                                        $totalRequest += $amount;

                                        echo '<tr>
                                                <td>' . $snum++ . '</td>
                                                <td>' . $branchName . '</td>
                                                <td>' . $branchLocation . '</td>
                                                <td>' . $branchLocationCode . '</td>
                                                <td>' . number_format($denoName) . '</td>
                                                <td>' . $cashCategory . '</td>
                                                <td>' . $sealNumber . '</td>
                                                <td><span style="font-weight: 100">' . $currencyIcon . '</span><strong>' . number_format($amount) . '</strong></td>
                                                <td>'. $srb_status .'</td>
                                                <td>';
                                                if ( $session->isAdmin() || $session->isSuperAdmin() ){
                                                    if ( $is_delivered == 'NO' ) {
                                                        if ( $numNotes > 30000 ) {
                                                            echo '<button data-target="splitRequest" class="btns waves-effect waves-red primary-btn white-text splitRequest modal-trigger" data-id="'.$srb_id.'"  data-snumnotes="'.$numNotes.'" data-smount="'.$amount.'" data-sden="'.$denoName.'">
                                                                <i class="material-icons left">business_center</i>
                                                                Split 
                                                            </button>';
                                                        } else {
                                                            // Check If Bag Is Already Packed
                                                            if ( $is_packed == 'NO' ) {
                                                                echo '<button data-target="packBag" class="btns waves-effect waves-teal teal white-text packBag modal-trigger" data-id="'.$srb_id.'" data-amount="'.$amount.'">
                                                                    <i class="material-icons left">work</i>
                                                                    Pack 
                                                                </button>';
                                                            } else {
                                                                // Check If Bag Has Been Dispatched
                                                                if ( $is_dispatched == 'NO' ){
                                                                    echo '<button data-target="dispatchRequest" class="btns waves-effect waves-orange orange darken-3 white-text dispatchRequest modal-trigger" data-id="'.$srb_id.'" >
                                                                        <i class="material-icons left">local_shipping</i>
                                                                        Dispatch 
                                                                    </button>';
                                                                } else {
                                                                    // echo 'Dispatched';
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo 'Completed';
                                                    }
                                                } else {
                                                    echo '';
                                                }
                                            echo '</tr>
                                        ';
                                    }
                                    echo '</tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7">TOTAL</th>
                                                <th><h5 class="teal-text">'.number_format($totalRequest).'</h5></th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tfoot>
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

    <!-- Split Request Modal -->
    <div id="splitRequest" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title"> Split Request </h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col l6 m6 s12">
                        <div class="card teal white-text">
                            <div class="card-content uppercase">
                                <h5><span style="font-weight: 100">Amount:</span></h5>
                                <h4 id="smount"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col l6 m6 s12">
                        <div class="card primary-btn white-text">
                            <div class="card-content uppercase">
                                <h5><span style="font-weight: 100">Number Of Notes:</span></h5>
                                <h4 id="snumnotes"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card black-text">
                            <div class="card-content uppercase">
                                <h6><span style="font-weight: 100; font-size: 18px;">A bag can only contain <strong>30,000</strong> notes. of <strong id="sden"></strong> Denomination. Which is <strong id="maxamount"></strong> Maximum.</span></h6>
                                <form name="add_name" id="add_name">
                                    <div class="table-responsive">  
                                        <table class="table table-bordered" id="dynamic_field">  
                                            <tr>  
                                                <td><input type="text" id="splitname[]" name="splitname[]" placeholder="Enter Amount Here" required autocomplete="off" onkeypress="return AvoidSpace(event)" /></td>  
                                                <td><button type="button" name="add" id="add" class="btn waves-effect waves-light blue darken-2 white-text"><i class="material-icons left">add</i> Add Another Bag</button></td>  
                                            </tr>  
                                        </table>  
                                        <h4>&nbsp;</h4>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="center">
                                                    <input type="hidden" name="srsUID" id="srsUID">
                                                    <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                                                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                                                    <button type="submit" class="btn waves-effect waves-light teal white-text splitThisBag">
                                                        <i class="material-icons left">save</i>
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </form>  
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
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
                    <div class="col s12">
                        <div class="card white">
                            <div class="card-content uppercase">
                                <h5><span style="font-weight: 100">Amount To Be Sealed:</span></h5>
                                <h4 id="reqAmount" class="teal-text"></h4>
                                <input type="hidden" id="reqAmountVal">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="srUID">
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="sealNumber" name="sealNumber" type="text" class="validate sealNumber" required autocomplete="off" onkeypress="return AvoidSpace(event)" maxlength="6">
                        <label for="sealNumber">Seal Number <br></label>
                        <small><span id="newSealNumberfb"></span></small><br>
                        <small>Generated Seal Number: <strong  class="black-text"><span id="newSealNumber"></span></strong></small>
                        <input type="hidden" id="gencurrentSealNumber">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text packThisBag mr-3">
                <i class="material-icons left">work</i>
                Pack
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
        $('.packThisBag').hide()
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