<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
header("Content-Type: text/html; charset=utf-8");
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
$file_path="photos/";
$file_thumb_path="photos/thumb/";
$user_cd=$uid;
$log_id = $_SESSION['log_id'];
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
//===============================================

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
 $pdSQL_get_right1 = "SELECT parent_group FROM  t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$album_id;
			                $pdSQLResult_get_right1 = mysql_query($pdSQL_get_right1);
			                $result_get_right1 = mysql_fetch_array($pdSQLResult_get_right1); 
							$p_group=$result_get_right1['parent_group'];
				$arr_gp=explode("_", $p_group);
				$group_count=count($arr_gp);
				if($group_count>1)
				{
				$get_album_id=$arr_gp[1];
				$pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $pdSQLResult_get_right = mysql_query($pdSQL_get_right);
			 $result_get_right = mysql_fetch_array($pdSQLResult_get_right);
				}
if(isset($_REQUEST['phid']))
{
$phid=$_REQUEST['phid'];
$pdSQL1="SELECT phid, pid, album_id, al_file, ph_cap FROM t027project_photos  WHERE pid= ".$pid." and album_id= ".$album_id." and  phid = ".$phid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$al_file=$pdData1['al_file'];
$ph_cap=$pdData1['ph_cap'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['phid'])&&isset($_REQUEST['album_id'])&&$_REQUEST['phid']!="")
{
@unlink($file_path.$al_file);
@unlink($file_thumb_path.$al_file);
 mysql_query("Delete from t027project_photos where phid=".$_REQUEST['phid']." and album_id=".$_REQUEST['album_id']);
 $activity="Album id(".$_REQUEST['album_id'].") photo id(".$_REQUEST['phid'].") - Photo Deleted Successfully";
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
 header("Location:sp_photo_album_input.php?album_id=$album_id");
}
/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
    
	
	$ph_cap=$_REQUEST['ph_cap'];
	
	
		
		
	    //Loop through each file
        for($i=0; $i<count($_FILES['al_file']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['al_file']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
              $shortname1 = $_FILES['al_file']['name'][$i];
			
				$ext = pathinfo($shortname1, PATHINFO_EXTENSION);
				$array_sname=explode(".",$shortname1);
				if(count($_FILES['al_file']['name'])==1 && $ph_cap!='')
				{
				$report_title=$ph_cap;
				}
				else
				{
				$report_title= mysql_real_escape_string(trim($array_sname[0]));
				}
				$report_title_1=$array_sname[0];
				
		
		
				$file_name=genRandom(5)."-".$album_id.".".$ext;
               
			 	$target_file=$file_path.$file_name;
			
              

                
                if(move_uploaded_file($tmpFilePath, $target_file)) {
				
	
		///create thumbnail
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($target_file);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($target_file);
                    break;

                case 'png':
                    $source = imagecreatefrompng($target_file);
                    break;
			
                case 'gif':
                    $source = imagecreatefromgif($target_file);
                    break;
                default:
                    $source = imagecreatefromjpeg($target_file);
            }

            imagecopyresampled($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail);
            }

	}
	//// End thumbnails
	
	$sql_query="INSERT INTO t027project_photos(pid, album_id, al_file, original_file_name,ph_cap) Values(".$pid.",".$album_id.", '".$file_name."', '".$shortname1."', '".$report_title."' )";
	$sql_pro=mysql_query($sql_query);
	$insert_id=mysql_insert_id();
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=$album_id."-".$insert_id." - New photo record added successfully";
	} else {
    $message= mysql_error($db);
	 $activity= mysql_error($db);
	}
	
	
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	}
				
              }
			
        }
	
	
	//header("Location: sp_photo_album_input.php?album_id=$album_id");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=$_REQUEST['ph_cap'];
