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
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtmonth1					= $_REQUEST['txtmonth'];
$txtmonth=$txtmonth1."-01";

$pdate=date('Y-m-d',strtotime($txtmonth));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;         
 $txtmonth=$pdate;
 
$txtstatus					= $_REQUEST['txtstatus'];
$txtremarks					= $_REQUEST['txtremarks'];
$temp_id					= 1;
if($clear!="")
{

$txtstatus 					= '';
$txtremarks 				= '';

}

if($saveBtn != "")
{
	$eSql_l = "Select * from progressmonth where status=0 AND temp_id=$temp_id";
  	$res_q=mysql_query($eSql_l);
	if(mysql_num_rows($res_q)==1)
	{
	$msg="You can't add new progress month if a month has already Active status";
	}
	else
	{
$sSQL = ("INSERT INTO progressmonth (pmonth,status,remarks,temp_id) VALUES ('$txtmonth','$txtstatus','$txtremarks','$temp_id')");

	$objDb->execute($sSQL);
	$pmid = $objDb->getAutoNumber();
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO progressmonth_log (log_module,log_title,log_ip,pmonth,  status,remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtmonth', '$txtstatus','$txtremarks',$pmid)");
	$objDb->execute($sSQL);
	}
		
 
}

if($updateBtn !=""){
$eSql_l = "Select * from progressmonth where status=0 and pmid!=$edit AND temp_id=$temp_id";
  	$res_q=mysql_query($eSql_l);
	
	if(mysql_num_rows($res_q)==1)
	{
		$msg="You can't update month's status to Active if a month has already Active status";
		
	}
	else
	{	
$uSql = "Update progressmonth SET 			
			 pmonth         		= '$txtmonth',
			 status   				= '$txtstatus',
			 remarks				= '$txtremarks'	,
			 temp_id				= '$temp_id'		
			where pmid 			= $edit  AND temp_id=$temp_id";
		  
 	if($objDb->execute($uSql)){
	
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
$sSQL2 = ("INSERT INTO progressmonth_log (log_module,log_title,log_ip,pmonth,  status,remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtmonth', '$txtstatus','$txtremarks',$edit)");
		$objDb->execute($sSQL2);

		
	}
	$txtstatus 					= '';
	$txtremarks 				= '';
	header("Location: progress.php?temp_id=".$temp_id);
	}
	
		
}

if($edit != ""){
 $eSql = "Select left(pmonth,7) as pmonth,status,remarks from progressmonth where pmid='$edit' AND temp_id=$temp_id";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $pmonth 						= $objDb->getField($i,pmonth);
	  $status	 					= $objDb->getField($i,status);
	  $remarks						= $objDb->getField($i,remarks);
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
function showResult(strmodule,strmonth,strstatus,strremarks) {
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
  xmlhttp.open("GET","searchpm.php?module="+strmodule+"&month="+strmonth+"&status="+strstatus+"&remarks="+strremarks,true);
  xmlhttp.send();
}

</script>
<!--<script type="text/javascript">
		 
 $(function() {
    $( "#valuetf" ).datepicker();
  });
   $(function() {
    $( "#valuett" ).datepicker();
  });

</script>-->
<script>
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
            <td colspan="3"><h1> <?php echo $action.$module; ?><span style="text-align:right; float:right"><a href="addprogress.php?temp_id=<?php echo $_REQUEST["temp_id"];?>">Back</a></span></h1></td>
			</tr>
			<tr>
           <?php  if($err_msg!="")
		   {
		   ?>
		    <td colspan="3" ><font color="red"><strong><?php echo $err_msg; ?></strong></font></td>
		   <?php
		   }
		   else
		   {?>
            <td colspan="3" ><font color="red"><strong><?php if($msg!="") echo $msg; else echo "";?></strong></font></td>
			<?php
			}
			?>
            </tr>      
           
			
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Month:</td>
              <td ><select name="txtmonth">
			  <?php $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
			$resg=mysql_query($sqlg);
			
			while($row3g=mysql_fetch_array($resg))
			{
			$getmonth=$row3g['getmonths'];
			if($getmonth==$pmonth)
			{
			$sel =" selected='selected' ";
			}
			else
			{
			$sel ="";
			}
			
			?>
			  <option value="<?php echo $getmonth;?>" <?php echo  $sel; ?>  ><?php echo $getmonth; ?> </option>
			  <?php
			  }
			  
			  ?>
			  </select></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Status:</td>
              <td ><input type="radio"  id="txtstatus" name="txtstatus" value="0" <?php if($status=="0"){ echo "checked='checked'";} else if($status==""){ echo "checked='checked'";} ?>/>Active
			  <input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($status=="1"){ echo "checked='checked'";} ?>/>Inactive
			  
			  <?php /*?><input type="text" id="txtstatus" name="txtstatus"  value="<?php echo $status; ?>" /><?php */?></td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Remarks:</td>
              <td >
			 <input type="text"  name="txtremarks" id="txtremarks" value="<?php echo $remarks; ?>" /> 
              </td>
             </tr>
			
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
<form name="reports" id="reports"  method="post"   onsubmit="return atleast_onecheckbox(event)" style="display:inline-block"> 
	<input type="hidden" name="module" id="module" value="<?php echo $module ?>" onkeyup="showResult(this.value,txtmonth.value,valuestatus.value,valueremarks.value)"/>
	<select name="txtmonth" id="txtmonth" onchange="showResult(module.value,this.value,valuestatus.value,valueremarks.value)">
	<option value="">Select Progress Month</option>
			  <?php $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
			$resg=mysql_query($sqlg);
			
			while($row3g=mysql_fetch_array($resg))
			{
			$getmonth=$row3g['getmonths'];
			if($getmonth==$pmonth)
			{
			$sel =" selected='selected' ";
			}
			else
			{
			$sel ="";
			}
			
			?>
			  <option value="<?php echo $getmonth;?>" <?php echo  $sel; ?>  ><?php echo $getmonth; ?> </option>
			  <?php
			  }
			  
			  ?>
			  </select>
<input type="text" name="valuestatus"  id="valuestatus" title="Status" placeholder="Status" style="width:100px"  onkeyup="showResult(module.value,txtmonth.value,this.value,valueremarks.value)"/>
<input type="text" name="valueremarks"  id="valueremarks"  title="Remarks" placeholder="Remarks" style="width:100px"    onkeyup="showResult(module.value,txtmonth.value,valuestatus.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportpm.php"/>
<div id="search"></div>
	<div id="without_search">
    
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th align="center" width="3%"><strong>Sr. No.</strong></th>
      <th align="center" width="2%"><strong>
	  <input  type="checkbox"  name="txtChkAll" id=
          "txtChkAll"   form="reports"  onclick="group_checkbox();"/>
		  
		  </strong></th>
      <th align="center" width="25%"><strong>Month</strong></th>
      <th width="20%"><strong>Status</strong></th>
      <th width="25%"><strong>Remarks</strong></th>
      <th align="center" width="15%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
 $sSQL = " Select pmid,left(pmonth,7) as pmonths,status,remarks from progressmonth where temp_id=$temp_id";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $pmid 							= $objDb->getField($i,pmid);
	  $pmonth 							= $objDb->getField($i,pmonths);
	  $status3 							= $objDb->getField($i,status);
	  if($status3=="0")
	  {
	  $status="Active";
	  }
	  else  if($status3=="1")
	  {
	  $status="Inactive";
	  }
	  $remarks 							= $objDb->getField($i,remarks);
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?php echo $i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?php echo $pmid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td width="210px"><?php echo $pmonth;?></td>
<td width="100px"><?php echo $status;?></td>
<td width="180px"  ><?php echo $remarks;?></td>

<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
 <a href="progress.php?edit=<?php echo $pmid;?>&temp_id=<?php echo $_REQUEST["temp_id"];?>"  ><img src="images/edit.png" width="22" height="22"  /></a></td>
 <td width="210px" align="right" ><a href="log_pm.php?trans_id=<?php echo $pmid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
</tr>
<?php        
	}
	}
?>
</table>
</div>
</form>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
