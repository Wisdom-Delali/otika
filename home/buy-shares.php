<?php include "../includes/header.php";
$_SESSION['token'] = md5(uniqid(mt_rand(), true)); ?>

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
                <?php $commodity_q=mysqli_query($conn, "SELECT * FROM commodity WHERE active_status=1");while($commodity_row=mysqli_fetch_array($commodity_q)){
                  ?>
                    <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing pricing-highlight">
                  <div class="pricing-title">
                    <?php echo $commodity_row['commodityName']; ?>
                  </div>
                  <div class="pricing-padding">
                    <div class="pricing-price">
                      <div>$<?php echo number_format($commodity_row['price'],2); ?></div>
                      <div>per share</div>
                    </div>
                    <div class="pricing-details">
                      <div class="pricing-item">
                        <p><?php echo $commodity_row['description']; ?></p>
                      </div>
                      
                    </div>
                  </div>
                  <div class="pricing-cta">
                  <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                      <input type="number" placeholder="Qty" class="form-control" min="1" style="width:100px;" id="qty<?php echo $commodity_row['commodityID'] ?>">
                      <input type="hidden"  id="csrf<?php echo $_SESSION['token'] ?? '' ?>">
                      <button type="button" class="btn btn-primary  addtocart" value="<?php echo $commodity_row['commodityID'] ?>"><i class="fa fa-shopping-cart fa-fw"></i></button>
                    </div>
                 </div>
                </div>
              </div>
                  <?php
                } ?>
              
              
              
            </div>
          </div>
        </section>

      

<?php include "../includes/footer-main.php"; ?>
<?php include "../includes/footer.php"; ?>

</body>


<!-- index  21 Nov 2019 03:47:04 GMT -->
</html>