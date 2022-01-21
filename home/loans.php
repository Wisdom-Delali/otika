<?php include "../includes/header.php";
$loans_q=mysqli_query($conn, "SELECT * FROM loans WHERE clientID='$client_id'");
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
function generateRandomString($length = 25) {
    $characters = '$0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
};
//usage 
$myRandomString = generateRandomString(50);
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
                    <h4>Loans</h4>
                    <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#requestloanmodal">Request a loan</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Purpose</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $li=1;
                          while($loan_row=mysqli_fetch_array($loans_q)){
                            ?>
                              <tr>
                                <td><?php echo $li++ ?></td>
                                <td><?php echo $loan_row['date']; ?></td>
                                <td><?php echo number_format($loan_row['amount'],2); ?></td>
                                <td><div class="badge badge-<?php if($loan_row['status']==2){echo "success";}elseif($loan_row['status']==1){echo "danger";}else{echo "warning";} ?> badge-shadow"><?php if($loan_row['status']==2){echo "Completed";}elseif($loan_row['status']==1){echo "Owing ".number_format($loan_row['balance'],2);}else{echo "Pending approval";} ?></div></td>
                                <td><?php echo mb_strimwidth($loan_row['purpose'], 0, 30, '...') ; ?></td>
                                <td><form method="POST" action="loan"><input type="hidden" name="loan" value="<?php echo $loan_row['orderID']; ?>" required><input type="hidden" name="csrf" value="<?php echo $_SESSION['token'] ?? '' ?>" required><input type="hidden" name="uid" value="<?php echo $myRandomString; ?>" required><button type="submit" class="btn btn-primary">Details</button></form></td>
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