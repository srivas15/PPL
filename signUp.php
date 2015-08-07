<?php
session_start();
?>
<html>
<body>
<?php

if($_POST[key] == 'ney')
{
	$servername = "localhost";
	$username = "sharoons";
	$password = "password";
	$dbname = "PPL";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
    		die("Connection failed: " . $conn->connect_error); 

	$sql = "insert into data (name, pwdhash, points, gw) values ('$_POST[name]', 	'$_POST[password]', 0, 1)";

	$conn->query($sql);
	$conn->close();
	echo "you have been successfully signed up";
	$_SESSION['name'] = $_POST[name];
	echo <br>;
	echo "<a href='predict.php'>Home</a>";
	
}
else
{
	echo "incorrect key";
}
?>
</body>
</html>