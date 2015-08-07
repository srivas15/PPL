<?php
session_start();
?>
<html>
<body>
<form action = "changed.php" method = "post">
old password: <input type = "password" name = "oldpassword"><br>
new password: <input type = "password" name = "newpassword"><br>
<input type = "submit">
</form>
</body>
</html>
