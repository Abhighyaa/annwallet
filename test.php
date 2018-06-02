<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
</head>
<body>

	<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
		
		<input type="file" name="publickey" /><br><br>
		<input type="file" name="privatekey" /><br><br>

		<button type="submit" name="btn-upload">upload</button>

		<?php

			if($_SERVER['REQUEST_METHOD']=="POST"){

				$var1 = file_get_contents($_FILES['publickey']['tmp_name']);
				echo "$var1";
				$var2 = file_get_contents($_FILES['privatekey']['tmp_name']);
				echo "$var2";

			}

		?>

	</form>


</body>
</html>