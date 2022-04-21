<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= ACTIVITY;
if ($uname==null  ) {
header("Location: index.php?init=3");
}
$objDb  		= new Database( );
if($_POST["submit"])
{
$name=mysql_real_escape_string($_POST["name"]);
$email=mysql_real_escape_string($_POST["email"]);
echo $email;
$sql = "INSERT INTO testdata (name, email)
VALUES ('".$name."', '".$email."')";
mysql_query($sql);
echo "Record Save";
}
?>
			<html>
<body>

<form action="" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
<input type="submit" name="submit">
</form>

</body>
</html>
