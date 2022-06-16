<?php
function h($value){
    return htmlspecialchars($value,ENT_QUOTES);
}

function dbconnect(){
    $db = new mysqli("localhost:8889","root","root","kensyu_db");
    if(!$db){
		die($db->error);
	}
    return $db;
}

function header_inc() {
    if(isset($_SESSION['id'])){
        //ログインしてる人用ヘッダー
        include(dirname(__FILE__) . "./head/header_logout.php");
    }else{
        //ログインしてない人用ヘッダー
        include(dirname(__FILE__) . "./head/header_login.php");
    }
}

function footer_inc() {
    if(isset($_SESSION['id'])){
        //ログアウトしてる人用フッター
        include(dirname(__FILE__) . "./head/footer_logout.php");
    }else{
        //ログインしてない人用フッター
        include(dirname(__FILE__) . "./head/footer_login.php");
    }
}
?>
