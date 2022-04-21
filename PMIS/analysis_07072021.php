<?php
error_reporting(E_ALL & ~E_NOTICE);

@require_once("requires/session.php");

$module		= "Pictorial Analysis";
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: index.php?init=3");
}
$defaultLang = 'en';

$user_cd=$uid;
header("Content-Type: text/html; charset=utf-8");
//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');

}
else
{
	require_once('rs_lang.admin_rus.php');

}
$edit			= $_GET['edit'];

$objDb  		= new Database( );
echo $_SESSION['log_id'];
@require_once("get_url.php");



$site_path1= $_SERVER['DOCUMENT_ROOT'] . "/IDIP2_GMC/PMIS/";
$file_path="pictorial_data";
$data_url="photos/";
$msg= "";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];

 $album_id=$_REQUEST['album_id'];
 if(isset($album_id)&&!empty( $album_id))
 {
  $pdSQL11="SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and  albumid = ".$album_id;
$pdSQLResult11 = mysql_query($pdSQL11) or die(mysql_error());
$pdData11 = mysql_fetch_array($pdSQLResult11);
$status=$pdData11['status'];
$album_name=$pdData11['album_name'];
 }
if(isset($_REQUEST['lid']))
{
$lid=$_REQUEST['lid'];
$pdSQL1="SELECT lid, pid, title FROM  locations  WHERE  lid = ".$lid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$title=$pdData1['title'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['lid'])&$_REQUEST['lid']!="")
{

 mysql_query("Delete from  locations where lid=".$_REQUEST['lid']);
 header("Location: location_form.php");
}
$pdSQLq="";
$pdSQLq = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title FROM  project_photos a inner join locations b on(a.ph_cap=b.lid) WHERE a.pid=".$pid;
		
		if(!empty($_GET['location'])){
			$location = urldecode($_GET['location']);
			$pdSQLq .=" AND ph_cap='".$location."'";
		}
		if(!empty($_GET['date_p'])){
			$date_p = urldecode($_GET['date_p']);
			$pdSQLq .=" AND (date_p='".$date_p."'";
		}
		if(!empty($_REQUEST['date_p2'])){
			$date_p2 = urldecode($_REQUEST['date_p2']);
			$pdSQLq .=" OR date_p='".$date_p2."' ) order by date_p DESC";
		}
	//	echo $pdSQLq;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_submit"])){

	 	$files_download =$_POST['file_download'];
		
		$category=$_GET['album_id'];
		 if(isset($files_download)){ 
		$files_count=count($files_download); 
		 for($i=0;$i<$files_count;$i++)
		 {
		 $all_download[]=$files_download[$i];		
		 }
		 $out = '';
   $out .="album_name".",";
   $out .="ph_cap".",";
   $out .="al_file".",";
   $out .="\n";
		foreach ($all_download as $selected_file_id) {

echo $getquery="SELECT album_id,album_name,ph_cap,al_file FROM  t027project_photos INNER JOIN  t031project_albums ON 
 (t027project_photos.album_id = t031project_albums.albumid) where album_id=$category and phid=$selected_file_id";
 $result=mysql_query($getquery);
 $num_rows = mysql_num_rows($result);

  $l = mysql_fetch_array($result);
  
	$results[] = $l['al_file'];
   echo  $cat_name=preg_replace('/\s+/','_',$l['album_name']);
   echo $l['album_name'];
    $out.=$l['album_name'].",";
    $out.=str_replace(',','',$l['ph_cap']).",";	
	$out.="<a href='" .$l['al_file'] . "'>".$l['al_file']."</a> ,";
   
    $out .="\n";
 

}
}
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
$cat_name = str_replace(",", "_", $cat_name);
$cat_name = str_replace("*", "", $cat_name);
 $td = date('Y-m-d-h-m-s',time());
 $fname=genRandom(5).$td;
 $filename1 =$fname.".zip";
 // $f = fopen ("data/".$filename,'w+');
 // fputs($f, $out);
  //fclose($f);
  
  
  $zip = new ZipArchive();
  echo $filename = $site_path1."Zip/".$filename1;

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

$zip->addFromString("list-".$fname.".csv", $out);
$zip->addFromString("instructions.txt", " The list of downloaded files is provided as csv in this archive.\n");

