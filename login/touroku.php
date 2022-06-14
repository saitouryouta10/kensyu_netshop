<?php
session_start();
session_regenerate_id();

require('../library.php');

if(isset($_SESSION["form"])){
    $form = $_SESSION["form"];
}else{
    header("Location: sinki_touroku.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $db = dbconnect();

    $stmt = $db->prepare("insert into users(name,name_kana,nickname,sex,birthday,zipcode,address,tell,email,pass)
                        VALUES(?,?,?,?,?,?,?,?,?,?)");
    if(!$stmt){
        die($db->error);
    }
    $stmt->bind_param("sssissssss",$form["name"],$form["name_kana"],$form["nickname"],$form["sex"],$form["birthday"],$form["zipcode"],
                        $form["address"],$form["tell"],$form["email"],$form["pass"]);
    
    $success = $stmt->execute();
    if(!$success){
        die($db->error);
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
    <button onclick="location.href='#'"></button>
</body>
</html>