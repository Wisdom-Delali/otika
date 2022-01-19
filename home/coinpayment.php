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
if(isset($_POST['depositC'])){
    $deposit = filter_input(INPUT_POST, 'depositC', FILTER_SANITIZE_STRING);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $currency = filter_input(INPUT_POST, 'imagecheck', FILTER_SANITIZE_STRING);
    $order = filter_input(INPUT_POST, 'orderID', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token'] || !$deposit || $deposit !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit();
    } else {
        
        $cps = new CoinPaymentsAPI();
        $cps->Setup('D47C0455086572E8a322f3f2eC313e92Ef199Cb5eA22a7AC5aAe3632cb33317C', 'e518e60876ed2b2f9c25c5ef5196577ba3e0f7f6cf80211a5ecadde211659912');

        $email = $_POST['email'];
        $amount = $_POST['amount'];

        $req = array(
            'amount' => $amount,
            'currency1' => 'USD',
            'currency2' => $currency,
            'buyer_email' => $email,
            'item_number' => $order,
            'invoice' => strip_tags($order),
            'item_name' => 'Deposit',
            'item_number' => $client_id,
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'ipn_url' => 'http://app.canzainvestment.com/coinpayments/transaction_ipn_handler',
        );
        // See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields  
        $result = $cps->CreateTransaction($req);
        if ($result['error'] == 'ok') {
            $txn_id=$result['result']['txn_id'];
            $address=$result['result']['address'];
            mysqli_query($conn, "INSERT INTO `ttransactions`(`clientID`, `address`, `txn_id`, `orderID`, `trantype`, `status`, `tranamount`, `tranmethod`) VALUES ('$client_id', '$address', '$txn_id','$order',1,0,'$amount',1)");
            $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
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
                                    <div class="buttons">
                                        <a href="#" class="btn btn-lg btn-sm btn-warning">Processing Payment</a>
                                        <a href="#" class="btn btn-lg disabled btn-primary btn-progress"></a>
                                        <a href="#" class="btn btn-lg disabled btn-primary"><?php echo $currency; ?></a>
                                    </div>
                                <h2>Deposit payment</h2>
                                <p class="lead">
                                    <?php print 'Address: '.$result['result']['address'].$le; ?>
                                </p><br>
                                <p class="lead">
                                    <?php print 'Send: '.sprintf('%.08f', $result['result']['amount']).' '. $currency.$le; ?>
                                </p>
                                <a href="#" class="btn btn-primary mt-4">Your account will be credited once payment has been confirmed.</a><br>
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