<?php
	session_start();
    include '../includes/getdb.php';
	if(isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['token'])){

		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

		if (!$token || $token !== $_SESSION['token']) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
			exit;
		} else {
		header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Allowed');
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_confirm = $_POST['passwordconfirm'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$dob = $_POST['dob'];

		$sql = "SELECT * FROM tclient WHERE email = '$email'";
		$query = $conn->query($sql);

		if($query->num_rows ==0){
			$row = $query->fetch_assoc();

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
			 '$address','$phone','$dob','$date_joined', 0, 0, '$myRandomString')");
						
			$verification_addresss="https://www.app.canzainvestment.com/auth/email-verification?email=".$email."&step=".$myRandomString."&source=".$myRandomString2."";

			$message = '<html><head>';
			$message .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">';
			$message .= '</head><body>';
			$message .= '<div class="card text-center">
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
		  </div>';
			$message .= "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script></body></html>";

			
			
			$to=$email;
			$subject="Email Verification";
			$headers = "From:accounts@canzainvestment.com" "\r\n";
			$headers .= "Reply-To: ". strip_tags("admin@canzainvestment.com") . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			if (mail($to, $subject, $message, $headers)) {
				$output = 1; //Mail sent
			  } else {
				$output = 2; //An error occured while sending mail
			  }


		}
		else{
			$output = 3; // User already exists
		}

		}

		
	}

	echo $output;

?>