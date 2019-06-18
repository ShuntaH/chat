<?php
    include 'includes/login.php';
    $msg = null;
    // echo var_dump(exif_imagetype($_FILES['image']['tmp_name']));

    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    // <----サムネイルアップロード---->

    // サムネイル用のキャンバスを作っていく

    $new_width = 250; //サムネイルの幅

    //元画像の縦幅サイズを取得
    list($width, $height) = getimagesize($_FILES['image']['tmp_name']);

    // 画像のサイズ比率を計算
    $rate = $new_width / $width; //比率
    $new_height = $rate * $height; // サムネイルの高さ

    // 計算したサイズでキャンバス（リソース）を作成する
    $canvas = imagecreatetruecolor($new_width, $new_height);

    // アップロードした画像の拡張子によって新ファイル名と画像の読み込み方を変える
    switch (exif_imagetype($_FILES['image']['tmp_name'])){
        // 型を取得する関数
        // JPEG
        case IMAGETYPE_JPEG:

        $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
        // 画像のリソースを取得する関数
        imagecopyresampled($canvas, $image, 0,0,0,0, $new_width, $new_height, $width, $height);
        // 画像サイズを変更する関数　画像の形式はまだ決まっていない
        $image_name = date("YmdHis"); //ベースとなるファイル名は日付
        $image_name .= mt_rand();
        $image_name .= '.jpg';
        imagejpeg($canvas, 'images/'.$image_name);
        // 画像を保存する関数 この段階で画像形式を決める
        break;

        // GIF
        case IMAGETYPE_GIF:
        $image = imagecreatefromgif($_FILES['image']['tmp_name']);
        imagecopyresampled($canvas, $image, 0,0,0,0,$new_width, $new_height, $width, $height);
        $image_name = date("YmdHis"); //ベースとなるファイル名は日付
        $image_name .= mt_rand();
        $image_name .= '.gif';
        imagegif($canvas, 'images/'.$image_name);
        // jpegで出力したいときはimagejpeg
        break;

        // PNG
        case IMAGETYPE_PNG:
        $image = imagecreatefrompng($_FILES['image']['tmp_name']);
        imagecopyresampled($canvas, $image, 0,0,0,0, $new_width, $new_height, $width, $height);
        $image_name = date("YmdHis"); //ベースとなるファイル名は日付
        $image_name .= mt_rand();
        $image_name .= '.png';
        imagepng($canvas, 'images/'.$image_name);
        // jpegで出力したいときはimagejpeg
        break;

        default:
        header('Location: upload.php');
        exit();

    }

    imagedestroy($image);
    imagedestroy($canvas);





    // <----オリジナルサイズ画像アップロード---->
    // echo var_dump($_FILES).'<br>';
    $old_name = $_FILES['image']['tmp_name'];
    // echo var_dump($old_name).'<br>';
    //   $new_name = $_FILES['image']['name']; //同じ名前のファイルがあるとき上書きされてしまう
    //   echo var_dump($new_name).'<br>';
    // $new_name = date("YmdHis"); //ベースとなるファイル名は日付
    // $new_name .= mt_rand(); //ランダムな数字も追加
    // switch (exif_imagetype($_FILES['image']['tmp_name'])) {
    //     case IMAGETYPE_JPEG:
    //         $image_name .= '.jpg';
    //         break;
    //     case IMAGETYPE_GIF:
    //         $image_name .= '.gif';
    //         break;
    //     case IMAGETYPE_PNG:
    //         $image_name .= '.png';
    //         break;
    //     default:
    //         header('Location: upload.php');
    //         exit();
    // }


      if (move_uploaded_file($old_name, 'album/'.$image_name)) {
          $msg = 'Upload is done. Go to <a href="album.php">Album</a> to view pictures.';
      } else {
          $msg = 'Upload was failed';
      }
  }


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chatroom: Uproad Photoes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="./css/upload.css" />
</head>
<body>
    <div class="header">
        <h1>Chatroom: Upload Photoes</h1>
        <h2>Menu</h2>
        <p>
        <a href="index.php">Home</a>
        <a href="bbs.php">Board</a>
        <a href="album.php">Album</a>
        <a href="upload.php">Upload Photoes</a>
        <a href="logout.php">Logout</a>
        </p>
    </div>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="Upload">
    </form>
    <?php
      if ($msg) {
          echo '<p>'.$msg.'</p>';
      }
    ?>


</body>
</html>