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

$log_id=$_REQUEST['log_id'];
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
<title><?php echo "Visited Pages";?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" />

<script type="text/javascript" src="scripts/script.js"></script>
</head>
<body>
<p>&nbsp;</p>
<div id="wrap">

<img src="images/cv-bank.jpg" title="Payroll" alt="Payroll" width="950" height="65"  />

<h1><?php echo $uname."'s Visited Pages"?> <span style="text-align:right; float:right"><a href="login_times.php?&uidd=<?php echo $uid;?>&name=<?php echo $uname;?>">Back</a></span></h1>
<table class="allformat" width="100%" align="center" cellpadding="1" cellspacing="0" border="1"  >
 <tr><td><strong>Sr.No.<strong/></td><td><strong>Visited Date Time <strong/></td><td><strong>URL<strong/></td></tr>
<?php
$logSQL = "SELECT *  FROM pages_visit_log where log_id='$log_id'";
$objDb->query($logSQL);	
$iCount = $objDb->getCount( );
if($iCount>0)
{
  for ($i = 0 ; $i < $iCount; $i ++)
	{
	$visited_date				=	$objDb->getField($i, visited_date);
	$request_url					=	$objDb->getField($i, request_url);

	?>
  <tr><td><?php echo $i+1;?><td><?php echo $visited_date;?></td><td><?php echo $request_url;?></td></tr>
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



