<html>
<body>
testing
<?php
$servername = "mysql6.000webhost.com";
$username = "a9575903_shars";
$password = "password1";
$dbname = "a9575903_shars";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error); 

$sql = "select * from data";
$result = $conn->query($sql);

while($row = $result->fetch_assoc())
{
	echo $row[name];
}
?>
</body>
</html>