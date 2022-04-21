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
$temp_is_default	= $_REQUEST['temp_is_default'];

$objDb  = new Database( );
$objDbb  = new Database( );
@require_once("get_url.php");
$btemp="Select * from `baseline_template` where temp_is_default=$temp_is_default";
			$resbtemp=mysql_query($btemp);
			while($row3tmpg=mysql_fetch_array($resbtemp))
			{?>
             <input type="checkbox" name="temp_id" class="check-field" id="temp<?php echo $row3tmpg['temp_id']; ?>" 
             value="<?php echo $row3tmpg['temp_id']; ?>" <?php if($row3tmpg['temp_is_default']==1){?> checked="checked" <?php }?>  
             onchange="GetDefaultTemplate(this.value)" ><?php echo $row3tmpg['temp_title']; ?><br/>
              <?php }?>