<?php
  require('../library.php');
  $db =dbconnect();

  session_start();

  //セッション情報があったら
  if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
    $sql1 ='select * from users where id='.$userid.'';
    $stmt1= $db->query($sql1);

    //idから情報をすべて抜き出し名前をセッションへ追加
    while($rec1 =$stmt1->fetch_assoc()){
      echo $rec1['name'] . 'さん　おかえりなさい';
      $user_name = $rec1["nickname"];
      $_SESSION["nickname"] = $user_name;
    }

  //なければゲストと表示
  }else{
    echo 'ゲストさん';
  }




$_SESSION['img_id']='';

$s='';

// 商品並び替えのため、変数にsql文を渡す
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../style.css">

</head>
<body class="top_b">
<header>
  <?php header_inc(); ?>
</header>
<main>

<div class="container" style="padding: 0 10%;">
  <!-- <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a> -->
  <form action="top.php" method="POST">
    <select name="narabikae" id="narabi">

  <!--  セレクトボックスの表示内容を変更する初期は「並び替え」になっているが、選択するとなくなるように -->
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
    <button type="submit" name="submit" class="btn btn-success">適用</button>
</form>

    <p class="itiran_title">一覧</p>
    <a href="cart.php">カートに行く</a>
<div class="itiran">

  <?php
  $sql ='select setumei, name,price,picture,id from items '.$s.'';
  $stmt= $db->query($sql);
  $db = null;
  ?>

<!-- データベースから商品一覧を表示させるもの。 -->
  <?php while( $rec = $stmt->fetch_assoc()): ?>
    <?php if($rec==false): ?>
      break;
      <?php endif ?>
<?php //print_r($rec);?>
      <a class="top_a" href="shouhin_shousai.php?id=<?php echo $rec['id'];?>">
        <div class="img_s">
        <table class="top_table">
          <tr>
            <th class="pic_size">

              <?php if($rec['picture']==null): ?>
                      <img src="./img/noimage.png">
                    <?php else: ?>
                      <img src="./img/<?php echo $rec['picture'];?>" >
                      <?php endif ?>
                    </div>

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
        <!-- </div> -->
       </div>
       </a>

       <?php endwhile; ?>
      <!-- </div> -->


    </div>
    </main>
<footer>
  <?php
footer_inc();
?>
</footer>

</body>
</html>
