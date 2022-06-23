<?php
require('../library.php');
$db =dbconnect();

session_start();
$userid=$_SESSION['id'];
// $item_id=$_GET['id'];


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

if(isset($_POST['sakujo_button'])==true){
  $sqls='delete from cart where id=?';
  $stmts =$db ->prepare($sqls);
  $stmts->bind_Param("s",$itemid);
  $stmts->execute();
}

if(isset($_POST['change_button'])==true){
  $sql2 = 'update cart set number='.$kazuerabi.' where id in('.$itemid.')';
  $stmt2 =$db ->query($sql2);

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

$stmt =$db ->query($sql);
$stmt2=$db->query($sql2);
$stmt3=$db->query($sql3);
$db=null;

// $stmt->bind_Param("s",$userid);
// $stmt->execute();

// $stmt->bind_result($id,$user_id,$item_id,$number,$created);
?>

<?php
$result2 = $stmt2->fetch_assoc();
?>
<?while( $rec = $stmt->fetch_assoc()):?>
  <?php $result3 = $stmt3->fetch_assoc();?>
  <?php //print_r($result3);?>
  <?php if($rec==false): ?>
      break;
      <?php endif ?>
      <div class="img_s">
      <table>
    <tr>
      <th class="pic_size">

        <a href="shouhin_shousai.php?id=<?php echo $rec['item_id'];?>">
                   <?php if($rec['picture']==null): ?>
                      <img src="./img/noimage.png">
                    <?php else: ?>
                      <img src="./img/<?php echo $rec['picture'];?>" >

                      <div>
                        <?php endif ?>
                      </a>
                      </th>
               <th class="th_name">
                 <p> <?php echo $rec['name']; ?> </p>
               </th>
               <th class="th_price">
                 <p> <?php echo $rec['price']; ?>円 </p>
               </th>
               <th>
                 <p><?php echo $rec['number'];  ?>個</p>
               </th>
               <th>
                 <p>計<?php echo $rec['number'] * $rec['price'];  ?>円</p>
                 <?php $total+=$rec['number'] * $rec['price']; ?>
                 <th>

                   <!-- <form action="" method="POST">
                     <select name="kazuerabi">
                       <?php for($i=1; $i<=$rec['stock'];$i++):?>
                        <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
                        <?php endfor ;?>
                      </select>
                      <input type="hidden" name="itemid" value="<?php echo $result3['id']; ?>">
                      <input type="submit" value="変更する" name="change_button">
                       </form>
                      <form action="" method="POST">
                        <input type="hidden" name="itemid" value="<?php echo $result3['id']; ?>">
                      <input type="submit" value="削除する" name="sakujo_button">
                      <?php //echo $result3['id'] ;?>
                    </form> -->
                  </th>
               </th>
             </tr>
           </table>
          </div>
          <?php endwhile; ?>
          <?php if($total<=0){ echo '商品が入っていません'; echo '<a href="top.php" style="color:red">戻る</a>';}else{echo '計'.$total.'円'; $_SESSION['total']=$total;}?>
          <button type="button" onclick="location.href='tyuumon_kakutei.php';" class="btn btn-success" style="width:100%">注文を確定する</button>
        </div>
      </div>

<div>

</div>



                       </main>
<footer>
  <?php
footer_inc();
?>
</footer>
</body>
</html>
