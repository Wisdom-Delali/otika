<?php include "../includes/header.php";
$order_q=mysqli_query($conn, "SELECT * FROM cart LEFT JOIN commodity ON cart.commodityID=commodity.commodityID WHERE cart.clientID='$client_id'");

function generateRandomString($length = 25) {
    $characters = '0-!$123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
};
//usage 
$myRandomString = generateRandomString(200);
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
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
                      <h2>Checkout
                      </h2>
                      <div class="invoice-number">Order <?php echo mb_strimwidth($myRandomString, 0, 10, '...') ; ?></div>
                    </div>
                    <hr>
                    

                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Order Summary</div>
                    <p class="section-lead">All items here cannot be deleted.</p>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Item</th>
                          <th class="text-center">Price</th>
                          <th class="text-center">Quantity</th>
                          <th class="text-right">Totals</th>
                        </tr>
                        <?php
                        $li =1;
                        $subtotal=0;
                        while($order_row=mysqli_fetch_array($order_q)){
                            $total = $order_row['price']*$order_row['qty'];
                            ?>
                                <tr>
                                    <td><?php echo $li++; ?></td>
                                    <td><?php echo $order_row['commodityName']; ?></td>
                                    <td class="text-center"><?php echo number_format($order_row['price'],2); ?></td>
                                    <td class="text-center"><?php echo $order_row['qty']; ?></td>
                                    <td class="text-right"><?php echo $total; ?></td>
                                </tr>
                            <?php
                             $subtotal +=$total;
                        }
                       
                        ?>
                        
                    
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Payment Method</div>
                        <p class="section-lead">The payment method that we provide is to make it easier for you to pay
                          invoices.</p>
                        <div class="images">
                          <img src="../assets/img/cards/visa.png" alt="visa">
                        </div>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal</div>
                          <div class="invoice-detail-value"><?php echo number_format($subtotal,2) ?></div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Shipping</div>
                          <div class="invoice-detail-value">$0.00</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg"><?php echo number_format($subtotal,2) ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                    <form id="checkout_form">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>"> 
                    <input type="hidden" name="order" value="<?php echo $myRandomString ?>"> 
                    <input type="hidden" name="checkout" value="<?php echo $_SESSION['token'] ?? '' ?>"> 
                    <input type="hidden" name="total" value="<?php echo $subtotal ?>"> 
                    <button type="submit" id="button" class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process
                    Payment</button>
                    <a href="dashboard" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</a>
                  </form>
                  
                  
                </div>
                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </section>

      

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php";
if(mysqli_num_rows($order_q)<1){
  ?>
    <script>
      swal('Sorry!', 'No products in cart', 'error');
   
  
            setTimeout(function(){
              window.location.replace("transactions");
            }, 3000);
      </script>
  <?php
}
?>

</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>