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

    // $stmt = $db->prepare("insert into users(name,name_kana,nickname,sex,birthday,zipcode,address,tell,email,pass)
    //                     VALUES(?,?,?,?,?,?,?,?,?,?)");

    $stmt = $db->prepare("update users set name = 'tarou' where id=2");

    
    if(!$stmt){
        // header("Location: sinki_touroku.php");
        echo "a";
        exit();
    }


    // $stmt->bind_param("s",$form["name_kana"]);


    //FIXME なんでかSQL文がうまく実行できない
    // $stmt->bind_param("sssissssss",$form["name"],$form["name_kana"],$form["nickname"],$form["sex"],$form["birthday"],$form["zipcode"],
    //                     $form["address"],$form["tell"],$form["email"],$password);
    
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
    <title>HOGEHOGE SHOP</title>
</head>
<body>
    登録しました。
    <button onclick="location.href='login.php'">ログインする</button>
</body>
</html>