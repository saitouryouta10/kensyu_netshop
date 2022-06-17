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
    <div class="form">
        <h1 class="toiawase">お問い合わせ内容確認</h1>
        <div class="container">
            <form action="#" method="post">
                <p>お名前</p>
                <!-- 名前出力 -->
                <p>メールアドレス</p>
                <!-- メールアドレス出力 -->
                <p>件名</p>
                <!-- 件名出力 -->
                <p>お問い合わせ内容</p>
                <!-- お問い合わせ内容出力 -->
                

                <!-- TODO：ボタンの間に隙間を開けたい -->
                <div class="button-matome">
                    <button class="btn btn-outline-secondary btn-block" onclick="location.href='toiawase.php'" id="kakunin">戻る</button>
                    <button type="submit" class="btn btn-warning" id="kakunin" style="font-weight: bold;">送信する</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>