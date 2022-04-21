<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Maps and Drawings";
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($draw_flag==0  ) {
header("Location: index.php?init=3");
}
$defaultLang = 'en';

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
@require_once("get_url.php");

$data_url="drawings/";
$msg= "";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];

 $album_id=$_REQUEST['album_id'];
 if(isset($album_id)&&!empty( $album_id))
 {


 $sqlss="SELECT albumid, pid, parent_id, album_name,parent_group, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and  albumid = ".$album_id;
	$sqlrwss=mysql_query($sqlss);
	$sqlrw1ss=mysql_fetch_array($sqlrwss);
	$par_groups=$sqlrw1ss['parent_group'];
	$album_name=$sqlrw1ss['album_name'];
	$parent_id=$sqlrw1ss['albumid']; 
 	 $prt_id=$sqlrw1ss['parent_id'];
	$status=$sqlrw1ss['status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$f_name="";
	for($i=0;$i<$lenns;$i++)
	{
	$sqlCN="select albumid,album_name,parent_id from t031project_drawingalbums where albumid='$par_arr[$i]' ";	
	$sqlrCN=mysql_query($sqlCN);
	$sqlCNrw=mysql_fetch_array($sqlrCN);
	$f_name .='<a style="text-decoration:none" href="./dm_drawingmap.php?album_id='.$sqlCNrw['albumid'].'">'.$sqlCNrw['album_name'].'</a>';
	
	$f_name .="&nbsp;&raquo;&nbsp;";
	
	}
   $fold_name=$f_name;

 }
 else
 {
 $parent_id=0;
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

///Filter
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["go_submit"])){
$dwg_type = $_POST['dwg_type'];

if(isset($_GET['cat_cd']))
{
$cat_cd_new='&cat_cd='.$_GET['cat_cd'];
}
if($dwg_type=='All')
{
header('Location:dm_drawingmap.php?album_id='.$_GET['album_id']);
}
else
{
header('Location:dm_drawingmap.php?album_id='.$_GET['album_id'].'&dwg_type='.$dwg_type );
}
}
///Filter End
 if(isset($_REQUEST['act'])&&isset($_REQUEST['dwgid'])&&isset($_REQUEST['album_id'])&&$_REQUEST['dwgid']!="")
{
$pdSQL1="SELECT al_file FROM  t027project_drawings  WHERE  dwgid = ".$_REQUEST['dwgid'];
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$al_file=$pdData1['al_file'];
@unlink($data_url.$al_file);
$album_id=$_REQUEST['album_id'];
 mysql_query("Delete from t027project_drawings where dwgid=".$_REQUEST['dwgid']." and album_id=".$_REQUEST['album_id']);
 header("Location:dm_drawingmap.php?album_id=$album_id");
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
			$pdSQLq .=" OR date_p='".$date_p2."' )";
		}
	//	echo $pdSQLq;
		
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
    background: rgba(0, 0, 0, 0) url("./images/drawing_folder.png") no-repeat scroll 0 0;
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
	var qString = '';
	if(frm.location.value != ""){
		qString += 'location=' + escape(frm.location.value);
	}
	
	if(frm.date_p.value != ""){
		qString += '&date_p=' + frm.date_p.value;
	}
	if(frm.date_p2.value != ""){
		qString += '&date_p2=' + frm.date_p2.value;
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


  <script language="javascript" type="text/javascript">

/*function getXMLHTTP() { //fuction to return the xml http object
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
    }*/
	

	
function getsubcat(albumid) {

			if(albumid==""||albumid==0)
			{
			
			<?php
		
			$cquery = "select * from  t031project_drawingalbums";
			
			$cresult = mysql_query($cquery);
			while ($cdata = mysql_fetch_array($cresult)) {	
			$album_id=$cdata['albumid'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdata['albumid']?>).style.display="none";
		   document.getElementById("subcatidm").value=albumid;
		   
            <?php }?>
			}
			else
			{
			<?php
		
			$cqueryg = "select * from  t031project_drawingalbums";
			
			$cresultg = mysql_query($cqueryg);
			while ($cdatag = mysql_fetch_array($cresultg)) {	
			$album_idg=$cdatag['albumid'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdatag['albumid']?>).style.display="none";
		   	
            <?php }?>

			
			 
           document.getElementById("subcatdiv_"+albumid).style.display="block";
		   document.getElementById("subcatidm").value=albumid;
		   
		   
	
           }
			
						
			var strURL="sel_nextalbum.php?album_id="+albumid;
			
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {
														
							document.getElementById("subcatdiv_"+albumid).innerHTML=req.responseText;
							
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
	}
	
	function getXMLHTTP1() { //fuction to return the xml http object
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
	function subcatlisting(subalbumid,albumid,parent_id) {

		 if(albumid!="" && subalbumid==0)
		  {
		  var myArray = albumid.split('_');		  
		  var len=myArray.length;
		  var subalbum=myArray[len-1];
		   <?php
		 $cquery2 = "select * from  t031project_drawingalbums";			
			$cresult2 = mysql_query($cquery2);
			while ($cdata2 = mysql_fetch_array($cresult2)) {	
			$album_id2=$cdata2['albumid'];
			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['albumid']?>).style.display="none";
			 <?php
		  }
		   ?>		   
		   for(var i=0; i<len; i++)
		   {
		    document.getElementById("subcatdiv_"+myArray[i]).style.display="block";
			 document.getElementById("subcatidm").value=myArray[i]; 		
		   }
		 	
		  }
		  else 
		  {
		 
		  var myArray1 = albumid.split('_');		  
		  var len1=myArray1.length;
		  var subalbum=myArray1[len1-1];
		   <?php
		 $cquery2 = "select * from  t031project_drawingalbums";			
			$cresult2 = mysql_query($cquery2);
			while ($cdata2 = mysql_fetch_array($cresult2)) {	
			$album_id2=$cdata2['albumid'];
			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['albumid']?>).style.display="none";
			 <?php
		  }
		   ?>		   
		   for(var j=0; j<len1; j++)
		   {
		    document.getElementById("subcatdiv_"+myArray1[j]).style.display="block";
			
		   }
		   document.getElementById("subcatdiv_"+subalbumid).style.display="block"; 
		  	 document.getElementById("subcatidm").value=subalbumid;
			
		  }
		
			var strURL1="sel_subalbum.php?subalbum_id="+subalbumid+"&albumid="+albumid;
			var req1 = getXMLHTTP1();			
			if (req1) {
			
				req1.onreadystatechange = function() {
					if (req1.readyState == 4) {
						// only if "OK"
						if (req1.status == 200) 
						{
					
						document.getElementById("subcatdiv_"+subalbumid).innerHTML=req1.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req1.statusText);
						}
					}				
				}			
				req1.open("GET", strURL1, true);
				req1.send(null);
			}
		
	}
	
	function advSearch(albumid,last_subalbum,dwg_no,dwg_title,dwg_date,revision_no,dwg_status) {
	
 // if (str.length==0) { 
 //  document.getElementById("livesearch").innerHTML="";
 //   document.getElementById("livesearch").style.border="0px";
 //   return;
 // }

/*if(last_subalbum=="" || last_subalbum==0)
{
alert("Please select Folder first");
document.getElementById("advsearch").style.display="none"; 
}
else
{*/
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	document.getElementById("advsearch").style.display="block"; 
      document.getElementById("advsearch").innerHTML=xmlhttp.responseText;
      document.getElementById("advsearch").style.border="1px solid #A5ACB2";
    }
  }

  xmlhttp.open("GET","drawing_search.php?albumid="+albumid+"&last_subalbum="+last_subalbum+"&dwg_no="+dwg_no+"&dwg_title="+dwg_title+"&dwg_date="+dwg_date+"&revision_no="+revision_no+"&dwg_status="+dwg_status,true);
  xmlhttp.send();
 }
