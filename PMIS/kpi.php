<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= KPI;
if ($uname==null  ) {
header("Location: index.php?init=3");
}

$objDb  		= new Database( );
$item			= $_GET['item'];
$edit			= $_GET['edit'];
$levelid			= $_GET['levelid'];
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "KPI";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= mysql_real_escape_string($_REQUEST['txtitemname']);
$txtweight					= $_REQUEST['txtweight'];
$txtst_goals				= $_REQUEST['st_goals'];
$txtoutcomes				= $_REQUEST['txtoutcomes'];
$txtoutput					= $_REQUEST['txtoutput'];
$txtisentry					= $_REQUEST['txtisentry'];
$act_s						= $_REQUEST['act'];
$btem="Select * from kpi_templates where is_active=1";
			  $resbtemp=mysql_query($btem);
			  $row3tmpgb=mysql_fetch_array($resbtemp);
			  $kpi_temp_id					= $row3tmpgb["kpi_temp_id"];
$length=count($act_s);
if($clear!="")
{
$txtitemcode 				= '';
$txtitemname 				= '';
$txtweight					= '';
}
if($item!="")
{
$sqlgx="Select itemname, parentcd from kpidata where stage='KPI'  and kpiid=$item";
$resgx=mysql_query($sqlgx);
$row3gx=mysql_fetch_array($resgx);
$name_output=$row3gx['itemname'];
$parent=$row3gx['parentcd'];
$sqlgx1="Select itemname, parentcd from kpidata where kpiid=$parent";
$resgx1=mysql_query($sqlgx1);
$row3gx1=mysql_fetch_array($resgx1);
$name_outcome=$row3gx1['itemname'];
$parent1=$row3gx1['parentcd'];
$sqlgx2="Select itemname, parentcd from kpidata where kpiid=$parent1";
$resgx2=mysql_query($sqlgx2);
$row3gx2=mysql_fetch_array($resgx2);
$name_strg=$row3gx2['itemname'];
 }
