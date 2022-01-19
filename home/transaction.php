<?php include "../includes/header.php";
$orderid=$_GET['order'];
$token = $_GET['csrf'];
    if (!$token || $token !== $_SESSION['token']) {
        header('dashboard');
        exit;
    } else {
        $sorder_q=mysqli_query($conn, "SELECT * FROM ttransactions WHERE clientID='$client_id' AND orderID='$orderid'");
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
                            <a href="my-transactions" class="btn btn-success">Back</a>
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
                          <th>Date</th>
                          <th class="text-center">Type</th>
                          <th class="text-center">Amount</th>
                          <th class="text-right">Address</th>
                        </tr>
                    
                            <tr>
                                <td>1</td>
                                <td><?php echo $sorder_row['date']; ?></td>
                                <td><?php if($sorder_row['trantype']==1){ echo "Deposit";}else{echo "Withdrawal";} ?></td>
                                <td class="text-center"><?php echo number_format($sorder_row['tranamount'],2); ?></td>
                                <td class="text-center"><?php echo $sorder_row['address']; ?></td>
                            </tr>
               
                    
                      </table>
                    </div>
                    
                  </div>
                </div>
              </div>
              <hr>
             
            </div>
          </div>
        </section>

<form id="callback" method="POST" action="my-transactions">
<input type="hidden" name="callbackC" value="<?php echo $_SESSION['token'] ?? '' ?>" required> 
<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>" required> 
<input type="hidden" name="txn_id"  value="<?php echo $sorder_row['txn_id']; ?>" required>
<input type="hidden" name="clientID" value="<?php echo $client_id; ?>" required>
<input type="hidden" name="email" value="<?php echo $profile_row['email']; ?>" required>
</form>

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php" ?>
<?php if($sorder_row['status']==1){}else{
?>
<script>
setInterval(function(){
    window.alert("Done");
    $('#callback').submit();
  
},5000);
</script>
<?php

} ?>

</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>