<?php
// サムネイル用のキャンバスを作っていく

$new_width = 250; //サムネイルの幅

//元画像の縦幅サイズを取得
list($width, $height) = getimagesize($_FILES['file']['tmp_name']);

// 画像のサイズ比率を計算
$rate = $new_width / $width; //比率
$new_height = $rate * $height; // サムネイルの高さ

// 計算したサイズでキャンバス（リソース）を作成する
$canvas = imagecreatetruecolor($new_width, $new_height);


// アップロードした画像の拡張子によって新ファイル名と画像の読み込み方を変える
switch (exif_imagetype($_FILES['file']['tmp_name'])){
    // 型を取得する関数
    // JPEG
    case IMAGETYPE_JPEG:
      $image = imagecreatefromjpeg($_FILES['file']['tmp_name']);
      // 画像のリソースを取得する関数
      imagecopyresampled($canvas, $image, 0,0,0,0, $new_width, $new_height, $width, $height);
      // 画像サイズを変更する関数
      imagejpeg($canvas, 'images/new_image.jpg');
      // 画像を保存する関数
      break;

    // GIF
    case IMAGETYPE_GIF:
      $image = imagecreatefromgif($_FILES['file']['tmp_name']);
      imagecopyresampled($canvas, $image, 0,0,0,0,$new_width, $new_height, $width, $height);
      imagegif($canvas, 'images/new_image.gif');
      break;

    // PNG
    case IMAGETYPE_PNG:
      $image = imagecreatefrompng($_FILES['file']['tmp_name']);
      imagecopyresampled($canvas, $image, 0,0,0,0, $new_width, $new_height, $width, $height);
      imagepng($canvas, 'images/new_image.png');
      break;

    default:
      exit();

}

imagedestroy($image);
imagedestroy($canvas);

?>