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

$btem="Select * from baseline_template where temp_id=$temp_id";
			  $resbtemp=mysql_query($btem);
			  $row3tmpgb=mysql_fetch_array($resbtemp);
			 if($row3tmpgb["use_data"]==1 || $row3tmpgb["use_data"]==2)
			 {
?>
<input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($status=="1"){ echo "checked='checked'";} else if($status==""){ echo "checked='checked'";} ?>/>IPC
			  <input type="radio"  id="txtstatus" name="txtstatus" value="2" <?php if($status=="2"){ echo "checked='checked'";} ?>/>Custom
              <?php }
			  else{?>
			 <input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($status=="1"){ echo "checked='checked'";} else if($status==""){ echo "checked='checked'";} ?> disabled="disabled"/>IPC
			  <input type="radio"  id="txtstatus" name="txtstatus" value="2" checked="checked"/>Custom
              <?php }?>