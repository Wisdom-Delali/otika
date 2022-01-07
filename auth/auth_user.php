<?php
	session_start();
    include 'getdb.php';
	if(isset($_POST['email'])){
		$output = array('error'=>false);


		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM tclient WHERE email = '$email'";
		$query = $conn->query($sql);

		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
            if($password==$row['password']){
                $_SESSION['clientID'] = $row['clientID'];
                $_SESSION['user_type'] = "client";
                $_SESSION['loggedin'] = "1";
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