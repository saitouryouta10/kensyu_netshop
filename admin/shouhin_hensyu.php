<?php

require("../library.php");
session_start();

if (isset($_SESSION["id"])){
    if($_SESSION["id"] !== 1){
        header("Location: ../top/top.php");
    }
}else{
    header("Location: ../top/top.php");
}


$update = "";
$form_add = [
    "name" => "",
    "price" => "",
    "stock" => "",
    "jenre_id" => "",
    "setumei" => "",
    "syousai" => "",
];

if (isset($_SESSION["old_form_add"])) {
    $old_form_add = $_SESSION["old_form_add"];
}

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

    if ($form_length["name"] > 255) {
        $error["name"] = "length_error";
    }

    /*------------------ジャンルバリデーション------------------*/
    if ($form_add["jenre_id"] === NUll){
        $form_add["jenre_id"] = "0";
    }

    /*------------------値段バリデーション------------------*/

    $match["price"] = preg_match("/[0-9]/",$form_add["price"]);

    $form_length["price"] = mb_strlen($form_add["price"]);

    if ($form_length["price"] > 10) {
        $error["price"] = "length_error";
    }

    if (!$match["price"]) {
        $match_error["price"] = "nomatch";
    }

    /*------------------在庫バリデーション------------------*/

    $match["stock"] = preg_match('/[0-9]/',$form_add["stock"]);

    $form_length["stock"] = mb_strlen($form_add["stock"]);

    if ($form_length["stock"] > 4) {
        $error["stock"] = "length_error";
    }

    if ($match["stock"] !== 1) {
        $match_error["stock"] = "nomatch";
    }

    /*------------------説明バリデーション------------------*/

    $form_length["setumei"] = mb_strlen($form_add["setumei"]);

    if ($form_length["setumei"] > 255) {
        $error["setumei"] = "length_error";
    }

    /*------------------詳細バリデーション------------------*/

    $form_length["syousai"] = mb_strlen($form_add["syousai"]);

    if ($form_length["syousai"] > 255) {
        $error["syousai"] = "length_error";
    }

    /*------------------画像バリデーション------------------*/
    $db = dbconnect();
    $reslts = $db->query("select picture from items");

    if ($reslts){
        while ($reslt = $reslts->fetch_assoc()) {
            // var_dump($image["name"]);
            if($image["name"] === $reslt["picture"] && $old_form_add["id"] === $reslt["id"]) {
                $match_error["image"] = "match";
                // echo "aaaaaaaaaaaaaaaaaaaaa";
            }
        }
    }


    if ($image["name"] !== "" && $image["error"] === 0) {
        // echo "a";
        $type = mime_content_type($image["tmp_name"]);
        if ($type !== "image/png" && $type !== "image/jpeg") {
            $error["image"] = "type_error";
        }
    }

    if(!isset($error) && !isset($match_error)) {

        if(move_uploaded_file($image["tmp_name"], "../top/img/" . $image["name"])) {
            $_SESSION["image"] = $image["name"];
        }else{
            die("画像が指定されていません。");
        }

        $_SESSION["form_add"]= $form_add;

        header("Location: sh_kakutei.php");
        exit();
    }

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
        <h2>商品編集</h2>
        <span>編集する商品の情報を入力してください</span>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
    <!-- inputにクラスとかnameとかつけて情報取得してください -->
        <div class="admin_form">
            
            <p>商品名　<span class="badge bg-danger">必須</span></p>
            <?php if (isset($error["name"]) && $error["name"] === "length_error"):?>
            <span class="error">名前は255文字以内にしてください。</span><br>
            <?php endif;?>
            
            <input type="text" name="name" value="<?php echo h($old_form_add["name"]);?>" required>
            
            <p>価格　<span class="badge bg-danger">必須</span></p>
            <?php if (isset($error["price"]) && $error["price"] === "length_error"):?>
            <span class="error">100億円以上はつけることができません。</span><br>
            <?php endif;?>
            <?php if (isset($match_error["price"]) && $match_error["price"] === "nomatch"):?>
            <span class="error">半角数字で入力してください。</span><br>
            <?php endif;?>
            <input type="text" name="price" value="<?php echo h($old_form_add["price"]);?>" required>円 

            <p>個数　<span class="badge bg-danger">必須</span></p>
            <?php if (isset($error["stock"]) && $error["stock"] === "length_error"):?>
            <span class="error">1万個未満にしてください。</span><br>
            <?php endif;?>
            <?php if (isset($match_error["stock"]) && $match_error["stock"] === "nomatch"):?>
            <span class="error">半角数字で入力してください。</span><br>
            <?php endif;?>
            <input type="text" name="stock" value="<?php echo h($form_add["stock"]);?>" required>個追加     　　　<span>残りの在庫：<?php echo h($old_form_add["stock"]);?>個</span>

            <p>ジャンル</p>
            <span style="color: red;">※選択しなかった場合自動的に[その他]になります</span><br>
            <input type="radio" name="jenre" id="kagu" value="1" <?= $old_form_add["jenre_id"] === "1" ? "checked" : '' ?> >
            <label for="kagu">家具</label>
            
            <input type="radio" name="jenre" id="syokuzai" value="2"  <?= $old_form_add["jenre_id"] === "2" ? "checked" : "" ?> >
            <label for="syokuzai">食材</label>

            <input type="radio" name="jenre" id="gangu" value="3"  <?= $old_form_add["jenre_id"] === "3" ? "checked" : "" ?> >
            <label for="gangu">玩具</label>

            <input type="radio" name="jenre" id="nitiyouhin" value="4"  <?= $old_form_add["jenre_id"] === "4" ? "checked" : "" ?> >
            <label for="nitiyouhin">日用品</label>

            <input type="radio" name="jenre" id="kaden" value="5"  <?= $old_form_add["jenre_id"] === "5" ? "checked" : "" ?> >
            <label for="kaden">家電</label> 
            
            <input type="radio" name="jenre" id="sonota" value="0"  <?= $old_form_add["jenre_id"] === "0" ? "checked" : "" ?> >
            <label for="sonota">その他</label> 

            <p>画像　<span class="badge bg-danger">必須</span></p>
            <?php if (isset($error["image"]) && $error["image"] === "type_error"):?>
            <span class="error">PNGかJPEGにしてください。</span><br>
            <?php endif;?>
            <?php if (isset($match_error["image"]) && $match_error["image"] === "match"):?>
            <span class="error">同じ名前の画像があります。別の名前に変更してください。</span><br>
            <?php endif;?>
            <input type="file" name="picture" required>     　　　<span>前の画像：<?php echo h($old_form_add["picture"]);?></span>

            <p>商品説明　<span class="badge bg-danger">必須</span></p>
            <?php if (isset($error["setumei"]) && $error["setumei"] === "length_error"):?>
            <span class="error">商品説明は255文字以内にしてください。</span><br>
            <?php endif;?>
            <textarea name="setumei" required><?php echo h($old_form_add["setumei"]);?></textarea>

            <p>詳細情報　<span class="badge bg-danger">必須</span></p>
            <?php if (isset($error["syousai"]) && $error["syousai"] === "length_error"):?>
            <span class="error">詳細情報は255文字以内にしてください。</span><br>
            <?php endif;?>
            <textarea name="syousai" required><?php echo h($old_form_add["syousai"]);?></textarea>
        </div>

        <div class="admin_button_matome">
            <a type="button" class="btn btn-primary" onclick='location.href="jouhou_add.php"'>戻る</a>
            <!-- shouhin_kakunin.phpへ -->
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
</body>
</html>