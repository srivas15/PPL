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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error); 

$sql = "select * from data where name='$name'";
$result = $conn->query($sql);

$correct = 0;

while($row = $result->fetch_assoc())
	if($row[pwdhash] == $_POST[oldpassword])
		$correct = 1;

$sql = "update data set pwdhash='$_POST[newpassword]' where name='$name'";
$conn->query($sql);

$conn->close();
?>
Password change successful.
<br><br>
<a href='predict.php'>Home</a>

</body>
</html>
