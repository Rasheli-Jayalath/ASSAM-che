<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$now 			= new DateTime();
$nowyear 		= $now->format("Y");
$sel_checkbox 	= $_REQUEST['sel_checkbox'];
$module			= $_REQUEST['module'];

if($module=="BOQ Data")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
$file_name="maindata.php";
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
<h1>List (<?php echo $module;?>)<span style="text-align:right; float:right"><a href="boqdata.php">Back</a></span></h1>
<?php
$criteria = '';

if($module=="BOQ Data")
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
		
		if($_REQUEST['valueisentry']!="")
		{
		$criteria = $criteria."Is Entry: <b>".$_REQUEST['valueisentry']." </b>";
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
  
  <?php if($module=="BOQ Data")
{ ?>
  <td width="10%"><strong>Stage<strong/></td>
  <td width="10%"><strong>Item Code<strong/></td>
  <td width="10%"><strong>Item Name<strong/></td>
  <td width="10%"><strong>Is Entry<strong/></td><?php }?>

</tr>
<?php
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	
	if($module=="BOQ Data")
{
	  $stage						= $objDb->getField($i,stage);
	  $itemcode 					= $objDb->getField($i,itemcode);
	  $itemname 					= $objDb->getField($i,itemname);
	  $isentry 						= $objDb->getField($i,isentry);
	 
	}
		
?>
<tr <?=$color; ?>>
<td width="3px"><center> <?=$i+1;?> </center> </td>

<?php if($module=="BOQ Data")
{?>
  <td><?php echo $stage;?></td><td><?php echo $itemcode;?></td><td><?php echo $itemname;?></td>
  <td><?php echo $isentry;?></td> <?php
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