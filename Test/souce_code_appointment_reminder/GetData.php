<?php
    $con=mysqli_connect("127.0.0.1","root","","mysql");

	//check the sate of the connection
	if (mysqli_connect_errno())
	  {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit;
	  }

	//Get Columns
	$columns = mysqli_query($con,"SHOW COLUMNS FROM ".$_POST['TableName']);
	if (!$columns) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}

	$columnHeaders = array();
	
	//Get and fill columnHeaders
	if (mysqli_num_rows($columns) > 0) {
		while ($row = mysqli_fetch_assoc($columns)) {
			$columnHeaders[] = $row['Field'];
		}
	}
	
	//Get rows 
	$result = mysqli_query($con,"SELECT * FROM ".$_POST['TableName']);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}

	mysqli_close($con);
	
	//Return the values of the columns
	echo "<div><table border='1'>";
		echo "<tr>";
			foreach ($columnHeaders as $header) {
				echo "<th>".$header."</th>";
			}
		echo "</tr>";

		while($row = mysqli_fetch_array($result))
		{	
			echo "<tr>";
				foreach ($columnHeaders as $header) {
					echo "<td>" . htmlspecialchars($row[$header]) . "</td>";
				}
			echo "</tr>";
		}  
	echo "</table></div>";
?>