//}
</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">

<table style="width:100%; height:100%">

  <tr style="height:45%"><td width="5%" align="left" valign="top" >
  <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; background-color:#E0E0E0">
  
<div style="vertical-align:top; margin:5px 15px 0px 5px; padding:5px 0px 0px 5px;" >
  <div id="LoginBox" class="borderRound borderShadow" >
<form name="searchfrm" id="searchfrm" action="reports_search.php"  method="post"  style=" border:1px solid #FFFFFF" >
     <table width="100%" height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;" >      
     <tr><th width="40%" align="left;" style="font-weight:bold; font-size:20px;"><?php echo SEARCH;?>:</th>
	 <th width="60%">&nbsp;&nbsp;</th></tr>
	  <tr >
	  
	  <td width="40%" style="text-align:left" ><?php echo FOLDER;?>: &nbsp;</td>
	  <td width="60%" >
	  <select  name="album_id" id="album_id" onchange="getsubcat(this.value)" >
  		<option value=0  ><?php echo SEL_FOL.".."; ?> </option>
		 <?php
		$cquery = "select * from  t031project_drawingalbums WHERE parent_id = 0";
		$cresult = mysql_query($cquery);
		while ($cdata = mysql_fetch_array($cresult)) {

?>
		
       <option value="<?php echo $cdata['albumid']; ?>" <?php if ($cat_idm == $cdata['albumid']) {echo ' selected="selected"';} ?>><?php echo $cdata['album_name']; ?></option>
		<?php
		}
		?>
