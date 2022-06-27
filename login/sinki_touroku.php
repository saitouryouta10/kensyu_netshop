<?php
require("../library.php");
session_start();

$form = [
	"name" => "",
	"name_kana" => "",
	"nickname" => "",
	"zipcode" => "",
	"address" => "",
	"tell" => "",
	"email" => "",
	"pass" => "",
	"pass_kakunin" => "",
	"doui" => "",
	"sex" => "",
	"birthday" => ""
];


$error = [];

$match_error = [];

$form_length = [];

$check_error = "";

if(isset($_SESSION["form"])){
    $form = $_SESSION["form"];
}

//フォーム内容のチェック
if($_SERVER["REQUEST_METHOD"] === "POST"){

	$form["name"] = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
	$form["name_kana"] = filter_input(INPUT_POST,"name_kana",FILTER_SANITIZE_STRING);
	$form["nickname"] = filter_input(INPUT_POST,"nickname",FILTER_SANITIZE_STRING);
	$form["zipcode"] = filter_input(INPUT_POST,"zipcode",FILTER_SANITIZE_STRING);
	$form["address"] = filter_input(INPUT_POST,"address",FILTER_SANITIZE_STRING);
	$form["tell"] = filter_input(INPUT_POST,"tell",FILTER_SANITIZE_STRING);
	$form["email"] = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
	$form["pass"] = filter_input(INPUT_POST,"pass",FILTER_SANITIZE_STRING);
	$form["pass_kakunin"] = filter_input(INPUT_POST,"pass_kakunin",FILTER_SANITIZE_STRING);
	$form["doui"] = filter_input(INPUT_POST,"doui");

	if(isset($_POST["sex"])){
		$form["sex"] = h($_POST["sex"]);
	}else{
		$form["sex"] = "";
	}

	if(isset($_POST["birthday"])){
		$form["birthday"] = h($_POST["birthday"]);
	}else{
		$form["birthday"] = "";
	}

	//文字の中のスペースを削除する
	$form["name"] = preg_replace('/　|\s+/', '', $form["name"]);
	$form["name_kana"] = preg_replace('/　|\s+/', '', $form["name_kana"]);
	$form["nickname"] =	preg_replace('/　|\s+/', '', $form["nickname"]);
	$form["zipcode"] = preg_replace('/　|\s+/', '', $form["zipcode"]);
	$form["address"] = preg_replace('/　|\s+/', '', $form["address"]);
	$form["tell"] = preg_replace('/　|\s+/', '', $form["tell"]);
	$form["email"] = preg_replace('/　|\s+/', '', $form["email"]);

	//数字の検索(一致するものがあった場合は1を返す)
	$match["num"] = preg_match('/[0-9]/',$form["name"]);

	//記号の検索(同上)
	$match["kigou"] = preg_match('/[!#<>:;&~@%+$"\'\*\^\(\)\[\]\|\/\.,_-]/',$form["name"]);

	//カタカナ以外の文字の検索(同上)
	$match["kana"] = preg_match('/[^ア-ンー]/u',$form["name_kana"]);

	//郵便番号の正規表現
	$match["zip"] = preg_match("/^[0-9]{3}-[0-9]{4}$/",$form["zipcode"]);

	//携帯電話番号の正規表現
	$match["tell"] = preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/",$form["tell"]);

	//文字数の検索
	$form_length["name"] = mb_strlen($form["name"]);
	$form_length["name_kana"] = mb_strlen($form["name_kana"]);
	$form_length["nickname"] = mb_strlen($form["nickname"]);

	/*--------------------名前のバリデーション-------------------------*/

	//0文字だった場合
	if($form["name"] === ""){
		$error["name"] = "blank";
	//21文字以上だった場合
	}else if($form_length["name"] > 20){
		$error["name"] = "string";
	}
	//記号か数字が含まれている場合
	if($match["num"] || $match["kigou"]){
		$match_error["name"] = "error";
	}

	/*--------------------フリガナのバリデーション-------------------------*/

	//0文字だった場合
	if($form["name_kana"] === ""){
		$error["name_kana"] = "blank";
	//31文字以上だった場合
	}else if($form_length["name_kana"] > 30){
		$error["name_kana"] = "string";
	}
	//カタカナ以外
	if($match["kana"]){
		$match_error["name_kana"] = "error";
	}

	/*--------------------ニックネームのバリデーション-------------------------*/

	//0文字だった場合
	if($form["nickname"] === ""){
		$error["nickname"] = "blank";
	//21文字以上だった場合
	}else if($form_length["nickname"] > 8){
		$error["nickname"] = "string";
	}
	/*--------------------生年月日のバリデーション-------------------------*/

	if($form["birthday"] == ""){
		$form["birthday"] = NULL;
		// echo "a";
		// var_dump($form["birthday"]);
		// exit();
	}
	/*--------------------性別のバリデーション-------------------------*/

	if($form["sex"] == ""){
		$form["sex"] = 3;
		// var_dump($form["sex"]);
		// exit();
	}
	/*--------------------郵便番号のバリデーション-------------------------*/

	//0文字だった場合
	if($form["zipcode"] === ""){
		$error["zipcode"] = "blank";
	}
	//正規表現にはじかれた場合
	if($form["zipcode"] !== "" && !$match["zip"]){
		$error["zipcode"] = "value_error";
	}

	/*--------------------住所のバリデーション-------------------------*/

	//0文字だった場合
	if($form["address"] === ""){
		$error["address"] = "blank";
	}

	/*--------------------携帯電話のバリデーション-------------------------*/

	//0文字だった場合
	if($form["tell"] === ""){
		$error["tell"] = "blank";
	}
	//正規表現にはじかれた場合
	if($form["tell"] !== "" && !$match["tell"]){
		$error["tell"] = "value_error";
	}

	/*--------------------メールアドレスのバリデーション-------------------------*/

	//0文字だった場合
	if($form["email"] === ""){
		$error["email"] = "blank";
	}

	/*データベース関係*/

	$db = dbconnect();

	$records = $db->query("select email from users");

	if($records){
		while($record = $records->fetch_assoc()){
			if($form["email"] === $record["email"]){
				$match_error["email"] = "dup";
			}
		}
	}else{
		die($db->error);
		exit();
	}

	//フィルターにはじかれたとき
	if($form["email"] !== "" && !filter_var($form["email"], FILTER_VALIDATE_EMAIL)){
		$error["email"] = "value_error";
	}

	/*--------------------パスワードのバリデーション-------------------------*/

	//0文字だった場合
	if($form["pass"] === ""){
		$error["pass"] = "blank";
	}

	/*--------------------パスワード確認用のバリデーション-------------------------*/

	//0文字だった場合
	if($form["pass_kakunin"] === ""){
		$error["pass_kakunin"] = "blank";
	//パスワードが一致しなかった場合
	}else if($form["pass"] !== $form["pass_kakunin"]){
		$error["pass_kakunin"] = "nomatch";
	}

	/*--------------------チェックボックス-------------------------*/

	if($form["doui"] !== "1"){
		$check_error = "blank";
	}

	//デバッグ
	// var_dump($error["name"]);
	// var_dump($match_error["name"]);
	// var_dump($error["name_kana"]);
	// var_dump($match_error["name_kana"]);
	// var_dump($error["nickname"]);
	// var_dump($error["zipcode"]);
	// var_dump($error["address"]);
	// var_dump($error["tell"]);
	// var_dump($error["email"]);
	// var_dump($error["pass"]);
	// var_dump($error["pass_kakunin"]);
	// exit();
	// var_dump($error);
	// var_dump($match_error);
	// var_dump($form["doui"]);

	if(empty($error) && empty($match_error) && $form["doui"]){
		$_SESSION["form"] = $form;
		// var_dump($form["birthday"]);
		// exit();
		header("Location: touroku_kakunin.php");
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


    <!-- Boot strap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>HOGEHOGE SHOP-新規登録</title>
</head>
<body>
    <a class="button btn btn-outline-secondary btn-block" id="login_button" onclick="location.href='login.php'">ログインページへ</a>
    <h1 class="touroku_title">HOGEHOGE SHOP</h1>

    <div class="subtitle">
        <h3>新規会員登録</h3>
        <p class="message">以下のフォームの必要事項を入力してください。</p>
    </div>
    <div class="input_form">
	<?php if($check_error === "blank"):?>
		<p class="message">同意するにチェックをいれてください</p>
	<?php endif;?>
	<form action="" method="post">
    <table>
	<tbody>
		<tr>
			<th>
				お名前　<span class="badge bg-danger">必須</span>
			</th>
			<td><input type="text" name="name" class="textbox" value="<?php echo h($form["name"])?>"><br>
				例)山田太郎<br>

				<!-- デバッグ -->
				<!-- <?php var_dump($error["name"]);?><br>
				<?php echo(mb_strlen($form["name"]));?> -->


				<?php if(isset($error["name"]) && $error["name"] === "blank"):?>
				<span class="error">名前を入力して下さい。</span>
				<?php endif;?>
				<?php if(isset($error["name"]) && $error["name"] === "string"):?>
				<span class="error">名前は20文字以内で入力してください。</span><br>
				<?php endif;?>
				<?php if(isset($match_error["name"]) && $match_error["name"] === "error"):?>
				<span class="error">名前に数字、記号は使用できません。</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>フリガナ　<span class="badge bg-danger">必須</span></th>
			<td><input type="text" name="name_kana" class="textbox" value="<?php echo h($form["name_kana"])?>"><br>
				例)ヤマダタロウ<br>
				<?php if(isset($error["name_kana"]) && $error["name_kana"] === "blank"):?>
				<span class="error">フリガナを入力して下さい。</span>
				<?php endif;?>
				<?php if(isset($error["name_kana"]) && $error["name_kana"] === "string"):?>
				<span class="error">フリガナは30文字以内で入力してください。</span><br>
				<?php endif;?>
				<?php if(isset($match_error["name_kana"]) && $match_error["name_kana"] === "error"):?>
				<span class="error">フリガナはカタカナで入力してください。</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>ニックネーム　<span class="badge bg-danger">必須</span></th>
			<td>
				<input type="text" name="nickname" class="textbox" value="<?php echo h($form["nickname"])?>"><br>
				<?php if(isset($error["nickname"]) && $error["nickname"] === "blank"):?>
				<span class="error">ニックネームを入力して下さい</span>
				<?php endif;?>
				<?php if(isset($error["nickname"]) && $error["nickname"] === "string"):?>
				<span class="error">ニックネームは20文字以内で入力してください。</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>性別</th>
            <label>
			<td>
			<input type="radio" id="male" name="sex" value="1" <?= isset($form["sex"]) && $form["sex"] === "1" ? 'checked' : '' ?>>
			<label for="male">男性</label>
			<input type="radio" id="female" name="sex" value="2" <?= isset($form["sex"]) && $form["sex"] === "2" ? 'checked' : '' ?>>
			<label for="female">女性</label>
			<input type="radio" id="others" name="sex" value="3" <?= isset($form["sex"]) && $form["sex"] === "3" ? 'checked' : '' ?>>
			<label for="others">その他</label>
            </td>

		</tr>
		<tr>
			<th>生年月日</th>
			<td><input type="date" name="birthday" value="<?php echo h($form["birthday"]) ?>"></td>
		</tr>
		<tr>
			<th>ご住所　<span class="badge bg-danger">必須</span></th>
			<td>
				<div class="address_margin">
                	<label>〒</label><br>
                	<input type="text" name="zipcode" maxlength="255" value="<?php echo h($form["zipcode"])?>"><br>
					例)123-4567 (半角数字でご入力ください。)<br>
				<?php if(isset($error["zipcode"]) && $error["zipcode"] === "blank"):?>
				<span class="error">郵便番号を入力して下さい。</span>
				<?php endif;?>
				<?php if(isset($error["zipcode"]) && $error["zipcode"] === "value_error"):?>
				<span class="error">正しい郵便番号を入力して下さい。</span>
				<?php endif;?>
				</div>
                <input type="text" name="address" class="textbox" value="<?php echo h($form["address"])?>"><br>
				例)〇〇県〇〇市〇〇区〇丁目〇-〇<br>
				<?php if(isset($error["address"]) && $error["address"] === "blank"):?>
				<span class="error">住所を入力して下さい</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>携帯電話番号　<span class="badge bg-danger">必須</span></th>
			<td>
				<input type="tel" name="tell" class="textbox" value="<?php echo h($form["tell"])?>"><br>
				例)123-4567-8900（半角数字でご入力ください）<br>
				<?php if(isset($error["tell"]) && $error["tell"] === "blank"):?>
				<span class="error">携帯電話番号を入力して下さい</span>
				<?php endif;?>
				<?php if(isset($error["tell"]) && $error["tell"] === "value_error"):?>
				<span class="error">正しい携帯電話番号を入力して下さい。</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>メールアドレス　<span class="badge bg-danger">必須</span></th>
			<td>
				<input type="text" name="email" class="textbox" value="<?php echo h($form["email"])?>"><br>
				例)〇〇〇@〇〇〇.com<br>
				<?php if(isset($error["email"]) && $error["email"] === "blank"):?>
				<span class="error">メールアドレスを入力して下さい</span>
				<?php endif;?>
				<?php if(isset($error["email"]) && $error["email"] === "value_error"):?>
				<span class="error">正しいメールアドレスを入力して下さい。</span><br>
				<?php endif;?>
				<?php if(isset($match_error["email"]) && $match_error["email"] === "dup"):?>
				<span class="error">そのメールアドレスは既に登録されています。</span><br>
				<span class="error">ログインは<a href="login.php">こちら</a></span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>パスワード　<span class="badge bg-danger">必須</span></th>
			<td>
				<input type="password" name="pass" minlength="8" maxlength="32" class="textbox"><br>
				8文字以上32文字以内でご入力下さい<br>
				<?php if(isset($error["pass"]) && $error["pass"] === "blank"):?>
				<span class="error">パスワードを入力して下さい。</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>パスワード(確認)　<span class="badge bg-danger">必須</span></th>
			<td>
				<input type="password" name="pass_kakunin"  minlength="8" maxlength="32" class="textbox"><br>
				8文字以上32文字以内でご入力下さい<br>
				<?php if(isset($error["pass_kakunin"]) && $error["pass_kakunin"] === "blank"):?>
				<span class="error">パスワードを入力して下さい。</span>
				<?php endif;?>
				<?php if(isset($error["pass_kakunin"]) && $error["pass_kakunin"] === "nomatch"):?>
				<span class="error">パスワードが一致しません。</span>
				<?php endif;?>
			</td>
		</tr>
	</tbody>
    </table>
    </div>
    <div class="doui">
        <p  class="message">会員規約および個人情報の取り扱いについて</p>
        <div class="kiyakusyo">
            <h2><a href="kiyaku.html" target="_brank">会員規約を読む</a></h2>
        </div>
        <div class="kiyaku_doui">
            <input type="checkbox" id="check_doui" name="doui" value="1">
            <label for="check_doui">上記会員規約、個人情報の取り扱いについて同意する</label>
        <div>
		<button type="submit" class="btn btn-warning" id="submit" style="font-weight: bold;">この内容で会員登録する</button>
	</div>
</form>
</body>
</html>
