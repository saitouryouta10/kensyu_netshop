<?php
session_start();
if(isset($_SESSION["id"])){
  //セッション情報がある場合は普通に画面遷移
  $userid=$_SESSION['id'];
}else{
    $login = 1;
    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
  header('Location:../login/login.php?login='.$login.'');
  exit();
}
require('../library.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $pass = $_SESSION['pass'];

    $db = dbconnect();
    $sql = 'update users set pass=? where id=?';
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param('si', $pass, $id);
    $success = $stmt->execute();
    if (!$success) {
        die($db->error);
    }

} else {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-パスワード変更確認</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
      <?php header_inc(); ?>
    </header>
    <main class="kaiin-body">
  <div class="kaiin-container">
    <h1>パスワードを変更しました</h1>
    <button class="btn btn-outline-secondary btn-block" onclick="location.href='kaiin_jouhou.php'">戻る</button>
  </div>
  </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
