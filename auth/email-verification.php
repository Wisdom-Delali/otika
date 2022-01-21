<!DOCTYPE html>
<html lang="en">
<?php
 $email=$_GET['email'];
 $step=$_GET['step'];
 $source=$_GET['source'];
 if($email=="" || $step=="" || $source==""){
  ?>
	<script>
	window.location="../auth/auth-login.php";
	</script>
	<?php
 };
 ?>

<!-- subscribe  21 Nov 2019 04:05:02 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Canza Investment - Email Verification</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="../assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='../assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="login-brand">
              Canza Investment
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Email Verification</h4>
              </div>
              <div class="card-body">
                <form id="email_verification">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
                      <input id="email" type="email" class="form-control" name="email" readonly value="<?php echo $email; ?>">
                      <input id="step" type="hidden" class="form-control" name="step"  value="<?php echo $step; ?>">
                      <input id="source" type="hidden" class="form-control" name="source"  value="<?php echo $source; ?>">
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <button id="submitbtn" class="btn disabled btn-progress btn-lg btn-round btn-primary">
                      Subscribe
                    </button>
                    <a href="auth-login" id="submitbtn2" style="display:none;" class="btn  btn-lg btn-round btn-primary">
                      Go to login page</a>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Canza Investment 2022
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <!-- jQuery 3 -->
  <script src="../assets/bundles/sweetalert/sweetalert.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="../assets/js/page/sweetalert.js"></script>
<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Moment JS -->
<script src="../bower_components/moment/moment.js"></script>

  <!-- General JS Scripts -->
  <script src="../assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="../assets/js/vue.min.js"></script>
  <script type="text/javascript">
$(function() {
window.onload = function verify(){
    var submitbtn = document.getElementById("submitbtn");
    var submitbtn2 = document.getElementById("submitbtn2");
    $.ajax({
      type: 'POST',
      url: '../scripts/auth-verify-email',
      data: $('#email_verification').serialize(),
      dataType: 'json',
      success: function(response){
        if(response.error){
          swal('Error', 'An error occured', 'error');
          submitbtn2.style.display="none";
          submitbtn.style.display="";
        }else{
          swal('Done', 'Your email address has been verified successfully!', 'success');
          submitbtn.style.display="none";
          submitbtn2.style.display="";
        }

      }
    });
}

});
</script>

</body>


<!-- subscribe  21 Nov 2019 04:05:02 GMT -->
</html>