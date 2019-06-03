<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/sealings.php';
include 'app/core/session.php';
$pagename = 'Actual Stock Position';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive()) {
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
              <?php
                $amountInBoxroom = getAmountWithStaff(8);
                // Get Amount In ACV
                $amountInACV = getAmountWithStaff(9);
                // Get Amount In AEV
                $amountInAEV = getAmountWithStaff(10);
                // Get Amount In BCA1
                $amountInBCA1 = getAmountWithStaff(17);
                // Get Amount In BCA2
                $amountInBCA2 = getAmountWithStaff(18);
                // Get Amount In PF1
                $amountInPF1 = getAmountWithStaff(19);
                // Get Amount In PF2
                $amountInPF2 = getAmountWithStaff(20);
                // Get Grand Total
                $grandTotal = $amountInACV + $amountInAEV + $amountInBCA1 + $amountInBCA2 + $amountInBoxroom + $amountInPF1 + $amountInPF2;
              ?>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l4 m4 s12 is-clickable boxroom">
                          <div class="card red darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Boxroom</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInBoxroom); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                        <div class="col l4 m4 s12 is-clickable acv">
                          <div class="card purple darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Awaiting Confirmation Vault</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInACV); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                        <div class="col l4 m4 s12 is-clickable aev">
                          <div class="card pink darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Awaiting Evaluation Vault</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInAEV); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col l4 m4 s12 is-clickable bca1">
                          <div class="card cyan darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Bundle Confirmation Area 1</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInBCA1); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                        <div class="col l4 m4 s12 is-clickable bca2">
                          <div class="card light-blue darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Bundle Confirmation Area 2</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInBCA2); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                        <div class="col l4 m4 s12 is-clickable pf1">
                          <div class="card grey darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Processing Floor 1</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInPF1); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col l4 m4 s12 is-clickable pf2">
                          <div class="card brown darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Amount In Processing Floor 2</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($amountInPF2); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                        <div class="col l8 m8 s12 pf2">
                          <div class="card orange darken-4 white-text">
                            <div class="card-content">
                              <p class="uppercase"> Total Amount In Cash Processing Center</p>
                              <h4><span style="font-weight: 100">&#8358;</span><strong><?php echo number_format($grandTotal); ?></strong></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Boxroom -->
              <div id="boxroom" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Boxroom</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInBoxroom); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="red darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '8'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="red darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="red darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="red darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="red darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="red darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="red darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong class="deepred-text" style="font-size: 24px"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
              
              <!-- ACV -->
              <div id="acv" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Awaiting Confirmation Vault</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInACV); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="purple darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '9'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="purple darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="purple darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="purple darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="purple darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="purple darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="purple darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong style="font-size: 24px; color: #4a148c"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
              
              <!-- AEV -->
              <div id="aev" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Awaiting Evaluation Vault</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInAEV); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="pink darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '10'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="pink darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="pink darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="pink darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="pink darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="pink darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="pink darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong style="font-size: 24px; color: #880e4f;"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
              
              <!-- BCA1 -->
              <div id="bca1" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Bundle Confirmation Area 1</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInBCA1); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="cyan darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '17'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="cyan darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="cyan darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="cyan darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="cyan darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="cyan darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="cyan darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong style="font-size: 24px; color: #006064;"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
              
              <!-- BCA2 -->
              <div id="bca2" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Bundle Confirmation Area 2</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInBCA2); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="light-blue darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '18'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="light-blue darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="light-blue darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="light-blue darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="light-blue darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="light-blue darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="light-blue darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong style="font-size: 24px; color: #01579b;"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
              
              <!-- PF1 -->
              <div id="pf1" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Processing Floor Supervisor 1</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInPF1); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="grey darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '19'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="grey darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="grey darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="grey darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="grey darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="grey darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="grey darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong style="font-size: 24px; color: #212121;"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
              
              <!-- PF2 -->
              <div id="pf2" style="height:35px"></div>
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <div class="row">
                        <div class="col l8 m8 s12">
                          <h4 class="uppercase header blue-grey-text">Processing Floor Supervisor 2</h4>
                        </div>
                        <div class="col l4 m4 s12">
                          <h4 class="uppercase header blue-grey-text">
                            <span style="font-weight: 100">total amount: &#8358;</span>
                            <strong><?php echo number_format($amountInPF2); ?></strong>
                          </h4>
                        </div>
                      </div>

                      <table class="striped highlight responsive-table">
                        <thead>
                          <tr class="brown darken-4 white-text">
                            <th style="width: 15%">&nbsp;</th>
                            <th>1,000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $totalMintCash1k = $totalMintCash5h = $totalMintCash2h = $totalMintCash1h = $totalMintCash50 = $totalMintCash20 = $totalMintCash10 = $totalMintCash5 = 0;
                          $totalAtmCash1k = $totalAtmCash5h = $totalAtmCash2h = $totalAtmCash1h = $totalAtmCash50 = $totalAtmCash20 = $totalAtmCash10 = $totalAtmCash5 = 0;
                          $totalFitCash1k = $totalFitCash5h = $totalFitCash2h = $totalFitCash1h = $totalFitCash50 = $totalFitCash20 = $totalFitCash10 = $totalFitCash5 = 0;
                          $totalUnfitCash1k = $totalUnfitCash5h = $totalUnfitCash2h = $totalUnfitCash1h = $totalUnfitCash50 = $totalUnfitCash20 = $totalUnfitCash10 = $totalUnfitCash5 = 0;
                          $totalUnprocessedCash1k = $totalUnprocessedCash5h = $totalUnprocessedCash2h = $totalUnprocessedCash1h = $totalUnprocessedCash50 = $totalUnprocessedCash20 = $totalUnprocessedCash10 = $totalUnprocessedCash5 = 0;
                          $totalCollatedCash = $totalCollatedCash1k = $totalCollatedCash5h = $totalCollatedCash2h = $totalCollatedCash1h = $totalCollatedCash50 = $totalCollatedCash20 = $totalCollatedCash10 = $totalCollatedCash5 = 0;
                          $results = array();
                          $sql = "SELECT DISTINCT seal_number FROM internalmovements WHERE destination_location = '20'";
                          $result = $con->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $seal_number = $row['seal_number'];
                              array_push($results, $seal_number);
                            }
                          }
                          // Get 1k Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1k += getTotalMintCash1k($snumber);
                          }
                          // Get 5h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5h += getTotalMintCash5h($snumber);
                          }
                          // Get 2h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash2h += getTotalMintCash2h($snumber);
                          }
                          // Get 1h Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash1h += getTotalMintCash1h($snumber);
                          }
                          // Get 50 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash50 += getTotalMintCash50($snumber);
                          }
                          // Get 20 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash20 += getTotalMintCash20($snumber);
                          }
                          // Get 10 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash10 += getTotalMintCash10($snumber);
                          }
                          // Get 5 Mint Cash
                          foreach($results as $snumber){
                            $totalMintCash5 += getTotalMintCash5($snumber);
                          }
                          // Get Total Mint Cash
                          $totalMintCash = $totalMintCash1k + $totalMintCash5h + $totalMintCash2h + $totalMintCash1h + $totalMintCash50 + $totalMintCash20 + $totalMintCash10 + $totalMintCash5;

                          // Get 1k Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1k += getTotalAtmCash1k($snumber);
                          }
                          // Get 5h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5h += getTotalAtmCash5h($snumber);
                          }
                          // Get 2h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash2h += getTotalAtmCash2h($snumber);
                          }
                          // Get 1h Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash1h += getTotalAtmCash1h($snumber);
                          }
                          // Get 50 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash50 += getTotalAtmCash50($snumber);
                          }
                          // Get 20 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash20 += getTotalAtmCash20($snumber);
                          }
                          // Get 10 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash10 += getTotalAtmCash10($snumber);
                          }
                          // Get 5 Atm Cash
                          foreach($results as $snumber){
                            $totalAtmCash5 += getTotalAtmCash5($snumber);
                          }
                          // Get Total Atm Cash
                          $totalAtmCash = $totalAtmCash1k + $totalAtmCash5h + $totalAtmCash2h + $totalAtmCash1h + $totalAtmCash50 + $totalAtmCash20 + $totalAtmCash10 + $totalAtmCash5;

                          // Get 1k Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1k += getTotalFitCash1k($snumber);
                          }
                          // Get 5h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5h += getTotalFitCash5h($snumber);
                          }
                          // Get 2h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash2h += getTotalFitCash2h($snumber);
                          }
                          // Get 1h Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash1h += getTotalFitCash1h($snumber);
                          }
                          // Get 50 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash50 += getTotalFitCash50($snumber);
                          }
                          // Get 20 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash20 += getTotalFitCash20($snumber);
                          }
                          // Get 10 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash10 += getTotalFitCash10($snumber);
                          }
                          // Get 5 Fit Cash
                          foreach($results as $snumber){
                            $totalFitCash5 += getTotalFitCash5($snumber);
                          }
                          // Get Total Fit Cash
                          $totalFitCash = $totalFitCash1k + $totalFitCash5h + $totalFitCash2h + $totalFitCash1h + $totalFitCash50 + $totalFitCash20 + $totalFitCash10 + $totalFitCash5;

                          // Get 1k Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1k += getTotalUnfitCash1k($snumber);
                          }
                          // Get 5h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5h += getTotalUnfitCash5h($snumber);
                          }
                          // Get 2h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash2h += getTotalUnfitCash2h($snumber);
                          }
                          // Get 1h Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash1h += getTotalUnfitCash1h($snumber);
                          }
                          // Get 50 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash50 += getTotalUnfitCash50($snumber);
                          }
                          // Get 20 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash20 += getTotalUnfitCash20($snumber);
                          }
                          // Get 10 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash10 += getTotalUnfitCash10($snumber);
                          }
                          // Get 5 Unfit Cash
                          foreach($results as $snumber){
                            $totalUnfitCash5 += getTotalUnfitCash5($snumber);
                          }
                          // Get Total Unfit Cash
                          $totalUnfitCash = $totalUnfitCash1k + $totalUnfitCash5h + $totalUnfitCash2h + $totalUnfitCash1h + $totalUnfitCash50 + $totalUnfitCash20 + $totalUnfitCash10 + $totalUnfitCash5;

                          // Get 1k Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1k += getTotalUnprocessedCash1k($snumber);
                          }
                          // Get 5h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5h += getTotalUnprocessedCash5h($snumber);
                          }
                          // Get 2h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash2h += getTotalUnprocessedCash2h($snumber);
                          }
                          // Get 1h Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash1h += getTotalUnprocessedCash1h($snumber);
                          }
                          // Get 50 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash50 += getTotalUnprocessedCash50($snumber);
                          }
                          // Get 20 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash20 += getTotalUnprocessedCash20($snumber);
                          }
                          // Get 10 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash10 += getTotalUnprocessedCash10($snumber);
                          }
                          // Get 5 Unprocessed Cash
                          foreach($results as $snumber){
                            $totalUnprocessedCash5 += getTotalUnprocessedCash5($snumber);
                          }
                          // Get Total Unprocessed Cash
                          $totalUnprocessedCash = $totalUnprocessedCash1k + $totalUnprocessedCash5h + $totalUnprocessedCash2h + $totalUnprocessedCash1h + $totalUnprocessedCash50 + $totalUnprocessedCash20 + $totalUnprocessedCash10 + $totalUnprocessedCash5;
                          
                          // Get Total Collated Cash 1k
                          $totalCollatedCash1k = $totalMintCash1k + $totalAtmCash1k + $totalFitCash1k + $totalUnfitCash1k + $totalUnprocessedCash1k;
                          // Get Total Collated Cash 5h
                          $totalCollatedCash5h = $totalMintCash5h + $totalAtmCash5h + $totalFitCash5h + $totalUnfitCash5h + $totalUnprocessedCash5h;
                          // Get Total Collated Cash 2h
                          $totalCollatedCash2h = $totalMintCash2h + $totalAtmCash2h + $totalFitCash2h + $totalUnfitCash2h + $totalUnprocessedCash2h;
                          // Get Total Collated Cash 1h
                          $totalCollatedCash1h = $totalMintCash1h + $totalAtmCash1h + $totalFitCash1h + $totalUnfitCash1h + $totalUnprocessedCash1h;
                          // Get Total Collated Cash 50
                          $totalCollatedCash50 = $totalMintCash50 + $totalAtmCash50 + $totalFitCash50 + $totalUnfitCash50 + $totalUnprocessedCash50;
                          // Get Total Collated Cash 20
                          $totalCollatedCash20 = $totalMintCash20 + $totalAtmCash20 + $totalFitCash20 + $totalUnfitCash20 + $totalUnprocessedCash20;
                          // Get Total Collated Cash 10
                          $totalCollatedCash10 = $totalMintCash10 + $totalAtmCash10 + $totalFitCash10 + $totalUnfitCash10 + $totalUnprocessedCash10;
                          // Get Total Collated Cash 5
                          $totalCollatedCash5 = $totalMintCash5 + $totalAtmCash5 + $totalFitCash5 + $totalUnfitCash5 + $totalUnprocessedCash5;
                          // Get Grand Total Collated Cahs
                          $totalCollatedCash = $totalMintCash + $totalAtmCash + $totalFitCash + $totalUnfitCash + $totalUnprocessedCash;
                        ?>
                          <tr>
                            <td class="brown darken-4 white-text uppercase">mint</td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalMintCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalMintCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="brown darken-4 white-text uppercase">atm fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalAtmCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalAtmCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="brown darken-4 white-text uppercase">Teller fit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalFitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalFitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="brown darken-4 white-text uppercase">Teller unfit notes</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnfitCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnfitCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="brown darken-4 white-text uppercase">Awaiting Evaluation (Unprocessed Cash)</td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1k); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash2h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash1h); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash50); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash20); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash10); ?></td>
                            <td><small>&#8358;</small><?php echo number_format($totalUnprocessedCash5); ?></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalUnprocessedCash); ?></strong></td>
                          </tr>
                          <tr>
                            <td class="brown darken-4 white-text uppercase">Total</td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1k); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash2h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash1h); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash50); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash20); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash10); ?></strong></td>
                            <td><small>&#8358;</small><strong class="black-text" style="font-size: 17px"><?php echo number_format($totalCollatedCash5); ?></strong></td>
                            <td><small>&#8358;</small><strong style="font-size: 24px; color: #3e2723;"><?php echo number_format($totalCollatedCash); ?></strong></td>
                          </tr>
                          <tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- SIDE STICKY MENU -->
          <ul id="rsmenu" style="font-size: 14px">
            <li class="is-clickable boxroom">Box room</li>
            <li class="is-clickable acv">AC Vault</li>
            <li class="is-clickable aev">AE Vault</li>
            <li class="is-clickable bca1">BC 1</li>
            <li class="is-clickable bca2">BC 2</li>
            <li class="is-clickable pf1">PF 1</li>
            <li class="is-clickable pf2">PF 2</li>
          </ul>
    

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

    <script type="text/javascript" src="assets/js/pages/sealings.js"></script>

    <script>
      $(".boxroom").click(function() {
        $('html, body').animate({
          scrollTop: $("#boxroom").offset().top
        }, 2000)
      })
      $(".acv").click(function() {
        $('html, body').animate({
          scrollTop: $("#acv").offset().top
        }, 2000)
      })
      $(".aev").click(function() {
        $('html, body').animate({
          scrollTop: $("#aev").offset().top
        }, 2000)
      })
      $(".bca1").click(function() {
        $('html, body').animate({
          scrollTop: $("#bca1").offset().top
        }, 2000)
      })
      $(".bca2").click(function() {
        $('html, body').animate({
          scrollTop: $("#bca2").offset().top
        }, 2000)
      })
      $(".pf1").click(function() {
        $('html, body').animate({
          scrollTop: $("#pf1").offset().top
        }, 2000)
      })
      $(".pf2").click(function() {
        $('html, body').animate({
          scrollTop: $("#pf2").offset().top
        }, 2000)
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