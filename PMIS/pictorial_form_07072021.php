<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Photos";
if ($uname==null  ) {
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
$msg						= "";

$file_path="pictorial_data/";
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
 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
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

@unlink($file_path."/". $al_file);
//@unlink($file_path."/thumb/" . $al_file);
 mysql_query("Delete from  project_photos where phid=".$_REQUEST['phid']);
  $activity=$ph_cap. " - Pictorial Analysis Photo Deleted Successfully";
$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
 header("Location: pictorial_form.php");
}
$size=50;
$max_size=($size * 1024 * 1024);
if(isset($_REQUEST['save']))
{ 
    $ph_cap=$_REQUEST['ph_cap'];
	$date_p=date("Y-m-d",strtotime($_REQUEST['date_p']));
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
	//echo $name_array = $_FILES['al_file']['name'];
	if(($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	///create thumbnail
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($extension){
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
            switch($extension){
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
	
	 $check_query="SELECT * from project_photos where ph_cap=".$ph_cap." AND date_p='".$date_p."'";
	$check_res=mysql_query($check_query);
	 $check_row=mysql_num_rows($check_res);
	if($check_row>0)
	{
	 $message=  "<b>Photo Already Exist for this Date & Location</b>";	
	}
	else
	{
	$sql_pro=mysql_query("INSERT INTO  project_photos(pid, al_file,ph_cap,date_p) 
	Values(".$pid.", '".$file_name."', '".$ph_cap."', '".$date_p."' )");
	if ($sql_pro == TRUE) {
    $message=  "<b>New record added successfully</b>";
	$activity=$ph_cap." - New photo for pictorial analysis added successfully";
	} else {
    $message= mysql_error($db);
	$activity= mysql_error($db);
	}
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	}
	}
	
	
	$al_file='';
	
	//header("Location: pictorial_form.php");
	
}

if(isset($_REQUEST['update']))
{
$ph_cap=$_REQUEST['ph_cap'];
$pdSQL = "SELECT a.phid, a.pid, a.al_file,a.date_p FROM  project_photos a WHERE a.pid = ".$pid." and a.phid=".$phid." order by phid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
//$date_p=$pdData["date_p"];
$phid=$_REQUEST['phid'];
$old_al_file= $pdData["al_file"];
$date_p=date("Y-m-d",strtotime($_REQUEST['date_p']));
		if($old_al_file){
			if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
			{			
				@unlink($file_path."/". $old_al_file);
				//@unlink($file_path."/thumb/" . $old_al_file);
			}
					
				}
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
		$extension=getExtention($_FILES["al_file"]["type"]);
		$file_name=genRandom(5)."-".$pid;
  
	if(
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	
	$thumb=TRUE;
	$thumb_width='150';
		if($thumb == TRUE)
        {
		
          	$thumbnail = $file_path."thumb/".$file_name;
            list($width,$height) = getimagesize($target_file);
			$thumb_height = ($thumb_width/$width) * $height;
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($extension){
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
            switch($extension){
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
	
    $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap', al_file='$file_name' ,date_p='$date_p' where phid=$phid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	}
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $ph_cap." - Pictorial Analysis Photo updated successfully";
	} else {
		$message= mysql_error($db);
		$activity= mysql_error($db);
	}
	
	}
	else
	{
	echo "Invalid File Format";
	}
	}
	else
	{
	 $sql_pro="UPDATE  project_photos SET ph_cap='$ph_cap',date_p='$date_p' where phid=$phid";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
		$activity=  $ph_cap." - Pictorial Analysis Photo updated successfully";
	} else {
		$message= mysql_error($db);
		$activity= mysql_error($db);
	}
	$iSQL = ("INSERT INTO pages_visit_log (log_id,request_url) VALUES ('$log_id','$activity')");
mysql_query($iSQL);
	}
header("Location: pictorial_form.php");
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
<script>
window.onunload = function(){
window.opener.location.reload();
};
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>
<script type="text/javascript">
	
   $(function() {
    $( "#date_p" ).datepicker();
  });

</script>
  <script>
  function required(){
	
	var x =document.getElementById("ph_cap").value;
	
	
	 if (x == 0) {
    alert("Select Location First");
    return false;
  		}
		
  
  }
  
  function cancelButton()
{
 window.opener.location.reload();
 self.close();
}
  </script>
</head>
<body>
<div id="content" style="width:650px; background-color:#E0E0E0">
<!--<h1> Pictorial Analysis Control Panel</h1>-->
<table align="center">
  <tr >
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span><?php echo PHOTO_VIDEO;?></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <div id="LoginBox" class="borderRound borderShadow" >
  <form action="pictorial_form.php" target="_self" method="post"  enctype="multipart/form-data" onsubmit="return required();">
  <?php if(isset($_REQUEST['phid'])&&$_REQUEST['phid']!="")
         {$ppdSQL = "SELECT a.phid, a.pid, a.al_file,a.date_p FROM  project_photos a WHERE a.pid = ".$pid." and a.phid=".$_REQUEST['phid']." order by phid";
		$ppdSQLResult = mysql_query($ppdSQL);
		$sql_num=mysql_num_rows($ppdSQLResult);
		$ppdData = mysql_fetch_array($ppdSQLResult);
		$date_p=$ppdData["date_p"];
		 }
?>
  <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo LOCATION;?>:</label></td>
  <td><select id="ph_cap" name="ph_cap">
     <option value="0"><?php echo PIC_LOCATION; ?></option>
  		<?php $pdSQL = "SELECT lid, pid, title, user_right, user_ids FROM  locations WHERE pid=".$pid." order by lid";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  if($_SESSION['ne_user_type']==1)
							{?>
  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
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
							if($read_right==1 || $read_right==3)
								  {	
								  ?>
                                  <option value="<?php echo $pdData["lid"];?>" <?php if($ph_cap==$pdData["lid"]) {?> selected="selected" <?php }?>><?php echo $pdData["title"];?></option>
                                  <?php
								  }
						}
				}
							
	   
   }} 
   }?>
  </select> &nbsp;
  <?php if($_SESSION['ne_user_type']==1)
							{
								?>
    <a class="SubmitButton"  href="javascript:void(null);" onclick="window.open('location_form.php', '<?php echo PLOAD_PHOTO_BTN;?>','width=470px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');"  style="margin:5px; text-decoration:none"><?php echo ADD_LOC;?></a>
  <?php
							}
							?></td>
  </tr>
  <tr><td><label><?php echo DATE;?>:</label></td>
  <td><input type="text" name="date_p" id="date_p" value="<?php 
  if(isset($date_p)&&$date_p!=""&&$$date_p!="0000-00-00"&&$date_p!="1970-01-01")
						  {
							  echo date('d-m-Y',strtotime($date_p));
						  }?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo PHOTO;?>:</label></td>
  <td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
  <tr><td colspan="2"> <?php if(isset($_REQUEST['phid']))
	 {
		 
	 ?>
     <input type="hidden" name="phid" id="phid" value="<?php echo $_REQUEST['phid']; ?>" />
     <input  type="submit" name="update" id="update" value="<?php echo UPDATE;?>" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="<?php echo SAVE;?>" />
	 <?php
	 }
	 ?>  <input  type="button" name="cancel" id="cancel" value="<?php echo CANCEL?>"   onclick="cancelButton();"/></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
  <table style="width:100%">
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table class="reference" style="width:100%" > 

    
                              <thead>
                                   <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th  style="text-align:center; vertical-align:middle">#</th>
                                  <th  width="50%" style="text-align:left"><?php echo LOCATION;?></th>
                                  <th  style="text-align:center"><?php echo PHOTO;?></th>
								 <th  style="text-align:left"><?php echo DATE;?></th>
								  <th  style="text-align:center"><?php echo ACTION;?></th>
								
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						$pdSQL = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title,b.user_ids, b.user_right FROM  project_photos a inner join locations b 
						on(a.ph_cap=b.lid) WHERE a.pid=".$pid." order by phid";
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
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path."/thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                       
						   <td align="right">
                           <span style="float:left">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form>
                           </span>
                           <span style="float:right">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo 'Are you sure, you want to delete this photo';?>')" /></form>
						   
						   </span></td>
                        </tr>
						<?php
			}
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
                            <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData['title'];?></td>
                          <td align="center"><img src="<?php echo $file_path."/thumb/".$pdData["al_file"];?>"  width="50" height="50"/></td>
                          <td align="left"><?php 
						  if(isset($pdData["date_p"])&&$pdData["date_p"]!=""&&$pdData["date_p"]!="0000-00-00"&&$pdData["date_p"]!="1970-01-01")
						  {
							   echo date('d-m-Y',strtotime($pdData["date_p"]));
						  }?></td>
                          <td align="right">
                          <?php  if($read_right==1 || $read_right==3)
								  {
								   ?>
                           <span style="float:left">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form>
                           </span>
                           <?php
								  }
								  ?>
                                  <?php  if($read_right==3)
								  {
								   ?>
                           <span style="float:right">
                           <form action="pictorial_form.php?phid=<?php echo $pdData['phid'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="<?php echo DEL;?>" onclick="return confirm('<?php echo DEL;?>')" /></form>
						   
						   </span>
                           <?php
								  }
								  ?></td>
                       
						   
                        </tr>
                            <?php
						}
				}
							
			}
						}
						}else
						{
						?>
						<tr>
                          <td colspan="6" ><?php echo NO_RECORD;?></td>
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
<?php
	$objDb  -> close( );
?>
