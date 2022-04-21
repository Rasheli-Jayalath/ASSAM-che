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
$lock=0;
if(isset($_REQUEST['save']))
{
	
	
	$year=$_REQUEST['year'];
	$pm_month1=$_REQUEST['pm_month'];
	$pm_month=$year."-".$pm_month1."-01";	
	$pm_value=$_REQUEST['pm_value'];
	$pm_percent=$_REQUEST['pm_percent'];
	$message="";
	$pgid=1;
	
	$pdSQL = "SELECT pm_cf, pid, year, pm_month, pm_value, pm_percent from t016project_monthwisecashflow where pid = ".$pid." and pm_month='$pm_month'";
$pdSQLResult = mysql_query($pdSQL);
//echo mysql_num_rows($pdSQLResult);
if(mysql_num_rows($pdSQLResult)>=1)
{
	$message=  "This month data is already exist.";
	$year='';
	$pm_month = '';
	$pm_value='';
	$pm_percent='';
}
else
{	
	
$sql_pro=mysql_query("INSERT INTO t016project_monthwisecashflow (pid, year, pm_month, pm_value, pm_percent) Values(".$pid.",'".$year."', '".$pm_month."', ".$pm_value.",".$pm_percent.")");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
 	$year='';
	$pm_month = '';
	$pm_value='';
	$pm_percent='';
	
}
}

if(isset($_REQUEST['update']))
{
	$pm_cf=$_REQUEST['pm_cf'];
	$year=$_REQUEST['year'];
	$pm_month2=$_REQUEST['pm_month'];
	$pm_month=$year."-".$pm_month2."-01";	
	$pm_value=$_REQUEST['pm_value'];
	$pm_percent=$_REQUEST['pm_percent'];
	$message="";
	$pgid=1;
	
	
	
	
$sql_pro="UPDATE t016project_monthwisecashflow SET year='$year', pm_value=$pm_value, pm_percent=$pm_percent where 
pm_cf=$pm_cf";
	
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
	
header("Location: sp_cashflow.php");

}

if(isset($_REQUEST['pm_cf']))
{
$pm_cf=$_REQUEST['pm_cf'];

$pdSQL1="SELECT pm_cf, pid, pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow  where pid = ".$pid." and  pm_cf = ".$pm_cf;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$pm_cf=$pdData1['pm_cf'];
	$year=$pdData1['year'];
	$pm_month=$pdData1['pm_month'];
	$pm_value=$pdData1['pm_value'];
	$pm_percent=$pdData1['pm_percent'];
	$lock=1;
}

$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult = mysql_query($pcrSQL);
$pcrData = mysql_fetch_array($pcrSQLResult);
$proj_cur=$pcrData["proj_cur"];

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
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Cash Flow Requirement</span><span style="float:right">
    <form action="sp_cashflow.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_cashflow_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Year (2016/2017/2018/2019):</label></td><td><input  type="text" name="year" id="year" value="<?php echo $year; ?>" /></td></tr>
  <?php $ppg_date_arr1=explode("-",$pm_month);
	$y1=$ppg_date_arr1[0];
	$m1=$ppg_date_arr1[1];
	
	?>
  <tr><td><label>Month:</label></td><td>
   <select name="pm_month" <?php if($lock==1){ echo 'disabled="disabled"';} ?>>
       <!-- <option value="">-- Select Month --</option>-->
		<?php for ($x = 1; $x <= 12; $x++) { 
		if($x==1){$x1='01';}
		if($x==2){$x1='02';}
		if($x==3){$x1='03';}
		if($x==4){$x1='04';}
		if($x==5){$x1='05';}
		if($x==6){$x1='06';}
		if($x==7){$x1='07';}
		if($x==8){$x1='08';}
		if($x==9){$x1='09';}
		if($x==10){$x1='10';}
		if($x==11){$x1='11';}
		if($x==12){$x1='12';}
		if($m1==$x1)
		{
		$sel="selected";
		}
		else
		{
		$sel="";
		}
		?>
		
          <option value=<?php echo $x1; ?> <?php echo $sel;?>><?php echo date('M', mktime(0,0,0,$x1)) ?> </option>
		  <?php
		  }
		  ?>
</select>
  
  </td></tr>
  
    <tr><td><label>Amount: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="pm_value" id="pm_value" value="<?php echo $pm_value; ?>" /></td></tr>
   
     <tr><td><label>Amount(%):</label></td><td><input  type="text" name="pm_percent" id="pm_percent" value="<?php echo $pm_percent; ?>" /></td></tr>
    
	  
	 <tr><td colspan="2"> <?php if(isset($_REQUEST['pm_cf']))
	 {
		 
	 ?>
     <input type="hidden" name="pm_cf" id="pm_cf" value="<?php echo $_REQUEST['pm_cf']; ?>" />
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
