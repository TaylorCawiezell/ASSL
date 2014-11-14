<?php
    $user="root";
	$pass="root";
	$mysql = 'mysql:host=localhost;dbname=tasksms;port=8889';
		$dbh = new PDO($mysql, $user, $pass);
		$username=$_POST['suname']; //get POST values 
		$number=$_POST['snumber'];
		$password=$_POST['spassword'];
        $stmt=$dbh->prepare("INSERT INTO user (username,number,password ) VALUES (:username,:number,:password);"); 
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        header('Location: message.php');
        
	die();