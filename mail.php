<?php
    session_start();
    unset($_SESSION['regiTime']);
    
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    $to = $_SESSION['mailAdd'];
    $subject = "PokePos 利用手続きURLの送信";
    $message = "以下のURLから利用登録して下さい。\r\nhttps://rikohaku.com\r\nURLの有効期限は10分です。\r\n※本メールは送信専用です。本メールに返信いただいても、お問い合わせにお答えすることが出来ません。\r\n※本メールにお心当たりがない場合は、他の方が誤ってメールアドレスを入力した可能性がありますので、お手数ですが本メールの削除をお願いいたします。";
    $headers = "From: yudai5707@gmail.com";
?>
<?php
    if(mb_send_mail($to, $subject, $message, $headers)){
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>メールアドレス入力</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">送信しました</p>
                <p>受信したURLから登録手続きをお願いいたします。</p>
                <input type="button" value="戻る" id="button" onclick="location.href='login.php'">
            </form>
        </div>        
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>
<?php
    }
?>