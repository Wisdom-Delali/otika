<?php
/*
	CoinPayments.net API Example
	Copyright 2014 CoinPayments.net. All rights reserved.	
	License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/
    include "../includes/getdb.php";
	require('coinpayments.inc.php');
   
    // Fill these in with the information from your CoinPayments.net account.
    $cp_merchant_id = '0db42135646151eb7d4a179f1ab1ecb0';
    $cp_ipn_secret = 'canzainvestmentcoinpayment';
    $cp_debug_email = 'admin@canzainvestment.com';

    //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.


    function errorAndDie($error_msg) {
        global $cp_debug_email;
        if (!empty($cp_debug_email)) {
            $report = 'Error: '.$error_msg."\n\n";
            $report .= "POST Data\n\n";
            foreach ($_POST as $k => $v) {
                $report .= "|$k| = |$v|\n";
            }
            mail($cp_debug_email, 'CoinPayments IPN Error', $report);
        }
        die('IPN Error: '.$error_msg);
    }

    if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
        errorAndDie('IPN Mode is not HMAC');
    }

    if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
        errorAndDie('No HMAC signature sent.');
    }

    $request = file_get_contents('php://input');
    if ($request === FALSE || empty($request)) {
        errorAndDie('Error reading POST data');
    }

    if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
        errorAndDie('No or incorrect Merchant ID passed');
    }

    $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
    if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
    //if ($hmac != $_SERVER['HTTP_HMAC']) { <-- Use this if you are running a version of PHP below 5.6.0 without the hash_equals function
        errorAndDie('HMAC signature does not match');
    }

    // HMAC Signature verified at this point, load some variables.

    $ipn_type = $_POST['ipn_type'];
    $txn_id = $_POST['txn_id'];
    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $amount1 = floatval($_POST['amount1']);
    $amount2 = floatval($_POST['amount2']);
    $currency1 = $_POST['currency1'];
    $currency2 = $_POST['currency2'];
    $status = intval($_POST['status']);
    $status_text = $_POST['status_text'];
    $txid = $_POST['invoice'];
    $client_id = $_POST['item_number'];
    $email = $_POST['buyer_email'];


    $order_currency = 'USD';
    $order_total = 10.00;

    $amount=$amount1;
    $order_id=$txid;

    if ($ipn_type != 'button') { // Advanced Button payment
        die("IPN OK: Not a button payment");
    }

    //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

    // Check the original currency to make sure the buyer didn't change it.
    if ($currency1 != $order_currency) {
        errorAndDie('Original currency mismatch!');
    }

    // Check amount against order total

 
    if ($status >= 100 || $status == 2) {
        $check=mysqli_query($conn, "SELECT * FROM ttransactions WHERE orderID='$order_id' AND clientID='$client_ID' AND status=0 LIMIT 1");
        $check_row=mysqli_fetch_array($check);
        if(mysqli_num_rows($check)!=1){
            errorAndDie('Account has already been credited!');
        }
        mysqli_query($conn, "UPDATE ttransactions SET status=1 WHERE orderID='$order_id' AND clientID='$client_ID'");
        $client_q=mysqli_query($conn, "SELECT * FROM tclient WHERE clientID='$client_ID' LIMIT 1");
        $client_row=mysqli_fetch_array($client_q);
        $balance=$client_row['client_account_balance'];
        $newbalance=$balance+$amount;
        mysqli_query($conn, "UPDATE tclient SET client_account_balance='$newbalance' WHERE clientID='$client_id'");
             
        $message = '<html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head><body><div class="card text-center">
				<div class="card-header">
				  Payment Recieved
				</div>
				<div class="card-body">
				  <h5 class="card-title">Canza Investment</h5>
				  <p class="card-text">Your order with reference <b>"'.$order_id.'" </b>has been processed successfully. Your account has been credited </p>
				</div>
				<div class="card-footer text-muted">
				  Thank you for doing business with us.
				</div>
			  </div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script></body></html>';
	
				
				$message2= '<html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head><body><div class="card text-center">
				<div class="card-header">
				  Coin Payment
				</div>
				<div class="card-body">
				  <h5 class="card-title">from:accounts@canzainvestments.com</h5>
				  <p class="card-text">Coin payment for '.$email.' has been processed successfully</p>
				  
				</div>
				
			  </div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script></body></html>';
				
			 
			 	$to=$email;
				$back="admin@canzainvestment.com";
				$from = "admin@canzainvestment.com";
				$subject="Coin Payment";
				$subject2="Coin Payment";
				$headers = "From: " . strip_tags($from) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
				$headers .= "CC: admin@canzainvestment.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";		
			
				mail($to, $subject, $message, $headers);
                mail($back, $subject2, $message2, $headers);


        // payment is complete or queued for nightly payout, success
    } else if ($status < 0) {
        //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
    } else {
        //payment is pending, you can optionally add a note to the order page
    }
    die('IPN OK');

    ?>