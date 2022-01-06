<?php
	session_start();
    include '../includes/getdb.php';
	if(isset($_POST['email'])){
		$output = array('error'=>false);
		
		$email = $_POST["email"];
		$password = $_POST["password"];

		$sql = "SELECT * FROM tclient WHERE email = '$email'";
		$query = $conn->query($sql);

		if($query->num_rows > 0){
			$row = $query->fetch_assoc();
            if($password=$row['password']){
                $output['error'] = false;
			}
			else{
				$output['error'] = true;
			}



		}
		else{
			$output['error'] = true;
		}

        

	echo json_encode($output);

?>