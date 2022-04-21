<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Manage Drawing Albums";

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
if(isset($_REQUEST['delete'])&&isset($_REQUEST['albumid'])&$_REQUEST['albumid']!="")
{
$albumid=$_REQUEST['albumid'];
$pdSQL1="SELECT dwgid, pid, dwg_no, dwg_title, dwg_date,	revision_no, dwg_status, al_file FROM t027project_drawings  WHERE pid= ".$pid." and album_id= ".$albumid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
while($pdData1 = mysql_fetch_array($pdSQLResult1))
{
@unlink($file_path.$pdData1['al_file']);
 mysql_query("Delete from t027project_drawings where dwgid=".$pdData1['dwgid']." and album_id=".$albumid);
}
 mysql_query("Delete from t031project_drawingalbums where albumid=".$_REQUEST['albumid']);
  $message=  "<span style='color:green;'>album and all its photos deleted successfully</span>";
   header("Location: sp_drawingalbum_input.php");
}
if(isset($_REQUEST['parent_id']))
{
$parent_id=$_REQUEST['parent_id'];
}
else
{
 $parent_id=0;
}

if(isset($_REQUEST['albumid']))
{
$albumid=$_REQUEST['albumid'];
$pdSQL1="SELECT albumid, pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and  albumid = ".$albumid." and parent_id=".$parent_id;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);
$status=$pdData1['status'];
$album_name=$pdData1['album_name'];
}

if(isset($_REQUEST['save']))
{ 
 
	$album_name=$_REQUEST['album_name'];
	$status=$_REQUEST['status'];
	$sql_pro=mysql_query("INSERT INTO t031project_drawingalbums(parent_id,pid, album_name, status) Values( ".$parent_id.", ".$pid.",'".$album_name."', ".$status.")");
	$albmid=mysql_insert_id();
	if($parent_id==0)
		{
		//$parent_group=$category_cd;
			if(strlen($albmid)==1)
			{
			$parent_group="00".$albmid;
			}
			else if(strlen($albmid)==2)
			{
			$parent_group="0".$albmid;
			}
			else
			{
			$parent_group=$albmid;
			}
		}
		else
		{
		$parent_group1=$parent_id."_".$albmid;
		$sql="select parent_group from t031project_drawingalbums where albumid='$parent_id'";
		$sqlrw=mysql_query($sql);
		$sqlrw1=mysql_fetch_array($sqlrw);
		
		if(strlen($albmid)==1)
			{
			$category_cd_pg="00".$albmid;
			}
			else if(strlen($albmid)==2)
			{
			$category_cd_pg="0".$albmid;
			}
			else
			{
			$category_cd_pg=$albmid;
			}
		
		echo $parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
		
		}
		$sql_pro="UPDATE t031project_drawingalbums SET parent_group='$parent_group' where albumid=$albmid and parent_id=$parent_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
header("Location: sp_drawingalbum_input.php?parent_id=".$parent_id);	
	
}

if(isset($_REQUEST['update']))
{
$album_name=$_REQUEST['album_name'];
$status=$_REQUEST['status'];
$sql_pro="UPDATE t031project_drawingalbums SET album_name='$album_name',status='$status' where albumid=$albumid and parent_id=$parent_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}	
	
header("Location: sp_drawingalbum_input.php?parent_id=".$parent_id);
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}
?>

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


<script>
				
			window.onunload = function(){
  window.opener.location.reload();
};
				</script>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
  <link href="css/style.css" rel="stylesheet" /> 
<div id="content" style="width:650px; background-color:#E0E0E0">
<!--<h1> Pictorial Analysis Control Panel</h1>-->
<table align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Manage Drawing Folders </span><!--<span style="float:right">
    <form action="analysis.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span>--></td>
  </tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
   <div id="LoginBox" class="borderRound borderShadow" >
  <form action="sp_drawingalbum_input.php" target="_self" method="post"  enctype="multipart/form-data">
  <input  type="hidden" name="parent_id" id="parent_id" value="<?php echo $parent_id;?>"   size="100"/>
   <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo "Drawing Folder Name:";?></label></td>
  <td><input  type="text" name="album_name" id="album_name" value="<?php echo $album_name;?>"   size="100"/>
</td>
  </tr>
  <?php if(!isset($status))
  {
  $status=1;
  } ?>
   <tr><td><label><?php echo "Status:";?></label></td>
  <td><input  type="radio" name="status" value="1" <?php if($status==1){ echo "checked";} ?>/>Active
  <input  type="radio" name="status"   value="0" <?php if($status==0){ echo "checked";} ?> />Inactive
</td>
  </tr>
  
  <tr><td colspan="2" align="center"> <?php if(isset($_REQUEST['albumid']))
	 {
		 
	 ?>
     <input type="hidden" name="albumid" id="albumid" value="<?php echo $_REQUEST['albumid']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel"  /></td></tr>
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
                                  <th width="40%" style="text-align:center">Folder Name</th>
                                  <th width="20%" style="text-align:center">Status</th>
								
								  <?php  if($drawentry_flag==1 || $drawadm_flag==1)
								  {
								   ?>
								  <th width="25%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
						$pdSQL = "SELECT albumid, parent_id,pid, album_name, status FROM t031project_drawingalbums  WHERE pid= ".$pid." and parent_id=".$parent_id." order by albumid";
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
                          <td align="center"><?php echo $pdData['album_name'];?></td>
                          <td align="center">  <?php if($pdData['status']==1)
						  {
						  echo "Active";
						  }
						  else
						  {
						  echo "Inactive";
						  }?></td>
                       
						  <?php  if($drawentry_flag==1 || $drawadm_flag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_drawingalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>&parent_id=<?php echo $pdData['parent_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span>
						    <?php  
							}
							if($drawadm_flag==1)
								  {
								   ?>
						   <span style="float:right"><form action="sp_drawingalbum_input.php?albumid=<?php echo $pdData['albumid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure, you want to delete this folder and its drawings?')" /></form></span>
						   
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