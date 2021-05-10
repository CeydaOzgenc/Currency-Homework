<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>KAYİT OL</title>
<link rel="stylesheet"  href="css/reset.css">
<link rel="stylesheet"  href="bootstrap/css/bootstrap.css">
<link rel="stylesheet"  href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="col-sm-6 register" >
			<form method="post" >
				<input id="firstinput"name="register_name" type="text" placeholder="Adınız..">
				<input name="register_surname" type="text" placeholder="Soyadınız..">
				<input name="register_username" type="text" placeholder="Kullanıcı Adınız..">
				<input name="register_password" type="password" placeholder="Şifreniz..">
				<input name="register_tc" type="number" placeholder="TC Kimlik Numaranız..">
				<input name="register_tel" type="number" placeholder="Telefon Numaranız..">
				<input name="register_adrress" type="text" placeholder="Adresiniz..">
				<input id="lastinput"name="register_mail" type="email" placeholder="E-Mailiniz..">
				<input name="register_usertype1" type="checkbox" >
				<label>Admin</label>
				<input name="register_usertype1" type="checkbox" >
				<label>Alıcı</label>
				<input name="register_usertype1" type="checkbox" >
				<label>Satıcı</label>
				<input id="buton2" name="register" type="submit" value="Kayıt Ol">
			</form>
		</div>
	</div>
	<?php session_start();
	include 'database.php';
	if(p("register")){
		$sql=mysqli_query($db,"insert into users (User_UserName,User_Password,User_Name,User_Surname,User_TC_Number,User_Tel_Number,User_Address,User_E-Mail) values('".p("register_username")."','".p("register_password")."','".p("register_name")."','".p("register_surname")."','".p("register_tc")."','".p("register_tel")."','".p("register_adrress")."','".p("register_mail")."')");
		if(null!==$sql){
			echo "deneme";
		}
	}
	?>
</body>
</html>
<script src="js/jquery.min.js"></script>
