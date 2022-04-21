<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");


if ($uname==null  ) {
header("Location: index.php?init=3");
}

$objDb  		= new Database( );
$item			= $_GET['item'];
$edit			= $_GET['edit'];
$milestone=$_REQUEST["milestone"];
if(isset($milestone)&&$milestone==1)
 { 
$module		= "Milestone";
 } else
 {
$module		= BOQ;
 }

@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "BOQ";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= mysql_real_escape_string($_REQUEST['txtitemname']);
$txtisentry					= 0;
$act_s						= $_REQUEST['act'];
$length=count($act_s);
if($clear!="")
{
$txtitemcode 				= '';
$txtitemname 				= '';
}

if($saveBtn != "")
{

$txtparentcd=0;	  
 $sSQL = ("INSERT INTO boqdata (parentcd, stage,itemcode, itemname, isentry) VALUES ($txtparentcd,'$txtstage','$txtitemcode', '$txtitemname',$txtisentry)");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$itemid = $txtid;
		/*if(strlen($itemid)==1)
		{
		$parentgroup="00".$itemid;
		}
		else if(strlen($itemid)==2)
		{
		$parentgroup="0".$itemid;
		}
		else
		{
		$parentgroup=$itemid;
		}*/
		$parentgroup=str_repeat("0",$_SESSION['codelength']-strlen($itemid)).$itemid;
	//$parentgroup=$parentgroup2."_".$parentgroup1;
		
	$uSqlu = "Update boqdata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemid";	
	$objDb->execute($uSqlu);
	

	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup, stage, itemcode, itemname,  activities, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup','$txtstage', '$txtitemcode', '$txtitemname','$txtactivities',$txtisentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL);
	
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){
 $uSql = "Update boqdata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 isentry				= '$txtisentry'			
			where itemid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	$eSql_l = "Select * from boqdata where itemid=$edit";
  	$objDb -> query($eSql_l);
  	$eCount1 = $objDb->getCount();
	if($eCount1 > 0){
	  $parentcd 					= $objDb->getField(0,parentcd);
	  $parentgroup	 				= $objDb->getField(0,parentgroup);
	  }
	 $msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];		
	
	$sSQL2 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup, stage, itemcode, itemname,  activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup','$txtstage', '$txtitemcode', '$txtitemname','$txtactivities', $txtisentry, '$txtresources',$edit)");
		$objDb->execute($sSQL2);
		
		$txtstage					= '';
		$txtitemcode 				= '';
		$txtitemname 				= '';
		$txtisentry					= '';
				
	}
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($edit != ""){
 $eSql = "Select * from boqdata where itemid='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentcd 					= $objDb->getField($i,parentcd);
	  $parentgroup	 				= $objDb->getField($i,parentgroup);
	  $stage						= $objDb->getField($i,stage);
	  $itemcode 					= $objDb->getField($i,itemcode);
	  $itemname 					= $objDb->getField($i,itemname);
	  $weight	 					= $objDb->getField($i,weight);
	  $activities					= $objDb->getField($i,activities);
	  $isentry 						= $objDb->getField($i,isentry);
	  $resources 					= $objDb->getField($i,resources);
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
</head>
<body>
<div id="wrap">
  <?php //include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmresources" id="frmresources" action=""  method="post" onsubmit="" enctype="multipart/form-data">
	  
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
			<?php /*?><tr>
            
              <td colspan="3" ><input id="txtparentcd" name="txtparentcd" type="hidden" value="<?php echo $parentcd; ?>" readonly=""/></td>
        </tr><?php */?>
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label"><?php if(isset($milestone)&&$milestone==1)
										 { 
										 echo "SubMilestone Code:";
										 } else
										 {
										 echo "SubBOQ Code:";
										 }?></td>
              <td ><input id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label"><?php if(isset($milestone)&&$milestone==1)
										 { 
										 echo "SubMilestone Name:";
										 } else
										 {
										 echo "SubBOQ Name:";
										 }?> </td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>"/></td>
             </tr>
			<?php /*?> <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IsEntry:</td>
              <td >
			 <select name="txtisentry">
			  <option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
			  <option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
			 
			  </select>
              </td>
             </tr><?php */?>
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
</div>
  <?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
