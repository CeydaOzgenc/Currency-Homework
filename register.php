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
				<label id="username">Bu kullanıcı adı başkası tarafından kullanılıyor..</label>
				<input name="register_password" type="password" placeholder="Şifreniz..">
				<input name="register_tc" type="number" placeholder="TC Kimlik Numaranız..">
				<input name="register_tel" type="" placeholder="Telefon Numaranız..">
				<input name="register_adrress" type="text" placeholder="Adresiniz..">
				<input id="lastinput"name="register_mail" type="email" placeholder="E-Mailiniz..">
				<input name="register_usertype2" type="checkbox" >
				<label>Alıcı</label>
				<input name="register_usertype3" type="checkbox" >
				<label>Satıcı</label>
				<label id="user_type">Kullanıcı tipinizi seçmeniz gerekli..</label>
				<input id="buton2" name="register" type="submit" value="Kayıt Ol">
			</form>
		</div>
	</div>
	<?php session_start();
	include 'database.php';
	if(p("register")){
		$sqlsorgula=mysqli_query($db,"select * from users where User_UserName='".p("register_username")."'");
		if(null==mysqli_fetch_row($sqlsorgula)){ //input'tan girilen kullanıcı bilgileri daha önce kayıt olmuş mu kontrol edilir
			if (null!=p("register_usertype1") or null!=p("register_usertype2") or null!=p("register_usertype3")){ // Kullanıcı tipinin seçilme durumu kontrol edilir.
				$usertype = array("Admin", "Alıcı", "Satıcı");
				$sql = "insert into users (User_UserName,User_Password,User_Name,User_Surname,User_TC_Number,User_Tel_Number,User_Address,User_E_Mail) values('".p("register_username")."','".p("register_password")."','".p("register_name")."','".p("register_surname")."',".intval(p("register_tc")).",".intval(p("register_tel")).",'".p("register_adrress")."','".p("register_mail")."');";
				for ($x=1;$x<4;$x++){
					$type="register_usertype".$x;
					if(null!=p("$type")){ //Kullanıcı tiplerinin şeçilmiş olma durumunu kontrol etmek ve seçilenleri veritabanına eklemek
						$sql .= "insert into usertypes (UserType_Name,User_UserName) values('".$usertype[$x-1]."','".p("register_username")."');";
					}
				}
				if ($db->multi_query($sql) === TRUE) {
 					echo "<script> alert ('Kayıdınız tamamlandı..'); </script> 
 					setTimeout(".header("refresh:0;url=index.php").", 1000);";

				}
				$db->close();
			}
			else{
				echo "<script>
				document.getElementsByTagName('input')[0].value='".p('register_name')."';
				document.getElementsByTagName('input')[1].value='".p('register_surname')."';
				document.getElementsByTagName('input')[2].value='".p('register_username')."';
				document.getElementsByTagName('input')[4].value='".p('register_tc')."';
				document.getElementsByTagName('input')[5].value='".p('register_tel')."';
				document.getElementsByTagName('input')[6].value='".p('register_adrress')."';
				document.getElementsByTagName('input')[7].value='".p('register_mail')."';
      			document.getElementById('user_type').style.display='block';
      			</script>";
			}
		}
		else{
			echo "<script>
				document.getElementsByTagName('input')[0].value='".p('register_name')."';
				document.getElementsByTagName('input')[1].value='".p('register_surname')."';
				document.getElementsByTagName('input')[2].value='".p('register_username')."';
				document.getElementsByTagName('input')[4].value='".p('register_tc')."';
				document.getElementsByTagName('input')[5].value='".p('register_tel')."';
				document.getElementsByTagName('input')[6].value='".p('register_adrress')."';
				document.getElementsByTagName('input')[7].value='".p('register_mail')."';
      			document.getElementById('username').style.display='block';
      			</script>";
		}
	}
	?>
</body>
</html>
<script src="js/jquery.min.js"></script>
