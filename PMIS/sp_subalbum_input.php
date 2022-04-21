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
$defaultLang = 'en';
$user_cd=$uid;

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
$file_path="photos/";
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
 $aid=$_REQUEST['cat_id'];
 $pdSQL2 = "SELECT user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$aid;
$pdSQLResult2 = mysql_query($pdSQL2);

$result2 = mysql_fetch_array($pdSQLResult2);
$result2['user_right'];
if($_SESSION['ne_user_type']==1)
			{
			}
			else
			{
				$u_rightr=$result2['user_right'];
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
				
			}
				}
			}




if(isset($_REQUEST['delete'])&&isset($_REQUEST['albumid'])&$_REQUEST['albumid']!=""){
				 $category_cd_c = $_GET['albumid'];
				$cat_id = $_GET['cat_id'];
				
			   $sql2c="Select * from t031project_albums where parent_album=$category_cd_c";
				$res2c=mysql_query($sql2c);
				if(mysql_num_rows($res2c)>=1)
				{
					
					$message=  "<span style='color:red;'>You should delete its sub folders(s) first</span>";
					$activity=$category_cd_c." - You should delete its sub album(s) firstt";
				
				}
				else
				{
				
			
				
				
			 $sql2t="Select * from t027project_photos where album_id=$category_cd_c";
				$res2t=mysql_query($sql2t);
				
				$row2d=mysql_fetch_array($res2t);
					if(mysql_num_rows($res2t)>=1)
					{
						$message=  "<span style='color:red;'>You should delete its Photos first</span>";
						 $activity=$category_cd_c." - You should delete its Photos first";
										
					}
					else
					{
					 $sdeletet= "Delete from t031project_albums where albumid=$category_cd_c";
					   mysql_query($sdeletet);
						
						 $message=  "<span style='color:green;'>album deleted successfully</span>";
						 $activity=$category_cd_c." - album deleted successfully";
					
					}				
				
				
				}
	
	$log_id = $_SESSION['log_id'];
	echo $message;
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);

}





if(isset($_REQUEST['albumid']))
{
$albumid=$_REQUEST['albumid'];
$pdSQL1="SELECT albumid, pid, album_name, status, parent_album FROM t031project_albums  WHERE pid= ".$pid." and  albumid = ".$albumid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$status=$pdData1['status'];
$album_name=$pdData1['album_name'];
$parent_album=$pdData1['parent_album'];
}
if(isset($_REQUEST['save']))
{ 
     $album_name=$_REQUEST['album_name'];
	 $status=$_REQUEST['status'];
	 
	 
	 $created_by	= $_SESSION['ne_fullname_name'];
	 $userid_owner	= $uid;
	
	$datt=date('Y-m-d H:i:s');
	$creater=$created_by." ".$datt;
	$last_modified_by="";
	 
	 $parent_album=$_REQUEST['parent_album'];
	if($_SESSION['ne_user_type']==1)
	{
	}
	else
	{
	$user_rs=$uid."_".$read_right;		
	$user_ids=$uid;
	}
	
$sql_pro1="INSERT INTO t031project_albums(pid, album_name, status,user_ids, user_right,parent_album, creater, creater_id,last_modified_by) Values(".$pid.", '".$album_name."', ".$status.",'".$user_ids."','".$user_rs."', '".$parent_album."' , '".$creater."', ".$userid_owner.", '".$last_modified_by."')";
	$sql_pro=mysql_query($sql_pro1);
	$album_id=mysql_insert_id();
	if($parent_album==0)
		{
		//$parent_group=$category_cd;
			if(strlen($album_id)==1)
			{
			$parent_group="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$parent_group="0".$album_id;
			}
			else
			{
			$parent_group=$album_id;
			}
		}
	else
	{
		$parent_group1=$parent_album."_".$album_id;
		$sql="select parent_group from t031project_albums where albumid='$parent_album'";
		$sqlrw=mysql_query($sql);
		$sqlrw1=mysql_fetch_array($sqlrw);
		
		if(strlen($album_id)==1)
			{
			$category_cd_pg="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$category_cd_pg="0".$album_id;
			}
			else
			{
			$category_cd_pg=$album_id;
			}
		
		$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
	}
	
	$sql_pro="UPDATE t031project_albums SET parent_group='$parent_group' where albumid=$album_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	$activity=  $album_id." - New Album added successfully";
	} else {
    $message= mysql_error($db);
	$activity= mysql_error($db);
	}
	
	$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	
	$album_name="";
	
}

if(isset($_REQUEST['update']))
{
$album_name=$_REQUEST['album_name'];
$status=$_REQUEST['status'];
 $parent_album=$_REQUEST['parent_album'];
 $created_by	= $_SESSION['ne_fullname_name'];
	 $userid_owner	= $uid;
	
	$datt=date('Y-m-d H:i:s');
	
	$last_modified_by=$created_by." ".$datt;
 
 if($parent_album==0)
		{
		//$parent_group=$category_cd;
			if(strlen($album_id)==1)
			{
			$parent_group="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$parent_group="0".$album_id;
			}
			else
			{
			$parent_group=$album_id;
			}
		}
	else
	{
		$parent_group1=$parent_album."_".$album_id;
		$sql="select parent_group from t031project_albums where albumid='$parent_album'";
		$sqlrw=mysql_query($sql);
		$sqlrw1=mysql_fetch_array($sqlrw);
		
		if(strlen($album_id)==1)
			{
			$category_cd_pg="00".$album_id;
			}
			else if(strlen($album_id)==2)
			{
			$category_cd_pg="0".$album_id;
			}
			else
			{
			$category_cd_pg=$album_id;
			}
		
		$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
	}
$sql_pro="UPDATE t031project_albums SET album_name='$album_name',status='$status', parent_album='$parent_album', creater_id=$userid_owner, last_modified_by='$last_modified_by' where albumid=$albumid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $albumid." - Album updated successfully";
	} else {
		$message= mysql_error($db);
		$activity= mysql_error($db);
	}	
	$log_id = $_SESSION['log_id'];
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	$album_name="";

}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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

