<?php
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}

include_once("connect.php");
include_once("functions.php");
//===============================================
/*
brid
pgid
pid
serial
description
total
inprogress
completed
*/



if(isset($_REQUEST['update']))
{

$fid=$_REQUEST['fid'];
$fund_year1 = $_REQUEST['fund_year1']; 
$fund_year2 = $_REQUEST['fund_year2'];
$fund_year3 = $_REQUEST['fund_year3'];
$fund_year4 = $_REQUEST['fund_year4'];
$fund_psdp_alloc_y1 = $_REQUEST['fund_psdp_alloc_y1']; 
$fund_psdp_alloc_y2 = $_REQUEST['fund_psdp_alloc_y2']; 
$fund_psdp_alloc_y3 = $_REQUEST['fund_psdp_alloc_y3'];
$fund_psdp_alloc_y4 = $_REQUEST['fund_psdp_alloc_y4'];
$fund_released = $_REQUEST['fund_released'];
$fund_expense = $_REQUEST['fund_expense'];
$fund_paid = $_REQUEST['fund_paid'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t003funds SET fund_year1='$fund_year1', fund_year2='$fund_year2', fund_year3='$fund_year3', fund_year4='$fund_year4', fund_psdp_alloc_y1=$fund_psdp_alloc_y1,  fund_psdp_alloc_y2=$fund_psdp_alloc_y2,  fund_psdp_alloc_y3=$fund_psdp_alloc_y3,  fund_psdp_alloc_y4=$fund_psdp_alloc_y4,  fund_released=$fund_released, fund_expense=$fund_expense,fund_paid=$fund_paid where fid=$fid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	

//header("Location: sp_project_info_update.php");
}


$pdSQL1="SELECT fid,fund_year1,fund_year2,fund_year3,fund_year4,fund_psdp_alloc_y1,fund_psdp_alloc_y2,fund_psdp_alloc_y3,fund_psdp_alloc_y4, fund_released, fund_expense, fund_paid FROM t003funds WHERE pid = ".$pid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$fund_year1 = $pdData1['fund_year1']; 
$fund_year2 = $pdData1['fund_year2'];
$fund_year3 = $pdData1['fund_year3']; 
$fund_year4 = $pdData1['fund_year4'];
$fund_psdp_alloc_y1 = $pdData1['fund_psdp_alloc_y1']; 
$fund_psdp_alloc_y2 = $pdData1['fund_psdp_alloc_y2']; 
$fund_psdp_alloc_y3 = $pdData1['fund_psdp_alloc_y3']; 
$fund_psdp_alloc_y4 = $pdData1['fund_psdp_alloc_y4']; 
$fund_released = $pdData1['fund_released'];
$fund_expense = $pdData1['fund_expense'];
$fund_paid = $pdData1['fund_paid'];
$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult = mysql_query($pcrSQL);
$pcrData = mysql_fetch_array($pcrSQLResult);
$proj_cur=$pcrData["proj_cur"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
 
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
 
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Financial Status</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_financial_info_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Financial Year1:</label></td><td><input  type="text" name="fund_year1" id="fund_year1" value="<?php echo $fund_year1; ?>" /></td></tr>
  <tr><td><label>Financial Year2:</label></td><td><input  type="text" name="fund_year2" id="fund_year2" value="<?php echo $fund_year2; ?>" /></td></tr>
  <tr><td><label>Financial Year3:</label></td><td><input  type="text" name="fund_year3" id="fund_year3" value="<?php echo $fund_year3; ?>" /></td></tr>
  <tr><td><label>Financial Year4:</label></td><td><input  type="text" name="fund_year4" id="fund_year4" value="<?php echo $fund_year4; ?>" /></td></tr>
  
    <tr><td><label>PSPD Allocation Year1: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="fund_psdp_alloc_y1" id="fund_psdp_alloc_y1" value="<?php echo $fund_psdp_alloc_y1; ?>"  /></td></tr>
	 <tr><td><label>PSPD Allocation Year2: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="fund_psdp_alloc_y2" id="fund_psdp_alloc_y2" value="<?php echo $fund_psdp_alloc_y2; ?>"  /></td></tr>
	 <tr><td><label>PSPD Allocation Year3: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="fund_psdp_alloc_y3" id="fund_psdp_alloc_y3" value="<?php echo $fund_psdp_alloc_y3; ?>"  /></td></tr>
	 <tr><td><label>PSPD Allocation Year4: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="fund_psdp_alloc_y4" id="fund_psdp_alloc_y4" value="<?php echo $fund_psdp_alloc_y4; ?>"  /></td></tr>
   
     <tr><td><label>Fund Released: (<?php echo $proj_cur;?>)</label></td><td>
	 <input  type="text" name="fund_released" id="fund_released" value="<?php echo $fund_released; ?>"/>
	</td></tr>
	
	  <tr><td><label>Expenditure: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="fund_expense" id="fund_expense" value="<?php echo $fund_expense; ?>" /></td></tr>
	 
	  <tr><td><label>Payment to Contractor: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="fund_paid" id="fund_paid" value="<?php echo $fund_paid; ?>" /></td></tr>
	    
	 <tr><td colspan="2"> 
	   <input type="hidden" name="fid" id="fid" value="<?php echo $_REQUEST['fid']; ?>" />
	 <input  type="submit" name="update" id="update" value="Update" />
	 <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
