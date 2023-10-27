<?php 
    session_start();
    require('dbconnect.php');

    $y=date("Y");
    $now_y=date("Y", strtotime($y));
    $total = 0;
    $products = isset($_SESSION['products'])? $_SESSION['products']:[];

    if(!isset($_SESSION['customId'])){
        $_SESSION['customId']=range(1,500);
        shuffle($_SESSION['customId']);
    }

    foreach($products as $name => $product){
        $subtotal = (int)$product['price']*(int)$product['count'];
        $add_order_db=$db->prepare('INSERT INTO order_logs SET customId=?, name=?, num=?, subtotal=?, year=?, shopId=?');
        $add_order_db->execute(array($_SESSION['customId'][0], $name, (int)$product['count'], $subtotal, $now_y, $_SESSION['id']));    
        $total += $subtotal;
    }

    $rslt=$db->prepare('INSERT INTO rslt_orders SET customId=?, total=?, deposit=?, change_=?, year=?, shopId=?');
    $rslt->execute(array($_SESSION['customId'][0], $total, $_SESSION['deposit'], $_SESSION['change'], $now_y, $_SESSION['id']));

    $after_ar_num = array_diff ($_SESSION['customId'], array($_SESSION['customId'][0]));
    $after_ar_num = array_values($after_ar_num);
    $_SESSION['customId'] = $after_ar_num;
    header ('Location: session_clear.php');
    exit();
?>