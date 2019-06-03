<?php
//Add functions file
include 'app/core/db.php';
include 'app/core/functions.php';
include 'app/pf/preannouncements.php';
include 'app/core/session.php';
$pagename = 'Cash Preparation';
//Check user loggin stats and user level
if ($session->logged_in) {
    if ($session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ) {
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
            header("Location: preannouncements");
        }
        $cid = getClientId($session->username);
        
        // Get ER Data
        $erData         = getEvacRequestById($get_id);
        $erName         = $erData['er_name'];
        $bank_id        = $erData['bank_id'];
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
                    <li><a href="preannouncements">Preannouncements</a></li>
                    <li class="active"><?php echo $pagename . ' &nbsp; ->  &nbsp; ' . $erName; ?> </li>
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
                        <a href="preannouncements" class="btns btns-delete waves-effect waves-teal" style="color: white !important">
                            <i class="material-icons left">keyboard_backspace</i> Back 
                        </a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col l8 m8 s12">

                  <div class="card">
                    <div class="card-content" style="min-height: 750px;">
                      
                        <h5 class="center blue-grey-text"><?php echo $pagename . ' <small>for</small> <strong class="black-text">' . $erName . '</strong>'; ?></h5>

                        <input type="hidden" name="evReqId" id="evReqId" value="<?php echo $get_id; ?>">
                        <input type="hidden" name="bankId" id="bankId" value="<?php echo $bank_id; ?>">
                        <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                        <span class="addPreannouncementBtn"></span>

                        <div class="row" style="margin: 30px 6px;">
                            <div class="col s12">
                                <h6 class="header">Preannouncement &amp; Sealing</h6>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="col l5 m5 s12">
                                <div class="input-field col s12">
                                    <select id="containerType">
                                        <?php getContainerTypeList(); ?>
                                    </select>
                                    <label>Container Type</label>
                                </div>
                            </div>
                            <div class="col l7 m7 s12">
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <select id="categoryType" required>
                                        <?php getCategoryTypeList(); ?>
                                        </select>
                                        <label>Cash Category</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin">
                            <div class="col l5 m5 s12">
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <select id="depositType" required>
                                        <?php getDepositTypeList(); ?>
                                        </select>
                                        <label>Deposit Type</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col l7 m7 s12">
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="sealNumber" name="sealNumber" type="text" class="validate sealNumber" required autocomplete="off" onkeypress="return AvoidSpace(event)" maxlength="6">
                                        <label for="sealNumber">Seal Number <small id="sealFb" class="helper-text red-text"></small></label>
                                        <small>System Generated Seal Number: <strong  class="black-text"><span id="newSealNumber"></span></strong></small>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <input type="hidden" id="genSealNumber">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="margin: 30px 6px;"></div>

                        <div id="iCBN">
                            <div class="row margin">
                                <div class="col l5 m5 s12">
                                    <div class="input-field col s12">
                                        <select id="denomination" class="cbnCash" required>
                                            <option value="">Select Cash Denomination</option>
                                            <?php getDen(); ?>
                                        </select>
                                        <label>Cash Denomination</label>
                                    </div>
                                </div>
                                <div class="col l7 m7 s12">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <select id="pieces" class="cbnCash" required>
                                                <option value="">Select Number Of Pieces</option>
                                                <?php getPieces(); ?>
                                            </select>
                                            <label>How Many Notes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="blue-grey-text">Total Amount: <strong class="black-text totalAmountC"></strong></h5>
                                    <input type="hidden" id="totalAmountC">
                                </div>
                            </div>
                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationCbn">
                                        <i class="material-icons right">save</i>
                                        Save CBN Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="nCBN">
                            <div class="row" style="margin: 30px 6px;">
                                <div class="col s12">
                                    <h6 class="header">Select Currencies</h6>
                                </div>
                                <?php getCurrencyList(); ?>
                            </div>
                        </div>
                        <div id="isNaira" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">Naira Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash1000" name="ncash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash1000Amount" name="ncash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash1000Amount naira" required autocomplete="off">
                                            <label for="ncash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash500" name="ncash500" type="text" class="validate ncash500" required autocomplete="off" readonly value="500">
                                            <label for="ncash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash500Amount" name="ncash500Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash500Amount naira" required autocomplete="off">
                                            <label for="ncash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash200" name="ncash200" type="text" class="validate ncash200" required autocomplete="off" readonly value="200">
                                            <label for="ncash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash200Amount" name="ncash200Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash200Amount naira" required autocomplete="off">
                                            <label for="ncash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash100" name="ncash100" type="text" class="validate ncash100" required autocomplete="off" readonly value="100">
                                            <label for="ncash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash100Amount" name="ncash100Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash100Amount naira" required autocomplete="off">
                                            <label for="ncash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash50" name="ncash50" type="text" class="validate ncash50" required autocomplete="off" readonly value="50">
                                            <label for="ncash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash50Amount" name="ncash50Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash50Amount naira" required autocomplete="off">
                                            <label for="ncash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash20" name="ncash20" type="text" class="validate ncash20" required autocomplete="off" readonly value="20">
                                            <label for="ncash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="ncash20Amount" name="ncash20Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash20Amount naira" required autocomplete="off">
                                        <label for="ncash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash10" name="ncash10" type="text" class="validate ncash10" required autocomplete="off" readonly value="10">
                                            <label for="ncash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash10Amount" name="ncash10Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash10Amount naira" required autocomplete="off">
                                            <label for="ncash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash5" name="ncash5" type="text" class="validate ncash5" required autocomplete="off" readonly value="5">
                                            <label for="ncash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash5Amount" name="ncash5Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash5Amount naira" required autocomplete="off">
                                            <label for="ncash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash1" name="ncash1" type="text" class="validate ncash1" required autocomplete="off" readonly value="1">
                                            <label for="ncash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ncash1Amount" name="ncash1Amount" type="text" onkeypress="return isNumber(event)" class="validate ncash1Amount naira" required autocomplete="off">
                                            <label for="ncash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount For Naira: <strong class="black-text nTotalAmount"></strong></h5>
                                    <input type="hidden" id="nTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationNaira">
                                        <i class="material-icons right">save</i>
                                        Save Naira Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="isUsd" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">US Dollar Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash1000" name="ucash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash1000Amount" name="ucash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash1000Amount usd" required autocomplete="off">
                                            <label for="ucash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash500" name="ucash500" type="text" class="validate ucash500" required autocomplete="off" readonly value="500">
                                            <label for="ucash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash500Amount" name="ucash500Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash500Amount usd" required autocomplete="off">
                                            <label for="ucash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash200" name="ucash200" type="text" class="validate ucash200" required autocomplete="off" readonly value="200">
                                            <label for="ucash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash200Amount" name="ucash200Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash200Amount usd" required autocomplete="off">
                                            <label for="ucash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash100" name="ucash100" type="text" class="validate ucash100" required autocomplete="off" readonly value="100">
                                            <label for="ucash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash100Amount" name="ucash100Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash100Amount usd" required autocomplete="off">
                                            <label for="ucash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash50" name="ucash50" type="text" class="validate ucash50" required autocomplete="off" readonly value="50">
                                            <label for="ucash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash50Amount" name="ucash50Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash50Amount usd" required autocomplete="off">
                                            <label for="ucash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash20" name="ucash20" type="text" class="validate ucash20" required autocomplete="off" readonly value="20">
                                            <label for="ucash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="ucash20Amount" name="ucash20Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash20Amount usd" required autocomplete="off">
                                        <label for="ucash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash10" name="ucash10" type="text" class="validate ucash10" required autocomplete="off" readonly value="10">
                                            <label for="ucash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash10Amount" name="ucash10Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash10Amount usd" required autocomplete="off">
                                            <label for="ucash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash5" name="ucash5" type="text" class="validate ucash5" required autocomplete="off" readonly value="5">
                                            <label for="ucash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash5Amount" name="ucash5Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash5Amount usd" required autocomplete="off">
                                            <label for="ucash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash1" name="ucash1" type="text" class="validate ucash1" required autocomplete="off" readonly value="1">
                                            <label for="ucash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ucash1Amount" name="ucash1Amount" type="text" onkeypress="return isNumber(event)" class="validate ucash1Amount usd" required autocomplete="off">
                                            <label for="ucash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount for US Dollar: <strong class="black-text uTotalAmount"></strong></h5>
                                    <input type="hidden" id="uTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationDollar">
                                        <i class="material-icons right">save</i>
                                        Save US Dollar Cash Preparation
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="isEuro" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">Euro Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash1000" name="ecash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash1000Amount" name="ecash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash1000Amount euro" required autocomplete="off">
                                            <label for="ecash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash500" name="ecash500" type="text" class="validate ecash500" required autocomplete="off" readonly value="500">
                                            <label for="ecash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash500Amount" name="ecash500Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash500Amount euro" required autocomplete="off">
                                            <label for="ecash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash200" name="ecash200" type="text" class="validate ecash200" required autocomplete="off" readonly value="200">
                                            <label for="ecash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash200Amount" name="ecash200Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash200Amount euro" required autocomplete="off">
                                            <label for="ecash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash100" name="ecash100" type="text" class="validate ecash100" required autocomplete="off" readonly value="100">
                                            <label for="ecash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash100Amount" name="ecash100Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash100Amount euro" required autocomplete="off">
                                            <label for="ecash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash50" name="ecash50" type="text" class="validate ecash50" required autocomplete="off" readonly value="50">
                                            <label for="ecash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash50Amount" name="ecash50Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash50Amount euro" required autocomplete="off">
                                            <label for="ecash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash20" name="ecash20" type="text" class="validate ecash20" required autocomplete="off" readonly value="20">
                                            <label for="ecash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="ecash20Amount" name="ecash20Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash20Amount euro" required autocomplete="off">
                                        <label for="ecash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash10" name="ecash10" type="text" class="validate ecash10" required autocomplete="off" readonly value="10">
                                            <label for="ecash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash10Amount" name="ecash10Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash10Amount euro" required autocomplete="off">
                                            <label for="ecash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash5" name="ecash5" type="text" class="validate ecash5" required autocomplete="off" readonly value="5">
                                            <label for="ecash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash5Amount" name="ecash5Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash5Amount euro" required autocomplete="off">
                                            <label for="ecash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash1" name="ecash1" type="text" class="validate ecash1" required autocomplete="off" readonly value="1">
                                            <label for="ecash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ecash1Amount" name="ecash1Amount" type="text" onkeypress="return isNumber(event)" class="validate ecash1Amount euro" required autocomplete="off">
                                            <label for="ecash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount for Euro: <strong class="black-text eTotalAmount"></strong></h5>
                                    <input type="hidden" id="eTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationEuro">
                                        <i class="material-icons right">save</i>
                                        Save Euro Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="isGbp" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">Great British Pounds Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash1000" name="gcash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash1000Amount" name="gcash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash1000Amount gbp" required autocomplete="off">
                                            <label for="gcash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash500" name="gcash500" type="text" class="validate gcash500" required autocomplete="off" readonly value="500">
                                            <label for="gcash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash500Amount" name="gcash500Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash500Amount gbp" required autocomplete="off">
                                            <label for="gcash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash200" name="gcash200" type="text" class="validate gcash200" required autocomplete="off" readonly value="200">
                                            <label for="gcash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash200Amount" name="gcash200Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash200Amount gbp" required autocomplete="off">
                                            <label for="gcash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash100" name="gcash100" type="text" class="validate gcash100" required autocomplete="off" readonly value="100">
                                            <label for="gcash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash100Amount" name="gcash100Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash100Amount gbp" required autocomplete="off">
                                            <label for="gcash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash50" name="gcash50" type="text" class="validate gcash50" required autocomplete="off" readonly value="50">
                                            <label for="gcash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash50Amount" name="gcash50Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash50Amount gbp" required autocomplete="off">
                                            <label for="gcash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash20" name="gcash20" type="text" class="validate gcash20" required autocomplete="off" readonly value="20">
                                            <label for="gcash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="gcash20Amount" name="gcash20Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash20Amount gbp" required autocomplete="off">
                                        <label for="gcash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash10" name="gcash10" type="text" class="validate gcash10" required autocomplete="off" readonly value="10">
                                            <label for="gcash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash10Amount" name="gcash10Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash10Amount gbp" required autocomplete="off">
                                            <label for="gcash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash5" name="gcash5" type="text" class="validate gcash5" required autocomplete="off" readonly value="5">
                                            <label for="gcash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash5Amount" name="gcash5Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash5Amount gbp" required autocomplete="off">
                                            <label for="gcash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash1" name="gcash1" type="text" class="validate gcash1" required autocomplete="off" readonly value="1">
                                            <label for="gcash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="gcash1Amount" name="gcash1Amount" type="text" onkeypress="return isNumber(event)" class="validate gcash1Amount gbp" required autocomplete="off">
                                            <label for="gcash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount for Pounds: <strong class="black-text gTotalAmount"></strong></h5>
                                    <input type="hidden" id="gTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationPounds">
                                        <i class="material-icons right">save</i>
                                        Save Pounds Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="isZar" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">South African Rand Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash1000" name="zcash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash1000Amount" name="zcash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash1000Amount zar" required autocomplete="off">
                                            <label for="zcash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash500" name="zcash500" type="text" class="validate zcash500" required autocomplete="off" readonly value="500">
                                            <label for="zcash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash500Amount" name="zcash500Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash500Amount zar" required autocomplete="off">
                                            <label for="zcash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash200" name="zcash200" type="text" class="validate zcash200" required autocomplete="off" readonly value="200">
                                            <label for="zcash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash200Amount" name="zcash200Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash200Amount zar" required autocomplete="off">
                                            <label for="zcash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash100" name="zcash100" type="text" class="validate zcash100" required autocomplete="off" readonly value="100">
                                            <label for="zcash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash100Amount" name="zcash100Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash100Amount zar" required autocomplete="off">
                                            <label for="zcash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash50" name="zcash50" type="text" class="validate zcash50" required autocomplete="off" readonly value="50">
                                            <label for="zcash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash50Amount" name="zcash50Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash50Amount zar" required autocomplete="off">
                                            <label for="zcash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash20" name="zcash20" type="text" class="validate zcash20" required autocomplete="off" readonly value="20">
                                            <label for="zcash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="zcash20Amount" name="zcash20Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash20Amount zar" required autocomplete="off">
                                        <label for="zcash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash10" name="zcash10" type="text" class="validate zcash10" required autocomplete="off" readonly value="10">
                                            <label for="zcash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash10Amount" name="zcash10Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash10Amount zar" required autocomplete="off">
                                            <label for="zcash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash5" name="zcash5" type="text" class="validate zcash5" required autocomplete="off" readonly value="5">
                                            <label for="zcash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash5Amount" name="zcash5Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash5Amount zar" required autocomplete="off">
                                            <label for="zcash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash1" name="zcash1" type="text" class="validate zcash1" required autocomplete="off" readonly value="1">
                                            <label for="zcash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="zcash1Amount" name="zcash1Amount" type="text" onkeypress="return isNumber(event)" class="validate zcash1Amount zar" required autocomplete="off">
                                            <label for="zcash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount for South African Rand: <strong class="black-text zTotalAmount"></strong></h5>
                                    <input type="hidden" id="zTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationZar">
                                        <i class="material-icons right">save</i>
                                        Save Zar Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="isCfa" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">West African CFA Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash1000" name="ccash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash1000Amount" name="ccash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash1000Amount cfa" required autocomplete="off">
                                            <label for="ccash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash500" name="ccash500" type="text" class="validate ccash500" required autocomplete="off" readonly value="500">
                                            <label for="ccash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash500Amount" name="ccash500Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash500Amount cfa" required autocomplete="off">
                                            <label for="ccash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash200" name="ccash200" type="text" class="validate ccash200" required autocomplete="off" readonly value="200">
                                            <label for="ccash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash200Amount" name="ccash200Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash200Amount cfa" required autocomplete="off">
                                            <label for="ccash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash100" name="ccash100" type="text" class="validate ccash100" required autocomplete="off" readonly value="100">
                                            <label for="ccash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash100Amount" name="ccash100Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash100Amount cfa" required autocomplete="off">
                                            <label for="ccash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash50" name="ccash50" type="text" class="validate ccash50" required autocomplete="off" readonly value="50">
                                            <label for="ccash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash50Amount" name="ccash50Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash50Amount cfa" required autocomplete="off">
                                            <label for="ccash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash20" name="ccash20" type="text" class="validate ccash20" required autocomplete="off" readonly value="20">
                                            <label for="ccash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="ccash20Amount" name="ccash20Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash20Amount cfa" required autocomplete="off">
                                        <label for="ccash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash10" name="ccash10" type="text" class="validate ccash10" required autocomplete="off" readonly value="10">
                                            <label for="ccash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash10Amount" name="ccash10Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash10Amount cfa" required autocomplete="off">
                                            <label for="ccash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash5" name="ccash5" type="text" class="validate ccash5" required autocomplete="off" readonly value="5">
                                            <label for="ccash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash5Amount" name="ccash5Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash5Amount cfa" required autocomplete="off">
                                            <label for="ccash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash1" name="ccash1" type="text" class="validate ccash1" required autocomplete="off" readonly value="1">
                                            <label for="ccash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ccash1Amount" name="ccash1Amount" type="text" onkeypress="return isNumber(event)" class="validate ccash1Amount cfa" required autocomplete="off">
                                            <label for="ccash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount for West African CFA <strong class="black-text cTotalAmount"></strong></h5>
                                    <input type="hidden" id="cTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationCfa">
                                        <i class="material-icons right">save</i>
                                        Save CFA Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="isCny" style="border-botttom: 1px solid #efefef;  margin: 10px 0;">
                            <div class="row">
                                <div class="col s12">
                                    <h6 class="header blue-grey-text">Chinese Yuan Cash Allocation</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash1000" name="ycash1000" type="text" class="validate cash1000" required autocomplete="off" readonly value="1000">
                                            <label for="cash1000">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash1000Amount" name="ycash1000Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash1000Amount cny" required autocomplete="off">
                                            <label for="ycash1000Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash500" name="ycash500" type="text" class="validate ycash500" required autocomplete="off" readonly value="500">
                                            <label for="ycash500">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash500Amount" name="ycash500Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash500Amount cny" required autocomplete="off">
                                            <label for="ycash500Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash200" name="ycash200" type="text" class="validate ycash200" required autocomplete="off" readonly value="200">
                                            <label for="ycash200">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash200Amount" name="ycash200Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash200Amount cny" required autocomplete="off">
                                            <label for="ycash200Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash100" name="ycash100" type="text" class="validate ycash100" required autocomplete="off" readonly value="100">
                                            <label for="ycash100">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash100Amount" name="ycash100Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash100Amount cny" required autocomplete="off">
                                            <label for="ycash100Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash50" name="ycash50" type="text" class="validate ycash50" required autocomplete="off" readonly value="50">
                                            <label for="ycash50">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash50Amount" name="ycash50Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash50Amount cny" required autocomplete="off">
                                            <label for="ycash50Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash20" name="ycash20" type="text" class="validate ycash20" required autocomplete="off" readonly value="20">
                                            <label for="ycash20">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s6">
                                    <div class="row margin">
                                    <div class="input-field col s12">
                                        <input id="ycash20Amount" name="ycash20Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash20Amount cny" required autocomplete="off">
                                        <label for="ycash20Amount">Amount</label>
                                        <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash10" name="ycash10" type="text" class="validate ycash10" required autocomplete="off" readonly value="10">
                                            <label for="ycash10">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash10Amount" name="ycash10Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash10Amount cny" required autocomplete="off">
                                            <label for="ycash10Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash5" name="ycash5" type="text" class="validate ycash5" required autocomplete="off" readonly value="5">
                                            <label for="ycash5">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash5Amount" name="ycash5Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash5Amount cny" required autocomplete="off">
                                            <label for="ycash5Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash1" name="ycash1" type="text" class="validate ycash1" required autocomplete="off" readonly value="1">
                                            <label for="ycash1">Denomination </label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l2 m2 s6">
                                    <div class="row margin">
                                        <div class="input-field col s12">
                                            <input id="ycash1Amount" name="ycash1Amount" type="text" onkeypress="return isNumber(event)" class="validate ycash1Amount cny" required autocomplete="off">
                                            <label for="ycash1Amount">Amount</label>
                                            <span class="helper-text"  data-error="This Field Is Required" data-success=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <h5 class="header blue-grey-text">Total Amount for Chinese Yuan:  <strong class="black-text yTotalAmount"></strong></h5>
                                    <input type="hidden" id="yTotalAmount">
                                </div>
                            </div>

                            <div class="row">
                                <div class="s12 right">
                                    <button class="btn waves-effect waves-light teal white-text cashAllocationCny">
                                        <i class="material-icons right">save</i>
                                        Save CNY Cash Allocation 
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                  </div>

                    <div class="row mt-3">
                        <div class="col l8 m8 s7">
                            <button class="btn waves-effect waves-light white teal-text donePreparingCash">
                                <i class="material-icons left">done_all</i>
                                Done, Close Cash Preparation
                            </button>
                        </div>
                        <div class="col l4 m4 s5">
                            <div class="right">
                                <button class="btn waves-effect waves-cyan cyan white-text savePreannouncement">
                                    <i class="material-icons left">add</i>
                                    Add Another Bag 
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col l4 m4 s12">
                    <div class="card">
                        <div class="card-content">
                            <h6 class="header uppercase blue-grey-text center">Useful Tips</h6>
                            
                      
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

    <script type="text/javascript" src="assets/js/pages/preannouncements.js"></script>

    <script>
      $("#isNaira").hide()
      $("#isUsd").hide()
      $("#isEuro").hide()
      $("#isGbp").hide()
      $("#isZar").hide()
      $("#isCfa").hide()
      $("#isCny").hide()
      $('.savePreannouncement').hide()
      $("#iCBN").hide()
      $("#nCBN").hide()
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