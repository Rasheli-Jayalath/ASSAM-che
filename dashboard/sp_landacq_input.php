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

if(isset($_REQUEST['save']))
{
	
	$serial=$_REQUEST['serial'];
	$description=$_REQUEST['description'];
	$amount=$_REQUEST['amount'];
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t0051landacq (pid,serial,description, amount) Values(".$pid.",'".$serial."', '".$description."',".$amount.")");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	
	$serial='';
	$description='';
	$amount='';
}

if(isset($_REQUEST['update']))
{
	$lanid=$_REQUEST['lanid'];
	$serial=$_REQUEST['serial'];
	$description=$_REQUEST['description'];
	$amount=$_REQUEST['amount'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0051landacq SET serial='$serial', description='$description', amount=$amount where lanid=$lanid";
	
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
	
header("Location: sp_landacq.php");
}
if(isset($_REQUEST['lanid']))
{
$lanid=$_REQUEST['lanid'];

$pdSQL1="SELECT lanid, pid, serial, description, amount FROM t0051landacq  where pid = ".$pid." and  lanid = ".$lanid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial = $pdData1['serial'];
	$description = $pdData1['description'];
	$amount = $pdData1['amount'];
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Land Acquisition</span><span style="float:right"><form action="sp_landacq.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_landacq_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Item ID:</label></td><td><input  type="text" name="serial" id="serial" value="<?php echo $serial; ?>" /></td></tr>
  
    <tr><td><label>Description:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td></tr>
   
     <tr><td><label>Value:</label></td><td><input  type="text" name="amount" id="amount" value="<?php echo $amount; ?>" /></td></tr>
	
 <tr><td colspan="2"> <?php if(isset($_REQUEST['lanid']))
	 {
		 
	 ?>
     <input type="hidden" name="lanid" id="lanid" value="<?php echo $_REQUEST['lanid']; ?>" />
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
