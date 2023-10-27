<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>利用登録完了</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/iscontinue.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <div class="done">
            <p>登録しました</p>
            <input type="button" onclick="location.href='login.php'" value="ログインする">
        </div>
        <?php require_once('footer.php') ?>
    </body>
</html>