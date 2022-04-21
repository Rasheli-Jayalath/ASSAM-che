<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$now 			= new DateTime();
$nowyear 		= $now->format("Y");
$sel_checkbox 	= $_REQUEST['sel_checkbox'];
$module			= $_REQUEST['module'];
if($module=="Resources")
	{
	$id="rid";
	$tbl_name="resources";
	$tbl_name1="resources_log";
	$file_name="resources.php";
	}
if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
$file_name="maindata.php";
}
if($module=="Activity Data")
{
$id="aid";
$tbl_name="activity";
$tbl_name1="activity_log";
$file_name="activity.php";
}


if ($sel_checkbox !='') {
$objDb   = new Database( );
@require_once("get_url.php");

$sSQL1 = "SELECT * FROM $tbl_name WHERE $id in (".implode(', ', $sel_checkbox).")";
$objDb->query($sSQL1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php include ('includes/metatag.php');?>
</head>
<body> 
<div id="wrap" >
<img src="images/cv-bank.jpg" title="Payroll" alt="Payroll" width="950" height="65"  />
<h1>List (<?php echo $module;?>)</h1>
<?php
$criteria = '';
 if($module=="Resources"){
		if($_REQUEST['valueresource']!="")
		{
		$criteria = $criteria."Resource Name: <b>".$_REQUEST['valueresource']." </b>";
		}
		if($_REQUEST['valueunit']!="")
		{
		
		$criteria = $criteria."Unit: <b>".$_REQUEST['valueunit']." </b>";
		}
		if($_REQUEST['valuequantity']!="")
		{
		
		$criteria = $criteria."Quantity: <b>".$_REQUEST['valuequantity']." </b>";
		}
		if($_REQUEST['valueschedulecode']!="")
		{
		$criteria = $criteria."Schedule Code: <b>".$_REQUEST['valueschedulecode']." </b>";
		}
		if($_REQUEST['valueboqcode']!="")
		{
		$criteria = $criteria."Boq Code: <b>".$_REQUEST['valueboqcode']." </b>";
		}
  }
if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{
		 if($_REQUEST['valuestage']!="")
		{
		$criteria = $criteria."Stage: <b>".$_REQUEST['valuestage']." </b>";
		}
		if($_REQUEST['valueitemcode']!="")
		{
		
		$criteria = $criteria."Item Code: <b>".$_REQUEST['valueitemcode']." </b>";
		}
		if($_REQUEST['valueitemname']!="")
		{
		
		$criteria = $criteria."Item Nmae: <b>".$_REQUEST['valueitemname']." </b>";
		}
		if($_REQUEST['valueweight']!="")
		{
		$criteria = $criteria."Weight: <b>".$_REQUEST['valueweight']." </b>";
		}
		if($_REQUEST['valueisentry']!="")
		{
		$criteria = $criteria."Is Entry: <b>".$_REQUEST['valueisentry']." </b>";
		}
 
 }
  if($module=="Activity Data"){
		 if($_REQUEST['valuecode']!="")
		{
		$criteria = $criteria."Code: <b>".$_REQUEST['valuecode']." </b>";
		}
		if($_REQUEST['valueschedid']!="")
		{
		
		$criteria = $criteria."Schedule ID: <b>".$_REQUEST['valueschedid']." </b>";
		}
		if($_REQUEST['valuestartdate']!="")
		{
		
		$criteria = $criteria."Start Date: <b>".$_REQUEST['valuestartdate']." </b>";
		}
		if($_REQUEST['valueenddate']!="")
		{
		$criteria = $criteria."End Date: <b>".$_REQUEST['valueenddate']." </b>";
		}
		if($_REQUEST['valueastartdate']!="")
		{
		$criteria = $criteria."Actual Start Date: <b>".$_REQUEST['valueastartdate']." </b>";
		}
		if($_REQUEST['valueaenddate']!="")
		{
		$criteria = $criteria."Actual End Date: <b>".$_REQUEST['valueaenddate']." </b>";
		}
		if($_REQUEST['valueremarks']!="")
		{
		$criteria = $criteria."Remarks: <b>".$_REQUEST['valueremarks']." </b>";
		}
 
 }


?>
 <a href="http://www.egcpakistan.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onclick="window.print();return false;" title="CV Bank-CV checklist"></a>

<table width="950px" border="0">
  <tr>
    <td width="950px"><?php echo "<strong>Criteria: </strong>".$criteria."";?>
</td>
    </tr>
</table>
<div id="content">
 <?php
$iCount = $objDb->getCount( );
if($iCount>0)
{
?>
  
<table class="reference"  width="100%" align="center">
 <tr align="center" >
  
  <td align="center" width="5%"><strong>Sr. No.</strong></td>
   <?php if($module=="Resources"){?>
  <td align="center" width="15%"><strong>Resource</strong></td> 
  <td width="10%"><strong>Unit</strong></td>
  <td width="10%"><strong>Quantity</strong></td>
  <td width="10%"><strong>Schedule Code</strong></td>
  <td width="10%"><strong>BoqCode</strong></td>
  <?php
  }
  ?>
  <?php if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{ ?>
  <td width="10%"><strong>Stage<strong/></td>
  <td width="10%"><strong>Item Code<strong/></td>
  <td width="10%"><strong>Item Name<strong/></td>
  <td width="10%"><strong>Weight<strong/></td>
  <td width="10%"><strong>Is Entry<strong/></td><?php }?>
  
   <?php if($module=="Activity Data"){ ?>
  <td><strong>Code<strong/></td><td><strong>Sechedule Id<strong/></td><td><strong>Start Date<strong/></td><td><strong>End Date<strong/></td><td><strong>Actual Start Date<strong/></td><td><strong>Actual End Date<strong/></td><td><strong>Order<strong/></td><td><strong>Baseline<strong/></td><td><strong>Remarks<strong/></td><?php }?>
</tr>
<?php
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	 if($module=="Resources"){
		$resource  				= $objDb->getField($i, resource);
		$unit  					= $objDb->getField($i, unit);
		$quantity  				= $objDb->getField($i, quantity);
		$schedulecode  			= $objDb->getField($i, schedulecode);
		$boqcode  				= $objDb->getField($i, boqcode);
	}
	if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{
	  $stage						= $objDb->getField($i,stage);
	  $itemcode 					= $objDb->getField($i,itemcode);
	  $itemname 					= $objDb->getField($i,itemname);
	  $weight	 					= $objDb->getField($i,weight);
	  $isentry 						= $objDb->getField($i,isentry);
	 
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
<tr <?=$color; ?>>
<td width="3px"><center> <?=$i+1;?> </center> </td>

<?php if($module=="Resources")
{?>
<td align="center"><?=$resource;?></td>
<td align="center"><?=$unit;?></td>
<td align="center"><?=$quantity;?></td>
<td align="center"><?=$schedulecode;?></td>
<td align="center"><?=$boqcode;?></td>
<?php 
} ?>
<?php if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{?>
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
?>
</table>
<a style="text-decoration:none;" href="#" >
  <input  type="submit"  class="button3" name="btnExport" id="btnExport" value="Export to Xls" />
  </a>
</div>

<?php
}
}
echo "<br /><br /> ";
include ("includes/footer.php");
?>
</div>
</body>
</html>