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
	while($row = mysqli_fetch_array($sqlsorgula)){$type[] = $row['UserType_Name'];} //Kullanıcı tipini veya tiplerini type dizisine aktarmak.
	?>
<!DOCTYPE html>
<html>
<head>
<title>ÜRÜN EKLE</title>
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
            <a href="add-money.php"><li>Para Ekle</li></a>
            <a href="get-item.php"><li>Ürün Alma</li></a>
          <?php } elseif($type[$x]=='Satıcı'){?>
            <a href="add-item.php"  class="active"><li>Ürün Ekle</li></a>
          <?php } ?>
      <?php } ?>
      <a href="home.php"><li>Profil</li></a>
      </ul>
    </div>
  </div>
</div>
<div class="container">
	<div class="col-sm-12 add additem">
		<h1>Senin Ürünlerin</h1>
    <?php $sqlürün=mysqli_query($db,"select * from useritems where User_UserName='".$_SESSION["oturumacan"]."'");
    if(mysqli_num_rows ($sqlürün)!=0){//Kişinin yüklediği ürünler sorgulanır ve varsa yazılır?>
    <table class="table table-hover">
    <thead>
      <tr >
        <th>Ürün Adı</th>
        <th>Ürün Miktarı</th>
        <th>Ürün Birim Fiyatı</th>
        <th>Ürün Durumu</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row=mysqli_fetch_array($sqlürün)) {
        $sqlitem_name=mysqli_fetch_array(mysqli_query($db,"select Item_Name from items where Item_Id='".$row["Item_Id"]."'"));
        $sqlitem_position=mysqli_fetch_array(mysqli_query($db,"select Position_Name from position where Position_Id='".$row["Position_Id"]."'"));
        ?>
      <tr class="
      <?php switch ($row["Position_Id"]) {//Ürünün durumuna göre satıra renk vermek
              case 1:
                echo "success";
                break;
              case 2:
                echo "danger";
                break;
              case 3:
                echo "active";
                break;}?>">
        <td><?php echo $sqlitem_name[0]; ?></td>
        <td><?php echo $row["UserItem_Amount"]; ?></td>
        <td><?php echo $row["UserItem_Unit_Price"]; ?></td>
        <td><?php echo $sqlitem_position[0]; ?></td>
      </tr>
    <?php }?>
    </tbody>
    </table>
    <?php } else{?>
      <label>Hiç ürününüz bulunmamakta.</label>
    <?php }?>
	</div>
  <div div class="col-sm-12 add item">
    <h1>Ürün Ekle</h1>
    <form method="post" >
      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text title">Ürün Adı</span>
        </div>
        <select name="item_name" class="custom-select form-control">
          <option selected>Lütfen Ürün Seçiniz</option>
          <option value="AMETİST">Ametist</option>
          <option value="SAFİR">Safir</option>
          <option value="PEMBE KUVARS">Pembe Kuvars</option>
          <option value="AKİK">Akik</option>
          <option value="AKUAMARİN">Akuamrin</option>
          <option value="AMETRİN">Ametrin</option>
          <option value="DUMANLI KUVARS">Dumanlı Kuvars</option>
          <option value="KEHRİBAR">Kehriban</option>
          <option value="SEDEF">Sedef</option>
          <option value="YAKUT">Yakut</option>
      </select>
      </div>
      <div class="input-group mb-4 mbort">
        <div class="input-group-prepend">
          <span class="input-group-text title">Ürün Miktarı</span>
        </div>
        <input type="text" name="item_amount" class="form-control">
      </div>
      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text title">Ürün Birim Fiyatı</span>
        </div>
        <input type="text" name="item_unitprice" class="form-control">
      </div>
      <input name="button_item" type="submit" value="Ürünü Ekle">
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
  if(p("button_item")){ //ürünü onay bekleme durumu ile eklemek.
    $item_id=mysqli_fetch_array(mysqli_query($db,"select Item_Id from items where Item_Name='".p("item_name")."'"));
    $sqlekle=mysqli_query($db,"insert into useritems (User_UserName,Item_Id,UserItem_Amount,UserItem_Unit_Price,Position_Id) values('".$_SESSION["oturumacan"]."',$item_id[0],".intval(p("item_amount")).",".intval(p("item_unitprice")).",3);");
    if ($sqlekle) {
          echo "<script> alert ('Ürününüz Eklendi..'); </script> 
          setTimeout(".header("refresh:0;url=add-item.php").", 1000);";

        }
  }
  ?>
</body>
</html>
<?php } ?>