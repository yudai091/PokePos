<?php
session_start();
unset($_SESSION['shopId-list']);
unset($_SESSION['customId']);
header('Location: order.php');
exit();
?>