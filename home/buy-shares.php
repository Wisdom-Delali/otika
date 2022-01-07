<?php include "../includes/header.php" ?>

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
                      <div>$<?php echo $commodity_row['price']; ?></div>
                      <div>per share</div>
                    </div>
                    <div class="pricing-details">
                      <div class="pricing-item">
                        <p><?php echo $commodity_row['description']; ?></p>
                      </div>
                      
                    </div>
                  </div>
                  <div class="pricing-cta">
                    <button id="<?php echo $commodity_row['commodityID'] ?>" onclick="addtocart(this);" type="button">Add to cart <i class="fas fa-arrow-right"></i></button>
                  </div>
                </div>
              </div>
                  <?php
                } ?>
              
              <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing pricing-highlight">
                  <div class="pricing-title">
                    Small Team
                  </div>
                  <div class="pricing-padding">
                    <div class="pricing-price">
                      <div>$60</div>
                      <div>per month</div>
                    </div>
                    <div class="pricing-details">
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">5 user agent</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Core features</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">10GB storage</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">10 Custom domain</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">24/7 Support</div>
                      </div>
                    </div>
                  </div>
                  <div class="pricing-cta">
                    <a href="#">Subscribe <i class="fas fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing">
                  <div class="pricing-title">
                    Enterprise
                  </div>
                  <div class="pricing-padding">
                    <div class="pricing-price">
                      <div>$499</div>
                      <div>per month</div>
                    </div>
                    <div class="pricing-details">
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Unlimited user agent</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Core features</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">8TB storage</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Unlimited custom domain</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Lifetime Support</div>
                      </div>
                    </div>
                  </div>
                  <div class="pricing-cta">
                    <a href="#">Subscribe <i class="fas fa-arrow-right"></i></a>
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