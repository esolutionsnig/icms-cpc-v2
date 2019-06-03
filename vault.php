<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
$pagename = 'Vault';
//Check user loggin stats and user level
if($session->logged_in){
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
                    <li><a href="./"><?php echo $pagename; ?></a></li>
                    <li class="active">Overview of activities</li>
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

              <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
              <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

              <div class="row">
                <div class="col l3 m3 s12">
                  <div class="card">
                    <div class="card-content" style="min-height: 400px;">
                      <div id="card-stats">
                        <div class="row">

                          <div class="col s12">
                            <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text is-clickable viewActualStockPosition">
                              <div class="padding-4">
                                <div class="col s3 m3">
                                  <i class="material-icons background-round mt-5">assignment</i>
                                </div>
                                <div class="col s9 m9 right-align">
                                  <p class="uppercase"> Actual Stock Position</p>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col s12">
                            <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text is-clickable viewActualStockCount">
                              <div class="padding-4">
                                <div class="col s3 m3">
                                  <i class="material-icons background-round mt-5">assignment_turned_in</i>
                                </div>
                                <div class="col s9 m9 right-align">
                                  <p class="uppercase"> Actual Stock Count</p>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- <div class="col l4 m4 s12">
                            <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text is-clickable takeIntoStorage">
                              <div class="padding-4">
                                <div class="col s3 m3">
                                  <i class="material-icons background-round mt-5">add_shopping_cart</i>
                                </div>
                                <div class="col s9 m9 right-align">
                                  <p class="uppercase">Take Into Storage</p>
                                </div>
                              </div>
                            </div>
                          </div> -->

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col l9 m9 s12">
                
                  <div id="card-widgets" class="viewActualStockPositionDiv">
                    <div class="row">
                      <div class="col s12">
                        <div class="card" style="border-left: 6px solid #ff5252;">
                          <div class="card-content uppercase" style="min-height: 400px;">
                            <h5 class="blue-grey-text center">Actual Stock Position </h5>

                            <div class="row margin">
                              <div class="input-field col l7 m7 s12">
                                <select id="clientUid" class="searchableSelect">
                                  <option value="">Select Client </option>
                                  <?php getClients(); ?>
                                </select>
                              </div>
                              <div class="input-field col l5 m5 s12">
                                <select id="categoryUid" class="searchableSelect">
                                  <option value="">Select Cash Category </option>
                                  <?php getCashCategoriesList(); ?>
                                </select>
                              </div>
                            </div>
                            <h5>&nbsp;</h5>
                            <div class="row margin">
                              <div class="input-field col l4 m4 s12">
                                <select id="currencyUid" class="searchableSelect">
                                  <option value="">Select Currency </option>
                                  <?php getCurrencyTypesList(); ?>
                                </select>
                              </div>
                              <div class="input-field col l4 m4 s12">
                                <select id="denominationUid" class="searchableSelect">
                                  <option value="">Select Denomination </option>
                                  <?php getDenominationTypesList(); ?>
                                </select>
                              </div>
                              <div class="input-field col l4 m4 s12">
                                <button class="btn waves-effect waves-light teal white-text fetchStock mr-3">
                                  <i class="material-icons right">send</i>
                                  Fetch Stock 
                                </button>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col s12 mt-5">
                                <div class="input-field loadingData"></div>
                                <div id="loadStock"></div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="card-widgets" class="viewActualStockCountDiv">
                    <div class="row">
                      <div class="col s12">
                        <div class="card" style="border-left: 6px solid #ff6f00;">
                          <div class="card-content" style="min-height: 400px;">
                            
                            <div class="row">
                              <div class="col s12 center uppercase">
                                <h5 class="blue-grey-text">Actual Stock Count </h5>
                              </div>
                            </div>
                            
                            <div class="row">
                              <div class="col s12">
                                <?php
                                  $sno = 1;
                                  $sum1000 = $sum500 = $sum200 = $sum100 = $sum50 = $sum20 = $sum10 = $sum5 = $sum1 = $sumAmount = 0;
                                  $sql = " SELECT * FROM sealings WHERE location_id = '$signed_location_id' ";
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
                                          <th>Denomination</th>
                                          <th>Amount</th>
                                          <th>Seal Number</th>
                                          <th>Is Opened?</th>
                                        </tr>
                                      </thead>';
                                      echo '<tfoot>
                                        <tr>
                                          <th>S/No</th>
                                          <th>Title</th>
                                          <th>Client</th>
                                          <th>Location</th>
                                          <th>Category</th>
                                          <th>Container</th>
                                          <th>Denomination</th>
                                          <th>Amount</th>
                                          <th>Seal Number</th>
                                          <th>Is Opened?</th>
                                        </tr>
                                      </tfoot>';
                                    echo '<tbody>';
                                    while ($row = $result->fetch_assoc()) {
                                      $s_id             = $row['s_id'];
                                      $sealing_title    = $row['sealing_title'];
                                      $client           = $row['client'];
                                      $location_id      = $row['location_id'];
                                      $category_id      = $row['category_id'];
                                      $denomination_id  = $row['denomination_id'];
                                      $container_id     = $row['container_id'];
                                      $amount           = $row['amount'];
                                      $seal_number      = $row['seal_number'];
                                      $is_opened        = $row['is_opened'];
                                      // Get Currencies
                                      $currency = $row['currency_id'];
                                      if ($currency == '1') {
                                        $currencyName = 'Nigerian Naira';
                                        $currencyIcon = '&#8358;';
                                      } else if ($currency == '2') {
                                        $currencyName = 'European Euro';
                                        $currencyIcon = '&euro;';
                                      } else if ($currency == '3') {
                                        $currencyName = 'US Dollars';
                                        $currencyIcon = '&#36;';
                                      } else if ($currency == '4') {
                                        $currencyName = 'British Pounds';
                                        $currencyIcon = '&#163;';
                                      } else if ($currency == '5') {
                                        $currencyName = 'South African Rand';
                                        $currencyIcon = 'R';
                                      } else if ($currency == '6') {
                                        $currencyName = 'Centra African Republic Franc';
                                        $currencyIcon = 'CFA';
                                      } else if ($currency == '7') {
                                        $currencyName = 'Chinese Yen';
                                        $currencyIcon = '&#165;';
                                      }
                                      //get client name
                                      $reqClientName          = getClientNameById($client);
                                      $clientName             = $reqClientName['bank_name'];
                                      //Split and get main seal number
                                      $sealPieces             = explode("-", $seal_number);
                                      $tymeStamp              = $sealPieces[0];
                                      $sealNumber             = $sealPieces[1];
                                      //get consignement 
                                      $reqConsLoc             = getConsignmentLocationById($location_id);
                                      $consignmentLocation    = $reqConsLoc['location_name'];
                                      //get denomination
                                      $reqDenomination        = getDenominationById($denomination_id);
                                      $denomination           = $reqDenomination['denomination_name'];
                                      // Get Container Name
                                      $getContainerType       = getContainerType($container_id);
                                      $containerType          = $getContainerType['ct_name'];
                                      // Get Cash Category Name
                                      $getCategoryType        = getCategoryTypeById($category_id);
                                      $cashCategory           = $getCategoryType['dc_name'];
                                      echo '<tr>
                                        <td>' . $sno++ . '</td>
                                        <td>' . $sealing_title . '</td>
                                        <td>' . $clientName . '</td>
                                        <td>' . $consignmentLocation . '</td>
                                        <td>' . $cashCategory . '</td>
                                        <td>' . $containerType . '</td>
                                        <td>' . $denomination . '</td>
                                        <td>' . '<small>' . $currencyIcon . '</small>' . number_format($amount) . '</td>
                                        <td>' . $sealNumber . '</td>
                                        <td>' . $is_opened . '</td>
                                      </tr>';
                                    }
                                    echo '</tbody>
                                    </table>';
                                  } else {
                                    echo 'No record found. ';
                                  }
                                ?>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- <div id="card-widgets" class="takeIntoStorageDiv">
                    <div class="row">
                      <div class="col s12">
                        <div class="card" style="border-left: 6px solid #0288d1;">
                          <div class="card-content" style="min-height: 500px;">
                            <h5 class="blue-grey-text center uppercase">Take into storage</h5>
                            
                            <div class="row margin" id="sealRow">
                              <div class="input-field col l3 m3 s3">
                                <small>Seal Number</small>
                                <select id="qSealNumber" class="searchableSelect">
                                  <option value="">Select Seal Number</option>
                                  <?php //getNewlySealedBags($signed_location_id); ?>
                                </select>
                              </div>
                              <div class="input-field col l1 m1 s2 loadingData"></div>
                              <div class="input-field col l8 m8 s7">
                                <small>Client</small>
                                <select id="clientIdd" class="searchableSelect">
                                  <option value="">Select Client </option>
                                  <?php // getClients(); ?>
                                </select>
                              </div>
                            </div>

                            <h6>&nbsp;</h6>
                            <div class="row">
                              <div class="col s12">
                                <div id="loadBag"></div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col s12">
                                <div class="right">
                                  <button class="btn waves-effect waves-light teal white-text saveIntoStorage">
                                    <i class="material-icons left">save</i>
                                    Save Into Storage
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->

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

    <div id="confirmCount" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Stock Counting Confirmation</h4>
        </div>
        <div class="modal-body">

          <p class="uppercase red-text">Are Sure You Have Confirmed This Consignment?</p>
          <input type="hidden" name="vId" id="vId">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No I Have Not</a>
        <button class="btn waves-effect waves-light teal white-text confirmVaultCount mr-3">
          <i class="material-icons left">done_all</i>
          YES I HAVE 
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

    <script type="text/javascript" src="assets/js/pages/vault.js"></script>

    <script>
        $(".takeIntoStorageDiv").hide()
        // $(".viewActualStockPositionDiv").hide()
        $(".viewActualStockCountDiv").hide()
    
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
  header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>