<?php 
require("../library.php");

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
	"doui" => ""
];


$error = [
	"doui" => ""
];

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

	// var_dump($form["doui"]);

	if($form["name"] === ""){
		$error["name"] = "blank";
	}else if(strlen($form["name"] >= 20)){
		$error["name"] = "string";
	}

	if($form["name_kana"] === ""){
		$error["name_kana"] = "blank";
	}
	
	if($form["nickname"] === ""){
		$error["nickname"] = "blank";
	}

	if($form["zipcode"] === ""){
		$error["zipcode"] = "blank";
	}

	if($form["address"] === ""){
		$error["address"] = "blank";
	}

	if($form["tell"] === ""){
		$error["tell"] = "blank";
	}

	if($form["email"] === ""){
		$error["email"] = "blank";
	}

	if($form["pass"] === ""){
		$error["pass"] = "blank";
	}

	if($form["pass_kakunin"] === ""){
		$error["pass_kakunin"] = "blank";
	}
	
	if($form["doui"] !== "1"){
		$error["doui"] = "blank";
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
    <link rel="stylesheet" href="style.css">
    <title>HOGEHOGE SHOP</title>
</head>
<body>
    <button type="button" class="btn btn-primary">トップへ</button>
    <h1>HOGEHOGE SHOP</h1>

    <div class="subtitle">
        <h3>新規会員登録</h3>
        <p>以下のフォームの必要事項を入力してください。</p>
    </div>
    <div class="input_form">
	<?php if($error["doui"] === "blank"):?>
		<p>同意するにチェックをいれてください</p>
	<?php endif;?>
	<form action="" method="post">
    <table>
	<tbody>
		<tr>
			<td>
				お名前<span class="require">必須</span>
			</td>
			<td><input type="text" name="name" class="textbox" value="<?php echo h($form["name"])?>"><br>
				例)山田太郎<br>
				<?php var_dump($error["name"]);?>
				<?php if(isset($error["name"]) && $error["name"] === "blank"):?>
				<span class="error">名前を入力して下さい</span>
				<?php endif;?>
				<?php if(isset($error["name"]) && $error["name"] === "string"):?>
				<span class="error">名前は20文字以内で入力してください。</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<td>お名前(フリガナ)<span class="require">必須</span></td>
			<td><input type="text" name="name_kana" class="textbox" value="<?php echo h($form["name_kana"])?>"><br>
				例)ヤマダタロウ<br>
				<?php if(isset($error["name_kana"]) && $error["name_kana"] === "blank"):?>
				<span class="error">フリガナを入力して下さい</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<td>ニックネーム<span class="require">必須</span></td>
			<td>
				<input type="text" name="nickname" class="textbox" value="<?php echo h($form["nickname"])?>"><br>
				<?php if(isset($error["nickname"]) && $error["nickname"] === "blank"):?>
				<span class="error">ニックネームを入力して下さい</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<td>性別</td>
            <label >
			<td>
                <input type="radio" id="male" name="sex" value="0">
                <label for="male">男性</label>
                <input type="radio" id="female" name="sex" value="1">
                <label for="female">女性</label>
                <input type="radio" id="others" name="sex" value="2">
                <label for="others">その他</label>
            </td>

		</tr>
		<tr>
			<td>生年月日</td>
			<td><input type="date" name="birthday"></td>
		</tr>
		<tr>
			<td>ご住所<span class="require">必須</span></td>
			<td>
				<div class="address_margin">
                	<label>〒</label><br>
                	<input type="text" name="zipcode" pattern="[0-9]{3}-[0-9]{4}" value="<?php echo h($form["zipcode"])?>"><br>
					例)〇〇〇-〇〇〇〇(半角数字で入力してください。)<br>
				<?php if(isset($error["zipcode"]) && $error["zipcode"] === "blank"):?>
				<span class="error">郵便番号を入力して下さい</span>
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
			<td>携帯電話番号<span class="require">必須</span></td>
			<td>
				<input type="tel" name="tell" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" class="textbox" value="<?php echo h($form["tell"])?>"><br>
				例)000-0000-0000（半角数字でご入力ください）<br>
				<?php if(isset($error["tell"]) && $error["tell"] === "blank"):?>
				<span class="error">携帯電話番号を入力して下さい</span>
				<?php endif;?>
			</td>	
		</tr>
		<tr>
			<td>メールアドレス<span class="require">必須</span></td>
			<td>
				<input type="email" name="email" class="textbox" value="<?php echo h($form["email"])?>"><br>
				例)〇〇〇@〇〇〇.com<br>
				<?php if(isset($error["email"]) && $error["email"] === "blank"):?>
				<span class="error">携帯電話番号を入力して下さい</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<td>パスワード<span class="require">必須</span></td>
			<td>
				<input type="password" name="pass" minlength="8" maxlength="32" class="textbox"><br>
				例)8文字以上32文字以内でご入力下さい<br>
				<?php if(isset($error["pass"]) && $error["pass"] === "blank"):?>
				<span class="error">パスワードを入力して下さい</span>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<td>パスワード(確認)<span class="require">必須</span></td>
			<td>
				<input type="password" name="pass_kakunin"  minlength="8" maxlength="32" class="textbox"><br>
				例)8文字以上32文字以内でご入力下さい<br>
				<?php if(isset($error["pass_kakunin"]) && $error["pass_kakunin"] === "blank"):?>
				<span class="error">住所を入力して下さい</span>
				<?php endif;?>
			</td>
		</tr>
	</tbody>
    </table>
    </div>
    <div class="doui">
        <p>会員規約および個人情報の取り扱いについて</p>
        <div class="kiyakusyo">
            <h2><a href="#">会員規約を読む</a></h2>
        </div>
        <div class="kiyaku_doui">
            <input type="checkbox" id="check_doui" name="doui" value="1">
            <label for="check_doui">上記会員規約、個人情報の取り扱いについて同意する</label>
        <div>
		<button type="submit" class="btn btn-primary" id="submit">この内容で会員登録する</button>
</form>
</div>
</body>
</html>