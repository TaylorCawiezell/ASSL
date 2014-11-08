<?php
if(isset($_POST['OzMLCommands']))
  {
    $con=mysqli_connect("127.0.0.1","root","","mysql");

	//check the sate of the connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit;
	}
	
	$tableExist = mysqli_query($con,"SELECT 1 FROM 'ozmlsripts'");
	
	if ($tableExist !== true)
	{
		if(mysqli_query($con,"CREATE TABLE ozmlscripts(
							ID int(10) NOT NULL AUTO_INCREMENT,
							Ozml varchar(10000) NOT NULL,
							PRIMARY KEY (ID))"))
		{
			echo "Table ozmlscripts created. ";
		}
	}
	
	//insert data
	$state = mysqli_query($con,"INSERT INTO ozmlscripts (ID, Ozml)
									    VALUES (NULL, '<Response>".$_POST['OzMLCommands']."</Response>')");
	mysqli_close($con);
	
	if ($state == 1)
		echo "Success";
	else
		echo "Unsuccess";
  }
else
	echo "Unsuccess";
?>