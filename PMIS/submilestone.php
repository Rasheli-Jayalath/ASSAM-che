<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= MILESTONE;
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
 $sqlgx="Select itemname, parentcd,parentgroup from maindata where stage='Milestone' and itemid=$subaid";
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
 if ($i==0){ $title="Milestone";  }
 else if ($i==1){ $title="Submilestone"; }
 
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
$txtstage				 	= "Milestone";
$txtitemcode				= $_REQUEST['txtitemcode'];
$txtitemname				= mysql_real_escape_string($_REQUEST['txtitemname']);
$txtweight					= $_REQUEST['txtweight'];
$txtmilestone				= $subaid;
$milestonelevel				=$levelid;
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

$eSqls = "Select * from maindata where itemid=".$txtmilestone;
  $objDb -> query($eSqls);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $parentgroup2 					= $objDb->getField(0,parentgroup);
	   $txtparentcd 					= $objDb->getField(0,itemid);
	  }
 $sSQL = ("INSERT INTO maindata (parentcd, activitylevel, stage,itemcode, itemname, weight, isentry) VALUES ($txtparentcd,$milestonelevel+1,'$txtstage','$txtitemcode', '$txtitemname',$txtweight,$txtisentry)");
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
	$parentgroup=$parentgroup2."_".$parentgroup1;
		
	 $uSqlu = "Update maindata SET 
			 parentgroup			= '$parentgroup'
			where itemid 				= $itemids";	
	$objDb->execute($uSqlu);
	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities	, isentry, resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$txtparentcd,'$parentgroup',$milestonelevel+1,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities',$txtisentry, '$txtresources',$itemids)");
	$objDb->execute($sSQL);
	print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
}

if($updateBtn !=""){


	 $eSql_s = "Select * from maindata where itemid='$txtmilestone'";
  	$objDb -> query($eSql_s);
  	$eCount2 = $objDb->getCount();
	if($eCount2 > 0){
	  $parentgroup_s	 				= $objDb->getField(0,parentgroup);
	  }
	   $itmid=str_repeat("0",$_SESSION['codelength']-strlen($edit)).$edit;
	 /* if(strlen($edit)==1)
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
		$parentgroup=$parentgroup_s."_".$itmid;
	
	
	
		$uSql = "Update maindata SET 			
			 itemcode         		= '$txtitemcode',
			 itemname   			= '$txtitemname',
			 weight					= $txtweight,
			 parentcd				= $txtmilestone,
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
	
	$sSQL2 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$milestonelevel,'$txtstage', '$txtitemcode', '$txtitemname',$txtweight,'$txtactivities', $txtisentry, '$txtresources',$edit)");
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
	$log_title   = "Deleted ".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	$sSQL7 = ("INSERT INTO maindata_log (log_module,log_title,log_ip, parentcd, parentgroup,activitylevel, stage, itemcode, itemname, weight, activities,isentry,  resources,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$parentcd,'$parentgroup',$activitylevel,'$stage', '$itemcode', '$itemname',$weight,'$txtactivities', $isentry, '$txtresources',$itemid)");
	$objDb->execute($sSQL7);
	
	$eSql_child = "delete from milestone_activity where milestoneid=$itemid";
    $objDb -> query($eSql_child);
	$eSql_d = "delete from maindata where itemid=$itemid";
    $objDb -> query($eSql_d);
}

header("Location: milestonedata.php");	
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
		
function getactivities(isentry_value)
{
if(isentry_value==1)
{
var strURL1="findactivities.php?isentry="+isentry_value;

			var req1 = getXMLHTTP();
			
			if (req1) {
				
				req1.onreadystatechange = function() {
					if (req1.readyState == 4) {
						// only if "OK"
						if (req1.status == 200) {
							document.getElementById('activities').style.display="block";						
							document.getElementById('activities').innerHTML=req1.responseText;						
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
document.getElementById('activities').style.display="none";
}
}

function showResult(strmodule,strstage,stritemcode,stritemname,strweight,strisentry) {
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
  xmlhttp.open("GET","search.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
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
	  <form name="frmresources" id="frmresources" action=""  method="post" onsubmit="" enctype="multipart/form-data">
	  <?php 
	 
	 /* $sqlss="select parentgroup from maindata where itemid=$subaid";
	$sqlrwss=mysql_query($sqlss);
	$sqlrw1ss=mysql_fetch_array($sqlrwss);
	$par_groups=$sqlrw1ss['parentgroup'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$subactname="";
	for($i=3;$i<$lenns;$i++)
	{
	 $sqlCN="select itemname,activitylevel,parentcd from maindata where itemid=$par_arr[$i]";
		
	$sqlrCN=mysql_query($sqlCN);
	$sqlCNrw=mysql_fetch_array($sqlrCN);
	
	$subactname .='<a style=" font-size:12px; font-weight:bold" href="subactivity.php?levelid='.$sqlCNrw["activitylevel"].'&subaid='.$par_arr[$i].'">'.$sqlCNrw["itemname"].'</a>';
	
	$subactname .="&nbsp;&raquo;&nbsp;";
	
	//$category_name .=$category_name;
	}
   $subact_name=$subactname;*/
   ?>

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
              <td class="label">Submilestone Code:</td>
              <td ><input id="txtitemcode" name="txtitemcode" type="text" value="<?php echo $itemcode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Submilestone  Name:</td>
              <td ><input id="txtitemname" name="txtitemname" type="text" value="<?php echo $itemname; ?>"/></td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Submilestone Weight:</td>
              <td >
			 <input type="text"  name="txtweight" id="txtweight" value="<?php echo $weight; ?>" /> 
              </td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IsEntry:</td>
              <td >
			 <select name="txtisentry" onchange="getactivities(this.value)">
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
