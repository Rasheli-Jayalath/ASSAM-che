<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= OUTPUT;
if ($uname==null  ) {
header("Location: index.php?init=3");
}
$objDb  		= new Database( );
$item			= $_GET['item'];
if($item!="")
{
 $sqlgx="Select itemname, parentcd from maindata where stage='MILESTONE' and itemid=$item";
$resgx=mysql_query($sqlgx);
$row3gx=mysql_fetch_array($resgx);
$name_outcome=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$sqlgx1="Select itemname, parentcd from maindata where itemid=$parent";
$resgx1=mysql_query($sqlgx1);
$row3gx1=mysql_fetch_array($resgx1);
$name_strg=$row3gx1['itemname'];

 }
$edit			= $_GET['edit'];
$delete			= $_GET['del'];

@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "MILESTONE";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= mysql_real_escape_string($_REQUEST['txtitemname']);
$txtweight					= $_REQUEST['txtweight'];
$txtst_goals				= $_REQUEST['st_goals'];
$txtoutcomes					= $_REQUEST['txtoutcomes'];
$txtisentry					= 0;


if($clear!="")
{

$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
$txtst_goals				= '';
$txtoutcomes				= '';
}

if($saveBtn != "")
{

$eSqls = "Select * from maindata where itemid='$txtoutcomes'";
  $objDb -> query($eSqls);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentgroup2 					= $objDb->getField(0,parentgroup);
	   $txtparentcd 					= $objDb->getField(0,itemid);
	  }
 $sSQL = ("INSERT INTO maindata (parentcd, stage,itemcode, itemname, weight, isentry,resources, activitylevel) VALUES ($txtparentcd,'$txtstage','$txtitemcode', '$txtitemname',$txtweight,$txtisentry,'$txtresources', 2)");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$itemid = $txtid;
		
		$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($itemid)).$itemid;
	$parentgroup=$parentgroup2."_".$parentgroup1;
		
	$uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemid";	
	$objDb->execute($uSqlu);
	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	 $sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup','$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL);
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
	
}

if($updateBtn !=""){


	$eSql_s = "Select * from maindata where itemid='$txtoutcomes'";
  	$objDb -> query($eSql_s);
  	$eCount2 = $objDb->getCount();
	if($eCount2 > 0){
	  $parentgroup_s	 				= $objDb->getField(0,parentgroup);
	  }
	 
		 $itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
		$parentgroup=$parentgroup_s."_".$itmid;
	
 $uSql = "Update maindata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 weight					= $txtweight,
			 parentcd				= $txtoutcomes,
			 parentgroup            = '$parentgroup',
			 isentry				= '$txtisentry',
			 resources				= '$txtresources'
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
	
	$sSQL2 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup','$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', txtisentry, '$txtresources',$edit)");
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
	$log_module  = $stage." Module";
	$log_title   = "Deleted".$stage ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	$sSQL7 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL7);	
	
	$eSql_act = "Select aid from activity where itemid=$itemid";
	$q_ry_act=mysql_query($eSql_act);
	while($res_s_act=mysql_fetch_array($q_ry_act))
	{
	$aid=$res_s_act['aid'];
	$eSql_child2 = "delete from kpi_activity where activityid=$aid";
	mysql_query($eSql_child2);
	$eSql_child3 = "delete from cam_activity where activityid=$aid";
	mysql_query($eSql_child3);
	$eSql_child4 = "delete from milestone_activity where activityid=$aid";
	mysql_query($eSql_child4);
	}	
	
	$eSql_child = "delete from activity where itemid=$itemid";
    $objDb -> query($eSql_child);
	$eSql_d = "delete from maindata where itemid=$itemid";
    $objDb -> query($eSql_d);
}
header("Location: maindata.php");	
}


