<?php
    date_default_timezone_set('Asia/Tokyo');
    $date = new DateTime('now');
    $week = array( '日', '月', '火', '水', '木', '金', '土' );
    $y=date("Y");
    $now_y=date("Y", strtotime($y));
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/hamburger.js"></script>
    <link rel="stylesheet" href="css/menu.css"/>
</head>
<input type="button" value="" ondblclick="buttonDoubleclick()" id="show_menu">
    <div id="nav-open">
    <span id="open_menu"></span>
    </div>
    <div class="user_info">
        <p id="today_datepc">
            <?php echo $date->format('Y/m/d').'('.$week[date('w')].')';?></p>
        <div id="nav-content">
            <div class="hamburger-top"></div>

            <p id="today_datesp">
                <?php echo $date->format('Y/m/d').'('.$week[date('w')].')';?></p>
                
            <ul class="menu_index">
                <li title="HOME"><a href="order.php" class="mypage">HOME</a></li>
                <li title="注文履歴一覧"><a href="order_log.php?y=<?php echo htmlspecialchars($now_y, ENT_QUOTES); ?>" class="list">注文履歴一覧</a></li>
                <li title="商品一覧"><a href="goods_list.php" class="admi_user">商品一覧</a></li>
                <li title="商品登録"><a href="register_goods.php" class="register_user">商品登録</a></li>
                <li title="パスワード設定"><a href="setting_psw.php" class="psw">パスワード設定</a></li>
                <li title="ログアウト"><a href="logout.php" class="logout">ログアウト</a></li>
            </ul>
        </div>
    </div>
</div>