//print_r($results);
foreach ($results as $file) {
//echo $file
$zip->addFile("photos/".$file,"/".$file);
}

echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();	

header('Content-Type: application/octet-stream');
header('Content-disposition: attachment; filename='.basename($filename1));
header('Content-Length: ' . filesize("Zip/".$filename1));
ob_clean();
flush();
readfile("Zip/".$filename1);
unlink("Zip/".$filename1);			


	
}	
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_submitv"])){

	 	$files_download1 =$_POST['file_downloadv'];
		$files_download=$files_download1[0];
		$category=$_GET['album_id'];
		 if(isset($files_download)){ 
		echo $getquery="SELECT album_id,v_cap,v_al_file FROM   t32project_videos INNER JOIN  t031project_albums ON 
 (t32project_videos.album_id = t031project_albums.albumid) where album_id=$category and vid=$files_download";
 $result=mysql_query($getquery);
 $num_rows = mysql_num_rows($result);

  $l = mysql_fetch_array($result); 
		$fileName=$l['v_al_file'];
		$file="photos/".$fileName; 
		 if (file_exists($file)) {
			
			 
                    $mime = 'application/force-download';

                    header('Content-Type: '.$mime);

                    header('Content-Description: File Transfer');
                    header('Content-Disposition: attachment; filename='.$fileName);
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    ob_clean();
                    flush();
                    readfile($file);
                    exit;
                }
		 }
}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
<?php include ('includes/metatag.php'); ?>
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
function getGalleryView(month) 
	{
	
		var location=document.getElementById("location").value;  
			
		if (month!="") {
			var strURL="findGalleryView.php?date_p="+month+" &location="+location;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('Gallery_View').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		   
	}
function doFilter(frm){
	
	var x =frm.location.value;
	
	
	 if (x == 0) {
    alert("Select Location First");
    return false;
  		}
		var y =frm.date_p.value;
	
	
	 if (y == 0) {
    alert("Select Date1");
    return false;
  		}
		var z =frm.date_p2.value;
	
	
	 if (z == 0) {
    alert("Select Date2");
    return false;
  		}
		
		if(x!=0 && y!=0 && z!=0)
		{document.location = 'analysis.php?location='+x+'&date_p='+y+'&date_p2='+z;
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
<script>
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function atleast_onecheckboxv(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
  else if($("input[type=checkbox]:checked").length >1) {
      e.preventDefault();
      alert('You can Download only one video at a time');
      return false;
}
}
</script>
<script>
function selectAllUnSelectAll(chkAll, strSelecting, frm){
if(chkAll.checked == true){
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = true;
			}
		}
	}
	else{
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = false;
			}
		}
	}
}
function selectUnSelect_top(value,frm)
{
	
var checkboxes = document.getElementsByClassName("checkbox");
if(value.checked == false){
chkAll.checked =false;
}
if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length)
{
chkAll.checked =true;
}
}
</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>

  <?php include 'includes/header.php'; ?>
<div id="content">

<table style="width:100%; height:100%">

  <tr style="height:45%"><td width="5%" align="left" valign="top" >
  <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; background-color:#E0E0E0">

  <div style="clear:both; margin:5px ">
  <?php
							  if($_SESSION['ne_user_type']==1)
							{
								?>
<a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('pictorial_form.php', '<?php echo PLOAD_PHOTO_BTN;?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo PLOAD_PHOTO_BTN;?></a>
	<?php }
   else
   {
$pdSQL = "SELECT * FROM  locations WHERE pid=".$pid." order by lid";
						$pdSQLResult = mysql_query($pdSQL);
						
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							 
	   
	   
			$u_rightr=$pdData['user_right'];			
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
							$flagg=1;
								  ?>
                                  <?php
								 								  }
								  
						}
				}
							
   
   }
   if($flagg==1)
   {
	   ?>
       <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('pictorial_form.php', '<?php echo PLOAD_PHOTO_BTN;?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo PLOAD_PHOTO_BTN;?></a>

       <?php
   }
   } 
   }?>
    </div>

<div style="vertical-align:top; margin:5px 15px 0px 5px; padding:5px 0px 0px 5px;" >
  <div id="LoginBox" class="borderRound borderShadow" >
