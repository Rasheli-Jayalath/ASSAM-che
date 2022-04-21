<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
$uname			= $_SESSION['uname'];
$admflag		= $_SESSION['admflag'];
/*$superadmflag	= $_SESSION['superadmflag'];
$payrollflag	= $_SESSION['payrollflag'];
$petrolflag		= $_SESSION['petrolflag'];
$petrolEntry	= $_SESSION['petrolEntry'];
$petrolVerify	= $_SESSION['petrolVerify'];
$petrolApproval	= $_SESSION['petrolApproval'];
$petrolPayment	= $_SESSION['petrolPayment'];*/
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";

$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$itemid						= $_REQUEST['txtitemid'];

$txtcode					= $_REQUEST['txtcode'];
$txtscheduleid				= $_REQUEST['txtscheduleid'];
$txtstartdate				= $_REQUEST['txtstartdate'];
$txtenddate					= $_REQUEST['txtenddate'];
$txtastartdate				= $_REQUEST['txtastartdate'];
$txtaenddate				= $_REQUEST['txtaenddate'];
$txtorder					= $_REQUEST['txtorder'];
$txtbaseline				= $_REQUEST['txtbaseline'];
$txtremarks				   = $_REQUEST['txtremarks'];

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

if(count($txtcode) >= 1){
			
				for($i = 0; $i < count($txtcode); $i++){

 $sSQL = ("INSERT INTO activity (itemid,  code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks) VALUES ($itemid,'$txtcode[$i]', '$txtscheduleid[$i]','$txtstartdate[$i]', '$txtenddate[$i]','$txtastartdate[$i]','$txtaenddate[$i]',$txtorder[$i],$txtbaseline[$i],'$txtremarks[$i]')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$aid = $txtid;
	
	$msg="Saved!";
		}
					}
 
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

<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
    <script type="text/javascript" src="scripts/JsCommon.js"></script>
<script>
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

</script>
<script>
function add_data(id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtcode = document.getElementById('txtcode').value;
var txtscheduleid = document.getElementById('txtscheduleid').value;
var txtstartdate = document.getElementById('txtstartdate').value;
var txtenddate = document.getElementById('txtenddate').value;
var txtastartdate = document.getElementById('txtastartdate').value;
var txtaenddate = document.getElementById('txtaenddate').value;
var txtorder = document.getElementById('txtorder').value;
var txtbaseline = document.getElementById('txtbaseline').value;
var txtweight = document.getElementById('txtweight').value;
var txtremarks = document.getElementById('txtremarks').value;

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp1.open("GET","adddata.php?itemid="+id+"&code="+txtcode+"&secheduleid="+txtscheduleid+"&startdate="+txtstartdate+"&enddate="+txtenddate+"&actualstartdate="+txtastartdate+"&actualenddate="+txtaenddate+"&aorder="+txtorder+"&baseline="+txtbaseline+"&remarks="+txtremarks+"&weight="+txtweight,true);
  xmlhttp1.send();
}

</script>


<script>
function edit_data(id,itemid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
	
      document.getElementById("abc"+itemid).innerHTML=xmlhttp1.responseText;
	   document.getElementById("addnew"+itemid).style.display="none";
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }
var url="editdata.php?aid="+id+"&itemid="+itemid;

  xmlhttp1.open("GET","editdata.php?aid="+id+"&itemid="+itemid,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(aid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtitemid = document.getElementById('itemid').value;
var txtcode = document.getElementById('txtcode').value;
var txtscheduleid = document.getElementById('txtscheduleid').value;
var txtstartdate = document.getElementById('txtstartdate').value;
var txtenddate = document.getElementById('txtenddate').value;
var txtastartdate = document.getElementById('txtastartdate').value;
var txtaenddate = document.getElementById('txtaenddate').value;
var txtorder = document.getElementById('txtorder').value;
var txtbaseline = document.getElementById('txtbaseline').value;
var txtweight = document.getElementById('txtweight').value;
var txtremarks = document.getElementById('txtremarks').value;

  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtitemid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp4.open("GET","updatedata.php?aid="+aid+"&itemid="+txtitemid+"&code="+txtcode+"&secheduleid="+txtscheduleid+"&startdate="+txtstartdate+"&enddate="+txtenddate+"&actualstartdate="+txtastartdate+"&actualenddate="+txtaenddate+"&aorder="+txtorder+"&baseline="+txtbaseline+"&remarks="+txtremarks+"&weight="+txtweight,true);
  xmlhttp4.send();
}

</script>
<script>
function cancel_data(id) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp1.open("GET","canceldata.php?itemid="+id,true);
  xmlhttp1.send();
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

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
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

function target_popup() {
   var myForm = document.getElementById('stgt_goal').value;

}
</script>
<style>
.button
{
	background: #0099ff none repeat scroll 0 0;
    color: black;
    padding: 6px;
    text-decoration: none;


}
</style>
<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 


<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}
</style>

</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<h1> Main Data Entry Control Panel</h1>
<form name="reports" id="reports"  method="post"  style="display:inline-block; width:100%"> 
		<div style="margin-bottom:12px;">
		<a class="button" href="javascript:void(null);" onclick="window.open('strategic_goal.php', 'Add Strategic Goal','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Strategic Goal</a>
		 <a class="button" href="javascript:void(null);" onclick="window.open('outcome.php', 'Add Outcome','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Outcome</a>
		  <a class="button" href="javascript:void(null);" onclick="window.open('output.php', 'Add Output','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Output</a>
		  <input type="submit" value="Add Resources" formaction="resources.php"/>
		  <a class="button" href="javascript:void(null);" onclick="window.open('activity.php', 'Add Activity','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Activity</a>		
		</div>
		
<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueweight"  id="valueweight" title="Weight" placeholder="Weight" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,valueweight.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="report.php"/>
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%" > 
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <th align="center" width="50%"><strong>Item Name</strong></th>
	  <th align="center" width="5%"><span class="label">Stage</span></th>
	  <th align="center" width="5%"><span class="label">Item Code</span></th>
	  <th width="5%"><strong>Weight</strong></th>
	   <th align="center" width="5%"><span class="label">Isentry</span></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reports"  onclick="group_checkbox();"/></strong></th>
	   <th align="center" width="20%"><strong>Action
     </strong></th>
	 <th align="center" width="5%"><strong>Log
     </strong></th>
	 
     </tr>

<?php
		 $sSQL = "SELECT * FROM maindata where stage='Strategic Goal' or stage='Outcome' or stage='Output'  or stage='Activity' order by parentgroup, parentcd";
		$sqlresult = mysql_query($sSQL);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from maindata where itemid = ".$cdlist[0];
	$cdsqlresult12 = mysql_query($cdsql2);
	$cddata1 = mysql_fetch_array($cdsqlresult12);
	$itemname = $cddata1['itemname'];
	
				

				
?>

		<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from maindata where itemid = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$itemid = $cddata['itemid'];
		$parentcd = $cddata['parentcd'];
		$stage=$cddata['stage'];
		$activitylevel=$cddata['activitylevel'];
		if($cddata['isentry']==0)
				{
				$isentry1="No";
				}
				else
				{
				$isentry1="Yes";
				}

			?>
<script>
function AddNewSizeProject<?php echo $itemid; ?>(){

	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:right; width:100px"/><input type="text" name="txtcode" id="txtcode"  size="25" style="text-align:right; width:100px"/>';
	var td4 = '<input type="text" name="txtstartdate" id="txtstartdate"  size="25" style="text-align:right; width:100px"/>';
	var td5 = '<input type="text" name="txtenddate" id="txtenddate"  size="25" style="text-align:right; width:100px"/>';
	var td6 = '<input type="text" name="txtastartdate" id="txtastartdate"  size="25" style="text-align:right; width:100px"/>';
	var td7 = '<input type="text" name="txtaenddate"  id="txtaenddate"  size="25" style="text-align:right; width:100px"/>';
	var td8 = '<input type="text" name="txtorder"  id="txtorder"  size="25" style="text-align:right; width:100px"/>';
	var td9 = '<input type="text" name="txtbaseline" id="txtbaseline"  size="25" style="text-align:right; width:100px"/>';
	var td10 = '<input type="text" name="txtweight" id="txtweight"  size="25" style="text-align:right; width:100px"/>';
	var td11 = '<input type="text" name="txtremarks" id="txtremarks"  size="25" style="text-align:right; width:100px"/>';
	var td12 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
	var td3 = '<select name="txtscheduleid" id="txtscheduleid" style="width:70px">' + "\n";

	
	<?php 
	$sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			?>
	td3 	+= "\t" + '<option value="<?php echo $row3g['schedulecode'];?>"><?php echo $row3g['schedulecode'].": ".$row3g['resource'];?></option>' + "\n";
	<?php }?>
	
	td3 	+= '</select>' + "\n";
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	var arrTds = new Array(td1, td2, td3,td4, td5, td6,td7, td8, td9,td10,td11,td12);
	doAddTr(arrTds, 'tblPrdSizesProject<?php echo $itemid; ?>');
}
</script>			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td rowspan="2"></td>
			<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parentcd==0){	
			echo "<b>".$itemname."</b>";
			}
			else
			{
			echo $h.$cddata['itemname'];
		
			}
		  
		  
		   ?>
		</td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">		</td>
		<?php if($stage=='Strategic Goal')
		{
		$editlink='strategic_goal.php';
		$redirect="outcome.php?item=$itemid";
		$redirect_title="Add Outcome";
		}
		else if($stage=='Outcome')
		{
		$editlink='outcome.php';
		$redirect="output.php?item=$itemid";
		$redirect_title="Add Output";
		}
		else if($stage=='Output')
		{
		$editlink='output.php';
		$redirect="activity.php?item=$itemid";
		$redirect_title="Add Activity";
		}
		else if($stage=='Activity' && $activitylevel==0)
		{
		$editlink='activity.php';
		$redirect="subactivity.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		else if($stage=='Activity' && $activitylevel>0)
		{
		$editlink='subactivity.php';
		$redirect="subactivity.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		$deletelink='subactivity.php';
		$deletelinkoutput='output.php';
		$deletelinkoutcome='outcome.php';
		$deletelinksg='strategic_goal.php';
		  ?>
		
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
		
		  <?php if($cddata['isentry']==0)
		{	
		?>
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		<?php
		 }?>
		 <?php  if($stage=='Activity' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a> | <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Activity and all of its child?')">Delete</a>
		<?php }else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a> | 
		
		<?php if($stage=='Strategic Goal') {?>
		<a href="<?php echo $deletelinkoutput; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Strategic Goal and all of its child?')">Delete</a>
		<?php
		}
		else if($stage=='Outcome') {?>
		<a href="<?php echo $deletelinkoutput; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Outcome and all of its child?')">Delete</a>
		<?php
		}
		else if($stage=='Output') {?>
		<a href="<?php echo $deletelinkoutput; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Output and all of its child?')">Delete</a>
		<?php
		}
		else if($stage=='Activity') {?>
		<a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Activity and all of its child?')">Delete</a>
		<?php
		}
		?>
		
		<?php } ?>
		 	 </td>
		 <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="log.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" target="_blank">Log</a>
	
		 </td>
	
		</tr>
		<tr>
		<td colspan="8">
			 <?php
	if($cddata['isentry']==1)
		{	
		?> 
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
		
			var id=<?php echo $itemid; ?>;
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp3=new XMLHttpRequest();
			  } else {  // code for IE6, IE5
				xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			
			  xmlhttp3.onreadystatechange=function() {
				if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
				
					
					document.getElementById("abc"+id).innerHTML=xmlhttp3.responseText;
					document.getElementById("addnew"+id).style.display="block";
					
				 // document.getElementById("search").style.border="1px solid #A5ACB2";
				  
				
				 
				}
			  }
			
			  xmlhttp3.open("GET","reloadmaindata.php?itemid="+id,true);
			  xmlhttp3.send();
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 

	<?php /*?><table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                    <tr>
                       <th style="width:5%;"></th>
                        <th style="width:15%;"><?php echo "Code";?></th>
						<th style="width:25%;"><?php echo "Resource";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						 <th style="width:15%;"><?php echo "Actual Start Date";?></th>
						<th style="width:25%;"><?php echo "Actual End Date";?></th>
						 <th style="width:15%;"><?php echo "Order";?></th>
						<th style="width:25%;"><?php echo "Base Line";?></th>
						<th style="width:5%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Remarks";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
				
			<?php $sql_a="Select * from activity where itemid=$itemid";
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$aid=$row3_a['aid'];
			?>
			
			<tr >
			
			<td><?php echo $i; ?></td>
			<td><?=$row3_a['code'];?></td>
			<td><?=$row3_a['secheduleid'];?></td>
			<td><?=$row3_a['startdate'];?></td>
			<td ><?=$row3_a['enddate'];?></td>
			<td ><?=$row3_a['actualstartdate'];?></td>
			<td><?=$row3_a['actualenddate'];?></td>
			<td><?=$row3_a['aorder'];?></td>
			<td><?=$row3_a['baseline'];?></td>
			<td><?=$row3_a['weight'];?></td>
			<td><?=$row3_a['remarks'];?></td>
			<td><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?> )"  /></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			?>	
					
                </tbody>
            </table><?php */?>
			</div>	
			 <div id="addnew<?php echo $itemid; ?>" style="float:right;">
			 <a onClick="AddNewSizeProject<?php echo $itemid; ?>();" href="javascript:void(null);">Add New</a></div>
			
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancel_data(<?php echo $itemid; ?>)" />

	</div>
		  </div>
		  <?php
		  }
		  ?>
		</td></tr>
		
	
	<?php        
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
