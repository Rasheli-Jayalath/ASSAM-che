<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
//$uname = $_SESSION['uname'];
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$stg_goal		= $_REQUEST['stg_goal'];



$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';
?>
 <select name="txtoutcomes">
			   <option value="">Select</option>
			  <?php echo $sqlg="Select * from maindata where stage='Outcome' and parentcd=".$stg_goal;
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

