<?php
require('../lib/DBController.php');
require('../library.php');
// $db =dbconnect();
$db = new DBController;


session_start();
if(isset($_SESSION['kounyuu'])){
  unset($_SESSION['kounyuu']);
  }
isset($_SESSION['id']);
$_SESSION['img_id']='';

$s='';
$sc='';

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
  <title>HOGEHOGE SHOP-トップ</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../style.css">

  

  <script>
    function osuna() {
const x = confirm("絶対押すなよ");

if(x) {
alert("いいね");
}else{
window.open('https://www.google.com/?hl=ja', '_blank');
}
}
  </script>
</head>
<body class="top_b">
<header>
    <?php header_inc(); ?>
</header>
<main>

<a href="" onclick="osuna()" onclick="osuna()" class="btn" style="color:antiquewhite">押すな</a>
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
  $sql ='select setumei, name,price,picture,id from items '.$sc.' '.$s.'';
  $rec=$db->executeQuery($sql, $types = null);
  // $stmt= $db->query($sql);
  // $db = null;
  // print_r($rec);
  // echo count($rec);
  // exit();
  ?>

<!-- データベースから商品一覧を表示させるもの。 -->
  <?php foreach($rec as $value): ?>
    <?php if($rec==false): ?>
      <?php break;?>
      <?php endif ?>
<?php //print_r($rec);?>

<!-- 商品一覧を表示させるテーブル -->
      <a class="top_a" href="shouhin_shousai.php?id=<?php echo $value['id'];?>">
        <div class="img_s">
        <table class="top_table">
          <tr>
            <th class="pic_size">

                <?php if($value['picture']==null): ?>
                  <img class="img-wrap" src="./img/noimage.png">
                  <?php else: ?>
                    <img src="./img/<?php echo $value['picture'];?>" >
                    <?php endif ?>

                    </div>

              </th>
               <th class="th_name">
                 <p> <?php echo $value['name']; ?> </p>
               </th>
               <th class="th_price">
                 <p> <?php echo $value['price']; ?>円 </p>
               </th>
               <th class="th_txt">
                 <p><?php echo $value['setumei'];  ?></p>
               </th>
             </tr>
           </table>
        <!-- </div> -->
       </div>
       </a>

       <?php endforeach; ?>
      <!-- </div> -->


    </div>
    </main>
<footer>
  <?php
footer_inc();
?>
</footer>

</body>
<!-- <script src="../test.js"></script> -->
</html>
