<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= CAM;

if ($uname==null  ) {
header("Location: index.php?init=3");
}
$objDb  		= new Database( );
$objDb2  		= new Database( );
 $edit			= $_GET['edit'];
 $delete			= $_GET['del'];
//$item			= $_GET['item'];
 $subaid			= $_GET['subaid'];
if($subaid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from maindata where stage='CAM' and itemid=$subaid";
$resgx=mysql_query($sqlgx);
$row3gx=mysql_fetch_array($resgx);
$name_activity=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$pgroup=$row3gx['parentgroup'];
$ar_group=explode("_",$pgroup);
$sizze= count($ar_group);
for($i=0; $i<$sizze; $i++)
{
$sqlgx1="Select itemname, parentcd from maindata where itemid=$ar_group[$i]";
$resgx1=mysql_query($sqlgx1);
$row3gx1=mysql_fetch_array($resgx1);
$itemname_1=$row3gx1['itemname'];
 if ($i==0){ $title="CAM";  }
 else if ($i==1){ $title="SubCAM"; }
 
$trail.="<table><tr><td><b>".$title;

 $trail.=": </b></td><td>".$itemname_1; 
 $trail.="</td></tr></table>";

}

 }
 //$subaid			= $_GET['subaid'];

$levelid		= $_GET['levelid'];

@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "CAM";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= mysql_real_escape_string($_REQUEST['txtitemname']);
$txtweight					= $_REQUEST['txtweight'];
$txtcam						= $subaid;
$camlevel					=$levelid;
$txtisentry					= $_REQUEST['txtisentry'];
$act_s						= $_REQUEST['act'];
$length=count($act_s);

if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtactivity				= '';
}

if($saveBtn != "")
{

  $eSqls = "Select * from maindata where itemid=".$txtcam;
  $objDb -> query($eSqls);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentgroup2 					= $objDb->getField(0,parentgroup);
	   $txtparentcd 					= $objDb->getField(0,itemid);
	  }
 $sSQL = ("INSERT INTO maindata (parentcd, activitylevel, stage,itemcode, itemname, weight, isentry) VALUES ($txtparentcd,$camlevel+1,'$txtstage','$txtitemcode', '$txtitemname',$txtweight,$txtisentry)");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$itemids = $txtid;
		/*if(strlen($itemids)==1)
		{
		$parentgroup1="00".$itemids;
		}
		else if(strlen($itemids)==2)
		{
		$parentgroup1="0".$itemids;
		}
		else
		{
		$parentgroup1=$itemids;
		}*/
		$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
	$parentgroup=$parentgroup2."_".$parentgroup1;
		
	 $uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb->execute($uSqlu);
	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$camlevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemids)");
	$objDb->execute($sSQL);
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){


	 $eSql_s = "Select * from maindata where itemid='$txtcam'";
  	$objDb -> query($eSql_s);
  	$eCount2 = $objDb->getCount();
	if($eCount2 > 0){
	  $parentgroup_s	 				= $objDb->getField(0,parentgroup);
	  }
	  /*if(strlen($edit)==1)
		{
		$itmid="00".$edit;
		}
		else if(strlen($edit)==2)
		{
		$itmid="0".$edit;
		}
		else
		{
		$itmid=$edit;
		}*/
		$itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
		$parentgroup=$parentgroup_s."_".$itmid;
	
	
	
		$uSql = "Update maindata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 weight					= $txtweight,
			 parentcd				= $txtcam,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry'
			where itemid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	
	$eSql_l = "Select * from maindata where itemid='$edit'";
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
	
	$sSQL2 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$camlevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', $txtisentry, '$txtresources',$edit)");
		$objDb->execute($sSQL2);
		
		$txtparentcd				= '';
		$txtparentgroup				= '';
		$txtstage					= '';
		$txtitemcode 				= '';
		$txtitemname 				= '';
		$txtweight					= '';
		$txtactivities				= '';
		$txtisentry					= '';
		$txtresources 				= '';
		
	}
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($delete != ""){
$eSql = "Select * from maindata where itemid=$delete";
$q_ry=mysql_query($eSql);
$res_s=mysql_fetch_array($q_ry);
$p_group=$res_s['parentgroup'];
$eSqlr = "Select * from maindata where parentgroup like '$p_group%'";
$q_ryr=mysql_query($eSqlr);
while($res_sr=mysql_fetch_array($q_ryr))
{
	$itemid			=$res_sr['itemid'];
	$parentcd		=$res_sr['parentcd'];
	$parentgroup	=$res_sr['parentgroup'];
	$activitylevel  =$res_sr['activitylevel'];
	$stage			=$res_sr['stage'];
	$itemcode		=$res_sr['itemcode'];
	$itemname		=$res_sr['itemname'];
	$weight			=$res_sr['weight'];
	$isentry  		=$res_sr['isentry'];
	$txtactivities	="";
	$txtresources	="";
	
	
	 $msg="Deleted!";
	$log_module  = $module." Module";
	$log_title   = "Deleted".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	$sSQL7 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL7);
	
	$eSql_child = "delete from cam_activity where caid=$itemid";
    $objDb -> query($eSql_child);
	$eSql_d = "delete from maindata where itemid=$itemid";
    $objDb -> query($eSql_d);
}

header("Location: camdata.php");	
}

if($edit != ""){
	$eSql = "Select * from maindata where itemid=$edit";
    $objDb -> query($eSql);
    $eCount = $objDb->getCount();
	if($eCount > 0){
	 $parentcd 						= $objDb->getField($g,parentcd);
	  $parentgroup	 				= $objDb->getField($g,parentgroup);
	  $stage						= $objDb->getField($g,stage);
	  $itemcode 					= $objDb->getField($g,itemcode);
	  $itemname 					= $objDb->getField($g,itemname);
	  $weight	 					= $objDb->getField($g,weight);
	  $activities					= $objDb->getField($g,activities);
	  $isentry 						= $objDb->getField($g,isentry);
	  $resources 					= $objDb->getField($g,resources);
	 
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
            <tr >
            <td colspan="4" ><?php echo  $trail; ?></td></tr>
			<tr >
           <?php  if($err_msg!="")
		   {
		   ?>
		    <td  colspan="4"><font color="red"><strong><?php echo $err_msg; ?></strong></font></td>
		   <?php
		   }
		   else
		   {?>
            <td colspan="4"><font color="#009933"><strong><?php if($msg!="") echo $msg; else echo "";?></strong></font></td>
			<?php
			}
			?>
            </tr> 
			<tr>
            
              <td colspan="3" ><input id="txtparentcd" name="txtparentcd" type="hidden" value="<?php echo $parentcd; ?>" readonly=""/></td>
        </tr>
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label">SubCAM Code:</td>
              <td ><input id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">SubCAM  Name:</td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>"/></td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">SubCAM Weight:</td>
              <td >
			 <input type="text"  name="txtweight" id="txtweight" value="<?php echo $weight; ?>" /> 
              </td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IsEntry:</td>
              <td >
			 <select name="txtisentry" >
			  <option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
			  <option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
			 
			  </select>
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
</div>
  <?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
