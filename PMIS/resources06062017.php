<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= RESOURCE;
$uname			= $_SESSION['uname'];
/*$admflag		= $_SESSION['admflag'];
$superadmflag	= $_SESSION['superadmflag'];
$payrollflag	= $_SESSION['payrollflag'];
$petrolflag		= $_SESSION['petrolflag'];
$petrolEntry	= $_SESSION['petrolEntry'];
$petrolVerify	= $_SESSION['petrolVerify'];
$petrolApproval	= $_SESSION['petrolApproval'];
$petrolPayment	= $_SESSION['petrolPayment'];

$empId			= $_GET['empId'];
$empId			= 1;*/
$edit			= $_GET['edit'];

if ($uname==null  ) {
header("Location: index.php?init=3");
}
$objDb  = new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$delete						= $_REQUEST['delete'];
$txtresource				= $_REQUEST['txtresource'];
$txtunit					= $_REQUEST['txtunit'];
$txtquantity				= $_REQUEST['txtquantity'];
$txtschedulecode			= $_REQUEST['txtschedulecode'];
$txtboqcode					= $_REQUEST['txtboqcode'];

if($clear!="")
{
$txtresource				= '';
$txtunit					= '';
$txtquantity				= '';
$txtschedulecode 			= '';
$txtboqcode 				= '';
}

if($saveBtn != "")
{



	
$sSQL = ("INSERT INTO resources (resource,unit,quantity,schedulecode, boqcode) VALUES ('$txtresource','$txtunit',$txtquantity, '$txtschedulecode', '$txtboqcode')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$resource_id = $txtid;
	$msg="Saved!";
	$log_module  = "resources Module";
	$log_title   = "Add Resource Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO resources_log (log_module,log_title,log_ip, resource, unit,quantity,schedulecode,boqcode,transaction_id) VALUES ('$log_module','$log_title','$log_ip', '$txtresource', '$txtunit', $txtquantity,'$txtschedulecode','$txtboqcode',$resource_id)");
	$objDb->execute($sSQL);

}

if($updateBtn !=""){
	
$uSql = "Update resources SET 
			 resource           	= '$txtresource',
			 unit					= '$txtunit',
			 quantity				= $txtquantity,
			 schedulecode         	= '$txtschedulecode',
			 boqcode    			= '$txtboqcode'
			where rid 				= $edit ";
		  
 	if($objDb->execute($uSql)){
	$log_module						= "resources Module";
	$log_title						= "Update Resource Record";
	$log_ip							= $_SERVER['REMOTE_ADDR'];
	
	$sSQL2 = ("INSERT INTO resources_log (log_module,log_title,log_ip, resource, unit,quantity,schedulecode,boqcode,transaction_id) VALUES ('$log_module','$log_title','$log_ip', '$txtresource', '$txtunit', $txtquantity,'$txtschedulecode','$txtboqcode',$edit)");
		$objDb->execute($sSQL2);
		$txtresource				= '';
		$txtunit					= '';
		$txtquantity				= '';
		$txtschedulecode 			= '';
		$txtboqcode 				= '';
		
	}
}


if($delete != ""){

$eSql_child2 = "update activity set rid=0, secheduleid='0' where rid=$delete";
mysql_query($eSql_child2);
$eSql_plrid= "delete from planned where rid=$delete";
mysql_query($eSql_plrid);
$eSql_pgrid = "delete from progress where rid=$delete";
mysql_query($eSql_pgrid);
$eSql_rid = "delete from resources where rid=$delete";
mysql_query($eSql_rid);

//header("Location: resources.php");	
}


