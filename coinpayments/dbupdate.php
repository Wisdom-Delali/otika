<?php
    include '../includes/session.php';
    require('coinpayments.inc.php');

	if(isset($_GET['txn_id'])){
		$output = array('error'=>false);

        $token = "a";
        $txn_id = $_GET['txn_id'];
        $callbackC = "a";

        if (!$token) {
            // return 405 http status code
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        } else {
            $cps = new CoinPaymentsAPI();
            $txId=$_GET['txn_id'];
           $cps->Setup('D47C0455086572E8a322f3f2eC313e92Ef199Cb5eA22a7AC5aAe3632cb33317C', 'e518e60876ed2b2f9c25c5ef5196577ba3e0f7f6cf80211a5ecadde211659912');
           $result = $cps->GetTransactionInformation($txId);
            //get the array info of transaction
            if ($result['error'] == 'ok') {
                $status=intval($result['result']['status']);
                $check=mysqli_query($conn, "SELECT * FROM `ttransactions` WHERE txn_id='$txID'");
                    if(mysqli_num_rows($check)==1){
                        mysqli_query($conn, "UPDATE `ttransactions` SET `status`=1 WHERE clientID='$client_id' AND txn_id='$txID'");
                        
                        $tnxrow=mysqli_fetch_array($check);
                        $amount=intval($tnxrow['tranamount']);
                        $clientbalance = intval($profile_row['client_account_balance']);
                        if(intval($tnxrow['trantype'])==1){
                            $newclientbalance = $clientbalance+$amount;
                        }else{
                            $newclientbalance = $clientbalance-$amount;
                        };
                        mysqli_query($conn, "UPDATE `tclient` SET `client_account_balance`='$newclientbalance' WHERE clientID='$client_id'");
                echo $status;
            }else{
                echo "none";
            }
        }
           
        }
        
		
	}


?>