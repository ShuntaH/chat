<?php
include 'includes/login.php';

// ファイル全文を読み込んでしまう。欲しいのは見出しである最初の一行だけ
// $info = file_get_contents("./notification/info.txt");
//開いてカーソルが最初に来る。
$fp = fopen("notification/info.txt", "r");
// echo session_id().'<br>';
// echo var_dump($_SESSION['id']);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Chatroom</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./css/index.css">
</head>

<body>
  <div class="header">
    <h1>Chatroom</h1>
    <h2>Menu</h2>
    <p>
      <a href="index.php">Home</a>
      <a href="bbs.php">Board</a>
      <a href="album.php">Album</a>
      <a href="upload.php">Upload Photoes</a>
      <a href="logout.php">Logout</a>
    </p>
    <h2>Nortification</h2>
  </div>

  <?php
  if ($fp) {
    $title = fgets($fp);
    if ($title) {
      echo '<a href="info.php">' . $title . '</a><br>';
    } else {
      echo 'There is no informaion';
    }
    fclose($fp);
  } else {
    echo 'There is no information';
  };
  ?>
  <img src="./img/insominia.jpg">
</body>

</html>