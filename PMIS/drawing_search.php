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
<?php


	$albumid = $_REQUEST['albumid'];
	 $last_subalbum = $_REQUEST['last_subalbum'];

	
	$sSQL_p = "SELECT parent_group FROM t031project_drawingalbums WHERE albumid=".$last_subalbum;
	$sSQL_p1=mysql_query($sSQL_p);
	$sSQL_p2=mysql_fetch_array($sSQL_p1);
	$parent_group_p=$sSQL_p2['parent_group'];
	
	
	

//$category = $_REQUEST['category'];
$dwg_type = $_REQUEST['dwg_type'];
$dwg_no = $_REQUEST['dwg_no'];
$dwg_title = $_REQUEST['dwg_title'];
$dwg_date = $_REQUEST['dwg_date'];
$revision_no = $_REQUEST['revision_no'];
$dwg_status = $_REQUEST['dwg_status'];


$now = new DateTime();
$nowyear = $now->format("Y");


$sCondition = '';

if($dwg_no!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (dwg_no LIKE '%".$dwg_no."%')";
	}
	else
	{
	$sCondition=" (dwg_no LIKE '%".$dwg_no."%')";
	}
//	echo $sCondition;
}
if($dwg_type!="All")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (dwg_type LIKE '%".$dwg_type."%')";
	}
	else
	{
	$sCondition=" (dwg_type LIKE '%".$dwg_type."%')";
	}
//	echo $sCondition;
}
if($dwg_title!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (dwg_title LIKE '%".$dwg_title."%')";
	}
	else
	{
	$sCondition=" (dwg_title LIKE '%".$dwg_title."%')";
	}
//	echo $sCondition;
}

if($revision_no!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (revision_no LIKE '%".$revision_no."%')";
	}
	else
	{
	$sCondition=" (revision_no LIKE '%".$revision_no."%')";
	}
//	echo $sCondition;
}
if($dwg_status!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (dwg_status LIKE '%".$dwg_status."%')";
	}
	else
	{
	$sCondition=" (dwg_status LIKE '%".$dwg_status."%')";
	}
//	echo $sCondition;
}

$orderby = " order by dwgid asc";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Interactive Search</title>
<link rel="stylesheet" type="text/css" href="css/style.css">

<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('cvcheck[]');
  for each(var checkbox in checkboxes)
    checkbox.checked = source.checked;
}
</script>


</head>

<body>

<?php 
if($dwg_no=="" && $dwg_type=="All" && $dwg_title==""&& $dwg_date=="" && $revision_no==""&& $dwg_status=="")
{
}
else
{
$sSQL1 = "SELECT * FROM t027project_drawings WHERE ".$sCondition.$orderby;
$sSQL12=mysql_query($sSQL1);
$iCount = mysql_num_rows($sSQL12);
if($iCount>0)
{
?>
<form action="" method="post"  name="report_cat" id="report_cat" >
 
   
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
	  <th align="center" width="10%"><strong>Title</strong></th>
	   <th align="center" width="15%"><strong>Drawing_no</strong></th>
	  <th align="center" width="10%"><strong>Revision No.</strong></th>
      <th align="center" width="5%"><strong>Status</strong></th>
	  
    </tr>
  


<?php

$i=0;
	while($sSQL3=mysql_fetch_array($sSQL12))
	{
		$album_id 			= $sSQL3['album_id'];
		$dwgid 					= $sSQL3['dwgid'];
		$dwg_no  				= $sSQL3['dwg_no'];
		$dwg_title  			= $sSQL3['dwg_title'];
		$al_file  				= $sSQL3['al_file'];
		$revision_no  				= $sSQL3['revision_no'];
		$dwg_status  				= $sSQL3['dwg_status'];
		
		
			if($last_subcat==0 || $last_subcat=="")
	{
		
		
$tquery1 = "select * from  t031project_drawingalbums where albumid = ".$album_id . " order by albumid ASC";
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
	 $tquery = "select albumid from  t031project_drawingalbums where ".$c_id1." order by albumid ASC";
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
	if($mysql_rows>0 )
	{
	$tdata = mysql_fetch_array($tresult);
	$album_id=$tdata['albumid'];
	$sSQL2 = "SELECT * FROM t031project_drawingalbums WHERE albumid=".$album_id." and INSTR(parent_group, '$parent_group_p')>0";
	$sSQL13=mysql_query($sSQL2);
	$sSQL4=mysql_fetch_array($sSQL13);
	$album_name=$sSQL4['album_name'];
	if(mysql_num_rows($sSQL13)>=1)	
		{
				
			 		?>
	
		<tr <?php echo $style; ?>>
		<td ><?=$i=$i+1;?></td>
		
<td ><a href="./drawings/<?php echo $al_file;?>" target="_blank"><?=$dwg_title;?></a></td>
<td ><?=$dwg_no;?></td>
<td ><?=$revision_no;?></td>
<td ><?
if($sSQL3['dwg_status']=='1')
					{
					echo "Initiated";
					} 
					else if($sSQL3['dwg_status']=='2')
					{
					echo "Approved";
					}
					else if($sSQL3['dwg_status']=='3')
					{
					echo  "Not Approved";
					}
					else if($sSQL3['dwg_status']=='4')
					{
					echo "Under Review";
					}
					else if($sSQL3['dwg_status']=='5')
					{
					echo "Response Awaited";
					}
					else if($sSQL3['dwg_status']=='7')
					{
					echo "Responded";
					}?></td>

</tr>
<?php
		
	
	}
	}
	else if($_SESSION['ne_user_type']==1)
	{
	$album_id 			= $sSQL3['album_id'];
	$sSQL2 = "SELECT * FROM t031project_drawingalbums WHERE albumid=".$album_id." and INSTR(parent_group, '$parent_group_p')>0";
	$sSQL13=mysql_query($sSQL2);
	$sSQL4=mysql_fetch_array($sSQL13);
	$album_name=$sSQL4['album_name'];
	if(mysql_num_rows($sSQL13)>=1)	
		{
					
			 		?>
	
		<tr <?php echo $style; ?>>
		<td ><?=$i=$i+1;?></td>
		
<td ><a href="./drawings/<?php echo $al_file;?>" target="_blank"><?=$dwg_title;?></a></td>
<td ><?=$dwg_no;?></td>
<td ><?=$revision_no;?></td>
<td ><?
if($sSQL3['dwg_status']=='1')
					{
					echo "Initiated";
					} 
					else if($sSQL3['dwg_status']=='2')
					{
					echo "Approved";
					}
					else if($sSQL3['dwg_status']=='3')
					{
					echo  "Not Approved";
					}
					else if($sSQL3['dwg_status']=='4')
					{
					echo "Under Review";
					}
					else if($sSQL3['dwg_status']=='5')
					{
					echo "Response Awaited";
					}
					else if($sSQL3['dwg_status']=='7')
					{
					echo "Responded";
					}?></td>

</tr>
<?php
		
	
	}
	}
	
	
		

	}
?>
</table>
</form>

<?php
} else { echo "<br />","<center> No Report Found..... </center> <br /><br />"; }
}
?>

</td> 

</body>
</html> 
  
