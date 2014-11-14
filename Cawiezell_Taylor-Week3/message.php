<?php

$id=$_GET['id'];
        
if($_GET['id']){


if ($_SERVER['REQUEST_METHOD']=='POST') {
    $number=$_POST['number']; //get POST values 
    $carrier=$_POST['carrier']; 
    $body=$_POST['body'];
    $hour=$_POST['hour'];
    $minute=$_POST['minute'];
    $ampm=$_POST['ampm'];
    
    $user="root";
    $pass="root";
    $mysql = 'mysql:host=localhost;dbname=tasksms;port=8889';
    $dbh = new PDO($mysql, $user, $pass);
    $stmt=$dbh->prepare("INSERT INTO message (userId,tonumber,body,status,carrier) VALUES ('".$id."','".$number."','".$body."','sent','".$carrier."');");
    $stmt->execute();
    $messages = $stmt->fetchall(PDO::FETCH_ASSOC);

   
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
	$mail->Body = $body;
    $mail->AddAddress($number.'@'.$carrier);
    
    if(isset($_POST['timed']) && $_POST['timed'] == 'Yes'){
         $time = date("H:i",strtotime($hour.":".$minute.$ampm));
         $messageQuery=$dbh->prepare("select messageId from message where userId='".$id."' and body='".$body."' limit 1;");
         $messageQuery->execute();
         $messageid = $messageQuery->fetch();
         $statusChange=$dbh->prepare("update message set status='timed', time='".$time."' where messageId='".$messageid['messageId']."'limit 1;");
         $statusChange->execute();
         echo "Message Has been timed!";
    }else{
        $mail->Send();
        echo "Message Has been sent!";
    }
    
}
    echo "<!DOCTYPE html>
<html ng-app='tasksms'>
	<head>
		<meta charset='utf-8'>

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>

		<title>Tasksms</title>
		<meta name='viewport' content='width=device-width; initial-scale=1.0'>
		<script type='text/javascript' src='js/angular.min.js'></script>
         <script type='text/javascript' src='js/angular-route.min.js'></script>
         <script type='text/javascript' src='js/app.js'></script>
         <link rel='stylesheet' type='text/css' href='css/main.css'>
	</head>

	<body>
        <header>
            <img src='img/logo.png' />
        </header>
        
		
    
        
		
		 <section ng-controller='messageController as message'>
			<form class='message-form' action='message.php?id=".$id."' method='POST'>
				to: <input type='text' name='number' value='' max='10' required /></br>
				Carrier <select name='carrier'>
			    <option value='messaging.sprintpcs.com'>Sprint</option>
			    <option value='txt.att.net'>ATT</option>
			    <option value='vzwpix.com'>Verizon</option>
			    </select>
			    <br>
                
			     <p>Message</p><textarea name='body' value='' required ></textarea></br>
                 <div class='timer'>
                 
                 <input type='checkbox' name='timed' value='Yes' ng-click='message.timed=!message.timed'/>   
                     <label style='position:relative;bottom:25px;'>Timed Message?</label><br>
                 
                 <div ng-hide='message.timed'>
                 <input class='hour' name='hour' type='text' maxlength='2' />:
                 <input class='minute' name='minute' type='text' maxlength='2' /><select name='ampm'>
                 </div>
            
			    <option value='AM'>AM</option>
			    <option value='PM'>PM</option>
                </select>
            </div>
			  <input type='submit' value='Submit' />
	        </form>
	     </section>
			
			
        <section>
            <h1>Messages</h1>";
            $user="root";
            $pass="root";
            $mysql = 'mysql:host=localhost;dbname=tasksms;port=8889';
            $dbh = new PDO($mysql, $user, $pass);
            $stmt=$dbh->prepare("select * from message where userId =".$id.";");
            $stmt->execute();
            $messages = $stmt->fetchall(PDO::FETCH_ASSOC);
            foreach ($messages as $message) {
				echo "<div class='message'>" ;
  		        echo '<p>to:'.$message['tonumber']."</p><br><h2>".$message['body']."</h2><br>";
                if($message['status'] == 'timed'){
                     echo "<h2>".$message['status']." for: ";
                    echo date("g:i a", strtotime($message['time']))."</h2>";
                  
                }else{
                    echo "<h2>".$message['status']."</h2>";
                }
                echo "<a href='delete.php?id=".$message['userId']."&mid=".$message['messageId']."'>Delete</a>";
                
				echo "</div>";
            }
           
        echo "</section>
       
           
       </body>
</html>";
   

}else{
    
    echo "
    <!DOCTYPE html>
<html ng-app='tasksms'>
	<head>
		<meta charset='utf-8'>

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>

		<title>Tasksms</title>
		<meta name='viewport' content='width=device-width; initial-scale=1.0'>
		<script type='text/javascript' src='js/angular.min.js'></script>
         <script type='text/javascript' src='js/angular-route.min.js'></script>
         <script type='text/javascript' src='js/app.js'></script>
         <link rel='stylesheet' type='text/css' href='css/main.css'>
	</head>

	<body>
        <header>
            <a href='text-app.php'><img src='img/logo.png' /></a>
        </header>
        <h1>Sorry you do not have access to this page! Please Return Home and Login!</h1>
        </body>
</html>";
}

?>

