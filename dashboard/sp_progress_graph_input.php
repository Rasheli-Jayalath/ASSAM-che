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

if(isset($_REQUEST['save']))
{

	$planned=$_REQUEST['planned'];
	$actual=$_REQUEST['actual'];
	$ppg_date1=$_REQUEST['ppg_date'];
	$ppg_date_arr=explode("-",$ppg_date1);
	$y=$ppg_date_arr[0];
	$m=$ppg_date_arr[1];
	$month_days=cal_days_in_month(CAL_GREGORIAN,$m,$y);
	$ppg_date=$y."-".$m."-".$month_days;	
	$message="";
	$pgid=1;
	 $pdSQL = "SELECT ppg_id, pid, planned, actual, ppg_date from t023project_progress_graph where pid = ".$pid." and ppg_date='$ppg_date'";
$pdSQLResult = mysql_query($pdSQL);
//echo mysql_num_rows($pdSQLResult);
if(mysql_num_rows($pdSQLResult)>=1)
{
	$message=  "This month data is already exist.";
	$planned='';
	$actual='';
	$ppg_date='';
}
else
{
$sql_pro=mysql_query("INSERT INTO t023project_progress_graph (pid, planned, actual, ppg_date) Values(".$pid.",".$planned.", ".$actual.", '".$ppg_date."')");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	
	$planned='';
	$actual='';
	$ppg_date='';
}
	
}

if(isset($_REQUEST['update']))
{
	$ppg_id=$_REQUEST['ppg_id'];
	$planned=$_REQUEST['planned'];
	$actual=$_REQUEST['actual'];
	$ppg_date1=$_REQUEST['ppg_date'];	
	$ppg_date_arr1=explode("-",$ppg_date1);
	$y1=$ppg_date_arr1[0];
	$m1=$ppg_date_arr1[1];
	$month_days1=cal_days_in_month(CAL_GREGORIAN,$m1,$y1);
	$ppg_date=$y1."-".$m1."-".$month_days1;
	
	$message="";
	$pgid=1;
	
	 $pdSQL = "SELECT ppg_id, pid, planned, actual, ppg_date from t023project_progress_graph where pid = ".$pid." and ppg_date='$ppg_date'";
$pdSQLResult = mysql_query($pdSQL);
if(mysql_num_rows($pdSQLResult)>=1)
{
	$message=  "This month data is already exist.";
	
}
else
{
	
$sql_pro="UPDATE t023project_progress_graph SET planned=$planned, actual=$actual, ppg_date='$ppg_date' where ppg_id=$ppg_id";
	
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
	
header("Location: sp_progress_graph.php");
}
}
if(isset($_REQUEST['ppg_id']))
{
$ppg_id=$_REQUEST['ppg_id'];

$pdSQL1="SELECT ppg_id, pid, planned, actual, ppg_date from t023project_progress_graph  where pid = ".$pid." and  ppg_id = ".$ppg_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	
	$planned=$pdData1['planned'];
	$actual=$pdData1['actual'];
	$ppg_date=$pdData1['ppg_date'];
}
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Project Progress</span><span style="float:right"><form action="sp_progress_graph.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_progress_graph_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <?php
  if(isset($_REQUEST['ppg_id']))
	 {
	
  $ppg_date_arr1=explode("-",$ppg_date);
	$y1=$ppg_date_arr1[0];
	$m1=$ppg_date_arr1[1];
	$ppg_date_f=$y1."-".$m1;
	}
	else
	{
	$ppg_date_f="";
	}
  ?>
  <tr><td><label>Month:</label></td><td><input  type="text" name="ppg_date" id="ppg_date" value="<?php echo $ppg_date_f; ?>" /> yyyy-mm</td></tr>
  <tr><td><label>Planned:</label></td><td><input  type="text" name="planned" id="planned" value="<?php echo $planned; ?>" /></td></tr>
  <tr><td><label>Actual:</label></td><td><input  type="text" name="actual" id="actual" value="<?php echo $actual; ?>" /></td></tr>
  
    
	 <tr>
	 <td colspan="2">
	  <?php if(isset($_REQUEST['ppg_id']))
	 {
		 
	 ?>
     <input type="hidden" name="ppg_id" id="ppg_id" value="<?php echo $_REQUEST['ppg_id']; ?>" />
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
