<?php
//Add functions file
include 'app/core/db2.php';
include 'app/core/functions.php';
include 'app/pf/user-management.php';
include 'app/core/session.php';
$pagename = 'User Management';
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
                    <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                    <!--start container-->
                    <div class="container">
                        <div class="section">
                            <div class="row">
                                <div class="col s12">
                                    <div class="right">
                                        <a href="register" class="btns btns-add waves-effect waves-teal uppercase" style="color: #fff !important;">
                                            <i class="material-icons left">add</i> Add New USer Account
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l8 m8 s12">
                                    <div class="card">
                                        <div class="card-content" id="load-banks">
                                            <h5 class="uppercase header blue-grey-text">Registered And Approved Users</h5>
                                            <?php
                                                $sno = 1;
                                                $udimage = '';
                                                $sql = "SELECT * FROM users WHERE registration_status = 'Approved' ORDER BY surname ASC";
                                                $result = $con->query($sql);
                                                if ($result->num_rows > 0) {
                                                    echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
                                                    echo '<thead>
                                                            <tr>
                                                                <th>S/No</th>
                                                                <th>Display Image</th>
                                                                <th>Surname</th>
                                                                <th>First Name</th>
                                                                <th>Gender</th>
                                                                <th>Phone Number</th>
                                                                <th>Email Address</th>
                                                                <th>Last Seen</th>
                                                                <th>Assigned Level</th>
                                                                <th style="width: 10%">ACTIONS</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>S/No</th>
                                                                <th>Display Image</th>
                                                                <th>Surname</th>
                                                                <th>First Name</th>
                                                                <th>Gender</th>
                                                                <th>Phone Number</th>
                                                                <th>Email Address</th>
                                                                <th>Last Seen</th>
                                                                <th>Assigned Level</th>
                                                                <th>ACTIONS</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>';
                                                    // output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        $ufname = $row['surname']. ' ' . $row['firstname'];
                                                        if (!empty($row['userdp'])){
                                                            $udimage = '<img src="assets/images/avatar/'.$row['userdp'].'" width="200" alt="avatar" class="circle responsive-img valign profile-image red darken-4 b2">';
                                                        } else {
                                                            $udimage = '<img src="assets/images/avatar/avatar-12.png" width="200" alt="avatar" class="circle responsive-img valign profile-image red darken-4 b2">';
                                                        }
                                                        echo '<tr>
                                                            <td>'.$sno++.'</td>
                                                            <td>' . $udimage . '</td>
                                                            <td>' . $row['surname'] . '</td>
                                                            <td>' . $row['firstname'] . '</td>
                                                            <td>' . $row['gender'] . '</td>
                                                            <td>' . $row['phoneno'] . '</td>
                                                            <td><a href="mailto:' . $row['email'] . '" style="color: #607d8b  !important;">' . $row['email'] . '</a></td>
                                                            <td>' ; timestamp($row['timestamp']); echo '</td>
                                                            <td>'; getUserLevel($row['username']); echo '</td>
                                                            <td>
                                                                <button data-target="changeAccessLevel" class="btns btns-edit waves-effect waves-light blue lighten-1 white-text changeAccessLevel modal-trigger m-10" data-id="' . $row['username'] . '" data-ufname="' . $ufname . '" >Change Access Level </button>
                                                            </td>
                                                        </tr>';
                                                    }
                                                    echo '</tbody>
                                                    </table>';
                                                } else {
                                                    echo 'No user found. <a href="register" class="btns btn-add waves-effect waves-red white blue-grey-text ml-3"><i class="material-icons left">add</i> Click Here To Add New User Account</a>';
                                                }
                                            ?>
                                        
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col l4 m4 s12">
                                    <div class="card">
                                        <div class="card-content" id="load-banks">
                                            <h5 class="uppercase header blue-grey-text">Users Pending Approvals</h5>
                                            <?php
                                                $sn = $sno = 1;
                                                $udimage = $registrationStatus = $registrationStatusBar = '';
                                                $sql = "SELECT * FROM users WHERE registration_status = 'Pending' ORDER BY surname ASC";
                                                $result = $con->query($sql);
                                                if ($result->num_rows > 0) {
                                                    echo '<table id="caTable" class="responsive-table display" cellspacing="0">';
                                                    echo '<thead>
                                                            <tr>
                                                                <th>S/No</th>
                                                                <th>Name</th>
                                                                <th>Registration Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>S/No</th>
                                                                <th>Name</th>
                                                                <th>Registration Status</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>';
                                                    // output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Confirm If User Registartion Has Been Approved 
                                                        if ( $row['registration_status'] == 'Pending') {
                                                            $registrationStatusBar = 'half-done';
                                                            $registrationStatus = 'Pending';
                                                        } else {
                                                            $registrationStatusBar = 'fully-done';
                                                            $registrationStatus = 'Approved';
                                                        }
                                                        
                                                        echo '<tr>
                                                            <td><input type="checkbox" name="choseme" id="choseme' . $sn++ . '" value="' . $row['username'] . '" class="iSelected" /><label for="choseme' . $sno++ . '"></label></td>
                                                            <td>' . $row['surname'] . ' ' . $row['firstname'] . '</td>
                                                            <td>
                                                                <div class="'. $registrationStatusBar .'">' . $registrationStatus . '</div>
                                                            </td>
                                                        </tr>';
                                                    }
                                                    echo '</tbody>
                                                    </table>';
                                                    echo '<div class="row">
                                                        <div class="col s12 center" style="margin-top: 30px">
                                                            <h6 class="uppercase deepred-text">Warning: Ensure You Verify The Total Of <strong id="totalSelected"></strong> Selected User Accounts Before Proceeding</h6>
                                                        </div>
                                                    </div>';
                                                    echo '<div class="row">
                                                        <div class="col l6 m6 s12">
                                                            <div class="center" style="margin-top: 30px">
                                                                <button class="btn primary-btn waves-effect waves-light white-text suspendUsers">
                                                                    <i class="material-icons left">cancel</i> 
                                                                    Suspend Selected Users 
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col l6 m6 s12">
                                                            <div class="center" style="margin-top: 30px">
                                                                <button class="btn teal waves-effect waves-light white-text approveUsers">
                                                                    <i class="material-icons left">done_all</i> 
                                                                    Approve Selected Users 
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                } else {
                                                    echo 'No record found';
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

        <!-- Add Modal -->
        <div id="changeAccessLevel" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Update User Account Level</h4>
                    <p class="subtitle">Ensure you have the right permission before proceeding</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col s12">
                            <h5 class="uppercase">You Are About Changing <strong class="black-text" id="ufname"></strong> Access Level</h5>
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <select id="userlevel" class="searchableSelect">>
                                <option value="">Select User New Access Level</option>
                                <?php getUserAccssLevelAll(); ?>
                            </select>
                        </div>
                        <input type="hidden" name="uusername" id="uusername">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Close</a>
                <button class="btn waves-effect waves-light teal white-text updateUserAccessLevel mr-3">
                    <i class="material-icons left">save</i>
                    Save Changes
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

        <script type="text/javascript" src="assets/js/pages/user-management.js"></script>

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