<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  		= new Database( );
$objDb1  		= new Database( );
@require_once("get_url.php");


$bSqls = "Select * from planned ";
  $objDb -> query($bSqls);
  
	$iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		
		$plid 	= $objDb->getField($i,plid);
		$budgetdate 	= $objDb->getField($i,budgetdate);
		$fmonth= date('m',strtotime($budgetdate));
		$fyear= date('Y',strtotime($budgetdate));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$budgetdate =$fyear."-".$fmonth."-".$fmonth_days;


 
echo  $bSQL = ("UPDATE planned SET budgetdate='".$budgetdate."' WHERE plid=".$plid);
	$objDb1->execute($bSQL);
	}
 }
	$objDb  -> close( );
	$objDb1  -> close( );
?>
