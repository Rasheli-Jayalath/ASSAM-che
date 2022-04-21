<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
// if ($uname==null)
// {
// 	header("Location: index.php?init=3");
// }
?>
<?
$objDb  = new Database( );
$objDb2  = new Database( );
@require_once("get_url.php");


$trans_id=$_REQUEST['trans_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo "User Log";?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" />

<script type="text/javascript" src="scripts/script.js"></script>
</head>
<body>
<p>&nbsp;</p>
<div id="wrap">

<img src="images/cv-bank.jpg" title="Payroll" alt="Payroll" width="950" height="65"  />

<?


	
?>
<h1><?php echo "Log Info"?> <span style="text-align:right; float:right"><a href="<?php echo "home.php"; ?>">Back</a></span></h1>
<table class="allformat" width="100%" align="center" cellpadding="1" cellspacing="0" border="1"  >
 <tr><td><strong>Name<strong/></td><td><strong>Counter<strong/></td></tr>
<?php

if($superadmin_flag==1)
{
	$sSQL = "SELECT distinct user_id, user_name FROM users_log";
	$objDb->query($sSQL);
	
$iCount = $objDb->getCount( );
if($iCount>0)
{
  for ($i = 0 ; $i < $iCount; $i ++)
	{
	$uid						=	$objDb->getField($i, user_id);
	$uname						=	$objDb->getField($i, user_name);
	
	$logSQL = "SELECT count(user_id) as counter FROM users_log where user_id='$uid'";
	$objDb2->query($logSQL);	
	$counter					=	$objDb2->getField(0, counter);
	?>
  <tr><td><?php echo $uname;?></td><td>
  <a href="login_times.php?uidd=<?php echo $uid;?>&name=<?php echo $uname;?>" >
  <?php echo $counter.""?></td></tr>
  <?php
  }
 }
 else
 {
 ?>
 <tr><td colspan="11">No Record Found</td></tr>
 <?php
 }
 }
	else
	{
	
	$logSQL = "SELECT count(user_id) as counter FROM users_log where user_id='$uid'";
	$objDb2->query($logSQL);	
	$counter					=	$objDb2->getField(0, counter);
	?>
  <tr><td><?php echo $uname;?></td><td>
  <a href="login_times.php">
  <?php echo $counter.""?></td></tr>
	<?php
	} 
?>
	
	</table>
	<?php
	
	include ("includes/footer.php");?>
	
</div>
</body>
</html>
<?
	$objDb  -> close( );

?>



