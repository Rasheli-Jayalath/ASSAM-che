<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null  ) {
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
$objDb  		= new Database( );
$objDb2  		= new Database( );
$milestone=$_REQUEST["milestone"];
if(isset($milestone)&&$milestone==1)
 { 
$module		= "Milestone";
 } else
 {
$module		= BOQ;
 }
 $edit			= $_GET['edit'];
 $delete			= $_GET['del'];
//$item			= $_GET['item'];
 $subaid			= $_GET['subaid'];
if($subaid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from boqdata where stage='BOQ' and itemid=$subaid";
$resgx=mysql_query($sqlgx);
$row3gx=mysql_fetch_array($resgx);
$name_activity=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$pgroup=$row3gx['parentgroup'];
$ar_group=explode("_",$pgroup);
$sizze= count($ar_group);
for($i=0; $i<$sizze; $i++)
{
$sqlgx1="Select itemname, parentcd from boqdata where itemid=$ar_group[$i]";
$resgx1=mysql_query($sqlgx1);
$row3gx1=mysql_fetch_array($resgx1);
$itemname_1=$row3gx1['itemname'];
 if ($i==0){ 
 if(isset($milestone)&&$milestone==1)
 {
 $title="Milestone"; 
 }
 else
 {
 $title="BOQ"; 
 }
 }
 else if ($i==1){ 
 
 if(isset($milestone)&&$milestone==1)
 {
 $title="SubMilestone"; 
 }
 else
 {
  $title="SubBOQ"; 
 }

 }
 
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
$txtstage				 	= "BOQ";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= $_REQUEST['txtitemname'];
$txtweight					= $_REQUEST['txtweight'];
if($subaid!="")
{
$txtboq						= $subaid;
}
if($levelid!="")
{
$boqlevel					=$levelid;
}
else
{
	$boqlevel					=0;
}
//$txtisentry					= $_REQUEST['txtisentry'];

$txtisentry     = $_REQUEST['txtisentry'];


if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtactivity				= '';
}

if($saveBtn != "")
{

  if(isset($txtboq)&&$txtboq!="")
  {
  $eSqls = "Select * from boqdata where itemid=".$txtboq;
  $objDb -> query($eSqls);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentgroup2 					= $objDb->getField(0,parentgroup);
	   $txtparentcd 					= $objDb->getField(0,itemid);
	  }
  $sSQL = ("INSERT INTO boqdata (parentcd, activitylevel, stage,itemcode, itemname,isentry) VALUES ($txtparentcd,$boqlevel+1,'$txtstage','$txtitemcode', '$txtitemname',$txtisentry)");
  }
  else
  {
	  $parentgroup2="";
	  $txtparentcd=0;
	   $sSQL = ("INSERT INTO boqdata (parentcd, activitylevel, stage,itemcode, itemname,isentry) VALUES ($txtparentcd,$boqlevel,'$txtstage','$txtitemcode', '$txtitemname',$txtisentry)");
	}
 
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$itemids = $txtid;
	$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($itemids)).$itemids;
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
	 if(isset($txtboq)&&$txtboq!="")
	  {
		$parentgroup=$parentgroup2."_".$parentgroup1;
	  }
	  else
	  {
		  $parentgroup=$parentgroup1;
	   }
		
	 $uSqlu = "Update boqdata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb->execute($uSqlu);
	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO boqdata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$boqlevel+1,'$txtstage', '$txtitemcode', '$txtitemname','$txtactivities',$txtisentry, '$txtresources',$itemids)");
	$objDb->execute($sSQL);
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){


	 $eSql_s = "Select * from boqdata where itemid='$txtboq'";
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
	
	
	
		$uSql = "Update boqdata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 parentcd				= $txtboq,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry'
			where itemid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	
	$eSql_l = "Select * from boqdata where itemid='$edit'";
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
	
	$sSQL2 = ("INSERT INTO boqdata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$boqlevel+1,'$txtstage', '$txtitemcode', '$txtitemname','$txtactivities', $txtisentry, '$txtresources',$edit)");
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
$eSql = "Select * from boqdata where itemid=$delete";
$q_ry=mysql_query($eSql);
$res_s=mysql_fetch_array($q_ry);
$p_group=$res_s['parentgroup'];
$eSqlr = "Select * from boqdata where parentgroup like '$p_group%'";
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
	$sSQL7 = ("INSERT INTO boqdata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL7);
	$eSql_boq = "select boqid from boq where itemid=$itemid";
   $ress_boq=mysql_query($eSql_boq);
   while($result_boq=mysql_fetch_array($ress_boq))
   {
   $boqid=$result_boq['boqid'];
   $eSql_ipcv = "delete from ipcv where boqid=$boqid";
    $objDb -> query($eSql_ipcv);
   }
	
	
	$eSql_child = "delete from boq where itemid=$itemid";
    $objDb -> query($eSql_child);
	
	$eSql_d = "delete from boqdata where itemid=$itemid";
    $objDb -> query($eSql_d);
}

header("Location: boqdata.php");	
}


if($edit != ""){
	$eSql = "Select * from boqdata where itemid=$edit";
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
              <td class="label"><?php if(isset($milestone)&&$milestone==1)
										 { 
										 echo SUB_MIL_CODE;
										 } else
										 {
										 echo SUB_BOQ_CODE;
										 }?>:</td>
              <td ><input id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label"><?php if(isset($milestone)&&$milestone==1)
										 { 
										 echo SUB_MIL_NAME;
										 } else
										 {
										 echo SUB_BOQ_NAME;
										 }?>  </td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>"/></td>
             </tr>
			  <?php /*if($levelid>0)
    {
*/    ?>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label"><?php echo IS_ENTRY;?>:</td>
              <td >
			 <select name="txtisentry" >
			  <option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  ><?php echo NO;?></option>
			  <option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> ><?php echo YES;?></option>
			 
			  </select>
              </td>
             </tr>
			<?php //}?>
			<tr>
			 <td></td>
			 <td height="39"></td>
			 <td align="left" colspan="5"  >
			 <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" />
			  <?php } else { ?>
			  <input type="submit" value="<?php echo SAVE;?>" name="save" id="save" />
			  &nbsp;&nbsp;<input type="submit" value="<?php echo CLEAR;?>" name="clear"  />
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