if($edit != ""){
 $eSql = "Select * from maindata where itemid='$edit'";
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
	  $ar_list=explode("_",$parentgroup);
	  $st_g=$ar_list[0];
	  $ou_cm=$ar_list[1];
	 	
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
var itemcode=document.frmresources.txtitemcode.value;  
var itemname=document.frmresources.txtitemname.value;
var weight=document.frmresources.txtweight.value;   
    var regex=/^[0-9]+$/;
   
if (itemcode==null || itemcode==""){  
  alert("Code is required field");  
  return false;  
}else if(itemname==null || itemname==""){  
  alert("Item Name is required field");  
  return false;  
  }
  else if(weight==null || weight=="" ){  
  alert("Weight is required field");  
  return false;  
  }
 else if (!weight.match(regex))
    {
        alert("Weight should be a number");
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


function get_outcomes(stg_value) {
		
		
		var strURL="findoutcome.php?stg_goal="+stg_value;
			var req = getXMLHTTP();
			
			if (req) {
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById('outcomes').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP: 5\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
		} 
		
function getresources(isentry_value)
{
if(isentry_value==1)
{
var strURL1="findresources.php?isentry="+isentry_value;

			var req1 = getXMLHTTP();
			
			if (req1) {
				
				req1.onreadystatechange = function() {
					if (req1.readyState == 4) {
						// only if "OK"
						if (req1.status == 200) {
							document.getElementById('resources').style.display="block";						
							document.getElementById('resources').innerHTML=req1.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP: 5\n" + req1.statusText);
						}
					}				
				}			
				req1.open("GET", strURL1, true);
				req1.send(null);
			}
}
else
{
document.getElementById('resources').style.display="none";
}
}

</script>

<link rel="stylesheet" type="text/css" href="dropdown-check-list.1.4/doc/smoothness-1.8.13/jquery-ui-1.8.13.custom.css">
<link rel="stylesheet" type="text/css" href="dropdown-check-list.1.4/src/ui.dropdownchecklist.themeroller.css">

    <!-- Include the DropDownCheckList supoprt -->
    <script type="text/javascript" src="dropdown-check-list.1.4/src/ui.dropdownchecklist.js"></script>
  

</head>
<body>
<div id="wrap">
  <?php //include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmresources" id="frmresources" action=""  method="post" onsubmit="return validateform()" enctype="multipart/form-data">
	  
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
            
              <td colspan="3" ><input id="txtparentcd" name="txtparentcd" type="hidden" value="<?php echo $parentcd; ?>" readonly=""/></td>
        </tr>
		<tr>
              <td class="label">&nbsp;</td>
              <td class="label">Strategic Goal :</td>
			 <?php if($item!="")
			 {
			 ?>
			 <td><input  type="hidden" name="st_goals" value="<?php echo $item;?>"/>
			 <input  type="text" name="str_name" value="<?php echo $name_strg; ?>" readonly=""/></td>
			 <?php
			 }
			 else
			 {?>
              <td ><select name="st_goals" onchange="get_outcomes(this.value)">
			  <option value="">Select</option>
			  <?php $sqlg="Select * from maindata where stage='MILESTONE' and activitylevel=0";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemid=$row3g['itemid'];
			
			
			if($itemid==$st_g)
			{
			$sel="selected='selected'";
			}
			else
			{
			$sel="";
			}
			?>
			  <option value="<?php echo $itemid;?>" <?php echo $sel; ?> ><?php echo $row3g['itemname']; ?> </option>
			  <?php
			  }
			  ?>
			  </select></td>
			  <?php
			  }
			  ?>
        </tr>
		<tr>
              <td class="label">&nbsp;</td>
              <td class="label">Outcome :</td>
			  <?php if($item!="")
			 {
			 ?>
			 <td><input  type="hidden" name="txtoutcomes" value="<?php echo $item;?>"/>
			 <input  type="text" name="out_name" value="<?php echo $name_outcome; ?>" readonly=""/></td>
			 <?php
			 }
			 else
			 {?>
              
              <td >
			  <div id="outcomes">
			  <select name="txtoutcomes">
			   <option value="">Select</option>
			  <?php $sqlg="Select * from maindata where stage='MILESTONE' and activitylevel=1";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemid=$row3g['itemid'];
			if($itemid==$ou_cm)
			{
			$sel="selected='selected'";
			}
			else
			{
			$sel="";
			}
			?>
			  <option value="<?php echo $itemid;?>" <?php echo $sel; ?> ><?php echo $row3g['itemname']; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
			  </div></td>
			  <?php
			  }
			  ?>
        </tr>
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Output Code:</td>
              <td ><input id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Output Name:</td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>"/></td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Output Weight:</td>
              <td >
			 <input type="text"  name="txtweight" id="txtweight" value="<?php echo $weight; ?>" /> 
              </td>
             </tr>
			<?php /*?> <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IsEntry:</td>
              <td >
			 <select name="txtisentry" onchange="getresources(this.value)">
			  <option value="0"  <?php if($isentry==0){?>selected="selected"<?php }?>  >No</option>
			  <option value="1" <?php if($isentry==1){?>selected="selected"<?php }?> >Yes</option>
			 
			  </select>
              </td>
             </tr><?php */?>
			 
			  <?php /*?><tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Resources:</td>
              <td >
			  <?php if($_REQUEST['edit']!="")
			  {
			  $style="style='display:block'";
			  }
			  else
			  {
			  $style="style='display:none'";
			  
			  } ?>
			 <div id="resources"  <?php echo $style; ?>> 
			 
			 <select name="res[]" id="s4a"  class="s4a" multiple="multiple" >
			   
			  <?php $ress_array=explode(",", $resources); 
			  
			  
			 $sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			
			foreach($ress_array as $val)
				{
			$val=str_replace("'", "", $val);
				if($val == $row3g['rid'])
				{
				$sele = " selected" ;
				break;
				}
				else
				{
					$sele = " " ;
				}
				
			 }			
			?>
			  <option value="<?php echo $row3g['rid'];?>"  <?php echo $sele; ?>><?php echo $row3g['resource']; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
			 </div>
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
	
	<?php /*?><form name="reports" id="reports"  method="post" target="_blank"  onsubmit="return atleast_onecheckbox(event)" style="display:inline-block"> 
	<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Output Code" placeholder="Output Code" style="width:100px"    onkeyup="showResult(module.value,this.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Output Name" placeholder="Output Name" style="width:100px"    onkeyup="showResult(module.value,valueitemcode.value,this.value,valueweight.value,valueisentry.value)"/>

<input type="text" name="valueweight"  id="valueweight" title="Weight" placeholder="Weight" style="width:100px"    onkeyup="showResult(module.value,valueitemcode.value,valueitemname.value,this.value,valueisentry.value)"/>

<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valueitemcode.value,valueitemname.value,valueweight.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="report.php"/>
<div id="search"></div>
	<div id="without_search">
    
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
      <th align="center" width="3%"><strong>
	  <input  type="checkbox"  name="txtChkAll" id=
          "txtChkAll"   form="reports"  onclick="group_checkbox();"/>
	 </strong></th>
	 <th align="center" width="10%"><span class="label">Stage</span></th>
     <th align="center" width="10%"><span class="label">Output Code</span></th>
	 <th align="center" width="15%"><span class="label">Output Name</span></th>
	 <th width="5%"><strong>Weight</strong></th>
      <th width="10%"><strong>Activities</strong></th>
      <th align="center" width="10%"><span class="label">Isentry</span></th>
	 <th align="center" width="10%"><span class="label">Resources</span></th>
	 <th align="center" width="10%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
 $sSQL = " Select * from maindata where stage='Output'";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $itemid						= $objDb->getField($i,itemid);
	  $parentcd 					= $objDb->getField($i,parentcd);
	  $parentgroup	 				= $objDb->getField($i,parentgroup);
	  $stage						= $objDb->getField($i,stage);
	  $itemcode 					= $objDb->getField($i,itemcode);
	  $itemname 					= $objDb->getField($i,itemname);
	  $weight	 					= $objDb->getField($i,weight);
	  $activities					= $objDb->getField($i,activities);
	  $isentry 						= $objDb->getField($i,isentry);
	  $resources 					= $objDb->getField($i,resources);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
if($isentry==0)
{
$isentry1="No";
}
else
{
$isentry1="Yes";
}
?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td width="180px"  ><?=$stage;?></td>
<td width="180px"  ><?=$itemcode;?></td>
<td width="180px"  ><?=$itemname;?></td>
<td width="100px"><?=$weight;?></td>
<td width="210px" align="right"><?=$activities;?></td>
<td width="180px"  ><?=$isentry1;?></td>
<td width="180px"  ><?php $ar_res=explode(",",$resources);

$sqlg1="Select * from resources";
			$resg1=mysql_query($sqlg1);
			while($row3g1=mysql_fetch_array($resg1))
			{
			
			foreach($ar_res as $val)
				{
			$val=str_replace("'", "", $val);
				if($val == $row3g1['rid'])
				{
				echo $row3g1['schedulecode'].",";
				}
				}
			}
?></td>


<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
 <a href="output.php?edit=<?php echo $itemid;?>"  ><img src="images/edit.png" width="22" height="22"/></a></td>
 <td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
</tr>
<?php        
	}
	}
?>
</table>
</div>
</form><?php */?>
</div>
  <?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
