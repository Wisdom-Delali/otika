<?php
    include '../includes/seesion.php';
    require('coinpayments.inc.php');

	if(isset($_POST['txn_id'])){
		$output = array('error'=>false);

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        $txn_id = filter_input(INPUT_POST, 'txn_id', FILTER_SANITIZE_STRING);
        $callbackC = filter_input(INPUT_POST, 'callbackC', FILTER_SANITIZE_STRING);

        if (!$token || $token !== $_SESSION['token']) {
            // return 405 http status code
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        } else {
            $cps = new CoinPaymentsAPI();
            $txId=$_GET['id'];
           $cps->Setup('D47C0455086572E8a322f3f2eC313e92Ef199Cb5eA22a7AC5aAe3632cb33317C', 'e518e60876ed2b2f9c25c5ef5196577ba3e0f7f6cf80211a5ecadde211659912');
           $result = $cps->GetTransactionInformation($txId);
            //get the array info of transaction
            if ($result['error'] == 'ok') {
                $status=$result['result']['status'];
        
                $verification_addresss="https://www.app.canzainvestment.com/auth/auth-login?page=my-transactions";
        
        
                $message = '<html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head><body><div class="card text-center">
                        <div class="card-header">
                          Payment Confirmation
                        </div>
                        <div class="card-body">
                          <h5 class="card-title">Canza Investment</h5>
                          <p class="card-text">Your payment has been processed successfully.</p>
                          <a href="'.$verification_addresss.'" target="_blank" class="btn btn-primary">Open account</a>
                        </div>
                        
                      </div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script></body></html>';
            
        
                $back="wudishine@gmail.com";
                $from = "admin@canzainvestment.com";
                $subject="Payment Confirmed";
                $headers = "From: " . strip_tags($from) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
                if ($status >= 100 || $status == 2) {
                    $check=mysqli_query($conn, "SELECT * FROM `ttransactions` WHERE txn_id='$txID'LIMIT 1");
                    if(mysqli_num_rows($check)==1){
                        mysqli_query($conn, "UPDATE `ttransactions` SET `status`=1 WHERE clientID='$client_id' AND txn_id='$txID'");
                        
                        $tnxrow=mysqli_fetch_array($check);
                        $amount=$tnxrow['tranamount'];
                        $clientbalance = $profile_row['client_account_balance'];
                        if($tnxrow['trantype']==1){
                            $newclientbalance = $clientbalance+$amount;
                        }else{
                            $newclientbalance = $clientbalance-$amount;
                        };
                        mysqli_query($conn, "UPDATE `tclient` SET `client_account_balance`='$newclientbalance' WHERE clientID='$client_id'");
                        mail($to, $subject, $message, $headers);
                        $output['error'] = false;
                    }
                    // payment is complete or queued for nightly payout, success
                } 
        
             } else {
                $output['error'] = true;
             }
        }
        
		
	}

	echo json_encode($output);

?>