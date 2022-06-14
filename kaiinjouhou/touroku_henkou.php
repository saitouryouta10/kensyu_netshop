<?php
$form = [];
$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['name'] === '') {
        $form['name'] = '';
        $error['name'] = 'blank';
    }
    $form['name_kana'] = filter_input(INPUT_POST, 'name_kana', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['name_kana'] === '') {
        $form['name_kana'] = '';
        $error['name_kana'] = 'blank';
    }
    $form['nickname'] = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['nickname'] === '') {
        $form['nickname'] = '';
        $error['nickname'] = 'blank';
    }
    $form['sex'] = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $form['birthday'] = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['birthday'] === '') {
        $error['birthday'] = 'blank';
    }
    $form['zipcode'] = $_POST['zipcode'];
    if ($form['zipcode'] === '') {
        $error['zipcode'] = 'blank';
    }
    $form['address'] = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['address'] === '') {
        $error['address'] = 'blank';
    }
    $form['tell'] = $_POST['tell'];
    if ($form['tell'] === '') {
        $error['tell'] = 'blank';
    }
    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['email'] === '') {
        $error['email'] = 'blank';
    }

    if (empty($error)) {
        session_start();
        $_SESSION['name'] = $form['name'];
        $_SESSION['name_kana'] = $form['name_kana'];
        $_SESSION['nickname'] = $form['nickname'];
        $_SESSION['sex'] = $form['sex'];
        $_SESSION['birthday'] = $form['birthday'];
        $_SESSION['zipcode'] = $form['zipcode'];
        $_SESSION['address'] = $form['address'];
        $_SESSION['tell'] = $form['tell'];
        $_SESSION['email'] = $form['email'];

        header("Location: check_update.php");
        exit();
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
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="name" value="<?php echo h($form['name']); ?>">
        <?php else : ?>
            <input type="text" name="name" value="<?php echo h($name); ?>">
        <?php endif; ?>
        <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
            <p>名前を入力してください</p>
        <? endif; ?>

        <h3>名前（フリガナ）</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="name_kana" value="<?php echo h($form['name_kana']); ?>">
        <?php else : ?>
            <input type="text" name="name_kana" value="<?php echo h($name_kana); ?>">
        <? endif; ?>
        <?php if (isset($error['name_kana']) && $error['name_kana'] === 'blank'): ?>
            <p>フリガナを入力してください</p>
        <? endif; ?>

        <h3>ニックネーム</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="nickname" value="<?php echo h($form['nickname']); ?>">
        <?php else : ?>
            <input type="text" name="nickname" value="<?php echo h($nickname); ?>">
        <? endif; ?>
        <?php if (isset($error['nickname']) && $error['nickname'] === 'blank'): ?>
            <p>ニックネームを入力してください</p>
        <? endif; ?>

        <h3>性別</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <?php if ($form['sex'] == 1) : ?>
                <input type="radio" name="sex" id="man" value="1" checked><label for="man">男性</label>
                <input type="radio" name="sex"id="woman" value="2"><label for="woman">女性</label>
                <input type="radio" name="sex"id="others" value="3"><label for="others">その他</ label>
            <?php endif; ?>
            <?php if ($form['sex'] == 2) : ?>
                <input type="radio" name="sex" id="man" value="1"><label for="man">男性</label>
                <input type="radio" name="sex" id="woman" value="2" checked><label for="woman">女性</label>
                <input type="radio" name="sex" id="others" value="3"><label for="others">その他</label>
            <?php endif; ?>
            <?php if ($form['sex'] == 3) : ?>
                <input type="radio" name="sex" id="man" value="1"><label for="man">男性</label>
                <input type="radio" name="sex" id="woman" value="2"><label for="woman">女性</label>
                <input type="radio" name="sex" id="others" value="3" checked><label for="others">その他</label>
            <?php endif; ?>
        <?php else : ?>
            <?php if ($sex == 1) : ?>
                <input type="radio" name="sex" id="man" value="1" checked><label for="man">男性</label>
                <input type="radio" name="sex"id="woman" value="2"><label for="woman">女性</label>
                <input type="radio" name="sex"id="others" value="3"><label for="others">その他</ label>
            <?php endif; ?>
            <?php if ($sex == 2) : ?>
                <input type="radio" name="sex" id="man" value="1"><label for="man">男性</label>
                <input type="radio" name="sex" id="woman" value="2" checked><label for="woman">女性</label>
                <input type="radio" name="sex" id="others" value="3"><label for="others">その他</label>
            <?php endif; ?>
            <?php if ($sex == 3) : ?>
                <input type="radio" name="sex" id="man" value="1"><label for="man">男性</label>
                <input type="radio" name="sex" id="woman" value="2"><label for="woman">女性</label>
                <input type="radio" name="sex" id="others" value="3" checked><label for="others">その他</label>
            <?php endif; ?>
        <?php endif; ?>

        <h3>生年月日</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="date" name="birthday" value="<?php echo h($form['birthday']); ?>">
        <?php else : ?>
            <input type="date" name="birthday" value="<?php echo h($birthday); ?>">
        <? endif; ?>

        <h3>〒住所</h3>
        <div>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                <input type="text" name="zipcode" value="<?php echo $form['zipcode']; ?>">
            <?php else : ?>
                <input type="text" name="zipcode" value="<?php echo $zipcode; ?>"><br>
            <? endif; ?>
            <?php if (isset($error['zipcode']) && $error['zipcode'] === 'blank'): ?>
                <p>郵便番号を入力してください</p>
            <? endif; ?>
        </div>

        <div>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                <input type="text" name="address" value="<?php echo h($form['address']); ?>">
            <?php else : ?>
                <input type="text" name="address" value="<?php echo h($address); ?>">
            <? endif; ?>
            <?php if (isset($error['address']) && $error['address'] === 'blank'): ?>
                <p>住所を入力してください</p>
            <? endif; ?>
        </div>

        <h3>電話番号</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="tell" value="<?php echo h($form['tell']); ?>">
        <?php else : ?>
            <input type="text" name="tell" value="<?php echo $tell; ?>">
        <? endif; ?>
        <?php if (isset($error['tell']) && $error['tell'] === 'blank'): ?>
            <p>電話番号を入力してください</p>
        <? endif; ?>

        <h3>メールアドレス</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="email" value="<?php echo h($form['email']); ?>">
        <?php else : ?>
            <input type="text" name="email" value="<?php echo h($email); ?>">
        <? endif; ?>
        <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
        <p>メールアドレスを入力してください</p>
        <? endif; ?>

        <div>
            <button type="submit" name="info">送信する</button>
        </div>
    </form>
    <?php endwhile; ?>
    <form action="pass_henkou.php" method="post">
        <button type="hidden" name="pass" value="<?php echo h($pass); ?>">パスワードを変更する</button>
    </form>
    <button onclick="location.href='kaiin_jouhou.php'">戻る</button>

</body>
</html>
