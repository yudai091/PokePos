<?php
session_start();
require('dbconnect.php');
if(!isset($_SESSION['regiTime'])){
    $_SESSION['regiTime'] = time();
}
if($_SESSION['regiTime'] + 600 > time()){
    $show=1;
    if (!empty($_POST) ){
        if ($_POST['name'] == "" || $_POST['password'] == "" || $_POST['password2'] == "") {
            $error['form'] = 'blank';
        }
        if ($_POST['password'] != "" ) {
            if (strlen($_POST['password'] ) < 6 ) {
                $error['password'] = 'length';
            }
        }
        if (($_POST['password'] != $_POST['password2']) && ($_POST['password2'] != "")){
            $error['password2'] = 'difference';
        }
        if(empty($error)) {
            $_SESSION['join'] = $_POST;
            header('Location: isok_register_shops.php');
            exit();
        }
    }
}else{
    $show=0;
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>利用登録画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">利用登録</p>
            <?php if($show==1){ ?>
            <?php if (isset($error['form']) && ($error['form'] == "blank")): ?>
                <p class="error"> 全て入力して下さい</p>
            <?php endif; ?>
            <?php if (isset($error['password']) && ($error['password'] == "length")): ?>
                <p class="error"> パスワードは6文字以上で指定してください</p>
            <?php endif; ?>
            <?php if (isset($error['password2']) && ($error['password2'] == "difference")): ?>
                <p class="error"> パスワードが一致しません</p>
            <?php endif; ?>
                <p id="input_key">
                    ユーザー名/店舗名<br>
                    (当アプリの利用画面に表示されます)
                </p>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name']??"", ENT_QUOTES); ?>">
                <p id="input_key">パスワード</p>
                    <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                <p id="input_key">パスワード再入力</p>
                    <input type="password" name="password2" pattern="[a-zA-Z0-9]+">
                <input type="submit" value="確認する" id="button">
            <?php }else{ ?>
                <p id="input_key">
                    タイムアウト<br>
                    お手数ですが、最初からやり直してください
                    <input type="button" value="戻る" onclick="location.href='login.php'" id="button">
                </p>
            <?php } ?>
            </form>
        </div>        
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>