</select>
</td>

</tr>
<tr>
		<td colspan="2" style="padding:0px;text-align:left">
			<?php
$cquery = "select albumid from  t031project_drawingalbums";
		
		$cresult = mysql_query($cquery);
		while ($cdata = mysql_fetch_array($cresult)) {	
		$cat_id2=$cdata['albumid'];	
		?>
<div id="<?php echo "subcatdiv_".$cdata['albumid']?>" style="display:block" >
		</div>
<?php
}

?>
 <input type="hidden" name="subcatidm" id="subcatidm" value=""/>         
</td>

</tr>
	 
	   <tr>
	   
         <td width="40%" style="text-align:left"><?php echo DRW_NO;?>: &nbsp;</td>
         <td width="60%" ><input type="text" name="dwg_no" id="dwg_no" value="<?php echo $dwg_no;?>"   size="100"/></td>
		</tr>
		<tr>
		 <td width="40%" style="text-align:left"><?php echo DRW_TITLE ;?>: &nbsp;</td>
         <td width="60%" ><input type="text" name="dwg_title" id="dwg_title" value="<?php echo $dwg_title;?>"   size="100"/></td>
       </tr>
	  
	   <tr>
         <td width="40%" style="text-align:left"><?php echo DRW_DATE ;?>: &nbsp;</td>
         <td width="60%" ><input type="text" name="dwg_date" id="dwg_date" value="<?php echo $dwg_date;?>"   size="100"/></td>
	</tr>
	<tr>
		 <td width="40%" style="text-align:left"><?php echo REV_NO ;?>:</td>
         <td width="60%" ><input type="text" name="revision_no" id="revision_no" value="<?php echo $revision_no;?>"   size="100"/></td>
       </tr>
	   
	   <tr>
         <td width="40%" style="text-align:left"><?php echo DRW_STA;?>:</td>
         <td width="60%" ><select name="dwg_status">
		 <option value="1" <?php if($dwg_status=='1')echo "selected";?>>Initiated</option>
  		<option value="2" <?php if($dwg_status=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($dwg_status=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($dwg_status=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($dwg_status=='5')echo "selected";?>>Response Awaited</option>
		  <option value="7" <?php if($dwg_status=='7')echo "selected";?>>Responded</option>
		</select></td>
		</tr>
		
	    
   <tr>
        <td width="40%" style="text-align:left"></td> 
         <td width="60%" align="left">
          <input type="button" onclick="advSearch(album_id.value,subcatidm.value,dwg_no.value,dwg_title.value,dwg_date.value,revision_no.value,dwg_status.value)" value="<?php echo GO;?>" /></td>
       </tr>
     </table>
   </form>
  </div>
</div>
<div id="advsearch" style="vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px;" ></div>

</div>
  
   
  </td><td width="67%" valign="top"> 
  <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; ">
  <table style="width:100%; height:100%">
  
    <tr style="height:50px">
    <td align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;">
	<span><?php echo MAPS_DRAWINGS;?></span>
    
	<span style="float:right; margin-top:15px;">
	<?php  if($drawentry_flag==1 || $drawadm_flag==1)
	{
	?>
    <?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]))
	{?>
    <a class="SubmitButton"  href="dm_drawingmap.php"  style="margin:3px; text-decoration:none"><?php echo VIEW_DRW;?></a>
	 <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_drawingalbum_input.php?parent_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:3px; text-decoration:none"><?php echo MAN_DRW_FOLDER;?></a>
	  <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_drawing_album_input.php?album_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=770px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" text-decoration:none"><?php echo MAN_DRW;?></a>
	<?php }
	else
	{ ?>	
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_drawingalbum_input.php', '<?php echo MAN_DRW_FOLDER;?> ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="text-decoration:none"><?php echo MAN_DRW_FOLDER;?></a>
	
	<?php
	}
	}
	?>
	
	</span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
