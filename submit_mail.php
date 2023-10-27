<?php
session_start();
require('dbconnect.php');

if (!empty($_POST) ){
    if ($_POST['mail_add'] == "") {
        $error['form'] = 'blank';
    }
    if(empty($error)) {
        $_SESSION['mailAdd'] = $_POST['mail_add'];
        header('Location: mail.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>メールアドレス入力</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
        <link rel="stylesheet" href="css/common.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">メールアドレス入力</p>
            <?php if (isset($error['form']) && ($error['form'] == "blank")): ?>
                <p class="error">入力して下さい</p>
            <?php endif; ?>
            <p>入力されたメールアドレスに利用登録の手続きURLをお送りします。</p>
            <P>メールが届かない場合は、時間をおいて再度送信して下さい。</p>
                <input type="email" class="mailBox" name="mail_add" placeholder="hoge@sample.com" value="<?php echo htmlspecialchars($_POST['mail_add']??"", ENT_QUOTES); ?>">
                <div class="btnBox">
                    <div><button type="button" class="btn btn-gray" onclick="location.href='/'">戻る</button></div>
                    <div><input type="submit" value="送信する" class="btn btn-blue"></div>
                </div>
            </form>
        </div>        
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>