<?php include "../includes/header.php";
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
$shares_q=mysqli_query($conn, "SELECT * FROM tclientshares LEFT JOIN commodity ON tclientshares.commodityID=commodity.commodityID WHERE tclientshares.clientID='$client_id'"); // Main query
?>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include "../includes/navbar.php" ?>
      <!-- Main Content -->
      <div class="main-content">
          <div class="row">
            <?php while($share_row=mysqli_fetch_array($shares_q)){
              ?>
                <div class="col-12 col-sm-12 col-lg-6">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="../<?php echo $share_row['image']; ?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Shares owned</div>
                        <div class="profile-widget-item-value"><?php echo $share_row['shareamount']; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Price before</div>
                        <div class="profile-widget-item-value">$<?php echo number_format($share_row['pricebefore'],2); ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Price now</div>
                        <div class="profile-widget-item-value">$<?php echo number_format($share_row['price'],2); ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description pb-0">
                    <div class="profile-widget-name"><?php echo $share_row['commodityName']; ?> <div class="text-muted d-inline font-weight-normal">
                        <div class="slash"></div> Commodity
                      </div>
                    </div>
                    <p><?php echo $share_row['description']; ?></p>
                  </div>
                  <div class="card-footer text-center pt-0">
                    <div class="font-weight-bold mb-2 text-small">Actions</div>
                    <hr>
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                            <button type="button" value="<?php echo $share_row['commodityID'] ?>" class="btn btn-success addtocart">Buy</button>
                            <input type="number" min="1" max="<?php echo $share_row['shareamount']; ?>" class="form-control" placeholder="Quantity" id="qty<?php echo $share_row['commodityID'] ?>">
                            <input type="hidden" id="csrf<?php echo $_SESSION['token'] ?? '' ?>">
                            <button type="button" value="<?php echo $share_row['commodityID'] ?>" class="btn btn-warning sell">Sell</button>
                        </div>
                  </div>
                </div>
            </div>
              <?php
            } ?>
            
                 
        </div>

      

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php" ?>
</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>