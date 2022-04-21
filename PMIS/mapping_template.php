<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Template";
if ($uname==null  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
$objDbD  		= new Database( );
$objDbDD  		= new Database( );
$objDbI 		= new Database( );
$objDbII 		= new Database( );
$objDbU			= new Database( );
$objDbUI			= new Database( );
$objDbUII			= new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$delete						= $_REQUEST['delete'];
$txtstage				 	= "New Template";
$txtitemname				= $_REQUEST['txtitemname'];
$temp_desc					=$_REQUEST['temp_desc'];
$use_data					=$_REQUEST['use_data'];
$temp_is_default			=$_REQUEST['temp_is_default'];
$active_temp			=$_REQUEST['active_temp'];

if($clear!="")
{

$txtitemname 				= '';

}
if($delete!="")
{

$useSql = "DELETE from baseline_template where temp_id=$delete";
	   $objDbD -> query($useSql);
	   $sSQL = " Select * from baseline temp_id=$delete";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		 $rid 							= $objDb->getField($i,rid);
		$usedSql2 = "DELETE from baseline_mapping_boqs where rid=$rid";
	   $objDbDD -> query($usedSql2);
	}
 }
$usedSql1 = "DELETE from baseline where temp_id=$delete";
	   $objDbDD -> query($usedSql1);
	   
$usedSql2 = "DELETE from activity where temp_id=$delete";
	   $objDbDD -> query($usedSql2);

}
if($saveBtn != "")
{

$parentcd=0;	
$sSQL = ("INSERT INTO baseline_template (temp_title,temp_desc, temp_is_default,use_data,active_temp) VALUES ('".mysql_real_escape_string($txtitemname)."', '".mysql_real_escape_string($temp_desc)."', '$temp_is_default', '$use_data', '$active_temp')");
	$objDb->execute($sSQL);
	$tempid = $objDb->getAutoNumber();
	$tempid = $tempid;
	$parentgroup=str_repeat("0",$_SESSION['codelength']-strlen($itemid)).$itemid;
	if($use_data!="" && $use_data==1)
	{
		$eSql = "select boqid, boqcode, `boqitem`, `boqunit`, `boqqty` from boq order by itemid ,boqid ASC";
	   $objDb -> query($eSql);
	  $eCount = $objDb->getCount();
		if($eCount>0)
		 {
			for ($i = 0 ; $i < $eCount; $i++)
			{
			 $boqid 	    = $objDb->getField($i,boqid);	
			 $base_code 	= $objDb->getField($i,boqcode);
			 $base_desc 	= $objDb->getField($i,boqitem);
			 $unit 		= $objDb->getField($i,boqunit);
			 $qty 			= $objDb->getField($i,boqqty);
				
	  $sSQL = ("INSERT INTO baseline (base_code, base_desc, unit,quantity,unit_type,temp_id) VALUES ('".mysql_real_escape_string($base_code)."', '".mysql_real_escape_string($base_desc)."', '".mysql_real_escape_string($unit)."',$qty, '1',$tempid)");
	
		$objDbI->execute($sSQL);
		$rid = $objDbI->getAutoNumber();
	$sbSQL = ("INSERT INTO baseline_mapping_boqs(rid,boqid) VALUES ($rid , $boqid)");
		$objDbII->execute($sbSQL);
			}
		 }
		 
		 
		 //header("Location: resources.php");	
			
	}
	if($temp_is_default==1)
	{
		$uSql = "Update baseline_template SET 
			
			 temp_is_default 	    = 0	
			 where temp_id 			<> $tempid";
			 
		$objDbUI->execute($uSql);
	}
		if($active_temp==1)
	{
		$aSql = "Update baseline_template SET 
			
			 active_temp 	    = 0	
			 where temp_id 			<> $tempid";
			 
		$objDbUII->execute($aSql);
	}	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	print "<script type='text/javascript'>";
	print "window.opener.location.reload();";
	print "self.close();";
	print "</script>";  
 

}

