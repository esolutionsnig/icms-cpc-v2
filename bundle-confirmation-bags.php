<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/bundle-confirmation.php';
include 'app/core/session.php';
$pagename = 'Bags';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isCPA() ||  $session->isCPS() || $session->isTreasuryOfficer() || $session->isTreasurySup()) {
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
            $get_client = $piecesDecrypted[1];
            $get_client_id = $piecesDecrypted[2];
            $get_strim = $piecesDecrypted[3];
            $get_client_code = $piecesDecrypted[4];
            
        } else {
            header("Location: bundle-confirmation");
        }
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
                    <li><a href="bundle-confirmation">Bundle Confirmations</a></li>
                    <li class="active"><?php echo $get_client; ?> </li>
                    <li class="active"><?php echo $pagename; ?> Bundle Confirmed</li>
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
                        <div class="col s12 card">
                            <div class="card-content">

                                <div class="row">
                                    <div class="col l6 m6 s12">
                                        <a href="bundle-confirmation" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Return</a> 
                                        &nbsp; &nbsp; 
                                        <a href="bundle-confirmation-bags?r=<?php echo $get_req; ?>" class="btns btns-read waves-effect waves-teal" style="color: teal !important"><i class="material-icons left">refresh</i> Reload Page</a>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <div class="right">
                                            <form method="post" action="app/pf/bundle-confirmation.php">
                                                <button type="submit" class="btns cyan waves-effect waves-red" name="export_excel" style="color: white !important;">
                                                    <i class="material-icons left">file_download</i> EXPORT TO EXCEL 
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <?php
                                        $evReq                  = getBundleConfirmationById($get_id);
                                        $conslocation           = $evReq['conslocation'];
                                        $audit_trail_number     = $evReq['audit_trail_number'];
                                        $confirmation_done      = $evReq['confirmation_done'];
                                        ?>
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="row center">
                                                    <div class="col l2 m2 s12">
                                                        <?php echo '<small>DATE:</small><br> <b>' . date("d/m/y", $audit_trail_number) . '</b>'; ?>
                                                    </div>
                                                    <div class="col l2 m2 s12">
                                                        <?php echo '<small>STREAM:</small><br> <b>' . $get_strim . '</b>'; ?>
                                                    </div>
                                                    <div class="col l5 m5 s12">
                                                        <?php echo '<small>CLIENT:</small><br> <b>' . $get_client . '</b>'; ?>
                                                    </div>
                                                    <div class="col l3 m3 s12">
                                                        <?php echo '<small>AUDIT TRAIL NUMBER:</small><br> <b>' . $get_client_code . '-' . $get_strim . '-' . $audit_trail_number . '</b>'; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <?php
                                            $endedOn = '';
                                            $sno = 1;
                                            $sumAmount = $sum1000 = $sum500 = $sum200 = $sum100 = $sum50 = $sum20 = $sum10 = $sum5 = $sum1 = 0;
                                            $sql = "SELECT * FROM bundleconfirmationbags WHERE bundleconfirmation_id = '$get_id' AND client = '$get_client_id' ORDER BY id DESC";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                echo '<table id="data-table-simple" class="display wrap" width="100%" cellspacing="0">';
                                                echo '<thead>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Seal No</th>
                                                            <th>Branch</th>
                                                            <th>Currency</th>
                                                            <th>1,000</th>
                                                            <th>Category</th>
                                                            <th>500</th>
                                                            <th>Category</th>
                                                            <th>200</th>
                                                            <th>Category</th>
                                                            <th>100</th>
                                                            <th>Category</th>
                                                            <th>50</th>
                                                            <th>Category</th>
                                                            <th>20</th>
                                                            <th>Category</th>
                                                            <th>10</th>
                                                            <th>Category</th>
                                                            <th>5</th>
                                                            <th>Category</th>
                                                            <th>1</th>
                                                            <th>Category</th>
                                                            <th>Total</th>
                                                            <th>By</th>
                                                        </tr>
                                                    </thead>';
                                                echo '<tbody>';
                                                while ($row = $result->fetch_assoc()) {
                                                    $bagId = $row['id'];
                                                    //Split and get main seal number
                                                    $sealPieces                 = explode("-", $row['seal_number']);
                                                    $sealNumber                 = $sealPieces[1];
                                                    //get currency
                                                    $reqCurrency                = getCurrencyById($row['currency']);
                                                    $currency                   = $reqCurrency['name'];
                                                    //get Category Data
                                                    $d1000C                     = getCategoryTypeById($row['d1000_category']);
                                                    $d1000Category              = $d1000C['name'];
                                                    $d500                       = getCategoryTypeById($row['d500_category']);
                                                    $d500Category               = $d500['name'];
                                                    $d200                       = getCategoryTypeById($row['d200_category']);
                                                    $d200Category               = $d200['name'];
                                                    $d100                       = getCategoryTypeById($row['d100_category']);
                                                    $d100Category               = $d100['name'];
                                                    $d50                        = getCategoryTypeById($row['d50_category']);
                                                    $d50Category                = $d50['name'];
                                                    $d20                        = getCategoryTypeById($row['d20_category']);
                                                    $d20Category                = $d20['name'];
                                                    $d10                        = getCategoryTypeById($row['d10_category']);
                                                    $d10Category                = $d10['name'];
                                                    $d5                         = getCategoryTypeById($row['d5_category']);
                                                    $d5Category                 = $d5['name'];
                                                    $d1                         = getCategoryTypeById($row['d1_category']);
                                                    $d1Category                 = $d1['name'];
                                                    // Get Bank rep Data
                                                    $getReqUserInfo             = $database->getUserInfo($row['added_by']);
                                                    $getClientRepFullname       = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'].' '.$getReqUserInfo['middlename'];
                                                    $getUserId                  = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
                                                    $userUID                    = base64_encode($getUserId);   
                                                    //Get Branch
                                                    $reqClientBranch            = getClientBranchNameById($row['branch']);
                                                    $clientBranch               = $reqClientBranch['name'];
                                                    // Sum Amount
                                                    $sumAmount += $row['amount'];
                                                    $sum1000 += $row['d1000_amount'];
                                                    $sum500 += $row['d500_amount'];
                                                    $sum200 += $row['d200_amount'];
                                                    $sum100 += $row['d100_amount'];
                                                    $sum50 += $row['d50_amount'];
                                                    $sum20 += $row['d20_amount'];
                                                    $sum10 += $row['d10_amount'];
                                                    $sum5 += $row['d5_amount'];
                                                    $sum1 += $row['d1_amount'];
                                                    echo '<tr>
                                                        <td>' . $sno++ . '</td>
                                                        <td>' . $sealNumber . '</td>
                                                        <td>' . $clientBranch . '</td>
                                                        <td>' . $currency . '</td>
                                                        <td>' . number_format($row['d1000_amount']) . '</td>
                                                        <td>' . $d1000Category . '</td>
                                                        <td>' . number_format($row['d500_amount']) . '</td>
                                                        <td>' . $d500Category . '</td>
                                                        <td>' . number_format($row['d200_amount']) . '</td>
                                                        <td>' . $d200Category . '</td>
                                                        <td>' . number_format($row['d100_amount']) . '</td>
                                                        <td>' . $d100Category . '</td>
                                                        <td>' . number_format($row['d50_amount']) . '</td>
                                                        <td>' . $d50Category . '</td>
                                                        <td>' . number_format($row['d20_amount']) . '</td>
                                                        <td>' . $d20Category . '</td>
                                                        <td>' . number_format($row['d10_amount']) . '</td>
                                                        <td>' . $d10Category . '</td>
                                                        <td>' . number_format($row['d5_amount']) . '</td>
                                                        <td>' . $d5Category . '</td>
                                                        <td>' . number_format($row['d1_amount']) . '</td>
                                                        <td>' . $d1Category . '</td>
                                                        <td>' . number_format($row['amount']) . '</td>
                                                        <td><a href="profile?r='.$getReqUserInfo['username'].'cprf'.$userUID .'" target="_blank" style="color: #4f2323 !important;">'.$getClientRepFullname.'</a></td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>TOTAL</th>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum1000).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum500).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum200).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum100).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum50).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum20).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum10).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum5).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sum1).'</th>
                                                            <th>&nbsp;</th>
                                                            <th>'. number_format($sumAmount).'</th>
                                                            <th>By</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>';
                                            } else {
                                                echo 'No record found.';
                                            }
                                        ?>
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

    <!-- Confirm Modal -->
    <div id="editBag" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Add New Bag To This Bundle</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding. <span class="red-text uppercase">Once Confirmed It Can't Be Edited</span>.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="clientBranchName">
                            <?php getClientBranchesList($get_client_id); ?>
                        </select>
                        <label>Client Branch Name <small class="black-text">(current: <strong id="branchName"></strong>)</small></label>
                    </div>
                    <input type="hidden" id="branchId">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="depostType">
                            <?php getDepositTypesList(); ?>
                        </select>
                        <label>Deposit Type <small class="black-text">(current: <strong id="depositTypeName"></strong>)</small></label>
                    </div>
                    <input type="hidden" id="depositTypeId">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="cashCategory" name="cashCategory">
                            <?php getCashCategoriesList(); ?>
                        </select>
                        <label>Cash Category <small class="black-text">(current: <strong id="depositCategoryName"></strong>)</small></label>
                    </div>
                    <input type="hidden" id="depositCategoryId">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="currency">
                            <?php getCurrencyTypesList(); ?>
                        </select>
                        <label>Currency <small class="black-text">(current: <strong id="currencyName"></strong>)</small></label>
                    </div>
                    <input type="hidden" id="currencyId">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="denomination">
                            <?php getDenominationTypesList(); ?>
                        </select>
                        <label>Change Denomination <small class="black-text">(current: <strong id="denominationName"></strong>)</small></label>
                    </div>
                    <input type="hidden" id="denominationId">
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="totalAmount" name="totalAmount" type="text" class="validate totalAmount" required autocomplete="off" placeholder="Amount Counted">
                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                    </div>
                </div>
                <div class="row margin" id="sealRow">
                    <div class="input-field col s12">
                        <small>Seal Numbers (Focus on the last 6 digits displayed to you and select preferred seal number)</small>
                        <select id="sealNumber" class="searchableSelect">
                            <?php getListOfSealNUmbers(); ?>
                        </select>
                    </div>
                    <input type="hidden" name="bagId" id="bagId">
                    <input type="hidden" name="bcsId" id="bcsId">
                    <input type="hidden" name="clientId" id="clientId" value="<?php echo $get_client_id; ?>">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text updateThisBag mr-3">
                <i class="material-icons left">save</i>
                Save Changes 
            </button>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteBag" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Delete This Bag From This Bundle</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12 uppercase">
                        <h6 class="black-text">This Step Is Not Reversible</h6>
                        <p class="red-text">Do Your Really Want To Delete This Bag?</p>
                    </div>
                    <input type="hidden" name="dbagId" id="bagId">
                    <input type="hidden" name="dbcsId" id="bcsId">
                    <input type="hidden" name="clientId" id="dclientId" value="<?php echo $get_client_id; ?>">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-red red white-text deleteThisBag mr-3">
                <i class="material-icons left">delete</i>
                YES DELETE BAG 
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

    <script type="text/javascript" src="assets/js/pages/bundle-confirmation.js"></script>

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