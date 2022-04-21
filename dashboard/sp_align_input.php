<?php
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}
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
	$size=50;
$max_size=($size * 1024 * 1024);
if(isset($_REQUEST['save']))
{ 
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
		echo "INSERT INTO t006alignment (pid, al_file) Values(".$pid.",".$file_name.")";
$sql_pro=mysql_query("INSERT INTO t006alignment (pid, al_file) Values(".$pid.", '".$file_name."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	}
	}
	}
	$al_file='';
	
	header("Location: sp_align.php");
	
}

if(isset($_REQUEST['update']))
{
$pdSQL = "SELECT a.alid, a.pid, a.al_file FROM t006alignment a WHERE pid = ".$pid." order by alid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
 $pdData = mysql_fetch_array($pdSQLResult);
 
	$alid=$_REQUEST['alid'];
	 
	echo $old_al_file= $pdData["al_file"];;
		if($old_al_file){
				@unlink($file_path . $old_al_file);
					
				}
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
echo $sql_pro="UPDATE t006alignment SET al_file='$file_name' where alid=$alid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	}
	}}
			
header("Location: sp_align.php");
}
if(isset($_REQUEST['alid']))
{
$alid=$_REQUEST['alid'];

$pdSQL1="SELECT alid, pid, al_file FROM t006alignment  WHERE pid= ".$pid." and  alid = ".$alid;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$al_file=$pdData1['al_file'];
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
 
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
 
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Alignment Plan/ Camps</span><span style="float:right">
    <form action="sp_align.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_align_input.php" target="_self" method="post"  enctype="multipart/form-data">
  <table border="1" width="100%" height="100%">
  <tr><td><label>Alignment:</label></td><td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td></tr>
  <tr><td colspan="2"> <?php if(isset($_REQUEST['alid']))
	 {
		 
	 ?>
     <input type="hidden" name="alid" id="alid" value="<?php echo $_REQUEST['alid']; ?>" />
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
  
  </table>
  </figure>
</div>
</body>
</html>
