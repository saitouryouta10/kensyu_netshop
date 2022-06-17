<?php
session_start();
require('../library.php');

if(isset($_SESSION['id']) && isset($_SESSION['name'])){
    $userid =$_SESSION['id'];
    $name = $_SESSION['name'];
}else{
    header('Location: login.php');
    exit();
}

if(isset($_SESSION['star'])){
  $star=$_SESSION['star'];
}
$db =dbconnect();

//メッセージの投稿
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);

    $stmt = $db->prepare('insert into reviews (comment, user_id,star) values(?,?,?)');

    $stmt->bind_param('sii',$comment,$userid,$star);
    $succsess = $stmt->execute();
    if(!$succsess){
        die($db->error);
    }
    header('Location: index.php');
    exit();
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
    <link rel="stylesheet" href="styles.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
<div id="wrap">
    <div id="head">
        <h1>口コミ</h1>
    </div>
    <div id="content">
        <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
        <form action="" method="post">
            <dl>
                <dt><?php echo h($name); ?>さん、メッセージをどうぞ</dt>
                <dd>
                    <textarea name="comment" cols="50" rows="5"></textarea>
                </dd>
            </dl>
            <select name="star" id="">
              <?php for($i=1;$i<6;$i++): ?>
                <option value="<?php $i ?>"></option>
            </select>
            <div>
                <p>
                    <input type="submit" value="投稿する"/>
                </p>
            </div>
        </form>
        <?php
        $stmt= $db->prepare('select r.comment,r.star,r.created from reviews r');
        if(!$stmt){
            die($db->error);
        }
        $succsess = $stmt->execute();
        if(!$succsess){
            die($db->error);
        }

        $stmt->bind_result($comment,$star,$created);
        while($stmt->fetch()): ?>
        <div class="msg">
            <?php if($comment): ?>
            <img src="member_picture/<?php echo h($comment); ?>" width="48" height="48" alt=""/>
            <?php endif ;?>
            <p><?php echo h($comment); ?><span class="name">（<?php echo h($name); ?>）</span></p>
            <p class="day"><a href="view.php?id=<?php echo h($id); ?>"><?php echo h($created) ; ?></a>
            <?php if($_SESSION['id'] === $userid): ?>
                [<a href="delete.php?id=<?php echo h($id); ?>" style="color: #F33;">削除</a>]
                <?php endif; ?>
            </p>
        </div>
        <?php endwhile ; ?>
    </div>
</div>
</body>

</html>
