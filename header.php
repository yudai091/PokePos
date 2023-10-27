<head>
    <link rel="stylesheet" href="css/header.css"/>
</head>
<div class="fixed">
    <div class="header">
        <?php if(isset($_SESSION['shop_name'])){ ?>
            <h1><?php echo (htmlspecialchars($_SESSION['shop_name'], ENT_QUOTES)); ?></h1>
        <?php }else{ ?>
            <h1>PokePos</h1>
        <?php } ?>
    </div>
