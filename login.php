<?php
session_start();
require('dbconnect.php');
if(!empty($_POST)) {
    if(($_POST['shopId'] != '') && ($_POST['password'] != '')) {
        $login = $db->prepare('SELECT * FROM shops WHERE shopId=?');
        $login->execute(array($_POST['shopId']));
        $shop=$login->fetch();

        if(password_verify($_POST['password'],$shop['password'])) {
            $_SESSION['id'] = $shop['shopId'];
            $_SESSION['shop_name'] = $shop['name'];
            $_SESSION['time'] = time();
            header('Location: order.php');
            exit();
        } else {
            $error['login'] = 'failed';
        } 
    } else {
        $error['login'] = 'blank';
    }
}
if(isset($_SESSION['id'])){
    if($_SESSION['time'] + 60*5 > time()){
        header('Location: order.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>PokePos</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/login.css"/>
        <link rel="stylesheet" href="css/common.css"/>
    </head>
    <body>
    <?php require_once('header.php') ?>
        <form action='' method="post" id="registrationform">
            <div class="content">
                <p id="title">ログイン</p>
        <?php if (isset($error['login']) &&  ($error['login'] == 'blank')): ?>
                <p id="error">フォームを入力してください</p>
        <?php endif; ?>
        <?php if( isset($error['login']) &&  $error['login'] == 'failed'): ?>
                <p id="error">もう一度入力して下さい</p>
        <?php endif; ?>
                <div class="flex">
                    <div class="login_form">
                        <div>shopID</div>
                            <input type="text" class="input_tologin" id="student_id" name="shopId" value="<?php echo htmlspecialchars($_POST['shopId']??"", ENT_QUOTES); ?>">
                        <div>パスワード</div>
                            <input type="password" class="input_tologin" id="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                        <div>
                            <input type="submit" id="button" name="button" value="Login">
                        </div>
                    </div>
                    <div class="login_attension">
                        <div>
                            <p>注意</p>
                            <ul>
                                <li>ログインにはshopID・パスワードをお使い下さい</li>
                                <li>shopID・パスワードは半角英数字で入力して下さい</li>
                                <li>shopID・パスワードを第三者に開示しないで下さい</li>
                            </ul>
                            <a href="submit_mail.php"><input type="button" class="btn btn-blue" value="未登録者はこちら"></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php require_once('footer.php') ?>
        <!-- <script type="text/javascript" src="javascript/check_preg.js"></script> -->
    </body>
</html>