<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$activity		= $_REQUEST['ac_ty'];



$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';
?>
 <select name="txtactivity" onchange="get_subactivity(this.value)">
			   <option value="">Select</option>
			  <?php echo $sqlg="Select * from maindata where stage='Activity' and parentcd=".$activity;
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemid=$row3g['itemid'];
			
			?>
			  <option value="<?php echo $itemid;?>" ><?php echo $row3g['itemname']; ?> </option>
			  <?php
			  }
			  ?>
			  </select>

