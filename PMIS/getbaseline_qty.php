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
$boq_id		= $_REQUEST['boq_id'];
$type		= $_REQUEST['type'];

$objDb  = new Database( );
$objDbb  = new Database( );
@require_once("get_url.php");

  if($type=="All")
  {
$bSql = "Select * from `boq` where boqid=$boq_id"; 
	$sqlresultb = mysql_query($bSql); 
	$boq_rowsb = mysql_fetch_array($sqlresultb);
	 if($boq_rowsb["boq_cur_1"]!="")
		 {
		 $boq_amountb=$boq_rowsb["cur_1_exchrate"]*$boq_rowsb["boq_cur_1_rate"]*$boq_rowsb["boqqty"];
		 }
		  if($boq_rowsb["boq_cur_2"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_2_exchrate"]*$boq_rowsb["boq_cur_2_rate"]*$boq_rowsb["boqqty"];
		 }
		  if($boq_rowsb["boq_cur_3"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_3_exchrate"]*$boq_rowsb["boq_cur_3_rate"]*$boq_rowsb["boqqty"];
		 }
		 $boqqty=$boq_amountb;
  }
  else
  {
	 $eSql = "Select * from boq where boqid='$boq_id'";
  $objDbb -> query($eSql);
  $eCount = $objDbb->getCount();
  $boqqty = $objDbb->getField(0,boqqty);
  }
?>
 <input type="text"  name="txtquantity" id="txtquantity" value="<?php echo $boqqty; ?>" />

