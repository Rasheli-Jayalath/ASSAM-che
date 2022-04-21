<?php
if(isset($_REQUEST['login']) && $_REQUEST['uname']!="" && $_REQUEST['password']!="")
{
$uname		= $_REQUEST['uname'];
$password	= $_REQUEST['password'];
include ('requires/configs.php'); 
include ('requires/db.class.php');
$objDb  = new Database( );
	$sSQL = "SELECT * FROM users WHERE uname='$uname' and password='$password'";
	$objDb->query($sSQL);
	$iCount = $objDb->getCount();
	$status = $objDb->getField(0, status);
	if($iCount==1 && $status==1)
	{
		@session_start( );
		$uid			= $objDb->getField(0, uid);
		$uname			= $objDb->getField(0, uname);
		$password			= $objDb->getField(0, password);
		$_SESSION['uid']			= $objDb->getField(0, uid);
		$_SESSION['uname']			= $objDb->getField(0, uname);
		$_SESSION['codelength']		=6;
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			{
			 //check for ip from share internet
			 $ip = $_SERVER["HTTP_CLIENT_IP"];
			}
			elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
			 // Check for the Proxy User
			 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			else
			{
			 $ip = $_SERVER["REMOTE_ADDR"];
			}
			
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
		   $browser ='Internet explorer';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
			$browser = 'Internet explorer';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
		   $browser = 'Mozilla Firefox';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
		   $browser = 'Google Chrome';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
		   $browser = "Opera Mini";
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
		   $browser = "Opera";
				 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
		   $browser = "Safari";
		 else
		   $browser = 'Something else';
			$request_uri = $_SERVER['REQUEST_URI'];
			
			
		
		$uSQL = ("INSERT INTO users_log (user_id,user_name,password,ip_address, req_url, browser) VALUES ('$uid','$uname','$password','$ip', '$request_uri', '$browser')");
			$objDb->execute($uSQL);
			$log_id=mysql_insert_id();
			$_SESSION['log_id']=$log_id;
			
		$objDb  -> close( );
		header("Location: maindata.php");
	}
	else if($iCount==1 && $status==0)
	{
	$msg="User Locked! Please contact administrator....";
	}
	else
	{
	$msg="User Name or Passord is incorrect....";
	}
$objDb  -> close( );
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo "PMIS"; ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" />

<script type="text/javascript" src="scripts/script.js"></script>

</head>
<body>
<?php include ('includes/header.php'); ?>
<div id="wrapper_MemberLogin_main" style="padding-bottom:50px">
	<h1 style="color:#000"><?php echo "LOGIN";?></h1>
	<div class="clear"></div>
	<div id="LoginBox" class="borderRound borderShadow">
<?php //  echo $msg;?>
<form action="index.php" method="post" name="loginForm">
<div class="loginboxContainer borderRound borderShadow">
			<div id="username1">
			<input type="text" name="uname" id="uname" class="userinbox"/>
			</div>
</div>
<div class="loginboxContainer borderRound borderShadow">
			<div id="userpass">
			 <input type="password" name="password" id="password" class="userinbox"/>
			</div>
</div>
<div id="userLogin"> <input id="uLogin" type="submit" name="login"  value="Login"/></div>	 

</form>
</div>
</div>

<?php // include ('includes/footer.php'); ?>
</body>

</html>

