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
	$gw = "";
	$count = 0;
	echo "welcome ".$_SESSION['name'];
	echo "<br>";
	$name = $_SESSION['name'];
	/*$servername = "localhost";
	$username = "sharoons";
	$password = "password";
	$dbname = "PPL";*/
 
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error);
 
	$sql = "select * from data where name='$name'";
	$result = $conn->query($sql);
 
	while($row = $result->fetch_assoc())
	{
		$gw = $row[gw];
		$_SESSION['gw'] = $gw;
	}
	//$conn->close;
	echo "matchday $gw"."<br><br>";
	echo "your predictions will be over written <br><br>";
    	$uri = 'http://api.football-data.org/alpha/soccerseasons/398/fixtures/?matchday=';
	$uri .= $gw;
	$reqPrefs['http']['method'] = 'GET';
   	$reqPrefs['http']['header'] = 'X-Auth-Token: 12c3eb70429a4a0fa09b09ef495a802a';
   	$stream_context = stream_context_create($reqPrefs);
   	$response = file_get_contents($uri, false, $stream_context);
    	$fixtures = json_decode($response, true);
	//var_dump($fixtures);
	$count = $fixtures[count];
	//var_dump($fixtures[fixtures][0][status]);
	if($fixtures[fixtures][$count - 1][status] == 'FINISHED')
	{
		$sql = "select distinct name from data";
		$result = $conn->query($sql);
		$names = array();
		$nameCount = 0;
		while($row = $result->fetch_assoc())
		{
			$names[$nameCount] = $row[name];
			echo $names[$nameCount];
			$nameCount++;
		}
 
		$myCount = 0;
 
		while($myCount < $nameCount)
		{
			$sql = "select * from predictions where name='$names[$myCount]' and gw=$gw order by fixture";
			$result = $conn->query($sql);
			$x = 0;
			$points = 0;
			while($x < $fixture[count])
			{
				//$x = $row[fixture];
				/*echo $fixtures[fixtures][$x][result][goalsHomeTeam];
				echo $fixtures[fixtures][$x][result][goalsAwayTeam];
				echo "<br>";
				echo $row[home];
				echo $row[away];*/
				$home = $fixtures[fixtures][$x][homeTeamName];
				$away = $fixtures[fixtures][$x][awayTeamName];
				if(($home == 'Manchester United FC')||($home == 'Arsenal FC')||($home == 'Liverpool FC')||($home == 'Chelsea FC')||($home == 'Manchester City FC')||($away == 'Manchester United FC')||($away == 'Arsenal FC')||($away == 'Liverpool FC')||($away == 'Chelsea FC')||($away == 'Manchester City FC'))
				{
					$row = $result->fetch_assoc();
 
					if($fixtures[fixtures][$x][result][goalsHomeTeam] > $fixtures[fixtures][$x][result][goalsAwayTeam])
					{
						if($row[home] > $row[away])
							$points += 5;
					}
					else if($fixtures[fixtures][$x][result][goalsHomeTeam] < $fixtures[fixtures][$x][result][goalsAwayTeam])
					{
						if($row[home] < $row[away])
							$points += 5;
					}
					else if($fixtures[fixtures][$x][result][goalsHomeTeam] == $fixtures[fixtures][$x][result][goalsAwayTeam])
					{
						if($row[home] == $row[away])
							$points += 5;
					}
					if(($fixtures[fixtures][$x][result][goalsHomeTeam] - $fixtures[fixtures][$x][result][goalsAwayTeam]) == ($row[home] - $row[away]))	
						$points += 5;
					if(($fixtures[fixtures][$x][result][goalsHomeTeam] == $row[home]) && ($fixtures[fixtures][$x][result][goalsAwayTeam] == $row[away]))
						$points += 5;
				}
					$x++;
			}
			//echo "points are $points";
			$sql = "update data set points = points + $points where name = '$names[$myCount]'";
			$conn->query($sql);
 
			$myCount++;
		}
		//$gw += 1;
		//$_SESSION['gw'] += 1;
		//$sql = "update data set gw = gw + 1";
		//$conn->query($sql);
	}
	else if($fixtures[fixtures][0][status] == 'TIMED')
	{
		echo "<form action='submit.php' method='post'>";
		$x = 0;
		while($x < $count)
		{
			$home = $fixtures[fixtures][$x][homeTeamName];
			$away = $fixtures[fixtures][$x][awayTeamName];
			if(($home == 'Manchester United FC')||($home == 'Arsenal FC')||($home == 'Liverpool FC')||($home == 'Chelsea FC')||($home == 'Manchester City FC')||($away == 'Manchester United FC')||($away == 'Arsenal FC')||($away == 'Liverpool FC')||($away == 'Chelsea FC')||($away == 'Manchester City FC'))
			{
				echo $home;
				echo "<input type='number' name='home[]' min='0' max='10'>";
				//var_dump($fixtures[fixtures]);
				echo " - ";
				echo "<input type='number' name='away[]' min='0' max='10'>";
				echo $away;
				echo "<br>";
			}
			$x++;
		}
		echo "<input type='submit'>";
		echo "</form>";
	}
        else
                echo "<br>Gameweek already started. Too late to predict. Come back for the next game week! <br>";
	echo "<a href='past.php'>My predictions</a>";
	echo "<br>";
	echo "<a href='leaderboards.php'>Leaderboards</a>";
	$conn->close();
?>
</body>
