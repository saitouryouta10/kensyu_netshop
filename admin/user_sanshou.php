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


$sql='select * from users';
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
        <h2>登録者情報</h2>
        <span>登録者情報参照</span>
    </div>

        <table class="admin_item_title">
	<tbody>
		<tr>
            <th></th>
			<th>ID</th>
			<th>名前</th>
			<th>購入金額</th>
			<th>購入回数</th>
			<th>レビュー数</th>
		</tr>

        <!-- 下みたいにタグコピペして商品情報出力してください。 -->
        <!-- メモ：長さ違うとレイアウトぐちゃぐちゃになる。どうしたらいいかわからん
            top.phpから引っ張ってテーブルをwhileで回してください。携帯画面のcssは暇があったら作ってください。 -->
        <!-- <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
        <p><span>日時</span><span>商品名</span><span>aaaaaaaa</span><span>販売数</span><span>在庫数</span>
        <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
        <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span> -->
        <?php
while($rec=$stmt->fetch_assoc()):
    $sql2='select sum(price) from  history where user_id = '.$rec['id'].'';
    $sql3='select count(*) from history where user_id = '.$rec['id'].'';
    $sql4='select count(*) from reviews where user_id = '.$rec['id'].'';
    $stmt2=$db->query($sql2);
    $stmt3=$db->query($sql3);
    $stmt4=$db->query($sql4);
    if($rec2=$stmt2->fetch_assoc()):
        if($rec3=$stmt3->fetch_assoc()):
            if($rec4=$stmt4->fetch_assoc()):
    // print_r($rec);
    // print_r($rec2);
    // print_r($rec3);
    // print_r($rec4);
    ?>
        <tr class="admin_item">
            <form method="POST" action="user_review.php">
            <td>
            <?php echo $rec['id']; ?>
                        <input type="radio"  name="kutikomi_jump" value="<?php echo $rec['id']; ?>">
                    </td>
                    <td><?php echo $rec['id']; ?></td>
                    <td><?php echo $rec['name']; ?></td>
                    <td><?php echo $rec2['sum(price)']; ?></td>
                    <td><?php echo $rec3['count(*)']; ?></td>
                    <td><?php echo $rec4['count(*)']; ?></td>
		</tr>
        <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>
        <?php endwhile; ?>
    </tbody>
</table>

    <div class="admin_button_matome">
        <a href="kanri_top.php" class="btn btn-primary">戻る</a>
        <input type="submit" class="btn btn-primary" value="口コミ">
    </form>
    </div>
</body>
</html>
