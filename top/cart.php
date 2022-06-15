<?php
require('../library.php');
$db =dbconnect();
session_start();
$item_id=$_GET['id'];

if(isset($_POST['kazuerabi'])){
  $kazuerabi=$_POST['kazuerabi'];
}else{
  $kazuerabi='';
}

if(isset($_SESSION['cart'])==true){
$cart=$_SESSION['cart'];
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
  <a href="top.php">
    <h1 class="title_name">HOGEHOGE SHOP</h1>
  </a>

<?php

foreach($cart as $key => $val){
  $sql = 'select * from items where id=?';

    $stmt =$db ->prepare($sql);
    $data[]=$val;
    // $stmt->bind_Param("s",$data);
    $stmt->execute($data);

    $stmt->bind_result($id,$name,$price,$jenre,$stock,$item_link,$setumei,$syousai,$picture,$created);
}
$max=count($cart);
$name[]=$name;
$price[]=$price;
$picture[]=$picture;

if($rec=$stmt->fetch()): ?>

<?php for($i=0;$i<$max;$i++){
  echo $name[$i] .$price[$i];
}

?>
<?php else : ?>
<p>その商品ページは削除されたか、URLが間違えています</p>
<?php endif ; ?>
</div>

<div>

</div>
</body>
</html>
