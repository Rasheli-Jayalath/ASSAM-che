<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
/*$uname			= $_SESSION['uname'];*/
$objDb  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
//include("basetable.php");
function mildatamaker($itemid, $rid,$kpimonth) {
   	    $TG=0;
		$TGC=0;
		$AC=0;
		$ACC=0;
	    $var1 = str_replace("-","",$kpimonth); // Date var
	 	$fmonth= date('m',strtotime($kpimonth."-01"));
		$fyear= date('Y',strtotime($kpimonth."-01"));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$kpimonth=$fyear."-".$fmonth."-".$fmonth_days;
		 $var1= $var1.$fmonth_days;
		
	$prmin = "select min(budgetdate) as budgetdate from planned";
	$prminresult = mysql_query($prmin);
	$prmindata = mysql_fetch_array($prminresult);
	$tgminmonth = $prmindata['budgetdate']; // Budget Minimum Month
	
	$prmin = "select min(progressdate) as progressdate from progress";
	$prminresult = mysql_query($prmin);
	$prmindata = mysql_fetch_array($prminresult);
	$acminmonth = $prmindata['progressdate']; // Progress Minimum Month
	
 	 $mildata1 = "SELECT budgetqty as "."TG".$var1." FROM planned WHERE itemid = ".$itemid." and rid=".$rid." AND budgetdate = '".$kpimonth."'";
	$mildataresult = mysql_query($mildata1);
	$mildata = mysql_fetch_array($mildataresult);
	 $TG = $mildata["TG".$var1];
	if($TG=='')
	{
	$TG=0;
	}
	 "<br/>";
	$mildata1 = "SELECT progressqty as "."AC".$var1." FROM progress WHERE itemid = ".$itemid ." and rid=".$rid." AND progressdate = '".$kpimonth."'";
	$mildataresult = mysql_query($mildata1);
	$mildata = mysql_fetch_array($mildataresult);
	$AC = $mildata["AC".$var1];
	if($AC=='')
	{
	$AC=0;
	}
	$mildata1 = "SELECT sum(budgetqty) as "."TGC".$var1." FROM planned WHERE itemid = ".$itemid." and rid=".$rid." AND budgetdate BETWEEN '".$tgminmonth."' AND '".$kpimonth."'";
	$mildataresult = mysql_query($mildata1);
	$mildata = mysql_fetch_array($mildataresult);
	$TGC = $mildata["TGC".$var1];
	if($TGC=='')
	{
	$TGC=0;
	}
	$mildata1 = "SELECT sum(progressqty) as "."ACC".$var1." FROM progress WHERE itemid = ".$itemid." and rid=".$rid." AND progressdate BETWEEN '".$acminmonth."' AND '".$kpimonth."'";
	$mildataresult = mysql_query($mildata1);
	$mildata = mysql_fetch_array($mildataresult);
	$ACC = $mildata["ACC".$var1];
	if($ACC=='')
	{
	$ACC=0;
	}

 mysql_query("update mildata set "."AC".$var1." =".$AC.", "."ACC".$var1." = ".$ACC.", "."TG".$var1." = ".$TG.", "."TGC".$var1." = ".$TGC." where itemid = ".$itemid." and rid=".$rid);
	$res = $AC."-".$ACC."-".$TG."-".$TGC;
	return $res;
}
echo "truncate table mildata";
mysql_query("truncate table mildata");
mysql_query("Insert into mildata (itemid,rid) select itemid,rid from activity");
$sql = "select itemid,rid from mildata ";
$result = mysql_query($sql);
while ($rows = mysql_fetch_array($result)) {
	
	$scalesql = "select scmonth from kpiscale";
	$scaleresult = mysql_query($scalesql);
	
	while ($scalerows = mysql_fetch_array($scaleresult)) {
		mildatamaker($rows['itemid'],$rows['rid'], $scalerows['scmonth']);
	}	
}

echo "Data is Making Process is complete";

?>
				<a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>
