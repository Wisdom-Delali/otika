<?php
	session_start();
	include 'getdb.php';

	if(!isset($_SESSION['clientID']) || trim($_SESSION['clientID']) == ''){
		?>
	<script>
	window.location="../auth/logout.php";
	</script>
	<?php
	}
    $client_id=$_SESSION['clientID'];
    $session_id=$_SESSION['session_id'];
    $profile_q=mysqli_query($conn, "SELECT * FROM tclient WHERE clientID='$client_id' AND session_id='$session_id'");
    if(mysqli_num_rows($profile_q)!=1){
        ?>
        <script>
        window.location="../auth/logout.php";
        </script>
        <?php
    }


?>