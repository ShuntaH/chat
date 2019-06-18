<?php
  include 'includes/login.php';
  $num = 10;

  $dsn = 'mysql:host=localhost; dbname=chatroom; charseet=utf8';
  $user = 'Chatroomuser';
  $password = 'password';
  $hash = password_hash($_REQUEST['pass'], PASSWORD_BCRYPT);


  $page = 0;
  if(isset($_GET['page']) && $_GET['page'] > 0 ){
      $page = intval($_GET['page']) -1;
  }

  try {
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $stmt = $db->prepare(
          "SELECT * FROM bbs ORDER BY date DESC LIMIT :page, :num"
      );

      $page = $page * $num;
      $stmt->bindParam(':page', $page, PDO::PARAM_INT);
      $stmt->bindParam(':num', $num, PDO::PARAM_INT);

      $stmt->execute();
  } catch (PDOException $e) {
      echo "Error:".$e->getMessage();
  }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chatroom: Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/bbs.css">
</head>
<body>
  <div class="header">
    <h1>Chatroom: Board</h1>
    <h2>Menu</h2>
    <p>
      <a href="index.php">Home</a>
      <a href="bbs.php">Board</a>
      <a href="album.php">Album</a>
      <a href="upload.php">Upload Photoes</a>
      <a href="logout.php">Logout</a>
    </p>
  </div>
  <div class="main">
    <div class="form">
      <form action="write.php" method="POST">
        <ul>
          <li><label for="name">Name:</label> <input type="text" id="name" name="name" value="<?php echo isset($_COOKIE['name']) ? $_COOKIE['name'] : "" ; ?>"></li>
          <li><label for="title">Title:</label><input type="text" id="title" name="title"></li>
          <li><label for="message">Message:</label><br><textarea id="message" name="body"></textarea></li>
          <li><label for="pass">Password to Delete:</label><input type="password" id="pass" name="pass"></li>
          <li><input type="submit" value="write"></li>
          <li><input type="hidden" id="token" name="token" value=" <?php echo　password_verify(session_id());?> "></li>
        </ul>
      </form>
    </div>


  <?php
    while ($row = $stmt->fetch()):
      //３項演算子　条件式がtureなら:左、falseなら:右
      $title = $row['title'] ? $row['title'] : '(No title)';
  ?>
    <div class="comments">
      <ul>
        <li>Name: <?php echo htmlspecialchars($row['name']) ?></li>
        <li>Title: <?php echo htmlspecialchars($title) ?></li>
        <li><?php echo htmlspecialchars($row['body'])?></li>
        <li><?php echo htmlspecialchars($row['date'])?></li>
        <form action="delete.php" method="POST">
          <li><input type="hidden" name="id" value="<?php echo $row['id']; ?>"></li>
          <li>Password to delete this: <input type="password" name="pass"></li>
          <li><input type="submit" value="Delete"></li>
          <li><input type="hidden" name="token" value="<?php sha1(session_id()); ?>"></li>
        </form>
      </ul>
    </div>


<?php
  endwhile;

  try {
      $stmt = $db->prepare("SELECT COUNT(*) FROM bbs");
      $stmt->execute();
  } catch (PDOException $e) {
      echo "Error:".$e->getMessage();
  }

  $comments = $stmt->fetchColumn();
  $max_page = ceil($comments / $num);
  echo '<p>';
  for($i = 1; $i <= $max_page; $i++){
      echo '<a href="bbs.php?page='.$i.'">'.$i.'</a>&nbsp;';
  }
?>
  </div>
</body>
</html>