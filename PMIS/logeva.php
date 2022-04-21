<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$user_counter = $_SESSION['user_counter'];
$module			= $_REQUEST['module'];

if($module=="EVA Data")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
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
<h1>Log (<?php echo $module; ?>)<span style="text-align:right; float:right"><a href="evadata.php">Back</a></span></h1>
<table class="allformat" width="100%" align="center" cellpadding="1" cellspacing="0" border="1"  >
 <tr><td><strong>Module<strong/></td><td><strong>Tilte<strong/></td><td><strong>Log Date<strong/></td><td><strong>IP<strong/></td> 
 <?php if($module=="EVA Data"){ ?><td><strong>Stage<strong/></td><td><strong>Item Code<strong/></td><td><strong>Item Name<strong/></td><td><strong>Weight<strong/></td><td><strong>Is Entry<strong/></td><?php } ?>

 
 </tr>
<?php
$iCount = $objDb->getCount( );
if($iCount>0)
{
  for ($i = 0 ; $i < $iCount; $i ++)
	{
	 
	$log_module					=	$objDb->getField($i, log_module);
	$log_title					=	$objDb->getField($i, log_title);
	$log_date					=	$objDb->getField($i, log_date);
	$log_ip						=	$objDb->getField($i, log_ip);
	
	if($module=="EVA Data"){
	 $parentcd 					= $objDb->getField($i,parentcd);
	  $parentgroup	 				= $objDb->getField($i,parentgroup);
	  $stage						= $objDb->getField($i,stage);
	  $itemcode 					= $objDb->getField($i,itemcode);
	  $itemname 					= $objDb->getField($i,itemname);
	  $weight	 					= $objDb->getField($i,weight);
	  $activities					= $objDb->getField($i,activities);
	  $isentry 						= $objDb->getField($i,isentry);
	  $resources 					= $objDb->getField($i,resources);
	  }
	  
	?>
  <tr><td><?php echo $log_module;?></td><td><?php echo $log_title;?></td><td><?php echo $log_date;?></td><td><?php echo $log_ip;?></td>
 
    <?php if($module=="EVA Data"){?>
  <td><?php echo $stage;?></td><td><?php echo $itemcode;?></td>
  <td><?php echo $itemname;?></td><td><?php echo $weight;?></td>
  <td><?php echo $isentry;?></td> <?php
   }
   ?>
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



