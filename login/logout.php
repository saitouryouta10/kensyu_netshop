<?php 
session_start();
unset($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGEHOGE SHOP</title>
</head>
<body>
    <h1>ログアウトしました<h1>
    <button type="button" class="btn btn-primary" onclick="location.href='../top/top.php'">トップに戻る</button>
    <button type="button" class="btn btn-primary" onclick="location.href='login.php'">ログインページへ</button>
</body>
</html>