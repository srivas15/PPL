<?php
session_start();
?>
<html>
<body>
Thank you for your predictions.. they have been saved ! <br>
<?php
	$name = $_SESSION['name'];
	$gw = $_SESSION['gw'];

	$servername = "localhost";
	$username = "sharoons";
	$password = "password";
	$dbname = "PPL";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error);

	$home = array();
	$away = array();

	$home = $_POST['home'];
	$away = $_POST['away'];
	
	$count = 0;
	$sql = "delete from predictions where name = '$name' and gw=$gw";
	$conn->query($sql);
	echo sizeof($home);
	while($count < sizeof($home))
	{
		$sql = "insert into predictions (name, gw, fixture, home, away) values ('$name', $gw, $count, $home[$count], $away[$count])";
		$conn->query($sql);
		$count++;
	}
	$conn->close();
	echo "<br>";
	echo "<a href='past.php'>My predictions</a>";
	echo "<br>";
	echo "<a href='leaderboards.php'>Leaderboards</a>";
	echo "<br>";
	echo "<a href='predict.php'>Predict !</a>";
?>
</body>
</html>