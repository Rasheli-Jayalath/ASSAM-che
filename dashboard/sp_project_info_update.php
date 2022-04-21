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



if(isset($_REQUEST['update']))
{

	//$pid=$_REQUEST['pid'];
	$proj_length=$_REQUEST['proj_length'];
	$con_id=$_REQUEST['con_id'];
	$comp1=$_REQUEST['comp1'];
	$comp2=$_REQUEST['comp2'];
	$cons_id=$_REQUEST['cons_id'];
	$proj_cont_price=$_REQUEST['proj_cont_price'];
	$proj_start_date=$_REQUEST['proj_start_date'];
	$proj_end_date=$_REQUEST['proj_end_date'];
	$proj_src_fund=$_REQUEST['proj_src_fund'];
	$proj_pc1_amount=$_REQUEST['proj_pc1_amount'];
	$proj_cur=$_REQUEST['proj_cur'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t002project SET proj_length='$proj_length', con_id='$con_id', comp1='$comp1', comp2='$comp2', cons_id='$cons_id',  proj_cont_price='$proj_cont_price',  proj_start_date='$proj_start_date', proj_end_date='$proj_end_date',proj_src_fund='$proj_src_fund', proj_pc1_amount='$proj_pc1_amount' , proj_cur='$proj_cur' where pid=$pid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	

//header("Location: sp_project_info_update.php");
}


$pdSQL1="SELECT pid,pgid,proj_name,proj_length,con_id,comp1,comp2, cons_id,proj_cont_price,proj_start_date,proj_end_date,proj_src_fund,proj_pc1_amount,proj_cur  FROM t002project  where pid = ".$pid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$proj_name=$pdData1['proj_name'];
	$proj_length=$pdData1['proj_length'];
	$con_id=$pdData1['con_id'];
	$comp1=$pdData1['comp1'];
	$comp2=$pdData1['comp2'];
	$cons_id=$pdData1['cons_id'];
	$proj_cont_price=$pdData1['proj_cont_price'];
	$proj_start_date=$pdData1['proj_start_date'];
	$proj_end_date=$pdData1['proj_end_date'];
	$proj_src_fund=$pdData1['proj_src_fund'];
	$proj_pc1_amount=$pdData1['proj_pc1_amount'];
	$proj_cur=$pdData1['proj_cur'];

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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Project Information</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_project_info_update.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Civilworks Contractor:</label></td><td><input  type="text" name="proj_length" id="proj_length" value="<?php echo $proj_length; ?>" /></td></tr>
  
    <tr><td><label>E &amp; M Contractor:</label></td><td><input  type="text" name="con_id" id="con_id" value="<?php echo $con_id; ?>"  />					</td></tr>
	 <tr><td><label>Company 1:</label></td><td><input  type="text" name="comp1" id="comp1" value="<?php echo $comp1; ?>"  /> (displayed on Contractor Mobilization and QA/QC Tests)					</td></tr>
	  <tr><td><label>Company 2:</label></td><td><input  type="text" name="comp2" id="comp2" value="<?php echo $comp2; ?>"  /> (displayed on Contractor Mobilization and QA/QC Tests)					</td></tr>
   
     <tr><td><label>Consultant (M&E):</label></td><td>
	 <input  type="text" name="cons_id" id="cons_id" value="<?php echo $cons_id; ?>"  size="50"/>
	</td></tr>
	
	  <tr><td><label>Contract Price:</label></td><td><input  type="text" name="proj_cont_price" id="proj_cont_price" value="<?php echo $proj_cont_price; ?>" /></td></tr>
	 
	  <tr><td><label>Start Date:</label></td><td><input  type="text" name="proj_start_date" id="proj_start_date" value="<?php echo $proj_start_date; ?>" /> yyyy-mm-dd</td>
	  </tr>
	   <tr><td><label>VO2 Completion Date:</label></td><td><input  type="text" name="proj_end_date" id="proj_end_date" value="<?php echo $proj_end_date; ?>" /> yyyy-mm-dd</td></tr>
	 
	  <tr><td><label>Source of Funds:</label></td><td><input  type="text" name="proj_src_fund" id="proj_src_fund" value="<?php echo $proj_src_fund; ?>" /></td></tr>
	  <tr><td><label>Appro. PC-1 Amount:</label></td><td><input  type="text" name="proj_pc1_amount" id="proj_pc1_amount" value="<?php echo $proj_pc1_amount; ?>" /></td></tr>
	   <tr><td><label>Currency:</label></td><td><input  type="text" name="proj_cur" id="proj_cur" value="<?php echo $proj_cur; ?>" /></td></tr>
	  
	 <tr><td colspan="2"> 
	 <input  type="submit" name="update" id="update" value="Update" />
	 <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
