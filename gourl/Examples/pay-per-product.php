<?php
/**
 * @category    Example1 - Pay-Per-Product (single crypto currency in payment box)
 * @package     GoUrl Cryptocurrency Payment API 
 * copyright 	(c) 2014-2021 Delta Consultants
 * @crypto      Supported Cryptocoins -	Bitcoin, BitcoinCash, BitcoinSV, Litecoin, Dash, Dogecoin, Speedcoin, Reddcoin, Potcoin, Feathercoin, Vertcoin, Peercoin, MonetaryUnit, UniversalCurrency
 * @website     https://gourl.io/bitcoin-payment-gateway-api.html#p1
 * @live_demo   https://gourl.io/lib/examples/pay-per-product.php
 */ 

	/********************** NOTE - 2018 YEAR *******************************************************************************/ 
	/*****                                                                                                             *****/ 
	/*****     This is iFrame Bitcoin Payment Box Example (2014 - 2017)                                                *****/ 
	/*****                                                                                                             *****/ 
	/*****     Available - new 2018-2021 version; mobile friendly JSON payment box (own logo, white label product)     *****/
	/*****     New Demo with generation php payment box code - https://gourl.io/lib/examples/example_customize_box.php *****/
	/*****         White Theme - https://gourl.io/lib/examples/example_customize_box.php?theme=black                   *****/
	/*****         Black Theme - https://gourl.io/lib/examples/example_customize_box.php?theme=default     		   *****/
	/*****         Your Own Logo - https://gourl.io/lib/examples/example_customize_box.php?theme=default&logo=custom   *****/
	/*****                                                                                                             *****/ 
	/***********************************************************************************************************************/


	
	
	require_once( "../lib/cryptobox.class.php" );
	require_once( "../../includes/session.php" );

	
	/**** CONFIGURATION VARIABLES ****/ 
	$token = $_POST['token'];

        if (!$token || $token !== $_SESSION['token']) {
            // return 405 http status code
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        } else {
			
		}
	$userID 		= $_POST['clientID'];				// place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
										// you don't need to use userID for unregistered website visitors
										// if userID is empty, system will autogenerate userID and save in cookies
	$userFormat		= "SESSION";			// save userID in cookies (or you can use IPADDRESS, SESSION)
	$orderID 		= $_POST['orderID'];	// invoice number - 000383
	$amountUSD		= $_POST['amount'];				// invoice amount - 2.21 USD
	$period			= "NOEXPIRY";		// one time payment, not expiry
	$def_language	= "en";				// default Payment Box Language
	$public_key		= "62391AAvGSi1Bitcoin77BTCPUBnnPs184KGvsFxoTI0tMsl5K"; // from gourl.io
	$private_key	= "62391AAvGSi1Bitcoin77BTCPRVRYLLSG6BmpkatCZ8jIzc6bj";// from gourl.io

	// IMPORTANT: Please read description of options here - https://gourl.io/api-php.html#options  
	
	// *** For convert Euro/GBP/etc. to USD/Bitcoin, use function convert_currency_live() with Google Finance
	// *** examples: convert_currency_live("EUR", "BTC", 22.37) - convert 22.37 Euro to Bitcoin
	// *** convert_currency_live("EUR", "USD", 22.37) - convert 22.37 Euro to USD

	/********************************/


	
	
	
	
	/** PAYMENT BOX **/
	$options = array(
			"public_key"  => $public_key, 	// your public key from gourl.io
			"private_key" => $private_key, 	// your private key from gourl.io
			"webdev_key"  => "", 		// optional, gourl affiliate key
			"orderID"     => $orderID, 		// order id or product name
			"userID"      => $userID, 		// unique identifier for every user
			"userFormat"  => $userFormat, 	// save userID in COOKIE, IPADDRESS or SESSION
			"amount"   	  => 0,				// product price in coins OR in USD below
			"amountUSD"   => $amountUSD,	// we use product price in USD
			"period"      => $period, 		// payment valid period
			"language"	  => $def_language  // text on EN - english, FR - french, etc
	);

	// Initialise Payment Class
	$box = new Cryptobox ($options);
	
	// coin name
	$coinName = $box->coin_name(); 
	
	// Successful Cryptocoin Payment received
	if ($box->is_paid()) 
	{
		if (!$box->is_confirmed()) {
			$message =  "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). Awaiting transaction/payment confirmation";
		}											
		else 
		{ // payment confirmed (6+ confirmations)

			// one time action
			if (!$box->is_processed())
			{
				// One time action after payment has been made/confirmed
				// !!For update db records, please use function cryptobox_new_payment()!!
				 
				$message = "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). Payment Confirmed. <br>(User will see this message one time after payment has been made)"; 
				
				// Set Payment Status to Processed
				$box->set_status_processed();  
			}
			else $message = "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). Payment Confirmed. <br>(User will see this message during ".$period." period after payment has been made)"; // General message
		}
	}
	else $message = "This invoice has not been paid yet";
	
	
	// Optional - Language selection list for payment box (html code)
	$languages_list = display_language_box($def_language);





	// ...
	// Also you need to use IPN function cryptobox_new_payment($paymentID = 0, $payment_details = array(), $box_status = "") 
	// for send confirmation email, update database, update user membership, etc.
	// You need to modify file - cryptobox.newpayment.php, read more - https://gourl.io/api-php.html#ipn
	// ...
		
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title><?php echo $coinName; ?> Payment</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='Expires' content='-1'>
<meta name='robots' content='all'>
<script src='../js/cryptobox.min.js' type='text/javascript'></script>
</head>
<body style='font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#666;margin:0'>
<div align='center'>
<div style='width:100%;height:auto;line-height:50px;background-color:#f1f1f1;border-bottom:1px solid #ddd;color:#49abe9;font-size:18px;'>
	1. GoUrl <b>Canza Investment</b>  (<?php echo $coinName; ?> payment). 
	
	
</div>

<h1>Deposit - Customer Invoice</h1>
<br>


<br><br>
<?php if (!$box->is_paid()) echo "<h2>Pay Invoice Now - </h2>"; else echo "<br><br>";  ?>
<div style='margin:30px 0 5px 300px'>Language: &#160; <?php echo $languages_list; ?></div>
<?php echo $box->display_cryptobox(true, 580, 230); ?>
<br><br><br>
<h3>Message :</h3>
<h2 style='color:#999'><?php echo $message; ?></h2>


</div><br><br><br><br><br><br>
<div style='position:absolute;left:0;'><a target="_blank" href="http://validator.w3.org/check?uri=<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"><img src="https://gourl.io/images/w3c.png" alt="Valid HTML 4.01 Transitional"></a></div>
</body>
</html>