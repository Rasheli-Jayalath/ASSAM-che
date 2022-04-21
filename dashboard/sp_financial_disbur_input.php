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
dgid
pgid
pid
serial
description
revision
approved
approvedpct
*/

if(isset($_REQUEST['save']))
{
	
	$serial=$_REQUEST['serial'];
	$type=$_REQUEST['type'];
	$description=$_REQUEST['description'];
	$fmonth=date('Y-m-d',strtotime($_REQUEST['fmonth']));
	$amount_claim=$_REQUEST['amount_claim']+0;
	$amount_paid=$_REQUEST['amount_paid']+0;
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t0029financial_disbursement(pid, serial, type, description, fmonth, amount_claim, amount_paid) Values(".$pid.",".$serial.", '".$type."', '".$description."', '".$fmonth."' ,".$amount_claim.", ".$amount_paid.")");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
 	$serial='';
	$type = '';
	$description='';
	$fmonth='';
	$amount_claim='';
	$amount_paid='';
	
}

if(isset($_REQUEST['update']))
{
	$contid=$_REQUEST['contid'];
	$serial=$_REQUEST['serial'];
	$type=$_REQUEST['type'];
	$description=$_REQUEST['description'];
	$fmonth=date('Y-m-d',strtotime($_REQUEST['fmonth']));
	$amount_claim=$_REQUEST['amount_claim']+0;
	$amount_paid=$_REQUEST['amount_paid']+0;
	
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0029financial_disbursement SET serial='$serial', type = '$type', description='$description', fmonth='$fmonth', amount_claim=$amount_claim, amount_paid=$amount_paid where contid=$contid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
header("Location: sp_financial_disbur.php");
}

if(isset($_REQUEST['contid']))
{
$contid=$_REQUEST['contid'];

$pdSQL1="SELECT contid, pgid, pid, serial, type, description, fmonth, amount_claim, amount_paid FROM t0029financial_disbursement  where pid = ".$pid." and  contid = ".$contid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial=$pdData1['serial'];
	$type=$pdData1['type'];
	$description=$pdData1['description'];
	$fmonth=$pdData1['fmonth'];
	$amount_claim=$pdData1['amount_claim'];
	$amount_paid=$pdData1['amount_paid'];

}

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
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Financial Disbursement</span><span style="float:right">
    <form action="sp_financial_disbur.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_financial_disbur_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Serial #:</label></td><td><input  type="text" name="serial" id="serial" value="<?php echo $serial; ?>" /></td></tr>
  <tr><td><label>Component:</label></td><td><select id="type" name="type">
 <?php $pcSQL1="SELECT * FROM  mis_tbl_2_components  where pid = ".$pid;

$pcSQLResult1 = mysql_query( $pcSQL1) or die(mysql_error());
while($pcData1 = mysql_fetch_array($pcSQLResult1))
{?>
<option value="<?php echo $pcData1["cid"]?>"><?php echo $pcData1["detail"]?></option>
<?php }?>
  </select></td></tr>
  
    <tr><td><label>Description:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td></tr>
   
     <tr><td><label>Month</label></td><td><input  type="text" name="fmonth" id="fmonth" value="<?php if($fmonth!=""&&$fmonth!="NULL")echo date('Y-m',strtotime($fmonth)); ?>" /> (yyyy-mm)</td></tr>
     <tr><td><label>Amount Claimed: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="amount_claim" id="amount_claim" value="<?php echo $amount_claim; ?>" /></td></tr>
	
	  <tr><td><label>Amount Paid: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="amount_paid" id="amount_paid" value="<?php echo $amount_paid; ?>" /></td></tr>
	 
	  
	  
	 <tr><td colspan="2"> <?php if(isset($_REQUEST['contid']))
	 {
		 
	 ?>
     <input type="hidden" name="contid" id="contid" value="<?php echo $_REQUEST['contid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
