<?php
session_start();
unset($_SESSION['products']);
unset($_SESSION['deposit']);
unset($_SESSION['change']);
header('Location: order.php');
exit();
?>