$pdSQL = "SELECT a.phid, a.pid, a.album_id, a.al_file FROM t027project_photos a WHERE pid = ".$pid." and album_id=".$album_id." and phid=".$phid." order by phid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path . $old_al_file);
				@unlink($file_thumb_path . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
            
                //save the filename
				$tmpFilePath = $_FILES['al_file']['tmp_name'];
                $shortname1 = $_FILES['al_file']['name'];
				$ext = pathinfo($shortname1, PATHINFO_EXTENSION);
				$array_sname=explode(".",$shortname1);
				if(count($_FILES['al_file']['name'])==1 && $ph_cap!='')
				{
				$report_title=$ph_cap;
				}
				else
				{
				$report_title= mysql_real_escape_string(trim($array_sname[0]));
				}
				$report_title_1=preg_replace("/[^a-zA-Z0-9.]/", "", $array_sname[0]);
				$shortname=$shortname1.$ext;
				
				
		
		
				$file_name=genRandom(5)."-".$album_id.".".$ext;
                //save the url and the file
				$target_file=$file_path.$file_name;
              //  $filePath = $report_path."/".$filename;

                
                if(move_uploaded_file($tmpFilePath, $target_file)) {
	
		///create thumbnail
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($target_file);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($target_file);
                    break;

                case 'png':
                    $source = imagecreatefrompng($target_file);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($target_file);
                    break;
                default:
                    $source = imagecreatefromjpeg($target_file);
            }

            imagecopyresampled($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail);
            }

	}
	//// End thumbnails
	 $sql_pro="UPDATE t027project_photos SET ph_cap='$report_title', al_file='$file_name' where phid=$phid and album_id=$album_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $album_id."-".$phid." - Photo Record updated successfully";
	} else {
		$message= mysql_error($db);
		$activity= mysql_error($db);
	}
	
	
	}
	
  
	
	}
	else
	{
	 $sql_pro="UPDATE t027project_photos SET ph_cap='$ph_cap' where phid=$phid and album_id=$album_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $album_id."-".$phid." - Photo Record updated successfully";
	} else {
		$message= mysql_error($db);
		$activity= mysql_error($db);
	}
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
header("Location: sp_photo_album_input.php?album_id=$album_id");
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
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
<?php include ('includes/metatag.php'); ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
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
function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
function required(){
	
		
	var x = document.forms["form2"]["ph_cap"].value;
		var uploadPhoto = document.forms["form2"]["al_file"].value;
		var uploadPhoto_old = document.forms["form2"]["old_al_file"].value;
	
  if (x == "") {
    alert("Caption must be filled out");
    return false;
  }
   if (uploadPhoto == "" && uploadPhoto_old=="") {
    alert("Photo must be uploaded first");
    return false;
  }
	
	
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
   </head>
   <body>
<div id="content">
<table  align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Manage Photos</span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
   <div id="LoginBox" class="borderRound borderShadow" >
  <form name="form2" action="sp_photo_album_input.php?album_id=<?php echo $album_id; ?>" target="_self" method="post"  enctype="multipart/form-data" onSubmit="return required()">
    <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo "Photo Caption:";?></label></td>
  <td><input type="text" name="ph_cap" id="ph_cap" value="<?php echo $ph_cap;?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo "Photo(s):";?></label></td>
  <td><?php if(isset($_GET['phid']))
		{
		?>
        <input  type="file" name="al_file" id="al_file"  />
        <input type="hidden" name="old_al_file" value="<?php echo $pdData1['al_file'];?>" />
	
		<?php
		}
		else
		{?>
         <input  type="file" name="al_file[]" id="al_file" multiple="multiple" /><div id="selectedFiles"></div>
     
		 <input type="hidden" name="old_al_file" value="" />
		<?php }	?></td>
  </tr>
  <tr><td><label></label></td>
  <td>
       <strong>Note:</strong>  max_file_uploads=20 <br />upload_max_filesize=1028M
    	</td>
  </tr>
  <tr><td colspan="2" align="center"> <?php if(isset($_REQUEST['phid']))
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
	 ?> 
     <input  type="button" name="cancel" id="cancel" value="Cancel"   onclick="cancelButton();"/>
     
     </td></tr>
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
                                  <th width="20%" style="text-align:center">Photo</th>
								
								  
								  <th width="25%" style="text-align:center">Action</th>
								 
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						 $pdSQL = "SELECT phid, pid,album_id, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
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
                          <td align="left">  <img src="<?php echo $file_path."thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                           <td align="right">
                      <?php    
                          if($_SESSION['ne_user_type']==1)
			{
				?>
                 <span style="float:left"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid']; ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
                 <span style="float:right"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onClick="return confirm('Are you sure, you want to delete this Photo?')" /></form></span>
                <?php
			}
			else
			{
				
				
				$u_rightr=$result_get_right['user_right'];
			
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			$arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
						
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
							else if($arightr[1]==3)
							{
							$read_right=3;
							}
                       
						 if($read_right==1 || $read_right==3)
								  {
								   ?>
						  <span style="float:left"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid']; ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   <?php  
							}
							if($read_right==3)
								  {
								   ?>
						   <span style="float:right"><form action="sp_photo_album_input.php?phid=<?php echo $pdData['phid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onClick="return confirm('Are you sure, you want to delete this Photo?')" /></form></span>
						   <?php
						   }
						}
				}
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
</body>
</html>