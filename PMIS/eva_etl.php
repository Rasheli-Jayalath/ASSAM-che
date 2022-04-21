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
mysql_query("truncate table `s009-eva-results`");
include_once "eva_etl_inc.php";
 $tbsql = "SELECT sum(bmonthlycost) as totalBcost FROM `s006-eva-budget`";
 $tbresult = mysql_query($tbsql);
 $tbdata=mysql_fetch_array($tbresult);
 $totalBcost=$tbdata["totalBcost"];
  $bsql = "SELECT * FROM `s006-eva-budget`";
 $bresult = mysql_query($bsql);
while ($bdata = mysql_fetch_array($bresult)) {
	$bcomponent = $bdata['bcomponent'];
	$bmonth = $bdata['bmonth'];
	$bcommulativecost = $bdata['bcommulativecost']+0;
	makeEVAResultData($bcomponent,$bmonth,$bcommulativecost,$totalBcost);
	//echo $bmonth."<br>";
}
?>