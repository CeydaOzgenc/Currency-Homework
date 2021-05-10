<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>GİRİŞ</title>
<link rel="stylesheet"  href="css/reset.css">
<link rel="stylesheet"  href="bootstrap/css/bootstrap.css">
<link rel="stylesheet"  href="css/style.css">
<?php session_start();
	include 'database.php';
	if(p("login")){
		$sql=mysqli_query($db,"select * from users where User_UserName='".p("login_username")."' and User_Password='".p("login_password")."'");
		if(mysqli_num_rows($sql)==0){
			echo "<script> alert ('Hatalı Giriş!'); </script>";
		}
		else{
			$_SESSION["oturumacan"]=$User_UserName;
			header("Location:anasayfa.php");
		}
	}
	if(p("register")){
		header("Location:register.php");
	}
	?>
</head>
<body>
	<div class="container" id="firs">
		<div class="col-sm-6 index" >
			<form method="post">
				<input id="firstinput"name="login_username" type="text" placeholder="Kullanıcı Adınız..">
				<input id="lastinput"name="login_password" type="password" placeholder="Şifreniz..">
				<input id="buton1" name="login" type="submit" value="Giriş">
				<input id="buton2" name="register" type="submit" value="Kayıt Ol">
			</form>
		</div>
	</div>
</body>
</html>
<script>
	document.getElementById("firs").style.height = window.innerHeight + "px";
</script>
<script src="js/jquery.min.js"></script>
