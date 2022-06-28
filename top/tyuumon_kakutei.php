<?php
require('../lib/DBController.php');
require('../library.php');
// $db =dbconnect();
$db = new DBController;

session_start();
if(!isset($_SESSION['kounyuu'])){
  header('Location: top.php');
  exit();
  }
$_SESSION['kounyuu']=1;

$userid=$_SESSION['id'];
// $item_id=$_GET['id'];
$total=$_SESSION['total'];
$num = $_SESSION["num"];


if(isset($_SESSION["id"])){
  //セッション情報がある場合は普通に画面遷移
  $userid=$_SESSION['id'];
  if(isset($_SESSION['name'])){
  $name = $_SESSION['name'];
  }
}else{

    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
 header('Location:../login/login.php?login='.$login.'');
   exit();

}
if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];
}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
$cart=$_SESSION['cart'];
}
//  echo $userid;

if(isset($_POST['itemid'])==true){
  $itemid=$_POST['itemid'];
  //  echo $itemid;
  }

if(isset($_SESSION['id'])==true){

  $sql ='select * from cart where user_id='.$userid.'';
  $rec=$db->executeQuery($sql, $types = null);
  foreach($rec as $value) {
  // print_r($rec);
  $item_id=$value['item_id'];
  $sqli='select * from items where id='.$item_id.'';
   $rec2=$db->executeQuery($sqli,$types=null);
    print_r($rec2);
    // print_r($rec2['stock']);
    // print_r($rec2['price']);
    $item_name=$rec2[0]['name'];
    $item_price=$rec2[0]['price'];
    $sqlt='insert into history(user_id,name,price,num,item_id) values('.$userid.',"'.$item_name.'",'.$item_price.','.$num.','.$item_id.')';
    if(isset($value['number'])&& isset($rec2[0]['stock'])){
    $newstock=($rec2[0]['stock'])-($value['number']);
    // echo $newstock;
    $sqlu='update items set stock='.$newstock.' where id='.$item_id.'';
    $db->insert_query($sqlu,$types=null);
  }

  $db->insert_query($sqlt,$types=null);
}//cartデータベースから購入商品を削除
  $sqls='delete from cart where user_id='.$userid.'';
  $db->insert_query($sqls,$types=null);;
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-注文確定</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body  class="skaku txt_w">
  <div>
    <div class="kakutei_title">
      <h1 style="margin-top:20px"><span>ご購入ありがとう</span><span>ございました</span></h1>
    </div>
    <div class="kingaku">
      <p>お支払合計金額は</p>
      <p><span class="money"><?php echo $total; ?></span>円です</p>
    </div>
  <div class="jouhou">

    <p>お客様登録情報</p>
    <?php
      $sql1 ='select * from users where id='.$userid.'';
      $rec1 =$db->executeQuery($sql1,$types=null);
      ?>

      <p>名前<br>
      <?php echo $rec1[0]['name'] ; ?>さん
      </p>
      <p>住所<br>
      <?php echo $rec1[0]['address'] ; ?>
      </p>
      <p>電話番号<br>
      <?php echo $rec1[0]['tell'] ; ?>
      </p>
      <p>メールアドレス<br>
      <?php echo $rec1[0]['email'] ; ?>
      </p>
    </div>

    <div class="tyukoku" style="color:red">
      <p>3日以内に支払いをお願いします</p>
      <p>お問い合わせはサポートダイヤルへ(XXX-XXXX-XXXX）</p>
    </div>

    <div  class="top_button" >
      <a href="top.php" class="modoru">トップに戻る</a>
    </div>
  </div>




</body>
</html>
