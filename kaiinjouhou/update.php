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

$id = $_SESSION['id'];
$name = $_SESSION['new_name'];
$name_kana = $_SESSION['name_kana'];
$nickname = $_SESSION['new_nickname'];
$sex = $_SESSION['sex'];
$birthday = $_SESSION['birthday'];
$zipcode = $_SESSION['zipcode'];
$address = $_SESSION['address'];
$tell = $_SESSION['tell'];
$email = $_SESSION['email'];

$db = dbconnect();
$sql = 'update users set name=?, name_kana=?, nickname=?, sex=?, birthday=?, zipcode=?, address=?, tell=?, email=? where id=?';
$stmt = $db->prepare($sql);

if (!$stmt) {
    die($db->error);
}
$stmt->bind_param('sssisssssi', $name, $name_kana, $nickname, $sex, $birthday, $zipcode, $address, $tell, $email, $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-変更完了</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
        <?php header_inc(); ?>
    </header>

    <main>
  <div class="kaiin-container">
    <h1>変更完了</h1>
    <button class="btn btn-outline-secondary btn-block" onclick="location.href='kaiin_jouhou.php'">戻る</button>
  </div>
  </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