<?php if(isset($_REQUEST["album_id"])&&!empty($_REQUEST["album_id"]) &&!empty($parent_id))
{?>
<table style="width:100%; height:auto; border:1px solid #ccc; border-radius:6px;"  >
  <tr>
  <td align="left" style="height:30px; vertical-align:top" ><span style="text-align:left;font-family:Verdana, Geneva, sans-serif; font-size:12px"><?php  echo $fold_name;?></span>
 
	<?php  /*if($drawentry_flag==1 || $drawadm_flag==1)
	{
	?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_drawing_album_input.php?album_id=<?php echo $_REQUEST["album_id"]; ?>', 'Manage Albums ','width=770px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" text-decoration:none">Manage Drawings</a>
	
	<?php
	}*/
	?>
	
	</td>
  </tr>
    <tr >
	
    <td style="text-align:center;font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span ><?php echo $album_name; ?>
    </span>
	</td></tr>
	
	<tr>
	<td align="center" valign="top">
	<?php 
		 $cm=0;
			$pdSQL = "SELECT albumid, parent_id,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and parent_id=".$parent_id." order by albumid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
			?>
	 <div style="border:1px solid #000; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; ">
	<table width="100%" style="margin:0px; border:0px; padding:0px">
			<tbody><tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
		
				while($result = mysql_fetch_array($pdSQLResult)){
				$album_id=$result[albumid];
				$pdSQL_r = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
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
 <!--    <a  href="javascript:void(null);" onclick="window.open('sp_photo.php?album_id=<?php echo $result['albumid'];?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none" >-->
	    <a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
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
			
			}?>
        </td>
		</tr>
		</tbody>
		</table>
		</div>
		<?Php
		}
		?>
		</td>
	</tr>
	
	
	
	
	
	
  <tr>
  <td align="right" valign="top">
 <form name="filter_1" id="filter_1" method="post" action="?album_id=<?php echo $_GET['album_id']?>"> 
<select  name="dwg_type" id="dwg_type"  >
 
  		<option value="All" <?php if(!isset($_GET['dwg_type']))echo "selected";?>>All Files</option>
        <option value="Design" <?php if($_GET['dwg_type']=='Design') echo "selected";?>>Design</option>
		 <option value="Survey" <?php if($_GET['dwg_type']=='Survey') echo "selected";?>>Survey</option>
  		<option value="Others" <?php if($_GET['dwg_type']=='Others') echo "selected";?>>Others</option>
		
