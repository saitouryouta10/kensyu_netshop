<?php
require('../library.php');
session_start();
$form['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$form['pass'] = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$id = $form['id'];
$pass = $form['pass'];

// var_dump($id);
//var_dump($form['pass']);

$form = [];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  filter_input(INPUT_POST, 'check_val', FILTER_SANITIZE_FULL_SPECIAL_CHARS) === "check_val" ) {
  $form['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $form['pass'] = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $form['old_pass'] = filter_input(INPUT_POST, 'old_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $form['new_pass'] = filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $form['check_pass'] = filter_input(INPUT_POST, 'check_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if ($form['new_pass'] === "") {
    $error["new_pass"] = "brank";
  }


  //var_dump($form['pass']);


  /* ------------------------------------------------------
    @WARNNING
  --------------------------------------------------------- */

  $db = dbconnect();
  $stmt_p = $db->prepare("select pass from users where id=?");
        if(!$stmt_p){
            die($db->error);
        }
        $stmt_p->bind_param("i", $form['id']);
        $success = $stmt_p->execute();
        if(!$success){
            die($db->error);
        }

        $stmt_p->bind_result($password);
        $stmt_p->fetch();

        if(!password_verify($form['old_pass'], $password)){
          $error['pass'] = "not_match";
        }

        // $aaa = password_verify($form['old_pass'], $password);
        // var_dump($aaa);

  // if (!password_verify($form['old_pass'], $form['pass'])) {
  //   $error['pass'] = "not_match";
  // }

  /* --------------------------------------------------------- */

  // var_dump($form['old_pass']);
  // var_dump($password);
  // var_dump($error['pass']);

  if ($form['new_pass'] !== $form['check_pass']) {
    $error['pass'] = "kakunin";
  }

  if (empty($error)) {

    $id = $form['id'];
    $pass = $form['new_pass'];
    $hash_pass = password_hash($pass,PASSWORD_DEFAULT);

    $db = dbconnect();
    $sql = 'update users set pass=? where id=?';

    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param("si", $hash_pass, $id);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }

    session_start();
    $_SESSION['id'] = $id;
    $_SESSION['pass'] = $hash_pass;

    header("Location: pass_update.php");
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
  <title>HOGEHOGE SHOP-パスワード変更</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
  <?php header_inc(); ?>
</header>

    <main class="kaiin-body">
  <div class="kaiin-container">
  <h1>パスワード変更</h1>
  <form action="" method="POST">
    <h4>以前のパスワードを入力してください</h4>
    <input type="password" name="old_pass" minlength="8" maxlength="32">
    <?php if (isset($error['pass']) && $error['pass'] === 'not_match'): ?>
      <p class="error">パスワードが違います</p>
    <? endif; ?>

    <h4>新しいパスワード</h4>
    <input type="password" name="new_pass" minlength="8" maxlength="32">
    <?php if (isset($error['new_pass']) && $error["new_pass"] === "brank"): ?>
      <p class="error">新しいパスワードを入力してください</p>
    <?php endif; ?>

    <h4>確認</h4>
    <input type="password" name="check_pass" minlength="8" maxlength="32">
    <?php if (isset($error['pass']) && $error['pass'] === 'kakunin'): ?>
      <p class="error">パスワードが一致しません</p>
    <?php endif; ?>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="pass" value="<?php echo $pass; ?>">

    <div class="btn-kakutei">
      <button type="submit" class="btn btn-warning" name="check_val" value="check_val">OK</button>
    </div>
  </form>
    <div class="btn-kakutei">
      <button class="btn btn-outline-secondary btn-block" onclick="location.href='touroku_henkou.php'">戻る</button>
    </div>

</div>

  </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>

</body>
</html>


<div class="btn-kakutei">
