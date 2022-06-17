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

        if(password_verify($form['old_pass'], $password)){
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
    $hash_pass = password_hash($form["pass"],PASSWORD_DEFAULT);

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
  <title>パスワード変更</title>
</head>
<body>
  <h1>パスワード変更</h1>
  <form action="" method="POST">
    <h3>以前のパスワードを入力してください</h3>
    <input type="password" name="old_pass" minlength="8" maxlength="32">
    <?php if (isset($error['pass']) && $error['pass'] === 'not_match'): ?>
      <p class="error">パスワードが違います</p>
    <? endif; ?>

    <h3>新しいパスワード</h3>
    <input type="password" name="new_pass" minlength="8" maxlength="32">
    <?php if (isset($error['new_pass']) && $error["new_pass"] === "brank"): ?>
      <p class="error">新しいパスワードを入力してください</p>
    <?php endif; ?>

    <h3>確認</h3>
    <input type="password" name="check_pass" minlength="8" maxlength="32">
    <?php if (isset($error['pass']) && $error['pass'] === 'kakunin'): ?>
      <p class="error">パスワードが一致しません</p>
    <?php endif; ?>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="hidden" name="pass" value="<?php echo $pass; ?>">

    <div>
      <button type="submit" name="check_val" value="check_val">OK</button>
    </div>
  </form>

  <button onclick="location.href='touroku_henkou.php'">戻る</button>

</body>
</html>
