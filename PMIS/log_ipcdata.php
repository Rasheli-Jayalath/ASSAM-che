<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$user_counter = $_SESSION['user_counter'];
$module			= $_REQUEST['module'];
if($module=="IPC Data")
{
	$id="ipcid";
	$tbl_name="ipc";
	$tbl_name1="ipc_log";

}

if ($uname==null)
{
	header("Location: index.php?init=3");
}
?>
<?
$objDb  = new Database( );
@require_once("get_url.php");
$trans_id=$_REQUEST['trans_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php');?>
</head>
<body>
<p>&nbsp;</p>
<div id="wrap">

<img src="images/cv-bank.jpg" title="Payroll" alt="Payroll" width="950" height="65"  />

<?
$sSQL1 = " select * FROM $tbl_name1 WHERE transaction_id=$trans_id";
$objDb->query($sSQL1);
?>
<h1>Log (<?php echo $module; ?>)</h1>
<table class="allformat" width="100%" align="center" cellpadding="1" cellspacing="0" border="1"  >
 <tr><td><strong>Module<strong/></td><td><strong>Tilte<strong/></td><td><strong>Log Date<strong/></td><td><strong>IP<strong/></td><td><strong>IPC No<strong/></td><td><strong>IPC Month<strong/></td><td><strong>IPC Start Date<strong/></td><td><strong>IPC End Date<strong/></td><td><strong>IPC Submit Date<strong/></td><td><strong>IPC Receive Date<strong/></td>
 
 </tr>
<?php
$iCount = $objDb->getCount( );
if($iCount>0)
{
  for ($i = 0 ; $i < $iCount; $i ++)
	{
	 
		  $log_module							=	$objDb->getField($i, log_module);
		  $log_title							=	$objDb->getField($i, log_title);
		  $log_date								=	$objDb->getField($i, log_date);
		  $log_ip								=	$objDb->getField($i, log_ip);
		  $ipcno 								= $objDb->getField($i,ipcno);
		  $ipcmonth	 							= $objDb->getField($i,ipcmonth);
		  $ipcstartdate							= $objDb->getField($i,ipcstartdate);
		  $ipcenddate 							= $objDb->getField($i,ipcenddate);
		  $ipcsubmitdate	 					= $objDb->getField($i,ipcsubmitdate);
		  $ipcreceivedate						= $objDb->getField($i,ipcreceivedate);
	

	?>
  <tr><td><?php echo $log_module;?></td><td><?php echo $log_title;?></td><td><?php echo $log_date;?></td><td><?php echo $log_ip;?></td>
  
<td ><?=$ipcno;?></td>
<td ><?=$ipcmonth;?></td>
<td><?=$ipcstartdate;?></td>
<td ><?=$ipcenddate;?></td>
<td ><?=$ipcsubmitdate;?></td>
<td   ><?=$ipcreceivedate;?></td>
  
     </tr>
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