if($saveBtn != "")
{

/*$eSqls = "Select * from kpidata where itemid='$txtoutput'";
  $objDb -> query($eSqls);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentgroup2 					= $objDb->getField(0,parentgroup);
	   $txtparentcd 					= $objDb->getField(0,itemid);
	  }*/
	  $txtparentcd=0;
	  $parentgroup2=0;
 $sSQL = ("INSERT INTO kpidata (parentcd, stage,itemcode, itemname, weight, isentry,activitylevel,kpi_temp_id) VALUES ($txtparentcd,'$txtstage','$txtitemcode', '$txtitemname',$txtweight,$txtisentry,0,'$kpi_temp_id')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$kpiid = $txtid;
	$parentgroup1=str_repeat("0",$_SESSION['codelength']-strlen($kpiid)).$kpiid;
	
	$parentgroup=$parentgroup1;
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
	//$parentgroup=$parentgroup2."_".$parentgroup1;
		
	$uSqlu = "Update kpidata SET 
			 parentgroup			= '$parentgroup'
			where kpiid 				= $kpiid";	
	$objDb->execute($uSqlu);
	
/*if($length>0)
{
		
		for($i=0; $i<$length; $i++)
		{
		$eSql_l = "Select * from activity where itemid='$act_s[$i]'";
  	$res_sql=mysql_query($eSql_l);
	$numrows=mysql_num_rows($res_sql);
			if($numrows>0)
			{
				while($rows=mysql_fetch_array($res_sql))
				{
				$aid=$rows['aid'];
				
					 $sSQL = ("INSERT INTO kpi_activity (kpiid,activityid) VALUES ($itemid,$aid)");
				$objDb->execute($sSQL);
				}
			}
			
		}
}*/
	
	
/*	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO kpidata_log (log_module,log_title,log_ip, parentcd, parentgroup, stage, itemcode, itemname, weight, activities, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup','$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL);*/
	
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){
 $uSql = "Update kpidata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 weight					= $txtweight,
			 isentry				= '$txtisentry'			
			where itemid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	$eSql_l = "Select * from kpidata where itemid=$edit";
  	$objDb -> query($eSql_l);
  	$eCount1 = $objDb->getCount();
	if($eCount1 > 0){
	  $parentcd 					= $objDb->getField(0,parentcd);
	  $parentgroup	 				= $objDb->getField(0,parentgroup);
	  }
	  
		   /*if($txtisentry==1 && $length>0)
			{
			for($i=0; $i<$length; $i++)
			{
			$eSql_l = "Select * from activity where itemid='$act_s[$i]'";
			$res_sql=mysql_query($eSql_l);
			$numrows=mysql_num_rows($res_sql);
				if($numrows>0)
				{
					while($rows=mysql_fetch_array($res_sql))
					{
					$aid=$rows['aid'];
					
						echo $sSQL = ("INSERT INTO kpi_activity (milestoneid,activityid) VALUES ($edit,$aid)");
					$objDb->execute($sSQL);
					}
				}
			}
			}*/
	 $msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];		
	
	$sSQL2 = ("INSERT INTO kpidata_log (log_module,log_title,log_ip, parentcd, parentgroup, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup','$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', $txtisentry, '$txtresources',$edit)");
		$objDb->execute($sSQL2);
		
		$txtstage					= '';
		$txtitemcode 				= '';
		$txtitemname 				= '';
		$txtweight					= '';
		$txtisentry					= '';
				
	}
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($edit != ""){
 $eSql = "Select * from kpidata where itemid='$edit'";
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
   <script>  
function validateform(){
var itemcode=document.frmresources.txtitemcode.value;  
var itemname=document.frmresources.txtitemname.value;
var weight=document.frmresources.txtweight.value;   
    //var regex=/^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;
   
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
 /* else if (regex.test(weight))
    {
        alert("Weight should be a number");
        return false;
    }*/
    
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

function showResult(strmodule,stritemcode,stritemname,strweight,strisentry) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("search").innerHTML=xmlhttp.responseText;
      document.getElementById("search").style.border="1px solid #A5ACB2";
	   document.getElementById("without_search").style.display="none";
	  document.getElementById("without_search").disabled=true;
	// document.getElementById("without_search").removeClass("checkbox").addClass("");
	  var nodes = document.getElementById("without_search").getElementsByTagName('*');
			for(var i = 0; i < nodes.length; i++){
			 $("#cvcheck").attr( "class", "" ); 
				 nodes[i].disabled = true;
			}
	 
    }
  }
  xmlhttp.open("GET","search.php?module="+strmodule+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function group_checkbox2()
{
	var select_all = document.getElementById("txtChkAll2"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox2"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.with_search .checkbox2:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>
<script>
function group_checkbox()
{
	var select_all = document.getElementById("txtChkAll"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>
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
			<?php /*?><tr>
            
              <td colspan="3" ><input id="txtparentcd" name="txtparentcd" type="hidden" value="<?php echo $parentcd; ?>" readonly=""/></td>
        </tr><?php */?>
            <?php /*?><tr>
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
			  <?php $sqlg="Select * from kpidata where stage='KPI' and activitylevel=0";
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
			  <?php $sqlg="Select * from kpidata where stage='KPI' and activitylevel=1";
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
              <td class="label">Output :</td>
			  <?php if($item!="")
			 {
			 ?>
			 <td><input  type="hidden" name="txtoutput" value="<?php echo $item;?>"/>
			 <input  type="text" name="name_output" value="<?php echo $name_output; ?>" readonly=""/></td>
			 <?php
			 }
			 else
			 {?>
              <td >
			  <div id="output">
			  <select name="txtoutput" >
			   <option value="">Select</option>
			  <?php $sqlop="Select * from kpidata where stage='KPI' and activitylevel=2";
			$resop=mysql_query($sqlop);
			while($row3op=mysql_fetch_array($resop))
			{
			$itemid=$row3op['itemid'];
			if($itemid==$ou_pt)
			{
			$sel="selected='selected'";
			}
			else
			{
			$sel="";
			}
			?>
			  <option value="<?php echo $itemid;?>" <?php echo $sel; ?> ><?php echo $row3op['itemname']; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
			  </div></td><?php } ?>
        </tr><?php */?>
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label">KPI Code:</td>
              <td ><input id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">KPI  Name:</td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>" align="left"/></td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">KPI Weight:</td>
              <td >
			 <input type="text"  name="txtweight" id="txtweight" value="<?php echo $weight; ?>" /> 
              </td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IsEntry:</td>
              <td >
			 <select name="txtisentry">
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
