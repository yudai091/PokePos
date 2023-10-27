<?php
error_reporting(0);
try {
    $db = new PDO ('mysql:dbname=pokepos;host=127.0.0.1; charset=utf8', 'root', '');
    $dbh = new PDO ('mysql:dbname=reporter;host=127.0.0.1; charset=utf8', 'root', '');
} catch (PDOException $e) {
    echo 'DB接続エラー' . $e->getMessage;
}
?>