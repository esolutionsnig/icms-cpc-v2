<aside id="left-sidebar-nav">
          <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="user-details cyan darken-2">
              <div class="row">
                <div class="col col s4 m4 l4 userdpsn">
                  <img src="assets/images/avatar/<?php echo $dp; ?>" alt="avatar" class="circle responsive-img valign profile-image red darken-4 b2">
                </div>
                <div class="col col s8 m8 l8">
                  <ul id="profile-dropdown-nav" class="dropdown-content">
                    <li>
                      <a href="profile" class="grey-text text-darken-1">
                        <i class="material-icons">face</i> Profile</a>
                    </li>
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">live_help</i> Help</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="process" class="grey-text text-darken-1">
                        <i class="material-icons">keyboard_tab</i> Logout</a>
                    </li>
                  </ul>
                  <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown-nav"><?php echo $shortname; ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                  <p class="user-roal">Current Shift: <?php echo $yourCurrentShift; ?></p>
                </div>
              </div>
            </li>

            <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isExecutive() || $session->isManager() ) { ?>
              <li class="no-padding <?php if ($pagename == 'Overview Of Activities') { echo 'active1'; } ?> ">
                <ul class="collapsible" data-collapsible="accordion">
                  <li class="bold">
                    <a href="executive-dashboard" class="waves-effect waves-red">
                        <i class="material-icons">assignment</i>
                        <span class="nav-text">Overview Of Activities</span>
                      </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

              <li class="no-padding <?php if ($pagename == 'Dashboard') { echo 'active1'; } ?> ">
                <ul class="collapsible" data-collapsible="accordion">
                  <li class="bold">
                    <a href="./" class="waves-effect waves-red">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">Dashboard</span>
                      </a>
                  </li>
                </ul>
              </li>

            <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isAccount()) { ?>
              <li class="no-padding <?php if ($pagename == 'Financial Control') { echo 'active1'; } ?> ">
                <ul class="collapsible" data-collapsible="accordion">
                  <li class="bold">
                    <a href="financial-control" class="waves-effect waves-red">
                        <i class="material-icons">account_balance_wallet</i>
                        <span class="nav-text">Financial Control</span>
                      </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

              <li class="navigation-header" style="border-bottom: 1px solid #fbe7e7">
                <a class="navigation-header-text deepred-text">
                  <i class="material-icons left deepred-text">linear_scale</i> 
                  INFLOWS 
                  <i class="material-icons right deepred-text">linear_scale</i>
                </a>
              </li>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isBanker() || $session->isBankerCmu() ) { ?>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion">
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Evacuation Requests' || $pagename == 'Evacuation Request' || $pagename == 'New Evacuation Request' || $pagename == 'Update Evacuation Request' || $pagename == 'Cash Preparation ' || $pagename == 'Prepared Bags' || $pagename == 'Update Evacuation Request') {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">local_shipping</i>
                        <span class="nav-text">Evacuation Requests</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <li <?php if ($pagename == 'New Evacuation Request') { echo 'class="active"'; } ?> >
                            <a href="evacuation-request-c">
                              <i class="material-icons">link</i>
                              <span> New Evacuation Request </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Update Evacuation Request' || $pagename == 'Cash Preparation ') { echo 'class="active"'; } ?> >
                            <a href="#">
                              <i class="material-icons">link</i>
                              <span> Update Evacuation Request </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Evacuation Requests' || $pagename == 'Prepared Bags') { echo 'class="active"'; } ?> >
                            <a href="evacuation-requests">
                              <i class="material-icons">link</i>
                              <span> View All Request </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive() || $session->isCPO() ) { ?>
                <li class="no-padding <?php if ($pagename == 'Evacuation Schedule') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="evacuation-schedule" class="waves-effect waves-red">
                        <i class="material-icons">assignment</i>
                        <span class="nav-text">Evacuation Schedule</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion">
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Preannouncements' || $pagename == 'Preannouncement' || $pagename == 'New Preannouncement' || $pagename == 'Update Preannouncement' || $pagename == 'Cash Preparation' || $pagename == 'Prepared Bags ' ) {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">account_balance_wallet</i>
                        <span class="nav-text">Preannouncements</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <li <?php if ($pagename == 'New Preannouncement') { echo 'class="active"'; } ?> >
                            <a href="preannouncement-c">
                              <i class="material-icons">link</i>
                              <span> New Preannouncement </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Update Preannouncement' || $pagename == 'Cash Preparation') { echo 'class="active"'; } ?> >
                            <a href="#">
                              <i class="material-icons">link</i>
                              <span> Update Preannouncement </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Preannouncements' || $pagename == 'Prepared Bags ') { echo 'class="active"'; } ?> >
                            <a href="preannouncements">
                              <i class="material-icons">link</i>
                              <span> View All Preannouncements </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>


              <li class="navigation-header" style="border-bottom: 1px solid #fbe7e7">
                <a class="navigation-header-text deepred-text">
                  <i class="material-icons left deepred-text">linear_scale</i> 
                  INTERNAL 
                  <i class="material-icons right deepred-text">linear_scale</i>
                </a>
              </li>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isCPA() ||  $session->isCPS() || $session->isTreasuryOfficer() || $session->isTreasurySup() ) { ?>
                <li class="no-padding <?php if ($pagename == 'Bundle Confirmation' || $pagename == 'Bags') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="bundle-confirmation" class="waves-effect waves-red">
                        <i class="material-icons">done_all</i>
                        <span class="nav-text">Bundle Confirmation</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion"> 
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Cash Allocations And Processing' || $pagename == 'Cash Allocation And Processing' || $pagename == 'New Cash Allocation' || $pagename == 'Update Cash Allocation' || $pagename == 'Viewing Cash Allocations & Processing' ) {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">monetization_on</i>
                        <span class="nav-text">Cash Allocation</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <li <?php if ($pagename == 'New Cash Allocation') { echo 'class="active"'; } ?> >
                            <a href="cash-allocation-c">
                              <i class="material-icons">link</i>
                              <span> New Cash Allocation </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Update Cash Allocation' || $pagename == 'Cash Preparation') { echo 'class="active"'; } ?> >
                            <a href="#">
                              <i class="material-icons">link</i>
                              <span> Update Cash Allocation </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Cash Allocations And Processing' || $pagename == 'Viewing Cash Allocation') { echo 'class="active"'; } ?> >
                            <a href="cash-allocation">
                              <i class="material-icons">link</i>
                              <span> View All Cash Allocation </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive() || $session->isCPO() ) { ?>
                <li class="no-padding <?php if ($pagename == 'Internal Movement') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="internal-movement" class="waves-effect waves-red">
                        <i class="material-icons">swap_horiz</i>
                        <span class="nav-text">Internal Movement</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="no-padding <?php if ($pagename == 'Actual Stock Position') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="actual-stock-position" class="waves-effect waves-red">
                        <i class="material-icons">location_on</i>
                        <span class="nav-text">Actual Stock Position</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="no-padding <?php if ($pagename == 'Exceptions') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="exceptions" class="waves-effect waves-red">
                        <i class="material-icons">money_off</i>
                        <span class="nav-text">Exceptions</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="no-padding <?php if ($pagename == 'Day &amp; Shift Management') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="day-shift-management" class="waves-effect waves-red">
                        <i class="material-icons">developer_board</i>
                        <span class="nav-text">Day &amp; Shift Management</span>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php } ?>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() ||  $session->isVaultOfficer() || $session->isVaultSup() ) { ?>
                <li class="no-padding <?php if ($pagename == 'Vault') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="vault" class="waves-effect waves-red">
                        <i class="material-icons">account_balance</i>
                        <span class="nav-text">Vault</span>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php } ?>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ) { ?>
                <li class="no-padding <?php if ($pagename == 'Box Room' || $pagename == 'The Manifest') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="boxroom" class="waves-effect waves-red">
                        <i class="material-icons">business_center</i>
                        <span class="nav-text">Box Room</span>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php } ?>


              <li class="navigation-header" style="border-bottom: 1px solid #fbe7e7">
                <a class="navigation-header-text deepred-text">
                  <i class="material-icons left deepred-text">linear_scale</i> 
                  OUTFLOWS 
                  <i class="material-icons right deepred-text">linear_scale</i>
                </a>
              </li>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() || $session->isBanker() || $session->isBankerCmu() ) { ?>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion">
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Supply Requests' || $pagename == 'View Supply Request' || $pagename == 'New Supply Request' || $pagename == 'Execute Supply Request' || $pagename == 'Update Supply Request') {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">local_shipping</i>
                        <span class="nav-text">Supply Requests</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <?php if ( $session->isBanker() || $session->isBankerCmu() ) { ?>
                            <li <?php if ($pagename == 'New Supply Request') { echo 'class="active"'; } ?> >
                              <a href="supply-request-c">
                                <i class="material-icons">link</i>
                                <span> New Supply Request </span>
                              </a>
                            </li>
                            <li <?php if ($pagename == 'Update Supply Request' || $pagename == 'Cash Preparation ') { echo 'class="active"'; } ?> >
                              <a href="#">
                                <i class="material-icons">link</i>
                                <span> Update Supply Request </span>
                              </a>
                            </li>
                          <?php } ?>
                          <li <?php if ($pagename == 'Supply Requests' || $pagename == 'View Supply Request' || $pagename == 'Execute Supply Request') { echo 'class="active"'; } ?> >
                            <a href="supply-requests">
                              <i class="material-icons">link</i>
                              <span> View All Request </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>
              <?php if ( $session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive() || $session->isCPO() ) { ?>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion">
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Cash Requests' || $pagename == 'Cash Request' || $pagename == 'New Cash Request' || $pagename == 'Update Cash Request' || $pagename == 'Cash Preparation ' || $pagename == 'Prepared Bags' || $pagename == 'Update Cash Request') {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">account_balance</i>
                        <span class="nav-text">Cash Requests</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <li <?php if ($pagename == 'New Cash Request') { echo 'class="active"'; } ?> >
                            <a href="cash-request-c">
                              <i class="material-icons">link</i>
                              <span> New Cash Request </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Update Cash Request' || $pagename == 'Cash Preparation ') { echo 'class="active"'; } ?> >
                            <a href="#">
                              <i class="material-icons">link</i>
                              <span> Update Cash Request </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Cash Requests' || $pagename == 'Prepared Bags') { echo 'class="active"'; } ?> >
                            <a href="cash-requests">
                              <i class="material-icons">link</i>
                              <span> View All Cash Request </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>

              <li class="navigation-header" style="border-bottom: 1px solid #fbe7e7">
                <a class="navigation-header-text deepred-text">
                  <i class="material-icons left deepred-text">linear_scale</i> 
                  GENERAL 
                  <i class="material-icons right deepred-text">linear_scale</i>
                </a>
              </li>

              <?php if ( $session->isAdmin() || $session->isSuperAdmin() ||  $session->isHeadOfUnit() || $session->isTreasuryOfficer() || $session->isTreasurySup() || $session->isCPA() ||  $session->isCPS() || $session->isVaultOfficer() || $session->isVaultSup() || $session->isBoxRoomSupervisor() || $session->isBoxRoomOfficer() ||  $session->isManager() || $session->isExecutive() || $session->isCPO() ) { ?>              
                <li class="no-padding <?php if ($pagename == 'Search Engine') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="queries-reports-views" class="waves-effect waves-red">
                        <i class="material-icons">search</i>
                        <span class="nav-text">Search Engine</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion">
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Consignment Sealings' || $pagename == 'New Consignment Sealing') {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">lock_outline</i>
                        <span class="nav-text">Consignment Sealings</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <li <?php if ($pagename == 'New Consignment Sealing') { echo 'class="active"'; } ?> >
                            <a href="sealing-c">
                              <i class="material-icons">link</i>
                              <span> New Sealing </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Consignment Sealings') { echo 'class="active"'; } ?> >
                            <a href="sealings">
                              <i class="material-icons">link</i>
                              <span> View All Sealings </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>

              <?php if ( $session->isAdmin() || $session->isSuperAdmin() ) { ?>
                <li class="no-padding <?php if ($pagename == 'Clients' || $pagename == 'Client') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="clients" class="waves-effect waves-red">
                          <i class="material-icons">business</i>
                          <span class="nav-text">Clients Management</span>
                        </a>
                    </li>
                  </ul>
                </li>
                <li class="no-padding <?php if ($pagename == 'User Management') { echo 'active1'; } ?> ">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                      <a href="user-management" class="waves-effect waves-red">
                          <i class="material-icons">people</i>
                          <span class="nav-text">User Management</span>
                        </a>
                    </li>
                  </ul>
                </li>
                <li class="bold">
                  <ul class="collapsible collapsible-accordion">
                    <li>
                    <?php
                    $settingsActive  = '';
                    if ($pagename == 'Settings' || $pagename == 'Deposit Types' || $pagename == 'Deposit Categories' || $pagename == 'Vehicle Management' || $pagename == 'Consignment Locations' || $pagename == 'Container Types' || $pagename == 'Denominations' || $pagename == 'Currencies') {
                      $settingsActive = 'active';
                    }
                    ?>
                      <a class="collapsible-header waves-effect waves-red <?php echo $settingsActive; ?>">
                        <i class="material-icons">settings</i>
                        <span class="nav-text">Settings</span>
                      </a>
                      <div class="collapsible-body">
                        <ul>
                          <li <?php if ($pagename == 'Deposit Types') { echo 'class="active"'; } ?> >
                            <a href="deposit-types">
                              <i class="material-icons">link</i>
                              <span> Deposit Types </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Deposit Categories') { echo 'class="active"'; } ?> >
                            <a href="deposit-categories">
                              <i class="material-icons">link</i>
                              <span> Deposit Categories </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Vehicle Management') { echo 'class="active"'; } ?> >
                            <a href="vehicle-management">
                              <i class="material-icons">link</i>
                              <span> Vehicle Management </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Consignment Locations') { echo 'class="active"'; } ?> >
                            <a href="consignment-locations">
                              <i class="material-icons">link</i>
                              <span> Consignment Locations </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Container Types') { echo 'class="active"'; } ?> >
                            <a href="container-types">
                              <i class="material-icons">link</i>
                              <span> Container Types </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Denominations') { echo 'class="active"'; } ?> >
                            <a href="denominations">
                              <i class="material-icons">link</i>
                              <span> Denominations </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Currencies') { echo 'class="active"'; } ?> >
                            <a href="currencies">
                              <i class="material-icons">link</i>
                              <span> Currencies </span>
                            </a>
                          </li>
                          <li <?php if ($pagename == 'Settings') { echo 'class="active"'; } ?> >
                            <a href="settings">
                              <i class="material-icons">link</i>
                              <span> View All </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              <?php } ?>
            
            <h1>&nbsp;</h1>
            
          </ul>
          <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only">
            <i class="material-icons">menu</i>
          </a>
        </aside>