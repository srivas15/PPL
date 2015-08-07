<?php
session_start();
?>
<html>
<body>
<?php
	$servername = "localhost";
	$username = "sharoons";
	$password = "password";
	$dbname = "PPL";

	$name = $_SESSION['name'];
	$gw = $_SESSION['gw'];

	echo "predictions for gameweek ";
	echo "$gw";
	echo "<br>predictions will be blank if the user has not predicted yet";
	echo "<br><br>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error);

	$uri = 'http://api.football-data.org/alpha/soccerseasons/354/fixtures/?matchday=';
	$uri .= $gw;
	$reqPrefs['http']['method'] = 'GET';
   	$reqPrefs['http']['header'] = 'X-Auth-Token: 12c3eb70429a4a0fa09b09ef495a802a';
   	$stream_context = stream_context_create($reqPrefs);
   	$response = file_get_contents($uri, false, $stream_context);
    	$fixtures = json_decode($response, true);

	$sql = "select distinct name from data";
	$result = $conn->query($sql);
	$names = array();
	$nameCount = 0;
	while($row = $result->fetch_assoc())
	{
		$names[$nameCount] = $row[name];
		//echo $names[$nameCount];
		$nameCount++;
	}

	$myCount = 0;

	while($myCount < $nameCount)
	{
		$sql = "select * from predictions where name='$names[$myCount]' and gw=$gw order by fixture";
		$result = $conn->query($sql);
		$x = 0;
		$a = 0;
		echo "<b>$names[$myCount]</b>";
		echo "<br>";
		//echo $result->num_rows;
		//echo $fixtures[count];
		while($x < $fixtures[count])
		{
			//$row = $result->fetch_assoc();
			//echo "lets see<br>";
			//$x = $row[fixture];
			$home = $fixtures[fixtures][$x][homeTeamName];
			$away = $fixtures[fixtures][$x][awayTeamName];
			if(($home == 'Manchester United FC')||($home == 'Arsenal FC')||($home == 'Liverpool FC')||($home == 'Chelsea FC')||($home == 'Manchester City FC')||($away == 'Manchester United FC')||($away == 'Arsenal FC')||($away == 'Liverpool FC')||($away == 'Chelsea FC')||($away == 'Manchester City FC'))
			{
				$row = $result->fetch_assoc();
				echo $home;
				echo " ";
				echo "$row[home]";
				echo " - ";
				echo "$row[away]";
				echo " ";
				echo $away;
				echo "<br>";
			}
			$x++;
		}
		$myCount++;
		echo "<br><br>";
	}
	$conn->close();
	echo "<br>";
	echo "<a href='leaderboards.php'>Leaderboards</a>";
	echo "<br>";
	echo "<a href='predict.php'>Predict !</a>";

?>
</body>
</html>