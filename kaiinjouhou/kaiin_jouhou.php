<?php
session_start();
require('../library.php');




// ログインしているか確認






if (isset($_SESSION['id']) && isset($_SESSION['nickname'])) {
    $id = $_SESSION['id'];

    $name = $_SESSION['nickname'];
} else {
    $login = 1;
    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
    header('Location:../login/login.php?login='.$login.'');
    exit();
}

// $_SESSION["id"] = 1;
// $name = "hogehoge";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員情報</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

</head>
<body>
    <header>
        <?php header_inc(); ?>
    </header>

    <main class="kaiin-body">
        <div class="kaiin-jouhou">

            <h1>会員情報</h1>

            <div class="btn-wrapper">
                <h5><?php echo $name ?>さん</h5>
                <p><button class="btn btn-primary" onclick="location.href='touroku_jouhou.php'">登録情報確認する</button></p>
                <p><button class="btn btn-primary"  onclick="location.href='touroku_henkou.php'">会員情報変更する</button></p>
                <p><button class="btn btn-primary" onclick="location.href='rireki.php'">注文履歴</button></p>
            </div>

        </div>

    </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>

</body>
</html>
