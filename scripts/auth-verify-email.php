<?php
	session_start();
    include '../includes/getdb.php';
	if(isset($_POST['email'])){
		$output = array('error'=>false);


		$email = $_POST['email'];
		$step = $_POST['step'];

		$sql = "SELECT * FROM tclient WHERE email = '$email' AND verificationcode='$step' AND verified='0'";
		$query = $conn->query($sql);

		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
            $client_id = $row['clientID'];
            mysqli_query($conn, "UPDATE tclient SET verified='1', verificationcode='', active='1' WHERE clientID='$client_id'");
            $output['error'] = false;
		}
		else{
			$output['error'] = true;
		}

	}

	echo json_encode($output);

?>