<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "IPC Data";
if ($uname==null  ) {
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
$msg									= "";
$saveBtn								= $_REQUEST['save']; 
$updateBtn								= $_REQUEST['update'];
$clear									= $_REQUEST['clear'];
$next									= $_REQUEST['next'];
$txtipcno								= $_REQUEST['txtipcno'];
$txtmonth1								= $_REQUEST['txtipcmonth'];
$txtipcmonth							= $txtmonth1."-01";
$txtipcstartdate						= $_REQUEST['txtipcstartdate'];
$txtipcenddate							= $_REQUEST['txtipcenddate'];
$txtipcsubmitdate						= $_REQUEST['txtipcsubmitdate'];
$txtipcreceivedate						= $_REQUEST['txtipcreceivedate'];
$txtstatus								= $_REQUEST['txtstatus'];

if($clear!="")
{

$txtipcno 						= '';
$txtipcstartdate 				= '';
$txtipcenddate					= '';
$txtipcenddate					= '';
$txtipcsubmitdate				= '';
$txtipcreceivedate				= '';
$txtstatus						= '';
}

if($saveBtn != "")
{
$eSql_l = "Select * from ipc where status=0";
  	$res_q=mysql_query($eSql_l);
	if(mysql_num_rows($res_q)==1)
	{
	$msg="You can't add new IPC month if a month has already Active status.";
	}
	else
	{
$sSQL = ("INSERT INTO ipc (ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status) VALUES ('$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus')");

	$objDb->execute($sSQL);
	$ipcid = $objDb->getAutoNumber();
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO ipc_log (log_module,log_title,log_ip,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status, transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$ipcid)");
	$objDb->execute($sSQL);
}	
		
 
}

if($updateBtn !=""){

$eSql_l = "Select * from ipc where status=0 and ipcid!=$edit";
  	$res_q=mysql_query($eSql_l);
	
	if(mysql_num_rows($res_q)==1)
	{
		$msg="You can't update month's status to Active if a month has already Active status";
		
	}
	else
	{	
$uSql = "Update ipc SET 			
			 ipcno         				= '$txtipcno',
			 ipcmonth   				= '$txtipcmonth',
			 ipcstartdate				= '$txtipcstartdate',
			  ipcenddate         		= '$txtipcenddate',
			 ipcsubmitdate   			= '$txtipcsubmitdate',
			 ipcreceivedate				= '$txtipcreceivedate',
			 status   					= '$txtstatus'		
			where ipcid 				= $edit";
		  
 	if($objDb->execute($uSql)){
	
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
$sSQL2 = ("INSERT INTO ipc_log (log_module,log_title,log_ip,ipcno,ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status,transaction_id) VALUES ('$log_module','$log_title','$log_ip','$txtipcno ','$txtipcmonth','$txtipcstartdate','$txtipcenddate','$txtipcsubmitdate','$txtipcreceivedate','$txtstatus',$edit)");
		$objDb->execute($sSQL2);

		
	}
	$txtipcno 						= '';
	$txtipcstartdate 				= '';
	$txtipcenddate					= '';
	$txtipcenddate					= '';
	$txtipcsubmitdate				= '';
	$txtipcreceivedate				= '';
	$txtstatus				= '';
	header("Location: ipcdata.php");
	
	}
		
}

if($edit != ""){
 $eSql = "Select ipcno,left(ipcmonth,7) as ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status from ipc where ipcid='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $ipcno 								= $objDb->getField($i,ipcno);
	  $ipcmonth	 							= $objDb->getField($i,ipcmonth);
	  $ipcstartdate							= $objDb->getField($i,ipcstartdate);
	  $ipcenddate 							= $objDb->getField($i,ipcenddate);
	  $ipcsubmitdate	 					= $objDb->getField($i,ipcsubmitdate);
	  $ipcreceivedate						= $objDb->getField($i,ipcreceivedate);
	  $status								= $objDb->getField($i,status);
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
function showResult(strmodule,strno,strmonth,strsdate,stredate,strsubdate,strrecdate) {
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
  xmlhttp.open("GET","searchipcdata.php?module="+strmodule+"&ipcno="+strno+"&ipcmonth="+strmonth+"&ipcstartdate="+strsdate+"&ipcenddate="+stredate+"&ipcsubmitdate="+strsubdate+"&ipcreceivedate="+strrecdate,true);
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
<script type="text/javascript">
		 
 $(function() {
 $('#txtipcstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtipcenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtipcsubmitdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtipcreceivedate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });


</script>
<script type="text/javascript">
		 
 $(function() {
 $('#valueipcstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueipcenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueipcsubmitdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueipcreceivedate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });


</script>

</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>

<div id="content">
<br />
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="" enctype="multipart/form-data" style="margin-top:10px;">
	  
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
            <td colspan="3"><h1> <?php echo $action.$module; ?><span style="text-align:right; float:right"><a href="addipc.php">Back</a></span></h1></td>
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
              <td class="label">IPC No:</td>
              <td ><input type="text" id="txtipcno" name="txtipcno"  value="<?php echo $ipcno; ?>" /></td>
             </tr>
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Month:</td>
              <td ><select name="txtipcmonth">
			  <?php $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
			$resg=mysql_query($sqlg);
			
			while($row3g=mysql_fetch_array($resg))
			{
			$getmonth=$row3g['getmonths'];
			if($getmonth==$ipcmonth)
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
              <td class="label">IPC Start Date:</td>
              <td ><input type="text" id="txtipcstartdate" name="txtipcstartdate"  value="<?php echo $ipcstartdate; ?>" /></td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IPC End Date:</td>
              <td >
			 <input type="text"  name="txtipcenddate" id="txtipcenddate" value="<?php echo $ipcenddate; ?>" /> 
              </td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IPC SubmitDate:</td>
              <td >
			 <input type="text"  name="txtipcsubmitdate" id="txtipcsubmitdate" value="<?php echo $ipcsubmitdate; ?>" /> 
              </td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">IPC Receive Date:</td>
              <td >
			 <input type="text"  name="txtipcreceivedate" id="txtipcreceivedate" value="<?php echo $ipcreceivedate; ?>" /> 
              </td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Status:</td>
              <td ><input type="radio"  id="txtstatus" name="txtstatus" value="0" <?php if($status=="0"){ echo "checked='checked'";} else if($status==""){ echo "checked='checked'";} ?>/>Active
			  <input type="radio"  id="txtstatus" name="txtstatus" value="1" <?php if($status=="1"){ echo "checked='checked'";} ?>/>Inactive		  
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
	<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
	<input type="text" name="valueipcno"  id="valueipcno" title="IPC NO" placeholder="IPC NO" style="width:100px"  onkeyup="showResult(module.value,this.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
	<select name="txtipcmonth" id="txtipcmonth" onchange="showResult(module.value,valueipcno.value,this.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)">
	<option value="">Select IPC Month</option>
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
<input type="text" name="valueipcstartdate"  id="valueipcstartdate" title="Start Date" placeholder="Start Date" style="width:100px"  onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,this.value,valueipcenddate.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
<input type="text" name="valueipcenddate"  id="valueipcenddate"  title="End Date" placeholder="End Date" style="width:100px"    onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,this.value,valueipcsubmitdate.value, valueipcreceivedate.value)"/>
<input type="text" name="valueipcsubmitdate"  id="valueipcsubmitdate" title="Submit Date" placeholder="Submit Date" style="width:100px"  onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,this.value, valueipcreceivedate.value)"/>
<input type="text" name="valueipcreceivedate"  id="valueipcreceivedate"  title="Receive Date" placeholder="Receive Date" style="width:100px"    onchange="showResult(module.value,valueipcno.value,txtipcmonth.value,valueipcstartdate.value,valueipcenddate.value,valueipcsubmitdate.value, this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportipcdata.php"/>
<div id="search"></div>
	<div id="without_search">
    
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th align="center" width="3%"><strong>Sr. No.</strong></th>
      <th align="center" width="2%"><strong>
	  <input  type="checkbox"  name="txtChkAll" id=
          "txtChkAll"   form="reports"  onclick="group_checkbox();"/>
		  
		  </strong></th>
      <th align="center" width="10%"><strong>IPC No</strong></th>
      <th width="10%"><strong>IPC Month</strong></th>
      <th width="15%"><strong>IPC Start Date</strong></th>
	  <th width="15%"><strong>IPC End Date</strong></th>
      <th width="15%"><strong>IPC Submit Date</strong></th>
	  <th width="10%"><strong>IPC Receive Date</strong></th>
	  <th width="5%"><strong>Status</strong></th>
      <th align="center" width="15%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
 $sSQL = "select ipcid,ipcno,left(ipcmonth,7) as ipcmonth,ipcstartdate,ipcenddate,ipcsubmitdate,ipcreceivedate,status from ipc";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $ipcid 								= $objDb->getField($i,ipcid);
	  $ipcno 								= $objDb->getField($i,ipcno);
	  $ipcmonth	 							= $objDb->getField($i,ipcmonth);
	  $ipcstartdate							= $objDb->getField($i,ipcstartdate);
	  $ipcenddate 							= $objDb->getField($i,ipcenddate);
	  $ipcsubmitdate	 					= $objDb->getField($i,ipcsubmitdate);
	  $ipcreceivedate						= $objDb->getField($i,ipcreceivedate);
	  $status3								= $objDb->getField($i,status);
	  
	   if($status3=="0")
	  {
	  $status="Active";
	  }
	  else  if($status3=="1")
	  {
	  $status="Inactive";
	  }
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$ipcid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td width="210px"><?=$ipcno;?></td>
<td width="100px"><?=$ipcmonth;?></td>
<td width="180px"  ><?=$ipcstartdate;?></td>
<td width="210px"><?=$ipcenddate;?></td>
<td width="100px"><?=$ipcsubmitdate;?></td>
<td width="180px"  ><?=$ipcreceivedate;?></td>
<td width="180px"  ><?=$status;?></td>

<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
 <a href="ipcdata.php?edit=<?php echo $ipcid;?>"  ><img src="images/edit.png" width="22" height="22"  /></a></td>
 <td width="210px" align="right" ><a href="log_ipcdata.php?trans_id=<?php echo $ipcid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
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
