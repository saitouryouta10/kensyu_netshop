<?php
session_start();

require('../library.php');

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$kenmei = $_SESSION['kenmei'];
$inquiry = $_SESSION['inquiry'];

$db = dbconnect();

$stmt = $db->prepare("insert into inquiry(name, email, kenmei, inquiry_post) VALUES(?,?,?,?)");

if (!$stmt) {
  die($db->error);
  exit();
}

$stmt->bind_param("ssss", $name, $email, $kenmei, $inquiry);

$success = $stmt->execute();
if (!$success) {
  die($db->error);
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>送信完了</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
  <h1 class="text-center">送信完了しました</h1>
  <a class="btn btn-outline-secondary btn-block text-center" href="../top/top.php">トップに戻る</a>

</body>
</html>
