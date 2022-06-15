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
        exit();
    }
    $stmt->bind_param("sssissssss",$form["name"],$form["name_kana"],$form["nickname"],$form["sex"],$form["birthday"],$form["zipcode"],
                        $form["address"],$form["tell"],$form["email"],$password);
    
    $success = $stmt->execute();
    if(!$success){
        header("Location: sinki_touroku.php");
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