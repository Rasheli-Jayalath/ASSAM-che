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
$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';
?>
<select id="canal_name" name="canal_name" onchange="getDates(this.value,<?php echo $lid;?>)" style="width:242px">
     <option value="0">Select Sub Component</option>
  		<?php $pdSQLd = "SELECT lcid,title FROM  locations_component  WHERE  lid=".$lid." order by title ASC";
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["lcid"];?>"><?php echo $pdDatad["title"];?></option>
   <?php } 
   }?>
  </select>
  

