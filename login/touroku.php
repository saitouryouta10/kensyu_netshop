<?php
session_start();

require('../library.php');

if(isset($_SESSION["form"])){
    $form = $_SESSION["form"];
}else{
    header("Location: sinki_touroku.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $password = password_hash($form["pass"],PASSWORD_DEFAULT);

    $db = dbconnect();

    $stmt = $db->prepare("insert into users(name,name_kana,nickname,sex,birthday,zipcode,address,tell,email,pass)
                        VALUES(?,?,?,?,?,?,?,?,?,?)");
    
    if(!$stmt){
        header("Location: sinki_touroku.php");
        // echo "a";
        exit();
    }


    // $stmt->bind_param("s",$form["name"]);


    //FIXME なんでかSQL文がうまく実行できない =>解決した。dateに何も入れていないときにNULLを手動でいれてあげた
    $stmt->bind_param("sssissssss",$form["name"],$form["name_kana"],$form["nickname"],$form["sex"],$form["birthday"],$form["zipcode"],
                        $form["address"],$form["tell"],$form["email"],$password);
    
    //  var_dump($form["name"]);
    //  var_dump($form["name_kana"]);
    //  var_dump($form["nickname"]);
    //  var_dump($form["sex"]);
    //  var_dump($form["birthday"]);
    //  var_dump($form["zipcode"]);
    //  var_dump($form["address"]);
    //  var_dump($form["tell"]);
    //  var_dump($password);

    $success = $stmt->execute();
    if(!$success){
        echo "i";
        // header("Location: sinki_touroku.php");
        exit();
    }else{
        //成功した場合はセッションの削除
        //新規登録画面に戻った時セッションがあるので情報が入っちゃうから
        unset($_SESSION["form"]);
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
    <h2 class="kakutei_title">HOGEHOGE SHOP</h2>
    <div class="touroku_container">
        <div class="touroku_back">
            <h1>ようこそ</h1>
            <p class="touroku_setumei">この度はHOGEHOGE SHOPアカウントを作成していただきありがとうございます。<br>
                <span>このアカウントを利用して商品を購入したり、購入履歴をみたりできます。<br>
                快適なお買い物LIFEを。</span></p>
            <div class="touroku_login">
                <button class="btn btn-success" onclick="location.href='login.php'">ログインする</button>
            </div>
        </div>
    </div>
    <p class="touroku_copy">© 2022 Kensyu_netshop<p>
</body>
</html>