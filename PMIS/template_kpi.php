<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "KPI Template";

if ($uname==null  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$kpi_temp_title				= mysql_real_escape_string($_REQUEST['kpi_temp_title']);
$kpi_temp_desc				= mysql_real_escape_string($_REQUEST['kpi_temp_desc']);
$is_default_temp				= 1;
$is_active				        = $_REQUEST['is_active'];
$is_eva				            = 0;
if($is_default_temp==1)
{
$btem="Select * from baseline_template where temp_is_default=1";
			  $resbtemp=mysql_query($btem);
			  $row3tmpgb=mysql_fetch_array($resbtemp);
			 
			  $temp_id					= $row3tmpgb["temp_id"];
}
else
{
$temp_id					=1;
}
$temp_id					=1;
if($saveBtn != "")
{
$parentcd=0;	
if($is_active==1)
{
	 $uSql1 = "Update kpi_templates SET 
			 is_active=0 ";
		$objDb->execute($uSql1);	  
 	
}
$sSQL = ("INSERT INTO kpi_templates (kpi_temp_title, kpi_temp_desc, is_default_temp, temp_id, is_active,is_eva) VALUES 
('$kpi_temp_title', '$kpi_temp_desc','$is_default_temp','$temp_id', '$is_active', '$is_eva')");
	$objDb->execute($sSQL);
	
	
	
	$msg="Saved!";
	
		/*print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>"; */ 
 
}

if($updateBtn !=""){
	
	if($is_active==1)
{
	$uSql1 = "Update kpi_templates SET 
			 is_active=0 ";
		$objDb->execute($uSql1);
}
 $uSql = "Update kpi_templates SET 
			
			 kpi_temp_title         	= '$kpi_temp_title',
			 kpi_temp_desc   			= '$kpi_temp_desc',
			 is_default_temp			= $is_default_temp,
			 temp_id					= $temp_id,
			 is_active					= $is_active,
			 is_eva						= $is_eva
			where kpi_temp_id 			= $edit";
		$objDb->execute($uSql);	  
 		
	$msg="Updated!";
	
		
	
		print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}
if(isset($_REQUEST['delete']))
{
 mysql_query("Delete from kpi_templates where kpi_temp_id=".$_REQUEST['delete']);
 $msg="Deleted!";
 //header("Location:template_kpi.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.opener.location.reload();";
    print "self.close();";
    print "</script>";
}

if($edit != ""){
 $eSql = "Select * from kpi_templates where kpi_temp_id='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $kpi_temp_id 					= $objDb->getField($i,kpi_temp_id);
	  $kpi_temp_title 				= $objDb->getField($i,kpi_temp_title);
	  $kpi_temp_desc 				= $objDb->getField($i,kpi_temp_desc);
	  $temp_id 					    = $objDb->getField($i,temp_id);
	  $is_default_temp 				= $objDb->getField($i,is_default_temp);
	  $is_active 						= $objDb->getField($i,is_active);
	  $is_eva 						= $objDb->getField($i,is_eva);
	 	
	}
}

?>
<script>
window.onunload = function(){
window.opener.location.reload();
};
				</script>
<?php /*?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?><?php */?>
<!doctype html>
<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script>
function GetTemplate(temp_id)
{

	var chck=false;
	if(temp_id==0)
	{
	chck=confirm('Are you sure to change Default Template?');
	}
	else
	{
		chck=confirm('Are you sure to Select Default Template?');
	}
	if(chck==true)
	{
	 document.getElementById("default_temp_div").setAttribute("style","opacity:1;");
	
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("default_temp_div").innerHTML=xmlhttp4.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
  xmlhttp4.open("GET","get_templatelist.php?temp_is_default="+temp_id,true);
  xmlhttp4.send();
  
	}
	}
	
function GetDefaultTemplate(temp_id)
{
	
	
	var radList = document.getElementsByName("temp_is_default");

  
	 

		  for (var i = 0; i < radList.length; i++) {
      if(radList[i].checked) document.getElementById(radList[i].id).checked = false;
    }
		 document.getElementById("temp"+temp_id).checked = true;
		
}
</script>

</head>
<body>

<div style="color:green; font-size:12px; font-weight:bold; margin-left:20px; margin-top:10px;"><?php echo $msg; ?></div>
<div class="form-style-2" style="float:left; width:100%">
<?php
			if(isset($_REQUEST['edit']))
			{
			$action="Update ";
			}
			else
			{
			$action="Add ";
			}
			?>
<div class="form-style-2-heading" style="color:#FF9900;"><?php echo $action.$module; ?></div>
<form name="frmstgoal" id="frmstgoal" action=""  method="post" onSubmit="return validateform()" enctype="multipart/form-data">
<input id="kpi_temp_id" name="kpi_temp_id" type="hidden" value="<?php echo $kpi_temp_id; ?>">
<label for="field1"><span>KPI Template Name: <span class="required">*</span></span><input  class="input-field" id="kpi_temp_title" name="kpi_temp_title" type="text" value="<?php echo $kpi_temp_title; ?>" /></label>
<label for="field2"><span>KPI Template Description: <span class="required">*</span></span><textarea id="kpi_temp_desc" name="kpi_temp_desc" class="input-field"><?php echo $kpi_temp_desc; ?></textarea></label>

<?php if(!isset($is_active))
{
$is_active=0;
}?>
<label for="field2"><span>KPI Template Is Active?<span class="required">*</span></span>Yes <input type="radio" id="is_active" name="is_active"  value="1"  <?php if($is_active==1){?> checked="checked" <?php }?>/>  No <input type="radio" id="is_active" name="is_active"  value="0" <?php if($is_active==0){?> checked="checked" <?php }?> /></label>

 <?php
			  if($edit!=""){?>
			  <label><span> </span><input type="submit" name="update" id="resetbtn"  value="Update"></label>
			
			<?php } else { ?>
			<label><span> </span><input type="submit" name="save" id="submitbtn"   value="Save">
			&nbsp;&nbsp;<input type="submit" value="Cancel" name="cancel"  /></label>
			
			 <?php } ?>

</form>
</div>

<div id="content">
<table class="reference"  style="width:100%; font-size:12px" >
                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC; vertical-align:middle">
                  <th align="center" width="2%"><strong>#</strong></th>
                  <th align="center" width="30%"><strong>KPI Template Name </strong></th>
                  <th width="23%"><strong>KPI Template Description</strong></th>
                 
				  <th width="5%"><strong>Status</strong></th>
                  <th align="center" width="10%"><strong>Action </strong></th>
                  <?php /*?> <th align="center" width="10%"><strong>Log </strong></th><?php */?>
                </tr>
             
                <?php

 $sSQL = " Select * from kpi_templates";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $kpi_temp_id 					= $objDb->getField($i,kpi_temp_id);
	  $kpi_temp_title 				= $objDb->getField($i,kpi_temp_title);
	  $kpi_temp_desc 				= $objDb->getField($i,kpi_temp_desc);
	  $temp_id 					    = $objDb->getField($i,temp_id);
	  $is_default_temp 				= $objDb->getField($i,is_default_temp);
	  $is_active 						= $objDb->getField($i,is_active);
	  
	  if($is_active==1)
	  {
	  $status="Active";
	  }
	  else
	  {
	  $status="Inactive";
	  }
	  
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}


$sSQL1 = " Select * from baseline_template where temp_id=".$temp_id ;
 $ssq=mysql_query($sSQL1);
 $kpi_ss=mysql_fetch_array($ssq);
 


?>
               
                <tr <?php echo $style; ?>>
                  <td width="5px"><center>
                    <?php echo $i+1;?>
                  </center></td>
                 
                  <td><?php echo $kpi_temp_title;?></td>
                  <td><?php echo $kpi_temp_desc;?></td>
                  
				   <td  align="right"><?php echo $status;?></td>
                  <td style="border-bottom:1px solid #cccccc"  >&nbsp;
                    <?php  if($resentry_flag==1 || $resadm_flag==1)
	{
	?>
                    <a href="template_kpi.php?edit=<?php echo $kpi_temp_id;?>"  >Edit</a>
                    <?php } ?>
                    <?php  if($resadm_flag==1)
	{
	?>
                    | <a href="template_kpi.php?delete=<?php echo $kpi_temp_id;?>"  onclick="return confirm('Are you sure you want to delete this Template?')" >Delete</a>
                  <?php
  }
  ?></td>
                 
                </tr>
                <?php        
	}
	}
?>
              </table>
</div>


</body>
</html>
<?php
	$objDb  -> close( );
?>
