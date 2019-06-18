<?php
include 'includes/login.php';
//データの受け取り
$name = $_POST['name'];
$title = $_POST['title'];
$body = $_POST['body'];
$pass = $_POST['pass'];
$token = $_POST['token'];

//必須項目チェック
if ($name == '' || $body == '') {
    header('Location: bbs.php');
    exit();
}
if (!preg_match("/^[0-9]{4}$/", $pass)) {
    header('Location: bbs.php');
    exit();
}

if ($token != sha1(session_id())) {
    header('Location: bbs.php');
    exit();
}
//名前をクッキーにセット
setcookie('name', $name, time() + 60 * 60 * 24);

//db接続
$dsn = 'mysql:host=localhost; dbname=Chatroom; charset=utf8';
$user = 'Chatroomuser';
$password = 'password';

try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $db->prepare("INSERT INTO bbs(name, title, body, date, pass) VALUES(:name, :title, :body, now(), :pass)");

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->execute();

    header('Location: bbs.php');
    exit();
} catch (PDOException $e) {
    die('Error:'.$e->getMessage());
}
?>