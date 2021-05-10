<?php
    session_start();
	if(!$_SESSION)
	{
		echo "<script> alert ('ADMINE ÖZELDIR!'); </script>";
		header("refresh:0;url=index.php");
	}
	else{ ?>
<!DOCTYPE html>
<html>
<head>
<title>ADMIN</title>
<link rel="stylesheet"  href="css/reset.css">
<link rel="stylesheet"  href="css/style.css">
</head>
<body>
<div id="container">
 MERHABA
</div>
</body>
</html>
<?php } ?>