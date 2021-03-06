<?php
global $db;
global $user_name;
global $search;
global $sc;

// require('../lib/DBController.php');

$userid = $_SESSION['id'];
$sql ='select * from users where id='.$userid.'';
$rec=$db->executeQuery($sql, $types = null);
//idから情報をすべて抜き出し名前をセッションへ追加
foreach($rec as $value) {
    // print_r($value);
  $user_name = $value["nickname"];
  $_SESSION["nickname"] = $user_name;
  $_SESSION["name"] = $value["name"];
}


if (isset($_GET['search'])) {
    $search = h($_GET['search']);
    $search_value = $search;
    // $db = dbconnect();
    $sc = "where name LIKE '%$search%'";

} else {
    $search = '';
}

?>

<div class="title_header">
    <h1 class="title"><a href="../top/top.php">HOGEHOGE SHOP</a></h1>
</div>
<div class="header_list">

    <div class="serch">
        <div class="header-message">
            <div class="header-message-left">
                <p><span><?php echo $user_name; ?></span>&nbsp;さん、おかえりなさい</p>
            </div>
            <div class="header-message-right">
                <form action="../top/top.php" method="get">
                    <?php if (isset($_GET['search'])) : ?>
                        <input type="text" class="text_box" name="search" maxlength="100" value="<?php echo $search ?>">
                    <?php else : ?>
                        <input type="text" class="text_box" name="search" maxlength="100" placeholder="商品名を入力してください">
                    <?php endif; ?>
                        <button type="submit" class="btn btn-warning" id="serch_button">検索🔍</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="header-link">
            <p><a href="../favo/favorite.php">お気に入り</a></p>
            <p><a href="../top/cart.php">カート</a></p>
            <p><a href="../login/logout.php">ログアウト</a></p>
            <p><a href="../kaiinjouhou/kaiin_jouhou.php">会員情報</a></p>
        </div>
    </div>
</div>
