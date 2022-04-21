<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
?>
<?
$objDb  = new Database( );
$objDb2  = new Database( );
@require_once("get_url.php");

$trans_id=$_REQUEST['trans_id'];
$user_id=$_REQUEST['uidd'];
$name=$_REQUEST['name'];
if($user_id==NULL || $user_id=="")
{
$uid=$uid;
$uname=$uname;
}
else
{
$uid=$user_id;
$uname=$name;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo "Log Info";?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" />

<script type="text/javascript" src="scripts/script.js"></script>
</head>
<body>
<p>&nbsp;</p>
<div id="wrap">

<img src="images/cv-bank.jpg" title="Payroll" alt="Payroll" width="950" height="65"  />

<h1><?php echo $uname."'s Log Info"?><span style="text-align:right; float:right"><a href="<?php echo "user_log.php"; ?>">Back</a></span></h1>
<table class="allformat" width="100%" align="center" cellpadding="1" cellspacing="0" border="1"  >
 <tr><td><strong>Sr.No.<strong/></td><td><strong>Login date<strong/></td><td><strong>IP Address<strong/></td><td><strong>URL<strong/></td><td><strong>Browser<strong/></td><td><strong>Visit Pages<strong/></td></tr>
<?php
$logSQL = "SELECT *  FROM users_log where user_id='$uid' order by login_date";
$objDb->query($logSQL);	
$iCount = $objDb->getCount( );
if($iCount>0)
{
  for ($i = 0 ; $i < $iCount; $i ++)
	{
	$log_id						=	$objDb->getField($i, log_id);
	$login_date					=	$objDb->getField($i, login_date);
	$ip_address					=	$objDb->getField($i, ip_address);
	$req_url					=	$objDb->getField($i, req_url);
	$browser					=	$objDb->getField($i, browser);
	
	//$counter					=	$objDb2->getField($i, counter);
	?>
  <tr><td><?php echo $i+1;?><td><?php echo $login_date;?></td><td><?php echo $ip_address;?></td><td><?php echo $req_url;?></td><td><?php echo $browser;?></td><td><a href="visited_pages.php?log_id=<?php echo $log_id; ?>&uidd=<?php echo $uid;?>&name=<?php echo $uname;?> "><?php echo "Visited Pages";?></td></tr>
  <?php
  }
 }
 else
 {
 ?>
 <tr><td colspan="11">No Record Found</td></tr>
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



