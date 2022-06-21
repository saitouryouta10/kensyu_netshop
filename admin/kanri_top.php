<?php 
require("../library.php");
session_start();

//ジャンプ防御
if (isset($_SESSION["id"])){
    if($_SESSION["id"] !== 1){
        header("Location: ../top/top.php");
    }
}else{
    header("Location: ../top/top.php");
}


$db = dbconnect();

// $stmt = $db->prepare("select created,name,price,stock from items")

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
        <h2>管理者画面TOP</h2>
        <span>出品商品情報</span>
    </div>
    <div class="admin_item_title">
        <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
    </div>
    <div class="admin_item">
        <!-- 下みたいにタグコピペして商品情報出力してください。 -->
        <!-- メモ：長さ違うとレイアウトぐちゃぐちゃになる。どうしたらいいかわからん
            top.phpから引っ張ってテーブルをwhileで回してください。携帯画面のcssは暇があったら作ってください。 -->
        <!-- <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
        <p><span>日時</span><span>商品名</span><span>aaaaaaaa</span><span>販売数</span><span>在庫数</span>
        <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
        <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span> -->
    </div>
    </div>
    <div class="admin_button_matome">
        <button type="button" class="btn btn-primary" onclick="location='shouhin_itiran.php'">過去の出品</button>
        <button type="button" class="btn btn-primary" onclick="location='jouhou_add.php'">商品追加</button>
        <button type="button" class="btn btn-primary" onclick="location='shouhin_sakujo.php'">商品削除</button>
        <button type="button" class="btn btn-primary" onclick="location='user_sanshou.php'">登録者情報管理</button>
    </div>
</body>
</html>