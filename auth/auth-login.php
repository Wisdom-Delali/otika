<?php include "../includes/header.php";
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form id="user_auth" class="needs-validation">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="auth-forgot-password" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="auth-register">Create One</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php include "../includes/footer.php" ?>

<script type="text/javascript">
$(function() {

  $('#user_auth').submit(function(e){
    e.preventDefault();
    var user_auth = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: 'auth_user.php',
      data: user_auth,
      dataType: 'json',
      success: function(response){
        if(response.error){
          swal('Error', 'Invalid personel ID or password', 'error');
        }else{
          swal('Login successful. You will be redirected shortly.', {
              buttons: false,
              timer: 3000,
            });
          window.location="../home/dashboard";

        }

      }
    });
  });

});
</script>
<!-- <script>

document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
</script> -->