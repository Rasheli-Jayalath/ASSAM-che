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
	
	$description=$_REQUEST['description'];
	$code=$_REQUEST['code'];
	$weight=$_REQUEST['weight'];
	$start=$_REQUEST['start'];
	$finish=$_REQUEST['finish'];
	$astart=$_REQUEST['astart'];
	$afinish=$_REQUEST['afinish'];
	$tamount=$_REQUEST['tamount'];
	$pamount=$_REQUEST['pamount'];
	$actamount=$_REQUEST['actamount'];
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t028dpm_vo2progress (pid,description, code, weight,  start, finish, astart, afinish, tamount, pamount, actamount) Values(".$pid.", '".$description."' , '".$code. "' , '".$weight."' , '".$start."' , '".$finish."' , '".$astart."' , '".$afinish."' , '".$tamount."' , '".$pamount."' , '".$actamount."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	
	$description='';
	$ppt_planned='';
	$ppt_actual='';
	
}

if(isset($_REQUEST['update']))
{
	$contid=$_REQUEST['contid'];
	$description=$_REQUEST['description'];
	$code=$_REQUEST['code'];
	$weight=$_REQUEST['weight'];
	$start=$_REQUEST['start'];
	$finish=$_REQUEST['finish'];
	$astart=$_REQUEST['astart'];
	$afinish=$_REQUEST['afinish'];
	$tamount=$_REQUEST['tamount'];
	$pamount=$_REQUEST['pamount'];
	$actamount=$_REQUEST['actamount'];
	
	$message="";
	$pgid=1;
	
echo $sql_pro="UPDATE t028dpm_vo2progress SET description='$description', code= '$code' , weight='$weight' , start='$start', finish='$finish', astart='$astart', afinish='$afinish', tamount='$tamount', pamount='$pamount', actamount='$actamount' where contid=".$contid;
	
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
	
header("Location: sp_dpm_vo2.php");
}
if(isset($_REQUEST['contid']))
{
$contid=$_REQUEST['contid'];

$pdSQL1="SELECT contid,pid, description, code, weight,  start, finish, astart, afinish, tamount, pamount, actamount  FROM t028dpm_vo2progress where  pid=$pid and contid=$contid order by contid";

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$description=$pdData1['description'];
	$code=$pdData1['code'];
	$weight=$pdData1['weight'];
	$start=$pdData1['start'];
	$finish=$pdData1['finish'];
	$astart=$pdData1['astart'];
	$afinish=$pdData1['afinish'];
	$tamount=$pdData1['tamount'];
	$pamount=$pdData1['pamount'];
	$actamount=$pdData1['actamount'];
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
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>VO2 Progress</span><span style="float:right">
    <form action="sp_dpm_vo2.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_dpm_vo2_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  
   <tr><td><label>Code:</label></td><td><input  type="text" name="code" id="code" value="<?php echo $code; ?>"  size="50px"/></td></tr>
   <tr><td><label>Milestone Name:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>"  size="50px"/></td>
  </tr>
    <tr><td><label>Weight:</label></td><td><input  type="text" name="weight" id="weight" value="<?php echo $weight; ?>"  size="50px"/></td></tr>
     <tr><td><label>Start Date:</label></td><td><input  type="text" name="start" id="start" value="<?php echo $start; ?>"  size="50px"/></td></tr>
       <tr><td><label>End Date:</label></td><td><input  type="text" name="finish" id="finish" value="<?php echo $finish; ?>"  size="50px"/></td></tr>
        <tr><td><label>Actual Start Date:</label></td><td><input  type="text" name="astart" id="astart" value="<?php echo $astart; ?>"  size="50px"/></td></tr>
           <tr><td><label>Actual End Date:</label></td><td><input  type="text" name="afinish" id="afinish" value="<?php echo $afinish; ?>"  size="50px"/></td></tr>
    <tr><td><label>Total Amount:</label></td><td><input  type="text" name="tamount" id="tamount" value="<?php echo $tamount; ?>" /></td></tr>
   
     <tr><td><label>Planned Amount:</label></td><td><input  type="text" name="pamount" id="pamount" value="<?php echo $pamount; ?>" /></td></tr>
	 <tr><td><label>Actual Amount:</label></td><td><input  type="text" name="actamount" id="actamount" value="<?php echo $actamount; ?>" /></td></tr>
	 
	  
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
