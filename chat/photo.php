<?php
include 'includes/login.php';
$view = $_POST['view'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chatroom: Photo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="./css/photo.css" >
</head>
<body>
  <div class="header">
  <h1>Chatroom: Photo</h1>
    <h2>Menu</h2>
    <p>
      <a href="index.php">Home</a>
      <a href="bbs.php">Board</a>
      <a href="album.php">Album</a>
      <a href="upload.php">Upload Photoes</a>
      <a href="logout.php">Logout</a>
    </p>
  </div>
    

    <div class="img">
      <?php echo '<img src="./album/'.$view.'">'; ?>
    </div>
