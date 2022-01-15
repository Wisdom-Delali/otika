<?php include "../includes/header.php";
$_SESSION['token'] = md5(uniqid(mt_rand(), true)); 
function generateRandomString($length = 25) {
  $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
  $myRandomString = generateRandomString(50);
?>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include "../includes/navbar.php" ?>
      <!-- Main Content -->
      <div class="main-content">
      <section class="section">
          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>Invoice</h2>
                      <div class="invoice-number">Order <?php echo mb_strimwidth($myRandomString, 0, 10, '...') ; ?></div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Billed To:</strong><br>
                          <?php echo $profile_row['first_name']; ?> <?php echo $profile_row['last_name']; ?><br>
                          <?php echo $profile_row['address']; ?>,<br>
                          <?php echo $profile_row['state']; ?>,<br>
                          <?php echo $profile_row['country']; ?>
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Shipped To:</strong><br>
                          <?php echo $profile_row['first_name']; ?> <?php echo $profile_row['last_name']; ?><br>
                          <?php echo $profile_row['address']; ?>,<br>
                          <?php echo $profile_row['state']; ?>,<br>
                          <?php echo $profile_row['country']; ?>
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">

                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Order Date:</strong><br>
                          <?php echo date('D/M/Y'); ?><br><br>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Order Summary</div>
                    <p class="section-lead">All items here cannot be deleted.</p>
                    <div class="table-responsive">
                      <form method="POST" id="depositform" action="coinpayment" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=600,height=800');">
                        <input type="hidden" name="depositC" value="<?php echo $_SESSION['token'] ?? '' ?>" required> 
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>" required> 
                            <label>Amount in USD</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    $
                                  </div>
                                </div>
                                <input type="number" id="amount" name="amount" required class="form-control currency">
                                <input type="hidden" name="orderID" value="<?php echo $myRandomString; ?>" required>
                                <input type="hidden" name="clientID" value="<?php echo $client_id; ?>" required>
                                <input type="hidden" name="email" value="<?php echo $profile_row['email']; ?>" required>
                              </div>
                      
                    </div>
                    <div class="form-group">
                      <label class="form-label">Payment method</label>
                      <div class="row gutters-sm">
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="radio" value="BTC" class="imagecheck-input" required checked/>
                            <span class="imagecheck-figure">
                              <img src="../assets/img/cards/bitcoin.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="radio" value="ETH" class="imagecheck-input" required />
                            <span class="imagecheck-figure">
                              <img src="../assets/img/cards/ethereum.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="radio" value="DOGE" class="imagecheck-input" required />
                            <span class="imagecheck-figure">
                              <img src="../assets/img/cards/dogecoin.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="radio" value="LTCT" class="imagecheck-input" required />
                            <span class="imagecheck-figure">
                              <img src="../assets/img/cards/visa.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Payment Method</div>
                        <p class="section-lead">The payment method that we provide is to make it easier for you to deposit.</p>
                        
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <button class="btn btn-primary btn-icon icon-left" type="submit"><i class="fas fa-credit-card"></i> Process
                    Payment</button>
                  <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </section>        

      

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php" ?>
<script src="../assets/bundles/cleave-js/dist/cleave.min.js"></script>
  <script src="../assets/bundles/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="../assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="../assets/js/page/forms-advanced-forms.js"></script>
  <script src="../assets/bundles/select2/dist/js/select2.full.min.js"></script>

</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>