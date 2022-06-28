<?php
require('../lib/DBController.php');
require('../library.php');
// $db =dbconnect();
$db = new DBController;

session_start();



$login=1;

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

// 数量受け取り
if(isset($_POST['kazuerabi'])){

  $kazuerabi=$_POST['kazuerabi'];
  $_SESSION["num"] = $kazuerabi;
  // var_dump($_SESSION["num"]);
  // exit();
}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
$cart=$_SESSION['cart'];
}
// echo $userid;
// 商品IDの受け取り
if(isset($_POST['itemid'])==true){
  $itemid=$_POST['itemid'];
  // echo $itemid;
  }

  // 削除ボタンを押された時カートDBから削除
if(isset($_POST['sakujo_button'])==true){
  $sqls='delete from cart where id=?';
  $db->insert_query($sqls,"s",$itemid);
}

// 数量変更ボタンを押されたときDBのnumberを更新
if(isset($_POST['change_button'])==true){
  $sqlu = 'update cart set number='.$kazuerabi.' where id in ('.$itemid.')';
  $db->insert_query($sqlu, $types = null);


}

$total=0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-カート</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <header>
  <?php header_inc();?>
</header>
<main>
<div class="container">
  <!-- <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a> -->
<p>カート</p>

  <?php
$sql='select * from cart  inner join items on cart.item_id=items.id where user_id='.$userid.'';
$sql2= 'select count(*) from cart where user_id='.$userid.'';
$sql3='select id from cart where user_id='.$userid.'';
$rec=$db->executeQuery($sql, $types = null);
$rec2=$db->executeQuery($sql2, $types = null);


?>

<?php $x=0 ;?>
<?php foreach($rec as $value):?>
  <?php $rec3=$db->executeQuery($sql3, $types = null);?>
  <?php //print_r($result3);?>
  <?php if($rec==false):
      break; ?>
      <?php endif ?>
      <!-- カートの商品を表示 -->
      <div class="img_s">
      <table>
    <tr>
      <th class="pic_size">

        <a href="shouhin_shousai.php?id=<?php echo $value['item_id'];?>">
                   <?php if($value['picture']==null): ?>
                      <img src="./img/noimage.png">
                    <?php else: ?>
                      <img src="./img/<?php echo $value['picture'];?>" >

                      <div>
                        <?php endif ?>
                      </a>
                      </th>
               <th class="th_name">
                 <p> <?php echo $value['name']; ?> </p>
               </th>
               <th class="th_price">
                 <p> <?php echo $value['price']; ?>円 </p>
               </th>
               <th class="cart_number">
                 <p><?php echo $value['number'];  ?>個</p>
               </th>
               <th class="cart_price">
                 <p>計<?php echo $value['number'] * $value['price'];  ?>円</p>
                 <?php $total+=$value['number'] * $value['price'];
                //  print_r($rec3);
                //  print_r($rec3[$x]['id']);
                 ?>

                 <th class="cart_button">

                   <form action="" method="POST">
                     <select name="kazuerabi">
                       <?php for($i=1; $i<=$value['stock'];$i++):?>
                        <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
                        <?php endfor ;?>
                      </select>
                      <input type="hidden" name="itemid" value="<?php echo $rec3[$x]['id']; ?>">
                      <button type="submit" class="btn btn-warning" name="change_button">変更</button>
                       </form>
                      <form action="" method="POST">
                        <input type="hidden" name="itemid" value="<?php echo $rec3[$x]['id']; ?>">
                      <button type="submit" name="sakujo_button" class="btn btn-danger">削除</button>
                    </form>
                  </th>
               </th>
             </tr>
           </table>

       </div>
       <?php $x++;?>
          <?php endforeach; ?>
          <?php if($total<=0): echo '商品が入っていません'; echo '<a href="top.php" style="color:red">&nbsp&nbsp&nbsp戻る</a>';else:echo '計'.$total.'円';?>
          <button type="button" onclick="location.href='tyuumon_kakunin.php';" class="btn btn-success" style="width:100%">購入する</button>
          <?php  endif?>
</div>
</div>
                       </main>
<footer>
<?php
footer_inc();
?>
</footer>

</body>
</html>
