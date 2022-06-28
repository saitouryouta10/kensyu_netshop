<?php
session_start();

require('../library.php');

if(isset($_SESSION["form"])){
    $form = $_SESSION["form"];
}else{
    header("Location: sinki_touroku.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <title>HOGEHOGE SHOP-登録</title>
</head>
<body>
        <div class="kakunin_buttonmatome_2">
            <button class="btn btn-success btn1" onclick="location.href='sinki_touroku.php'">変更する</button>
        </div>
    <form action="touroku.php" method="post">
        <div class="kakunin_container">
            <h1>登録情報</h1>
            <div class="kakunin_value">
                <p class="kakunin_title">名前</p><p><?php echo h($form["name"]); ?></p>
                <p class="kakunin_title">フリガナ</p><p><?php echo h($form["name_kana"]); ?></p>
                <p class="kakunin_title">ニックネーム</p><p><?php echo h($form["nickname"]); ?></p>
                <p class="kakunin_title">
                    性別</p><p><?php
                    if($form["sex"] == 1) {
                        echo "男性";
                    } else if ($form["sex"] == 2) {
                        echo "女性";
                    } else {
                        echo "その他";
                    } ?>
                </p>
                <p class="kakunin_title">生年月日</p>
                <?php if($form["birthday"] === NULL):?>
                    <p>登録していません</p>
                <?php else:?>
                    <p><?php echo h($form["birthday"]);?></p>
                <?php endif;?>
                <p class="kakunin_title">
                    住所</p><p style="width: 100%; word-wrap: break-word;"><?php echo h($form["zipcode"]); ?><br>
                    <?php echo h($form["address"]); ?>
                </p>
                <p class="kakunin_title">電話番号</p><p><?php echo h($form["tell"]); ?></p>
                <p class="kakunin_title">メールアドレス</p><p><?php echo h($form["email"]); ?></p>
            </div>
    
            <div class="kakunin_buttonmatome_1">
                <button class="btn btn-warning btn2" style="font-weight: bold;">登録する</button>
            </div>
        </div>
    </form>
</body>
</html>
