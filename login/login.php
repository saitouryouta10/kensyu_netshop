<?php
require("../library.php");
session_start();

$email = "";
$pass = "";
$error = [
    "email" => "",
    "pass" => "",
    "login" => ""
];

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    $pass = filter_input(INPUT_POST,"pass",FILTER_SANITIZE_STRING);
    
    if($email === ""){
        $error["email"] = "brank";
    }
    if($pass === ""){
        $error["pass"] = "brank";
    }

    if($error["email"] === "" && $error["pass"] === ""){
        $db = dbconnect();

        $stmt = $db->prepare("select id,pass from users where email = ? limit 1");
        if(!$stmt){
            die($db->error);
        }
        $stmt->bind_param("s",$email);
        $success = $stmt->execute();
        if(!$success){
            die($db->error);
        }

        $stmt->bind_result($id,$password);
        $stmt->fetch();

        if(password_verify($pass,$password)){
            session_regenerate_id();
            $_SESSION["id"] = $id;
            header("Location: ../top/top.php");
            exit();
        }else{
            $error["login"] = "nomatch";
        }
    }
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGEHOGE SHOP</title>
</head>
<body>
    <form action="" method="post">
        <div class="form">
            <?php if(isset($error["login"]) && $error["login"] === "nomatch"):?>
            <span>ログインに失敗しました。メールアドレス、パスワードを正しくご記入ください。</span>
            <?php endif;?>
            <div class="email">
                <p>メールアドレス</p>
                <input type="text" name="email" value="<?php echo h($email);?>"><br>
                <?php if(isset($error["email"]) && $error["email"] === "brank"):?>
                <span>メールアドレスをご記入ください</span>
                <?php endif;?>
            </div>
            <div class="pass">
                <p>パスワード</p>
                <input type="password" name="pass" value="<?php echo h($pass);?>"><br>
                <?php if(isset($error["pass"]) && $error["pass"] === "brank"):?>
                <span>パスワードをご記入ください</span>
                <?php endif;?>
            </div>
        </div>
        <div class="sinki_location">
            <a href="sinki_touroku.php">アカウント未登録の方はこちら</a>
        </div>
        <div class="top_page">
            <a href="../top/top.php">トップに戻る</a>
        </div>            
        <button type="submit">ログイン</button>
    </form>
    <?php include(dirname(__FILE__) . "/../head/footer_logout.php")?>
</body>
</html>