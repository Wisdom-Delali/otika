<?php
include "../includes/getdb.php";
session_start();
$client_id=$_SESSION['clientID'];
    $session_id=$_SESSION['session_id'];
    mysqli_query($conn, "UPDATE tclient SET session_id='' WHERE clientID='$client_id' AND session_id='$session_id'");
	

	session_destroy();


	?>
	<script>
	window.location="auth-login.php";
	</script>
	<?php

exit();
?>