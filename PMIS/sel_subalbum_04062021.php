<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Drawing Albums";

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($draw_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$file_path="drawings/";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
?>
<table width="90%" cellspacing="1" cellpadding="1" >
<?php
$subalbum_id= $_REQUEST['subalbum_id'];
$albumid= $_REQUEST['albumid'];
if($subalbum_id!="" && $subalbum_id!=0)
{

?>
<?php 

$tquery = "select * from  t031project_drawingalbums where parent_id = ".$subalbum_id . " order by albumid ASC";
$tresult = mysql_query($tquery);
$mysql_rows=mysql_num_rows($tresult);

if($mysql_rows>0)
{
 $con_albumid=$albumid."_".$subalbum_id;

?>
<tr>
<td width="40%" align="left"><?php echo "Sub Folder";?> 
       </td>
<td width="60%">
<select name="subcatid_<?php echo $subalbum_id; ?>" id="subcatid_<?php echo $subalbum_id; ?>" onchange="subcatlisting(this.value,'<?php echo $con_albumid; ?>',<?php echo $subalbum_id; ?>)" >
<option value="0">Select Sub Category..</option>
<?php

while ($tdata = mysql_fetch_array($tresult)) {
?>
	<option value="<?php echo $tdata['albumid']; ?>" <?php if ($subalbum_id == $tdata['albumid']) {echo ' selected="selected"';} ?>><?php echo $tdata['album_name']; ?></option>
<?php
}
?>
</select>
</td>
</tr>
<?php
}
}
else
{
echo "empty";
}

?>

</table>

