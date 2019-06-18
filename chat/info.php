<?php
  include 'includes/login.php';
  $fp = fopen("./notification/info.txt", "r");
  $line = array();
  if ($fp) {
     while (!feof($fp)) {
         $line[] = fgets($fp);
     }
  }
  fclose($fp);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">
    <title>Chatroom</title>
</head>
  <body>
      <div class="header">
        <h1>Chatroom: Information</h1>
        <h2>Menu</h2>
        <p>
          <a href="index.php">Home</a>
          <a href="bbs.php">Board</a>
          <a href="album.php">Album</a>
          <a href="upload.php">Upload Photoes</a>
          <a href="logout.php">Logout</a>
        </p>
      </div>
      <?php
        if (count($line) > 0) {

          for ($i=0; $i < count($line); $i++) {
              if ($line[0] === 0) {
                  echo '<h3>'.$line[0].'</h3>';
              }else {
                  echo $line[$i].'<br>';
              }
          }

        }else {
            echo 'There is no informaion';
        }
      ?>
  </body>
</html>