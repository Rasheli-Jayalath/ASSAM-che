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
	
	$iss_no=$_REQUEST['iss_no'];
	$iss_title=$_REQUEST['iss_title'];
	$iss_detail=$_REQUEST['iss_detail'];
	$iss_status=$_REQUEST['iss_status'];
	$iss_action=$_REQUEST['iss_action'];
	$iss_remarks=$_REQUEST['iss_remarks'];
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t012issues (pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks) Values(".$pid.",'".$iss_no."', '".$iss_title."', '".$iss_detail."', '".$iss_status."', '".$iss_action."', '".$iss_remarks."')");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	
	$iss_no='';
	$iss_title='';
	$iss_detail='';
	$iss_status='';
	$iss_action='';
	$iss_remarks='';
}

if(isset($_REQUEST['update']))
{
	$iss_id=$_REQUEST['iss_id'];
	$iss_no=$_REQUEST['iss_no'];
	$iss_title=$_REQUEST['iss_title'];
	$iss_detail=$_REQUEST['iss_detail'];
	$iss_status=$_REQUEST['iss_status'];
	$iss_action=$_REQUEST['iss_action'];
	$iss_remarks=$_REQUEST['iss_remarks'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t012issues SET iss_no='$iss_no', iss_title='$iss_title', iss_detail='$iss_detail',  iss_status='$iss_status',  iss_action='$iss_action', iss_remarks='$iss_remarks' where iss_id=$iss_id";
	
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
	
header("Location: sp_issues_info.php");
}
if(isset($_REQUEST['iss_id']))
{
$iss_id=$_REQUEST['iss_id'];

$pdSQL1="SELECT iss_id, pid, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks FROM t012issues  where pid = ".$pid." and  iss_id = ".$iss_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$iss_no=$pdData1['iss_no'];
	$iss_title=$pdData1['iss_title'];
	$iss_detail=$pdData1['iss_detail'];
	$iss_status=$pdData1['iss_status'];
	$iss_action=$pdData1['iss_action'];
	$iss_remarks=$pdData1['iss_remarks'];
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Major/Current Issues</span><span style="float:right"><form action="sp_issues_info.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_issues_info_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Issue No:</label></td><td><input  type="text" name="iss_no" id="iss_no" value="<?php echo $iss_no; ?>" /></td></tr>
  
    <tr><td><label>Title:</label></td><td><textarea rows="4" cols="50" name="iss_title"><?php echo $iss_title; ?></textarea></td></tr>
   
     <tr><td><label>Detail:</label></td><td><textarea rows="4" cols="50" name="iss_detail"><?php echo $iss_detail; ?></textarea></td></tr>
	
	  <tr><td><label>Status:</label></td><td><textarea rows="4" cols="50" name="iss_status"><?php echo $iss_status; ?></textarea></td></tr>
	 
	  <tr><td><label>Action:</label></td><td><textarea rows="4" cols="50" name="iss_action"><?php echo $iss_action; ?></textarea></td></tr>
	   <tr><td><label>Remarks:</label></td><td><textarea rows="4" cols="50" name="iss_remarks"><?php echo $iss_remarks; ?></textarea></td></tr>
	  
	 <tr><td colspan="2"> <?php if(isset($_REQUEST['iss_id']))
	 {
		 
	 ?>
     <input type="hidden" name="iss_id" id="iss_id" value="<?php echo $_REQUEST['iss_id']; ?>" />
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
