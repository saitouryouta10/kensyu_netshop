<?php
session_start();
session_regenerate_id();

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
    <title>登録情報</title>
</head>
<body>
    <button onclick="location.href='sinki_touroku.php'">変更する</button>
    <h1>登録情報</h1>
    <form action="touroku.php" method="post">
    <p>名前<br><?php echo h($form["name"]); ?></p>
    <p>名前（フリガナ）<br><?php echo h($form["name_kana"]); ?></p>
    <p>ニックネーム<br><?php echo h($form["nickname"]); ?></p>
    <p>
        性別<br><?php h($form["sex"]);
        if($form["sex"] == 1) {
            echo "男性";
        } else if ($form["sex"] == 2) {
            echo "女性";
        } else {
            echo "その他";
        } ?>
     </p>
    <p>生年月日<br><?php echo h($form["birthday"]); ?></p>
    <p>
        住所<br><?php echo h($form["zipcode"]); ?><br>
        <?php echo h($form["address"]); ?>
    </p>
    <p>電話番号<br><?php echo h($form["tell"]); ?></p>
    <p>メールアドレス<br><?php echo h($form["email"]); ?></p>



    <button>登録する</button>
    </form>


</body>
</html>
