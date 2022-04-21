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

if(isset($_REQUEST['save']))
{

	$proj_name=$_REQUEST['proj_name'];
	$pcolor="#F90";
		
	$message="";
	$pgid=1;
	$sridlist = $_SESSION['sridlist'];
	$max_srid = max($sridlist);
	$sr_max = $_SESSION['sr_max'];
	
$sql_pro=mysql_query("INSERT INTO t002project (srid, proj_name, pcolor) Values(".($max_srid+1).", '".$proj_name."', '".$pcolor."')");
$max_id=mysql_insert_id();
$sql1=mysql_query("INSERT INTO t024project_progress_table (pid, act_id) select ".$max_id." as pid, act_name  from t011activities order by act_order");

$sql1=mysql_query("INSERT INTO t003funds (pid) VALUES (".$max_id.")");

	if ($sql_pro == TRUE) {
		$_SESSION['max_pid']=$max_id;
		array_push($sridlist, ($max_srid+1));
		$_SESSION['sridlist'] = $sridlist;
		$_SESSION['sr_max'] = $sr_max + 1 ;
		$message=  "New record added successfully";
	} else {
    	$message= mysql_error($db);
	}
	$proj_name='';
}

if(isset($_REQUEST['update']))
{

	$pid2=$_REQUEST['pid'];
	$proj_name=$_REQUEST['proj_name'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t002project SET proj_name='$proj_name' where pid=$pid2";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	

header("Location: sp_maindashboard.php");
}

if(isset($_REQUEST['pid']))
{
$pid1=$_REQUEST['pid'];
$pdSQL1="SELECT pid,pgid,proj_name FROM t002project  where pid = ".$pid1;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$proj_name=$pdData1['proj_name'];
	
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Project List</span><span style="float:right"><form action="sp_maindashboard.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_maindashboard_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Project Name:</label></td><td><input  type="text" name="proj_name" id="proj_name" value="<?php echo $proj_name; ?>"  size="80px"/></td></tr>
  
   
	 <tr>
	 <td colspan="2">
	  <?php if(isset($_REQUEST['pid']))
	 {
		 
	 ?>
     <input type="hidden" name="pid" id="pid" value="<?php echo $_REQUEST['pid']; ?>" />
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
