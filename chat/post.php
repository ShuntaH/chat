<?php
include 'includes/login.php';
$name = $_POST['name'];
$gender = $_POST['gender'];

if ($gender == 'man') {
    $gender = 'man';
}elseif ($gender = 'woman') {
    $gender = 'woman';
}else {
    $gender = 'Illegal Computer Access';
}

$tem_star = intval($_POST['star']);
$star = '';
if ($tem_star<1 || $tem_star>5) {
    $star = "Illegal Computer Accsess";
}
for ($i=0; $i < $tem_star; $i++) {
    $star .= '★';
}
for (; $i < 5; $i++) {
    $star .= '☆';
}

$feeling = $_POST['feeling'];
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Result</title>
    </head>
    <body>
        <h1>Result</h1>
        <p>Name: <?php echo $name; ?></p>
        <p>Gender: <?php echo $gender; ?></p>
        <p>How satisfied?:<?php echo $star; ?></p>
        <p>You Feeling: <?php echo $feeling; ?></p>
    </body>
</html>