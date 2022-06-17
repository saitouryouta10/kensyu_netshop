<?php
require('../library.php');
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    header('Location: login.php');
    exit();
}
$db = dbconnect();
$stmt = $db->query('select history.name, history.price, history.created, item_id, items.id, items.picture from history left join items on item_id=items.id where user_id='.$user_id.'');
if (!$stmt) {
    die($db->error);
}

// //エラーメッセージの初期化
// $errorMessage = "";
// //フラグの初期化
// $o = false;

// //検索ボタンが押された時の処理
// if (isset($_GET["search"])) {
//   //入力チェック
//   if (empty($_GET["textbox"])) {
//       $errorMessage = '未入力です。';
//   }

//   if (!empty($_GET["textbox"])) {
//     $o = true;
//     //入力した文字を変数に格納
//     $textbox = $_GET["textbox"];
// }

// 検索処理
if (isset($_GET['search'])) {
    $search = h($_GET['search']);
    $search_value = $search;


} else {
    $search = '';
    $search_value = '';
}

//  if ($result) {
//   foreach ($result as $row)

//  }



//  $search_stmt = array();
//  foreach ($db->query($sql) as $row) {
//    array_push($search_stmt,$row);
//  }
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
<form action="" method="get">
       <input type="text" name="search" value="<?php echo $search_value ?>"><br>
       <button type="submit" name="">検索</button>
    </form>
    <form action="shiborikomi.php" method="post">
        <button type="submit" name="">絞り込み ＞</button>
    </form>

    <h1>注文履歴</h1>
    <?php
    if (isset($_GET['search']) ) :
      $search = h($_GET['search']);
      $search_value = $search;
      $db = dbconnect();
      $sql = "select history.name, history.price, history.created, item_id, items.id, items.picture from history left join items on item_id=items.id where history.name LIKE '%$search%' ";
      $search_stmt = $db->prepare($sql);
      if (!$search_stmt) {
        die($db->error);
      }
      $result = $search_stmt->execute();
      if (!$result) {
        die($db->error);
      }
      while( $search_rireki = $search_stmt->fetch()):

    ?>
       <table>
            <tbody>
              <tr>
                <td rowspan="5">
                    <a href="shouhin_shousai.php?id=<?php echo $search_rireki['item_id'];?>">
                    <?php if ($search_rireki['picture'] == null): ?>
                      <img src="./img/noimage.png">
                    <?php else: ?>
                      <img src="./img/<?php echo $search_rireki['picture'];?>" >
                    <?php endif; ?>
                    </a>
                </td>
                <td>商品名 : <?php echo $search_rireki['name']; ?></td>
              </tr>
              <tr>
                <td>金額 : <?php echo $search_rireki['price']; ?></td>
              </tr>
              <tr>
                <td>購入日 : <?php echo $search_rireki['created']; ?></td>
              </tr>
              <tr>
                <td>
                    <button onclick="location.href=../top?id=<?php echo $search_rireki['item_id'];?>">商品レビューを書く</button>
                </td>
              </tr>
              <tr>
                <td>
                    <button onclick="location.href=../top/shouhin_shousai.php?id=<?php echo $search_rireki['item_id'];?>">再度購入</button>
                </td>
              </tr>
            </tbody>
        </table>
      <?php endwhile; ?>
    <?php else : ?>
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
    <?php endif; ?>

    <button onclick="location.href='kaiin_jouhou.php'">戻る</button>

</body>
</html>
