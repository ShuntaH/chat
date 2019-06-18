<?php
// セッション開始
session_start();

if (isset($_SESSION['id'])) {
    //セッションにユーザーIDがある＝ログインしている
    //トップページに遷移する
    session_regenerate_id(true);
    header('Location: index.php');
    exit();
}




// エラーメッセージ、登録完了メッセージの初期化
$error = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signup"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["name"])) {  // 値が空のとき
        $error = 'Username is not input';
    } elseif (empty($_POST["password"])) {
        $error = 'Password is not input';
    }

    if (!empty($_POST["name"]) && !empty($_POST["password"])) {


        $dsn = 'mysql:host=mysql; dbname=chatroom; charset=utf8';
        $user = 'root';
        $password = 'root';



        // 3. エラー処理
        try {
            echo 'bbbbb';
            $db = new PDO($dsn, $user, $password);
            echo 'aaaaa';
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare(" INSERT INTO users(name, password) VALUES (:name, :password) ");

            $stmt->execute(array(':name' => $_POST['name'], ':password' => sha1($_POST['password'])));
            $signUpMessage = 'Register is done &period; Your name is ' . $_POST['name'] . ' &period; Your Password is ' . $_POST['password'] . '&period;';
        } catch (PDOException $e) {
            $error = 'Database error';
            echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang=en>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signupLogin.css">
    <title>Chatroom</title>
</head>

<body>
    <div class="main">
        <h1 class="title">Chatroom</h1>
        <div class="form">
            <h2>Sign Up</h2>
            <p style="color:red;"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></p>
            <p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
            <form action="signup.php" method="POST" name="form">
                <p><label for="name">Username: <input type="text" id="name" name="name" placeholder="Input name"></label></p>
                <p><label for="password">Password: <input type="password" id="password" name="password" placeholder="Input password"></label></p>
                <input type="submit" name="signup" value="Sign Up">
            </form>
            <br>
            <form action="Login.php">
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>

</html>