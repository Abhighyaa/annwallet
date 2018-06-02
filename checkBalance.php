<!DOCTYPE html>
<html>
<head>
	<title>Check Wallet Balance</title>
</head>
<body>

	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
		
		<input type="file" name="publickey" /><br><br>
		<input type="file" name="privatekey" /><br><br>

		<button type="submit" name="btn-upload">upload</button>
		
		<?php
		if($_SERVER['REQUEST_METHOD']=="POST"){
			
			include('connectdb.php');

			$publicKey = file_get_contents($_FILES['publickey']['tmp_name']);
			$privateKey = file_get_contents($_FILES['privatekey']['tmp_name']);

			$check = "done";

			openssl_public_encrypt($check, $encryptedData, $publicKey);
			openssl_private_decrypt($encryptedData, $decryptedData,$privateKey);


			if($check === $decryptedData){

				$hashPublicKey = hash('sha256',$publicKey);
				
				$checkdb = "SELECT * FROM balance where hash='$hashPublicKey' ";
				$result = $conn->query($checkdb);
   				if ($result->num_rows ==1) {
   					$row = mysqli_fetch_array($result);
   					$balance=$row['bal'];
   				
   					echo "Heyy, Your balance is ".$balance;

   				}				

			}
			else{
				echo "Wrong keys.";
			}


   		}
		?>


	</form>


</body>
</html>