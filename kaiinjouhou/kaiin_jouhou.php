<?php
session_start();
require('../library.php');

//ログインしているか確認
// if (isset($_SESSION['login_id']) && isset($_SESSION['name'])) {
//     $id = $_SESSION['login_id']
//     $name = $_SESSION['name'];
// } else {
//     header('Location: login.php');
//     exit();
// }

$_SESSION["id"] = 2;
$name = "hogehoge";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員情報</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>会員情報</h1>
    <p><?php echo $name ?>さん</p>
    <div class="btn-wrapper">
        <button onclick="location.href='touroku_jouhou.php'">登録情報を確認する</button>
        <button onclick="location.href='touroku_henkou.php'">会員情報を変更する</button>
        <button onclick="location.href='rireki.php'">注文履歴</button>
    </div>


</body>
</html>
