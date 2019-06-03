<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/day-shift-management.php';
include 'app/core/session.php';
$pagename = 'Day &amp; Shift Management';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() || $session->isCMO()) {

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
                            <div class="col l6 m6 s12">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="left">
                                            <button data-target="startDay" class="btns btns-add waves-effect waves-teal  modal-trigger">
                                                <i class="material-icons left">alarm_on</i> Start New Day 
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-content">
                                        <h6 class="header center blue-grey-text uppercase">
                                            Day Management Table <small class="black-text">Use The Search Form To Sort / Filter The Records.</small>
                                        </h6>
                                        <?php 
                                            $sno = 1;
                                            $sql = "SELECT * FROM day_shift ORDER BY id DESC";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                echo '<table id="caTable" class="display wrap" width="100%" cellspacing="0">';
                                                echo '<thead>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Title</th>
                                                            <th>Day</th>
                                                            <th>Started</th>
                                                            <th>Started By</th>
                                                            <th>Closed</th>
                                                            <th>Closed By</th>
                                                            <th>Closed On</th>
                                                            <th>Status</th>
                                                            <th>ACTIONS</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Title</th>
                                                            <th>Day</th>
                                                            <th>Started</th>
                                                            <th>Started By</th>
                                                            <th>Closed</th>
                                                            <th>Closed By</th>
                                                            <th>Closed On</th>
                                                            <th>Status</th>
                                                            <th>ACTIONS</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>';
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    // Get Day Started User
                                                    $rowGUD                 = $database->getUserInfo($row['dstarted_by']);
                                                    $dayStartedBy           = $rowGUD['surname'].' '.$rowGUD['firstname'].' '.$rowGUD['middlename'];
                                                    $getUserId              = $rowGUD['username'].'------'.$rowGUD['email'].'------el';
                                                    $userUID                = base64_encode($getUserId);
                                                    // Get Get Day Closed User
                                                    $rowGUD2                = $database->getUserInfo($row['dclosed_by']);
                                                    $dayClosedBy            = $rowGUD2['surname'].' '.$rowGUD2['firstname'].' '.$rowGUD2['middlename'];
                                                    $getCitId               = $rowGUD2['username'].'------'.$rowGUD2['email'].'------el';
                                                    $citUID                 = base64_encode($getCitId);
                                                    echo '<tr>
                                                    <td>' . $sno++ . '</td>
                                                    <td>' . $row['dstart_title'] . '</td>
                                                    <td>'; echo timestamp($row['dday']) ; echo '</td>
                                                    <td>' . $row['dstarted'] . '</td>
                                                    <td><a href="profile?r='.$rowGUD['username'].'cprf'.$userUID .'" target="_blank" style="color: #4f2323 !important;">'.$dayStartedBy.'</a></td>
                                                    <td>' . $row['dclosed'] . '</td>
                                                    <td><a href="profile?r='.$rowGUD2['username'].'cprf'.$citUID .'" target="_blank" style="color: #4f2323 !important;">'.$dayClosedBy.'</a></td>
                                                    <td>'; if ( $row['dclosed_on'] != '' ) { echo timestamp($row['dclosed_on']) ; } echo '</td>
                                                    <td>' . $row['dstatus'] . '</td>
                                                    <td>';
                                                    if ( $row['dclosed'] == 'YES' ) {
                                                        echo '<button data-target="restoreDay" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text openDayBtn modal-trigger uppercase" data-id="' . $row['id'] . '"> <i class="material-icons left">restore</i> Restore 
                                                        </button> &nbsp; ';
                                                    } else {
                                                        echo '<button data-target="closeDay" class="btns btns-edit waves-effect waves-light red darken-4 lighten-1 white-text closeDayBtn modal-trigger uppercase" data-id="' . $row['id'] . '"> <i class="material-icons left">alarm_off</i> Close 
                                                        </button> &nbsp; ';
                                                    }
                                                    echo'</td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                </table>';
                                            } else {
                                                echo 'No day started';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col l6 m6 s12">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="right">
                                            <button data-target="startShift" class="btns btns-add waves-effect waves-teal  modal-trigger">
                                                <i class="material-icons left">alarm_on</i> Start New Shift 
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-content">
                                        <h6 class="header center blue-grey-text uppercase">
                                            Shift Management Table <small class="black-text">Use The Search Form To Sort / Filter The Records.</small>
                                        </h6>
                                        <?php 
                                            $snum = 1;
                                            $sql = "SELECT * FROM shifts_day ORDER BY id DESC";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                echo '<table id="caTablez" class="display wrap" width="100%" cellspacing="0">';
                                                echo '<thead>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Day</th>
                                                            <th>Shift</th>
                                                            <th>Started</th>
                                                            <th>Started By</th>
                                                            <th>Started On</th>
                                                            <th>Closed?</th>
                                                            <th>Closed By</th>
                                                            <th>Closed On</th>
                                                            <th>Status</th>
                                                            <th>ACTIONS</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>S/No</th>
                                                            <th>Day</th>
                                                            <th>Shift</th>
                                                            <th>Started</th>
                                                            <th>Started By</th>
                                                            <th>Started On</th>
                                                            <th>Closed?</th>
                                                            <th>Closed By</th>
                                                            <th>Closed On</th>
                                                            <th>Status</th>
                                                            <th>ACTIONS</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>';
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    // Get Day Started User
                                                    $rowGUD                 = $database->getUserInfo($row['sstarted_by']);
                                                    $dayStartedBy           = $rowGUD['surname'].' '.$rowGUD['firstname'].' '.$rowGUD['middlename'];
                                                    $getUserId              = $rowGUD['username'].'------'.$rowGUD['email'].'------el';
                                                    $userUID                = base64_encode($getUserId);
                                                    // Get Get Day Closed User
                                                    $rowGUD2                = $database->getUserInfo($row['sclosed_by']);
                                                    $dayClosedBy            = $rowGUD2['surname'].' '.$rowGUD2['firstname'].' '.$rowGUD2['middlename'];
                                                    $getCitId               = $rowGUD2['username'].'------'.$rowGUD2['email'].'------el';
                                                    $citUID                 = base64_encode($getCitId);
                                                    // Get Day Info
                                                    $rowDS                  = getDayShift($row['day_id']);
                                                    $dayTitle               = $rowDS['dstart_title'];
                                                    echo '<tr>
                                                    <td>' . $snum++ . '</td>
                                                    <td>' . $dayTitle . '</td>
                                                    <td>' . $row['stitle'] . '</td>
                                                    <td>'; echo $row['sstarted'] ; echo '</td>
                                                    <td><a href="profile?r='.$rowGUD['username'].'cprf'.$userUID .'" target="_blank" style="color: #4f2323 !important;">'.$dayStartedBy.'</a></td>
                                                    <td>'; echo timestamp($row['sstarted_on']) ; echo '</td>
                                                    <td>' . $row['sclosed'] . '</td>
                                                    <td><a href="profile?r='.$rowGUD2['username'].'cprf'.$citUID .'" target="_blank" style="color: #4f2323 !important;">'.$dayClosedBy.'</a></td>
                                                    <td>'; if ( $row['sclosed_on'] != '' ) { echo timestamp($row['sclosed_on']) ; } echo '</td>
                                                    <td>' . $row['sstatus'] . '</td>
                                                    <td>';
                                                    if ( $row['sclosed'] == 'YES' ) {
                                                        echo '<button data-target="restoreShift" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text openShiftBtn modal-trigger uppercase" data-id="' . $row['id'] . '"> <i class="material-icons left">restore</i> Restore 
                                                        </button> &nbsp; ';
                                                    } else {
                                                        echo '<button data-target="closeShift" class="btns btns-edit waves-effect waves-light red darken-4 lighten-1 white-text closeShiftBtn modal-trigger uppercase" data-id="' . $row['id'] . '"> <i class="material-icons left">alarm_off</i> Close 
                                                        </button> &nbsp; ';
                                                    }
                                                    echo'</td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                </table>';
                                            } else {
                                                echo 'No shift started';
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
    <div id="startDay" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Start A New Day</h4>
                <p class="subtitle">Ensure you are ready and have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="dayStartTitle" name="dayStartTitle" type="text" class="validate dayStartTitle" required autocomplete="off">
                        <label for="dayStartTitle">Title</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text startNewDay mr-3">
                <i class="material-icons right">send</i>
                Start New Day
            </button>
        </div>
    </div>

    <!-- Close Modal -->
    <div id="closeDay" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Day Closure</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="col s12">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="dsId" id="dsId">
                        <?php 
                            $sno = 1;
                            $sql = "SELECT * FROM internal_movements WHERE destination_location != '4' AND destination_location != '5' AND destination_location != '8' AND destination_location != '9' ORDER BY im_id DESC";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // Can'tcClose day
                                echo '<h5 class="uppercase red-text">You can not close the day until the consignments listed in the table below are moved to either Vault Room or Supervisor Desk</h5>';
                                echo '<table id="caTables" class="display wrap" width="100%" cellspacing="0">';
                                echo '<thead>
                                        <tr>
                                            <th>S/No</th>
                                            <th>Seal Number</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>S/No</th>
                                            <th>Seal Number</th>
                                            <th>Location</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>';
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    //Split and get main seal number
                                    $sealPieces             = explode("-", $row['seal_number']);
                                    $tymeStamp              = $sealPieces[0];
                                    $sealNumber             = $sealPieces[1];
                                    //get consignement 
                                    $reqConsLoc             = getConsignmentLocationById($row['destination_location']);
                                    $consignmentLocation    = $reqConsLoc['location_name'];
                                    echo '<tr>
                                        <td>' . $sno++ . '</td>
                                        <td>' . $sealNumber. '</td>
                                        <td>' . $consignmentLocation. '</td>
                                    </tr>';
                                }
                                echo '</tbody>
                                </table>';
                            } else {
                                // Close day
                                echo '<h5 class="uppercase teal-text">You can close the day by click the close day button below</h5>';
                                echo '<button class="btn waves-effect waves-light teal white-text closeThisDayBtn mr-3">
                                    <i class="material-icons left">save</i>
                                    Close This Day 
                                </button>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        </div>
    </div>

    <!-- Restore Modal -->
    <div id="restoreDay" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Day Restore</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="col s12">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="dsId" id="dsId">
                        <h5 class="uppercase black-text">You are about to change this day status from closed to open, do you want to proceed?</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text restoreThisDayBtn mr-3">
                <i class="material-icons left">save</i>
                Yes Restore This Day
            </button>
        </div>
    </div>

    <!-- Start Modal -->
    <div id="startShift" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Start A New Shift</h4>
                <p class="subtitle">Ensure you are ready and have the right permission before proceeding</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="input-field col  s12">
                        <select  class="searchableSelect" id="dayId">
                            <option value="">Select Day</option>
                            <?php getDays(); ?>
                        </select>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <input id="shiftStartTitle" name="shiftStartTitle" type="text" class="validate shiftStartTitle" required autocomplete="off">
                        <label for="shiftStartTitle">Title</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <select id="sshift">
                            <option value="">Select Shift</option>
                            <option value="Morning">Morning Shift</option>
                            <option value="Afternoon">Afternoon Shift</option>
                            <option value="Evening">Evening Shift</option>
                        </select>
                        <label>Shift</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
            <button class="btn waves-effect waves-light teal white-text startNewShift mr-3">
                <i class="material-icons right">send</i>
                Start New Shift
            </button>
        </div>
    </div>

    <!-- Close Modal -->
    <div id="closeShift" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Shift Closure</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="col s12">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="ssId" id="ssId">
                        <?php 
                            $cantEndShift = false;
                            $sql = "SELECT * FROM bundle_confirmation_start WHERE confirmation_done != 'YES'";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                $cantEndShift = true;
                                echo '<h5 class="uppercase red-text">You can not close shift because there is one or more active bundle confirmation.</h5>';
                            }
                            $sql = "SELECT * FROM cash_allocations WHERE counted_value = '0'";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                $cantEndShift = true;
                                echo '<h5 class="uppercase red-text">You can not close shift because there is one or more active cash allocation.</h5>';
                            }
                            if ( $cantEndShift == false ) {
                                echo '<button class="btn waves-effect waves-light teal white-text closeThisShiftBtn mr-3">
                                    <i class="material-icons left">save</i>
                                    Close This Shift 
                                </button>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
        </div>
    </div>

    <!-- Restore Modal -->
    <div id="restoreShift" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Shift Restore</h4>
                <p class="subtitle">Ensure you have the right permission before proceeding.</p>
            </div>
            <div class="modal-body">
                <div class="row margin">
                    <div class="col s12">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="ssId" id="ssId">
                        <h5 class="uppercase black-text">You are about to change this shift status from closed to open, do you want to proceed?</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
            <button class="btn waves-effect waves-light teal white-text restoreThisShiftBtn mr-3">
                <i class="material-icons left">save</i>
                Yes Restore This Shift
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

    <script type="text/javascript" src="assets/js/pages/day-shift-management.js"></script>

    <script>
        $(document).ready(function() {
            $('#caTable').DataTable( {
                // "scrollY": 300,
                "scrollX": true
            })
            $('#caTables').DataTable( {
                // "scrollY": 300,
                // "scrollX": true
            })
            $('#caTablez').DataTable( {
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