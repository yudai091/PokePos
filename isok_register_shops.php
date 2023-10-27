<?php
session_start();
require('dbconnect.php');

if(!isset($_SESSION['shopId-list'])){
    $_SESSION['shopId-list']=range(1000,10000);
    shuffle($_SESSION['shopId-list']);
}

if(!empty($_POST['y'])){
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
    $statement = $db->prepare('INSERT INTO shops SET shopId=?, name=?, password=?, registered=NOW()');
    $statement->execute(array($_SESSION['shopId-list'][0], $_SESSION['join']['name'], $hash));

    $after_ar_num = array_diff ($_SESSION['shopId-list'], array($_SESSION['shopId-list'][0]));
    $after_ar_num = array_values($after_ar_num);
    $_SESSION['shopId-list'] = $after_ar_num;

    header ('Location: iscontinu_register_shops.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>利用登録確認</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/isok_register.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

            <form action="" method="post" id="registrationform">
                <input type="hidden" name="action" value="submit">
                <p id="list">
                    ユーザー名/店舗名<br>
                    (当アプリの利用画面に表示されます)
                </p>
                <p id="about"><?php echo (htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></p>
                <p id="list">パスワード</p>
                <p id="about">[セキュリティのため非表示]</p>
                    <input type="button" onclick="location.href='register_shops.php?action=rewrite'" value="修正する" name="rewrite">
                    <input type="button" value="登録する" name="registration" id="openBtn">
                </div>
                    <div id="modal" class="modal">
                        <div class="modal_content for_register">
                            <p>登録しますか?</p>
                        <input type="submit" id="register" name="y" value="はい">
                        <input type="button" id="closeBtn" name="n" value="いいえ">
                        </div>
                    </div>
            </form>
            <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/modal.js"></script>
    </body>
</html>