if($edit != ""){
 $eSql = "Select * from resources where rid='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $resource 					= $objDb->getField($i,resource);
	  $unit 						= $objDb->getField($i,unit);
	  $quantity 					= $objDb->getField($i,quantity);
	  $schedulecode 				= $objDb->getField($i,schedulecode);
	  $boqcode 						= $objDb->getField($i,boqcode);
	 	
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
function showResult(strmodule,strresource,strtunit,strquantity,strschedulecode,strboqcode) {
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
  xmlhttp.open("GET","search.php?module="+strmodule+"&resource="+strresource+"&unit="+strtunit+"&quantity="+strquantity+"&schedulecode="+strschedulecode+"&boqcode="+strboqcode,true);
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

<!--<script>
function getLocked(status)
{

if(status=="Pending" || status=="Paid")
{
document.getElementById("txtlocked").value="Locked";
	 document.getElementById("txtlocked").disabled=true;
}
else
{
document.getElementById("txtlocked").value="Unlocked";
	 document.getElementById("txtlocked").disabled=false;
}
	
}
</script>-->
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmresources" id="frmresources" action=""  method="post" onsubmit="" enctype="multipart/form-data">
	  
	  <table width="100%" border="0"  align="center" cellpadding="1" cellspacing="1">
            <tr>
            <td colspan="2"><h1>Resources</h1></td>
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
              <td class="label">&nbsp;</td>
              <td class="label">Resource Name:</td>
              <td >
			 <input type="text"  name="txtresource" id="txtresource" value="<?php echo $resource; ?>" />            </td>
             </tr>
			<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Unit:</td>
              <td >
			 <input type="text"  name="txtunit" id="txtunit" value="<?php echo $unit; ?>" /> 
              </td>
             </tr>
			<tr>
			  <td class="label">&nbsp;</td>
              <td class="label">Quantity:</td>
              <td > <input type="text"  name="txtquantity" id="txtquantity" value="<?php echo $quantity; ?>" /> </td>
           	</tr>
            <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Schedule Code:</td>
              <td ><input id="txtschedulecode" name="txtschedulecode" type="text" value="<?php echo $schedulecode; ?>"/></td>
             </tr>
			 <tr>
              <td class="label">&nbsp;</td>
              <td class="label">Boq Code:</td>
              <td >
			  <select name="txtboqcode"  >
			  <option value="0">Select BOQ Code:</option>
			  <?php $sqlg="Select * from boq";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$boqid=$row3g['boqid'];
			if($boqid==$boqcode)
			{
			$sel="selected='selected'";
			}
			
			else
			{
			$sel="";
			}
			?>
			  <option  value="<?php echo $boqid;?>" <?php echo $sel; ?> ><?php echo $row3g['boqid']. ": ".$row3g['boqcode']. " - ". $row3g['boqitem'] ; ?> </option>
			  <?php
			  }
			  ?>
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
	
	<form name="reports" id="reports"  method="post"   onsubmit="return atleast_onecheckbox(event)" style="display:inline-block"> 
	<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valueresource.value,valueunit.value,valuequantity.value,valueschedulecode.value,valueboqcode.value)"/>
<input type="text" name="valueresource"  id="valueresource" title="Resource" placeholder="Resource Name" style="width:100px"  onkeyup="showResult(module.value,this.value,valueunit.value,valuequantity.value,valueschedulecode.value,valueboqcode.value)"/>
<input type="text" name="valueunit"  id="valueunit"  title="Unit" placeholder="Unit" style="width:100px"    onkeyup="showResult(module.value,valueresource.value,this.value,valuequantity.value,valueschedulecode.value,valueboqcode.value)"/>
<input type="text" name="valuequantity"  id="valuequantity" title="Quantity" placeholder="Quantity" style="width:100px"    onkeyup="showResult(module.value,valueresource.value,valueunit.value,this.value,valueschedulecode.value,valueboqcode.value)"/>

<input type="text" name="valueschedulecode"  id="valueschedulecode" title="Schedule Code" placeholder="Schedule Code" style="width:100px"    onkeyup="showResult(module.value,valueresource.value,valueunit.value,valuequantity.value,this.value,valueboqcode.value)"/>

<input type="text" name="valueboqcode"  id="valueboqcode" title="Boq Code" placeholder="Boq Code" style="width:100px"    onkeyup="showResult(module.value,valueresource.value,valueunit.value,valuequantity.value,valueschedulecode.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="report.php"/>
<div id="search"></div>
	<div id="without_search">
    
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th align="center" width="5px"><strong>Sr. No.</strong></th>
      <th align="center"><strong>
	  <input  type="checkbox"  name="txtChkAll" id=
          "txtChkAll"   form="reports"  onclick="group_checkbox();"/>
		  
		  </strong></th>
      <th align="center" width="25%"><strong>Resource Name </strong></th>
      <th width="10%"><strong>Unit</strong></th>
      <th width="15%"><strong>Quantity</strong></th>
      <th align="center" width="20%"><span class="label">Schedule Code</span></th>
	 <th align="center" width="10%"><span class="label">Boq Code</span></th>
	 <th align="center" width="10%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
 $sSQL = " Select * from resources";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $rid 							= $objDb->getField($i,rid);
	  $resource 					= $objDb->getField($i,resource);
	  $unit 						= $objDb->getField($i,unit);
	  $quantity 					= $objDb->getField($i,quantity);
	  $schedulecode 				= $objDb->getField($i,schedulecode);
	  $boqcode 						= $objDb->getField($i,boqcode);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$rid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td width="210px"><?=$resource;?></td>
<td width="100px"><?=$unit;?></td>
<td width="210px" align="right"><?= number_format($quantity, 2, '.', '');?></td>
<td width="180px"  ><?=$schedulecode;?></td>
<td width="180px"  ><?=$boqcode;?></td>


<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
 <a href="resources.php?edit=<?php echo $rid;?>"  >Edit</a> | <a href="resources.php?delete=<?php echo $rid;?>"  onclick="return confirm('Are you sure you want to delete this Resource?')" >Delete</a></td>
 <td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $rid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
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
