<?php
session_start();
require('dbconnect.php');

if (!empty($_POST) ){
    if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['password']) || empty($_POST['password2'])) {
        $error['form'] = 'blank';
    }
    if (!empty($_POST['password'])&&$_POST['password'] != "test" ) {
        $error['password'] = 'difference';
    }
    if(substr(strrchr($_FILES['img']['name'], '.'), 1) != "png"){
        $error['img'] = 'notPng';
    }
    if(empty($error)) {
        $_SESSION['goods'] = $_POST;
        $_SESSION['file']['name']=$_FILES['img']['name'];
        $_SESSION['file']['type']=$_FILES['img']['type'];
        $_SESSION['file']['content']=$_FILES['img']['tmp_name'];
        $_SESSION['file']['size']=$_FILES['img']['size'];

        $storeDir = './image/goods/';
        $image = $_SESSION['goods']['name'] . '.' . substr(strrchr($_FILES['img']['name'], '.'), 1);
        move_uploaded_file($_FILES['img']['tmp_name'], $storeDir . $image);

        header('Location: isok_register_goods.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>新規商品登録画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <?php require_once('menu.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">商品登録</p>
            <?php if (isset($error['form']) && ($error['form'] == "blank")): ?>
                <p class="error"> 全て入力して下さい</p>
            <?php endif; ?>
            <?php if (isset($error['password']) && ($error['password'] == "difference")): ?>
                <p class="error"> パスワードが違います</p>
            <?php endif; ?>
            <?php if (isset($error['img']) && ($error['img'] == "notPng")): ?>
                <p class="error"> png画像にしてください</p>
            <?php endif; ?>
                <p id="input_key">商品名</p>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name']??"", ENT_QUOTES); ?>">
                <p id="input_key">価格(提供額)</p>
                    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($_POST['price']??"", ENT_QUOTES); ?>">
                <p id="input_key">商品画像(.png)</p>
                    <input type="file" id="file" name="img" accept=".png" style="width:100%;">
                <p id="input_key">パスワード</p>
                    <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                <p id="input_key">パスワード再入力</p>
                    <input type="password" name="password2" pattern="[a-zA-Z0-9]+">
                <input type="submit" value="確認する" id="button" class="resister_goodsBtn">
            </form>
        </div>
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>