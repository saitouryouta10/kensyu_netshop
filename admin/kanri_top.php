<?php
require("../library.php");
session_start();

//ジャンプ防御
if (isset($_SESSION["id"])){
    if($_SESSION["id"] !== 1){
        header("Location: ../top/top.php");
    }
}else{
    header("Location: ../top/top.php");
}


$db = dbconnect();

// $stmt = $db->prepare("select created,name,price,stock from items")
$sql='select * from items order by created desc';
$sql2='select price from  history right outer join users on history.user_id = users.id';
$stmt=$db->query($sql);


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
                    <h2>管理者画面TOP</h2>
                    <span>出品商品情報</span>
                    <span>&nbsp最近の出品</span>
                </div>

                <table class="admin_item_title">
                    <tbody>
                        <tr>
                            <!-- <th></th> -->
                            <th>日時</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>販売数</th>
                            <th>在庫数</th>
                            </tr>
                            <?php
                        for($i=0;$i<3;$i++):
                            if($rec=$stmt->fetch_assoc()):
                            ?>
                           <!-- 在庫保持カラムをintにキャストして変数に代入 -->
                           <?php $rs = h((int)$rec["retention_stock"]);?>

                            <!-- 現在の在庫カラムをintにキャストして変数に代入 -->
                            <?php $st = h((int)$rec["stock"]);?>

                            <!-- 元の在庫から現在の在庫を引いた数(販売数)を変数に代入 -->
                            <?php $sales = $rs - $st;?>
                             <tr class="admin_item">
                                </td>
                                <td><?php echo $rec['created']; ?></td>
                                <td><?php echo $rec['name']; ?></td>
                                <td><?php echo $rec['price']; ?></td>
                                <td><?php echo $sales; ?></td>
                                <td><?php echo $rec['stock']; ?></td>
                            </tr>
                            <?php endif; ?>
<?php endfor; ?>
</tbody>
</table>

<div class="admin_button_matome">
    <button type="button" class="btn btn-primary" onclick="location='shouhin_itiran.php'">過去の出品</button>
    <button type="button" class="btn btn-primary" onclick="location='jouhou_add.php'">商品追加</button>
    <button type="button" class="btn btn-primary" onclick="location='shouhin_sakujo.php'">商品削除</button>
    <button type="button" class="btn btn-primary" onclick="location='user_sanshou.php'">登録者情報管理</button>
    </div>
    </div>
    </body>
    </html>
