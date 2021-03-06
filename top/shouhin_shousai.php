<?php
require('../lib/DBController.php');
require('../library.php');
// $db =dbconnect();
$db = new DBController;

session_start();

$item_id='';

// 商品IDにより商品ページを表示、バリデーション
if(isset($_GET['id'])){
  $item_id=$_GET['id'];
}
  if(!preg_match('/^([0-9]{1,100})$/',$item_id)) {
    echo '入力したURLが当サイトのページと一致しません';
    echo '<br><a href="./top.php">トップに戻る</a>';
    exit();
  }

$login=1;


// var_dump($name);
if(isset($_SESSION["id"])){
  //セッション情報がある場合は普通に画面遷移
  $userid=$_SESSION['id'];
  if(isset($_SESSION['name'])){
  $name = $_SESSION['name'];
  }
}else{

    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
 header('Location:../login/login.php?login='.$login.'');
   exit();

}


//カートに入れる数を決める
if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];
  $_SESSION["num"] = $kazuerabi;
  // var_dump($_SESSION["number"]);
  // exit();
}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
  $cart=$_SESSION['cart'];
}

// $cart[]=$item_id;
// $_SESSION['cart']=$cart;



// メッセージの投稿 削除
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['com_id'])==true){
    $com_id=$_POST['com_id'];
    //  echo $com_id;
    $sqls='delete from reviews where id=?';
    $db->insert_query($sqls,'i',$com_id);
    }elseif(isset($_POST['star'])==true){
    $comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
    $star = filter_input(INPUT_POST,'star',FILTER_SANITIZE_STRING);
    $sqlc='insert into reviews (comment,user_id,star,item_id) values(?,?,?,?)';
    $db->insert_query($sqlc,'siii',$comment,$userid,$star,$item_id);
    header('Location: ');
    exit();
  }
}
// if($_SERVER['REQUEST_METHOD'] === 'POST'){
//   if(isset($_POST['com_id'])==true){
//     $com_id=$_POST['com_id'];
//     //  echo $com_id;
//     $sqls='delete from reviews where id=?';
//     $stmts =$db ->prepare($sqls);
//     $stmts->bind_Param("i",$com_id);
//     $stmts->execute();

//     }elseif(isset($_POST['star'])==true){
//     $comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
//     $star = filter_input(INPUT_POST,'star',FILTER_SANITIZE_STRING);

//     $stmt = $db->prepare('insert into reviews (comment,user_id,star,item_id) values(?,?,?,?)');

//     $stmt->bind_param('siii',$comment,$userid,$star,$item_id);
//     $succsess = $stmt->execute();
//     if(!$succsess){
//         die($db->error);
//     }
//     header('Location: ');
//     exit();
//   }
// }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-商品詳細</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<header>
  <?php header_inc(); ?>
</header>
<main>


<!-- 商品詳細を表示 -->
  <div class="container">
<?php
$sql = 'select * from items where id='.$item_id.'';
$rec= $db->executeQuery($sql, $types = null);
print_r($rec);
if($rec):

// print_r($rec);

//if($stmt->fetch()): ?>
 <p>商品詳細</p>
 <div class="btn-modoru-rireki">
    <a class="btn btn-outline-secondary btn-block" href="../top/top.php">トップに戻る</a>
</div>
<div class="s_main">
  <div class="shouhin_img">
    <?php if($rec[0]['picture']): ?>
        <img src="./img/<?php echo h($rec[0]['picture']); ?>" >
        <?php else: ?>
          <img src="./img/noimage.png" >
          <?php endif ;?>
        </div>
     <div class="shousai_name">
      <p><?php echo h($rec[0]['name']); ?><span class="name"></p>
      <div class="shousai_price">

        <p><?php echo h($rec[0]['price']); ?>円</span></p>

        <?php if($rec[0]['stock'] >0): ?>

