<footer class="page-footer footer-bg-color">
        <div class="footer-copyright">
          <div class="container">
            <span>Copyright ©
              <script type="text/javascript">
                document.write(new Date().getFullYear());
              </script> 
            <?php echo PROJECT_COPYRIGHT; ?>
            <?php echo PROJECT_VERSION; ?>
          </div>
        </div>
    </footer>

    <!-- Start Modal -->
    <div id="selectShift" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="title">Integrated Cash Management Services Limited</h4>
        </div>
        <div class="modal-body">
          <h6>&nbsp;</h6>
          <div class="row">
            <div class="col l6 m6 s12">
              <h5>Welcome Back <span class="teal-text bold"><?php echo $fullname; ?></span></h5>
              <h6><i class="material-icons">sentiment_very_satisfied</i> We are happy you could make it to work today</h6>
              <p>Please it is mandatory that you select your shift before proceeding. So we encourage you to do that now. Thank You.</p>
              <p class="red-text uppercase">At the end of your chosen shift, endeavor to sign out. All activities on the application is closely monitored and tied to user account. Remember one can not always be too careful.</p>
            </div>
            <div class="col l6 m6 s12">
              <div class="card">
                <div class="card-content">
                  <h6 class="header blue-grey-text center uppercase">Shift &amp; Location Selector</h6>
                  <div class="row margin">
                    <div class="input-field col s12">
                      <select  id="yourShift">
                        <option value="">Choose Shift</option>
                        <option value="Morning">Morning Shift</option>
                        <option value="Afternoon">Afternoon Shift</option>
                        <option value="Evening">Evening Shift</option>
                      </select>
                    </div>
                  </div>
                  <div class="row margin">
                    <div class="input-field col s12">
                      <select  id="signInAs" class="searchableSelect">
                        <option value="">Choose Location</option>
                        <?php getConsignmentLocationsListMinusWorkStations(); ?>
                      </select>
                    </div>
                  </div>
                  <h4>&nbsp;</h4>
                  <div class="row">
                    <div class="col s12 center">
                      <input type="hidden" name="usertoken" id="usertoken" value="<?php echo $usertoken; ?>">
                      <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                      <button class="btn waves-effect waves-light teal white-text setShiftLocation mr-3">
                          <i class="material-icons right">input</i>
                          Set Shift &amp; Location 
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>