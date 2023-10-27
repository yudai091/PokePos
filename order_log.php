<?php
session_start();
require('dbconnect.php');
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
    } else {
    header('Location: login.php');
    exit();
}

$customId_list=$db->prepare('SELECT * FROM rslt_orders WHERE year=? AND shopId=? ORDER BY fin DESC');
$customId_list->execute(array($_GET['y'], $_SESSION['id']));
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>注文履歴</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/common.css"/>
        <link rel="stylesheet" href="css/order_log.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
        <link rel="stylesheet" href="css/pagenation.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <?php require('menu.php') ?>
        <form action="order_log.php" method="get" id="ch_year">
            <div class="gp_chbox">
                <div class="gp_box">
                <?php 
                    $y=date("Y");
                    $now_y=date("Y", strtotime($y));
                    for($i=$now_y; $i>$now_y-3; $i--){ ?>
                    <input id="gp_ch" type="submit" name="y" value="<?php echo $i; ?>">
                <?php } ?>
                        <p id="gp_ttl"><?php $ch_y=$_GET['y']; echo $ch_y.'年度の注文履歴'; ?></p>
                </div>
            </div>
        </form>
        <div class="report_content">
            <?php foreach($customId_list as $customId): ?>
            <form action="order_loglist.php" method="post">
                <div class="report">
                    <input type="hidden" name="customId" value="<?php echo (htmlspecialchars($customId['customId'], ENT_QUOTES)); ?>">
                    <input type="hidden" name="y" value="<?php echo (htmlspecialchars($_GET['y'], ENT_QUOTES)); ?>">
                    お客様番号: <?php echo (htmlspecialchars($customId['customId'], ENT_QUOTES)); ?>
                    <button type="submit" class="btn btn-red ordconf">注文履歴の確認</button>
                </div>
            </form>
            <?php endforeach; ?>
        </div>

        <?php require_once('footer.php') ?>

        <script type="text/javascript" src="javascript/del_modal.js"></script>

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
                $(".report_content").paginathing({
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
    </body>
</html>