if($updateBtn !=""){
	
 $upSql = "Update baseline_template SET 
			 temp_title  			= '".mysql_real_escape_string($txtitemname)."',
			 temp_desc  			= '".mysql_real_escape_string($temp_desc)."',
			 use_data 			    = '$use_data',
			 temp_is_default 	    = '$temp_is_default',
			 active_temp 	    = '$active_temp'	
			 where temp_id 			= $edit";
			 
	if($objDbU->execute($upSql))
	{
			 
	if($temp_is_default==1)
	{
		$uSql = "Update baseline_template SET 
			
			 temp_is_default 	    = 0	
			 where temp_id 			<> $edit";
			 
		$objDbUI->execute($uSql);
	}
		if($active_temp==1)
	{
		$aSql = "Update baseline_template SET 
			
			 active_temp 	    = 0	
			 where temp_id 			<> $edit";
			 
		$objDbUII->execute($aSql);
	}
	$msg="Template is updated"	 ; 
	
	if($use_data!="" && $use_data==1)
	{
	   $useSql = "DELETE from baseline where temp_id=$edit";
	   $objDbD -> query($useSql);
	   $useSql = "DELETE from baseline_mapping_boqs where rid=$edit";
	   $objDbD -> query($useSql);
	   
		echo $eSql = "select boqid, boqcode, `boqitem`, `boqunit`, `boqqty` from boq Order by itemid ,boqid ASC";
	   $objDb -> query($eSql);
	  $eCount = $objDb->getCount();
		if($eCount>0)
		 {
			for ($i = 0 ; $i < $eCount; $i++)
			{
			  $boqid 	    = $objDb->getField($i,boqid);	
			echo  $base_code 	= $objDb->getField($i,boqcode);
			  $base_desc 	= $objDb->getField($i,boqitem);
			  $unit 		= $objDb->getField($i,boqunit);
			  $qty 			= $objDb->getField($i,boqqty);
				
	 	$sSQL = ("INSERT INTO baseline (base_code, base_desc, unit, quantity,unit_type,temp_id) VALUES ('".mysql_real_escape_string($base_code)."','".mysql_real_escape_string($base_desc)."','".mysql_real_escape_string($unit)."',$qty, '1', $edit)");
		$objDbI->execute($sSQL);
		$rid = $objDbI->getAutoNumber();
		$sbSQL = ("INSERT INTO baseline_mapping_boqs(rid,boqid) VALUES ($rid , $boqid)");
		$objDbII->execute($sbSQL);
			}
		 }
		 
		 
		 //header("Location: resources.php");	
			
	}
	}
		print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
				
				
}

