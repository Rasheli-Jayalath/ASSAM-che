<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Photos";

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
//===============================================
$file_path="photos/";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
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
$album_id=$_REQUEST['album_id'];
if(isset($_REQUEST['vid']))
{
$vid=$_REQUEST['vid'];
$pdSQL1="SELECT vid, pid,album_id,v_cap, v_al_file  FROM t32project_videos  WHERE pid= ".$pid." and album_id= ".$album_id." and  vid = ".$vid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$v_al_file=$pdData1['v_al_file'];
$v_cap=$pdData1['v_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['vid'])&&isset($_REQUEST['album_id'])&&$_REQUEST['vid']!="")
{
@unlink($file_path.$v_al_file);
 mysql_query("Delete from t32project_videos where vid=".$_REQUEST['vid']." and album_id=".$_REQUEST['album_id']);
 header("Location: sp_video_input.php?album_id=$album_id");
}
/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
   $v_cap=$_REQUEST['v_cap'];
	//$file_name = $_FILES['al_file']['name'];
    $file_type = $_FILES['v_al_file']['type'];
    $file_size = $_FILES['v_al_file']['size'];
	
	if(isset($_FILES["v_al_file"]["name"])&&$_FILES["v_al_file"]["name"]!="")
	{
 $allowed_extensions = array("webm","ogv","mov", "mp4", "3gp", "ogg","avi","mpeg");
 $pattern = implode ($allowed_extensions, "|");
 $extension = pathinfo($_FILES['v_al_file']['name'], PATHINFO_EXTENSION);
	//$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
   
	 if (preg_match("/({$pattern})$/i", $_FILES['v_al_file']['name']) )
        {
            if (($file_type == "video/webm") || ($file_type == "video/mp4") || ($file_type == "video/ogv") || ($file_type == "video/avi")|| ($file_type == "video/mpeg"))
            
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['v_al_file']['tmp_name'],$target_file))
	{
	$sql_pro1="INSERT INTO t32project_videos(pid,album_id,v_cap,v_al_file) Values(".$pid.",".$album_id.", '".$v_cap."', '".$file_name."' )";
	$sql_pro=mysql_query($sql_pro1);
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
	}
	}
	
	
		}
	}
	$v_al_file='';
	
	header("Location: sp_video_input.php?album_id=$album_id");
	
}

if(isset($_REQUEST['update']))
{
$v_cap=$_REQUEST['v_cap'];
$pdSQL = "SELECT a.vid, a.pid,a.album_id, a.v_al_file FROM t32project_videos a WHERE pid = ".$pid." and vid=".$vid." and album_id=".$album_id." order by vid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$vid=$_REQUEST['vid'];
$old_al_file= $pdData["v_al_file"];
		if($old_al_file){
			if(isset($_FILES["v_al_file"]["name"])&&$_FILES["v_al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["v_al_file"]["name"])&&$_FILES["v_al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["v_al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid. ".".$extension;
  
	if(
	($_FILES["v_al_file"]["type"] == "video/webm")|| 
	($_FILES["v_al_file"]["type"] == "video/mp4")|| 
	($_FILES["v_al_file"]["type"] == "video/ogv") || 
	($_FILES["v_al_file"]["type"] == "video/avi")|| 
	($_FILES["v_al_file"]["type"] == "video/mpeg"))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['v_al_file']['tmp_name'],$target_file))
	{
  $sql_pro="UPDATE t32project_videos SET v_cap='$v_cap', v_al_file='$file_name' where vid=$vid and album_id=$album_id";
	
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
	 $sql_pro="UPDATE t32project_videos SET v_cap='$v_cap' where vid=$vid and album_id=$album_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
header("Location: sp_video_input.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<script>
window.onunload = function(){
window.opener.location.reload();
};
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  
 <?php /*?> <link rel="stylesheet" type="text/css" media="all" href="calender/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="calender/calendar.js"></script>
  <script type="text/javascript" src="calender/lang/calendar-en.js"></script>
  <script type="text/javascript" src="calender/calendar-setup.js"></script><?php */?>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>

<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 
<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}

.new_div li {
    list-style: outside none none;
}

.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("./images/frame.png") no-repeat scroll 0 0;
    float: left;
    height: 90px;
    padding: 50px 0 0 6px;
    width: 152px;
	padding-left: 21px !important;
}
.imageTitle {
    color: #464646;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: normal;
}
.ms-WPBody a:link {
    color: #0072bc;
    text-decoration: none;
}
/*div a {
    color: #767676 !important;
    font-family: arial;
    font-size: 12px;
    line-height: 17px;
    text-decoration: none !important;
}*/
img {
    border: medium none;
}
</style>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	/*if(frm.desg_id.value != ""){
		qString += '&desg_id=' + frm.desg_id.value;
	}
	if(frm.emp_type.value != ""){
		qString += '&emp_type=' + frm.emp_type.value;
	}
	if(frm.smec_egc.value != ""){
		qString += '&smec_egc=' + frm.smec_egc.value;
	}*/
	document.location = 'analysis.php?' + qString;
}
</script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
function getDates(lid)
{
	
	if (lid!=0) {
			var strURL="finddate.php?lid="+lid;
			var req = getXMLHTTP();
			
			if (req) {
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("location_div").innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP COM:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 

}
</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
   <link href="css/style.css" rel="stylesheet" /> 
<div id="content">
<table align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Manage Videos</span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
   <div id="LoginBox" class="borderRound borderShadow" >
  <form action="sp_video_input.php?album_id=<?php echo $album_id; ?>" target="_self" method="post"  enctype="multipart/form-data">
 <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo "Video Caption:";?></label></td>
  <td><input type="text" name="v_cap" id="v_cap" value="<?php echo $v_cap;?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo "Video:";?></label></td>
  <td><input  type="file" name="v_al_file" id="v_al_file" value="<?php echo $v_al_file; ?>" /></td>
  </tr>
  <tr><td colspan="2" align="center"> <?php if(isset($_REQUEST['vid']))
	 {
		 
	 ?>
     <input type="hidden" name="vid" id="vid" value="<?php echo $_REQUEST['vid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" onClick="window.close()"/></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
  <table width="100%">
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
 <table class="reference" style="width:100%" > 
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="40%" style="text-align:center">Caption</th>
                                  <th width="25%" style="text-align:center">Video</th>
								
								  <?php if($picentry_flag==1 || $picadm_flag==1)
								  {
								   ?>
								  <th width="20%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						 $pdSQL = "SELECT vid, pid,album_id,v_cap, v_al_file  FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
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
                          <td align="center"><?php echo $pdData['v_cap'];?></td>
                          <td align="left">  <img src="./images/video_file_icon.jpg"  width="50" height="50"/></td>
                       
						 
						   <td align="right">
						    <?php if($picentry_flag==1 || $picadm_flag==1)
								  {
								   ?>
						   <span style="float:left"><form action="sp_video_input.php?vid=<?php echo $pdData['vid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   <?php  
							}
							if($picadm_flag==1)
								  {
								   ?>
						   <span style="float:right"><form action="sp_video_input.php?vid=<?php echo $pdData['vid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>
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
</div>
 