<form action="" target="_self" method="post"  enctype="multipart/form-data">
  <table border="0" width="100%" height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td colspan="2" align="left"><strong><?php echo PIC_LOCATION ?>:</strong></td></tr>
  <tr>
  <td colspan="2"><select id="location" name="location" onchange="getDates(this.value)" style="width:242px">
     	<option value="0"><?php echo PIC_LOCATION ?></option>
  		<?php $pdSQL = "SELECT * FROM  locations WHERE pid=".$pid." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{
							  ?>
                              
  <option value="<?php echo $pdData["lid"];?>" <?php if($location==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
   <?php }
   else
   {
	   
	   
			$u_rightr=$pdData['user_right'];			
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
							
								  ?>
                                   <option value="<?php echo $pdData["lid"];?>" <?php if($location==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                                  <?php
								  
						}
				}
							
   
   }} 
   }?>
  </select></td>
  </tr>
  <tr><td colspan="2" align="left"><strong><?php echo COMP_DATES;?>:</strong></td></tr>
  <tr><td  colspan="2"  align="left"><div id="location_div" style="width:100%">
  <select id="date_p" name="date_p" style="width:120px">
     <option value="0"><?php echo DATE;?> 1</option>
     <?php 
	 if(isset($_REQUEST['location']))
	 {
		$location= $_REQUEST['location'];
		 $pdSQLdd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid."  and ph_cap=".$location." order by date_p  ASC";
	 }
	 else
	 {
			$pdSQLdd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." order by date_p  ASC";
	 }
		
  		
						 $pdSQLResultdd = mysql_query($pdSQLdd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultdd)>=1)
							  {
							  while($pdDatadd = mysql_fetch_array($pdSQLResultdd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatadd["date_p"];?>" <?php if($date_p==$pdDatadd["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatadd["date_p"]));?></option>
   <?php } 
   }?>
  </select>
  <select id="date_p2" name="date_p2"  style="width:120px">
     <option value="0"><?php echo DATE;?> 2</option>
     <?php 
	 
	 if(isset($_REQUEST['location']))
	 {
		$location= $_REQUEST['location'];
		 $pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." and ph_cap=".$location." order by date_p  ASC";
	 }
	 else
	 {
			$pdSQLd = "SELECT DISTINCT(date_p) FROM  project_photos  WHERE pid=".$pid." order by date_p  ASC";
	 }
	 
	 
			
		
						 $pdSQLResultd = mysql_query($pdSQLd);
						$i=0;
							  if(mysql_num_rows($pdSQLResultd)>=1)
							  {
							  while($pdDatad = mysql_fetch_array($pdSQLResultd))
							  { 
							  $i++;?>
  <option value="<?php echo $pdDatad["date_p"];?>" <?php if($date_p2==$pdDatad["date_p"]) {?> selected="selected" <?php }?>><?php echo date('d-m-Y',strtotime($pdDatad["date_p"]));?></option>
   <?php } 
   }?>
  </select>
  </div></td>
  </tr>
  <tr><td colspan="2" align="center"> 
	<input type="button"  onclick="doFilter(this.form);" class="SubmitButton" name="Submit" id="Submit" value=" <?php echo VIEW; ?> " />
	</td></tr>
	 </table>
	
  </form>
  </div>
</div>
<div style="vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px;" id="Gallery_View">
   <?php if(!empty($_GET['date_p'])&&!empty($_GET['location'])&&!empty($_GET['date_p2']))
  {

			 
			 $pdSQLResult = mysql_query($pdSQLq);
			if(mysql_num_rows($pdSQLResult) >= 1){
			while($result = mysql_fetch_array($pdSQLResult))
			{
				 if($result['al_file']!="")
				{
			
				?>
                <strong><?php echo $result['title']."&nbsp; as on &nbsp;&nbsp;".date('d F, Y',strtotime($result['date_p'])); ?>:</strong>
                <a href="<?php echo $file_path."/".$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none">
                <img src="<?php echo $file_path."/thumb/".$result['al_file']; ?>" title="<?php echo date('d F, Y',strtotime($result['date_p'])); ?>"  style=" border:3px solid #000; border-radius:6px;margin-top:10px;"  width="270px" /></a>
			<br/><br/>
				 <?php 
				}
			}
				}
				
  } ?>       
