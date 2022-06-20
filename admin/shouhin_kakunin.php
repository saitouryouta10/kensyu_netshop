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
         <!--商品名表示  -->
        
        <p>価格</p>
        <!-- 価格表示 -->

        <p>個数</p>
        <!-- 個数表示 -->

        <p>画像</p>
        <!-- 画像表示 -->

        <p>商品説明</p>
        <!-- 商品説明表示 -->

        <p>詳細情報</p>
        <!-- 詳細情報表示 -->
    </div>
    <div class="admin_button_matome">
        <button type="button" class="btn btn-primary">戻る</button>

        <!-- shouhin_kakutei.phpへ -->
        <button type="button" class="btn btn-primary">追加する</button>
    </div>
</body>
</html>