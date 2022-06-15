<?php
session_start();
require('../library.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $name_kana = $_SESSION['name_kana'];
    $nickname = $_SESSION['nickname'];
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
  <title>変更完了</title>
</head>
<body>
  <h1>変更完了</h1>

  <button onclick="location.href='kaiin_jouhou.php'">戻る</button>
</body>
</html>
