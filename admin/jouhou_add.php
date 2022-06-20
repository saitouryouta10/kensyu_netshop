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
        <h2>商品追加</h2>
        <span>追加する商品の情報を入力してください</span>
    </div>

    <!-- inputにクラスとかnameとかつけて情報取得してください -->
    <div class="admin_form">
        <p>商品名　<span class="badge bg-danger">必須</span></p>
        <input type="text" required> 
        
        <p>価格　<span class="badge bg-danger">必須</span></p>
        <input type="text" required>円

        <p>個数　<span class="badge bg-danger">必須</span></p>
        <input type="text" required>

        <p>ジャンル　<span class="badge bg-danger">必須</span></p>
        <input type="radio" name="jenre" id="kagu" value="1" required>
        <label for="kagu">家具</label>
        
        <input type="radio" name="jenre" id="syokuzai" value="2" required>
        <label for="syokuzai">食材</label>

        <input type="radio" name="jenre" id="gangu" value="3" required>
        <label for="gangu">玩具</label>

        <input type="radio" name="jenre" id="nitiyouhin" value="4" required>
        <label for="nitiyouhin">日用品</label>

        <input type="radio" name="jenre" id="kaden" value="5" required>
        <label for="kaden">家電</label>

        <p>画像　<span class="badge bg-danger">必須</span></p>
        <input type="file" required>

        <p>商品説明　<span class="badge bg-danger">必須</span></p>
        <textarea required>
        </textarea>

        <p>詳細情報　<span class="badge bg-danger">必須</span></p>
        <textarea required>
        </textarea>
    </div>
    <div class="admin_button_matome">
        <button type="button" class="btn btn-primary">戻る</button>

        <!-- shouhin_kakunin.phpへ -->
        <button type="button" class="btn btn-primary">追加する</button>
    </div>
</body>
</html>