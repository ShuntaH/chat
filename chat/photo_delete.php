<?php

$delete = $_POST['delete'];
// var_dump($delete);
unlink('./images/'.$delete);
unlink('./album/'.$delete);

header('Location: album.php');
exit();