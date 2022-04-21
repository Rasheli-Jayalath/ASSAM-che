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
$lid		= $_REQUEST['lid'];
$lcid		= $_REQUEST['lcid'];
$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';
?>
<select id="date_p" name="date_p"  style="width:120px">
     <option value="0">Date 1</option>
  		<?php $pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE  ph_cap=".$lid." and lcid=".$lcid." order by date_p  ASC";
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["date_p"];?>" <?php if($date_p==$pdDatad["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatad["date_p"]));?></option>
   <?php } 
   }?>
  </select>
  <select id="date_p2" name="date_p2"  style="width:120px">
     <option value="0">Date 2</option>
  		<?php $pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE  ph_cap=".$lid." and lcid=".$lcid." order by date_p  ASC";
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["date_p"];?>" <?php if($date_p==$pdDatad["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatad["date_p"]));?></option>
   <?php } 
   }?>
  </select>

