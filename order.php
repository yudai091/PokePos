<?php
$delete_name = isset($_POST['delete_name'])? htmlspecialchars($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';
session_start();
require('dbconnect.php');
if($delete_name != '') unset($_SESSION['products'][$delete_name]);
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
    } else {
    header('Location: login.php');
    exit();
}
$TOKEN_LENGTH = 16;
$tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
$token = bin2hex($tokenByte);
$_SESSION['token'] = $token;
$goods=$db->prepare('SELECT * FROM goods WHERE display=1 AND shopId=?');
$goods->execute(array($_SESSION['id']));
$goods_img=$db->prepare('SELECT * FROM images');
$goods_img->execute();
$img=$goods_img->fetchALL();
?>
<?php
$name = isset($_POST['name'])? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
$price = isset($_POST['price'])? htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8') : '';
$count = isset($_POST['count'])? htmlspecialchars($_POST['count'], ENT_QUOTES, 'utf-8') : '';
session_start();
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
if(isset($_SESSION['products'])){  
//$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products']; 
//$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    foreach($products as $key => $product){  
    //もし、キーとPOSTで受け取った商品名が一致したら、
        if($key == $name && (int)$product['count'] != 0){ 
        //既に商品がカートに入っているので、個数を足し算する     
            $count = (int)$count + (int)$product['count'];
        }
    }
}  
if($name!=''&&$count!=''&&$price!=''){
    $_SESSION['products'][$name]=[
        'count' => $count,
        'price' => $price
    ];
}
$products = isset($_SESSION['products'])? $_SESSION['products']:[];
$total = 0;
$products = isset($_SESSION['products'])? $_SESSION['products']:[];
foreach($products as $name => $product){
$subtotal = (int)$product['price']*(int)$product['count'];
$total += $subtotal;
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>注文画面</title>        
        <?php require_once('meta.php') ?>
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" href="/css/common.css">
        <link rel="stylesheet" href="/css/order.css">
        <link rel="stylesheet" href="/css/pagenation.css">

        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    </head>
    <?php require_once('header.php') ?>
    <?php require_once('menu.php') ?>

    <body>
        <div class="main">
            <div class="wrapper last-wrapper" id="ch_content1">
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
                                    <form action="order.php" method="POST" class="item-form">
                                        <input type="hidden" name="name" value="<?php echo $good['name']; ?>">
                                        <input type="hidden" name="price" value="<?php echo $good['prices']; ?>">
                                        <select name="count" id="goods-cnt">
                                            <option value=""></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                        <button type="submit" class="btn-sm btn-blue">追加</button>
                                    </form>
                                </div>
                            </li>
                            <?php $i+=1;?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container" id="ch_content2">
                <div class="wrapper-title">
                    <h3>追加内容</h3>
                </div>
                <div class="cartlist">
                    <table class="cart-table">
                        <thead>
                            <tr id="sticky">
                                <th>商品名</th>
                                <th>数量</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="conf_table">
                            <?php foreach($products as $name => $product): ?>
                            <tr>
                                <td id="product_name" label="商品名"><?php echo $name; ?></td>
                                <td label="数量" class="text-right"><?php echo $product['count']; ?></td>
                                <td>
                                    <form action="order.php" method="post">
                                        <input type="hidden" name="delete_name" value="<?php echo $name; ?>">
                                        <button type="submit" class="btn btn-red">取消</button>
                                    </form>
                                </td>
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
                    <div class="btn-conf toconf-pc">
                    <a id="usr_a" href="order_conf.php">
                        <input type="button" class="btn btn-red" id="toconf-pc" value="会計">
                    </a>
                    </div>
            </div>
            <div class="spBtns">
                <div class="btn-conf toconf-sp">
                    <a id="usr_a" href="order_conf.php">
                        <input type="button" class="btn btn-red" id="toconf-sp" value="会計">
                    </a>
                </div>
                <div class="chbox">
                    <div class="ch_menu">
                        <input type="button" value="商品一覧" class="btn" id="ord_ch1" >
                    </div>
                    <div class="ch_cart">
                        <input type="button" value="追加内容" class="btn" id="ord_ch2">
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="javascript/order_ch.js"></script>
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
    </body>
</html>