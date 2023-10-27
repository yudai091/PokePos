<?php
session_start();
require('dbconnect.php');

if(isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];
    $messages = $db->prepare('SELECT * FROM posts WHERE message_id=?');
    $messages -> execute(array($id));
    $message = $messages->fetch();
    if ($message['created_by'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM posts WHERE message_id=?');
        $del->execute(array($id));
    }
}
header('Location: reports.php');
exit();
?>