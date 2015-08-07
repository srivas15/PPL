<?php
session_start();
?>
<html>
<body>
Leaderboards.. <br><br>
<?php
	$servername = "localhost";
	$username = "sharoons";
	$password = "password";
	$dbname = "PPL";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error);
	$sql = "select name, points from data order by points";
	$result = $conn->query($sql);

	while($row = $result->fetch_assoc())
	{
		echo "$row[name]       ";
		echo "$row[points]";
		echo "<br>";
	}
	$conn->close;
	echo "<a href='predict.php'>Predict !</a>";
	echo "<br>";
	echo "<a href='past.php'>My predictions</a>";
	echo "<br>";

?>
</body>
</html>