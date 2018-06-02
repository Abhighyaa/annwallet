<?php

$publicKeyFile = '/var/www/html/annwallet/publicKey.txt';
$privateKeyFile=  '/var/www/html/annwallet/privateKey.txt';
unlink($publicKeyFile);
unlink($privateKeyFile);
header('location:index.php');

?>