if($edit != ""){
 $eSql = "Select * from baseline_template where temp_id='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $temp_id 	= $objDb->getField($i,temp_id);
	  $temp_title= $objDb->getField($i,temp_title);
	  $temp_desc= $objDb->getField($i,temp_desc);
	  $temp_is_default= $objDb->getField($i,temp_is_default);
	  $use_data= $objDb->getField($i,use_data);
	  $active_temp= $objDb->getField($i,active_temp);
	  
	 	
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script>  
function validateform(){

var itemname=document.frmstgoal.txtitemname.value;  
    //var regex=/^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;
   
if(itemname==null || itemname==""){  
  alert("Template Name is required field");  
  return false;  
  }
    
}  
</script>  
</head>
<body>
<div id="wrapperPRight">
  <?php //include 'includes/header.php'; ?>

<div id="content">
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="return validateform()" enctype="multipart/form-data">
	  
	  <table width="100%" border="0"  align="center" cellpadding="1" cellspacing="1">
            <tr>
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
            <td colspan="2"><h1> <?php echo $action.$module; ?></h1></td>
           <?php  if($err_msg!="")
		   {
		   ?>
		    <td  colspan="2"><font color="red"><strong><?php echo $err_msg; ?></strong></font></td>
		   <?php
		   }
		   else
		   {?>
            <td colspan="2"><font color="#009933"><strong><?php if($msg!="") echo $msg; else echo "";?></strong></font></td>
			<?php
			}
			?>
            </tr>      
           
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Template Title:</td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $temp_title; ?>"/></td>
             </tr>
             <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Template Description:</td>
              <td ><textarea id="temp_desc" name="temp_desc"><?php echo $temp_desc; ?></textarea></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Use Data:</td>
              <td>
              <input type="radio" name="use_data" id="use_data" value="2"  checked="checked"/>  Use BOQ Data
              <input type="radio" name="use_data" id="use_data"   value="1"  <?php if($use_data==1){?> checked="checked" <?php }?>/>  Copy BOQ Data
              <input type="radio" name="use_data" id="use_data"   value="3" <?php if($use_data==3){?> checked="checked" <?php }?>/>  Custom 
              </td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Default Template? :</td>
              <td><input type="radio" name="temp_is_default"   id="temp_is_default" value="1" checked="checked"/> Yes
                  <input type="radio" name="temp_is_default" id="temp_is_default" value="0"  <?php if($temp_is_default==0){?> checked="checked" <?php }?>/>  No
              </td>
             </tr>
             <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Active Template? :</td>
              <td><input type="radio" name="active_temp"   id="active_temp" value="1" checked="checked" /> Yes
                  <input type="radio" name="active_temp" id="active_temp" value="0"  <?php if($active_temp==0){?> checked="checked" <?php }?>/>  No
              </td>
             </tr>
			<tr>
			 <td></td>
			 <td height="39"></td>
			 <td align="left" colspan="5"  >
			 <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save" />
			  &nbsp;&nbsp;<input type="submit" value="Clear" name="clear"  />
			  <?php } ?></td>
			 </tr>
 		</table>
     </form>

	<br clear="all" />
	<div id="content">
<table class="reference"  style="width:100%; font-size:12px" >
                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC; vertical-align:middle">
                  <th align="center" width="2%"><strong>#</strong></th>
                  <th align="center" width="25%"><strong>Template Name </strong></th>
                  <th width="23%"><strong>Description</strong></th>
                  <th width="15%"><strong>Data</strong></th>
                  <th width="15%"><strong>Default?</strong></th>
				  <th width="5%"><strong>Status</strong></th>
                  <th align="center" width="15%"><strong>Action </strong></th>
                  <?php /*?> <th align="center" width="10%"><strong>Log </strong></th><?php */?>
                </tr>
             
                <?php

 $sSQL = " Select * from baseline_template";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $temp_id 					= $objDb->getField($i,temp_id);
	  $temp_title 				= $objDb->getField($i,temp_title);
	  $temp_desc 				= $objDb->getField($i,temp_desc);
	  $is_default_temp 				= $objDb->getField($i,temp_is_default);
	  $is_active 						= $objDb->getField($i,active_temp);
	  $use_data						= $objDb->getField($i,use_data);
	  
	  if($is_active==1)
	  {
	  $status='<span style="color:#FF0000">'."Active".'</span>';
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



?>
               
                <tr <?php echo $style; ?>>
                  <td width="5px"><center>
                    <?php echo $i+1;?>
                  </center></td>
                 
                  <td><?php echo $temp_title;?></td>
                  <td><?php echo $temp_desc;?></td>
                   <td><?php if($use_data==2)echo "Use BOQ Data"; elseif($use_data==1) echo "Copy BOQ Data"; else echo "Custom";?></td>
                  <td  ><?php if($is_default_temp==1) {
					  echo  'Yes <span style="color:#FF0000">(Default)</span>';
				  		}
					  else 
					  {
						  echo "No";
					  }?></td>
				   <td ><?php echo $status;?></td>
                  <td style="border-bottom:1px solid #cccccc"  >&nbsp;
                    <?php  if($resentry_flag==1 || $resadm_flag==1)
	{
	?>
                    <a href="mapping_template.php?edit=<?php echo $temp_id;?>"  >Edit</a>
                    <?php } ?>
                    <?php  if($resadm_flag==1)
	{
	?>
                    | <a href="mapping_template.php?delete=<?php echo $temp_id;?>"  onclick="return confirm('Are you sure you want to delete this Template?')" >Delete</a>
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
</div>
  <?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
