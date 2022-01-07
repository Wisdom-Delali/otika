<?php

	session_start();
	session_destroy();

	?>
	<script>
	window.location="auth-login.php";
	</script>
	<?php

exit();
?>