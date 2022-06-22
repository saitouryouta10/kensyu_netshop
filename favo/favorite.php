<?php
require('../library.php');
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    header('Location: login.php');
    exit();
}
$s = '';
$p = '';


if (isset($_GET['narabikae'])) {
  $narabikae=$_GET['narabikae'];

  if($narabikae === 'koujun'){
    $s ='order by f.created desc';
  }
  else if($narabikae === 'shoujun'){
    $s ='order by f.created asc';
  }
}

if (isset($_GET['nedan'])) {
  $nedan = $_GET['nedan'];
  switch($nedan) {
  case 1 :
    $p = 'and i.price <= 1000';
    break;
  case 2 :
    $p = 'and i.price >=1001 and i.price <= 5000';
    break;
  case 3 :
    $p = 'and i.price >=5001 and i.price <= 10000';
    break;
  case 4 :
    $p = 'and i.price >=10001 and i.price <= 50000';
    break;
  case 5 :
    $p = 'and i.price >=50001';
    break;
  default :
    $p = 'and i.price >= 0';
  }
}

  $db = dbconnect();
  $stmt = $db->query('select f.id, f.user_id, f.created, f.item_id, i.id, i.picture,i.name, i.price from favorite f left join items i on item_id=i.id where user_id='.$user_id.' '.$p.' '.$s.'');
  if (!$stmt) {
    die($db->error);
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

</head>
<body>
  <header>
    <?php header_inc(); ?>
  </header>

  <main class="kaiin-body">

  <div class="btn-modoru-rireki">
    <a class="btn btn-outline-secondary btn-block" href="../top/top.php">トップに戻る</a>
  </div>


  <form action="" method="GET">
    <select name="narabikae" id="narabi">
      <?php if($narabikae ==='koujun'):?>
      <option value="koujun">新しい順</option>
      <option value="shoujun">古い順</option>
      <?php elseif($narabikae==='shoujun'): ?>
      <option value="shoujun">古い順</option>
      <option value="koujun">新しい順</option>
      <?php else : ?>
        <option value="default">並び替え</option>
        <option value="koujun">新しい順</option>
      <option value="shoujun">古い順</option>
      <?php endif ;?>
    </select>

    <select name="nedan" id="nedan">
      <option value="default">すべて</option>
      <option value="1">～1000円</option>
      <option value="2">1001円～5000円</option>
      <option value="3">5001円～10000円</option>
      <option value="4">10001円～50000円</option>
      <option value="5">50001円～</option>
    </select>

    <button type="submit" name="">検索</button>
  </form>
  <h1>お気に入り</h1>
  <div class="rireki-table">
      <?php while( $rireki = $stmt->fetch_assoc()): ?>
          <table>
              <tbody>
                <tr>
                  <td rowspan="5">
                      <a href="../top/shouhin_shousai.php?id=<?php echo $rireki['item_id']; ?>">
                      <?php if ($rireki['picture'] == null): ?>
                        <img src="../top/img/noimage.png">
                      <?php else: ?>
                        <img src="../top/img/<?php echo $rireki['picture'];?>" >
                      <?php endif; ?>
                      </a>
                  </td>
                  <td>商品名 : <?php echo $rireki['name']; ?></td>
                </tr>
                <tr>
                  <td>金額 : <?php echo $rireki['price']; ?>円</td>
                </tr>
                <tr>
                  <td>追加日 : <?php echo $rireki['created']; ?></td>
                </tr>
                <tr>
                  <td>
                      <a class="btn btn-success" href="../top/kutikomi.php?id=<?php echo $rireki['item_id']; ?>">商品レビューを書く</a>
                  </td>
                </tr>
                <tr>
                  <td>
                      <a class="btn btn-warning" href="../top/shouhin_shousai.php?id=<?php echo $rireki['item_id'];?>">再度購入</a>
                  </td>
                </tr>
              </tbody>
          </table>
      <?php endwhile; ?>
  </div>


    </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
