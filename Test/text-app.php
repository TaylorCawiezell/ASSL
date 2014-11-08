<?php
 
if(isset($_POST['sign-up'])){
    $user="root";
	$pass="root";
	$mysql = 'mysql:host=localhost;dbname=tasksms;port=8889';
		$dbh = new PDO($mysql, $user, $pass);
		$username=$_POST['suname']; //get POST values 
        $stmt=$dbh->prepare("select username from user where username = '".$username."';");
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
        echo "exists! cannot insert";
        }else{
            header('Location: message.php');
        }
 
 }
    
    
    if(isset($_POST['login'])){
    $user="root";
	$pass="root";
	$mysql = 'mysql:host=localhost;dbname=tasksms;port=8889';
		$dbh = new PDO($mysql, $user, $pass);
		$username=$_POST['luname']; //get POST values 
        $password=$_POST['lpassword'];
        $stmt = $dbh->prepare("SELECT * FROM user WHERE username= '".$username."' AND password= '".$password."';");
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_NUM);
        if($rows > 0) {
            header("location: message.php");
        }else{
            echo "Wrong username or Password";
            }
 
 }
?>


<!DOCTYPE html>
<html ng-app='tasksms'>
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Tasksms</title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<script type="text/javascript" src="js/angular.min.js"></script>
         <script type="text/javascript" src='js/angular-route.min.js'></script>
         <script type="text/javascript" src="js/app.js"></script>
         <link rel="stylesheet" type="text/css" href="css/main.css">
	</head>

	<body>
        <header>
            <img src="img/logo.png" />
        </header>
        
		
        
        <!--Section for login page-->
		<section class='home' ng-controller='loginController as login' >
            
            <h1 ng-hide='login.signup'>Welcome: {{suname}}</h1>
			
            <article class='signup'>
                <button ng-click="login.signup=!login.signup">Become a Member</button>
                <form action="text-app.php" method="POST" ng-hide="login.signup">
                        <h1>Username</h1> <input type="text" ng-model="suname" name="suname"><br>
                        <h1>Number</h1><input type="text" name="snumber">
                        <h1>Password</h1><input type="password" name="spassword"><br><br>
                        <input type="submit" value='sign-up' name='sign-up'/>
                    </form>    
            </article>
            
           
            
            <article class='login'>
                <h1 ng-hide='login.form'>Welcome Back {{luname}}</h1>
                <button ng-click="login.form=!login.form">Login</button>
                <form action="text-app.php" method="POST" ng-hide="login.form">
                    <h1>Username</h1> <input type="text" ng-model="luname" name="luname"><br>
                    <h1>Password</h1><input type="password" name="lpassword"><br><br>
                    <input type="submit" value='login' name='login'/>
                </form>
                
            </article>
		</section>
        
        
  
			
       
           
       </body>
</html>
