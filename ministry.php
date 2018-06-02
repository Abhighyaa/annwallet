<!DOCTYPE html>
<html>
<head>
	<title>I am ministry</title>
</head>
<body>

	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
		
		<input type="file" name="publickey" /><br><br>
		<input type="file" name="privatekey" /><br><br>

		<button type="submit" name="btn-upload">upload</button>

		<?php

			if($_SERVER['REQUEST_METHOD']=="POST"){
				$ministryPublicKey = file_get_contents('ministryPublicKey.txt');
				$publicKey = file_get_contents($_FILES['publickey']['tmp_name']);
				$privateKey = file_get_contents($_FILES['privatekey']['tmp_name']);

				$ministryPrivateKey = file_get_contents('ministryPrivateKey.txt');

				$check = "done";

				openssl_public_encrypt($check, $encryptedData, $publicKey);
				openssl_private_decrypt($encryptedData, $decryptedData,$privateKey);


				if($check === $decryptedData){

					if($publicKey == $ministryPublicKey){
						
						include('connectdb.php');
						$displaydb = "SELECT * from gotoministry";
						$result=$conn->query($displaydb);
   						if ($result->num_rows > 0) {

   							while($row = $result->fetch_assoc()) {
     						
     							$answerEncrypted =base64_decode($row['encryptedAnswer']);
     							$hashPublicKeyEncrypted= base64_decode($row['encryptedHash']);
     							openssl_private_decrypt($answerEncrypted, $answerDecrypted, $ministryPrivateKey);
								openssl_private_decrypt($hashPublicKeyEncrypted, $hashPublicKeyDecrypted, $ministryPrivateKey);
								echo "<br><br>$answerDecrypted				$hashPublicKeyDecrypted			<a href=a.php>Approve</a> 		<a href=a.php>Decline</a> <br>";

       						}

   						}

					}

				}

			}

		?>

	</form>

</body>
</html>