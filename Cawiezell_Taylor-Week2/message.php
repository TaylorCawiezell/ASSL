<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $number=$_POST['number']; //get POST values 
    $carrier=$_POST['carrier']; 
    $message=$_POST['message'];
    
    
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;



$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = 'dowebguys@gmail.com';  
	$mail->Password = 'megaman1';           
	$mail->SetFrom('dowebguys@gmail.com', 'TaskSMS');
	$mail->Subject = 'TaskSMS';
	$mail->Body = $message;
    $mail->AddAddress($number.'@'.$carrier);
    $mail->Send();

    
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
        
		
    
        
		
		
		<section>
			<form action="message.php" method="POST">
				Number <input type="text" name="number" value="" max='10' required /></br>
				Carrier <select name='carrier'>
			    <option value="messaging.sprintpcs.com">Sprint</option>
			    <option value="txt.att.net">ATT</option>
			    <option value="vzwpix.com">Verizon</option>
			    </select>
			    <br>
			     Message <textarea name="message" value="" required ></textarea></br>
			  <input type='submit' value='Submit' />
	        </form>
	     <section>
			
       
           
       </body>
</html>