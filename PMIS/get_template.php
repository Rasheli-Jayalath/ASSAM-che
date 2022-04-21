<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	//header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$temp_id		= $_REQUEST['temp_id'];

$objDb  = new Database( );
$objDbb  = new Database( );
@require_once("get_url.php");
if($temp_id!=""&&$temp_id!=0)
{
$btemb="Update baseline_template SET temp_is_default=1 where temp_id=".$temp_id;
			 mysql_query($btemb);
$bt="Update baseline_template SET temp_is_default=0 where temp_id<>".$temp_id;
			  mysql_query($bt);
}
$btem="Select * from baseline_template where temp_is_default=1";
			  $resbtemp=mysql_query($btem);
			  $row3tmpgb=mysql_fetch_array($resbtemp);
			  echo $row3tmpgb["temp_desc"];
?>
