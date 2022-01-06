<?php
	session_start();
    include '../includes/getdb.php';
	if(isset($_POST['email'])){
		$output = array('error'=>false);
        $output['error'] = true;
		/* $email = mysqli_real_escape_string($conn,$_POST["email"]);
		$password = mysqli_real_escape_string($conn,$_POST["password"]);

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
		} */

        /* $stmt = $conn->prepare('SELECT * FROM Tclient WHERE email = '$email'');
        $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'
       
        $stmt->execute();
       
        $query = $stmt->get_result();

        // Do something with $row
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
        

	    } */

	echo json_encode($output);

?>