<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  		= new Database( );
$objDb1  		= new Database( );
//$uname			= $_SESSION['uname'];
if ($uname==null  ) {
header("Location: index.php?init=3");
}
@require_once("get_url.php");

$eSqls = "Select * from progress ";
  $objDb -> query($eSqls);
  
	$iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		
		$progressdate	= $objDb->getField($i,progressdate);
		$pgid	= $objDb->getField($i,pgid);
		$fyear=date('Y',strtotime($progressdate));
		$fmonth=date('m',strtotime($progressdate));
		$days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$progressdate=$fyear."-".$fmonth."-".$days;

echo  $bSQL = ("UPDATE progress SET progressdate='".$progressdate."' WHERE pgid=".$pgid);
echo "<br/>";
	$objDb1->execute($bSQL);
	}
 }
 
 
 

	$objDb1  -> close( );
echo "Progress Date Data Making Process is complete";
 ?>
 <a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>