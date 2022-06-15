<?php
require('../library.php');
session_start();
$name = $_SESSION['name'];
$name_kana = $_SESSION['name_kana'];
$nickname = $_SESSION['nickname'];
$sex = $_SESSION['sex'];
$birthday = $_SESSION['birthday'];
$zipcode = $_SESSION['zipcode'];
$address = $_SESSION['address'];
$tell = $_SESSION['tell'];
$email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>変更内容確認</title>
</head>
<body>
<h1>変更内容</h1>
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
    <p>生年月日<br><?php echo h($birthday); ?></p>
    <p>
        住所<br><?php echo h($zipcode); ?><br>
        <?php echo h($address); ?>
    </p>
    <p>電話番号<br><?php echo $tell; ?></p>
    <p>メールアドレス<br><?php echo h($email); ?></p>


    <button onclick="history.back()">戻る</button>
    <button onclick="location.href='update.php'">確定</button>


</body>
</html>
