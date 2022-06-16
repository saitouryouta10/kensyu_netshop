<?php
require('../library.php');
$db =dbconnect();

session_start();
$userid=$_SESSION['id'];
// $item_id=$_GET['id'];

if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];
}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
$cart=$_SESSION['cart'];
}
echo $userid;

if(isset($_POST['sakujo'])==true){
  $sakujo=$_POST['sakujo'];
  echo $sakujo;
  }

if(isset($_POST['sakujo_button'])==true){
  $sqls='delete from cart where id=?';
  $stmts =$db ->prepare($sqls);
  $stmts->bind_Param("s",$sakujo);
  $stmts->execute();
}

$total=0;
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
  <?php print_r($result3);?>
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

                   <form action="" method="POST">
                     <select name="kazuerabi">
                       <?php for($i=1; $i<=$rec['stock'];$i++):?>
                        <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
                        <?php endfor ;?>
                      </select>
                      <input type="submit" value="変更する" name="change_button">
                       </form>
                      <form action="" method="POST">
                        <input type="hidden" name="sakujo" value="<?php echo $result3['id']; ?>">
                      <input type="submit" value="削除する" name="sakujo_button">
                      <?php echo $result3['id'] ;?>
                    </form>
                  </th>
               </th>
             </tr>
           </table>
        </div>
       </div>
          <?php endwhile; ?>
          <?php if($total<=0){ echo '商品が入っていません'; echo '<a href="top.php" style="color:red">戻る</a>';}else{echo $total;} ?>
</div>

<div>

</div>
</body>
</html>