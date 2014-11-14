<?php
    $user="root";
	$pass="root";
	$mysql = 'mysql:host=localhost;dbname=clients;port=8889';
		$dbh = new PDO($mysql, $user, $pass);
		$username=$_POST['suname']; //get POST values 
		$phone=$_POST['snumber'];
		$email=$_POST['spass'];
		$stmt=$dbh->prepare("INSERT INTO clients (number,username,password ) VALUES (:username,:phone,:password);"); 
		 
		$stmt->bindParam(':number', $number); 
	    $stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->execute();
	header('Location: message.php'); 
	die();