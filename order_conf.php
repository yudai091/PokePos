<?php 
    session_start();
    $total = 0;
    $products = isset($_SESSION['products'])? $_SESSION['products']:[];
    foreach($products as $name => $product){
    $subtotal = (int)$product['price']*(int)$product['count'];
    $total += $subtotal;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>商品確認</title>
<?php require('meta.php') ?>
<link rel="stylesheet" href="/css/common.css">
<link rel="stylesheet" href="/css/order.css">
</head>
<body>
    <?php require('header.php') ?>

<div class="container" id="ch_content2-5">
    <div class="wrapper-title">
        <h3>商品確認</h3>
    </div>
        <div class="cartlist">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>個数</th>
                        <th>小計</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $name => $product): ?>
                    <tr>
                        <td label="商品名："><?php echo $name; ?></td>
                        <td label="価格：" class="text-right">¥<?php echo $product['price']; ?></td>
                        <td label="個数：" class="text-right"><?php echo $product['count']; ?></td>
                        <td label="小計：" class="text-right">¥<?php echo $product['price']*$product['count']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
            <table class="total_table">
                <tbody>
                    <tr id="note_tr">
                        <th>合計</th>
                        <td>¥<?php echo $total; ?></td>
                    </tr>
                </tbody>
            </table>
</div>
<div class="btn-conf orcf">
        <button type="button" class="btn btn-blue" onclick="location.href='order.php'">戻る</button>
        <button type="button" class="btn btn-gray" onclick="location.href='payment.php'">会計へ</button>
    </div>

<?php require_once('footer.php') ?>
</body>
</html>