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
	
	$s_no=$_REQUEST['s_no'];
	$s_title=$_REQUEST['s_title'];
	$s_detail=$_REQUEST['s_detail'];
	$s_status=$_REQUEST['s_status'];
	$s_action=$_REQUEST['s_action'];
	$s_remarks=$_REQUEST['s_remarks'];
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t028security (pid, s_no, s_title, s_detail, s_status, s_action, s_remarks) Values(".$pid.",'".$s_no."', '".$s_title."', '".$s_detail."', '".$s_status."', '".$s_action."', '".$s_remarks."')");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	
	$s_no='';
	$s_title='';
	$s_detail='';
	$s_status='';
	$s_action='';
	$s_remarks='';
}

if(isset($_REQUEST['update']))
{
	$s_id=$_REQUEST['s_id'];
	$s_no=$_REQUEST['s_no'];
	$s_title=$_REQUEST['s_title'];
	$s_detail=$_REQUEST['s_detail'];
	$s_status=$_REQUEST['s_status'];
	$s_action=$_REQUEST['s_action'];
	$s_remarks=$_REQUEST['s_remarks'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t028security SET s_no='$s_no', s_title='$s_title', s_detail='$s_detail',  s_status='$s_status',  s_action='$s_action', s_remarks='$s_remarks' where s_id=$s_id";
	
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
	
header("Location: sp_security_info.php");
}
if(isset($_REQUEST['s_id']))
{
$s_id=$_REQUEST['s_id'];

$pdSQL1="SELECT s_id, pid, s_no, s_title, s_detail, s_status, s_action, s_remarks FROM t028security  where pid = ".$pid." and  s_id = ".$s_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$s_no=$pdData1['s_no'];
	$s_title=$pdData1['s_title'];
	$s_detail=$pdData1['s_detail'];
	$s_status=$pdData1['s_status'];
	$s_action=$pdData1['s_action'];
	$s_remarks=$pdData1['s_remarks'];
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Security</span><span style="float:right"><form action="sp_security_info.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_security_info_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Security Item No:</label></td><td><input  type="text" name="s_no" id="s_no" value="<?php echo $s_no; ?>" /></td></tr>
  
    <tr><td><label>Title:</label></td><td><textarea rows="4" cols="50" name="s_title"><?php echo $s_title; ?></textarea></td></tr>
   
     <tr><td><label>Detail:</label></td><td><textarea rows="4" cols="50" name="s_detail"><?php echo $s_detail; ?></textarea></td></tr>
	
	  <tr><td><label>Status:</label></td><td><textarea rows="4" cols="50" name="s_status"><?php echo $s_status; ?></textarea></td></tr>
	 
	  <tr><td><label>Action:</label></td><td><textarea rows="4" cols="50" name="s_action"><?php echo $s_action; ?></textarea></td></tr>
	   <tr><td><label>Remarks:</label></td><td><textarea rows="4" cols="50" name="s_remarks"><?php echo $s_remarks; ?></textarea></td></tr>
	  
	 <tr><td colspan="2"> <?php if(isset($_REQUEST['s_id']))
	 {
		 
	 ?>
     <input type="hidden" name="s_id" id="s_id" value="<?php echo $_REQUEST['s_id']; ?>" />
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
