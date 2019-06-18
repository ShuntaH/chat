<?php
session_start();
$error = '';
// ini_set('display_errors', true);
// error_reporting(E_ALL);

if (isset($_SESSION['id'])) {
    //セッションにユーザーIDがある＝ログインしている
    //トップページに遷移する
    session_regenerate_id(true);
    header('Location: index.php');
    exit();
}

if (isset($_POST['login'])) {
    if (empty($_POST['name'])) {
        $error = 'Username is not input';
    } elseif (empty($_POST['password'])) {
        $error = 'Password is not input';
    }
    //issetで判定をすると空文字もtrueになってしまう

    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        try {
            // データベースに接続
            $dsn = 'mysql:host=mysql; dbname=chatroom; charset=utf8';
            $user = 'root';
            $password = 'root';

            $db = new PDO($dsn, $user, $password);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare("
            SELECT * FROM users WHERE name=:name");

            $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            // $stmt->bindParam(':pass',$hashVerify , PDO::PARAM_STR);
            $stmt->execute();
            //password_hashを認証するときはphp上でやる必要があり、fetchしてから

            if ($row = $stmt->fetch()) {
                if (password_verify($_POST['password'], $hash)) {
                    //ユーザーが存在していたので、セッションにユーザーIDをセット
                    $_SESSION['id'] = $row['id'];
                    session_regenerate_id(true);
                    header('Location: index.php');
                    exit();
                } else {
                    $error = 'Username or password is not correct';
                    //1レコードも取得できなかった場合
                    //ユーザー名パスワードが間違っている可能性あり
                    //もう一度ログインフォームを表示
                }
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
            //       $errorMessage =        $sql;
            //        $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo        $e->getMessage();
        }
    }
}
//ログインしていない場合はログインフォームを表示する
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatroom</title>
    <link rel="stylesheet" href="./css/signupLogin.css">
</head>

<body>
    <div class="main">
        <h1 class="title">Chatroom</h1>
        <div class="form ">
            <h2>Login</h2>
            <p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
            <form action="login.php" method="POST" name="form">
                <p><label for="name">Username: <input type="text" id="name" name="name" placeholder="Input username" value="<?php if (!empty($_POST["username"])) {
                                                                                                                                echo htmlspecialchars($_POST["username"], ENT_QUOTES);
                                                                                                                            } ?>"></label></p>
                <p><label for="password">Password: <input type="password" id="password" name="password" placeholder="Input password"></label></p>
                <input type="submit" name="login" value="Login">
            </form>
            <br>
            <form action="signup.php" method="POST" name="form">
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </div>

</body>

</html>