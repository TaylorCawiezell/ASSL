<?php 

$id=$_GET['id'];
$mid=$_GET['mid'];
$user="root";
$pass="root";
$mysql = 'mysql:host=localhost;dbname=tasksms;port=8889';
$dbh = new PDO($mysql, $user, $pass);
$stmt=$dbh->prepare("DELETE FROM message WHERE messageId='".$mid."' ");
$stmt->execute();
header("Location: message.php?id=".$id);
    
    ?>