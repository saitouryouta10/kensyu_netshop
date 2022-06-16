<?php
session_start();
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
  <title>パスワード変更確認</title>
</head>
<body>
  <h1>パスワードを変更しました</h1>

  <button onclick="location.href='kaiin_jouhou.php'">戻る</button>
</body>
</html>
