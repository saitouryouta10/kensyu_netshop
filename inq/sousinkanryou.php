<?php
require('../library.php');
require('../lib/DBcontroller.php');
session_start();

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$kenmei = $_SESSION['kenmei'];
$inquiry = $_SESSION['inquiry'];

$dbc = new DBcontroller();

$sql = "insert into inquiry(name, email, kenmei, inquiry_post) VALUES(?,?,?,?)";
$types = "ssss";

$success = $dbc->insert_query($sql, $types, $name, $email, $kenmei, $inquiry)

if (!$success) {
  die($db->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOGEHOGE SHOP-送信完了</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
  <h1 class="text-center">お問い合わせありがとうございます</h1>
  <a class="btn btn-outline-secondary btn-block text-center" href="../top/top.php">トップに戻る</a>

</body>
</html>
