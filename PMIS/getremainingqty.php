<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$objDb  = new Database( );
$rid 				= $_REQUEST['rid'];

$sqlg="Select * from baseline";
			$resg=mysql_query($sqlg);
			while($abc=mysql_fetch_array($resg))
			{
				if($abc['rid']==$rid)
			{
			
			$sqlg3="Select sum(baseline) as used_qt from activity where rid=".$abc['rid'];
			$resg3=mysql_query($sqlg3);
			
			$abc3=mysql_fetch_array($resg3);
			$used_qty=$abc3['used_qt'];
			//$used_qty=0;
			$remaining_qtyy=$abc['quantity']-$used_qty;
			}
			}
			echo $remaining_qtyy;

?>
