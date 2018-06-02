   	<?php $SERVER = 'localhost';
   	$username = 'root';
	$passwd = 'root';
	$dbname = 'annonymous_wallet';
	
	$conn = new mysqli($SERVER,$username,$passwd,$dbname);
	if ($conn->connect_error) {
	  	die("Connection failed: " . $conn->connect_error);
	} ?>