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
	$unit=$_REQUEST['unit'];
	$start=date('Y-m-d',strtotime($_REQUEST['start']));
	$finish=date('Y-m-d',strtotime($_REQUEST['finish']));
	$days=$_REQUEST['days'];
	$tqty=$_REQUEST['tqty']+0;
	$tdqty=$_REQUEST['tdqty']+0;
	$rqty=$_REQUEST['rqty']+0;
	$done=$_REQUEST['done']+0;
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t028dpm(pid, serial, type, description, unit, start, finish, days, tqty, tdqty, rqty, done) Values(".$pid.",".$serial.", '".$type."', '".$description."', '".$unit."', '".$start."' , '".$finish."' , '".$days."' ,".$tqty.", ".$tdqty.", ".$rqty.", '".$done."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
 	$serial='';
	$type = '';
	$description='';
	$unit='';
	$start='';
	$finish='';
	$days='';
	$tqty='';
	$tdqty='';
	$rqty='';
	
}

if(isset($_REQUEST['update']))
{
	$contid=$_REQUEST['contid'];
	$serial=$_REQUEST['serial'];
	$type=$_REQUEST['type'];
	$description=$_REQUEST['description'];
	$unit=$_REQUEST['unit'];
	$start=date('Y-m-d',strtotime($_REQUEST['start']));
	$finish=date('Y-m-d',strtotime($_REQUEST['finish']));
	$days=$_REQUEST['days'];
	$tqty=$_REQUEST['tqty']+0;
	$tdqty=$_REQUEST['tdqty']+0;
	$rqty=$_REQUEST['rqty']+0;
	$done=$_REQUEST['done']+0;
	
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t028dpm SET serial='$serial', type = '$type', description='$description', unit='$unit', start='$start', finish='$finish', days='$days',tqty='$tqty',tdqty='$tdqty',rqty='$rqty' ,done='$done'  where contid=$contid";
	
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
	
header("Location: sp_dpm.php");
}

if(isset($_REQUEST['contid']))
{
$contid=$_REQUEST['contid'];

$pdSQL1="SELECT contid, pgid, pid, serial, type, description, unit, start, finish, days, tqty, tdqty, rqty, done FROM t028dpm  where pid = ".$pid." and  contid = ".$contid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial=$pdData1['serial'];
	$type=$pdData1['type'];
	$description=$pdData1['description'];
	$unit=$pdData1['unit'];
	$start=$pdData1['start'];
	$finish=$pdData1['finish'];
	$days=$pdData1['days'];
	$tqty=$pdData1['tqty'];
	$rqty=$pdData1['rqty'];
	$tdqty=$pdData1['tdqty'];
	$done=$pdData1['done'];

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
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>VO2 Critical Analysis</span><span style="float:right">
    <form action="sp_dpm.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_dpm_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td width="40%"><label>Serial #:</label></td><td width="60%"><input  type="text" name="serial" id="serial" value="<?php echo $serial; ?>" /></td></tr>
  <tr>
    <td><label>Milestone:</label></td>
    <td><select id="type" name="type">
      <?php $pcSQL1="SELECT * FROM  t028dpm_activity  where pid = ".$pid;

$pcSQLResult1 = mysql_query( $pcSQL1) or die(mysql_error());
while($pcData1 = mysql_fetch_array($pcSQLResult1))
{?>
      <option value="<?php echo $pcData1["aid"]?>"><?php echo $pcData1["detail"]?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td><label>Activity:</label></td>
    <td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td>
  </tr>
  <tr>
    <td>Unit:</td>
    <td><input  type="text" name="unit" id="unit" value="<?php echo $unit; ?>" /></td>
  </tr>
  
    <tr><td><label>Start:</label></td><td><input  type="text" name="start" id="start" value="<?php 
	if($start!=""&&$start!="NULL")
	echo date('Y-m',strtotime($start)); ?>" />
      (yyyy-mm-dd)</td></tr>
   
     <tr><td><label>Finish:</label></td><td><input  type="text" name="finish" id="finish" value="<?php if($finish!=""&&$finish!="NULL")echo date('Y-m',strtotime($finish)); ?>" /> 
       (yyyy-mm-dd)</td></tr>
     <tr>
       <td>Days:</td>
       <td><input  type="text" name="days" id="days" value="<?php echo $days; ?>" /></td>
     </tr>
     <tr>
       <td>Total Quantity:</td>
       <td><input  type="text" name="tqty" id="tqty" value="<?php echo $tqty; ?>" /></td>
     </tr>
     <tr>
       <td> Quantity Completed to Date :</td><td><input  type="text" name="tdqty" id="tdqty" value="<?php echo $tdqty; ?>" /></td></tr>
	
	  <tr>
	    <td>Remaining Quantity:</td>
	    <td><input  type="text" name="rqty" id="rqty" value="<?php echo $rqty; ?>" /></td>
	    </tr>
	  <tr>
	    <td>% Done:</td><td><input  type="text" name="done" id="done" value="<?php echo $done; ?>" /></td></tr>
	 
	  
	  
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
