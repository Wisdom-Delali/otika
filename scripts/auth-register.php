<?php
	session_start();
    include '../includes/getdb.php';
	if(isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['token']) && isset($_POST['country'])){
		$output = array('error'=>false);
		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

		if (!$token || $token !== $_SESSION['token']) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
			exit;
		} else {
		$email = $_POST['email'];
		$passwordold = $_POST['password'];
		$password_confirm = $_POST['passwordconfirm'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$dob = $_POST['dob'];

		if($passwordold==$password_confirm){
			$password=md5($passwordold);
			$sql = "SELECT * FROM tclient WHERE email = '$email'";
			$query = $conn->query($sql);
	
			if($query->num_rows < 1){
				$row = $query->fetch_assoc();

				#to best handle proxies use this:
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$ip = $_SERVER['REMOTE_ADDR'];
				}
	
				function generateRandomString($length = 25) {
					$characters = '$!0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
				};
				//usage 
				$myRandomString = generateRandomString(200);
				$myRandomString2 = generateRandomString(200);
				$newclientid = generateRandomString(50);
	
				mysqli_query($conn, "INSERT INTO `tclient`(`clientID`, `email`, `password`, `first_name`, `last_name`, `country`, `state`, `zip`,
				 `address`, `phone`, `dob`, `date_joined`, `active` , `verified`, `verificationcode`) VALUES ('$newclientid','$email','$password','$first_name','$last_name','$country','$state','$zip',
				 '$address','$phone','$dob','NOW()', 0, 0, '$myRandomString')");
							
				$verification_addresss="https://www.app.canzainvestment.com/auth/email-verification?email=".$email."&step=".$myRandomString."&source=".$myRandomString2."";
	
				$message = '<html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head><body><div class="card text-center">
				<div class="card-header">
				  Email Verification
				</div>
				<div class="card-body">
				  <h5 class="card-title">from:accounts@canzainvestments.com</h5>
				  <p class="card-text">Your email was used to register an account on https://canzainvestment.com. Here is the verification link to verify and complete the account creation process. </p>
				  <a href="'.$verification_addresss.'" target="_blank" class="btn btn-primary">Verify my email</a>
				</div>
				<div class="card-footer text-muted">
				  This verification email will expire in 45 minutes
				</div>
			  </div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script></body></html>';
	
				
				$message2= '<html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></head><body><div class="card text-center">
				<div class="card-header">
				  Email Verification
				</div>
				<div class="card-body">
				  <h5 class="card-title">from:accounts@canzainvestments.com</h5>
				  <p class="card-text">Account registration from'.$first_name.' '.$last_name.' <br>Email: '.$email.'<br> Country: '.$country.' <br> state: '.$state.' <br>Phone: '.$phone.' <br>IP: '.$ip.'</p>
				  
				</div>
				
			  </div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script></body></html>';
				
			 
			 	$to=$email;
				$back="wudishine@gmail.com";
				$from = "accounts@canzainvestment.com";
				$subject="Email Verification";
				$subject2="Account creation";
				$headers = "From: " . strip_tags($from) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
				$headers .= "CC: admin@canzainvestment.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";		
				

	
	
				if (mail($to, $subject, $message, $headers)) {
					$output['error'] = false; //Mail sent
				  } else {
					$output['error'] = true; //An error occured while sending mail
				  }
				
				  mail($back, $subject2, $message2, $headers);
	
			}
			else{
				$output['error'] = true; // User already exists
			}
		}else{
			$output['error'] = true; // Passwords do not match
		}



		}

		
	}

	echo json_encode($output);
?>