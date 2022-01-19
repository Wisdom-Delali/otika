<?php include "../includes/header.php";
$orderid=$_GET['order'];
$token = $_GET['csrf'];
    if (!$token || $token !== $_SESSION['token']) {
        header('dashboard');
        exit;
    } else {
        $order_q=mysqli_query($conn, "SELECT * FROM share_transactions_details LEFT JOIN commodity ON share_transactions_details.commodityID=commodity.commodityID WHERE share_transactions_details.clientID='$client_id' AND share_transactions_details.orderID='$orderid'");
        $sorder_q=mysqli_query($conn, "SELECT * FROM share_transactions WHERE clientID='$client_id' AND orderID='$orderid'");
        $sorder_row=mysqli_fetch_array($sorder_q);
    }
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
                      <h2>
                        <div class="btn-group mb-3" role="group" aria-label="Basic example">
                            <a href="transactions" class="btn btn-success">Back</a>
                            <button type="button" class="btn btn-<?php if($sorder_row['status']==1){echo "success";}else{echo "warning";} ?>"><?php if($sorder_row['status']==1){echo "Completed";}else{echo "In Progress";} ?></button>
                            <button type="button" class="btn <?php if($sorder_row['status']==1){echo "btn-icon btn-success";}else{echo "disabled btn-warning btn-progress";} ?>"><?php if($sorder_row['status']==1){echo "<i class='fas fa-check'></i>";}else{} ?></button>
                        </div>
                          
                      </h2>
                      <div class="invoice-number">Order <?php echo mb_strimwidth($orderid, 0, 10, '...') ; ?></div>
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
                        while($order_row=mysqli_fetch_array($order_q)){
                            $total = $order_row['tranprice']*$order_row['qty'];
                            ?>
                                <tr>
                                    <td><?php echo $li++; ?></td>
                                    <td><?php echo $order_row['commodityName']; ?></td>
                                    <td class="text-center"><?php echo number_format($order_row['tranprice'],2); ?></td>
                                    <td class="text-center"><?php echo $order_row['qty']; ?></td>
                                    <td class="text-right"><?php echo number_format($total,2) ?></td>
                                </tr>
                            <?php
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
                          <div class="invoice-detail-value"><?php echo number_format($sorder_row['amount'],2) ?></div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Shipping</div>
                          <div class="invoice-detail-value">$0.00</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg"><?php echo number_format($sorder_row['amount'],2) ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
             
            </div>
          </div>
        </section>

      

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php" ?>
</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>