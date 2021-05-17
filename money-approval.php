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
<title>PARA ONAYLAMA</title>
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
                <a href="money-approval.php" class="active"><li>Para Onay</li></a>
              </ul>
            </li>
          <?php } elseif($type[$x]=='Alıcı'){?>
            <a href="add-money.php"><li>Para Ekle</li></a>
            <a href="get-item.php"><li>Ürün Alma</li></a>
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
  <div class="col-sm-12 add top">
    <h1>Onaylanacak Ürünler</h1>
    <?php $sqlürün=mysqli_query($db,"select * from moneys where Position_Id=3");
    if(mysqli_num_rows ($sqlürün)!=0){?>
    <table class="table table-hover">
    <thead>
      <tr >
        <th>Paranın Sahibi</th>
        <th>Para Miktarı</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row=mysqli_fetch_array($sqlürün)) { ?>
      <form method="post" >
        <tr class="active">
          <td><?php echo $row["User_UserName"]; ?></td>
          <td><?php echo $row["Money_Amount"]; ?></td>
          <input type="text" name="yaz" value="<?php echo $row['Money_Id'];?>" style="display:none;">
          <td><input type="submit" name="onay" value="Onay"><input type="submit" name="ret" value="Ret"></td>
        </tr>
      </form>
    <?php }?>
    </tbody>
    </table>
    <?php } else{?>
      <label>Onaylanacak para bulunmamakta.</label>
    <?php }?>
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
  if(p("onay")){
    $id=p("yaz");
    mysqli_query($db,"update moneys set Position_Id=1 where Money_Id=$id");
    header("refresh:0;url=money-approval.php");
  }
  if(p("ret")){
    $id=p("yaz");
    mysqli_query($db,"update moneys set Position_Id=2 where Money_Id=$id");
    header("refresh:0;url=money-approval.php");
  }
  ?>
</body>
</html>
<?php } ?>