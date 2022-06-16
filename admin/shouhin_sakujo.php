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
            <button type="button">ログアウト</button>
            <button type="button">TOP</button>
        </div>
    </div>
    <div class="admin_subtitle">
        <h2>削除する商品を選択してください</h2>
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
        <button type="button" class="btn btn-primary">戻る</button>
        
        
        <!-- sakujo_kakunin.phpへ -->
        <button type="button" class="btn btn-primary">削除</button>
    </div>
</body>
</html>