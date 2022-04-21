<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= "Activity Data";
$uname			= $_SESSION['uname'];
/*$admflag		= $_SESSION['admflag'];
$superadmflag	= $_SESSION['superadmflag'];
$payrollflag	= $_SESSION['payrollflag'];
$petrolflag		= $_SESSION['petrolflag'];
$petrolEntry	= $_SESSION['petrolEntry'];
$petrolVerify	= $_SESSION['petrolVerify'];
$petrolApproval	= $_SESSION['petrolApproval'];
$petrolPayment	= $_SESSION['petrolPayment'];*/
if ($uname==null  ) {
header("Location: index.php?init=3");
}
$itemid			= $_GET['subaid'];
$edit		= $_GET['edit'];
$objDb  		= new Database( );
if($itemid!="")
{
 $sqlgx="Select itemname, parentcd,parentgroup from maindata where stage='Activity' and itemid=$itemid";
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
 if ($i==0){ $title="Strategic Goal";  }
 else if ($i==1){ $title="Outcome"; }
  else if ($i==2){  $title="Output";  }
   else if ($i==3){ $title="Activity"; }
    else if ($i>3){ $title="Subactivity"; }
$trail.="<table><tr><td><b>".$title;

 $trail.=": </b></td><td>".$itemname_1; 
 $trail.="</td></tr></table>";

}

 }
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtcode					= $_REQUEST['txtcode'];
$txtscheduleid				= $_REQUEST['txtscheduleid'];
$txtstartdate				= $_REQUEST['txtstartdate'];
$txtenddate					= $_REQUEST['txtenddate'];
$txtastartdate				= $_REQUEST['txtastartdate'];
$txtaenddate				= $_REQUEST['txtaenddate'];
$txtorder					= $_REQUEST['txtorder'];
$txtbaseline				= $_REQUEST['txtbaseline'];
$txtremarks					= $_REQUEST['txtremarks'];

if($clear!="")
{

$txtcode 					= '';
$txtscheduleid 				= '';
$txtstartdate				= '';
$txtenddate 				= '';
$txtastartdate 				= '';
$txtaenddate				= '';
$txtorder 					= '';
$txtbaseline 				= '';
$txtremarks					= '';

}

if($saveBtn != "")
{
$parentcd=0;	
 $sSQL = ("INSERT INTO activity (itemid,  code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks) VALUES ($itemid,'$txtcode', '$txtscheduleid','$txtstartdate', '$txtenddate','$txtastartdate','$txtaenddate',$txtorder,$txtbaseline,'$txtremarks')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$aid = $txtid;
	
	$msg="Saved!";
	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	 $sSQL = ("INSERT INTO activity_log (log_module,log_title,log_ip, itemid, code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$txtcode', '$txtscheduleid','$txtstartdate', '$txtenddate','$txtastartdate','$txtaenddate',$txtorder,$txtbaseline,'$txtremarks',$aid)");
	$objDb->execute($sSQL);
 
}

if($updateBtn !=""){
	
 $uSql = "Update activity SET 
			
			 code         		= '$txtcode',
			 secheduleid  		= '$txtscheduleid',
			 startdate			= '$txtstartdate',
			 enddate        	= '$txtenddate',
			 actualstartdate  	= '$txtastartdate',
			 actualenddate		= '$txtaenddate',
			 aorder        		= $txtorder,
			 baseline  			= $txtbaseline,
			 remarks			= '$txtremarks'			
			where aid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL2 = ("INSERT INTO activity_log (log_module,log_title,log_ip, itemid, code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$txtcode', '$txtscheduleid','$txtstartdate', '$txtenddate','$txtastartdate','$txtaenddate',$txtorder,$txtbaseline,'$txtremarks',$edit)");
	$objDb->execute($sSQL2);
	

		
		
		$txtcode 					= '';
		$txtscheduleid 				= '';
		$txtstartdate				= '';
		$txtenddate 				= '';
		$txtastartdate 				= '';
		$txtaenddate				= '';
		$txtorder 					= '';
		$txtbaseline 				= '';
		$txtremarks					= '';
		
	}
	header("location: activityentry.php?subaid=".$itemid);

}

