<?php
session_start();
require('dbconnect.php');

if (!empty($_POST) ){
    if ($_POST['shopId'] == "" || $_POST['old_password'] == "" || $_POST['new_password'] == "" || $_POST['new_password2'] == "") {
        $error['form'] = 'blank';
    }
    if($_POST['shopId'] != $_SESSION['id']){
        $error['shopId'] = 'difference';
    }
    if ($_POST['new_password'] != "" ) {
        if (strlen($_POST['new_password'] ) < 6 ) {
            $error['new_password'] = 'length';
        }
    }
    if (($_POST['new_password'] != $_POST['new_password2']) && ($_POST['new_password2'] != "")){
        $error['new_password2'] = 'difference';
    }
    if(empty($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: isok_newpsw.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>新規パスワード設定</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <?php require('menu.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">パスワード再設定</p>
            <?php if (isset($error['form']) && ($error['form'] == "blank")): ?>
                <p class="error"> 全て入力して下さい</p>
            <?php endif; ?>
            <?php if (isset($error['shopId']) && ($error['shopId'] == "difference")): ?>
                <p class="error"> shopIDが正しくありません</p>
            <?php endif; ?>
            <?php if (isset($error['new_password']) && ($error['new_password'] == "length")): ?>
                <p class="error"> パスワードは6文字以上で指定してください</p>
            <?php endif; ?>
            <?php if (isset($error['new_password2']) && ($error['new_password2'] == "difference")): ?>
                <p class="error"> 新パスワードと再入力したパスワードが一致しません</p>
            <?php endif; ?>
            <p id="input_key">shopID</p>
                    <input type="text" id="student_id" name="shopId" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['student_id']??"", ENT_QUOTES); ?>">
            <p id="input_key">旧パスワード</p>
                    <input type="password" id="password" name="old_password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['old_password']??"", ENT_QUOTES); ?>">
                <p id="input_key">新パスワード</p>
                    <input type="password" id="password" name="new_password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['new_password']??"", ENT_QUOTES); ?>">
                <p id="input_key">新パスワード再入力</p>
                    <input type="password" name="new_password2" pattern="[a-zA-Z0-9]+">
                <input type="submit" value="確認する" id="button" class="resister_goodsBtn">
            </form>
        </div>
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>