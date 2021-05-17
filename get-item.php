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
<title>ÜRÜN ALMA</title>
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
            <a href="get-item.php" class="active"><li>Ürün Alma</li></a>
          <?php } elseif($type[$x]=='Satıcı'){?>
            <a href="add-item.php"><li>Ürün Ekle</li></a>
          <?php } ?>
      <?php } ?>
      <a href="home.php"><li>Profil</li></a>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <div div class="col-sm-12 add item top">
    <h1>Ürün Alımı</h1>
    <form method="post" >
      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text title">Ürün Adı</span>
        </div>
        <select id="item_name" name="item_name" class="custom-select form-control">
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
          <span class="input-group-text title" >Ürün Miktarı</span>
        </div>
        <input id="item_amount" type="text" name="item_amount" class="form-control">
      </div>
      <input name="button_item" type="submit" value="Ürünü Sorgula">
      <div class="query_money">
        <h1 id="moneytitle">Ödemeniz Gereken Tutar :</h1>
        <label id="moneytext"></label>
        <input id="moneybutton" name="button_money" type="submit" value="Ürünü Al">
      </div>
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
  function money($name,$amount,$position){
    $db= new mysqli("localhost","root","","bourse_project");
    $item_id=mysqli_fetch_array(mysqli_query($db,"select Item_Id from items where Item_Name='$name'"));
    $sqlürün=mysqli_query($db,"select * from useritems where Item_Id=$item_id[0] and  Position_Id=1 ORDER BY UserItem_Unit_Price ");
    if(mysqli_num_rows ($sqlürün)!=0){
      $item=intval(p("item_amount"));
      $money=0;
      while ($row=mysqli_fetch_array($sqlürün)){
        if($item>0){
          if($item<$row["UserItem_Amount"]){
            $money+=($item*$row["UserItem_Unit_Price"]);
            if($position==2){
              $new_amount=$row["UserItem_Amount"]-$item;
              mysqli_query($db,"update useritems set UserItem_Amount=$new_amount where UserItem_Id=".$row["UserItem_Id"]);
            }
          }
          else{
            $item-=$row["UserItem_Amount"];
            $money+=($row["UserItem_Amount"]*$row["UserItem_Unit_Price"]);
            if($position==2){
              mysqli_query($db,"delete from useritems where UserItem_Id=".$row["UserItem_Id"]);
            }
          }
        }
      }
      if($position==1 or $position==2){
        $parasorgula=mysqli_query($db,"select * from moneys where User_UserName='".$_SESSION["oturumacan"]."' and Position_Id=1");
        $usermoney=0;
        if(mysqli_num_rows ($parasorgula)!=0){
          while ($user=mysqli_fetch_array($parasorgula)) {
            $usermoney+=$user["Money_Amount"];
            if($money>0 and $position==2){
              if($money<$user["Money_Amount"]){
                $newmoney=$user["Money_Amount"]-$money;
                mysqli_query($db,"update moneys set Money_Amount=$newmoney where Money_Id=".$user["Money_Id"]);
              }
              else{
                $money-=$user["Money_Amount"];
                mysqli_query($db,"delete from moneys where Money_Id=".$user["Money_Id"]);
              }
            }
          }
          if($position==2){
            echo"<script> alert ('Ürünün alışı gerçekleşmiştir..'); </script>
            setTimeout(".header("refresh:0;url=get-item.php").", 1000);";
          }
        }
        if($usermoney>=$money and $position==1){
          money($name,$amount,2);
        }
        else if($usermoney<$money and $position==1){
          echo"<script> alert ('Paranız yeterli değil!!'); </script>
          setTimeout(".header("refresh:0;url=get-item.php").", 1000);";
        }
      }
      echo "<script>
      document.getElementById('item_name').value='".$name."';
      document.getElementById('item_amount').value='".$amount."';
      document.getElementById('moneytext').innerHTML = ".$money." + ' TL';
      document.getElementsByClassName('query_money')[0].style.display= 'block';
      </script>";
    }
    else{
      echo "<script>
      document.getElementById('moneytext').innerHTML = 'Ürün stokta bulunmamaktadır..';
      document.getElementsByClassName('query_money')[0].style.display= 'block';
      document.getElementById('moneytitle').style.display= 'none';
      document.getElementById('moneybutton').style.display= 'none';
      </script>";
    }
  }
  
  if(p("button_item")){
    money(p("item_name"),p("item_amount"),0);
  }
  if(p("button_money")){
    money(p("item_name"),p("item_amount"),1);
  }
  ?>
</body>
</html>
<?php } ?>