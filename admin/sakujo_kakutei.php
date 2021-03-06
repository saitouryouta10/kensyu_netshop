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


$delete = $_SESSION["delete"];

foreach($delete as $del){
    $db = dbconnect();
    // echo $del;
    $stmt = $db->prepare("delete from items where id=?");
    if(!$stmt){
        echo "エラーだよ！";
        die($db->error);
    }
    $stmt->bind_param("i",$del);
    $success = $stmt->execute();
    if(!$success){
        echo "エラーじゃ！";
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
        <p>削除しました</p>
    </div>
    </div>
    <div class="admin_button_matome">
            <button type="button" class="btn btn-primary admin_yes" onclick="location.href='kanri_top.php'">管理画面にもどる</button>
    </div>
</body>
</html>