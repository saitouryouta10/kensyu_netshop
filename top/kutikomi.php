<?php
session_start();
require('../library.php');

$item_id=$_GET['id'];

header_inc();

$login=1;

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

if(isset($_SESSION['id']) && isset($_SESSION['name'])){
    $userid =$_SESSION['id'];
    $name = $_SESSION['name'];
}else{
    header('Location: login.php');
    exit();
}


$db =dbconnect();

//メッセージの投稿
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['com_id'])==true){
    $com_id=$_POST['com_id'];
    //  echo $com_id;
    $sqls='delete from reviews where id=?';
    $stmts =$db ->prepare($sqls);
    $stmts->bind_Param("i",$com_id);
    $stmts->execute();

    }else{
    $comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
    $star = filter_input(INPUT_POST,'star',FILTER_SANITIZE_STRING);

    $stmt = $db->prepare('insert into reviews (comment,user_id,star,item_id) values(?,?,?,?)');

    $stmt->bind_param('siii',$comment,$userid,$star,$item_id);
    $succsess = $stmt->execute();
    if(!$succsess){
        die($db->error);
    }
    header('Location: kutikomi.php?id='.$item_id.'');
    exit();
  }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ひとこと掲示板</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
  <!-- <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a> -->
<div id="wrap">
    <div id="head">
        <h1>レビュー一覧</h1>
    </div>
    <div id="content">
        <div style="text-align: right"><a href="shouhin_shousai.php?id=<?php echo $item_id;?>">商品画面に戻る</a></div>
        <br>

        <?php $sql='select count(*) from reviews where user_id='.$userid.' and item_id='.$item_id.'';
            $stmtc= $db->query($sql);
            $recc =$stmtc->fetch_assoc();
            // print_r($recc);
            ?>
            <?php if($recc['count(*)']==0): ?>
              <form action="" method="post">
                  <dl>
                      <dt><?php echo h($name); ?>さん、メッセージをどうぞ</dt>
                      <dd>
                          <textarea name="comment" cols="50" rows="5"></textarea>
                      </dd>
                  </dl>
                  <p>評価（5段階）</p>
                  <select name="star" id="">
                    <?php for($i=1;$i<6;$i++): ?>
                      <option value="<?php echo $i ?>"><?php echo $i; ?></option>
                      <?php endfor ; ?>
                  </select>
                  <br>
                  <br>
                  <div>
                      <p>
                          <button type="submit"class="btn btn-success">投稿する</button>
                          <!-- <input type="submit" value="投稿する"/> -->
                      </p>
                  </div>
                </form>
          <?php endif; ?>

        <?php
        $stmt1= $db->query('select r.comment,r.star,r.created,r.user_id from reviews r where item_id='.$item_id.'');
        $sql3='select id from reviews where item_id='.$item_id.'';
        $stmt3=$db->query($sql3);
        // if(!$stmt){
        //     die($db->error);
        // }
        // $succsess = $stmt->execute();
        // if(!$succsess){
        //     die($db->error);
        // }

        while($result2=$stmt1->fetch_assoc()):
        // print_r($result2);
        ?>
            <?php $result3 = $stmt3->fetch_assoc(); ?>
            <?php echo $result2['user_id']. $_SESSION['id']; ?>
        <div class="msg">
            <p><?php echo h($result2['comment']); ?><br><span class="name"><?php echo h($name); ?></span></p>
            <p>評価<?php echo h($result2['star']); ?></p>
            <p class="day"><a href="view.php?id=<?php echo h($id); ?>"><?php echo h($result2['created']) ; ?></a>

            <?php if($_SESSION['id'] == $result2['user_id']): ?>
              <form action="" method="POST">
              <input type="hidden" name="com_id" value="<?php echo $result3['id']; ?>">
              <?php echo $result3['id']; ?>
              <button type="submit"class="btn btn-danger">削除</button>
                <!-- <input type="submit" value="削除"/> -->
              </form>

                <?php endif; ?>
            </p>
        </div>
        <?php endwhile; ?>

    </div>
</div>

<?php
footer_inc();
?>

</body>

</html>
