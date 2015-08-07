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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error); 

$sql = "select * from data where name='$_POST[name]'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		if($row[pwdhash] == $_POST[password])
		{
			echo "sign in successful"."<br>";
			$_SESSION['name'] = $row[name];
			echo "<a href='predict.php'>Home</a>";
		}
		else
			echo "name and password dont match"."<br>";
		break;
	}
}
else
	echo "incorrect name or password";
$conn->close();
echo "<br><a href='password.php'>change your password</a>";
?>

</body>
</html>
