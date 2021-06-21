<?php
    session_start();
	if(!$_SESSION)
	{
		echo "<script> alert ('ADMINE ÖZELDIR!'); </script>";
		header("refresh:0;url=index.php");
	}
	else{ include 'database.php';
	$type=array();
	$sqlsorgula=mysqli_query($db,"select * from usertypes where User_UserName='".$_SESSION["oturumacan"]."'");
	while($row = mysqli_fetch_array($sqlsorgula)){$type[] = $row['UserType_Name'];}
	?>
<!DOCTYPE html>
<html>
<head>
<title>PROFİL</title>
<link rel="stylesheet"  href="css/reset.css">
<link rel="stylesheet"  href="bootstrap/css/bootstrap.css">
<link rel="stylesheet"  href="css/style.css">
</head>
<body>
<div id="nav">
  <div class="container">
  	<div id="user">
  		<label><?php echo $_SESSION["oturumacan"];?></label>
  	</div>
    <div id="navbar">
      <ul>
       	<a href="#"><li id="mobile">MENU</li></a>
       	<?php //kullanıcı tipine göre menü görseli ayarlanır.
        for($x=0;$x<count($type);$x++){ 
       		if($type[$x]=='Admin'){?>
       			<li id="down">Admin Onay
       				<ul class="dropdown">
       					<a href="item-approval.php"><li>Ürün Onay</li></a>
       					<a href="money-approval.php"><li>Para Onay</li></a>
       				</ul>
       			</li>
       		<?php } elseif($type[$x]=='Alıcı'){?>
       			<a href="add-money.php"><li>Para Ekle</li></a>
            <a href="get-item.php"><li>Ürün Alma</li></a>
            <a href="report.php"><li>Rapor</li></a>
       		<?php } elseif($type[$x]=='Satıcı'){?>
       			<a href="add-item.php"><li>Ürün Ekle</li></a>
            <?php if(count($type)<2){?> <a href="report.php"><li>Rapor</li></a> <?php } 
          } ?>
  		<?php } ?>
  		<a href="home.php" class="active"><li>Profil</li></a>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <div div class="col-sm-12 add item top">
    <h1>Profil</h1>
    <form method="post" >
      <?php $sqlsorgula=mysqli_query($db,"select * from users where User_UserName='".$_SESSION["oturumacan"]."'");
      while($row = mysqli_fetch_array($sqlsorgula)){;?>
      <div class="input-group mb-4 home">
        <div class="input-group-prepend">
          <span class="input-group-text title">Kullanıcı Adınız</span>
        </div>
      <input value="<?php echo $row['User_UserName']; ?>" type="text" name="user_username" class="form-control">
      </div>
      <div class="input-group mb-4 mbort home">
        <div class="input-group-prepend">
          <span class="input-group-text title" >Şifre</span>
        </div>
        <input value="<?php echo $row['User_Password']; ?>" type="text" name="user_sifre" class="form-control">
      </div>
      <div class="input-group mb-4  home">
        <div class="input-group-prepend">
          <span class="input-group-text title" >Adınz</span>
        </div>
        <input value="<?php echo $row['User_Name']; ?>" type="text" name="user_name" class="form-control">
      </div>
      <div class="input-group mb-4 mbort home">
        <div class="input-group-prepend">
          <span class="input-group-text title">Soyadınız</span>
        </div>
      <input value="<?php echo $row['User_Surname']; ?>" type="text" name="user_surname" class="form-control">
      </div>
      <div class="input-group mb-4 home">
        <div class="input-group-prepend">
          <span class="input-group-text title" >TC Kimlik Numaranız</span>
        </div>
        <input value="<?php echo $row['User_TC_Number']; ?>" type="text" name="user_tc" class="form-control">
      </div>
      <div class="input-group mb-4 mbort home">
        <div class="input-group-prepend">
          <span class="input-group-text title">Telefon Numaranız</span>
        </div>
      <input value="<?php echo $row['User_Tel_Number']; ?>" type="text" name="user_tel" class="form-control">
      </div>
      <div class="input-group mb-4 home">
        <div class="input-group-prepend">
          <span class="input-group-text title" >Adresiniz</span>
        </div>
        <input value="<?php echo $row['User_Address']; ?>" type="text" name="user_adrress" class="form-control">
      </div>
      <div class="input-group mb-4 mbort home">
        <div class="input-group-prepend">
          <span class="input-group-text title">Mailiniz</span>
        </div>
      <input value="<?php echo $row['User_E_Mail']; ?>" type="text" name="user_mail" class="form-control">
      </div>
    <?php } ?>
    </form>
  </div>
</div>
<div id="footer">
  <div class="container">
     <div id="footertext">
       <p>© Copyright 2021 Ceyda Özgenç Tüm Hakları Saklıdır. </p>
     </div>
  </div>
</div>
</body>
</html>
<?php } ?>