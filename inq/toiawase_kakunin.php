<?php
require("../library.php");
session_start();
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$kenmei = $_SESSION['kenmei'];
$inquiry = $_SESSION['inquiry'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>HOGEHOGE SHOP-お問い合わせ内容確認</title>
</head>
<body>
    <div class="form">

        <h1 class="text-center" style="margin-top: 50px">お問い合わせ内容確認</h1>
        <hr>

        <div class="container">
            <form action="sousinkanryou.php" method="post">
                <p>お名前</p>
                <p><?php echo h($name); ?></p>
                <p>メールアドレス</p>
                <p><?php echo h($email); ?></p>
                <p>件名</p>
                <p><?php echo h($kenmei); ?></p>
                <p>お問い合わせ内容</p>
                <p style="width:100%; word-wrap: break-word;"><?php echo h($inquiry); ?></p>

                <div class="button-matome">
                    <button type="submit" class="btn btn-warning btn-matome-pos" style="font-weight: bold;">送信する</button>
                    <a class="btn btn-outline-secondary btn-block btn-matome-pos" onclick="location.href='toiawase.php'">戻る</a>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <p class="text-center" style="margin-bottom: 30px">© 2022 Kensyu_netshop</p>
</body>
</html>
