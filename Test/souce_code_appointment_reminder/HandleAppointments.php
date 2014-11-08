<?php
if(isset($_POST['DialedNumber']) && isset($_POST['ScheduledDate']) && isset($_POST['ScheduledTime']) && isset($_POST['ScriptId']) )
  {
    $con=mysqli_connect("127.0.0.1","root","","mysql");

		//check the sate of the connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit();
	}
	
	$tableExist = mysqli_query($con,"SELECT 1 FROM 'ozmlout'");
	
	if ($tableExist !== true)
	{
		if(mysqli_query($con,"CREATE TABLE ozmlout(
							ID int(10) NOT NULL AUTO_INCREMENT,
							DialedNumber varchar(40) NOT NULL,
							Status varchar(40) DEFAULT NULL,
							Duration int(10) DEFAULT NULL,
							ScriptId int(10) DEFAULT NULL,
							RecordUrl varchar(150) DEFAULT NULL,
							StartTime datetime DEFAULT NULL,
							ScheduledTime datetime DEFAULT NULL,
							PRIMARY KEY (ID))"))
		{
			echo "Table ozmlout created. ";
		}
	}

	//insert data
	$state = mysqli_query($con,"INSERT INTO ozmlout (ID, DialedNumber, Status, Duration, ScriptId, RecordUrl, StartTime, ScheduledTime)
								VALUES (NULL, '".$_POST['DialedNumber']."', 'call', NULL, ".$_POST['ScriptId'].", NULL, NULL, '".$_POST['ScheduledDate']." ".$_POST['ScheduledTime']."')");
	mysqli_close($con);
	
	if ($state == 1)
		echo "Success";
	else
		echo "Unsuccess";
  }
else
	echo "Unsuccess";
?>