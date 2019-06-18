<?php
    include 'includes/login.php';
    $images = array();
    $num = 6;

    if ($handle = opendir('./images')) {
        while ($entry = readdir($handle)) {
            if ($entry != "." && $entry != "..") {
                $images[] = $entry;
            }
        }
        closedir($handle);
    }

?>
<!-- 画像の削除機能つけたい -->

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Chatroom: Album</title>
    <link rel="stylesheet" href="./css/album.css">
  </head>

  <body>
    <div class=header>
        <h1>Chatroom: Album</h1>
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
if (count($images) > 0) {
    $images = array_chunk($images, $num);
    $page = 0;
    // echo var_dump($images);

    if (isset($_GET['page']) && is_numeric($_GET['page'])){
        $page = intval(($_GET['page'])) -1;
        // $pageに無い数字ex100とかが入っていた場合
        if (!isset($images[$page])){
            $page = 0;
        }
        // echo var_dump($images['1']);

    }

    foreach ($images[$page] as $img) {
        // echo var_dump($images);
?>
       <div class="img">
            <?php echo '<img src="./images/'.$img.'">'  ?>
            <form action="photo.php" method="POST" enctype="multipart/form-data">
                <input type="submit" value="view">
                <input type="hidden" name='view' value="<?php echo $img;  ?>">
            </form>
            <form action="photo_delete.php" method="POST" enctype="multipart/form-data">
                <input type="submit" value="Delete">
                <input type="hidden" name='delete' value="<?php echo $img;  ?>">
            </form>
       </div>
<?php

    }

    echo '<p>';
    for ($i = 1; $i <= count($images); $i++){
        echo '<a href="album.php?page='.$i.'">'.$i.'</a> &nbsp;';
    }
    echo'</p>';
}else{
echo '<p>Photos do not exist yet</p>';
        }
?>



  </body>
</html>