<?php
session_start();
$form_add = $_SESSION["form_add"];
$filename = $_SESSION["image"];

if (isset($_SESSION["id"])){
    if($_SESSION["id"] !== 1){
        header("Location: ../top/top.php");
    }
}else{
    header("Location: ../top/top.php");
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
    <div class="admin_subtitle">
        <h2>商品確認</h2>
    </div>

    <!-- inputにクラスとかnameとかつけて情報取得してください -->
    <div class="admin_form">
        <p>商品名</p>
         <?php echo $form_add["name"];?>
        
        <p>価格</p>
        <!-- 価格表示 -->
        <?php echo $form_add["price"];?>

        <p>個数</p>
        <!-- 個数表示 -->
        <?php echo $form_add["stock"];?>

        <p>ジャンル</p>
        <!-- 個数表示 -->
        <?= $form_add["jenre_id"] === "1" ? "家具" : ""?>
        <?= $form_add["jenre_id"] === "2" ? "食材" : ""?>
        <?= $form_add["jenre_id"] === "3" ? "玩具" : ""?>
        <?= $form_add["jenre_id"] === "4" ? "日用品" : ""?>
        <?= $form_add["jenre_id"] === "5" ? "家電" : ""?>
        <?= $form_add["jenre_id"] === "0" ? "その他" : ""?>

        <p>画像</p>
        <!-- 画像表示 -->
        <img style="width: 100px; height: 100px;"src="../top/img/<?php echo $filename;?>">

        <p>商品説明</p>
        <!-- 商品説明表示 -->
        <?php echo $form_add["setumei"];?>

        <p>詳細情報</p>
        <!-- 詳細情報表示 -->
        <?php echo $form_add["syousai"];?>
    </div>
    <div class="admin_button_matome">
        <a type="button" class="btn btn-primary" onclick="location='jouhou_add.php'">戻る</a>

        <!-- shouhin_kakutei.phpへ -->
        <a type="button" class="btn btn-primary" onclick="location='shouhin_kakutei.php'">追加する</a>
    </div>
</body>
</html>