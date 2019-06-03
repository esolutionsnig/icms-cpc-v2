<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/supply-requests.php';
include 'app/core/session.php';
$pagename = 'Client Supply Requests';
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
          <div class="container">
            <div class="section">
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      
                      <?php
                        $sno = 1;
                        $sql = "SELECT * FROM supply_requests ORDER BY sr_id DESC";
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
                                        <th>ACTIONS</th>
                                    </tr>
                                </tfoot>
                                <tbody>';
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                                $bUID = $row['sr_id'].'------'.$row['sr_slug'].'------el';
                                $bankUID = base64_encode($bUID);
                                //get client name
                                $reqClientName      = getClientNameById($row['client']);
                                $clientName         = $reqClientName['bank_name'];
                    
                                $citConfirmationToken = $row['sr_id'] . 'cittoken18' . time() . 'cittoken18' . $row['client'];
                    
                                echo '<tr>
                                    <td>' . $sno++ . '</td>
                                    <td>' . $clientName . '</td>
                                    <td><a href="supply-request-r?r=' . $row['sr_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['sr_title'] . '</a></td>
                                    <td>' . $row['sr_type'] . '</td>
                                    <td>' . $row['sr_date'] . '</td>';
                                    echo '<td><strong>'; number_format(getTotalBranchSupplyRequest($row['sr_id'])); echo '</strong> Branch(es)</td>
                                    <td>
                                        <a href="client-supply-request-r?r=' . $row['sr_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
                                            View  <i class="material-icons left">link</i>
                                        </a>
                                    </td>
                                </tr>';
                            }
                            echo '</tbody>
                            </table>';
                        } else {
                            echo 'No request found.';
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