<!DOCTYPE html>
<html>
<head>
	<title>Key generation</title>
</head>
<body>

	<?php

  		$toGenKeyPair = array(
    		"digest_alg" => "sha512",
    		"private_key_bits" => 4096,
    		"private_key_type" => OPENSSL_KEYTYPE_RSA,
		);

		$keyPair = openssl_pkey_new($toGenKeyPair);

		openssl_pkey_export($keyPair, $privateKey);
		$publicKey = openssl_pkey_get_details($keyPair);
		$publicKey = $publicKey["key"];


    	$publicKeyFile = '/var/www/html/annwallet/publicKey.txt';
    	$privateKeyFile=  '/var/www/html/annwallet/privateKey.txt';
    	$openPublicKeyFile = fopen($publicKeyFile, 'w') or die('Cannot open file:  '.$publicKeyFile );
    	$openPrivateKeyFile = fopen($privateKeyFile, 'w') or die('Cannot open file:  '.$privateKeyFile);	


    	fwrite($openPublicKeyFile, $publicKey);
    	fwrite($openPrivateKeyFile, $privateKey);  
    	include('connectdb.php');
    	$hashPublicKey = hash("sha256", $publicKey);
    	$insertdb = "INSERT INTO balance(hash) VALUES ('$hashPublicKey') ";
  		

?>
	<?php if($conn->query($insertdb) === TRUE):?>
		Your <a href="download_pub.php">public key</a><br><br><br>
		Your <br><a href="download_priv.php"> private key</a><br><br><br>
		<a href="logout.php">Logout</a>

	<?php else: ?>
		Couldn't generate the keys, please <a href="index.php">try again.</a>
	<?php endif;?>

</body>
</html>