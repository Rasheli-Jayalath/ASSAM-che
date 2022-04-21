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
rcid
pgid
pid
serial
description
reloc
remarks
approvedpct
*/

if(isset($_REQUEST['save']))
{
	
	$serial=$_REQUEST['serial'];
	$description=$_REQUEST['description'];
	$nolines=$_REQUEST['nolines'];
	$reloc=$_REQUEST['reloc'];
	$remarks=$_REQUEST['remarks'];
 	$message="";
	$pgid=1;
echo $sql_pro=mysql_query("INSERT INTO t0211relocation (pid, serial, description, nolines, reloc, remarks) Values(".$pid.",".$serial.", '".$description."','".$nolines."','".$reloc."', '".$remarks."')");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
 	$serial='';
	$description='';
	$nolines='';
	$reloc='';
	$remarks='';
 }

if(isset($_REQUEST['update']))
{
	$rcid=$_REQUEST['rcid'];
	$serial=$_REQUEST['serial'];
	$description=$_REQUEST['description'];
	$nolines=$_REQUEST['nolines'];
	$reloc=$_REQUEST['reloc'];
	$remarks=$_REQUEST['remarks'];
 	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0211relocation SET serial='$serial', description='$description', nolines='$nolines', reloc='$reloc', remarks='$remarks' where rcid=$rcid";
	
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
	
header("Location: sp_reloc.php");
}
if(isset($_REQUEST['rcid']))
{
$rcid=$_REQUEST['rcid'];

$pdSQL1="SELECT rcid, pgid, pid, serial, description, nolines, reloc, remarks FROM t0211relocation  where pid = ".$pid." and  rcid = ".$rcid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$serial=$pdData1['serial'];
	$description=$pdData1['description'];
	$nolines=$pdData1['nolines'];
	$reloc=$pdData1['reloc'];
	$remarks=$pdData1['remarks'];
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
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;">Relocation of Utilities<span style="float:right">
    <form action="sp_reloc.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_reloc_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Serial #:</label></td><td><input  type="text" name="serial" id="serial" value="<?php echo $serial; ?>" /></td></tr>
  
    <tr><td><label>      Type of Utility:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td></tr>
   
     <tr><td><label>Number of Lines:</label></td><td><input  type="text" name="nolines" id="nolines" value="<?php echo $nolines; ?>" /></td></tr>
     <tr><td><label>Relocation/ Upraising Status:</label></td><td><input  type="text" name="reloc" id="reloc" value="<?php echo $reloc; ?>" /></td></tr>
	
	  <tr><td><label>Remarks:</label></td><td><input  type="text" name="remarks" id="remarks" value="<?php echo $remarks; ?>" /></td></tr>
	 
	  <tr><td colspan="2"> <?php if(isset($_REQUEST['rcid']))
	 {
		 
	 ?>
	    <input type="hidden" name="rcid" id="rcid" value="<?php echo $_REQUEST['rcid']; ?>" />
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