<div>

  <form action="" method="POST">
    <select name="kazuerabi" >
      <?php for($i=1; $i<=$rec[0]['stock'];$i++):?>
        <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
        <?php endfor ;?>
      </select>
    </div>
    <div class="shousai_b">
      <button type="submit"name="cartin_button" class="btn btn-success">カートに入れる</button>
    </form>

    <p style="color:pink; margin-top:0">
      <?php if($kazuerabi !==null){
        // カートに入れるボタンが押されたとき,cartデータベースに追加
        if(isset($_POST['cartin_button'])==true){
          $sql2 = 'insert into cart(user_id,item_id,number) values('.$userid.','.$item_id.','.$kazuerabi.')';
          $sql_2='select count(*) from cart where item_id='.$item_id.' and user_id='.$userid.'';
          $rec2= $db->executeQuery($sql_2, $types = null);
          // print_r($rec2);
          if($rec2[0]['count(*)']==0 ){
            $db->insert_query($sql2, $types = null);
            echo $kazuerabi ."個カートに入れました";
          }else{
            echo '追加済み';
          }
        }
      }
      ?>
      </div>
      <!-- 在庫がない場合数量選択、カートへの追加不可 -->
          <? else:?>
            <p style="color:red;">在庫がありません</p>
            <?php endif; ?>
        </p>
      </div>


      <form action="" method="POST">
        <div class="shousai_b">
          <button type="submit"name="favorite_button" class="btn btn-warning">お気に入りに追加</button>
        </form>

        <p style="color:pink; margin-top:0">
        <?php
            // お気に入りに追加ボタンが押されたとき,favoriteデータベースに追加
            if(isset($_POST['favorite_button'])==true){
              $sql3 = 'insert into favorite(user_id,item_id) values('.$userid.','.$item_id.')';
              $sql_3='select count(*) from favorite where item_id='.$item_id.' and user_id='.$userid.'';


              $rec3= $db->executeQuery($sql_3, $types = null);
              if($rec3[0]['count(*)']==0 ){
                $db ->insert_query($sql3,$types = null);
                echo "お気に入りに追加しました";
              }else{
                echo '追加済み';
              }
            }
            ?>
    </p>
      </div>

        <a href="cart.php">カートに行く</a>
        <?php //var_dump($cart); exit(); ?>
      </div>

    </div>
    <h5>商品説明</h5>
    <p ><?php echo h($rec[0]['setumei']) ; ?></p>
    <h5 style="margin-top:20px">商品詳細</h5>
    <p ><?php echo h($rec[0]['syousai']) ; ?></p>


  <div>

  <!-- 商品レビューを表示 -->
<br>
<p class="shousai_r">レビュー<a type="button" href="kutikomi.php?id=<?php echo $item_id;?>" class="btn btn-success">一覧</a></p>
<br>
<?php


          $rv= $db->executeQuery('select r.comment,r.star,r.created, r.user_id from reviews r where item_id='.$item_id.'',$types = null);
          $sql4='select id from reviews where user_id='.$userid.'';
          $sql5='select avg(star) from reviews where item_id='.$item_id.'';
          $r= $db->executeQuery($sql5, $types = null);

          $rec4=$db->executeQuery($sql4, $types = null);

          // 評価の平均を表示、評価がない場合レビューがないと表示
          if($r[0]['avg(star)']>0) :?>
          <p>評価平均<?php echo $r[0]['avg(star)'] ;?></p><br>
          <?php elseif($r[0]['avg(star)']==0): ?>
            <p>レビューはまだありません</p><br><br>
          <?php endif; ?>
          <?php

          // $result=$stmt->fetch_assoc();

          foreach($rv as $value):
            // print_r($value);
          $nr= $db->executeQuery('select nickname from users where id='.$value['user_id'].'', $types = null);

          ?>
          <div class="msg" style="width:100%; word-wrap: break-word;">
            <p style="border-top:solid 2px lightgray;">ユーザー名：<?php echo h($nr[0]['nickname']); ?></p>
            <p>コメント<br></p>
            <?php if($value['comment'] == null): ?>
              <p>なし</p>
              <?php else : ?>
                <p>
                  <?php echo h($value['comment']); ?>
                </p>
              <?php endif ;?>
              <p>評価<?php echo h($value['star']); ?>&nbsp&nbsp&nbsp<?php echo h($value['created']) ; ?></p>

              <?php if($_SESSION['id'] == $value['user_id']): ?>
                <form action="" method="POST">
                  <input type="hidden" name="com_id" value="<?php echo $rec4[0]['id']; ?>">
                  <?php //echo $result3['id']; ?>
                  <button type="submit"class="btn btn-danger">削除</button>
                  <!-- <input type="submit" value="削除"/> -->
                </form>
                <?php endif; ?>

                <br>
              </p>
          </div>
          <?php endforeach ; ?>
      </div>


      <!-- 存在しない商品IDを入力された場合のコメント -->
      <?php  else : ?>
        <p>その商品ページは削除されたか、URLが間違えています</p>
        <a class="btn btn-outline-secondary btn-block" href="../top/top.php">トップに戻る</a>
        <?php endif; ?>
    </div>
    </div>
    </div>
    </div>
      </main>
      <footer>
<?php
footer_inc();
?>
</footer>

  </body>
  </html>
