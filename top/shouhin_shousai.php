<?php
require('../library.php');
$db =dbconnect();
session_start();
$item_id=$_GET['id'];

$login=1;

if(isset($_SESSION["id"])){
  //セッション情報がある場合は普通に画面遷移
  $userid=$_SESSION['id'];
}else{

    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
 header('Location:../login/login.php?login='.$login.'');
   exit();

}

$userid=$_SESSION['id'];

//カートに入れる数を決める
if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];

}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
  $cart=$_SESSION['cart'];
}

// $cart[]=$item_id;
// $_SESSION['cart']=$cart;

// カートに入れるボタンが押されたとき,cartデータベースに追加
if(isset($_POST['cartin_button'])==true){
  $sql2 = 'insert into cart(user_id,item_id,number) values('.$userid.','.$item_id.','.$kazuerabi.')';
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a>

<?php
$sql = 'select * from items where id=?';
$stmt =$db ->prepare($sql);
$stmt->bind_Param("s",$item_id);
$stmt->execute();

$stmt->bind_result($id,$name,$price,$jenre,$stock,$item_link,$setumei,$syousai,$picture,$created);
if($stmt->fetch()): ?>

<div class="s_main">
  <div class="shouhin_img">
    <?php if($picture): ?>
        <img src="./img/<?php echo h($picture); ?>" >
        <?php else: ?>
          <img src="./img/noimage.png" >
          <?php endif ;?>
        </div>
     <div>
      <p><?php echo h($name); ?><span class="name"></p>
      <p><?php echo h($price); ?>円</span></p>

      <?php if($stock >0): ?>
         <form action="" method="POST">
          <select name="kazuerabi" >
           <?php for($i=1; $i<=$stock;$i++):?>
           <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
           <?php endfor ;?>
          </select>
         <button type="submit"name="cartin_button" class="btn btn-success">カートに入れる</button>



          <!-- $stmt->bind_result($id,$name,$price,$jenre,$stock,$item_link,$setumei,$syousai,$picture,$created); -->

        </form>
     <? else:?>
       <p style="color:red;">在庫がありません</p>
       <?php endif; ?>
          <p style="color:pink">
          <?php if($kazuerabi !==null){
        echo $kazuerabi ."個カートに入れました";
       }
       ?>
        </p>
        <a href="cart.php">カートに行く</a>
        <?php //var_dump($cart); exit(); ?>
      </div>

    </div>
    <p ><?php echo h($setumei) ; ?></p>
    <?php else : ?>
      <p>その商品ページは削除されたか、URLが間違えています</p>
      <?php endif; ?>

</div>

<div>

</div>
</body>
</html>
