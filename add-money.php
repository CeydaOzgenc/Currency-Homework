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
<title>PARA EKLE</title>
<link rel="stylesheet"  href="css/reset.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
            <a href="add-money.php"  class="active"><li>Para Ekle</li></a>
            <a href="get-item.php"><li>Ürün Alma</li></a>
            <a href="report.php"><li>Rapor</li></a>
          <?php } elseif($type[$x]=='Satıcı'){?>
            <a href="add-item.php"><li>Ürün Ekle</li></a>
            <?php if(count($type)<2){?> <a href="report.php"><li>Rapor</li></a> <?php } 
          } ?>
      <?php } ?>
      <a href="home.php"><li>Profil</li></a>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <div class="col-sm-12 add money">
    <?php $sqlonaypara=mysqli_fetch_array(mysqli_query($db,"select SUM(Money_TranslateTL) from moneys where User_UserName='".$_SESSION["oturumacan"]."' and Position_Id=1")); 
          if(null==$sqlonaypara[0]){$sqlonaypara[0]=0;}//adminden onaylanan paraların hesapını sqlonaypara'ya aktarmak ve boşsa 0 yapmak.
          $Tlpara=mysqli_fetch_array(mysqli_query($db,"select SUM(Money_Amount) from moneys where User_UserName='".$_SESSION["oturumacan"]."' and Money_Type='TL' and Position_Id=3")); 
          $Europara=mysqli_fetch_array(mysqli_query($db,"select SUM(Money_Amount) from moneys where User_UserName='".$_SESSION["oturumacan"]."' and Money_Type='EURO' and Position_Id=3")); 
          $Dolarpara=mysqli_fetch_array(mysqli_query($db,"select SUM(Money_Amount) from moneys where User_UserName='".$_SESSION["oturumacan"]."' and Money_Type='KANADA DOLARI' and Position_Id=3")); 
          $Yenpara=mysqli_fetch_array(mysqli_query($db,"select SUM(Money_Amount) from moneys where User_UserName='".$_SESSION["oturumacan"]."' and Money_Type='JAPON YENİ' and Position_Id=3")); 
          if(!$Tlpara[0]){$Tlpara[0]=0;}
          if(!$Europara[0]){$Europara[0]=0;}
          if(!$Dolarpara[0]){$Dolarpara[0]=0;}
          if(!$Yenpara[0]){$Yenpara[0]=0;}//adminden onay bekleyen paraların hesapını sqlpara'ya aktarmak ve boşsa 0 yapmak.?> 
    <label><h1>Onaylanan Bakiyeniz :</h1><?php echo $sqlonaypara[0]." TL";?></label>
    <label><h1>Onaylanmayı Bekleyen Bakiyeniz :</h1>
      <?php echo $Tlpara[0]." TL , ".$Yenpara[0]." JAPON YENİ , ".$Europara[0]." EURO , " .$Dolarpara[0]." KANADA DOLARI";?></label>
  </div>
  <div div class="col-sm-12 add item">
    <h1>Para Ekle</h1>
    <form method="post" >
      <div class="input-group mb-4 mbmoneyozel">
        <div class="input-group-prepend">
          <span class="input-group-text title">Para Cinsi</span>
        </div>
        <select id="money_type" name="money_type" class="custom-select form-control">
          <option selected>Lütfen Ürün Seçiniz</option>
          <option value="JAPON YENİ">JAPON YENİ</option>
          <option value="EURO">EURO</option>
          <option value="KANADA DOLARI">KANADA DOLARI</option>
          <option value="TL">TL</option>
        </select>
      </div>
      <div class="input-group mb-4 mbmoney mbort">
        <div class="input-group-prepend">
          <span class="input-group-text title">Eknenecek Bakiye Miktarı</span>
        </div>
        <input type="text" name="money_amount" class="form-control">
      </div>
      <input name="button_money" type="submit" value="Bakiyeyi Ekle">
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
<?php 
  if(p("button_money") and p("money_type")){//parayı onay bekleme durumu ile eklemek.
    if(p("money_type")!="TL"){
      $sqlekle=mysqli_query($db,"insert into moneys (User_UserName,Money_Amount,Money_Type,Money_TranslateTL,Position_Id) values('".$_SESSION["oturumacan"]."',".intval(p("money_amount")).",'".p("money_type")."',0,3);");
    }
    else{
      $sqlekle=mysqli_query($db,"insert into moneys (User_UserName,Money_Amount,Money_Type,Money_TranslateTL,Position_Id) values('".$_SESSION["oturumacan"]."',".intval(p("money_amount")).",'".p("money_type")."',".intval(p("money_amount")).",3);");
    }
    if ($sqlekle) {
          echo "<script> alert ('Bakiyeniz Eklendi..'); </script> 
          setTimeout(".header("refresh:0;url=add-money.php").", 1000);";
        }
  }
  ?>
</body>
</html>
<?php } ?>