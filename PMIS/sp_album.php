<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Photo Albums";

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$data_url="photos/";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<!--<h1> Pictorial Analysis Control Panel</h1>-->
<table style="width:100%; height:100%">
  
    <tr style="height:60px">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Albums</span><span style="float:left">
    <?php /*?><form action="location_form.php" method="post"><input type="submit" name="back" id="back" value="Locations" /></form><?php */?>
    </span>
	<span style="float:right">
	<?php  if($picentry_flag==1 || $picadm_flag==1)
	{
	?>
	<form action="sp_album_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Manage Albums" /></form>
	<?php
	}
	?>
	
	</span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="" target="_self" method="post"  enctype="multipart/form-data">
  <table width="70%" style="margin:0px; border:0px; padding:0px">
			<tbody><tr>
			<td width="100%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT albumid, pid, album_name, status FROM t031project_albums  WHERE pid= ".$pid." and status=1 order by albumid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				$album_id=$result[albumid];
				$pdSQL_r = "SELECT phid, pid, al_file, ph_cap FROM t027project_photos WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
			 $pdSQLResult_r = mysql_query($pdSQL_r);
			if(mysql_num_rows($pdSQLResult_r) >= 1)
			{
			
				$result_r = mysql_fetch_array($pdSQLResult_r);
				$al_file_r=$result_r['al_file'];
			}
			else
			{
			$al_file_r="no_image.jpg";
			}
				
				?>
				
            <div class="new_div">
			<li class="dfwp-item">
	<div  style="float:left;width:152px;margin-right:8px;">
	<a href="sp_photo.php?album_id=<?php echo $result['albumid'];?>" target="_parent" >
	<div class="img-frame-gallery">	
	<img width="80" height="80" border="0" align="top" alt="" src="<?php echo $data_url.$al_file_r; ?>">
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
	
  </form> 
  </td></tr>
  
  </table>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
