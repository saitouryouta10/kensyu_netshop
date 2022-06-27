<?php
require('../library.php');
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

$name = $_SESSION['name'];
$name_kana = $_SESSION['name_kana'];
$nickname = $_SESSION['nickname'];
$sex = $_SESSION['sex'];
$birthday = $_SESSION['birthday'];
$zipcode = $_SESSION['zipcode'];
$address = $_SESSION['address'];
$tell = $_SESSION['tell'];
$email = $_SESSION['email'];

unset($_SESSION['name']);
unset($_SESSION['nickname']);

$_SESSION['new_name'] = $name;
$_SESSION['new_nickname'] = $nickname;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-変更内容確認</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
        <?php header_inc(); ?>
    </header>

    <main class="kaiin-body">
<div class="kakunin_container">
<h1>変更内容</h1>
    <div class="kakunin_value">
    <p>名前<br><?php echo h($name); ?></p>
    <p>名前（フリガナ）<br><?php echo h($name_kana); ?></p>
    <p>ニックネーム<br><?php echo h($nickname); ?></p>
    <p>
        性別<br><?php h($sex);
        if(($sex == 1)) {
            echo "男性";
        } else if ( ($sex) == 2) {
            echo "女性";
        } else {
            echo "その他";
        } ?>
     </p>
     <?php if (empty($birthday)) : ?>
        <p>生年月日<br>登録していません</p>
    <?php else : ?>
        <p>生年月日<br><?php echo h($birthday); ?></p>
    <?php endif; ?>
    <p style="width:100%; word-wrap: break-word;">
        住所<br><?php echo h($zipcode); ?><br>
        <?php echo h($address); ?>
    </p>
    <p>電話番号<br><?php echo $tell; ?></p>
    <p>メールアドレス<br><?php echo h($email); ?></p>
    </div>

    </div>

<div class="btn-kakutei">
    <button class="btn btn-outline-secondary btn-block" onclick="location.href='touroku_henkou.php'">戻る</button>
    <button class="btn btn-warning" onclick="location.href='update.php'">確定</button>
</div>

</main>
    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
