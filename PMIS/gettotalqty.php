<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$rid 				= $_REQUEST['rid'];
$objDb  = new Database( );
$sqlg="Select * from baseline where rid=$rid";
			$resg=mysql_query($sqlg);
			$abc=mysql_fetch_array($resg);
			echo $abc['quantity'];

?>
