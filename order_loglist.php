<?php
session_start();
require('dbconnect.php');
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
    } else {
    header('Location: login.php');
    exit();
}

$cId=$_POST['customId'];
$order_logs=$db->prepare('SELECT * FROM order_logs ol, rslt_orders rslt WHERE ol.customId=? AND ol.year=? AND ol.shopId=? ORDER BY ol.id DESC');
$order_logs->execute(array($cId, $_POST['y'], $_SESSION['id']));
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
        <div class="report_content">
            <?php foreach($order_logs as $order_log): ?>
                <form action="order_conf.php" method="post">
                <div class="indiv_report">
                        <span id="rep">
                            <p>商品名 : <?php echo htmlspecialchars($order_log['name'], ENT_QUOTES); ?></p>
                            <p>個数 : <?php echo htmlspecialchars($order_log['num'], ENT_QUOTES); ?></p>
                            <p>小計 : <?php echo htmlspecialchars($order_log['subtotal'], ENT_QUOTES); ?></p>
                        </span>
                </div>
            <?php endforeach; ?>
            <p id="report_about"> 
                合計 : <?php echo htmlspecialchars($order_log['total'], ENT_QUOTES); ?> | お預かり金 : <?php echo htmlspecialchars($order_log['deposit'], ENT_QUOTES); ?> | お釣り : <?php echo htmlspecialchars($order_log['change_'], ENT_QUOTES); ?>
            </p>
            <button type="button" class="btn btn-blue" onclick="location.href='order_log.php?y=<?php echo htmlspecialchars($_POST['y'], ENT_QUOTES); ?>'">戻る</button>
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