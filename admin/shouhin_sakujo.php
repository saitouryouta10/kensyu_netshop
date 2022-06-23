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


$sales = 0;

$reslt = "";
$error = "";

$db = dbconnect();
$resluts = $db->query("select * from items order by id desc");
// $shine = $db->query("select retention_stock from items");
if(!$resluts){
    die($db->error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["select"])){
        $_SESSION["delete"] = $_POST["select"];
        // var_dump($_SESSION["delete"]);
        // exit();
        header("Location: sakujo_kakunin.php");
        exit();
    }else {
        $error = "null";
    }

}




?><!DOCTYPE html>
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
        <h2>削除する商品を選択してください</h2>
        <span>出品商品情報</span><br>
        <?php if($error === "null"):?>
            <span style="color: red; font-size: 1.25rem;">削除するのを選択しろ</span>
        <?php endif;?>
    </div>
    <form action="" method="post">
        <div class="admin_item">
            <table>
            <tbody>
                <tr class="admin_itemtitle">
                    <th>日時</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>販売数</th>
                    <th>在庫数</th>
                </tr>
                <?php while ($reslut = $resluts->fetch_assoc()):?>
                    <?php $rs = h((int)$reslut["retention_stock"]);?>
                    <?php $st = h((int)$reslut["stock"]);?>
                    <?php $sales = $rs - $st;?>
                    <tr>
                        <td>
                            <input type="checkbox" name="select[]" value="<?php echo h($reslut["id"]);?>">
                            <?php echo h($reslut["created"]);?>
                        </td>
                        <td><?php echo h($reslut["name"]);?></td>
                        <td><?php echo h($reslut["price"]);?></td>
                        <td><?php echo $sales?></td>
                        <td><?php echo $st;?></td>
                    </tr>
                <?php endwhile;?>
            </tbody>
            </table> 
        </div>

    <div class="admin_button_matome">
        <a type="button" class="btn btn-primary" onclick='location.href="kanri_top.php"'>戻る</a>
        
        
        <!-- sakujo_kakunin.phpへ -->
        <button type="subtmit" class="btn btn-primary">削除</button>
    </div>
    </form>
</body>
</html>