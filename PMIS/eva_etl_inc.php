<?php
function makeEVAResultData($bcomponent,$bmonth,$bcommulativecost,$totalBcost)
{
	$BAC=$totalBcost;
 $equery ="select * from `s007-eva-earned`  where ecomponent =".$bcomponent." and emonth='".$bmonth."' ";
$eresult = mysql_query($equery);
$ecommulativecost = 0;
if (!$eresult) {
    die('Invalid query1: ' . mysql_error());
} else {
		$edata = mysql_fetch_array($eresult);
		$ecommulativecost = $edata['ecommulativecost']+0;
		
}
//// end EV
$aquery ="select * from `s008-eva-actual`  where acomponent =".$bcomponent." and amonth = '".$bmonth."' ";
$aresult = mysql_query($aquery);
$acommulativecost = 0;
if (!$aresult) {
    die('Invalid query2: ' . mysql_error());
} else {
		$adata = mysql_fetch_array($aresult);
		$acommulativecost = $adata['acommulativecost']+0;
		
}
//// end AC
////////////// Start Formulas
$CV=0;
$SV=0;
$CPI=0;
$SPI=0;
$EAC_1=0;
$EAC_2=0;
$EAC_3=0;
$CPI_SPI=0;
$ETC_1=0;
$ETC_2=0;
$ETC_3=0;
$TCPI_1=0;
$TCPI_2_1=0;
$TCPI_2_2=0;
$TCPI_2_3=0;
$BAC_AC=0;
$BAC_EV=0;
$CV=$ecommulativecost-$acommulativecost;
$SV=$ecommulativecost-$bcommulativecost;
if($ecommulativecost!=0 && $ecommulativecost!="" && $acommulativecost!=0 && $acommulativecost!="")
{
	
 $CPI=$acommulativecost/$ecommulativecost;
}
else
{
$CPI=0;
}
if($bcommulativecost!=0 && $bcommulativecost!="")
{
	 $SPI=$ecommulativecost/$bcommulativecost;
}
else
{
	$SPI=0;
}
if($CPI!=0 && $CPI!="")
{
$EAC_1=$BAC/$CPI;
}
else
{
$EAC_1=0;
}
$EAC_2=$acommulativecost+($BAC-$ecommulativecost);
$CPI_SPI=$CPI*$SPI;
if($CPI_SPI!=0&&$CPI_SPI!="")
{
$EAC_3=$EAC_2/$CPI_SPI;
}
else
{
$EAC_3=0;
}
$ETC_1=$EAC_1-$acommulativecost;
$ETC_2=$EAC_2-$acommulativecost;
$ETC_3=$EAC_3-$acommulativecost;
$BAC_AC=$BAC-$acommulativecost;
$BAC_EV=$BAC-$ecommulativecost;
if($BAC_AC!=0&&$BAC_AC!="")
{
$TCPI_1=$BAC_EV/$BAC_AC;
}
else
{
	$TCPI_1=0;
}
if($ETC_1!=0&&$ETC_1!="")
{
$TCPI_2_1=$BAC_EV/$ETC_1;
}
else
{
	$TCPI_2_1=0;
}
if($ETC_2!=0&&$ETC_2!="")
{
$TCPI_2_2=$BAC_EV/$ETC_2;
}
else
{
	$TCPI_2_2=0;
}
if($ETC_3!=0&&$ETC_3!="")
{
$TCPI_2_3=$BAC_EV/$ETC_3;
}
else
{
	$TCPI_2_3=0;
}
////////////End Formulas
$sql="insert into `s009-eva-results` (rcomponent, rmonth,cv,sv,cpi,spi,bac,eac1,eac2,eac3,etc1,etc2,etc3,tcpi1,tcpi2_1,tcpi2_2,tcpi2_3) values (".$bcomponent.", '".$bmonth."', '".$CV."', '".$SV."', '".$CPI."', '".$SPI."', '".$BAC."', '".$EAC_1."', '".$EAC_2."', '".$EAC_3."', '".$ETC_1."', '".$ETC_2."', '".$ETC_3."', '".$TCPI_1."', '".$TCPI_2_1."', '".$TCPI_2_2."', '".$TCPI_2_3."')";
	 mysql_query($sql);
	
	return;
}



?>