</select>
		
		<input type="submit" form="filter_1" name="go_submit" id="go_submit" value="GO" /> </form>
   
   
   <table class="reference" width="100%"  style=" padding: 3px; font-family: Verdana, Geneva, sans-serif; font-size: 12px;
     margin: 0px;" > 
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">#</th>
                                  <th width="15%" style="text-align:center"><?php echo DRW_NO ;?></th>
								  <th width="25%" style="text-align:center"><?php echo DRW_TITLE ;?></th>
                                  <th width="25%" style="text-align:center"><?php echo DRW_TYPE ;?></th>
								  <th width="10%" style="text-align:center"><?php echo DRW_DATE ;?></th>
								   <th width="10%" style="text-align:center"><?php echo REV_NO;?></th>
								  <th width="10%" style="text-align:center"><?php echo DRW_STA;?></th>
                                  <th width="10%" style="text-align:center"><?php echo FILE;?></th>
								
								  <?php if($drawentry_flag==1 || $drawadm_flag==1)
								  {
								   ?>
								  <th width="15%" style="text-align:center" colspan="2"><?php echo ACTION;?></th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  if(isset($_GET['dwg_type']))
							  {
								  $type_d=$_GET['dwg_type'];
								  
								  $pdSQL = "SELECT dwgid, pid,album_id, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and dwg_type='$type_d' and album_id=".$parent_id." order by dwgid";
							  }
							  else
							  {
								   $pdSQL = "SELECT dwgid, pid,album_id, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$parent_id." order by dwgid";
}
						 
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
                          <td ><?php echo $pdData['dwg_no'];?></td>
						  <td ><?php echo $pdData['dwg_title'];?></td>
                          <td ><?php echo $pdData['dwg_type'];?></td>
						  <td ><?php echo $pdData['dwg_date'];?></td>
						  <td ><?php echo $pdData['revision_no'];?></td>
						  <td >
					<?php
			 		if($pdData['dwg_status']=='1')
					{
					echo "Initiated";
					} 
					else if($pdData['dwg_status']=='2')
					{
					echo "Approved";
					}
					else if($pdData['dwg_status']=='3')
					{
					echo  "Not Approved";
					}
					else if($pdData['dwg_status']=='4')
					{
					echo "Under Review";
					}
					else if($pdData['dwg_status']=='5')
					{
					echo "Response Awaited";
					}
					else if($pdData['dwg_status']=='7')
					{
					echo "Responded";
					}?>
					</td>	  
					
						  <td align="left"><a href="./drawings/<?php echo $pdData["al_file"];?>" target="_blank"><img src="./images/file.png"  width="50" height="50" title="<?php echo $pdData["al_file"];?>"/></a></td>
						  
						   <?php  if($drawentry_flag==1 || $drawadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:left; vertical-align:middle;  text-align:center; margin-top:15px; margin-left:15px">
						   <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('sp_drawing_album_input.php?dwgid=<?php echo $pdData['dwgid']; ?>&album_id=<?php echo $pdData['album_id']; ?>', 'Manage drawings ','width=770px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style=" text-decoration:none">Edit</a>
						   </span>
						   
						   </td>
						   <?php  
							}
							if($drawadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right; margin-top:15px; margin-right:10px">
						   <a class="SubmitButton"  href="dm_drawingmap.php?dwgid=<?php echo $pdData['dwgid'] ?>&album_id=<?php echo $pdData['album_id']; ?>&act=delete"  style=" text-decoration:none">Delete</a>
						   
						   </span>
						   </td>
						   <?php
						   }
						   ?>
                       
						
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="9" ><?php echo NO_RECORD;?></td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
   
   
   
   

  </td></tr>
  
  </table>
  <div style="clear:both; margin-top:10px"></div>
  
<?php }
else
{?>
<div style="border:1px solid #ccc; border-radius:6px; vertical-align:top; margin:5px 0px 0px 5px; padding:5px 0px 0px 5px; ">
  <table width="100%" style="margin:0px; border:0px; padding:0px">
			<tbody><tr>
			<td width="90%" valign="top" style="margin:0px; border:0px; padding:0px">
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT albumid, parent_id,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and status=1 and parent_id=".$parent_id." order by albumid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				$album_id=$result[albumid];
				$pdSQL_r = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." limit 0,1";
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
 <!--    <a  href="javascript:void(null);" onclick="window.open('sp_photo.php?album_id=<?php echo $result['albumid'];?>', 'Manage Albums ','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none" >-->
	    <a  href="dm_drawingmap.php?album_id=<?php echo $result['albumid'];?>" >
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
		</div>
		
	<?php }?>
  </td></tr>
  
  </table></div></td></tr>
  
  </table>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
