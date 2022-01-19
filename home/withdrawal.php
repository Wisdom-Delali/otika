<?php include "../includes/header.php";
require('../coinpayments/coinpayments.inc.php');
?>
<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- Main Content -->
      <div class="main-content">
        

<?php
if(isset($_POST['withdrawC'])){
    $withdraw = filter_input(INPUT_POST, 'withdrawC', FILTER_SANITIZE_STRING);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $currency = filter_input(INPUT_POST, 'imagecheck', FILTER_SANITIZE_STRING);
    $order = filter_input(INPUT_POST, 'orderID', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token'] || !$withdraw || $withdraw !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit();
    } else {
        $email = $_POST['email'];
        $amount = $_POST['amount'];

        $cps = new CoinPaymentsAPI();
        $cps->Setup('D47C0455086572E8a322f3f2eC313e92Ef199Cb5eA22a7AC5aAe3632cb33317C', 'e518e60876ed2b2f9c25c5ef5196577ba3e0f7f6cf80211a5ecadde211659912');
    
        $result = $cps->CreateWithdrawal($amount, $currency, $address);

        if ($result['error'] == 'ok') {
            $txn_id=$result['result']['txn_id'];
            mysqli_query($conn, "INSERT INTO `ttransactions`(`clientID`, `address`, `txn_id`, `orderID`, `trantype`, `status`, `tranamount`, `tranmethod`) VALUES ('$client_id', '$address', '$txn_id','$order',2,0,'$amount',1)");
            $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
            ?>
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                        <div class="col-12 col-md-6 col-sm-12">
                            <div class="card">
                            <div class="card-header">
                                <h4>Withdrawal - <?php echo $currency; ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="empty-state" data-height="400">
                                    <div class="buttons">
                                        <a href="#" class="btn btn-lg btn-sm btn-warning">Processing Withdrawal</a>
                                        <a href="#" class="btn btn-lg disabled btn-primary btn-progress"></a>
                                        <a href="#" class="btn btn-lg disabled btn-primary"><?php echo $currency; ?></a>
                                    </div>
                                <h2>Withdrawal</h2>
                                <p class="lead">
                                    <?php print 'Withdrawal created with ID: '.$result['result']['id']; ?>
                                </p><br>
                                
                                <a href="#" class="btn btn-primary mt-4">Your account will be debited once payment has been confirmed.</a><br>
                                <a href="<?php print $result['result']['status_url'].$le ?>" class="mt-4 bb">Monitor transaction</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </section>
            <?php
        } else {
            ?>
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                        <div class="col-12 col-md-6 col-sm-12">
                            <div class="card">
                            <div class="card-header">
                                <h4>Coin Payment - <?php echo $currency; ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="empty-state" data-height="400">
                                <div class="empty-state-icon">
                                    <div class="empty-state-icon bg-danger">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                                <h2>Error</h2>
                                <p class="lead">
                                    <?php print 'Error: '.$result['error']."\n"; ?>
                                </p>
                                
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </section>
            <?php
        }

    }
    
}


?>

            

<?php include "../includes/footer-main.php" ?>
<?php include "../includes/footer.php" ?>
</body>