<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/cash-allocation.php';
include 'app/core/session.php';
$pagename = 'New Cash Allocation';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin()) {
        $cid = getClientId($session->username);
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
                    <li><a href="cash-allocation"> Cash Allocations</a></li>
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
                    <a href="cash-allocation" class="btns btns-delete waves-effect waves-teal" style="color: white !important"><i class="material-icons left">keyboard_backspace</i> Done &amp; Return</a>
                  </div>
                </div>
              </div>

              <input type="hidden" name="bankId" id="bankId" value="<?php echo $cid; ?>">
              <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
              <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">


                <div class="row">
                    <div class="col l8 m8 s12">
                        <div class="card">
                            <div class="card-content" style="min-height: 600px;">

                                <div id="preAssignment" style="margin-bottom: 30px;">
                                    <div class="row margin">
                                        <div class="input-field col l3 m3 s12">
                                            <select id="sealNumber" class="searchableSelect" required>
                                                <option value="">Select Seal Number</option>
                                                <?php getListOfResealedNUmbers(); ?>
                                            </select>
                                        </div>
                                        <div class="col l1 m1 s12">
                                            <div class="loadingData"></div>
                                        </div>
                                        <div class="input-field col l8 m8 s12">
                                            <h5 id="currentSealNumber" class="red-text" style="font-weight: 300 !important; font-size: 20px;"></h5>
                                            <input type="hidden" id="chosenSealNumber">
                                        </div>
                                    </div>
                                </div>

                                <div id="loadBag"></div>
                                
                                <div id="loadNoBag">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="row center">
                                                <div class="col s12">
                                                    <h5 class="orange-text uppercase center">You Have Assigned All Cash In This Bag. Please Pick Another Bag.</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="assignment" class="card">
                                    <div class="card-content">
                                        <h4 class="header center blue-grey-text">Cash Allocation Form </h4>
                                        <div class="row margin">
                                            <div class="input-field col l6 m6 s12">
                                                <select id="allocatedTo" required>
                                                    <option value="">Select Whom You Are Assigning Cash To</option>
                                                    <?php getProcessors(); ?>
                                                </select>
                                                <label>Processor (Teller)</label>
                                            </div>
                                            <div class="input-field col l6 m6 s12">
                                                <select id="workstation" required>
                                                    <option value="">Select Processor's Work Station</option>
                                                    <?php getWorkStationLists(); ?>
                                                </select>
                                                <label>Processor's Work Station</label>
                                            </div>
                                        </div>
                                        <div class="row margin">
                                            <div class="input-field col l4 m4 s12">
                                                <input type="text" id="allocatedCash" placeholder="Enter The Amount Of Cash Being Allocated">
                                                <label for="assignedCash">Allocate Cash</label>
                                                <h5 class="blue-grey-text amountAllocated"></h5>
                                                <input type="hidden" id="shift" value="<?php echo $yourCurrentShift; ?>">
                                            </div>
                                            <div class="col l8 m8 s12">
                                                <div class="right" style="margin-top: 30px;">
                                                    <button class="btn waves-effect waves-light teal white-text saveCashAllocation">
                                                        <i class="material-icons left">save</i>
                                                        Allocate Cash To <span id="allocatee"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col l4 m4 s12">
                    <div class="card">
                        <div class="card-content">
                        
                        <h4 class="header center blue-grey-text">Information</h4>
                        
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

    <script type="text/javascript" src="assets/js/pages/cash-allocation.js"></script>

    <script>
        $("#cashPreparation").hide()
        $("#assignment").hide()
        $("#loadNoBag").hide()

        $(document).ready(function(){
            $('.clientName.autocomplete').autocomplete({
                data: {<?php
                    $sql = " SELECT * FROM banks ORDER BY bank_name ASC ";
                    $result = $con->query($sql);
                    $clientData = array();
                    if ($result->num_rows > 0) {
                        $counta = 0;
                        while ($row = $result->fetch_assoc()) {
                            if ($counta++ > 0) echo ",";
                            echo '"' . $row['bank_name'] . '": null'; 
                        }
                    }
                    ?>
                },
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