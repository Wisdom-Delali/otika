<?php
	$conn = new mysqli('localhost', 'root', '', 'db_canza_invest');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>