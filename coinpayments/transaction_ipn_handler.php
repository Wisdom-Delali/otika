<?php
/*
	CoinPayments.net API Example
	Copyright 2014 CoinPayments.net. All rights reserved.	
	License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/
   include "../includes/getdb.php";
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
    $orderID = $_POST['invoice'];
    $clientID = $_POST['item_number'];
    $email = 'wudishine@gmail.com';

    $message = '
				  <br>order id = '.$orderID.';
				  <br>status id = '.$status.';
				  <br>client id = '.$clientID.';
				  <br>status  = '.$status.';
				  <br>amount = '.$amount1.';
                 ';
	
    $message2 = '
				  <br>order id 2= '.$orderID.';
				  <br>status id = '.$status.';
				  <br>client id = '.$clientID.';
				  <br>status  = '.$status.';
				  <br>amount = '.$amount1.';
                 
				';
                
    $message3 = '
				  <br>order id 3= '.$orderID.';
				  <br>status id = '.$status.';
				  <br>client id = '.$clientID.';
				  <br>status  = '.$status.';
				  <br>amount = '.$amount1.';
                 
				';
	

    $order_currency = 'USD';
    $order_total = 10.00;


    if ($ipn_type != 'button') { // Advanced Button payment
        die("IPN OK: Not a button payment");
    }

    //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

    // Check the original currency to make sure the buyer didn't change it.
    if ($currency1 != $order_currency) {
        errorAndDie('Original currency mismatch!');
    }

    // Check amount against order total

    $to=$email;
    $back="wudishine@gmail.com";
    $from = "accounts@canzainvestment.com";
    $subject="Done";
    $subject2="Account creation";
    $headers = "From: " . strip_tags($from) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	
    

 
    if ($status >= 100 || $status == 2) {
        mail($to, $subject, $message, $headers);
        $check=mysqli_query($conn, "SELECT * FROM `ttransactions` WHERE orderID='$orderID' AND clientID='$clientID' AND status=0");
        if(mysqli_num_rows($check)==1){
            mysqli_query($conn, "UPDATE `ttransactions` SET `status`=1 WHERE orderID='$orderID' AND clientID='$clientID' AND status=0");
            $clientq=mysqli_query($conn, "SELECT * FROM `tclient` WHERE clientID='$clientID'");
            $clientrow=mysqli_fetch_array($clientq);
            $clientbalance = $clientrow['client_account_balance'];
            $newclientbalance = $clientbalance+$amount1;
            mysqli_query($conn, "UPDATE `tclient` SET `client_account_balance`='$newclientbalance' WHERE clientID='$clientID'");

        }
        
        // payment is complete or queued for nightly payout, success
    } else if ($status < 0) {
        mail($to, $subject, $message2, $headers);
        //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
    } else {
        mail($to, $subject, $message3, $headers);
        //payment is pending, you can optionally add a note to the order page
    }
    die('IPN OK');

    ?>