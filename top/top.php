<?php
require('library.php');
$db =dbconnect();

$s='';
if(isset($_POST['narabikae'])){
  $narabikae=$_POST['narabikae'];

  if($narabikae === 'koujun'){
    $s ='order by price desc';
  }
  else if($narabikae === 'shoujun'){
    $s ='order by price asc';
  }
  else{
    $s='order by stock desc';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGE</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>

  <h1 class="title_name">HOGEHOGE SHOP</h1>
  <form action="top.php" method="POST">
    <select name="narabikae" id="narabi">

      <?php if($narabikae ==='koujun'):?>
      <option value="koujun">価格が高い順</option>
      <option value="shoujun">価格が低い順</option>
      <?php elseif($narabikae==='shoujun'): ?>
      <option value="shoujun">価格が低い順</option>
      <option value="koujun">価格が高い順</option>
      <?php else : ?>
        <option value="default">並び替え</option>
        <option value="koujun">価格が高い順</option>
      <option value="shoujun">価格が低い順</option>
        <?php endif ;?>
    </select>
    <input type="submit" name="submit" value="適用">
</form>

    <p class="itiran_title">一覧</p>
<div class="itiran">

  <?php
  $sql ='select * from items '.$s.'';
  $stmt= $db->query($sql);

  $db = null;
  ?>
  <?while( $rec = $stmt->fetch_assoc()): ?>
    <?php $i=0; $i++; ?>
    <?php if($rec==false): ?>
      break;
      <?php endif ?>
      <div class="img_s">
        <div class="pic_size">
      <?php if($rec['picture']==null): ?>
        <div class="arimasen">
          <P class="txt_center">商品画像はありません <br></p>
        </div>
        <?php else: ?>

          <form>
            <a href=""></a>
          <?php '<input type="image" src="echo ./img/'.$rec['picture'].'">' ?>
          </form>

            <?php endif ?>
        </div>
            <table>
              <tr>
                <th class="th_name">
                  <p> <?php echo $rec['name']; ?> </p>
                </th>
                <th class="th_price">
                  <p> <?php echo $rec['price']; ?>円 </p>
                </th>
                <th class="th_txt">
                  <p>椅子は、こしかけるために作られたものや、こしかけるために使われているもの[2]。こしかけるための家具（の総称）である[3][4]。「腰掛け（こしかけ）」とも言う。</p>
                </th>
              </tr>
            </table>

          </div>
          <?php endwhile; ?>
        </div>


</body>
</html>
