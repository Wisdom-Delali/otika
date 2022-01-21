<?php include "../includes/header.php";
$orderid=$_POST['loan'];
$token = $_POST['csrf'];
    if (!$token || $token !== $_SESSION['token']) {
        header('dashboard');
        exit;
    } else {
        $loandetails_q=mysqli_query($conn, "SELECT * FROM loan_details  WHERE clientID='$client_id' AND orderID='$orderid'");
        $loan_q=mysqli_query($conn, "SELECT * FROM loans WHERE clientID='$client_id' AND orderID='$orderid'");
        $loan_row=mysqli_fetch_array($loan_q);
    }
$_SESSION['paytoken'] = md5(uniqid(mt_rand(), true));
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
                            <a href="loans" class="btn btn-success">Back</a>
                            <a href="#" <?php if($loan_row['status']==1){echo 'data-toggle="modal" data-target="#payloan"';}?> class="btn btn-<?php if($loan_row['status']==2){echo "success";}elseif($loan_row['status']==1){echo "danger";}else{echo "warning";} ?>"><?php if($loan_row['status']==2){echo "Payment complete";}elseif($loan_row['status']==1){echo "Click here to Pay now";}else{echo "Pending approval";} ?></a>
                            <button type="button" class="btn <?php if($loan_row['status']==2){echo "btn-icon btn-success";}elseif($loan_row['status']==1){echo "btn-icon btn-danger";}else{echo "disabled btn-warning btn-progress";} ?>"><?php if($loan_row['status']==2){echo "<i class='fas fa-check'></i>";}elseif($loan_row['status']==1){echo "<i class='fas fa-money-check'></i>";}else{} ?></button>
                        </div>
                          
                      </h2>
                      <div class="invoice-number">Loan <?php echo mb_strimwidth($orderid, 0, 10, '...') ; ?></div>
                    </div>
                    <hr>
                    

                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Payment history</div>
                    <p class="section-lead">All items here cannot be deleted.</p>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Date</th>
                          <th class="text-center">Amount paid</th>
                          <th class="text-center">Method</th>
                        </tr>
                        <?php
                        $li =1;
                        while($loandetails_row=mysqli_fetch_array($loandetails_q)){
                            $total = $loandetails_row['amountpaid'];
                            ?>
                                <tr>
                                    <td><?php echo $li++; ?></td>
                                    <td><?php echo $loandetails_row['date']; ?></td>
                                    <td class="text-center"><?php echo number_format($loandetails_row['amountpaid'],2); ?></td>
                                    <td class="text-center">Balance payment</td>
                                </tr>
                            <?php
                        }
                        ?>
                        
                    
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Note</div>
                        <p class="section-lead">Kindly repay outstanding loans to qualify for new loans.</p>
                        
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Loan total</div>
                          <div class="invoice-detail-value">$<?php echo number_format($loan_row['amount'],2) ?></div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Amount paid</div>
                          <div class="invoice-detail-value">$<?php echo number_format($loan_row['paid'],2) ?></div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Amount owed</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">$<?php echo number_format($loan_row['balance'],2) ?></div>
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
        <div class="modal fade" id="payloan" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">Pay your debt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="loanpaymentform">
                <input type="hidden" name="paytoken" id="token" value="<?php echo $_SESSION['paytoken'] ?? '' ?>" required>
                <input type="hidden" name="loanpaymentform" value="<?php echo $_SESSION['paytoken'] ?? '' ?>" required>
                <input type="hidden" name="orderID" value="<?php echo $orderid ?>" required>
                  <div class="form-group">
                    <label>Amount to pay</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          $
                        </div>
                      </div>
                      <input type="text" id="amount" name="amount" placeholder="0.00" required class="form-control currency">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Pay</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php" ?>
</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>