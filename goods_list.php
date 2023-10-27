<?php
session_start();
require('dbconnect.php');
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
    } else {
    header('Location: login.php');
    exit();
}
$goods=$db->prepare('SELECT * FROM goods WHERE shopId=?');
$goods->execute(array($_SESSION['id']));
if(isset($_POST['chDisplay'])){
    if ($_POST['display'] == 0) {
        $not_display = $db->prepare('UPDATE goods SET display=0 WHERE name=?');
        $not_display->execute(array($_POST['name']));
    }
    else{
        $display = $db->prepare('UPDATE goods SET display=1 WHERE name=?');
        $display->execute(array($_POST['name']));
    }
}
if(isset($_FILES['chImg']['name'])){
    $format = substr(strrchr($_FILES['chImg']['name'], '.'), 1);
    // $change_img=$db->prepare('UPDATE images SET img_name=? WHERE img_id=?');
    // $change_img->execute(array("a",2));

    $change_img=$db->prepare('UPDATE images SET img_name=?, img_type=?, img_content=?, img_size=?, addedDay=NOW() WHERE img_name=?');
    $statement->execute(array($_FILES['chImg']['name'], $format, $_FILES['chImg']['tmp_name'], $_FILES['chImg']['size'], $_POST['name'].png));
    $storeDir = './image/goods/';
    $image = $_POST['name'] . '.' . substr(strrchr($_FILES['chImg']['name'], '.'), 1);
    move_uploaded_file($_FILES['img']['tmp_name'], $storeDir . $image);
}

$goods_img=$db->prepare('SELECT * FROM images');
$goods_img->execute();
$img=$goods_img->fetchALL();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>商品管理画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/goods_list.css"/>
        <link rel="stylesheet" href="css/common.css"/>
        <link rel="stylesheet" href="css/pagenation.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <?php require('menu.php') ?>

        <div class="main">
                <div class="container">
                    <div class="wrapper-title">
                        <h3>商品一覧</h3>
                    </div>
                    <div class="itemlist">
                        <ul id="goods-ul">
                            <?php $i=0;?>
                            <?php foreach($goods as $good): ?>
                            <li id="goods-li">
                                <div class="item-body">
                                    <h5><?php echo $good['name']; ?></h5>
                                    <img src="image/goods/<?php echo $img[$i]['img_name']; ?>" alt="<?php echo $img[$i]['img_name']; ?>">
                                    <p>¥<?php echo $good['prices']; ?></p>
                                    <form action="" method="post">
                                        <input type="hidden" name="name" value="<?php echo $good['name']; ?>">
                                        <input type="hidden" name="price" value="<?php echo $good['prices']; ?>">      
                                    <select name="display">
                                    <?php if($good['display'] != 0){ ?>
                                        <option value="0">非表示</option>
                                    <?php }else { ?>
                                        <option value="1">表示</option>
                                    <?php } ?>
                                    </select>
                                    <input type="submit" name="chDisplay" class="btn-ref btn-blue" value="反映">
                                    </form>
                                    <!-- <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="name" value="<?php echo $good['name']; ?>">
                                        <input type="file" id="ci" name="chImg" accept=".png">
                                        <input type="submit" name="chImg" class="btn-ref btn-blue" value="写真変更" require
                                        >
                                    </form> -->
                                </div>
                            </li>
                            <?php $i+=1;?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php require('footer.php') ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="javascript/pagenation.js"></script>
        
        <script type="text/javascript">
        var windowWidth = window.innerWidth;
        var pages;
        if (windowWidth < 767) {
            pages = 4;
        } else {
            pages = 6;
        }
        jQuery(document).ready(function ($) {
            $("#goods-ul").paginathing({
            perPage: pages,
            firstLast: true,
            firstText: "<<",
            lastText: ">>",
            prevText: "<",
            nextText: ">",
            activeClass: "active",
            });
        });
        </script>
    </bory>
</html>