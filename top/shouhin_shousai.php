<?php
require('../library.php');
$db =dbconnect();

$item_id=$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
<?php
$sql = 'select * from items where id=?';
$stmt =$db ->prepare($sql);
$stmt->bind_Param("s",$item_id);
$stmt->execute();

$stmt->bind_result($id,$name,$price,$jenre,$stock,$item_link,$setumei,$syousai,$picture,$created);
if($stmt->fetch()): ?>

<div class="s_main">
  <div class="shouhin_img">
    <?php if($picture): ?>
        <img src="./img/<?php echo h($picture); ?>" >
        <?php else: ?>
          <p>商品画像はありません</p>
          <?php endif ;?>
        </div>
     <div>
      <p><?php echo h($name); ?><span class="name"></p>
      <p><?php echo h($price); ?>円</span></p>

      <form action="#" method="POST">
        <select>
      <?php while($stock===0):?>
      <option value=<?php; ?>><? $stock; ?></option>
      <?php $stock -1 ;?>
      <?php endwhile ;?>
    </select>
    <input type="submit" name="submit" value="適用">
      </form>

    </div>
  </div>
  <p ><?php echo h($setumei) ; ?></p>

<?php else : ?>
<p>その商品ページは削除されたか、URLが間違えています</p>
<?php endif ; ?>
</div>


</body>
</html>
