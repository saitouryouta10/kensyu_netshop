<?php
session_start();
require('../library.php');

if (isset($_SESSION['id'])) {
    $ssid = $_SESSION['id'];
} else {
    header('Location: login.php');
    exit();
}
$id = $ssid;
$db = dbconnect();
$sql = 'select id, name, name_kana, nickname, sex, birthday, zipcode, address, tell, email from users where id=?';
$stmt = $db->prepare($sql);
if (!$stmt) {
    die($db->error);
}
$stmt->bind_param("i", $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}
$stmt->bind_result($id, $name, $name_kana, $nickname, $sex, $birthday, $zipcode, $address, $tell, $email);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報</title>
</head>
<body>

    <h1>登録情報</h1>
    <?php while ( $stmt->fetch() ): ?>
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

    <?php endwhile; ?>

    <button onclick="history.back()">戻る</button>



</body>
</html>
