<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'Branch Cash Supply Request ';
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
        $cid         = $srData['client_id'];
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
                        <a href="supply-requests" class="btns btns-delete waves-effect waves-teal" style="color: white !important">
                            <i class="material-icons left">keyboard_backspace</i> Back 
                        </a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col l5 m5 s12">

                  <div class="card">
                    <div class="card-content" style="min-height: 750px;">
                      
                        <h5 class="center blue-grey-text"><?php echo $pagename . ' <small>for</small> <strong class="black-text">' . $srName . '</strong>'; ?></h5>

                        <input type="hidden" name="srId" id="srId" value="<?php echo $get_id; ?>">
                        <input type="hidden" name="srClient" id="srClient" value="<?php echo $cid; ?>">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

                        <div class="row" style="margin: 30px 6px;">
                            <div class="col s12">
                                <h6 class="header">Branch Cash Request</h6>
                            </div>
                        </div>

                        <div class="row margin" style="margin-top: 30px !important;">
                          <div class="input-field col s12">
                            <small>Requesting Branch</small>
                            <select id="clientBranch" class="searchableSelect" required>
                              <option value="">Select The Requesting Branch</option>
                              <?php getClientBranhcesLists($cid); ?>
                            </select>
                          </div>
                        </div>

                        <div class="row margin" style="margin-top: 30px !important;">
                            <div class="input-field col l4 m4 s12">
                                <small>Cash Denomination</small>
                                <select id="denomination" class="searchableSelect" required>
                                  <?php getDenominationTypesList(); ?>
                                </select>
                            </div>
                            <div class="input-field col l8 m8 s12">
                                <small>Cash Category</small>
                                <select id="cashCategory" class="searchableSelect" required>
                                  <?php getCategoryTypeLists(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row margin" style="margin-top: 30px !important;">
                            <div class="input-field col l4 m4 s12">
                                <small>Cash Currency</small>
                                <select id="currency" class="searchableSelect" required>
                                  <?php getCurrencyTypesList(); ?>
                                </select>
                            </div>
                            <div class="input-field col l8 m8 s12">
                                <input id="amount" name="amount" type="text" onkeypress="return isNumber(event)" class="validate" required autocomplete="off">
                                <label for="amount">Amount</label>
                                <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                <div id="enteredAmount"></div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px;">
                          <div class="col s12">
                              <div class="right">
                                  <button class="btn waves-effect waves-teal teal white-text saveBranchRequest">
                                      <i class="material-icons left">save</i>
                                      Save Branch Request 
                                  </button>
                              </div>
                          </div>
                        </div>

                    </div>
                  </div>
                </div>
                <div class="col l7 m7 s12">
                    <div class="card">
                        <div class="card-content" style="min-height: 750px;">
                            <h6 class="header uppercase blue-grey-text center">Cash Requested </h6>
                            <?php
                                $sno = 1;
                                $currencyIcon = '';
                                $sql = "SELECT * FROM supplybranches WHERE supply_id = '$get_id' AND is_deleted = 'NO' ORDER BY id DESC";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                                    echo '<thead>
                                            <tr>
                                                <th>S/No</th>
                                                <th>Branch Name</th>
                                                <th>Den</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S/No</th>
                                                <th>Branch Name</th>
                                                <th>Den</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        $currency = $row['currency'];
                                        $denomination = $row['denomination'];
                                        $cash_category = $row['cash_category'];
                                        $branch = $row['branch'];
                                        $amount = $row['amount'];
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
                                        echo '<tr>
                                                <td>' . $sno++ . '</td>
                                                <td>' . $branchName . '</td>
                                                <td>' . number_format($denoName) . '</td>
                                                <td>' . $cashCategory . '</td>
                                                <td><span style="font-weight: 100">' . $currencyIcon . '</span><strong>' . number_format($amount) . '</strong></td>
                                                <td><button data-target="deleteRequest" class="btns btns-delete waves-effect waves-light white-text modal-trigger deleteRequest uppercase" data-id="'.$row['id'].'" data-bname="'.$branchName.'" >
                                                <i class="material-icons left">delete_forever</i>delete</button></td>
                                            </tr>
                                        ';
                                    }
                                    echo '</tbody>
                                    </table>';
                                } else {
                                    echo 'No record found';
                                }
                            ?>
                            <h5>&nbsp;</h5>
                            <h6 class="header uppercase blue-grey-text center">Useful Tips</h6>

                        </div>
                    </div>
                </div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col s12">
                      <div class="center">
                          <button class="btn waves-effect waves-cyan cyan white-text doneCloseSupplyRequest" >
                              <i class="material-icons left">done_all</i>
                              Done, Close Supply Request
                          </button>
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
    
    <!-- Add Branch Modal -->
    <div id="deleteRequest" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Branch Supply Request</h4>
          <p class="subtitle">Ensure you have the right permission before proceeding</p>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col s12">
              <h5 class="red-text">Are sure you want to delete this <strong id="brnchName" class="black-text"></strong> branch request?</h5>
            </div>
          </div>

          <input type="hidden" name="bId" id="bId">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No</a>
        <button class="btn waves-effect waves-light primary-btn white-text deleteBranchRequest mr-3">
          <i class="material-icons left">delete_forever</i>
          Yes, Delete This Request
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