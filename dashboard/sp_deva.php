<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include_once("connect.php");
include_once("functions.php");

if(isset($_REQUEST['delete']))
{
mysql_query("Delete from t0211eva where rcid=".$_REQUEST['rcid']);
}

//===============================================

 $pdSQL = "SELECT rcid, pgid, pid, serial, description, nolines FROM t0211eva where pid = ".$pid." order by serial";
$pdSQLResult = mysql_query($pdSQL);
} else {
	header("Location: index.php?msg=0");
}

$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult = mysql_query($pcrSQL);
$pcrData = mysql_fetch_array($pcrSQLResult);
$proj_cur=$pcrData["proj_cur"];
$evaSQL1 ="SELECT min(ppg_date) as start from t0211eva_progress_graph where pid =".$pid;
$evaSQLResult1 = mysql_query($evaSQL1);
$evaData1 = mysql_fetch_array($evaSQLResult1);
$evaSQL ="SELECT ppg_date, cpi,spi,tcpi from t0211eva_progress_graph where pid=".$pid." AND ppg_date = (SELECT max(ppg_date) from t0211eva_progress_graph)";
$evaSQLResult = mysql_query($evaSQL);
$evaData = mysql_fetch_array($evaSQLResult);
$ppg_date=$evaData["ppg_date"];
$cpi=$evaData["cpi"];
$spi=$evaData["spi"];
$tcpi=$evaData["tcpi"];
$end=$ppg_date;
$start=$evaData1["start"];
function GetPlannedData($start,$end)
{
	$reportquery ="SELECT * FROM  t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
			
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
		if($reportdata["planned"]!=0&&$reportdata["planned"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".round($reportdata["planned"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetActualData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
			
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
		if($reportdata["actual"]!=0&&$reportdata["actual"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".round($reportdata["actual"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetEarnedData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
			
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
		if($reportdata["earned"]!=0&&$reportdata["earned"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".round($reportdata["earned"])." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}

function GetCPIData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
			
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
		if($reportdata["cpi"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".number_format($reportdata["cpi"],2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
function GetSPIData($start,$end)
{
	$reportquery ="SELECT * FROM t0211eva_progress_graph  where ppg_date >='".$start."' AND ppg_date <='".$end."' order by ppg_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
			
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
		if($reportdata["spi"]!="")
		{	
				$month=date('m',strtotime($reportdata["ppg_date"]))-1;
			
				$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["ppg_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["ppg_date"])). ") , ".number_format($reportdata["spi"],2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
		}
					 
				}
				
	return $code_str;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
 <script src="https://code.highcharts.com/modules/jquery.highchartTable.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
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
  <table style="width:100%; height:100% ;">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Earned Value Analysis</span><span style="float:right">
    <form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%; "><td align="center">
    <span style="text-align:right; "><form action="sp_eva.php" method="post"><input type="submit" name="view_tab " id="view_tab" value="View Tabular Data" /></form></span>
 <?php if($adminflag==1)
{
?>

   <span style="text-align:right; "><form action="sp_evaprogress_graph.php" method="post"><input type="submit" name="add_gdata" id="add_gdata" 
   value="Manage Graphic Data" /></form></span>
  <?php
  }
  ?>


 <div style="overflow-y: scroll; height:400px;">
          
  
                              
                              
						</td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
