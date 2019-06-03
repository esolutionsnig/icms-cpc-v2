<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
include 'app/pf/evacuation-requests.php';
$pagename = 'Financial Control';
//Check user loggin stats and user level
if($session->logged_in){
    if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isAccount() ) { 
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
                    <li><a href="executive-dashboard"><?php echo $pagename; ?></a></li>
                    <li class="active">Overview Of Client Account Balance &amp; Billing</li>
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

                <!--card stats start-->
                <div id="card-stats">
                    <div class="row mt-1">

                        <?php
                            // Get Amount In The Building
                            $amountInBuilding = $amountInTransit = $grandTotal = 0;
                            $grandTotal = getTotalAmountExecustiveView();
                            $amountInTransit = getTotalCit('naira');
                            $amountInBuilding = $grandTotal - $amountInTransit;
                        ?>

                        <!-- Expecting -->
                        <div class="col l3 m3 s12">
                            <h4 class="header uppercase blue-grey-text">
                                <i class="material-icons left deepred-text">local_shipping</i> Cash In Transit 
                            </h4>
                            <div class="card  gradient-shadow min-height-100">
                                <div class="padding-4">
                                    <div class="col s3 m3">
                                        <small>&nbsp;<br></small>
                                        <span class="background-round mt-5"><?php echo currencyIconn('naira'); ?></span>
                                        <p>Naira</p>
                                    </div>
                                    <div class="col s9 m9 right-align">
                                        <h4 class="mb-0"><?php echo number_format($amountInTransit); ?></h4>
                                        <p class="no-margin">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- In The Building -->
                        <div class="col l4 m4 s12">
                            <h4 class="header uppercase blue-grey-text">
                                <i class="material-icons left deepred-text">home</i> Cash In Building 
                            </h4>
                            <div class="card  gradient-shadow min-height-100">
                                <div class="padding-4">
                                    <div class="col s3 m3">
                                        <small>&nbsp;<br></small>
                                        <span class="background-round mt-5"><?php echo currencyIconn('naira'); ?></span>
                                        <p>Naira</p>
                                    </div>
                                    <div class="col s9 m9 right-align">
                                        <h4 class="mb-0"><?php echo number_format($amountInBuilding); ?></h4>
                                        <p class="no-margin">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Total Amount -->
                        <div class="col l5 m5 s12">
                            <h4 class="header uppercase blue-grey-text">
                                <i class="material-icons left deepred-text">account_balance_wallet</i> Total Amount In ICMS Custody 
                            </h4>
                            <div class="card  gradient-shadow min-height-100">
                                <div class="padding-4">
                                    <div class="col s3 m3">
                                        <small>&nbsp;<br></small>
                                        <span class="background-round mt-5"><?php echo currencyIconn('naira'); ?></span>
                                        <p>Naira</p>
                                    </div>
                                    <div class="col s9 m9 right-align">
                                        <h4 class="mb-0"><?php echo number_format($grandTotal); ?></h4>
                                        <p class="no-margin">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                </div>
            </div>
            <!--end container-->

            <div class="container">
                <div class="section">

                  <div class="row">
                    <div class="s12">
                      <div class="card">
                        <div class="card-content">
                          
                          <div class="row">
                            <div class="col s12">
                              <h4 class="uppercase header blue-grey-text">
                                list of clients and summary of services rendered to them 
                                <span class="right">
                                  <button data-target="queryEvacReqs" class="btn primary-btn white-text waves-effect waves-teal queryEvacReqs modal-trigger glowingBtn">
                                    <i class="material-icons left">search</i> Run Query 
                                  </button>
                                </span>
                              </h4>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col s12" id="searchResult"></div>
                          </div>

                          <div class="row">
                            <div class="col s12">
                              <?php
                                $sno = 1;
                                $totalAmountPrepared = 0;
                                $sql = "SELECT * FROM bank_requests WHERE cit = 'YES' ORDER BY er_id DESC";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                                    echo '<thead>
                                            <tr>
                                                <th>S/No</th>
                                                <th>Request Title</th>
                                                <th>Client</th>
                                                <th>Branch Location</th>
                                                <th>Destination</th>
                                                <th>Prepared</th>
                                                <th>Total Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S/No</th>
                                                <th>Request Title</th>
                                                <th>Client</th>
                                                <th>Branch Location</th>
                                                <th>Destination</th>
                                                <th>Prepared</th>
                                                <th>Total Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        $bUID = $row['er_id'].'------'.$row['er_slug'].'------el';
                                        $bankUID = base64_encode($bUID);
                                        //get client name
                                        $reqClientName      = getClientNameById($row['bank_id']);
                                        $clientName         = $reqClientName['bank_name'];
                                        //get consignement 
                                        $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
                                        $consignmentLocation    = $reqConsLoc['location_name'];
                            
                                        $citConfirmationToken = $row['er_id'] . 'cittoken18' . time() . 'cittoken18' . $row['bank_id'];
                                        // Get Total Amount Prepared
                                        $totalAmountPrepared = getTotalAmountPreparedBagsPerRequest($row['er_id']);
                                        echo '<tr>
                                            <td>' . $sno++ . '</td>
                                            <td><a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['er_name'] . '</a></td>
                                            <td>' . $clientName . '</td>
                                            <td>' . $row['location_code'] . '</td>
                                            <td>'. $consignmentLocation .'</a></td>';
                                            echo '<td><strong>'; number_format(getNumberPreparedBagsPerRequest($row['er_id'])); echo '</strong> Bag(s)</td>
                                            <td><h5>'.number_format($totalAmountPrepared).'</h5></td>
                                            <td>'. $row['date_execution'].'</td>
                                        </tr>';
                                    }
                                    echo '</tbody>
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
            </div>

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

    <div id="queryEvacReqs" class="modal">
      <div class="modal-content">
        <div class="modal-header uppercase">
          <h4 class="title">Client Transaction Search Engine</h4>
        </div>
        <div class="modal-body">   

          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

          <div class="row">
            <div class="input-field col s12">
              <small>Client</small>
              <select id="clientName" class="searchableSelect">
                <option value="">Select Client</option>
                <?php getClients(); ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="input-field col l6 m6 s12">
              <small>Start Date</small>
              <input id="startDate" name="startDate" type="date" class="validate" required>
            </div>
            <div class="input-field col l6 m6 s12">
              <small>End Date</small>
              <input id="endDate" name="endDate" type="date" class="validate" required>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-light btn-flat left">Close</button>
        <div class="right">
          <button class="btn waves-effect waves-light teal white-text processRequest">
            <i class="material-icons left">search</i> Run Query
          </button>
        </div>
      </div>
    </div>

    <?php include 'layouts/foot.php'; ?>

    <!--prism-->
    <script type="text/javascript" src="assets/vendors/prism/prism.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <!--data-tables.js -->
    <script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>

    <script type="text/javascript" src="assets/js/pages/financial-control.js"></script>

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