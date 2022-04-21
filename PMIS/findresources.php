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
$isentry		= $_REQUEST['isentry'];



$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';
?>


 <select name="res[]" id="s4a"  class="s4a" multiple="multiple" >
			   
			  <?php echo $sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$rid=$row3g['rid'];
			
			?>
			  <option value="<?php echo $rid;?>" ><?php echo $row3g['resource']; ?> </option>
			  <?php
			  }
			  ?>
			  </select>

