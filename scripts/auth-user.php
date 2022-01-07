<?php
	session_start();
    include '../includes/getdb.php';
	if(isset($_POST['email'])){
		$output = array('error'=>false);


		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM tclient WHERE email = '$email'";
		$query = $conn->query($sql);

		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
            if($password==$row['password']){
                function generateRandomString($length = 25) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                };
                //usage 
                $myRandomString = generateRandomString(200);
                $client_id=$row['clientID'];
                mysqli_query($conn, "UPDATE tclient SET session_id='$myRandomString' WHERE clientID='$client_id'");
                $_SESSION['clientID'] = $row['clientID'];
                $_SESSION['user_type'] = "client";
                $_SESSION['loggedin'] = "1";
                $_SESSION['session_id'] = $myRandomString;
                $output['error'] = false;
			}
			else{
				$output['error'] = true;
			}



		}
		else{
			$output['error'] = true;
		}

	}

	echo json_encode($output);

?>