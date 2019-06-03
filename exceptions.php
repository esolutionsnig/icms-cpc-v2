<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/exceptions.php';
include 'app/core/session.php';
$pagename = 'Exceptions';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin()) {
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
                    <li class="active"><?php echo $pagename; ?></li>
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
                            <button data-target="throwExc" id="throwExcept" class="btns btns-add waves-effect waves-teal modal-trigger">
                                <i class="material-icons left">highlight_off</i>
                                Log New Exception
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                            
                                <?php 
                                    $sno = 1;
                                    $status = '';
                                    $sql = "SELECT * FROM thrown_exceptions WHERE thrown_to = '$username' ORDER BY ex_id DESC";
                                    $result = $con->query($sql);
                                
                                    if ($result->num_rows > 0) {
                                        $totalBags = 0;
                                        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                        echo '<thead>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Thrown By</th>
                                                    <th>Thrown On</th>
                                                    <th>Thrown Comment</th>
                                                    <th>Seal Number</th>
                                                    <th>Denomination</th>
                                                    <th>Expected Amount</th>
                                                    <th>Actual Counted</th>
                                                    <th>Resolution</th>
                                                    <th>Resolved By</th>
                                                    <th class="width-20">ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Thrown By</th>
                                                    <th>Thrown On</th>
                                                    <th>Thrown Comment</th>
                                                    <th>Seal Number</th>
                                                    <th>Denomination</th>
                                                    <th>Expected Amount</th>
                                                    <th>Actual Counted</th>
                                                    <th>Resolution</th>
                                                    <th>Resolved By</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>';
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            // Get Sender Data
                                            $getReqUserInfo         = $database->getUserInfo($row['thrown_by']);
                                            $senderFullName         = $getReqUserInfo['surname'].' '.$getReqUserInfo['firstname'];
                                            $getUserId              = $getReqUserInfo['username'].'------'.$getReqUserInfo['email'].'------el';
                                            $senderUID              = base64_encode($getUserId);
                                            // Get Supo Data
                                            $getSupoData            = $database->getUserInfo($row['reviewed_by']);
                                            $supoFullName           = $getSupoData['surname'].' '.$getSupoData['firstname'];
                                            $getSupoId              = $getSupoData['username'].'------'.$getSupoData['email'].'------el';
                                            $supoUID              = base64_encode($getSupoId);
                                            //Split and get main seal number 
                                            $sealPieces             = explode("-", $row['seal_number']);
                                            $tymeStamp              = $sealPieces[0];
                                            $sealNumber             = $sealPieces[1];
                                            // Get Denomination Data
                                            $getDenomination        = getDenominationById($row['denomination']);
                                            $denomination           = $getDenomination['denomination_name'];
                                            // Get Currency Data
                                            $getCurrency            = getCurrencyById($row['currency']);
                                            $CurrencySlug           = $getCurrency['currency_slug'];
                                            // Get Currencies
                                            if ($CurrencySlug == 'naira') {
                                                $currencyName = 'Nigerian Naira';
                                                $currencyIcon = '<small>&#8358;</small>';
                                            } else if ($CurrencySlug == 'euro') {
                                                $currencyName = 'European Euro';
                                                $currencyIcon = '<small>&euro;</small>';
                                            } else if ($CurrencySlug == 'gbp') {
                                                $currencyName = 'British Pounds';
                                                $currencyIcon = '<small>&#163;</small>';
                                            } else if ($CurrencySlug == 'usd') {
                                                $currencyName = 'US Dollars';
                                                $currencyIcon = '<small>&#36;</small>';
                                            } else if ($CurrencySlug == 'cny') {
                                                $currencyName = 'Chinese Yen';
                                                $currencyIcon = '<small>&#165;</small>';
                                            } else if ($CurrencySlug == 'cfa') {
                                                $currencyName = 'Centra African Republic Franc';
                                                $currencyIcon = '<small>CFA</small>';
                                            } else if ($CurrencySlug == 'zar') {
                                                $currencyName = 'South African Rand';
                                                $currencyIcon = '<small>R</small>';
                                            }
                                            echo '<tr>
                                                <td>' . $sno++ . '</td>
                                                <td><a href="profile?r='. $getReqUserInfo['username'].'cprf'.$senderUID . '" target="_blank" style="color: #4f2323 !important;">'. $senderFullName. '</a></td>
                                                <td>' . timestamp($row['thrown_on']) . '</td>
                                                <td>' . $row['thrown_comment'] . '</td>
                                                <td>' . $sealNumber . '</td>
                                                <td>' . $denomination . '</td>
                                                <td>' . $currencyIcon . number_format($row['expected_amount']) . '</td>
                                                <td>' . $currencyIcon . number_format($row['actual_amount']) . '</td>
                                                <td>' . $row['reviewed_comment'] . '</td>
                                                <td><a href="profile?r='. $getSupoData['username'].'cprf'.$supoUID . '" target="_blank" style="color: #4f2323 !important;">'. $supoFullName. '</a></td>
                                                <td>';
                                                    if ( $row['thrown_to'] == $username && $row['ex_status'] == 'Unresolved') {
                                                        echo '<button data-target="resolveException" style="margin: 6px;" class="btns btns-add waves-effect waves-light triggerBtn modal-trigger" data-exid="' . $row['ex_id'] . '"> Resolve Issue <i class="material-icons left">local_pharmacy</i> </button>';
                                                    } else {
                                                        echo 'Resolved';
                                                    }
                                                echo '</td>
                                            </tr>';
                                        }
                                        echo '</tbody>
                                        </table>';
                                    } else {
                                        echo 'No known exception found.';
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

    <!-- Start Modal -->
    <div id="throwExc" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Throw An Exception</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding. Use The Form Below To Report Any Issue With The Content Of The Bag You Are Confirming</p>
            </div>
            <div class="modal-body">
                <h6>&nbsp;</h6>
                <div class="row margin">
                    <div class="input-field col l5 m5 s12">
                        <select  class="searchableSelect" id="supo">
                            <option value="">Select Your Supervisor's Name</option>
                            <?php getUsersList(); ?>
                        </select>
                    </div>
                    <div class="input-field col l2 m2 s10">
                        <select id="exceptionsealnumber" class="searchableSelect">
                            <option value="">Seal Number</option>
                            <?php getListOfSealNUmbersNotBundleConfirmed($signed_location_id); ?>
                        </select>
                    </div>
                    <div class="input-field col l3 m3 s12">
                        <select id="currenc">
                            <option value="">Currency</option>
                            <?php getCurrencyTypesList(); ?>
                        </select>
                    </div>
                    <div class="input-field col l2 m2 s12">
                        <select id="denom">
                            <option value="">Denomination</option>
                            <?php getDenominationTypesList(); ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s12">
                        <input id="expectedAmount" type="text" class="validate">
                        <label for="expectedAmount">Expected Amount </label>
                        <h5 class="blue-grey-text bold" id="showExpectedAmount"></h5>
                    </div>
                    <div class="input-field col l6 m6 s12">
                        <input id="actualAmount" type="text" class="validate">
                        <label for="actualAmount">Actual Amount</label>
                        <h5 class="blue-grey-text bold" id="showActualAmount"></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="thrownComment" class="materialize-textarea validate"></textarea>
                        <label for="expectedAmount">Your Reasons </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text addExceptions mr-3">
                <i class="material-icons right">send</i>
                Send Exception 
            </button>
        </div>
    </div>

    <!-- Resolution Modal -->
    <div id="resolveException" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Exception Handler</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <h6>&nbsp;</h6>
                <input type="hidden" name="exId" id="exId">
                <div class="row margin">
                    <div class="input-field col s12">
                        <textarea id="reviewedComment" class="materialize-textarea validate"></textarea>
                        <label for="reviewedComment">Your Observation &amp; Resolution </label>
                    </div>
                </div>
                <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text resolveThisException mr-3">
                <i class="material-icons left">local_pharmacy</i>
                Resolve
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

    <script type="text/javascript" src="assets/js/pages/exceptions.js"></script>

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