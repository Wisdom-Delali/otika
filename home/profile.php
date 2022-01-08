<?php include "../includes/header.php" ?>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include "../includes/navbar.php" ?>
      <?php 
        $client_id=$_SESSION['clientID'];
        $session_id=$_SESSION['session_id'];
        $profile_q=mysqli_query($conn, "SELECT * FROM tclient WHERE clientID='$client_id' AND session_id='$session_id'");
        if(mysqli_num_rows($profile_q)!=1){
            ?>
            <script>
            window.location="../auth/logout.php";
            </script>
            <?php
        }
        $profile_row=mysqli_fetch_array($profile_q);
        ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img alt="image" src="../assets/img/users/user-1.png" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#"><?php echo $profile_row['last_name'] ?> <?php echo $profile_row['first_name'] ?></a>
                      </div>
                      <div class="author-box-job">Web Developer</div>
                    </div>
                    <div class="text-center">
                      <div class="author-box-description">
                        <p>
                        <?php echo $profile_row['bio'] ?>
                        </p>
                      </div>
                      <div class="mb-2 mt-3">
                        <div class="text-small font-weight-bold">Follow <?php echo $profile_row['first_name'] ?> On</div>
                      </div>
                      <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
                        <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-github">
                        <i class="fab fa-github"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                        <i class="fab fa-instagram"></i>
                      </a>
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Personal Details</h4>
                  </div>
                  <div class="card-body">
                    <div class="py-4">
                      <p class="clearfix">
                        <span class="float-left">
                          Birthday
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $profile_row['dob'] ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Phone
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $profile_row['phone'] ?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Mail
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $profile_row['email'] ?>
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                          aria-selected="true">About</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                          aria-selected="false">Setting</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#password-reset" role="tab"
                          aria-selected="false">Change Password</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-3 col-6 b-r">
                            <strong>Full Name</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['first_name'] ?> <?php echo $profile_row['last_name'] ?></p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Mobile</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['phone'] ?></p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Email</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['email'] ?></p>
                          </div>
                          <div class="col-md-3 col-6">
                            <strong>Address</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['address'] ?></p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 col-6 b-r">
                            <strong>Country</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['country'] ?></p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>State/City</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['state'] ?></p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Member since</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['date_joined'] ?></p>
                          </div>
                          <div class="col-md-3 col-6">
                            <strong>D.O.B</strong>
                            <br>
                            <p class="text-muted"><?php echo $profile_row['dob'] ?></p>
                          </div>
                        </div>
                    
                      </div>
                      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="post" class="needs-validation">
                          <div class="card-header">
                            <h4>Edit Profile</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>First Name</label>
                                <input type="text" class="form-control" value="<?php echo $profile_row['first_name'] ?>" required>
                                <div class="invalid-feedback">
                                  Please fill in the first name
                                </div>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $profile_row['last_name'] ?>" required>
                                <div class="invalid-feedback">
                                  Please fill in the last name
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-7 col-12">
                                <label>Email</label>
                                <input type="email" class="form-control" value="<?php echo $profile_row['last_name'] ?>" required>
                                <div class="invalid-feedback">
                                  Please fill in the email
                                </div>
                              </div>
                              <div class="form-group col-md-5 col-12">
                                <label>Phone</label>
                                <input type="tel" class="form-control" value="<?php echo $profile_row['phone'] ?>">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-12">
                                <label>Bio</label>
                                <textarea
                                  class="form-control summernote-simple"><?php echo $profile_row['bio'] ?></textarea>
                              </div>
                            </div>
                            
                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary">Save Changes</button>
                          </div>
                        </form>
                      </div>
                      <div class="tab-pane fade" id="password-reset" role="tabpanel" aria-labelledby="profile-tab3">
                      <form id="change_password">
                      <div class="form-group">
                            <label for="password">Old Password</label>
                            <input id="old-password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                            name="old-password" tabindex="2" required>
                           
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                            name="password" tabindex="2" required>
                            <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="confirm-password"
                            tabindex="2" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Reset Password
                            </button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
<?php include "../includes/footer-main.php" ?>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../assets/bundles/summernote/summernote-bs4.js"></script>
<?php include "../includes/footer.php" ?>
<script type="text/javascript">
$(function() {

  $('#change_password').submit(function(e){
    e.preventDefault();
    var change_password = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: '../scripts/auth-change-password',
      data: change_password,
      dataType: 'json',
      success: function(response){
        if(response.error){
          swal('Error', 'Invalid email or password', 'error');
        }else{
          swal('Login successful. You will be redirected shortly.', {
              buttons: false,
              timer: 3000,
            });
          window.location.replace("../home/dashboard.php");
        }

      }
    });
  });

});
</script>
</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>