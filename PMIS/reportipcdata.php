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
if($module=="IPC Data")
	{
	$id="ipcid";
	$tbl_name="ipc";
	$tbl_name1="ipc_log";
	$file_name="ipcdata.php";
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
<h1>List (<?php echo $module;?>)<span style="text-align:right; float:right"><a href="ipcdata.php">Back</a></span></h1>
<?php
$criteria = '';

		if($_REQUEST['valueipcno']!="")
		{
		$criteria = $criteria."IPC No: <b>".$_REQUEST['valueipcno']." </b>";
		}
		if($_REQUEST['txtipcmonth']!="")
		{
		
		$criteria = $criteria."IPC Month: <b>".$_REQUEST['txtipcmonth']." </b>";
		}
		if($_REQUEST['valueipcstartdate']!="")
		{
		
		$criteria = $criteria."Start Date: <b>".$_REQUEST['valueipcstartdate']." </b>";
		}
		if($_REQUEST['valueipcenddate']!="")
		{
		
		$criteria = $criteria."End Date: <b>".$_REQUEST['valueipcenddate']." </b>";
		}
		if($_REQUEST['valueipcsubmitdate']!="")
		{
		
		$criteria = $criteria."Submit Date: <b>".$_REQUEST['valueipcsubmitdate']." </b>";
		}
		if($_REQUEST['valueipcreceivedate']!="")
		{
		
		$criteria = $criteria."Receive Date: <b>".$_REQUEST['valueipcreceivedate']." </b>";
		}
		


?>


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
  <td align="center" width="15%"><strong>IPC NO</strong></td> 
  <td width="10%"><strong>IPC Month</strong></td>
  <td width="10%"><strong>IPC Start Date</strong></td>
   <td width="10%"><strong>IPC End Date</strong></td>
    <td width="10%"><strong>IPC Submit Date</strong></td>
	 <td width="10%"><strong>IPC Receive Date</strong></td>
 
 
  
</tr>
<?php
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	 
	  $ipcno 								= $objDb->getField($i,ipcno);
	  $ipcmonth	 							= $objDb->getField($i,ipcmonth);
	  $ipcstartdate							= $objDb->getField($i,ipcstartdate);
	  $ipcenddate 							= $objDb->getField($i,ipcenddate);
	  $ipcsubmitdate	 					= $objDb->getField($i,ipcsubmitdate);
	  $ipcreceivedate						= $objDb->getField($i,ipcreceivedate);
	 
	
	
?>
<tr <?=$color; ?>>
<td width="3px"><center> <?=$i+1;?> </center> </td>

<td width="210px"><?=$ipcno;?></td>
<td width="100px"><?=$ipcmonth;?></td>
<td width="180px"  ><?=$ipcstartdate;?></td>
<td width="210px"><?=$ipcenddate;?></td>
<td width="100px"><?=$ipcsubmitdate;?></td>
<td width="180px"  ><?=$ipcreceivedate;?></td>


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