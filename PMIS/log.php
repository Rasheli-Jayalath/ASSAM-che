<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$user_counter = $_SESSION['user_counter'];
$module			= $_REQUEST['module'];
if($module=="Resources")
{
$id="rid";
$tbl_name="resources";
$tbl_name1="resources_log";
}
if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
}
if($module=="Activity Data")
{
$id="aid";
$tbl_name="activity";
$tbl_name1="activity_log";
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
<h1>Log (<?php echo $module; ?>)<span style="text-align:right; float:right"><a href="maindata.php">Back</a></span></h1>
<table class="allformat" width="100%" align="center" cellpadding="1" cellspacing="0" border="1"  >
 <tr><td><strong>Module<strong/></td><td><strong>Tilte<strong/></td><td><strong>Log Date<strong/></td><td><strong>IP<strong/></td> <?php if($module=="Resources"){ ?><td><strong>Resource Name<strong/></td><td><strong>Unit<strong/></td><td><strong>Quantity<strong/></td><td><strong>Schedule Code<strong/></td><td><strong>Boq Code<strong/></td><?php } ?>
 <?php if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity"){ ?><td><strong>Stage<strong/></td><td><strong>Item Code<strong/></td><td><strong>Item Name<strong/></td><td><strong>Weight<strong/></td><td><strong>Is Entry<strong/></td><?php } ?>
 <?php if($module=="Activity Data"){ ?><td><strong>Code<strong/></td><td><strong>Sechedule Id<strong/></td><td><strong>Start Date<strong/></td><td><strong>End Date<strong/></td><td><strong>Actual Start Date<strong/></td><td><strong>Actual End Date<strong/></td><td><strong>Order<strong/></td><td><strong>Baseline<strong/></td><td><strong>Remarks<strong/></td><?php } ?>
 
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
	if($module=="Resources")
		{
		$resource					=	$objDb->getField($i, resource);
		$unit					=	$objDb->getField($i, unit);
		$quantity				=	$objDb->getField($i, quantity);
		$schedulecode			=	$objDb->getField($i, schedulecode);
		$boqcode				=	$objDb->getField($i, boqcode);
		}
	if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity"){
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
	  if($module=="Activity Data"){
	  $aid							= $objDb->getField($i,aid);
	  $itemid						= $objDb->getField($i,itemid);
	  $code							= $objDb->getField($i,code);
	  $scheduleid	 				= $objDb->getField($i,secheduleid);
	  $startdate					= $objDb->getField($i,startdate);
	  $enddate 						= $objDb->getField($i,enddate);
	  $actualstartdate 				= $objDb->getField($i,actualstartdate);
	  $actualenddate	 			= $objDb->getField($i,actualenddate);
	  $aorder						= $objDb->getField($i,aorder);
	  $baseline 					= $objDb->getField($i,baseline);
	  $remarks 						= $objDb->getField($i,remarks);
	  }
	?>
  <tr><td><?php echo $log_module;?></td><td><?php echo $log_title;?></td><td><?php echo $log_date;?></td><td><?php echo $log_ip;?></td>
   <?php if($module=="Resources"){?>
  <td><?php echo $resource;?></td><td><?php echo $unit;?></td>
  <td><?php echo $quantity;?></td><td><?php echo $schedulecode;?></td>
  <td><?php echo $boqcode;?></td> <?php
   }
   ?>
    <?php if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity"){?>
  <td><?php echo $stage;?></td><td><?php echo $itemcode;?></td>
  <td><?php echo $itemname;?></td><td><?php echo $weight;?></td>
  <td><?php echo $isentry;?></td> <?php
   }
   ?>
    <?php if($module=="Activity Data"){?>
	 <td><?=$code;?></td>
	<td><?=$scheduleid;?></td>
	<td><?=$startdate;?></td>
	<td ><?=$enddate;?></td>
	<td ><?=$actualstartdate;?></td>
	<td><?=$actualenddate;?></td>
	<td><?=$aorder;?></td>
	<td><?=$baseline;?></td>
	<td><?=$remarks;?></td> <?php
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



