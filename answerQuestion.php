<!DOCTYPE html>
<html>
<head>
	<title>Answer Question</title>
</head>
<body>

	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
		What is 2+3?<br>
		<input type="text" name="answer"><br><br>
		<input type="file" name="publickey"><br><br>
		<input type="submit" name="Submit">


	</form>

	<?php

		if($_SERVER['REQUEST_METHOD']=="POST"){

			include('connectdb.php');

			$answer = $_POST['answer'];
			$publicKey = file_get_contents($_FILES['publickey']['tmp_name']);
			//echo "$answer 		$publicKey";
			$hashPublicKey = hash('sha256',$publicKey);

			$ministryPublicKey = file_get_contents('ministryPublicKey.txt');
			
			openssl_public_encrypt($answer, $answerEncrypted, $ministryPublicKey);
			
			openssl_public_encrypt($hashPublicKey, $hashPublicKeyEncrypted, $ministryPublicKey);
			/*echo "$answerEncrypted<br><br>";
			echo "$hashPublicKeyEncrypted";*/

			$answerEncrypted= base64_encode($answerEncrypted);
			$hashPublicKeyEncrypted= base64_encode($hashPublicKeyEncrypted);

			/*openssl_private_decrypt($answerEncrypted, $answerDecrypted, $ministryPrivateKey);
			openssl_private_decrypt($hashPublicKeyEncrypted, $hashPublicKeyDecrypted, $ministryPrivateKey);

			echo "<br><br>$answerDecrypted<br><br>";
			echo "$hashPublicKeyDecrypted";*/
			
			$insertdb = "INSERT INTO gotoministry(encryptedAnswer,encryptedHash) VALUES ('$answerEncrypted','$hashPublicKeyEncrypted') ";
			if($conn->query($insertdb) === TRUE){
				echo "Your query is being processed. ";
			}			
			else{
				echo "Server issues. Please try again in some time.";
			}

		}

?>
	

</body>
</html>