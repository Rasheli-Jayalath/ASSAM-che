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

$objDb  = new Database( );
$objDbb  = new Database( );
@require_once("get_url.php");
 $eSql = "Select * from boq where boqid='$boq_id'";
  $objDbb -> query($eSql);
  $eCount = $objDbb->getCount();
  $boqitem = $objDbb->getField(0,boqitem);
?>
<input type="text"  name="txtresource" id="txtresource" value="<?php echo $boqitem; ?>" /> 

