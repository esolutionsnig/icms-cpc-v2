<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/internal-movement.php';
include 'app/core/session.php';
$pagename = 'Internal Movement';
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
                                <h5 class="breadcrumbs-title">
                                    <?php echo $pagename; ?>
                                </h5>
                                <ol class="breadcrumbs">
                                    <li><a href="./">Dashboard</a></li>
                                    <li class="active">
                                        <?php echo $pagename; ?>
                                    </li>
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
                                <button class="btns btns-add waves-effect waves-teal newMovements">
                                    <i class="material-icons left">add</i> Move Consignments 
                                </button>
                            </div>
                        </div>
                    </div>

                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <h6 class="header center blue-grey-text uppercase">
                                            Internal Movement Table <small class="black-text">Use The Search Form To Sort / Filter The Records.</small>
                                        </h6>
                                        <?php getInternalMovements(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col l3 m3 s12">
                                <div class="card">
                                    <div class="card-content" style="min-height: 500px;">
                                        <h6 class="header blue-grey-text center uppercase">
                                            Infomation
                                        </h6>
                                        <ul class="collection">
                                            <li class="collection-item">Select The Source Location (i.e Where The Consignment Is Coming From)</li>
                                            <li class="collection-item">Select The Destination Location (i.e Where The Consignment Is Going To)</li>
                                            <li class="collection-item">Enter / Scan The Seal Numbers In Their Respective Fields</li>
                                            <li class="collection-item">To Add More Seal Numbers, Click The Add New Row Button To Auto-Generate Seal Number Row</li>
                                            <li class="collection-item">To Remove Seal Numbers, Click The Remove Row Button To Automatically Remove The Row With Its Content</li>
                                            <li class="collection-item">Remove Empty Rows If Mistakenly Add</li>
                                            <li class="collection-item">Click The Move Consignment Button To Save Changes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col l9 m9 s12" id="moveConsignments">
                                <div class="card">
                                    <div class="card-content" style="min-height: 900px;">

                                        <h6 class="header center blue-grey-text uppercase">
                                            Internal Movement Form <small class="red-text">Ensure You Confirm The Seal Number Before Send The Consignment</small>
                                        </h6>

                                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

                                        <div class="row margin">
                                            <div class="input-field col s12">
                                                <select id="sourceLocation">
                                                    <?php getConsignmentLocationsList(); ?>
                                                </select>
                                                <label>Source Location</label>
                                            </div>
                                        </div>
                                        <div class="row margin">
                                            <div class="input-field col s12 center">
                                                <i class="material-icons">arrow_downward</i>
                                            </div>
                                        </div>
                                        <div class="row margin">
                                            <div class="input-field col s12">
                                                <select id="destinationLocation">
                                                    <?php getConsignmentLocationsList(); ?>
                                                </select>
                                                <label>Destination Location</label>
                                            </div>
                                        </div>

                                        <div class="field_wrapper">
                                            <div class="row margin" id="sealRow">
                                                <div class="input-field col l10 m10 s9">
                                                    <input id="sealNumbers[]" name="sealNumbers[]" type="text" class="validate autocomplete sealNumbers" required autocomplete="off">
                                                    <label for="sealNumbers">Seal Number (Focus on the last 6 digits displayed to you and select preferred seal number)</label>
                                                    <small class="red-text" id="sealNumberStatus"></small>
                                                </div>
                                                <div class="input-field col l2 m2 s3">
                                                    <button class="btns btns-add waves-effect waves-light add_button" title="Add Another Seal Number Row">
                                                        <i class="material-icons left">add</i> New Row
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col s12">
                                                <h6 class="uppercase blue-grey-text center">
                                                    You have added <strong class="black-text sealNumberRowCounter"> &nbsp; 1 &nbsp; </strong> seal number(s)
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="input-field col s12">
  <select multiple>
    <option value="" disabled selected>Choose your option</option>
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
  </select>
</div>

                                        <div class="row margin">
                                            <div class="input-field col s12 center">
                                                <button class="btn waves-effect waves-light teal white-text moveToNewLocation">
                                                    <i class="material-icons right">send</i>
                                                    Move Consignments
                                                </button>
                                            </div>
                                        </div>

                                        <span id="ishere" tabindex='1'></span>

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

    <!-- Add Modal -->
    <div id="moveOne" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Move Consignment To New Location</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <label for="sealNumberCurrentLocation">Current Location (Source Location)</label>
                    <div class="input-field col s12">
                        <input id="sealNumberCurrentLocation" name="sealNumberCurrentLocation" type="text" class="validate sealNumberCurrentLocation" required autocomplete="off" readonly>
                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                        <input type="hidden" id="sealNumberCurrentLocationCode">
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="sealNumberDestinationLocation">
                            <?php getConsignmentLocationsList(); ?>
                        </select>
                        <label>Destination Location</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="ssealNumber" name="ssealNumber" type="text" class="validate ssealNumber" required autocomplete="off">
                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                        <input type="hidden" id="sealNumberId">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text moveOneConsignment mr-3">
                <i class="material-icons right">send</i>
                Move Consignment 
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

    <script type="text/javascript" src="assets/js/pages/internal-movement.js"></script>

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