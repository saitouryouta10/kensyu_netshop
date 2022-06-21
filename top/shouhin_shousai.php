<?php
require('../library.php');
$db =dbconnect();
session_start();
$item_id=$_GET['id'];

header_inc();

$login=1;

if(isset($_SESSION["id"])){
  //セッション情報がある場合は普通に画面遷移
  $userid=$_SESSION['id'];
  if(isset($_SESSION['nickname'])){
  $name = $_SESSION['nickname'];
  }
}else{

    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
 header('Location:../login/login.php?login='.$login.'');
   exit();

}

// var_dump($name);
$userid=$_SESSION['id'];

//カートに入れる数を決める
if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];

}else{
  $kazuerabi=null;
}

if(isset($_SESSION['cart'])==true){
  $cart=$_SESSION['cart'];
}

// $cart[]=$item_id;
// $_SESSION['cart']=$cart;



//メッセージの投稿
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['com_id'])==true){
    $com_id=$_POST['com_id'];
    //  echo $com_id;
    $sqls='delete from reviews where id=?';
    $stmts =$db ->prepare($sqls);
    $stmts->bind_Param("i",$com_id);
    $stmts->execute();

    }elseif(isset($_POST['star'])==true){
    $comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
    $star = filter_input(INPUT_POST,'star',FILTER_SANITIZE_STRING);

    $stmt = $db->prepare('insert into reviews (comment,user_id,star,item_id) values(?,?,?,?)');

    $stmt->bind_param('siii',$comment,$userid,$star,$item_id);
    $succsess = $stmt->execute();
    if(!$succsess){
        die($db->error);
    }
    header('Location: ');
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<main>
  <!-- <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a> -->

<?php
$sql = 'select * from items where id='.$item_id.'';
$stmt =$db ->query($sql);



if($rec=$stmt->fetch_assoc()):

// print_r($rec);

//if($stmt->fetch()): ?>
 <div class="container">
<div class="s_main">
  <div class="shouhin_img">
    <?php if($rec['picture']): ?>
        <img src="./img/<?php echo h($rec['picture']); ?>" >
        <?php else: ?>
          <img src="./img/noimage.png" >
          <?php endif ;?>
        </div>
     <div>
      <p><?php echo h($rec['name']); ?><span class="name"></p>
      <p><?php echo h($rec['price']); ?>円</span></p>

      <?php if($rec['stock'] >0): ?>


         <form action="" method="POST">
          <select name="kazuerabi" >
           <?php for($i=1; $i<=$rec['stock'];$i++):?>
           <option value="<?php echo $i; ?>"><? echo $i; ?>個</option>
           <?php endfor ;?>
          </select>
         <button type="submit"name="cartin_button" class="btn btn-success">カートに入れる</button>
        </form>


     <? else:?>
       <p style="color:red;">在庫がありません</p>
       <?php endif; ?>
          <p style="color:pink">
          <?php if($kazuerabi !==null){
            // カートに入れるボタンが押されたとき,cartデータベースに追加
            if(isset($_POST['cartin_button'])==true){
              $sql2 = 'insert into cart(user_id,item_id,number) values('.$userid.','.$item_id.','.$kazuerabi.')';
              $sql_2='select count(*) from cart where item_id='.$item_id.' and user_id='.$userid.'';
              $stmt_2=$db->query($sql_2);
              $rec2=$stmt_2->fetch_assoc();
              if($rec2['count(*)']==0 ){
              $stmt2 =$db ->query($sql2);
              echo $kazuerabi ."個カートに入れました";
            }else{
              echo 'この商品は既にカートに入っています';
            }
              }
            }


       ?>
        </p>
        <a href="cart.php">カートに行く</a>
        <?php //var_dump($cart); exit(); ?>
      </div>

    </div>
    <p ><?php echo h($rec['setumei']) ; ?></p>
    <p ><?php echo h($rec['syousai']) ; ?></p>


  <div>

<br>
<p class="shousai_r">レビュー<button type="button" onclick="location.href='kutikomi.php?id=<?php echo $item_id;?>';" class="btn btn-success">一覧</button></p>
<br>
<?php


          $stmt= $db->query('select r.comment,r.star,r.created, r.user_id from reviews r where item_id='.$item_id.'');
          $sql3='select id from reviews where user_id='.$userid.'';
          $sql4='select avg(star) from reviews where item_id='.$item_id.'';
          $s=$db->query($sql4);
          $r=$s->fetch_assoc();
          // print_r($r);
          $stmt3=$db->query($sql3);

          if($r['avg(star)']>0) :?>
          <p>評価平均<?php echo $r['avg(star)'] ;?></p><br>
          <?php elseif($r['avg(star)']==0): ?>
            <p>レビューはまだありません</p><br><br>
          <?php endif; ?>
          <?php

          $result3 = $stmt3->fetch_assoc();
          // $result=$stmt->fetch_assoc();
          // print_r($result['user_id']);

          while($result=$stmt->fetch_assoc()):
          $n= $db->query('select nickname from users where id='.$result['user_id'].'');
          $nr=$n->fetch_assoc();
          ?>
          <div class="msg">
            <p>ユーザー名：<?php echo h($nr['nickname']); ?></p>
            <p>コメント<br></p>
            <?php if($result['comment'] == null): ?>
              <p>なし</p>
              <?php else : ?>
              <?php echo h($result['comment']); ?>
              <?php endif ;?>
              <p>評価<?php echo h($result['star']); ?>&nbsp&nbsp&nbsp<?php echo h($result['created']) ; ?></p>

              <?php if($_SESSION['id'] === $result['user_id']): ?>
                <form action="" method="POST">
                  <input type="hidden" name="com_id" value="<?php echo $result3['id']; ?>">
                  <?php //echo $result3['id']; ?>
                  <button type="submit"class="btn btn-danger">削除</button>
                  <!-- <input type="submit" value="削除"/> -->
                </form>
                <?php endif; ?>

                <br>
              </p>
          </div>
          <?php endwhile ; ?>
      </div>



      <?php  else : ?>
        <p>その商品ページは削除されたか、URLが間違えています</p>
        <?php endif; ?>
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
