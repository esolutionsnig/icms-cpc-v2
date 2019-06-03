<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'Supply Requests';
//Check user loggin stats and user level
if ($session->logged_in) {
  if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isBanker() || $session->isBankerCmu() ) {
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
          <?php if ( $session->isAdmin() || $session->isSuperAdmin() ){ ?>
            <div class="container">
              <div class="section">
                <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
                        
                        <?php
                          $sno = 1;
                          $dispatchStatus = '';
                          $sql = "SELECT * FROM supplies ORDER BY id DESC";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                              echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                              echo '<thead>
                                      <tr>
                                          <th>S/No</th>
                                          <th>Client</th>
                                          <th>Request Title</th>
                                          <th>Request Type</th>
                                          <th>Supply Date</th>
                                          <th>Total Request</th>
                                          <th>Total Amount</th>
                                          <th>ACTIONS</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                      <tr>
                                          <th>S/No</th>
                                          <th>Client</th>
                                          <th>Request Title</th>
                                          <th>Request Type</th>
                                          <th>Supply Date</th>
                                          <th>Total Request</th>
                                          <th>Total Amount</th>
                                          <th>ACTIONS</th>
                                      </tr>
                                  </tfoot>
                                  <tbody>';
                              // output data of each row
                              while ($row = $result->fetch_assoc()) {
                                  $bUID = $row['id'].'------'.$row['sr_slug'].'------el';
                                  $bankUID = base64_encode($bUID);
                                  //get client name
                                  $reqClientName      = getClientNameById($row['client_id']);
                                  $clientName         = $reqClientName['bank_name'];
                      
                                  $citConfirmationToken = $row['id'] . 'cittoken18' . time() . 'cittoken18' . $row['client_id'];
                      
                                  echo '<tr>
                                      <td>' . $sno++ . '</td>
                                      <td>' . $clientName . '</td>
                                      <td><a href="supply-request-r?r=' . $row['sr_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['sr_title'] . '</a></td>
                                      <td>' . $row['sr_type'] . '</td>
                                      <td>' . $row['sr_date'] . '</td>';
                                      echo '<td><strong>'; number_format(getTotalBranchSupplyRequest($row['id'])); echo '</strong> Branch(es)</td>
                                      <td><h4>' . number_format(getTotalAmountPerSupplyRequest($row['id'])) . '</h4></td>
                                      <td>
                                          <a href="supply-request-r?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                                              View  <i class="material-icons left">link</i>
                                          </a>
                                          ';
                                          if ($session->isBankerCmu()) {
                                            if ( $row['bp_done'] == 'NO' ) {
                                                echo '<a href="supply-request-e?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns light-blue waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                                Edit Request <i class="material-icons left">edit</i>
                                                </a>';
                                                echo '<a href="supply-request-p?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns btns-delete waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                                Prepare Branch Request <i class="material-icons left">local_mall</i>
                                                </a>';
                                              }
                                          }
                                          echo '
                                      </td>
                                  </tr>';
                              }
                              echo '</tbody>
                              </table>';
                          } else {
                              echo 'No request found. <a href="supply-request-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Supply Request</a>';
                          }
                        ?>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } else {
            // Get client ID
            $userBankId = getClientId($username);
            //get client name
            $reqClientName      = getClientNameById($userBankId);
            $clientName         = $reqClientName['bank_name'];
            // Computer Book & Account Balance
            $bookBalance = $clientAccountBalance = 0;
            $bookBalance = getClientBookBalance($userBankId);
            $undeliveredSupplyRequest = getUndeliveredSupplyRequest($userBankId);
            $clientAccountBalance = $bookBalance - $undeliveredSupplyRequest; 
          ?>
            <div class="container">
              <div class="section">
                <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
                        <h4 class="uppercase blue-grey-text header">
                          <span style="font-weight: 100">Client:</span> <?php echo $clientName; ?>
                        </h4>
                        <div class="row">
                          <div class="col l6 m6 s12">
                            <div class="card teal darken-2 white-text">
                              <div class="card-content center">
                                <h5><span style="font-weight: 100">Account Balance</span></h5>
                                <h2><?php echo number_format($clientAccountBalance); ?></h2>
                              </div>
                            </div>
                          </div>
                          <div class="col l6 m6 s12">
                            <div class="card orange darken-2 white-text">
                              <div class="card-content center">
                                <h5><span style="font-weight: 100">Book Balance</span></h5>
                                <h2><?php echo number_format($bookBalance); ?></h2>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s12">
                            <h5>
                              Amount withdrawable: <strong><?php echo number_format($clientAccountBalance); ?></strong>. Need more cash? 
                              <button class="btn white teal-text waves-effect waves-teal btn-large">
                                <i class="material-icons left">account_balance_wallet</i>
                                Click here To Request For Cash Inflow
                              </button>
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container">
              <div class="section">
                <div class="row">
                  <div class="col s12">
                    <div class="right">
                      <a href="supply-request-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Supply Request</a>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
                        
                        <?php
                          $sno = 1;
                          $sql = "SELECT * FROM supplies WHERE client_id = '$userBankId' ORDER BY id DESC";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                              echo '<table id="data-table-noscroll" class="responsive-table display" cellspacing="0">';
                              echo '<thead>
                                      <tr>
                                          <th>S/No</th>
                                          <th>Client</th>
                                          <th>Request Title</th>
                                          <th>Request Type</th>
                                          <th>Supply Date</th>
                                          <th>Total Request</th>
                                          <th>Total Amount</th>
                                          <th>ACTIONS</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                      <tr>
                                          <th>S/No</th>
                                          <th>Client</th>
                                          <th>Request Title</th>
                                          <th>Request Type</th>
                                          <th>Supply Date</th>
                                          <th>Total Request</th>
                                          <th>Total Amount</th>
                                          <th>ACTIONS</th>
                                      </tr>
                                  </tfoot>
                                  <tbody>';
                              // output data of each row
                              while ($row = $result->fetch_assoc()) {
                                  $bUID = $row['id'].'------'.$row['sr_slug'].'------el';
                                  $bankUID = base64_encode($bUID);
                                  //get client name
                                  $reqClientName      = getClientNameById($row['client_id']);
                                  $clientName         = $reqClientName['bank_name'];
                      
                                  $citConfirmationToken = $row['id'] . 'cittoken18' . time() . 'cittoken18' . $row['client_id'];
                      
                                  echo '<tr>
                                      <td>' . $sno++ . '</td>
                                      <td>' . $clientName . '</td>
                                      <td><a href="supply-request-r?r=' . $row['sr_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['sr_title'] . '</a></td>
                                      <td>' . $row['sr_type'] . '</td>
                                      <td>' . $row['sr_date'] . '</td>';
                                      echo '<td><strong>'; number_format(getTotalBranchSupplyRequest($row['id'])); echo '</strong> Branch(es)</td>
                                      <td>' . number_format(getTotalAmountPerSupplyRequest($row['id'])) . '</td>
                                      <td>
                                          <a href="supply-request-r?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                                              View  <i class="material-icons left">link</i>
                                          </a>
                                          ';
                                          if ($session->isBankerCmu()) {
                                            if ( $row['bp_done'] == 'NO' ) {
                                              echo '<a href="supply-request-e?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns light-blue waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                              Edit Request <i class="material-icons left">edit</i>
                                              </a>';
                                              echo '<a href="supply-request-p?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns btns-delete waves-effect waves-light" style="color: white !important; margin: 3px !important;">
                                              Prepare Branch Request <i class="material-icons left">local_mall</i>
                                              </a>';
                                            } else {
                                              echo '<button data-target="donePreparingReq" class="btns btns-add waves-effect waves-teal donePreparingReq modal-trigger" data-id="' . $row['id'].'"> Done </button>';
                                            }
                                          }
                                          echo '
                                      </td>
                                  </tr>';
                              }
                              echo '</tbody>
                              </table>';
                          } else {
                              echo 'No request found. <a href="supply-request-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Supply Request</a>';
                          }
                        ?>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
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