</div> 
</div>
  
   
  </td><td width="67%" valign="top"> <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; ">
  <table style="width:100%; height:100%">
  
    <tr style="height:60px; background: #F0AC62" >
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo PHOTO_VIDEO_ALBUM; ?></span>
    
	<span style="float:right">
    <?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
	{?>
    <a class="SubmitButton"  href="analysis.php"  style="margin:5px; text-decoration:none"><?php echo VIEW_ALBUM; ?></a>
	<?php } ?>
	<?php  /*if($picentry_flag==1 || $picadm_flag==1)
	{
	?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_album_input.php', '<?php echo MAN_ALBM; ?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_ALBM; ?></a>
	
	<?php
	}*/
	?>
	
	</span></td></tr>
  <tr style="height:45%"><td align="center">
  <form name="reports_cat" id="reports_cat" method="post" action="" onsubmit="return atleast_onecheckbox(event)"> </form>
   <form name="reports_catv" id="reports_catv" method="post" action="" onsubmit="return atleast_onecheckboxv(event)"> </form>
  <?php echo $message; ?>
<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
{?>
<table style="width:100%; height:auto; border:1px solid #ccc; border-radius:6px;"  >
  <tbody>
    <tr >
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;">
    <span><?php echo $album_name; ?>
    </span>
	<span style="float:right; margin-top:10px">
	<?php  //if($picentry_flag==1 || $picadm_flag==1)
	//{
			if($_SESSION['ne_user_type']==1)
			{
			
  ?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none"><?php echo MAN_VID;?></a>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM; ?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_PHOTO; ?></a>
     <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_subalbum_input.php?cat_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM; ?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_ALBM; ?></a>
   
	
	<?php
	}
	

else if($_REQUEST['album_id'])
{
	
$cattid=$_REQUEST['album_id'];
			$cqueryd = "select * from  t031project_albums  where albumid='$cattid'";
			$cresultd = mysql_query($cqueryd);
			$cdatad = mysql_fetch_array($cresultd);
			$p_cdd=$cdatad['parent_album'];
			$pp_group=$cdatad['parent_group'];
			$arr_pp_group=explode("_",$pp_group);
			$getalbumid=$arr_pp_group[1];
			
			if($p_cdd==0)
			{
				
			?>
            
            <?php
			}
			else if($p_cdd!=0)
			{
			$cqueryd_r = "select user_right,user_ids from  t031project_albums  where albumid=$getalbumid";
			$cresultd_r = mysql_query($cqueryd_r);
			$cdatad_r = mysql_fetch_array($cresultd_r);	
			
			$u_right=$cdatad_r['user_right'];
			$arruright= explode(",",$u_right);
			$arr_right_users=count($arruright);		
			 foreach($arruright as $key => $val) 
			 	{
			   $arruright[$key] = trim($val);
			   $aright= explode("_", $arruright[$key]);
			    if($aright[0]==$user_cd)
						{
							if($aright[1]==1)
							{
							$read_right=1;
							?>
      <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none"><?php echo MAN_VID;?></a>
	 <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM; ?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_PHOTO; ?></a>
     <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_subalbum_input.php?cat_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM; ?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_ALBM; ?></a>

     <?php
							}
							else if($aright[1]==3)
							{
							$read_right=3;
							?>
                             <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_video_input.php?album_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none"><?php echo MAN_VID;?></a>
                             <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_photo_album_input.php?album_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM; ?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_PHOTO; ?></a>
     <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_subalbum_input.php?cat_id=<?php echo $album_id; ?>', '<?php echo MAN_ALBM; ?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo MAN_ALBM; ?></a>
    
     
     <?php
							}
							else if($aright[1]==2)
							{
							$read_right=2;
							
							
							}
					     }
				}
			
			}
}
	//}
?>
	
	</span>
    
    
    </td></tr>
    <tr><td style="font-size:18px; font-weight:bold">
    <?php 
	
	$sqlss="select parent_group, status from t031project_albums where albumid=$album_id";
	$sqlrwss=mysql_query($sqlss);
	$sqlrw1ss=mysql_fetch_array($sqlrwss);
	$par_groups=$sqlrw1ss['parent_group'];
	$status=$sqlrw1ss['status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$album_name_track="";
	$album_name_track .='
	<strong><a style="font-size:15px" href="analysis.php">'.PHOTO_VIDEO_ALBUM.'</a></strong>&nbsp;&raquo;&nbsp;	';
	for($i=0;$i<$lenns;$i++)
	{
	 $sqlCN="select album_name,parent_album from t031project_albums where albumid='$par_arr[$i]' ";
		
	$sqlrCN=mysql_query($sqlCN);
	$sqlCNrw=mysql_fetch_array($sqlrCN);
	
		$category_name_lang=$sqlCNrw["album_name"];
	
	
	$album_name_track .='<strong><a style="font-size:15px" href="analysis.php?cat_id='.$sqlCNrw["parent_album"].'&album_id='.$par_arr[$i].'">'.$category_name_lang.'</a></strong>';
	
	$album_name_track .="&nbsp;&raquo;&nbsp;";
	
	//$category_name .=$category_name;
	}
   echo $report_category=$album_name_track;
   ?></td></tr>
  <tr>
 <td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
  <?php $cm=0;
			 $pdSQL = "SELECT * FROM t031project_albums  WHERE pid= ".$pid." and status=1 and parent_album=".$album_id." order by albumid asc";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
					
				$album_idn=$result['albumid'];
				$p_group=$result['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[1];
				 $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $pdSQLResult_get_right = mysql_query($pdSQL_get_right);
			 $result_get_right = mysql_fetch_array($pdSQLResult_get_right);
			 
				
				$pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_idn." limit 0,1";
			 $pdSQLResult_r = mysql_query($pdSQL_r);
			if(mysql_num_rows($pdSQLResult_r) >= 1)
			{
			
				$result_r = mysql_fetch_array($pdSQLResult_r);
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.png";
			}
				
				
	if($_SESSION['ne_user_type']==1)
			{
			?>		
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>

            <?php
			$cm++;
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
						
						
					
			
				?>
			<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?> </div>
	</div>
	</li>
	</div>
    <?php
			$cm++;
			}
				}
				}
			
			}} ?>
            </td>
            </tr>
            <tr><td style="font-size:18px">&nbsp;</td></tr>
            <tr style="background: #E6E6E6; height:32px"><td style="font-size:18px; font-weight:bold; padding-left:3px; ">Photos</td></tr>
 
            <?php  $pdSQL1 = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
			 $pdSQLResult1 = mysql_query($pdSQL1);
			if(mysql_num_rows($pdSQLResult1) >= 1){ 
			
			?>
               <tr style="height:40px">
              <td>
  <input  type="checkbox" name="chkAll" id=
          "chkAll" value="1" form="reports_cat" onclick="selectAllUnSelectAll(this,'file_download[]',reports_cat);"/> Select/Unselect All &nbsp;&nbsp;&nbsp;&nbsp;<span><input type="submit" name="download_submit" id="download_submit" value="Download Files" form="reports_cat" /></span>
          </td></tr>
          <?php
			}
			?>
            <tr>
            <td  align="center" valign="top">
          
 <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." order by phid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				
				
				?>
				<?php if($result['al_file']!="")
				{
				$file_array=explode(".",$result['al_file']);
				$file_type=$file_array[1];
				if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png") || ($file_type=="JPG")|| ($file_type=="JPEG")|| ($file_type=="PNG") || ($file_type=="GIF")|| ($file_type=="jfif"))
				{
				?>
				<div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:163px;margin-right:0px;">

	   <a  href=" <?php echo $data_url.$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none" >
       
       
	<div style="border: thin #999 solid; padding: 3px;margin-bottom: 3px;">	
	<img src="<?php //echo $data_url."thumb/".$result['al_file'];
	echo $data_url."thumb/".$result['al_file']; ?>"  border="0" width="150px" height="112px" title="<?php echo $result['al_file'];?>"/>
    </div>
	 	</a>
        <div align="center" class="imageTitle" style="padding-top:2px; font-weight:bold">
     <input type="checkbox" class="checkbox"    name="file_download[]"  value="<?php echo $result['phid'];?>" form="reports_cat" onclick="selectUnSelect_top(this,reports_cat);"/>
		<?php if(strlen($result['ph_cap'])>15)
		{
		echo substr($result['ph_cap'],0,15)."...";
		}
		else
		{
		echo $result['ph_cap'];
		} ?>				     </div>
	</div>

	
	
	
	</li>
	</div>
            <?php
				}
				
				}
				}
			}
			else
			{
			 echo NO_RECORD;?>
			<?php
			}?>
            </td></tr>
            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
         <tr style="background: #E6E6E6; height:32px"><td style="font-size:18px; font-weight:bold; padding-left:3px"><span><?php echo VIDEOS; ?></span>
	<span style="float:right; width:160px;margin-top:10px">
	
	</span></td></tr>
    <?php  $pdSQL1 = "SELECT vid, pid,album_id,v_cap,v_al_file FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
			 $pdSQLResult1 = mysql_query($pdSQL1);
			if(mysql_num_rows($pdSQLResult1) >= 1){ 
			
			?>
               <tr style="height:40px">
              <td>
 <span><input type="submit" name="download_submitv" id="download_submitv" value="Download Files" form="reports_catv" />
  </span>
          </td></tr>
          <?php
			}
			?>
  <tr><td align="center" valign="top">

   <table width="100%" style=" padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
    font-weight: bold;  margin: 0px;">
     <tbody><?php  
			
			 $cm=0;
			 $pdSQL = "SELECT vid, pid,album_id,v_cap,v_al_file FROM t32project_videos WHERE pid = ".$pid." and album_id=".$album_id." order by vid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				
				if($cm==0 || $cm%6==0)
				{
				echo "<tr>";
				}?><td width="26%" style="border: thin #999 solid; padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
    font-weight: bold;  margin: 0px;"><?php if($result['v_al_file']!="")
				{
				$file_array=explode(".",$result['v_al_file']);
				$file_type=$file_array[1];
				/*if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png"))
				{*/
				?>
                <div  style="float:left;width:163px;margin-right:0px;">
				 <a  href="javascript:void(null);" onclick="window.open('sp_video_large.php?video=<?php echo $result['v_al_file'];?>&vid=<?php echo $result['vid'];?>&album_id=<?php echo $album_id;?>', 'View Video ','width=700px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  
     style="margin-top:20px;text-decoration:none"  alt="<?php echo $result['v_cap'];?>">
                 <img src="./images/video_file_icon.jpg" width="150" height="100" border="0"  title="<?php echo $result['v_al_file'];?>"/></a>
                 <div align="center" class="imageTitle" style="padding-top:2px; font-weight:bold">
       <input type="checkbox" class="checkboxv"    name="file_downloadv[]"  value="<?php echo $result['vid'];?>" form="reports_catv" onclick="selectUnSelect_topv(this,reports_catv);"/>
		<?php if(strlen($result['v_cap'])>15)
		{
		echo substr($result['v_cap'],0,15)."...";
		}
		else
		{
		echo $result['v_cap'];
		} ?>				     </div>
        </div>
			               
                 <?php
				 
				}?></td>
            <?php 
			$cm++;
			if($cm==6 || $cm%6==0)
			{
			echo "</tr>";
			}
			}}
			else
			{
				 echo NO_RECORD;
			}?>
                </tbody>
      </table>
  </td></tr>    
            
            
            
            
            
                              </tbody>
      </table>

  </td>
  </tr>
  
  </table>
  
  
<?php }
else
{?>
  <table width="100%" style="margin:0px; border:0px; padding:0px">
			<tbody>
            <tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and status=1 and parent_album=0 order by albumid desc";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				$album_id=$result['albumid'];
				$pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 $pdSQLResult_r = mysql_query($pdSQL_r);
			if(mysql_num_rows($pdSQLResult_r) >= 1)
			{
			
				$result_r = mysql_fetch_array($pdSQLResult_r);
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.png";
			}
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
    <a  href="analysis.php?album_id=<?php echo $result['albumid'];?>" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url."thumb/".$al_file_r; ?>">
	</div>
	</a>
	<div align="center" class="imageTitle" style="padding-top:5px; font-weight:bold">
	<?php echo $result['album_name']; ?>				     </div>
	</div>
	</li>
	</div>

            <?php 
			$cm++;
			
			}}?>
        </td>
		</tr>
		</tbody>
		</table>
	<?php }?>
  </td></tr>
  
  </table></div></td></tr>
  
  </table>
</div>
  <?php include ("includes/footer.php"); ?>

</body>
</html>
<?php
	$objDb  -> close( );
?>
