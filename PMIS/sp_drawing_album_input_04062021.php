<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Drawings";

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($draw_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$file_path="drawings/";
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
if(isset($_REQUEST['dwgid']))
{
$dwgid=$_REQUEST['dwgid'];
$pdSQL1="SELECT dwgid, pid, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings  WHERE pid= ".$pid." and album_id= ".$album_id." and  dwgid = ".$dwgid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$al_file=$pdData1['al_file'];
 $dwg_type=$pdData1['dwg_type'];
 $dwg_no=$pdData1['dwg_no'];
	$dwg_title=$pdData1['dwg_title'];
	$dwg_date=$pdData1['dwg_date'];
	$revision_no=$pdData1['revision_no'];
	$dwg_status=$pdData1['dwg_status'];
}

/*$size=50;
$max_size=($size * 1024 * 1024);*/
if(isset($_REQUEST['save']))
{ 
	$dwg_type=$_REQUEST['dwg_type'];
    $dwg_no=$_REQUEST['dwg_no'];
	$dwg_title=mysql_real_escape_string(trim($_REQUEST['dwg_title']));
	$dwg_date=$_REQUEST['dwg_date'];
	$revision_no=$_REQUEST['revision_no'];
	$dwg_status=$_REQUEST['dwg_status'];
		//echo $name_array = $_FILES['al_file']['name'];
	if(isset($_FILES["al_file"]["name"])&&$_FILES["al_file"]["name"]!="")
	{
	$extension=getExtention($_FILES["al_file"]["type"]);
	$file_name=genRandom(5)."-".$pid. ".".$extension;
   
	if(($_FILES["al_file"]["type"] == "application/pdf")|| 
	($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
		
	 $sql_query="INSERT INTO t027project_drawings(pid, album_id, dwg_type,dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file) Values(".$pid.",".$album_id.", '".$dwg_type."', '".$dwg_no."', '".$dwg_title."', '".$dwg_date."', '".$revision_no."','".$dwg_status."', '".$file_name."')";
	$sql_pro=mysql_query($sql_query);
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
	}
	}
	}
	$al_file='';
	
	//header("Location: sp_drawing_album_input.php?album_id=$album_id");
	
}

if(isset($_REQUEST['update']))
{
	$dwg_type=$_REQUEST['dwg_type'];
	$dwg_no=$_REQUEST['dwg_no'];
	$dwg_title=mysql_real_escape_string(trim($_REQUEST['dwg_title']));
	$dwg_title=stripslashes($dwg_title);
	$dwg_date=$_REQUEST['dwg_date'];
	$revision_no=$_REQUEST['revision_no'];
	$dwg_status=$_REQUEST['dwg_status'];
$pdSQL = "SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." and dwgid=".$dwgid." order by dwgid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$dwgid=$_REQUEST['dwgid'];
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
  
	if(($_FILES["al_file"]["type"] == "application/pdf")|| 
	($_FILES["al_file"]["type"] == "application/msword") || 
	($_FILES["al_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["al_file"]["type"] == "text/plain") || 
	($_FILES["al_file"]["type"] == "image/jpg")|| 
	($_FILES["al_file"]["type"] == "image/jpeg")|| 
	($_FILES["al_file"]["type"] == "image/gif") || 
	($_FILES["al_file"]["type"] == "image/png"))
	{ 
	
	$target_file=$file_path.$file_name;
	if(move_uploaded_file($_FILES['al_file']['tmp_name'],$target_file))
	{
	
    $sql_pro="UPDATE t027project_drawings SET  dwg_type='$dwg_type',dwg_no='$dwg_no',dwg_title='$dwg_title',dwg_date='$dwg_date',revision_no='$revision_no',dwg_status='$dwg_status',al_file='$file_name' where dwgid=$dwgid and album_id=$album_id";
	
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
	 $sql_pro="UPDATE t027project_drawings SET  dwg_type='$dwg_type',dwg_no='$dwg_no',dwg_title='$dwg_title',dwg_date='$dwg_date',revision_no='$revision_no',dwg_status='$dwg_status' where dwgid=$dwgid and album_id=$album_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	}
header("Location: sp_drawing_album_input.php?album_id=$album_id");
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
<script type="text/javascript">
		 
 $(function() {
   $('#dwg_date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  


</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
   <link href="css/style.css" rel="stylesheet" /> 
<div id="content">
<table  align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Manage Drawings </span></td>
  </tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
   <div id="LoginBox" class="borderRound borderShadow" >
  <form action="sp_drawing_album_input.php?album_id=<?php echo $album_id; ?>" target="_self" method="post"  enctype="multipart/form-data">
    <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
	<?php
	$pdSQL6 = "SELECT album_name FROM t031project_drawingalbums  WHERE pid= ".$pid." and albumid=".$album_id;
	$pdSQLResult6 = mysql_query($pdSQL6);
	$pdData6 = mysql_fetch_array($pdSQLResult6);
	?>
	<tr><td><label><?php echo "Drawing Folder Name:";?></label></td>
  <td style="font-weight:bold"><?php echo $pdData6['album_name'];?></td>
  </tr>
  <tr><td><label><?php echo "Drawing Type:";?></label></td>
  <td ><select  name="dwg_type" id="dwg_type"  >
  <?php if(isset($dwg_type))
  {
	  $drawing_type=$dwg_type;
  }
  else
  {
	  $drawing_type="Design";
  }?>
  		<option value="Design" <?php if($drawing_type=='Design') echo "selected";?>>Design</option>
		 <option value="Survey" <?php if($drawing_type=='Survey') echo "selected";?>>Survey</option>
  		<option value="Others" <?php if($drawing_type=='Others') echo "selected";?>>Others</option>
		
</select></td></tr>
  <tr><td><label><?php echo "Drawing No:";?></label></td>
  <td><input type="text" name="dwg_no" id="dwg_no" value="<?php echo $dwg_no;?>"   size="100"/></td>
  </tr>
   <tr><td><label><?php echo "Drawing Title:";?></label></td>
  <td><input type="text" name="dwg_title" id="dwg_title" value="<?php echo $dwg_title;?>"   size="100"/> Please avoid special characters</td>
  </tr>
  <tr><td><label><?php echo "Drawing Date:";?></label></td>
  <td><input type="text" name="dwg_date" id="dwg_date" value="<?php echo $dwg_date;?>"   size="100"/> yyyy-mm-dd</td>
  </tr>
  <tr><td><label><?php echo "Revision No:";?></label></td>
  <td><input type="text" name="revision_no" id="revision_no" value="<?php echo $revision_no;?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo "Drawing Status:";?></label></td>
  <td>
  		<select name="dwg_status">
		 <option value="1" <?php if($dwg_status=='1')echo "selected";?>>Initiated</option>
  		<option value="2" <?php if($dwg_status=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($dwg_status=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($dwg_status=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($dwg_status=='5')echo "selected";?>>Response Awaited</option>
		  <option value="7" <?php if($dwg_status=='7')echo "selected";?>>Responded</option>
		</select>
 </td>
  </tr>
  <tr><td><label><?php echo "Upload File:";?></label></td>
  <td><input  type="file" name="al_file" id="al_file" value="<?php echo $al_file; ?>" /></td>
  </tr>
  
  <tr><td colspan="2" align="center"> <?php if(isset($_REQUEST['dwgid']))
	 {
		 
	 ?>
     <input type="hidden" name="dwgid" id="dwgid" value="<?php echo $_REQUEST['dwgid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel"/></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
  <?php /*?><table width="100%">
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table class="reference" style="width:100%" > 
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="15%" style="text-align:center">Drawing No.</th>
								  <th width="25%" style="text-align:center">Title</th>
								  <th width="10%" style="text-align:center">Drawing Date</th>
								   <th width="10%" style="text-align:center">Revision No.</th>
								  <th width="10%" style="text-align:center">Status</th>
                                  <th width="10%" style="text-align:center">File</th>
								
								  <?php if($drawentry_flag==1 || $drawadm_flag==1)
								  {
								   ?>
								  <th width="15%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						 $pdSQL = "SELECT dwgid, pid,album_id, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings WHERE pid = ".$pid." and album_id=".$album_id." order by dwgid";
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
                          <td align="center"><?php echo $pdData['dwg_no'];?></td>
						  <td align="center"><?php echo $pdData['dwg_title'];?></td>
						  <td align="center"><?php echo $pdData['dwg_date'];?></td>
						  <td align="center"><?php echo $pdData['revision_no'];?></td>
						  <td align="center"><?php echo $pdData['dwg_status'];?></td>
						  <td align="left"><a href="./drawings/<?php echo $pdData["al_file"];?>" target="_blank"><img src="./images/file.png"  width="50" height="50" title="<?php echo $pdData["al_file"];?>"/></a></td>
                       
						  <?php  if($drawentry_flag==1 || $drawadm_flag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_drawing_album_input.php?dwgid=<?php echo $pdData['dwgid']; ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						   <?php  
							}
							if($drawadm_flag==1)
								  {
								   ?>
						   <span style="float:right"><form action="sp_drawing_album_input.php?dwgid=<?php echo $pdData['dwgid'] ?>&album_id=<?php echo $pdData['album_id']; ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this Drawing?')" /></form></span>
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
                          <td colspan="8" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                        </div>
                        </td>
                        </tr>
  </table><?php */?>
</div>