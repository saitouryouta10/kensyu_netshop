<?php
function h($value){
    return htmlspecialchars($value,ENT_QUOTES);
}

// function dbconnect(){

//     require_once( dirname( __FILE__ , 2) . '/config/db.php');
//     $db = new mysqli(HOST, USER, PASS, DBName);

//     return $db;
// }

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
