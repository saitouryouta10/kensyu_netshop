<?php
require("../library.php");

$form_add = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $form_add["name"] = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
    $form_add["price"] = filter_input(INPUT_POST,"price",FILTER_SANITIZE_NUMBER_INT);
    $form_add["stock"] = filter_input(INPUT_POST,"stock",FILTER_SANITIZE_NUMBER_INT);
    $form_add["jenre_id"] = filter_input(INPUT_POST,"jenre",FILTER_SANITIZE_NUMBER_INT);
    $form_add["setumei"] = filter_input(INPUT_POST,"setumei",FILTER_SANITIZE_STRING);
    $form_add["syousai"] = filter_input(INPUT_POST,"syousai",FILTER_SANITIZE_STRING);
    $image = $_FILES["picture"];

    /*------------------名前バリデーション------------------*/

    $form_length["name"] = mb_strlen($form_add["name"]);

    if ($form_length["name"] > 9999999999) {
        $error["name"] = "length_error";
    }

    /*------------------値段バリデーション------------------*/

    $form_length["price"] = mb_strlen($form_add["price"]);

    if ($form_length["price"] > 9999999999) {
        $error["price"] = "length_error";
    }

    /*------------------在庫バリデーション------------------*/

    $form_length["stock"] = mb_strlen($form_add["stock"]);

    if ($form_length["stock"] > 9999) {
        $error["stock"] = "length_error";
    }

    /*------------------説明バリデーション------------------*/

    $form_length["setumei"] = mb_strlen($form_add["setumei"]);

    if ($form_length["setumei"] > 255) {
        $error["setumei"] = "length_error";
    }

    /*------------------詳細バリデーション------------------*/

    $form_length["syousai"] = mb_strlen($form_add["syousai"]);

    if ($form_length["setumei"] > 255) {
        $error["syousai"] = "length_error";
    }

    /*------------------画像バリデーション------------------*/

    if ($image["name"] !== "" && $image["error"] === "") {
        $type = mime_content_type($image["tmp_name"]);
        var_dump($type);
    }
}


// $db = dbconnect();
// $stmt = $db->prepare("insert into items(name,price,stock,jenre_id,setumei,syousai,picture)
//                         values(?,?,?,?,?,?,?)");

// if (!$stmt) {
//     die($db->error);
// }

// $stmt->bind_param("siiisss",$_POST["name"],$_POST["price"],$_POST["stock"],$_POST[""])




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
        <h2>商品追加</h2>
        <span>追加する商品の情報を入力してください</span>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
    <!-- inputにクラスとかnameとかつけて情報取得してください -->
        <div class="admin_form">
            <p>商品名　<span class="badge bg-danger">必須</span></p>
            <input type="text" name="name" required> 
            
            <p>価格　<span class="badge bg-danger">必須</span></p>
            <input type="text" name="price" required>円

            <p>個数　<span class="badge bg-danger">必須</span></p>
            <input type="text" name="stock" required>

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
            <input type="file" name="picture" required>

            <p>商品説明　<span class="badge bg-danger">必須</span></p>
            <textarea name="setumei" required>
            </textarea>

            <p>詳細情報　<span class="badge bg-danger">必須</span></p>
            <textarea name="syousai" required>
            </textarea>
        </div>

        <div class="admin_button_matome">
            <a type="button" class="btn btn-primary" onclick="location='kanri_top.php'">戻る</a>
            <!-- shouhin_kakunin.phpへ -->
            <button type="submit" class="btn btn-primary">追加する</button>
        </div>
    </form>
</body>
</html>