/*li {
    list-style: outside none none;
}*/

.img-frame-gallery {
    background: rgba(0, 0, 0, 0) url("frame.png") no-repeat scroll 0 0;
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

function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
   
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
function required(){
	var x = document.forms["form1"]["album_name"].value;
  if (x == "") {
    alert("Name must be filled out");
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
<script>
				
			window.onunload = function(){
  window.opener.location.reload();
};
function showParentAlbum(value)
{
	if(value==1)
	{
		document.getElementById("parentDiv").style.display="";
		document.getElementById("parentDiv").style.visibility="visible";
		
	}
	else
	{
		document.getElementById("parentDiv").style.display="none";
		document.getElementById("parentDiv").style.visibility="hidden";
		
	}
}
				</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
  <link href="css/style.css" rel="stylesheet" /> 
  </head>
  <body>
<div id="content" style="width:650px; background-color:#E0E0E0">
<!--<h1> Pictorial Analysis Control Panel</h1>-->

<table align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo MAN_ALBM;?></span><!--<span style="float:right">
    <form action="analysis.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span>--></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $flag;?>
  <?php echo $message; ?>
   <div id="LoginBox" class="borderRound borderShadow" >
   <!--action="sp_subalbum_input.php?cat_id=<?php echo $aid;?>"-->
  <form name="form1" action="sp_subalbum_input.php?cat_id=<?php echo $aid;?>" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required()">
  <input type="hidden" name="parent_album" id="parent_album" value="<?php echo $aid;?>" />
   <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo ALBUM_NAME;?>:</label></td>
  <td><input  type="text" name="album_name" id="album_name" value="<?php echo $album_name;?>"   size="100"/>
</td>
  </tr>
  
 
   
  
  <?php if(!isset($status))
  {
  $status=1;
  } ?>
   <tr><td><label><?php echo STATUS;?>;</label></td>
  <td><input  type="radio" name="status" value="1" <?php if($status==1){ echo "checked";} ?>/><?php echo ACTIVE?>
  <input  type="radio" name="status"   value="0" <?php if($status==0){ echo "checked";} ?> /><?php echo INACTIVE?>
</td>
  </tr>
  
  <tr><td colspan="2" align="center"> <?php if(isset($_REQUEST['albumid']))
	 {
		 
	 ?>
     <input type="hidden" name="albumid" id="albumid" value="<?php echo $_REQUEST['albumid']; ?>" />
     <input  type="submit" name="update" id="update" value="<?php echo UPDATE;?>" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />
	 <?php
	 }  
	 ?> 
     
     <input  type="button" name="cancel" id="cancel" value="<?php echo CANCEL?>"   onclick="cancelButton();"/></td></tr>
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
                                  <th width="5%" style="text-align:center; vertical-align:middle">#</th>
                                  <th width="40%" style="text-align:center"><?php echo ALBUM_NAME;?></th>
                                  <th width="20%" style="text-align:center"><?php echo STATUS;?></th>
								
								
								  <th width="25%" style="text-align:center"><?php echo ACTION;?></th>
								
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
						 $pdSQL = "SELECT albumid,parent_group, pid, album_name,user_right, status FROM t031project_albums  WHERE pid= ".$pid." and parent_album=".$aid."   order by albumid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=1;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  
							  $p_group=$pdData['parent_group'];
				$arr_gp=explode("_", $p_group);
				$get_album_id=$arr_gp[1];
				 $pdSQL_get_right = "SELECT user_ids,user_right FROM t031project_albums  WHERE pid= ".$pid." and status=1 and albumid=".$get_album_id;
			 $pdSQLResult_get_right = mysql_query($pdSQL_get_right);
			 $result_get_right = mysql_fetch_array($pdSQLResult_get_right);
							  
							
							  if($_SESSION['ne_user_type']==1)
			{
				
							  ?>
                              
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['album_name'];?></td>
                          <td align="center">  <?php if($pdData['status']==1)
						  {
						  echo ACTIVE;
						  }
						  else
						  {
						  echo INACTIVE;
						  }?></td>
                       
						  
						   <td align="right"><span style="float:left"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   
						   <span style="float:right"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this album and its photos?')" /></form></span>
						   
						  </td>
                        </tr>
						<?php
				 $i++;		
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
                            <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['album_name'];?></td>
                          <td align="center">  <?php if($pdData['status']==1)
						  {
						  echo ACTIVE;
						  }
						  else
						  {
						  echo INACTIVE;
						  }?></td>
                       
						  <?php  if($read_right==1 || $read_right==3)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						    <?php  
							}
							if($read_right==3)
								  {
								   ?>
						   <span style="float:right"><form action="sp_subalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&cat_id=<?php echo $aid ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this album and its photos?')" /></form></span>
						   
						   <?php
						   }
						   ?></td>
                        </tr>
                            <?php
						 $i++;
						}
				}
				 
			}
						
						
						
						
						}
							  }else
						{
						?>
						<tr>
                          <td colspan="4" ><?php echo NO_RECORD;?></td>
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
































