<?php
$form = [];
$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['name'] === '') {
        $error['name'] = 'blank';
    }
    $form['name_kana'] = filter_input(INPUT_POST, 'name_kana', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['name_kana'] === '') {
        $error['name_kana'] = 'blank';
    }
    $form['nickname'] = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['nickname'] === '') {
        $error['nickname'] = 'blank';
    }
    $form['birthday'] = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['birthday'] === '') {
        $error['birthday'] = 'blank';
    }
    $form['zipcode'] = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['zipcode'] === '') {
        $error['zipcode'] = 'blank';
    }
    $form['address'] = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['address'] === '') {
        $error['address'] = 'blank';
    }
    $form['tell'] = filter_input(INPUT_POST, 'tell', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['tell'] === '') {
        $error['tell'] = 'blank';
    }
    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['email'] === '') {
        $error['email'] = 'blank';
    }
}
session_start();
require('../library.php');

if (isset($_SESSION['id'])) {
    $ssid = $_SESSION['id'];
} else {
    header('Location: login.php');
    exit();
}
$id = $ssid;
$db = dbconnect();
$sql = 'select id, name, name_kana, nickname, sex, birthday, zipcode, address, tell, email, pass from users where id=?';
$stmt = $db->prepare($sql);
if (!$stmt) {
    die($db->error);
}
$stmt->bind_param("i", $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}
$stmt->bind_result($id, $name, $name_kana, $nickname, $sex, $birthday, $zipcode, $address, $tell, $email, $pass);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報変更</title>
</head>
<body>

    <h1>登録情報</h1>
    <?php while ( $stmt->fetch() ): ?>
    <form action="" method="post">
        <h3>名前</h3>
        <input type="text" name="name" value="<?php echo h($name); ?>">
        <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
        <p>名前を入力してください</p>
        <? endif; ?>
        <h3>名前（フリガナ）</h3>
        <input type="text" name="name_kana" value="<?php echo h($name_kana); ?>">
        <?php if (isset($error['name_kana']) && $error['name_kana'] === 'blank'): ?>
        <p>フリガナを入力してください</p>
        <? endif; ?>
        <h3>ニックネーム</h3>
        <input type="text" name="nickname" value="<?php echo h($nickname); ?>">
        <?php if (isset($error['nickname']) && $error['nickname'] === 'blank'): ?>
        <p>ニックネームを入力してください</p>
        <? endif; ?>
        <h3>性別</h3>
        <?php if ($sex == 1) : ?>
            <input type="radio" name="sex" id="man" value="1" checked><label for="man">男性</label>
            <input type="radio" name="sex"id="woman" value="2"><label for="woman">女性</label>
            <input type="radio" name="sex"id="others" value="3"><label for="others">その他</label>
        <?php endif; ?>
        <?php if ($sex == 2) : ?>
            <input type="radio" name="sex" id="man" value="1"><label for="man">男性</label>
            <input type="radio" name="sex" id="woman" value="2" checked><label for="woman">女性</label>
            <input type="radio" name="sex" id="others" value="3"><label for="others">その他</label>
        <?php endif; ?>
        <?php if ($sex == 3) : ?>
            <input type="radio" name="sex" id="man" value="1" checked><label for="man">男性</label>
            <input type="radio" name="sex" id="woman" value="2"><label for="woman">女性</label>
            <input type="radio" name="sex" id="others" value="3" checked><label for="others">その他</label>
        <?php endif; ?>

        <h3>生年月日</h3>
        <input type="date" name="birthday" value="<?php echo h($birthday); ?>">
        <h3>〒住所</h3>
        <input type="text" name="zipcode" value="<?php echo h($zipcode); ?>"><br>
        <?php if (isset($error['zipcode']) && $error['zipcode'] === 'blank'): ?>
        <p>郵便番号を入力してください</p>
        <? endif; ?>
        <input type="text" name="address" value="<?php echo h($address); ?>">
        <?php if (isset($error['address']) && $error['address'] === 'blank'): ?>
        <p>住所してください</p>
        <? endif; ?>
        <h3>電話番号</h3>
        <input type="text" name="tell" value="<?php echo $tell; ?>">
        <?php if (isset($error['tell']) && $error['tell'] === 'blank'): ?>
        <p>電話番号を入力してください</p>
        <? endif; ?>
        <h3>メールアドレス</h3>
        <input type="text" name="email" value="<?php echo h($email); ?>">
        <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
        <p>フリガナを入力してください</p>
        <? endif; ?>
        <div>
            <button type="submit" name="info">登録する</button>
        </div>
    </form>
    <?php endwhile; ?>
    <form action="pass_henkou.php" method="post">
        <button type="hidden" name="pass" value="<?php echo h($pass); ?>">パスワードを変更する</button>
    </form>
    <button onclick="location.href='kaiinjouhou_jouhou.php'">戻る</button>



</body>
</html>