if($edit != ""){
 $eSql = "Select * from activity where aid=$edit";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $code 					= $objDb->getField($g,code);
	  $secheduleid	 			= $objDb->getField($g,secheduleid);
	  $startdate				= $objDb->getField($g,startdate);
	  $enddate 					= $objDb->getField($g,enddate);
	  $actualstartdate 			= $objDb->getField($g,actualstartdate);
	  $actualenddate	 		= $objDb->getField($g,actualenddate);
	  $aorder					= $objDb->getField($g,aorder);
	  $baseline 				= $objDb->getField($g,baseline);
	  $remarks 					= $objDb->getField($g,remarks);
	 	
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

function showResult(strmodule,strcode,strschdid,strstartdate,strenddate,strastartdate,straenddate,strremarks) {

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
 
  xmlhttp.open("GET","search.php?module="+strmodule+"&code="+strcode+"&schdid="+strschdid+"&startdate="+strstartdate+"&enddate="+strenddate+"&astartdate="+strastartdate+"&aenddate="+straenddate+"&remarks="+strremarks,true);

  xmlhttp.send();
}

</script>
<script type="text/javascript">
		 
 $(function() {
 $('#txtstartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
   $('#txtenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#txtastartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
   $('#txtaenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });

</script>

<script type="text/javascript">
		 
 $(function() {
 $('#valuestartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueastartdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
  $(function() {
 $('#valueaenddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });


</script>
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
	  <?php
	  $eSql_l = "Select itemname,parentcd from maindata where itemid='$itemid'";
  	  $objDb -> query($eSql_l);
  	  $itemname					= $objDb->getField(0,itemname);
	  $parentcd					= $objDb->getField(0,parentcd);
	  ?>
	 
	  <table width="100%" border="0"  align="center" cellpadding="1" cellspacing="1">
	  <tr><td colspan="4"> <?php echo $trail; ?></td></tr>
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
            <td colspan="3"><h1> <?php echo $action."Data"; ?></h1></td><td></td></tr>
			<tr>
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
              <td class="label">&nbsp;</td>
              <td class="label">Code:</td>
              <td ><input id="txtcode" name="txtcode" type="text" value="<?php echo $code; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Resource:</td>
              <td >
			  <select name="txtscheduleid" id="s4a"  class="s4a" >
			   
			  <?php $ress_array=explode(",", $secheduleid); 
			  
			  
			 $sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			
				if($secheduleid == $row3g['schedulecode'])
				{
				$sele = " selected" ;
				}
				else
				{
				$sele = "" ;
				}
				
				
			?>
			  <option value="<?php echo $row3g['schedulecode'];?>"  <?php echo $sele; ?>><?php echo $row3g['schedulecode']. ": ".$row3g['resource']; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
			  
			 </td>
             </tr>
			 
			 	<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Start Date :</td>
              <td >
			 <input type="text"  name="txtstartdate" id="txtstartdate" value="<?php echo $startdate; ?>" /> 
              </td>
             </tr>
			  <tr>
              <td class="label">&nbsp;</td>
              <td class="label">End Date:</td>
              <td ><input id="txtenddate" name="txtenddate" type="text" value="<?php echo $enddate; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Actual Start Date:</td>
              <td ><input id="txtastartdate" name="txtastartdate" type="text" value="<?php echo $actualstartdate; ?>"/></td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Actual End Date:</td>
              <td >
			 <input type="text"  name="txtaenddate" id="txtaenddate" value="<?php echo $actualenddate; ?>" /> 
              </td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Order:</td>
              <td ><input id="txtorder" name="txtorder" type="text" value="<?php echo $aorder; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Baseline:</td>
              <td ><input id="txtbaseline" name="txtbaseline" type="text" value="<?php echo $baseline; ?>"/></td>
             </tr>
			 <tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Remarks:</td>
              <td >
			  <textarea name="txtremarks" id="txtremarks" cols="25" rows="5"><?php echo $remarks; ?></textarea>
			
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
	
	<form name="reports" id="reports"  method="post" target="_blank"  onsubmit="return atleast_onecheckbox(event)" style="display:inline-block"> 
	<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuecode.value,valueschedid.value,valuestartdate.value,valueenddate.value,valueastartdate.value,valueaenddate.value,valueremarks.value)"/>
	
<input type="text" name="valuecode"  id="valuecode" title="Code" placeholder="Code" style="width:100px"  onkeyup="showResult(module.value,this.value,valueschedid.value,valuestartdate.value,valueenddate.value,valueastartdate.value,valueaenddate.value,valueremarks.value)"/>
<input type="text" name="valueschedid"  id="valueschedid"  title="Resource" placeholder="Resource" style="width:100px"    onkeyup="showResult(module.value,valuecode.value,this.value,valuestartdate.value,valueenddate.value,valueastartdate.value,valueaenddate.value,valueremarks.value)"/>
<input type="text" name="valuestartdate"  id="valuestartdate" title="Start Date" placeholder="Start Date" style="width:100px"    onchange="showResult(module.value,valuecode.value,valueschedid.value,this.value,valueenddate.value,valueastartdate.value,valueaenddate.value,valueremarks.value)"/>
<input type="text" name="valueenddate"  id="valueenddate" title="End Date" placeholder="End Date" style="width:100px"    onchange="showResult(module.value,valuecode.value,valueschedid.value,valuestartdate.value,this.value,valueastartdate.value,valueaenddate.value,valueremarks.value)"/>
<input type="text" name="valueastartdate"  id="valueastartdate" title="Actual Start Date" placeholder="Actual Start Date" style="width:100px"    onchange="showResult(module.value,valuecode.value,valueschedid.value,valuestartdate.value,valueenddate.value,this.value,valueaenddate.value,valueremarks.value)"/>
<input type="text" name="valueaenddate"  id="valueaenddate" title="Actual End Date" placeholder="Actual End Date" style="width:100px"    onchange="showResult(module.value,valuecode.value,valueschedid.value,valuestartdate.value,valueenddate.value,valueastartdate.value,this.value,valueremarks.value)"/>
<input type="text" name="valueremarks"  id="valueremarks" title="Remarks" placeholder="Remarks" style="width:100px"    onkeyup="showResult(module.value,valuecode.value,valueschedid.value,valuestartdate.value,valueenddate.value,valueastartdate.value,valueaenddate.value,this.value)"/>
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
	 <th align="center" width="5%"><span class="label">Code</span></th>
     <th align="center" width="5%"><span class="label">Resource</span></th>
	 <th align="center" width="10%"><span class="label">Start Date</span></th>
	 <th align="center" width="10%"><span class="label">End Date</span></th>
	 <th align="center" width="10%"><span class="label">Actual Start Date</span></th>
	 <th align="center" width="10%"><span class="label">Actual End Date</span></th>
	 <th align="center" width="5%"><span class="label">Order</span></th>
	 <th align="center" width="10%"><span class="label">Baseline</span></th>
	 <th align="center" width="10%"><span class="label">Remarks</span></th>
	 <th align="center" width="10%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
 $sSQL = " Select * from activity where itemid=$itemid";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $aid						= $objDb->getField($i,aid);
	  $itemid						= $objDb->getField($i,itemid);
	  $code							= $objDb->getField($i,code);
	  $scheduleid	 				= $objDb->getField($i,secheduleid);
	  $startdate					= $objDb->getField($i,startdate);
	  $enddate 						= $objDb->getField($i,enddate);
	  $actualstartdate 				= $objDb->getField($i,actualstartdate);
	  $actualenddate	 			= $objDb->getField($i,actualenddate);
	  $aorder						= $objDb->getField($i,aorder);
	  $baseline 					= $objDb->getField($i,baseline);
	  $remarks 						= $objDb->getField($i,remarks);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}

?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$aid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td><?=$code;?></td>
<td><?=$scheduleid;?></td>
<td><?=$startdate;?></td>
<td ><?=$enddate;?></td>
<td ><?=$actualstartdate;?></td>
<td><?=$actualenddate;?></td>
<td><?=$aorder;?></td>
<td><?=$baseline;?></td>
<td><?=$remarks;?></td>


<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp; 
<a href="activityentry.php?edit=<?php echo $aid;?>&subaid=<?php echo $itemid;?>"  ><img src="images/edit.png" width="22" height="22"/></a></td>
 <td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $aid; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
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
