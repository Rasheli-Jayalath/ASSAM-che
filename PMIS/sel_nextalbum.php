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
$user_cd=$uid;
@require_once("get_url.php");
$file_path="drawings/";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
?>
<table width="90%"  cellspacing="1" cellpadding="1" >
<?php 

$album_id = intval($_GET['album_id']);
if($album_id!="")
{
	if($_SESSION['ne_user_type']==1)
	{
	
	
	 $tquery = "select * from  t031project_drawingalbums where parent_id = ".$album_id . " order by albumid ASC";
	 $tresult = mysql_query($tquery);
	 $mysql_rows=mysql_num_rows($tresult);
	}
	else
	{
		
$tquery1 = "select * from  t031project_drawingalbums where parent_id = ".$album_id . " order by albumid ASC";
$tresult1 = mysql_query($tquery1);
$c_id1="";
$g=0;
while($cddata2=mysql_fetch_array($tresult1))
{
$catt_cdd=$cddata2['albumid'];
$arr_rst1=explode(",",$cddata2['user_ids']);
$len_rst21=count($arr_rst1);

for($ri1=0; $ri1<$len_rst21; $ri1++)
{ 

if($arr_rst1[$ri1]==$user_cd)
{
$g=$g+1;
	if($g==1)
	{ 
	$c_id1="albumid=".$catt_cdd ;
	}
	else
	{
	
	$c_id1.=" OR albumid=".$catt_cdd ;
	}

}

}
//$g=$g+1;

}	

	if($c_id1!="")
	{
	$tquery = "select * from  t031project_drawingalbums where ".$c_id1." order by albumid ASC";
	$tresult = mysql_query($tquery);
	$mysql_rows=mysql_num_rows($tresult);
	}
	else
	{
	$mysql_rows=0;
	?>
	
	<?php 
	}

	}


if($mysql_rows>0)
{


?>


<tr>
<td width="40%" align="left"><?php echo "Sub Folder";?> 
       </td>
<td width="60%">
<select name="subcatid_<?php echo $album_id; ?>" id="subcatid_<?php echo $album_id; ?>"  onchange="subcatlisting(this.value,'<?php echo $album_id?>',<?php echo $album_id; ?>)">
<option value="0">Select Sub Album..</option>
<?php

while ($tdata = mysql_fetch_array($tresult)) {

?>
<option value="<?php echo $tdata['albumid']; ?>"><?php echo $tdata['album_name']; ?></option>
<?php

}
?>
</select>
</td>
</tr>
<?php

}

?>

<?php

}
?>
</table>