<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= Progress;
if ($uname==null ) {
header("Location: index.php?init=3");
}
else if($spgentry_flag==0 and $spgadm_flag==0 )
{
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
$temp_id					= $_REQUEST['temp_id'];
$progress_type				= $_REQUEST['txtstatus'];


if($clear!="")
{

$txtstatus 					= '';
$temp_id 				= '';

}

if($saveBtn != "")
{   if($temp_id!=""&&$temp_id!=0)
	{
	$eSql_2 = "Select * from baseline_template where temp_id=$temp_id";
  	$res_2=mysql_query($eSql_2);
	$sqrows2=mysql_fetch_array();
	$use_data=$sqrows2["use_data"];
	}
	if($use_data==3&&$progress_type==1)
	{
		$msg=5;
	}
	else
	{
	$eSql_l = "Select * from template_progress where temp_id=$temp_id";
  	$res_q=mysql_query($eSql_l);
	if(mysql_num_rows($res_q)==1)
	{
		$msg=4;
	//$msg="Progress Entry type has already been selected for this Template";
	}
	else
	{
	$sSQL = ("INSERT INTO template_progress (temp_id,progress_type,update_flag) VALUES ('$temp_id','$progress_type',1)");
	$objDb->execute($sSQL);
	$temp_pid = $objDb->getAutoNumber();
	$msg="Saved!";
	$msg=3;
	}
	}
	header("Location: template_progress.php?msg=$msg");	
   
}
if($edit != ""){
 $eSql = "Select * from template_progress where temp_pid='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $temp_id_e 	= $objDb->getField($i,temp_id);
	 $progress_type_e = $objDb->getField($i,progress_type);
	 }
}
if($updateBtn !=""){
$eSql_l = "Select * from template_progress where temp_pid=$edit";
  	$res_q=mysql_query($eSql_l);
	$res_rows=mysql_fetch_array($res_q);
 $progress_type_d=$res_rows["progress_type"];
	if ($progress_type_d!=$progress_type)
	{
		
		$msg=1;
	}
	else
	{	
  $uSql = "Update template_progress SET 			
			 temp_id         	= '$temp_id',
			 progress_type   	= '$progress_type'			
			where temp_pid 			= $edit";
		  
 	if($objDb->execute($uSql)){
	$msg=2;
	}
	$txtstatus 					= '';
	$txtremarks 				= '';
	
	}
	
	header("Location: template_progress.php?msg=$msg");	
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
function selectProgressEntry(temp_id)
{
	
	
 if(temp_id!="")
 {
   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp5=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp5=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp5.onreadystatechange=function() {
    if (xmlhttp5.readyState==4 && xmlhttp5.status==200) {
      document.getElementById("templatedata").innerHTML=xmlhttp5.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
  xmlhttp5.open("GET","get_template_type.php?temp_id="+temp_id,true);
  xmlhttp5.send();
	
 }
	
}
</script>
</head>
<body>
<div id="wrap">
<?php include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="" enctype="multipart/form-data">
	  
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
            <td colspan="3"><h1> <?php echo  $action.$module; ?></span></h1></td>
			</tr>
			<tr>
           <?php  if($err_msg!="")
		   {
		   ?>
		    <td colspan="3" ><font color="red"><strong><?php echo  $err_msg; ?></strong></font></td>
		  
          <?php
			}
			elseif($_REQUEST["msg"]==1)
			{?> 
            <td colspan="3" align="center"><font color="green"><strong><?php  echo "You can't update Progress Type"; ?></strong></font></td>
			<?php
		   }
		   elseif($_REQUEST["msg"]==2)
		   {?>
           <td colspan="3" ><font color="green"><strong><?php echo "Updated!";?></strong></font></td>
           	<?php
		   }
		   elseif($_REQUEST["msg"]==3)
		   {?>
           <td colspan="3" ><font color="green"><strong><?php echo "Saved!";?></strong></font></td>
         	<?php
		   }
		   elseif($_REQUEST["msg"]==4)
		   {?>
           <td colspan="3" ><font color="red"><strong><?php echo "Progress Entry type has already been selected for this Template";?></strong></font></td>
           <?php
		   }
		   elseif($_REQUEST["msg"]==5)
		   {?>
           <td colspan="3" ><font color="red"><strong><?php echo "This Baseline Template can not linked to IPC  as It is not linked to BOQ. Please select Custom.";?></strong></font></td>
            <?php
		   }
		   elseif($_REQUEST["msg"]==6)
		   {?>
           <td colspan="3" ><font color="green"><strong><?php echo "IPC Progress has been Published Successfully.";?></strong></font></td>
           <?php }?>
           
            </tr>      
               <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Template:</td>
              <td ><select name="temp_id" id="temp_id" onchange="selectProgressEntry(this.value)">
			  <option value="0">Select Template:</option>
			  <?php $btemp="Select * from baseline_template";
			$resbtemp=mysql_query($btemp);
			while($row3tmpg=mysql_fetch_array($resbtemp))
			{
			$tempid=$row3tmpg['temp_id'];
			if($tempid==$temp_id_e)
			{
			$sel="selected='selected'";
			}
			
			else
			{
			$sel="";
			}
			?>
			  <option  value="<?php echo  $tempid;?>" <?php echo  $sel; ?> ><?php echo  $row3tmpg['temp_title']; ?> </option>
			  <?php
			  }
			  ?>
			  </select></td>
             
            </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Progress Entry:</td>
              <td ><div id="templatedata"><input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($progress_type_e=="1"){ echo "checked='checked'";}  ?>/>IPC
			  <input type="radio"  id="txtstatus" name="txtstatus" value="2" <?php if($progress_type_e=="2"){ echo "checked='checked'";} ?>/>Custom
			  </div></td>
             </tr>
			 
			 	<!--<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Remarks:</td>
              <td >
			 <input type="text"  name="txtremarks" id="txtremarks" value="<?php echo  $remarks; ?>" /> 
              </td>
             </tr>-->
			
			<tr>
			 <td></td>
			 <td height="39"></td>
			 <td align="left" colspan="5"  >
			 <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update"  />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save"  />
			  &nbsp;&nbsp;<input type="submit" value="Clear" name="clear"  />
			  <?php } ?></td>
			 </tr>
 		</table>
     </form>
	 <br clear="all" />
     <table class="reference" style="width:100%" >
                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC; vertical-align:middle">
                  <th align="center" width="2%"><strong>#</strong></th>
                  <th align="center" width="20%"><strong>Template </strong></th>
                  <th width="10%"><strong>Progress Type</strong></th>
                 <th width="15%"><strong>View/Add Progress</strong></th>
                  <th align="center" width="10%"><strong>Action </strong></th>
                  <?php /*?> <th align="center" width="10%"><strong>Log </strong></th><?php */?>
                </tr>
                <strong>
                <?php
 $sSQL = " Select * from template_progress a inner join baseline_template b on(a.temp_id=b.temp_id)";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $temp_pid 							= $objDb->getField($i,temp_pid);
	  $temp_id 								= $objDb->getField($i,temp_id);
	   $temp_title 						= $objDb->getField($i,temp_title);
	  $progress_type 						= $objDb->getField($i,progress_type);
	  $update_flag 						= $objDb->getField($i,update_flag);
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
                </strong>
                <tr <?php echo  $style; ?>>
                  <td width="5px"><center>
                   <?php echo $i+1;?>
                  </center></td>
                  <td width="150px"><?php echo  $temp_title;?></td>
                  <td width="100px"><?php if($progress_type==1)echo "IPC";
				  else
				  echo "Custom";?></td>
                   <td width="100px"><?php if($progress_type==1)
				   {?> <a href="addprogress.php?temp_id=<?php echo  $temp_id;?>" >View IPC Progress</a> |  <?php if($update_flag==1) {?><a href="publishprogress.php?temp_id=<?php echo  $temp_id;?>" >Publish IPC Progress</a><?php } else{ echo "Published";}?>
				  <?php  }
				  else
				  {?>
				   <a href="addprogress.php?temp_id=<?php echo  $temp_id;?>" >Add Custom Progress</a> &nbsp; | &nbsp;<a href="addprogress.php?temp_id=<?php echo  $temp_id;?>" >View Custom Progress</a>
				  <?php }?></td>
                  <td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
                    <?php  if($resentry_flag==1 || $resadm_flag==1)
	{
	?>
                    <a href="template_progress.php?edit=<?php echo  $temp_pid;?>"  >Edit</a>
                    <?php } ?>
                    <?php  if($resadm_flag==1)
	{
	?>
                    | <a href="template_progress.php?delete=<?php echo  $temp_pid;?>"  onclick="return confirm('Are you sure you want to delete this Template Progress?')" >Delete</a>
                  <?php
  }
  ?></td>
                  <?php /*?><td width="210px" align="right" ><a href="log.php?trans_id=<?php echo  $rid ; ?>&amp;module=<?php echo  $module?>" target="_blank">Log</a></td><?php */?>
                </tr>
                <?php        
	}
	}
?>
              </table>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
