<?php
require('../library.php');
$db =dbconnect();

session_start();
$userid=$_SESSION['id'];
// $item_id=$_GET['id'];
$total=$_SESSION['total'];

if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];
}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
$cart=$_SESSION['cart'];
}
// echo $userid;

if(isset($_POST['itemid'])==true){
  $itemid=$_POST['itemid'];
  // echo $itemid;
  }

if(isset($_SESSION['id'])==true){
  $sqls='delete from cart where user_id='.$userid.'';
  $stmts= $db ->query($sqls);
}

if(isset($_POST['change_button'])==true){
  $sql2 = 'update cart set number='.$kazuerabi.' where id in('.$itemid.')';
  $stmt2 =$db ->query($sql2);

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body  class="skaku txt_w">
  <div>
    <div class="kakutei_title">
      <h1><span>ご購入ありがとう</span><span>ございました</span></h1>
    </div>
    <div class="kingaku">
      <p>お支払合計金額は</p>
      <p><span class="money"><?php echo $total; ?></span>円です</p>
    </div>
  <div class="jouhou">

    <p>お客様登録情報</p>
    <?php
      $sql1 ='select * from users where id='.$userid.'';
      $stmt1= $db->query($sql1);
      $rec1 =$stmt1->fetch_assoc();?>

      <p>名前<br>
      <?php echo $rec1['name'] ; ?>さん
      </p>
      <p>住所<br>
      <?php echo $rec1['address'] ; ?>
      </p>
      <p>電話番号<br>
      <?php echo $rec1['tell'] ; ?>
      </p>
      <p>メールアドレス<br>
      <?php echo $rec1['email'] ; ?>
      </p>
    </div>

    <div class="tyukoku" style="color:red">
      <p>3日以内に支払いをお願いします</p>
      <p>お問い合わせはサポートダイヤルへ(XXX-XXXX-XXXX）</p>
    </div>

    <div  class="top_button">
      <a href="top.php" class="modoru">トップに戻る</a>
    </div>
  </div>




</body>
</html>