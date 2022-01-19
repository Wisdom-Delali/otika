<?php include "../includes/header.php";
$transactions_q=mysqli_query($conn, "SELECT * FROM ttransactions WHERE clientID='$client_id'");
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
function generateRandomString($length = 25) {
    $characters = '-!%$0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
};
//usage 
$myRandomString = generateRandomString(200);
$_SESSION['uid'] = $myRandomString;

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
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>My Transactions</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $li=1;
                          while($transaction_row=mysqli_fetch_array($transactions_q)){
                            ?>
                              <tr>
                                <td><?php echo $li++ ?></td>
                                <td><?php echo $transaction_row['date']; ?></td>
                                <td><?php if($transaction_row['trantype']==1){echo "Deposit";}else{echo "Withdrawal";} ?></td>
                                <td><?php echo number_format($transaction_row['tranamount'],2); ?></td>
                                <td><div class="badge badge-<?php if($transaction_row['status']==1){echo "success";}else{echo "warning";} ?> badge-shadow"><?php if($transaction_row['status']==1){echo "Completed";}else{echo "Pending";} ?></div></td>
                                <td><a href="transaction?csrf=<?php echo $_SESSION['token'] ?? '' ?>&order=<?php echo $transaction_row['orderID']; ?>&uid=<?php echo $myRandomString ?? '' ?>&cli=true&sha=true" class="btn btn-primary">Details</a></td>
                              </tr>
                            <?php
                          }; ?>
                    
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
         
          </div>
        </section>

      

<?php include "../includes/footer-main.php" ?>

<?php include "../includes/footer.php" ?>
</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>