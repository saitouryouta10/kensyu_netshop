<?php
if (isset($_GET['search'])) {
    $search = h($_GET['search']);
    $search_value = $search;

} else {
    $search = '';
    $search_value = '';
}
?>

<div class="title_header">
    <h1 class="title"><a href="../top/top.php">HOGEHOGE SHOP</a></h1>
</div>
<div class="header_list">



    <div class="serch">
        <!-- <form action="../top/top.php"  method="get"> -->
        <form action="" method="get">
            <?php if (isset($_GET['search'])) : ?>
                <input type="text" class="text_box" value="<?php echo $search ?>">
            <?php else : ?>
                <input type="text" class="text_box" placeholder="商品名を入力してください">
            <?php endif; ?>
                <button type="submit" class="btn btn-warning" id="serch_button">検索 🔍</button>
            </div>
        </form>

        <div class="header-link">
            <p><a href="#">お気に入り</a></p>
            <p><a href="../top/cart.php">カート</a></p>
            <p><a href="../login/logout.php">ログアウト</a></p>
            <p><a href="../kaiinjouhou/kaiin_jouhou.php">会員情報</a></p>
        </div>
    </div>
</div>

