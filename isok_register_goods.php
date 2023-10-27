<?php
session_start();
require('dbconnect.php');

if(!empty($_POST)){
    $statement = $db->prepare('INSERT INTO goods SET name=?, prices=?, addedDay=NOW(), shopId=?');
    $statement->execute(array($_SESSION['goods']['name'], $_SESSION['goods']['price'], $_SESSION['id'] ));
    $reset_inc_set=$db->query('SET @i:=0, @j:=0');
    $reset_inc=$db->query('UPDATE goods SET goods_id=(@i := @i +1), img_id = (@j := @j +1)');

    // 画像を保存
    if (!empty($_SESSION['file']['name'])) {
        $format = substr(strrchr($_SESSION['file']['name'], '.'), 1);
        $image = $_SESSION['goods']['name'] . '.' . $format;
        $statement = $db->prepare('INSERT INTO images SET img_name=?, img_type=?, img_content=?, img_size=?, addedDay=NOW()');
        $statement->execute(array($image, $format, $_SESSION['file']['content'], $_SESSION['file']['size']));
        $reset_inc_set=$db->query('SET @i:=0');
        $reset_inc=$db->query('UPDATE images SET img_id=(@i := @i +1)');
    
        move_uploaded_file($_SESSION['file']['content'], './image/goods' . $image);

        header ('Location: iscontinu_register_goods.php');
        exit();    
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ユーザー登録確認</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/isok_register.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

            <form action="" method="post" id="registrationform">
                <input type="hidden" name="action" value="submit">
                    <!-- <p id="list"></p> -->
                    <p id="about">商品名: <?php echo (htmlspecialchars($_SESSION['goods']['name'], ENT_QUOTES)); ?></p>
                    <!-- <p id="list"></p> -->
                    <p id="about">価格: <?php echo (htmlspecialchars($_SESSION['goods']['price'], ENT_QUOTES)); ?>円(税込)</p>
                    <img src="image/goods/<?php echo $_SESSION['goods']['name'] . '.png';?>">
                <input type="button" onclick="location.href='register_goods.php?action=rewrite'" value="修正する" name="rewrite">
                <input type="button" value="登録する" name="registration" id="openBtn">
                    <div id="modal" class="modal">
                        <div class="modal_content for_register">
                            <p>登録しますか?</p>
                        <input type="submit" id="register" value="はい">
                        <input type="button" id="closeBtn" value="いいえ">
                        </div>
                    </div>
            </form>
            <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/modal.js"></script>
    </body>
</html>