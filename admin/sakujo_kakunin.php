<?php 
require("../library.php");
session_start();

$delete = $_SESSION["delete"];
var_dump($delete);

$db = dbconnect();

$stmt = $db->$prepare("select name")




?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>HOGEHOGE SHOP</title>
</head>
<body>
    <div class="kanri_top">
        <h1>管理画面</h1>
        <div class="admin_button">
            <button type="button" onclick="location='../login/logout.php'">ログアウト</button>
            <button type="button" onclick="location='kanri_top.php'">TOP</button>
        </div>
    </div>
    <div class="admin_kakunin">
        <p>〇〇を削除してもよろしいですか</p>
    </div>
    </div>
    <div class="admin_button_matome">
            <!-- sakujo_kakutei.phpへ -->
            <button type="button" class="btn btn-primary admin_yes">はい -削除する</button>
            <a type="button" class="btn btn-danger admin_no" onclick="location.href='shouhin_sakujo.php'">いいえ -選択画面に戻る</a>
    </div>
</body>
</html>