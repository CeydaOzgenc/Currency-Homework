<?php
    session_start();
	if(!$_SESSION)
	{
		echo "<script> alert ('ADMINE ÖZELDIR!'); </script>";
		header("refresh:0;url=index.php");
	}
	else{ include 'database.php';
	$type=array();
  header('Content-Type: text/html; charset=utf-8');
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
  		<a href="home.php"><li>Profil</li></a>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <div div class="col-sm-12 add item top">
    <h1>Rapor</h1>
    <form method="post" >
      <div class="input-group mb-4 report">
      	<input type="date" name="date1" class="form-control">
      </div>
      <div class="input-group mb-4 mbort report">
        <input type="date" name="date2" class="form-control">
      </div>
      <input name="button_ara" type="submit" value="Rapor Oluştur">
    </form>
    <?php if(p("button_ara")){
		if(p("date1") and p("date2")){
      $dosyaad="rapor.xls";
      if(file($dosyaad)!=NULL){
        unlink($dosyaad);
      }
      else{
        touch($dosyaad);
      }
      $dosyaad=fopen($dosyaad, "a");
      fprintf($dosyaad, chr(0xEF).chr(0xBB).chr(0xBF));
			for ($i=0; $i < count($type); $i++){
        if($type[$i]=="Alıcı"){
          $rapor1=mysqli_query($db,"select * from useritems where User_UserName='".$_SESSION["oturumacan"]."' and UserItem_Type='Alındı'");
          $rapor2=mysqli_query($db,"select * from useritem where UserItem_Type='Yok'");
          $yaz="Alım Tutarı";
        }
        if($type[$i]=="Satıcı"){
          $rapor2=mysqli_query($db,"select * from useritems where User_UserName='".$_SESSION["oturumacan"]."' and UserItem_Type='Satıldı'");
          $rapor1=mysqli_query($db,"select * from useritem where UserItem_Type='Yok'");
          $yaz="Satılma Tutarı";
        }?>
          <table class="table">
            <thead>
              <tr>
                <?php fwrite($dosyaad, " Tarih \t Ürün Tipi \t $yaz \t Miktar \n");?>
                <th>Tarih</th>
                <th>Ürün Tipi</th>
                <th><?php echo $yaz;?></th>
                <th>Miktar</th>
              </tr>
            </thead>
            <tbody>
            <?php if(p("date1")<p("date2")){
              if($type[$i]=="Alıcı"){
                while($row1=mysqli_fetch_array($rapor1)){
                  $tarih=$row1["UserItem_Time"];
                  $urun=mysqli_fetch_array(mysqli_query($db,"select Item_Name from items where Item_Id=".$row1["Item_Id"]));
                  $para=$row1["UserItem_Unit_Price"];
                  $miktar=$row1["UserItem_Amount"];
                  if($row1["UserItem_Time"]>p("date1") and $row1["UserItem_Time"]<p("date2")) { ?>
                    <tr>
                      <?php fwrite($dosyaad,"$tarih \t $urun[0] \t $para \t  $miktar \n");?>
                      <td><?php echo $tarih; ?></td>
                      <td><?php echo $urun[0]?></td>
                      <td><?php echo $para?></td>
                      <td><?php echo $miktar?></td>
                    </tr>
                  <?php }
                }
              }
              else{
                while($row2=mysqli_fetch_array($rapor2)){
                  $tarih=$row2["UserItem_Time"];
                  $urun=mysqli_fetch_array(mysqli_query($db,"select Item_Name from items where Item_Id=".$row2["Item_Id"]));
                  $para=$row2["UserItem_Unit_Price"];
                  $miktar=$row2["UserItem_Amount"];
                  if($row2["UserItem_Time"]>p("date1") and $row2["UserItem_Time"]<p("date2")){ ?>
                    <tr>
                      <?php fwrite($dosyaad,"$tarih \t $urun[0] \t $para \t  $miktar \n");?>
                      <td><?php echo $tarih; ?></td>
                      <td><?php echo $urun[0]?></td>
                      <td><?php echo $para?></td>
                      <td><?php echo $miktar?></td>
                    </tr>
                  <?php }
                }
              }
            }
            else{
              if(count($type)>1){
                if($i==1){
                  echo"<script>alert('İlk seçilen tarih ikinci seçilen tarihden küçük olmalıdır!')</script>";
                }
              }
              else{
                echo"<script>alert('İlk seçilen tarih ikinci seçilen tarihden küçük olmalıdır!')</script>";
              }
            }?> 
            </tbody>
          </table>
        <?php 
		  }
    }
    else{
      echo "<script>alert('Tarih bilgileri boş geçilemez.')</script>";
    }
	  }?>
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