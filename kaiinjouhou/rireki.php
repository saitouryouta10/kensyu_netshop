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
    $s ='order by history.created desc';
  }
  else if($narabikae === 'shoujun'){
    $s ='order by history.created asc';
  }
}

if (isset($_GET['nedan'])) {
  $nedan = $_GET['nedan'];
  switch($nedan) {
  case 1 :
    $p = 'history.price <= 1000';
    break;
  case 2 :
    $p = 'history.price >=1001 and history.price <= 5000';
    break;
  case 3 :
    $p = 'history.price >=5001 and history.price <= 10000';
    break;
  case 4 :
    $p = 'history.price >=10001 and history.price <= 50000';
    break;
  case 5 :
    $p = 'history.price >=50001';
    break;
  default :
    $p = 'history.price >= 0';
  }
}

  $db = dbconnect();
  $stmt = $db->query('select history.name, history.price, history.created, item_id, items.id, items.picture from history left join items on item_id=items.id where user_id='.$user_id.' '.$s.'');
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
    <title>rireki</title>
    <style>
        table , td, th {
	        border: none;
	        border-collapse: collapse;
        }
        table {
            margin-bottom: 30px;
        }
        td, th {
        	padding: 3px;
        	width: 50%;
        	height: 25px;
        }
        th {
        	background: #f0e6cc;
        }
        .even {
        	background: #fbf8f0;
        }
        .odd {
        	background: #fefcf9;
        }
    </style>
</head>
<body>
  <form action="rireki.php" method="GET">
    <select name="narabikae" id="narabi">
      <?php if($narabikae ==='koujun'):?>
      <option value="koujun">新しい順</option>
      <option value="shoujun">古いい順</option>
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

    <h1>注文履歴</h1>

      <?php while( $rireki = $stmt->fetch_assoc()): ?>
          <table>
              <tbody>
                <tr>
                  <td rowspan="5">
                      <a href="shouhin_shousai.php?id=<?php echo $rireki['item_id']; ?>">
                      <?php if ($rireki['picture'] == null): ?>
                        <img src="./img/noimage.png">
                      <?php else: ?>
                        <img src="./img/<?php echo $rireki['picture'];?>" >
                      <?php endif; ?>
                      </a>
                  </td>
                  <td>商品名 : <?php echo $rireki['name']; ?></td>
                </tr>
                <tr>
                  <td>金額 : <?php echo $rireki['price']; ?></td>
                </tr>
                <tr>
                  <td>購入日 : <?php echo $rireki['created']; ?></td>
                </tr>
                <tr>
                  <td>
                      <button onclick="location.href=../top?id=<?php echo $rireki['item_id'];?>">商品レビューを書く</ button>
                  </td>
                </tr>
                <tr>
                  <td>
                      <button onclick="location.href=../top/shouhin_shousai.php?id=<?php echo $rireki['item_id'];?>">再度購入</button>
                  </td>
                </tr>
              </tbody>
          </table>
      <?php endwhile; ?>

    <button onclick="location.href='kaiin_jouhou.php'">戻る</button>

</body>
</html>
