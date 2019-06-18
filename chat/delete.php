<?php
include 'includes/login.php';
$id = intval($_POST['id']);
$pass = $_POST['pass'];
$token = $_POST['token'];



if ($id == '' || $pass == '') {
    header('Location: bbs.php');
}

if ($token != sha1(session_id())) {
    header('Location: bbs.php');
    exit();
}

$dsn = 'mysql:host=localhost; dbname=Chatroom; charset=utf8';
$user = 'Chatroomuser';
$password = 'password';

try {

   $db = new PDO($dsn, $user, $password);
   $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $stmt = $db->prepare(
       "DELETE FROM bbs WHERE id=:id AND pass=:pass"
   );


   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
   $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
   $stmt->execute();


} catch (PDOExeption $e) {
    die('Error:'.$e->getMessage());
}
header("Location: bbs.php");
exit();


?>