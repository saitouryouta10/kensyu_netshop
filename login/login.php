<?php
require("../library.php");
require_once('../lib/DBController.php');
require_once("../lib/UserDBController.php");

session_start();

$login_prease = "";
$email = "";
$pass = "";
$error = [
    "email" => "",
    "pass" => "",
    "login" => ""
];





// TODO:ログインしないと入れないページから飛んできたよう
if($_SERVER["REQUEST_METHOD"] === "GET"){

    if(isset($_GET["login"])){

        $login_prease = $_GET["login"];
        $alert = "<script type='text/javascript'>alert('その機能を使うためにはログインをしてください');</script>";
    }
    // var_dump($login_prease);    
}

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
        $db = new UserDBController;

        $data = $db->userLoginQuery($email);

        // var_dump($data);

        // var_dump($data["0"]["id"]);
        // var_dump($data["0"]["pass"]);
        if(password_verify($pass,$data["0"]["pass"])){
            if ($data["0"]["id"] === 1){
                $_SESSION["id"] = $data["0"]["id"];
                header("Location: ../admin/kanri_top.php");
                exit();
            }
            session_regenerate_id();
            $_SESSION["id"] = $data["0"]["id"];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

    <title>HOGEHOGE SHOP-ログイン</title>
</head>
<body>
    <form action="" method="post">
        <div class="login_container">
            <h1 class="touroku_title">HOGEHOGE SHOP</h1>
            <div class="subtitle">
                <h3>ログイン</h3>
            </div>
            <?php if(isset($error["login"]) && $error["login"] === "nomatch"):?>
                <div class="error">
                    <span>ログインに失敗しました。メールアドレス、パスワードを正しくご記入ください。</span>
                </div>
            <?php endif;?>
            <div class="login_form">
                <?php if(isset($login_prease) && $login_prease == 1):?>
                <?php echo $alert; ?>
                <?php endif;?>
                    <table>
                            <tr>
                                <th>
                                    メールアドレス
                                </th>
                                <td>
                                    <input type="text" name="email" class="login_email" placeholder="メールアドレス" value="<?php echo h($email);?>"><br>
                                    <?php if(isset($error["email"]) && $error["email"] === "brank"):?>
                                    <div class="error">
                                        <span>メールアドレスをご記入ください</span>
                                    </div>
                                    <?php endif;?>
                                <td>
                            </tr>
                            <tr>
                                <th>
                                    パスワード
                                </th>
                                <td>
                                    <input type="password" name="pass" class="login_pass" placeholder="パスワード" value="<?php echo h($pass);?>"><br>
                                    <?php if(isset($error["pass"]) && $error["pass"] === "brank"):?>
                                    <div class="error">
                                        <span>パスワードをご記入ください</span>
                                    </div>
                                    <?php endif;?>
                                </td>
                            </tr>
                    </table>
                <div class="login_button">
                    <button type="submit" class="btn btn-warning" style="font-weight: bold;">ログイン</button>
                </div>
            </div>
            
            <div class="sinki_location">
                <span>アカウントをお持ちではありませんか？<a href="sinki_touroku.php">会員登録</a></span>
            </div>

            <!-- TODO: パスワード忘れた人はこちらを追加してみたい -->

            <div class="loca_top">
                <a type="button" class="btn btn-outline-secondary btn-block" onclick="location.href='../top/top.php'">トップに戻る</a>
            </div>
        </div>
    </form>
</body>
</html>