<?php
require("../library.php");
session_start();


$form_add = $_SESSION["form_add"];
$filtername = $_SESSION["image"];

$db = dbconnect();
$stmt = $db->prepare("insert into items(name,price,stock,jenre_id,setumei,syousai,picture)
                        values(?,?,?,?,?,?,?)");

if (!$stmt) {
    die($db->error);
}

$stmt->bind_param("siiisss",$form_add["name"],$form_add["price"],$form_add["stock"],
                            $form_add["jenre_id"],$form_add["setumei"],$form_add["syousai"],$filtername);

$success = $stmt->execute();
if(!$stmt) {
    die($db->error);
}else {
    unset($_SESSION["form_add"]);
    unset($_SESSION["image"]);
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
    <div class="admin_kakunin">
        <p>追加しました</p>
    </div>
    </div>
    <div class="admin_button_matome">
            <a type="button" class="btn btn-primary admin_yes" onclick="location='kanri_top.php'">管理画面にもどる</a>
    </div>
</body>
</html>