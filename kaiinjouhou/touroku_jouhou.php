<?php
session_start();
require('../library.php');
require('../lib/DBcontroller.php');

$dbc = new DBcontroller();


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    $login = 1;
    //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
    header('Location:../login/login.php?login='.$login.'');
    exit();
}

// var_dump($id);

//$db2 = dbconnect();
$sql = 'select id, name, name_kana, nickname, sex, birthday, zipcode, address, tell, email from users where id=?';
$types = 'i';

$dataArray = $dbc->executeQuery($sql,$types,$id);
if (!$dataArray) {
    die($dbc->error);
}


// $stmt = $dbc->prepare($sql);
// if (!$stmt) {
//     die($dbc->error);
// }
// $stmt->bind_param("i", $id);
// $success = $stmt->execute();
// if (!$success) {
//     die($dbc->error);
// }

//$stmt->bind_result($id, $name, $name_kana, $nickname, $sex, $birthday, $zipcode, $address, $tell, $email);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGEHOGE SHOP-登録情報</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <?php header_inc(); ?>
    </header>

    <main class="kaiin-body">
        <div class="kakunin_container">
            <h2>登録情報</h2>
            <div class="kakunin_value">
                <?php foreach($dataArray as $data) :?>
                    <p>名前<br><?php echo h($data['name']); ?></p>
                    <p>名前（フリガナ）<br><?php echo h($data['name_kana']); ?></p>
                    <p>ニックネーム<br><?php echo h($data['nickname']); ?></p>
                    <p>
                        性別<br><?php h($data['sex']);
                        if(($data['sex'] == 1)) {
                            echo "男性";
                        } else if ( ($data['sex']) == 2) {
                            echo "女性";
                        } else {
                            echo "その他";
                        } ?>
                    </p>

                    <?php if (empty($data['birthday'])) : ?>
                        <p>生年月日<br>登録していません</p>
                    <?php else : ?>
                        <p>生年月日<br><?php echo h($data['birthday']); ?></p>
                    <?php endif; ?>
                    <p style="width:100%; word-wrap: break-word;">
                        住所<br><?php echo h($data['zipcode']); ?><br>
                        <?php echo h($data['address']); ?>
                    </p>
                    <p>電話番号<br><?php echo $data['tell']; ?></p>
                    <p>メールアドレス<br><?php echo h($data['email']); ?></p>
                    </div>
            <?php endforeach; ?>
        </div>
        <div class="btn-pos">
                    <button button class="btn btn-outline-secondary btn-block" onclick="location.href='kaiin_jouhou.php'">戻る</button>
        </div>
    </main>

    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
