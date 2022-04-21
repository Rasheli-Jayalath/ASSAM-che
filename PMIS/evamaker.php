<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($process_flag==0 ) {
header("Location: index.php?init=3");
}

function BudgetDataMaker($kpimonth, $total_budget) {
   	   
	    $var1 = str_replace("-","",$kpimonth); // Date var
	 	$fmonth= date('m',strtotime($kpimonth."-01"));
		$fyear= date('Y',strtotime($kpimonth."-01"));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$kpimonth=$fyear."-".$fmonth."-".$fmonth_days;
		 $var1= $var1.$fmonth_days;
		
	$prmin = "select sum(budgetqty) as bmonthlycost from planned where budgetdate='$kpimonth'";
	$bmonthlycostresult = mysql_query($prmin);
	$bmonthlycostdata = mysql_fetch_array($bmonthlycostresult);
	$bmonthlycost = $bmonthlycostdata['bmonthlycost']; // Budget Minimum Month
	
	$prminc = "select sum(budgetqty) as bcommulativecost from planned where budgetdate<='$kpimonth'";
	
	$bcommulativecostresult = mysql_query($prminc);
	$bcommulativecostdata = mysql_fetch_array($bcommulativecostresult);
	$bcommulativecost = $bcommulativecostdata['bcommulativecost']; // Budget Minimum Month
	
	$bmonthlypercent=$bmonthlycost/$total_budget*100;
	$bcommulativepercent=$bcommulativecost/$total_budget*100;
	
echo "INSERT INTO `s006-eva-budget` (bcomponent, bmonth, bmonthlycost, bcommulativecost, bmonthlypercent, bcommulativepercent) VALUES (1,'$kpimonth','$bmonthlycost','$bcommulativecost','$bmonthlypercent','$bcommulativepercent')";
	
 mysql_query("INSERT INTO `s006-eva-budget` (bcomponent, bmonth, bmonthlycost, bcommulativecost, bmonthlypercent, bcommulativepercent) VALUES (1,'$kpimonth','$bmonthlycost','$bcommulativecost','$bmonthlypercent','$bcommulativepercent')");
	echo "<br>";
	
}

function EarnedDataMaker($kpimonth, $total_progress) {
   	   
	   
	    $var1 = str_replace("-","",$kpimonth); // Date var
	 	$fmonth= date('m',strtotime($kpimonth."-01"));
		$fyear= date('Y',strtotime($kpimonth."-01"));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$kpimonth=$fyear."-".$fmonth."-".$fmonth_days;
			$kpimonth=$fyear."-".$fmonth."-"."01";
		 
		
	 $prmin = "select sum(progressqty) as emonthlycost from progress where progressdate='$kpimonth'";
	$emonthlycostresult = mysql_query($prmin);
	$emonthlycostdata = mysql_fetch_array($emonthlycostresult);
	$emonthlycost = $emonthlycostdata['emonthlycost']; // Budget Minimum Month
	
	$prminc = "select sum(progressqty) as ecommulativecost from progress where progressdate<='$kpimonth'";
	
	$ecommulativecostresult = mysql_query($prminc);
	$ecommulativecostdata = mysql_fetch_array($ecommulativecostresult);
	$ecommulativecost = $ecommulativecostdata['ecommulativecost']; // Budget Minimum Month
	
	$emonthlypercent=$emonthlycost/$total_progress*100;
	$ecommulativepercent=$ecommulativecost/$total_progress*100;
	
//echo "INSERT INTO `s007-eva-earned` (ecomponent, emonth, emonthlycost, ecommulativecost, emonthlypercent, ecommulativepercent) VALUES (1,'$kpimonth','$emonthlycost','$ecommulativecost','$emonthlypercent','$ecommulativepercent')";

$kpimonth=$fyear."-".$fmonth."-".$fmonth_days;
	
 mysql_query("INSERT INTO `s007-eva-earned` (ecomponent, emonth, emonthlycost, ecommulativecost, emonthlypercent, ecommulativepercent) VALUES (1,'$kpimonth','$emonthlycost','$ecommulativecost','$emonthlypercent','$ecommulativepercent')");
	echo "<br>";
	
}

function ActualDataMaker($kpimonth, $total_actual) {
   	   
	   
	    $var1 = str_replace("-","",$kpimonth); // Date var
	 	$fmonth= date('m',strtotime($kpimonth."-01"));
		$fyear= date('Y',strtotime($kpimonth."-01"));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$kpimonth=$fyear."-".$fmonth."-".$fmonth_days;
			$kpimonth=$fyear."-".$fmonth."-"."01";
		 
		$prmipc = "select ipcid,ipcno from ipc where ipcmonth='$kpimonth'";
	$ipcresult = mysql_query($prmipc);
	$ipcdata = mysql_fetch_array($ipcresult);
	$ipc = $ipcdata['ipcid'];
	$ipcno = $ipcdata['ipcno'];
	
	 $prmin = "select sum(ipcqty) as amonthlycost from ipcv where ipcid='$ipc'";
	$amonthlycostresult = mysql_query($prmin);
	$amonthlycostdata = mysql_fetch_array($amonthlycostresult);
	$amonthlycost = $amonthlycostdata['amonthlycost']; // Budget Minimum Month
	
	$prmina = "select sum(ipcqty) as acommulativecost from ipcv where ipcid<='$ipc'";
	
	$acommulativecostresult = mysql_query($prmina);
	$acommulativecostdata = mysql_fetch_array($acommulativecostresult);
	$acommulativecost = $acommulativecostdata['acommulativecost']; // Budget Minimum Month
	
	$amonthlypercent=$amonthlycost/$total_actual*100;
	$acommulativepercent=$acommulativecost/$total_actual*100;
$kpimonth=$fyear."-".$fmonth."-".$fmonth_days;
	
 mysql_query("INSERT INTO `s008-eva-actual` (acomponent, amonth, amonthlycost, acommulativecost, amonthlypercent, acommulativepercent,aipcnumber) VALUES (1,'$kpimonth','$amonthlycost','$acommulativecost','$amonthlypercent','$acommulativepercent','$ipcno')");
	
	
}
mysql_query("truncate table `s006-eva-budget`");
mysql_query("truncate table `s007-eva-earned`");
mysql_query("truncate table `s008-eva-actual`");
$sql = "select sum(budgetqty) as total_budget from planned ";
$result = mysql_query($sql);
$budget=mysql_fetch_array($result);
$total_budget=$budget["total_budget"];

$sql = "select sum(progressqty) as total_progress from progress ";
$result = mysql_query($sql);
$progress=mysql_fetch_array($result);
$total_progress=$progress["total_progress"];


$sql = "select sum(boqamount) as total_actual from boq ";
$result = mysql_query($sql);
$actual=mysql_fetch_array($result);
$total_actual=$actual["total_actual"];


	$scalesql = "select scmonth from kpiscale";
	$scaleresult = mysql_query($scalesql);
	
	while ($scalerows = mysql_fetch_array($scaleresult)) {
		BudgetDataMaker($scalerows['scmonth'],$total_budget);
		EarnedDataMaker($scalerows['scmonth'],$total_progress);
		ActualDataMaker($scalerows['scmonth'],$total_actual);
	}	

echo "EVA Data is Making Process is complete";

?>
				<a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>
