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


if(isset($_POST['review_del'])==true){
    $sqls='delete from reviews where id=?';
    $itemid=$_POST['review_del'];
    $stmts =$db ->prepare($sqls);
    $stmts->bind_Param("s",$itemid);
    $stmts->execute();
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

        <style type="text/css">

            @media screen and (min-width:960px) {
                .table_m {
                    margin: 10px 100px 0;
                }

            }

        </style>

    </head>
    <body >


        <div class="kanri_top">
            <h1>管理画面</h1>
            <div class="admin_button">
                <button type="button" onclick="location='../login/logout.php'">ログアウト</button>
                <button type="button" onclick="location='kanri_top.php'">TOP</button>
            </div>
        </div>
        <div class="admin_subtitle">
            <h2>登録者情報</h2>
            <span>コメント一覧</span>
            </div>
            <div class="table_m" style="text-align:center;">
            <?php


if(isset($_POST['kutikomi_jump'])):
    $n = $_POST['kutikomi_jump'];

    echo 'ID:' . $n . '<br>';
    $sql='select * from reviews where user_id='.$n.'';
    $stmt=$db->query($sql);
?>
<?php
$sql3='select count(*) from reviews where user_id = '.$n.'';
$stmt3=$db->query($sql3);
$rec3=$stmt3->fetch_assoc();
// print_r($rec3);

if($rec3['count(*)']>0):

?>
        <table style="table-layout: fixed; width:100%">
            <tbody>
                <tr class="admin_item_title" >
                    <th></th>
                    <th>ID</th>
                    <th>コメント</th>
                    <th>星</th>
                    <th>商品名</th>
                    <th>日時</th>
                </tr>
            </div>
            <!-- </div> -->
            <!-- 下みたいにタグコピペして商品情報出力してください。 -->
            <!-- メモ：長さ違うとレイアウトぐちゃぐちゃになる。どうしたらいいかわからん
            top.phpから引っ張ってテーブルをwhileで回してください。携帯画面のcssは暇があったら作ってください。 -->
            <!-- <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
            <p><span>日時</span><span>商品名</span><span>aaaaaaaa</span><span>販売数</span><span>在庫数</span>
            <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span>
            <p><span>日時</span><span>商品名</span><span>価格</span><span>販売数</span><span>在庫数</span> -->


            <?php

        // if($rec=$stmt->fetch_assoc()):
// print_r($rec);
            while($rec=$stmt->fetch_assoc()):
                $sql2='select price from  history right outer join users on history.user_id = users.id';
                $sql2='select name from  items where id = '.$rec['item_id'].'';
                $stmt2=$db->query($sql2);
                // print_r($rec);
                $rec2=$stmt2->fetch_assoc()
                            // print_r($rec2);
                            ?>
                            <tr class="admin_item" style="overflow-wrap : break-word;">
                                <form method="POST" action="">
                                    <td>
                                        <?php //echo $rec['id']; ?>
                                        <input type="radio"  name="review_del" value="<?php echo $rec['id']; ?>">
                                    </td>
                                    <td><?php echo $rec['id']; ?></td>
                                    <td><?php echo $rec['comment']; ?></td>
                                    <td><?php echo $rec['star']; ?></td>
                                   <?php if(isset($rec2['name'])): ?>
                                    <td><?php echo $rec2['name']; ?></td>
                                    <?php else: ?>
                                        <td>削除された商品です</td>
                                        <?php endif; ?>
                                    <td><?php echo $rec['created']; ?></td>
                                </tr>

                                <?php //endif; ?>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="admin_button_matome">
                    <a href="user_sanshou.php" class="btn btn-primary">戻る</a>
                    <input type="hidden" name="kutikomi_jump" value="<?php echo $n; ?>">
                    <input type="submit" class="btn btn btn-danger" value="削除する">
                </div>
                </form>
                <?php else: ?>
                    <p>レビューがありません</p><br>
                    <a href="user_sanshou.php" class="btn btn-primary">戻る</a>
                <?php endif; ?>
                    <?php else: ?>
                        <p> ユーザーが選択されていません。</p><br>
                        <a href="user_sanshou.php" class="btn btn-primary">戻る</a>
                    <?php endif; ?>

                    </body>
                    </html>
