<?php
require('../library.php');
$db =dbconnect();
session_start();
$item_id=$_GET['id'];

if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];

}else{
  $kazuerabi='';
}

if(isset($_SESSION['cart'])==true){
$cart=$_SESSION['cart'];
}

$cart[]=$item_id;
$_SESSION['cart']=$cart;


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
          <p>商品画像がありません</p>
          <?php endif ;?>
        </div>
     <div>
      <p><?php echo h($name); ?><span class="name"></p>
      <p><?php echo h($price); ?>円</span></p>

      <?php if($stock >0): ?>
         <form action="" method="POST">
          <select name="kazuerabi">
           <?php for($i=1; $i<=$stock;$i++):?>
           <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
           <?php endfor ;?>
          </select>
         <input type="submit" value="カートに入れる">
       </form>
    <? else:?>
      <p style="color:red;">在庫がありません</p>
      <?php endif; ?>
      <p style="color:pink"><?php if($kazuerabi !== ''){ echo $kazuerabi ."個カートに入れました";} ?></p>
      <a href="cart.php?id=<?php echo $id;?>">カートに行く</a>
      <?php //var_dump($cart); exit(); ?>
    </div>

  </div>
  <p ><?php echo h($setumei) ; ?></p>
<?php else : ?>
<p>その商品ページは削除されたか、URLが間違えています</p>
<?php endif ; ?>
</div>

<div>

</div>
</body>
</html>
