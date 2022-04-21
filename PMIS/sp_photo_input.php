<?php
session_name(PNAME);
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
$adminflag=$_SESSION['adminflag'];
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}
$adminflag=$_SESSION['adminflag'];
include_once("connect.php");
include_once("functions.php");
//===============================================
$file_path="dashboard_data/";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
}
if(isset($_REQUEST['phid']))
{
$phid=$_REQUEST['phid'];
$pdSQL1="SELECT phid, pid, al_file, ph_cap FROM  project_photos  WHERE pid= ".$pid." and  phid = ".$phid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$al_file=$pdData1['al_file'];
$ph_cap=$pdData1['ph_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['phid'])&$_REQUEST['phid']!="")
{
@unlink($al_file.$al_file);
 mysql_query("Delete from  project_photos where phid=".$_REQUEST['phid']);
 header("Location: sp_photo_input.php");
}
$size=50;
$max_size=($size * 1024 * 1024);
if(isset($_REQUEST['save']))
{ 
    $ph_cap=$_REQUEST['ph_cap'];
	//echo $name_array = $_FILES['al_file']['name'];
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| ($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png")&&($_FILES["al_file"]["size"] < $max_size))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	$sql_pro=mysql_query("INSERT INTO  project_photos(pid, al_file,ph_cap) Values(".$pid.", '".$file_name."', '".$ph_cap."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
	}
	}
	}
	$al_file='';
	
	header("Location: sp_photo_input.php");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=$_REQUEST['ph_cap'];
$pdSQL = "SELECT a.phid, a.pid, a.al_file FROM  project_photos a WHERE pid = ".$pid." and phid=".$phid." order by phid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid. ".".$extension;
  
	if(
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png")&&($_FILES["al_file"]["size"] < $max_size))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
    $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap', al_file='$file_name' where phid=$phid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
	 $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap' where phid=$phid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
header("Location: sp_photo_input.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tarbela 4th Extension  Hydropower Project</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
<img src="nha1.jpg" alt="nha logo" width="68.12"  height="60.98" style="position:absolute; top: 0px; left: 20px;"  />
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
<img src="nha2.jpg" alt="nha logo" width="104.64" style="position:absolute; top: 20px; right: 20px;" />
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Photos/Videos</span><span style="float:right">
    <form action="sp_photo.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_photo_input.php" target="_self" method="post"  enctype="multipart/form-data">
  <table border="1" width="100%" height="100%">
  <tr><td><label><?php echo "Photo/Video Caption:";?></label></td>
  <td><input type="text" name="ph_cap" id="ph_cap" value="<?php echo $ph_cap;?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo "Photo:";?></label></td>
  <td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
  <tr><td colspan="2"> <?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	
  </form> 
  </td></tr>
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="40%" style="text-align:center">Caption</th>
                                  <th width="45%" style="text-align:center">Photo</th>
								
								  <?php if($adminflag==1)
								  {
								   ?>
								  <th width="10%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						 $pdSQL = "SELECT phid, pid, al_file, ph_cap FROM  project_photos WHERE pid = ".$pid." order by phid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['ph_cap'];?></td>
                          <td align="left">  <img src="<?php echo $file_path.$pdData["al_file"];?>"  width="50" height="50"/></td>
                       
						  <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_photo_input.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_photo_input.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>
						   <?php
						   }
						   ?></td>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                        </div>
                        </td>
                        </tr>
  </table>
  </figure>
</div>
</body>
</html>
