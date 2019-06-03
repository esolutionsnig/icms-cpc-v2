<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/core/session.php';
$pagename = 'Dashboard';
//Check user loggin stats and user level
if($session->logged_in){
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
                    <li><a href="./"><?php echo $pagename; ?></a></li>
                    <li class="active">Overview of activities</li>
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

              <?php if ( $session->isBanker() || $session->isBankerCmu() ) { 
                // Get client ID
                $userBankId = getClientId($username);
                // Computer Book & Account Balance
                $bookBalance = $clientAccountBalance = 0;
                $bookBalance = getClientBookBalance($userBankId);
                $undeliveredSupplyRequest = getUndeliveredSupplyRequest($userBankId);
                $clientAccountBalance = $bookBalance - $undeliveredSupplyRequest;
              ?>
                <!--card stats start-->
                <div id="card-stats">
                  <div class="row mt-1">

                    <div class="col l4 m4 s12">
                      <div class="card primary-btn gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col l4 m4 s5">
                            <i class="material-icons large background-round mt-5">store</i>
                            <small>&nbsp;</small>
                          </div>
                          <div class="col l8 m8 s7 right-align">
                            <h3 class="mb-0"><?php echo number_format(getTotalClientBranches($userBankId)); ?></h3>
                            <h5 class="no-margin">Branch Locations</h5>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col l4 m4 s12">
                      <div class="card cyan darken-2 gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col l4 m4 s5">
                            <i class="material-icons large background-round mt-5">local_shipping</i>
                            <small>&nbsp;</small>
                          </div>
                          <div class="col l8 m8 s7 right-align">
                            <h3 class="mb-0"><?php echo number_format(getClientTotalPendingEvacuationRequests($userBankId)); ?></h3>
                            <h5 class="no-margin">Total Pending Evacuation Requests</h5>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col l4 m4 s12">
                      <div class="card orange darken-2 gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col l4 m4 s5">
                            <i class="material-icons large background-round mt-5">account_balance_wallet</i>
                            <small>&nbsp;</small>
                          </div>
                          <div class="col l8 m8 s7 right-align">
                            <h3 class="mb-0"><?php echo number_format(getClientTotalPendingSupplyRequests($userBankId)); ?></h3>
                            <h5 class="no-margin">Total Pending Supply Requests</h5>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="row mt-2">
                    <div class="col l6 m6 s12">
                      <div class="card teal darken-2 gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col l4 m4 s5">
                            <i class="material-icons large background-round mt-5">account_balance_wallet</i>
                            <p>&nbsp;</p>
                          </div>
                          <div class="col l8 m8 s7 right-align">
                            <h3 class="mb-0"><?php echo number_format($clientAccountBalance); ?></h3>
                            <h5 class="no-margin">Account Balance</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col l6 m6 s12">
                      <div class="card orange darken-4 gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col l4 m4 s5">
                            <i class="material-icons large background-round mt-5">account_balance_wallet</i>
                            <p>&nbsp;</p>
                          </div>
                          <div class="col l8 m8 s7 right-align">
                            <h3 class="mb-0"><?php echo number_format($bookBalance); ?></h3>
                            <h5 class="no-margin">Book Balance</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else if ( $session->isCMO() ) { ?>`
                <!-- ER -->
                <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
                        <h5 class="header blue-grey-text">
                          Evacuation Requests
                          <?php if ( isAllBagsHandedOver($username) ) { ?>
                            <div class="right">
                              <button data-target="handOverCons" class="btns btns-add waves-effect waves-teal hocons hoconx modal-trigger" data-id="<?php echo $username; ?>">
                              <i class="material-icons left">rv_hookup</i>
                                Handover Consignment 
                              </button>
                            </div>
                          <?php } ?>
                        </h5>
                        <?php getRequestsConfirmations($username); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- SR -->
                <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
                        <h5 class="header blue-grey-text">
                          Supply Requests
                          <?php if ( isAllBagsHandedOver($username) ) { ?>
                            <div class="right">
                              <button data-target="handOverCons" class="btns btns-add waves-effect waves-teal hocons hoconx modal-trigger" data-id="<?php echo $username; ?>">
                              <i class="material-icons left">rv_hookup</i>
                                Handover Consignment 
                              </button>
                            </div>
                          <?php } ?>
                        </h5>
                        <?php getRequestsConfirmationsSR($username); ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else { ?>

                <!--card stats start-->
                <div id="card-stats">
                  <div class="row mt-1">
                    <div class="col s12 m6 l3">
                      <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">business</i>
                            <p>Subscribed Clients</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumberOfBanks()); ?></h5>
                            <p class="no-margin">Total</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l3">
                      <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">store</i>
                            <p>Client Branches</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php getNumberOfBankLocations(); ?></h5>
                            <p class="no-margin">Total</p>
                            <p>From: <?php number_format(getNumberOfBanks()); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l3">
                      <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">timeline</i>
                            <p>Total Transactions</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0">0</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l3">
                      <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text">
                        <div class="padding-4">
                          <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">people</i>
                            <p>Registered Users</p>
                          </div>
                          <div class="col s5 m5 right-align">
                            <h5 class="mb-0"><?php number_format(getNumberUsers()); ?></h5>
                            <p class="no-margin">Total</p>
                            <p>Client : <?php number_format(getNumberClientReps()); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!--card widgets start-->
                <div id="card-widgets">
                  <div class="row">
                    <div class="col s12 m4 l4">
                      <div class="card" style="border-left: 6px solid #0288d1;">
                        <div class="card-content">
                          <h5 class="header uppercase">
                            Clients <br>
                            <small>Use the quick filter to search through client list</small>
                          </h5>
                          <input type="text" id="sfInput" onkeyup="sfFunction()" placeholder="Search for names..." title="Type in a name to begin search">
                          <div style="min-height:450px; height:450px; overflow-y: scroll;">
                            <?php getClientList(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m4 l4">
                      <div class="card" style="border-left: 6px solid #ff5252;">
                        <div class="card-content">
                          <h5 class="header uppercase">
                            Branches <br>
                            <small>Use the quick filter to search through branch list</small>
                          </h5>
                          <input type="text" id="bfInput" onkeyup="bfFunction()" placeholder="Search for names..." title="Type in a name to begin search">
                          <div style="min-height:450px; height:450px; overflow-y: scroll;">
                            <?php getBranchesList(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m4 l4">
                      <div class="card" style="border-left: 6px solid #43a047;">
                        <div class="card-content">
                          <h5 class="header uppercase">
                            Users <br>
                            <small>Use the quick filter to search through users list</small>
                          </h5>
                          <input type="text" id="ufInput" onkeyup="ufFunction()" placeholder="Search for names..." title="Type in a name to begin search">
                          <div style="min-height:450px; height:450px; overflow-y: scroll;">
                            <?php getUserssList(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--card widgets end-->
                
              <?php } ?>

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

    <div id="recCons" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">You Are About To Receive This ( <strong id="erName"></strong> ) Consignement</h4>
        </div>
        <div class="modal-body">

          <p class="uppercase red-text">Select The Seal Numbers You Are Receiving, Ensure You Have Received This Consignments Before Proceeding</p>

          <div class="row margin" id="sealRow">
            <div class="input-field col s12">
              <small>Seal Numbers (Select preferred seal number)</small>
              <select multiple id="sealNumberx" class="searchableSelect">
              </select>
            </div>
          </div>

          <input type="hidden" name="citConfirmationToken" id="citConfirmationToken">
          <input type="hidden" name="erId" id="erId">
          <input type="hidden" name="tap" id="tap">
          <input type="hidden" name="bbCid" id="bbCid">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No I Have Not</a>
        <button class="btn waves-effect waves-light teal white-text consignmentReceived mr-3">
          <i class="material-icons left">rv_hookup</i>
          YES I HAVE 
        </button>
      </div>
    </div>

    <div id="handOverCons" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Cosignment Handover</h4>
        </div>
        <div class="modal-body">

          <p class="uppercase red-text">Select The Seal Numbers You Are Handing Over, Ensure You Have Handed This Consignments Over To The Boxroom Officer Before Proceeding</p>

          <div class="row margin" id="sealRow">
            <div class="input-field col s12">
              <small>Seal Numbers (Select preferred seal number)</small>
              <select multiple id="sealNumberxx" class="searchableSelect">
              </select>
            </div>
          </div>
          
          <input type="hidden" name="sourceLocation" id="sourceLocation" value="2">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">Cancel</a>
        <button class="btn waves-effect waves-light teal white-text moveToBoxRoom mr-3">
          <i class="material-icons right">send</i>
          Move Consignments 
        </button>
      </div>
    </div>

    <div id="delCons" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">You Are About To Deliver This Consignement</h4>
        </div>
        <div class="modal-body">

          <p class="uppercase red-text">Have you handed over this consignment to the client recieving officer?</p>

          <input type="hidden" name="citConfirmationTokenn" id="citConfirmationTokenn">
          <input type="hidden" name="srbId" id="srbId">
          <input type="hidden" name="client" id="client">
          <input type="hidden" name="tad" id="tad">
          <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat left">No I Have Not</a>
        <button class="btn waves-effect waves-light teal white-text consignmentDelivered mr-3">
          <i class="material-icons left">rv_hookup</i>
          YES I HAVE 
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

    <script type="text/javascript" src="assets/js/pages/dashboard.js"></script>

    <script>
      // Remove Consignments
      $(".moveToBoxRoom").click(function(event) {
        event.preventDefault()
        var sealNumberxx = $('#sealNumberxx').val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (sealNumberxx == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".moveToBoxRoom").html('<div class="progress"><div class="indeterminate"></div></div> Moving');
            $(".moveToBoxRoom").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/dashboard.php",
                method: "POST",
                data: { moveToBoxRoom: 1, sealNumberxx: sealNumberxx, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".moveToBoxRoom").html('<i class="material-icons right">send</i> Move Consignments ')
                    $(".moveToBoxRoom").removeAttr('disabled')
                    if (data == "Error") {
                        console.log(data)
                        Materialize.toast('Movement Failed: ' + data, 1000, 'rounded')
                    } else {
                        Materialize.toast('Movement Initiated, To be Concluded By Receiver', 1000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000)
                    }
                }
            })
        }
      })
    </script>

  </body>
</html>
<?php
} else {
  header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>