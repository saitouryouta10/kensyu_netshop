<?php
require('../library.php');
require('../lib/DBcontroller.php');
$form = [];
$error = [];
$match_error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {

    $form['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $form['self_check_email'] = filter_input(INPUT_POST, 'self_check_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $self_check_email = $form['self_check_email'];

    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //数字の検索(一致するものがあった場合は1を返す)
	$match["num"] = preg_match('/[0-9]/',$form["name"]);
	//記号の検索(同上)
	$match["kigou"] = preg_match('/[!#<>:;&~@%+$"\'\*\^\(\)\[\]\|\/\.,_-]/',$form["name"]);
    //文字数の検索
	$form_length["name"] = mb_strlen($form["name"]);
    if ($form['name'] === '') {
        $form['name'] = '';
        $error['name'] = 'blank';
    } else if ($form_length["name"] > 20){
		$error["name"] = "string";
	}
	//記号か数字が含まれている場合
	if($match["num"] || $match["kigou"]){
		$match_error["name"] = "error";
	}

    $form['name_kana'] = filter_input(INPUT_POST, 'name_kana', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //カタカナ以外の文字の検索(同上)
	$match["kana"] = preg_match('/[^ア-ンー]/u',$form["name_kana"]);
    //文字数の検索
	$form_length["name_kana"] = mb_strlen($form["name_kana"]);
    if ($form['name_kana'] === '') {
        $form['name_kana'] = '';
        $error['name_kana'] = 'blank';
    } else if($form_length["name_kana"] > 30){
		$error["name_kana"] = "string";
	}
	//カタカナ以外
	if($match["kana"]){
		$match_error["name_kana"] = "error";
    }

    $form['nickname'] = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //文字数の検索
	$form_length["nickname"] = mb_strlen($form["nickname"]);
    if ($form['nickname'] === '') {
        $form['nickname'] = '';
        $error['nickname'] = 'blank';
    } else if($form_length["nickname"] > 8){
		$error["nickname"] = "string";
	}

    $form['sex'] = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $form['birthday'] = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['birthday'] === '') {
        $form['birthday'] = NULL;
    }


    $form["zipcode"] = filter_input(INPUT_POST,"zipcode",FILTER_SANITIZE_STRING);
    //郵便番号の正規表現
	$match["zip"] = preg_match("/^[0-9]{3}-[0-9]{4}$/",$form["zipcode"]);
    if ($form['zipcode'] === '') {
        $error['zipcode'] = 'blank';
    }
    //正規表現にはじかれた場合
	if($form["zipcode"] !== "" && !$match["zip"]){
		$error["zipcode"] = "value_error";
	}

    $form['address'] = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['address'] === '') {
        $error['address'] = 'blank';
    }

    $form["tell"] = filter_input(INPUT_POST,"tell",FILTER_SANITIZE_STRING);
    //携帯電話番号の正規表現
	$match["tell"] = preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/",$form["tell"]);
    if ($form['tell'] === '') {
        $error['tell'] = 'blank';
    }
    //正規表現にはじかれた場合
	if($form["tell"] !== "" && !$match["tell"]){
		$error["tell"] = "value_error";
	}

    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($form['email'] === '') {
        $error['email'] = 'blank';
    }
    //フィルターにはじかれたとき
	if($form["email"] !== "" && !filter_var($form["email"], FILTER_VALIDATE_EMAIL)){
		$error["email"] = "value_error";
	}

    $dbc = new DBcontroller();
    $sql = "select email from users where email not in ('". $self_check_email ."')";
    $dataArray = $dbc->executeQuery($sql, $types = null, "");
    if (!$dataArray) {
        die($dbc->error);
    }

    foreach ($dataArray as $data) {
        if ($data['emai'] == $self_check_email) {
            $match_error["email"] = "dup";
        }
    }

	// $records = $db2->query("select email from users where email not in ('". $self_check_email ."')");
	// if($records){
	// 	while($record = $records->fetch_assoc()){
	// 		if($form["email"] === $record["email"]){
	// 			$match_error["email"] = "dup";
	// 		}
	// 	}
	// } else {
    //     die($db2->error);
    // }

	//文字の中のスペースを削除する
    $form["name"] = preg_replace('/　|\s+/', '', $form["name"]);
	$form["name_kana"] = preg_replace('/　|\s+/', '', $form["name_kana"]);
	$form["nickname"] =	preg_replace('/　|\s+/', '', $form["nickname"]);
	$form["zipcode"] = preg_replace('/　|\s+/', '', $form["zipcode"]);
	$form["address"] = preg_replace('/　|\s+/', '', $form["address"]);
	$form["tell"] = preg_replace('/　|\s+/', '', $form["tell"]);
	$form["email"] = preg_replace('/　|\s+/', '', $form["email"]);

    if (empty($error) && empty($match_error)) {
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
if(isset($_SESSION["id"])){
    //セッション情報がある場合は普通に画面遷移
    $id = $_SESSION['id'];
}else{
      $login = 1;
      //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
    header('Location:../login/login.php?login='.$login.'');
    exit();
}
$dbc = new DBcontroller();
$sql = 'select id, name, name_kana, nickname, sex, birthday, zipcode, address, tell, email, pass from users where id=?';
$types = 'i';

$dataArray = $dbc->executeQuery($sql,$types,$id);
if (!$dataArray) {
    die($dbc->error);
}


//$db2 = dbconnect();
// $sql = 'select id, name, name_kana, nickname, sex, birthday, zipcode, address, tell, email, pass from users where id=?';
// $stmt = $db2->prepare($sql);
// if (!$stmt) {
//     die($db2->error);
// }
// $stmt->bind_param("i", $id);
// $success = $stmt->execute();
// if (!$success) {
//     die($db2->error);
// }
// $stmt->bind_result($id, $name, $name_kana, $nickname, $sex, $birthday, $zipcode, $address, $tell, $email, $pass);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGEHOGE SHOP-登録情報変更</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <?php header_inc(); ?>
    </header>

    <main class="kaiin-body">
    <div>
    <form action="kaiin_jouhou.php" method="get" class="text-end">
        <button type="submit" class="btn btn-outline-secondary btn-block">戻る</button>
    </form>
    </div>

    <div class="henkou-inp">

    <h1>登録情報変更</h1>
    <?php foreach($dataArray as $data): ?>
    <form action="" method="post">
        <div class="henkou-form">
        <h3>名前</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="name" value="<?php echo h($form['name']); ?>">
        <?php else : ?>
            <input type="text" name="name" value="<?php echo h($data['name']); ?>">
        <?php endif; ?>
        <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
            <p class="error">名前を入力してください</p>
        <? endif; ?>
        <?php if(isset($error["name"]) && $error["name"] === "string"):?>
			<p class="error">名前は20文字以内で入力してください。</p>
		<?php endif;?>
		<?php if(isset($match_error["name"]) && $match_error["name"] === "error"):?>
			<p class="error">名前に数字、記号は使用できません。</p>
		<?php endif;?>

        <h3>名前（フリガナ）</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="name_kana" value="<?php echo h($form['name_kana']); ?>">
        <?php else : ?>
            <input type="text" name="name_kana" value="<?php echo h($data['name_kana']); ?>">
        <? endif; ?>
        <?php if (isset($error['name_kana']) && $error['name_kana'] === 'blank'): ?>
            <p class="error">フリガナを入力してください</p>
        <? endif; ?>
        <?php if(isset($error["name_kana"]) && $error["name_kana"] === "string"):?>
			<p class="error">フリガナは30文字以内で入力してください。</p><br>
		<?php endif;?>
		<?php if(isset($match_error["name_kana"]) && $match_error["name_kana"] ==="error"):?>
			<p class="error">フリガナはカタカナで入力してください。</p>
		<?php endif;?>

        <h3>ニックネーム</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="nickname" value="<?php echo h($form['nickname']); ?>">
        <?php else : ?>
            <input type="text" name="nickname" value="<?php echo h($data['nickname']); ?>">
        <? endif; ?>
        <?php if (isset($error['nickname']) && $error['nickname'] === 'blank'): ?>
            <p class="error">ニックネームを入力してください</p>
        <? endif; ?>
        <?php if(isset($error["nickname"]) && $error["nickname"] === "string"):?>
			<p class="error">ニックネームは8文字以内で入力してください。</p>
		<?php endif;?>

        <div>
        <h3>性別</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="radio" id="male" name="sex" value="1" <?= isset($form["sex"]) && $form["sex"] === "1" ? 'checked' : '' ?>>
			<label for="male">男性</label>
			<input type="radio" id="female" name="sex" value="2" <?= isset($form["sex"]) && $form["sex"] === "2" ? 'checked' : '' ?>>
			<label for="female">女性</label>
			<input type="radio" id="others" name="sex" value="3" <?= isset($form["sex"]) && $form["sex"] === "3" ? 'checked' : '' ?>>
			<label for="others">その他</label>

        <?php else : ?>
            <input type="radio" id="male" name="sex" value="1" <?= $data['sex'] == 1 ? 'checked' : '' ?>>
			<label for="male">男性</label>
			<input type="radio" id="female" name="sex" value="2" <?= $data['sex'] == 2 ? 'checked' : '' ?>>
			<label for="female">女性</label>
			<input type="radio" id="others" name="sex" value="3" <?= $data['sex'] ==3 ? 'checked' : '' ?>>
			<label for="others">その他</label>

        <?php endif; ?>
        </div>

        <div>
        <h3>生年月日</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="date" name="birthday" value="<?php echo h($form['birthday']); ?>">
        <?php else : ?>
            <input type="date" name="birthday" value="<?php echo h($data['birthday']); ?>">
        <? endif; ?>
        </div>

        <h3>〒住所</h3>
        <div>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                <input type="text" name="zipcode" value="<?php echo $form['zipcode']; ?>">
            <?php else : ?>
                <input type="text" name="zipcode" value="<?php echo $data['zipcode']; ?>"><br>
            <? endif; ?>
            <?php if (isset($error['zipcode']) && $error['zipcode'] === 'blank'): ?>
                <p class="error">郵便番号を入力してください</p>
            <? endif; ?>
            <?php if(isset($error["zipcode"]) && $error["zipcode"] === "value_error"):?>
				<p class="error">正しい郵便番号を入力して下さい。</p>
			<?php endif;?>
        </div>

        <div>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                <input type="text" name="address" value="<?php echo h($form['address']); ?>">
            <?php else : ?>
                <input type="text" name="address" maxlength="255" value="<?php echo h($data['address']); ?>">
            <? endif; ?>
            <?php if (isset($error['address']) && $error['address'] === 'blank'): ?>
                <p class="error">住所を入力してください</p>
            <? endif; ?>
        </div>

        <h3>電話番号</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="tell" value="<?php echo h($form['tell']); ?>">
        <?php else : ?>
            <input type="text" name="tell" value="<?php echo $data['tell']; ?>">
        <? endif; ?>
        <?php if (isset($error['tell']) && $error['tell'] === 'blank'): ?>
            <p class="error">電話番号を入力してください</p>
        <? endif; ?>
        <?php if(isset($error["tell"]) && $error["tell"] === "value_error"):?>
				<p class="error">正しい携帯電話番号を入力して下さい。</p>
		<?php endif;?>

        <h3>メールアドレス</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <input type="text" name="email" value="<?php echo h($form['email']); ?>">
        <?php else : ?>
            <input type="text" name="email" value="<?php echo h($data['email']); ?>">
        <? endif; ?>
        <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
        <p class="error">メールアドレスを入力してください</p>
        <? endif; ?>
        <?php if(isset($error["email"]) && $error["email"] === "value_error"):?>
				<p class="error">正しいメールアドレスを入力して下さい。</p>
		<?php endif; ?>
        <?php if(isset($match_error["email"]) && $match_error["email"] === "dup"): ?>
				<p class="error">そのメールアドレスは既に使われています。</p>
		<?php endif; ?>

        <input type="hidden" name="id", value="<?php echo h($id); ?>">
        <input type="hidden" name="self_check_email", value="<?php echo h($data['email']); ?>">
    </div>
        <div class="btn-sub">
            <button type="submit" name="info" class="btn btn-warning">送信する</button>
        </div>
    </form>
    </div>

    <form action="pass_henkou.php" method="post">
        <input type="hidden" name="id", value="<?php echo h($id); ?>">
        <div class="btn-sub">
            <button type="hidden" class="btn btn-success" name="pass" value="<?php echo h($data['pass']); ?>">パスワードを変更する</button>
        </div>
    </form>

    <?php endforeach; ?>
    </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
