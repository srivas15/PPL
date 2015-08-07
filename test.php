<html>
<body>
matchday 1<br>
<?php
    	$uri = 'http://api.football-data.org/alpha/soccerseasons/398/fixtures/?matchday=1';
   	//$uri = 'http://api.football-data.org/alpha/fixtures/?timeFrameStart=2015-08-15&timeFrameEnd=2015-08-30';
	//$uri = 'http://api.football-data.org/alpha/soccerseasons/354';
	$reqPrefs['http']['method'] = 'GET';
   	$reqPrefs['http']['header'] = 'X-Auth-Token: 12c3eb70429a4a0fa09b09ef495a802a';
   	$stream_context = stream_context_create($reqPrefs);
   	$response = file_get_contents($uri, false, $stream_context);
    	$fixtures = json_decode($response, true);
	//var_dump($fixtures[fixtures][0][homeTeamName]);
?>
<form action="test2.php" method="post">
<?php
	echo $fixtures[fixtures][0][homeTeamName];
	//echo strlen($fixtures[fixtures][0][homeTeamName]);
?><input type="number" name="1predH" min="1" max="10">
 - <input type="number" name="1predA" min="1" max="10"><?php
	echo $fixtures[fixtures][0][awayTeamName];
	//echo strlen($fixtures[fixtures][0][homeTeamName]);
?>
</body>
</html>