<?php
require('../lib/DBController.php');
require('../library.php');
// $db =dbconnect();
$db = new DBController;

session_start();
if (isset($_SESSION['id'])) {
    $userid = $_SESSION['id'];
} else {
  $login = 1;
  //セッション情報がなかったらログイン画面に遷移してログイン画面でログインしろ！的なエラーメッセージ出しときます
  header('Location:../login/login.php?login='.$login.'');
  exit();
}
$s = '';
$p = '';


if (isset($_GET['narabikae'])) {
  $narabikae=$_GET['narabikae'];

  if($narabikae === 'koujun'){
    $s ='order by f.created desc';
  }
  else if($narabikae === 'shoujun'){
    $s ='order by f.created asc';
  }
}

if(isset($_POST['itemid'])==true){
  $itemid=$_POST['itemid'];
  //  echo $itemid;
}

if (isset($_GET['nedan'])) {
  $nedan = $_GET['nedan'];
  switch($nedan) {
  case 1 :
    $p = 'and i.price <= 1000';
    break;
  case 2 :
    $p = 'and i.price >=1001 and i.price <= 5000';
    break;
  case 3 :
    $p = 'and i.price >=5001 and i.price <= 10000';
    break;
  case 4 :
    $p = 'and i.price >=10001 and i.price <= 50000';
    break;
  case 5 :
    $p = 'and i.price >=50001';
    break;
  default :
    $p = 'and i.price >= 0';
  }
}


  if(isset($_POST['sakujo_button'])==true){
    $sqls='delete from favorite where id=?';
    $db->insert_query($sqls,'i',$itemid);
  }
  $sql= 'select f.id, f.user_id, f.created, f.item_id, i.id, i.picture,i.name, i.price from favorite f left join items i on item_id=i.id where user_id='.$userid.' '.$p.' '.$s.'';
  $rec = $db->executeQuery($sql,$types=null);

  $sql3='select id from favorite where user_id='.$userid.'';
 $result3 = $db->executeQuery($sql3,$types=null);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOGEHOGE SHOP-お気に入り</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">

</head>
<body>
  <header>
    <?php header_inc(); ?>
  </header>

  <main class="kaiin-body">

  <div class="btn-modoru-rireki">
    <a class="btn btn-outline-secondary btn-block" href="../top/top.php">トップに戻る</a>
  </div>


  <form action="" method="GET">
    <select name="narabikae" id="narabi">
      <?php if($narabikae ==='koujun'):?>
      <option value="koujun">新しい順</option>
      <option value="shoujun">古い順</option>
      <?php elseif($narabikae==='shoujun'): ?>
      <option value="shoujun">古い順</option>
      <option value="koujun">新しい順</option>
      <?php else : ?>
        <option value="default">並び替え</option>
        <option value="koujun">新しい順</option>
      <option value="shoujun">古い順</option>
      <?php endif ;?>
    </select>

    <select name="nedan" id="nedan">
      <option value="default">すべて</option>
      <option value="1">～1000円</option>
      <option value="2">1001円～5000円</option>
      <option value="3">5001円～10000円</option>
      <option value="4">10001円～50000円</option>
      <option value="5">50001円～</option>
    </select>

    <button type="submit" name="">検索</button>
  </form>
  <h1>お気に入り</h1>
  <div class="rireki-table">
    <?php $i=0; ?>
      <?php foreach($rec as $value): ?>
        <?php if($value==false){ break; }?>

        <div class="favo">
          <table>
              <tbody>
                <tr>
                  <td rowspan="5">
                      <a href="../top/shouhin_shousai.php?id=<?php echo $value['item_id']; ?>">
                      <?php if ($value['picture'] == null): ?>
                        <img src="../top/img/noimage.png">
                      <?php else: ?>
                        <img src="../top/img/<?php echo $value['picture'];?>" >
                      <?php endif; ?>
                      </a>
                  </td>
                  <td>商品名 : <span><?php echo $value['name']; ?></span></td>
                </tr>
                <tr>
                  <td>金額 : <span><?php echo $value['price']; ?>円</span></td>
                </tr>
                <tr>
                  <td>追加日 : <span><?php echo $value['created']; ?></span></td>
                </tr>
                <tr>
                  <td>
                      <a class="btn btn-warning" href="../top/shouhin_shousai.php?id=<?php echo $value['item_id'];?>">購入</a>
                  </td>
                </tr>
                <tr>
                  <td>
                  <form action="" method="POST">
                        <input type="hidden" name="itemid" value="<?php echo $result3[$i]['id']; ?>">
                      <button type="submit" name="sakujo_button" class="btn btn-danger">削除</button>
                    </form>
                  </td>
                </tr>
              </tbody>
          </table>
          </div>
          <?php $i++; ?>
      <?php endforeach; ?>
  </div>


    </main>
    <footer>
        <?php footer_inc(); ?>
    </footer>
</body>
</html>
