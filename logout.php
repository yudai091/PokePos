<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['time']);
unset($_SESSION['shop_name']);
header('Location: login.php');
exit();
?>