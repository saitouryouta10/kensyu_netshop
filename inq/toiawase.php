<?php
require("../library.php");
session_start();


$error = [];

$match_error = [];


if (isset($_SESSION["form"])) {
    $form = $_SESSION["form"];
}

//フォーム内容のチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {

	$form["name"] = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
	$form["email"] = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    $form["kenmei"] = filter_input(INPUT_POST,"kenmei",FILTER_SANITIZE_STRING);
    $form["inquiry"] = filter_input(INPUT_POST,"inquiry",FILTER_SANITIZE_STRING);


	//文字の中のスペースを削除する
	$form["name"] = preg_replace('/　|\s+/', '', $form["name"]);
	$form["email"] = preg_replace('/　|\s+/', '', $form["email"]);

	//記号の検索(同上)
	$match["kigou"] = preg_match('/[!#<>:;&~@%+$"\'\*\^\(\)\[\]\|\/\.,_-]/', $form["name"]);


	/*--------------------名前のバリデーション-------------------------*/

	//0文字だった場合
	if ($form["name"] === "") {
		$error["name"] = "blank";
	}
	//記号か数字が含まれている場合
	if ($match["kigou"]) {
		$match_error["name"] = "error";
	}


	/*--------------------メールアドレスのバリデーション-------------------------*/

	//0文字だった場合
	if ($form["email"] === "") {
		$error["email"] = "blank";
	}
    	//フィルターにはじかれたとき
	if ($form["email"] !== "" && !filter_var($form["email"], FILTER_VALIDATE_EMAIL)) {
		$error["email"] = "value_error";
	}


    /*--------------------お問い合わせ内容のバリデーション-------------------------*/

    if ($form["inquiry"] === "") {
		$error["inquiry"] = "blank";
    }



	if (empty($error) && empty($match_error)) {
		$_SESSION["name"] = $form["name"];
        $_SESSION["email"] = $form["email"];
        $_SESSION["kenmei"] = $form["kenmei"];
        $_SESSION["inquiry"] = $form["inquiry"];

		header("Location: toiawase_kakunin.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>HOGEHOGE SHOP</title>
</head>
<body>
    <div class="form ">
        <div class="top-pos">
            <div class="text-end">
                <a class="btn btn-outline-secondary btn-block" href="../top/top.php">トップに戻る</a>
            </div>
           <h1 class="toiawase">お問い合わせ</h1>
        </div>

        <hr>

        <div class="container">
            <form action="#" method="post">
                <p>お名前　<span class="badge bg-danger">必須</span></p>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <input type="text" name="name" value="<?php echo h($form['name']); ?>">
                <?php else : ?>
                    <input type="text" name="name" maxlength="20">
                <?php endif; ?>
                <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
                    <p class="error">名前を入力してください</p>
                <? endif; ?>
		        <?php if(isset($match_error["name"]) && $match_error["name"] === "error"):?>
		            <p class="error">名前に数字、記号は使用できません。</p>
		         <?php endif;?>

                <p>メールアドレス　<span class="badge bg-danger">必須</span></p>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <input type="text" name="email" value="<?php echo h($form['email']); ?>">
                <?php else : ?>
                    <input type="email" name="email">
                <? endif; ?>
                <?php if(isset($error["email"]) && $error["email"] === "value_error"):?>
				    <p class="error">正しいメールアドレスを入力して下さい。</p>
		        <?php endif; ?>
                <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
                    <p class="error">メールアドレスを入力してください</p>
                <? endif; ?>

                <p>件名</p>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <input type="text" name="kenmei" maxlength="30" value="<?php echo h($form['kenmei']); ?>">
                <?php else : ?>
                    <input type="text" name="kenmei" maxlength="30">
                <?php endif; ?>

                <p>お問い合わせ内容　<span class="badge bg-danger">必須</span></p>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <textarea name="inquiry" maxlength="200"><?php echo h($form['inquiry']); ?></textarea>
                <?php else : ?>
                    <textarea name="inquiry" maxlength="200"></textarea>
                <?php endif; ?>
                <?php if (isset($error['inquiry']) && $error['inquiry'] === 'blank'): ?>
                    <p class="error">お問い合わせ内容を入力してください</p>
                <? endif; ?>

                <div class="button">
                    <button type="submit" class="btn btn-warning" id="kakunin" style="font-weight: bold;">入力内容を確認する</button>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <p class="text-center" style="margin-bottom: 30px">© 2022 Kensyu_netshop</p>
</body>
</html>
