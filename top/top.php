<?php
require('../library.php');
$db =dbconnect();

session_start();
echo session_id();
$_SESSION['img_id']='';

$s='';

if(isset($_POST['narabikae'])){
  $narabikae=$_POST['narabikae'];

  if($narabikae === 'koujun'){
    $s ='order by price desc';
  }
  else if($narabikae === 'shoujun'){
    $s ='order by price asc';
  }
  else{
    $s='order by stock desc';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGE</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body class="top_b">

  <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a>
  <form action="top.php" method="POST">
    <select name="narabikae" id="narabi">

      <?php if($narabikae ==='koujun'):?>
      <option value="koujun">価格が高い順</option>
      <option value="shoujun">価格が低い順</option>
      <?php elseif($narabikae==='shoujun'): ?>
      <option value="shoujun">価格が低い順</option>
      <option value="koujun">価格が高い順</option>
      <?php else : ?>
        <option value="default">並び替え</option>
        <option value="koujun">価格が高い順</option>
      <option value="shoujun">価格が低い順</option>
        <?php endif ;?>
    </select>
    <input type="submit" name="submit" value="適用">
</form>

    <p class="itiran_title">一覧</p>
<div class="itiran">

  <?php
  $sql ='select setumei, name,price,picture,id from items '.$s.'';
  $stmt= $db->query($sql);
  $db = null;
  ?>

  <?while( $rec = $stmt->fetch_assoc()): ?>
    <?php if($rec==false): ?>
      break;
      <?php endif ?>

      <a href="shouhin_shousai.php?id=<?php echo $rec['id'];?>">
        <div class="img_s">
        <table>
          <tr>
            <th class="pic_size">

                   <?php if($rec['picture']==null): ?>
                      <img src="./img/noimage.png">
                    <?php else: ?>
                      <img src="./img/<?php echo $rec['picture'];?>" >

              <div>
                 <?php endif ?>

              </th>
               <th class="th_name">
                 <p> <?php echo $rec['name']; ?> </p>
               </th>
               <th class="th_price">
                 <p> <?php echo $rec['price']; ?>円 </p>
               </th>
               <th class="th_txt">
                 <p><?php echo $rec['setumei'];  ?></p>
               </th>
             </tr>
           </table>
        </div>
       </div>
       </a>


          <?php endwhile; ?>
  </div>


</body>
</html>
