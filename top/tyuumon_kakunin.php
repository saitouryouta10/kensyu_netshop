<?php
require('../lib/DBController.php');
require('../library.php');
// $db =dbconnect();
$db = new DBController;

session_start();
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
// $item_id=$_GET['id'];
if(isset($_SESSION['kounyuu']) && $_SESSION['kounyuu'] ===1){
  header('Location: top.php');
  exit();
  }
$_SESSION['kounyuu']=2;
//数の選択
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


$total=0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-注文確認</title>
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
  <p>注文確認</p>
  <a href="cart.php">戻る</a>
  <?php
$sql='select * from cart  inner join items on cart.item_id=items.id where user_id='.$userid.'';
// $sql = 'select id,user_id,item_id,number from cart where user_id='.$userid.'';
$sql2= 'select count(*) from cart where user_id='.$userid.'';
$sql3='select id from cart where user_id='.$userid.'';
$rec=$db->executeQuery($sql, $types = null);
$rec2=$db->executeQuery($sql2, $types = null);

?>

<?php foreach($rec as $value):?>
  <?php $rec3=$db->executeQuery($sql3, $types = null);?>
  <?php //print_r($result3);?>
  <?php if($rec==false){ break;}?>

      <!-- 商品の表示 -->
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
               <th>
                 <p><?php echo $value['number'];  ?>個</p>
               </th>
               <th>
                 <p>計<?php echo $value['number'] * $value['price'];  ?>円</p>
                 <?php $total+=$value['number'] * $value['price']; ?>
                </th>
             </tr>
           </table>
          </div>
          <?php endforeach; ?>
          <?php if($total<=0): echo '商品が入っていません'; ?>
          <?php else: echo '計'.$total.'円'; $_SESSION['total']=$total;?>
          <button type="button" onclick="location.href='tyuumon_kakutei.php';" class="btn btn-success" style="width:100%">注文を確定する</button>
          <?php endif; ?>
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
