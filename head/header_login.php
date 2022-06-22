<?php
global $db;
global $user_name;
global $search;
global $sc;

$user_name = 'ゲスト';

if (isset($_GET['search'])) {
    $search = h($_GET['search']);
    $search_value = $search;
    $db = dbconnect();
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
                <form action="" method="get">
                    <?php if (isset($_GET['search'])) : ?>
                        <input type="text" class="text_box" name="search" value="<?php echo $search ?>">
                    <?php else : ?>
                        <input type="text" class="text_box" name="search" placeholder="商品名を入力してください">
                    <?php endif; ?>
                        <button type="submit" class="btn btn-warning" id="serch_button">検索🔍</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="header-link">
            <p><a href="#">お気に入り</a></p>
            <p><a href="../top/cart.php">カート</a></p>
            <p><a href="../login/login.php">ログイン</a></p>
            <p><a href="../kaiinjouhou/kaiin_jouhou.php">会員情報</a></p>
        </div>
    </div>
</div>
