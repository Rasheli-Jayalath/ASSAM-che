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
	$comp1_foreign=$_REQUEST['comp1_foreign']+0;
	$comp1_local=$_REQUEST['comp1_local']+0;
	$comp2_foreign=$_REQUEST['comp2_foreign']+0;
	$comp2_local=$_REQUEST['comp2_local']+0;
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t0081contmob (pid, serial, type, description, comp1_foreign, comp1_local, comp2_foreign, comp2_local) Values(".$pid.",".$serial.", '".$type."', '".$description."',".$comp1_foreign.",".$comp1_local.", ".$comp2_foreign.", ".$comp2_local.")");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
 	$serial='';
	$type = '';
	$description='';
	$comp1_foreign='';
	$comp1_local='';
	$comp2_foreign='';
	$comp2_local='';
}

if(isset($_REQUEST['update']))
{
	$contid=$_REQUEST['contid'];
	$serial=$_REQUEST['serial'];
	$type=$_REQUEST['type'];
	$description=$_REQUEST['description'];
	$comp1_foreign=$_REQUEST['comp1_foreign']+0;
	$comp1_local=$_REQUEST['comp1_local']+0;
	$comp2_foreign=$_REQUEST['comp2_foreign']+0;
	$comp2_local=$_REQUEST['comp2_local']+0;
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0081contmob SET serial='$serial', type = '$type', description='$description', comp1_foreign=$comp1_foreign, comp1_local=$comp1_local, comp2_foreign=$comp2_foreign, comp2_local=$comp2_local where contid=$contid";
	
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
	
header("Location: sp_contmob.php");
}

if(isset($_REQUEST['contid']))
{
$contid=$_REQUEST['contid'];

$pdSQL1="SELECT contid, pgid, pid, serial, type, description, comp1_foreign, comp1_local, comp2_foreign, comp2_local FROM t0081contmob  where pid = ".$pid." and  contid = ".$contid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial=$pdData1['serial'];
	$type=$pdData1['type'];
	$description=$pdData1['description'];
	$comp1_foreign=$pdData1['comp1_foreign'];
	$comp1_local=$pdData1['comp1_local'];
	$comp2_foreign=$pdData1['comp2_foreign'];
	$comp2_local=$pdData1['comp2_local'];
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
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Contractor's Mobilization</span><span style="float:right">
    <form action="sp_contmob.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_contmob_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Serial #:</label></td><td><input  type="text" name="serial" id="serial" value="<?php echo $serial; ?>" /></td></tr>
  <tr><td><label>Type (D/C/E):</label></td><td><input  type="text" name="type" id="type" value="<?php echo $type; ?>" /></td></tr>
  
    <tr><td><label>Description:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td></tr>
   
     <tr><td><label>Company 1 Foreign:</label></td><td><input  type="text" name="comp1_foreign" id="comp1_foreign" value="<?php echo $comp1_foreign; ?>" /></td></tr>
     <tr><td><label>Company 1 Local:</label></td><td><input  type="text" name="comp1_local" id="comp1_local" value="<?php echo $comp1_local; ?>" /></td></tr>
	
	  <tr><td><label>Company 2 Foreign:</label></td><td><input  type="text" name="comp2_foreign" id="comp2_foreign" value="<?php echo $comp2_foreign; ?>" /></td></tr>
	 
	  <tr>
	    <td>Company 2 Local:</td><td><input  type="text" name="comp2_local" id="comp2_local" value="<?php echo $comp2_local; ?>" /></td></tr>
	  
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
