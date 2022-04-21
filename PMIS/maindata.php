<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
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
$temp_id=1;
/*$btem="SELECT * FROM `baseline_template` WHERE temp_is_default=1";
			  $resbtemp=mysql_query($btem);
			  $row3tmpg=mysql_fetch_array($resbtemp);
			  $temp_id=$row3tmpg["temp_id"];*/
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
  
 <?php /*?> <link rel="stylesheet" type="text/css" media="all" href="calender/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="calender/calendar.js"></script>
  <script type="text/javascript" src="calender/lang/calendar-en.js"></script>
  <script type="text/javascript" src="calender/calendar-setup.js"></script><?php */?>
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
var txtweight = document.getElementById('txtweight').value;

  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		// document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp1.open("GET","adddata.php?itemid="+id+"&code="+txtcode+"&secheduleid="+txtscheduleid+"&startdate="+txtstartdate+"&enddate="+txtenddate+"&actualstartdate="+txtastartdate+"&actualenddate="+txtaenddate+"&weight="+txtweight,true);
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
var txtweight = document.getElementById('txtweight').value;

  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtitemid).innerHTML=xmlhttp4.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp4.open("GET","updatedata.php?aid="+aid+"&itemid="+txtitemid+"&code="+txtcode+"&secheduleid="+txtscheduleid+"&startdate="+txtstartdate+"&enddate="+txtenddate+"&actualstartdate="+txtastartdate+"&actualenddate="+txtaenddate+"&weight="+txtweight,true);
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
		 //document.getElementById("addnew"+id).style.display="block";
		
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

function add_sd(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_ed(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_asd(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  function add_aed(fieldid)
{
 $('#'+fieldid).datepicker({ dateFormat: 'yy-mm-dd' }).val();
// alert("123");

  }
  
  
</script>

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
<br />
<h1> <?php echo ACT_ENTRY_PANEL;?></h1>
<form name="reports" id="reports"  method="post" onsubmit="return atleast_onecheckbox(event)"  style="display:inline-block; width:100%; margin-top:10px;"> 
		<div style="margin-bottom:12px;">
		<?php  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
		<a class="button" href="javascript:void(null);" onclick="window.open('subactivity.php', 'Add Activity','width=550px,height=550px,scrollbars=yes');" ><?php echo ADD_ACT;?></a>
		
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="button" ><?php echo ADD_ACT;?></a>
		
		<?php
		}
		?>	
		</div>
		
<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueweight"  id="valueweight" title="Weight" placeholder="Weight" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,valueweight.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="report.php" />
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%" > 
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <?php
	  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
      <th width="30%" style="text-align:center; vertical-align:middle"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  else
	  {
	  ?>
	   <th style="text-align:center; vertical-align:middle" width="50%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  ?>
	  <th style="text-align:center; vertical-align:middle" width="5%"><span class="label"><?php echo CODE;?></span></th>
	  <th style="text-align:center; vertical-align:middle" width="5%"><span class="label"></span><?php echo IS_ENTRY; ?></span></th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><span class="label"><?php echo RESOURCE;?></span></th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><?php echo START;?> <br />(yyyy-mm-dd)</th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><?php echo END;?> <br />(yyyy-mm-dd)</th>
	  <th style="text-align:center; vertical-align:middle" width="10%"><?php echo AVAILED;?></th>
      <th style="text-align:center; vertical-align:middle" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reports"  onclick="group_checkbox();"/></strong></th>
	    <?php
	  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
	   <th style="text-align:center; vertical-align:middle" width="13%"><?php echo ACTION; ?>
  </th>
	 <?php
	 }
	 ?>
	 <th style="text-align:center; vertical-align:middle" width="2%"><?php echo LOG;?>
     </th>
	 
     </tr>

<?php
		 $sSQL = "SELECT * FROM maindata  order by parentgroup, parentcd";
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
					elseif($j==6)
					{
					
					//brown
					$colorr="#99CCCC";
					}
					elseif($j==7)
					{
					
					//brown
					$colorr="#CC66CC";
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
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
		
		<?php 
		if($isentry1=="Yes")
		{
		
		$sql_b="Select * from activity where itemid=$itemid AND temp_id=$temp_id";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$aid=$row3_b['aid'];
			?>
			
			
			
			
			  <?php  
			   
			  
				 $sqlg="Select * from baseline where rid=".$row3_b['rid'] ;
				$resg=mysql_query($sqlg);
				$row3g=mysql_fetch_array($resg);
				
							
				?>
				
				<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><?php if($row3g['base_desc']!="") { echo $row3g['base_desc']; } else { echo "&nbsp;"; }?></td>
				
              
			<td style=" font-size:10px; text-align:center;  color: #000000; background-color: <?php echo $colorr; ?>"><?=$row3_b['startdate'];?></td>
			<td style=" font-size:10px; text-align:center;  color: #000000; background-color: <?php echo $colorr; ?>"><?=$row3_b['enddate'];?></td>
			<td style=" font-size:10px;  text-align:right;  color: #000000; background-color: <?php echo $colorr; ?>"><?=$row3_b['baseline'];?></td>
			<?php
			$i=$i+1;
			}
			}
			else
			{
			?>
            
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"></td>
			<?php
			}
			?>
		<td style=" font-size:10px; text-align:center;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">		</td>
		<?php  if($activitylevel==0)
		{
		$editlink='subactivity.php';
		$redirect="subactivity.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		else if($activitylevel>0)
		{
		$editlink='subactivity.php';
		$redirect="subactivity.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		$deletelink='subactivity.php';
		$deletelinkoutput='output.php';
		
		  ?>
		
			 <?php
	  if($mdataentry_flag==1 || $mdataadm_flag==1)
	{
	?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
		
		  <?php if($cddata['isentry']==0)
		{	
		?>
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=550,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		<?php
		 }?>
		 <?php  if($activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=550,height=550,scrollbars=yes');" >Edit</a> 
		
		<?php if($mdataadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Activity and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=550,height=550,scrollbars=yes');" >Edit</a>  
		
		<?php 
			 if($mdataadm_flag==1)
		{
		?>
		|
	
			<a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Activity and all of its child?')">Delete</a>
			<?php
			
		}
		?>
		
		<?php } ?>
		 	 </td>
		<?php
		}
		?>
		 <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="log.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" target="_blank"><?php echo LOG;?></a>
	
		 </td>
	
		</tr>
		<tr>
		<td colspan="10">
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
					//document.getElementById("addnew"+id).style.display="block";
					
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
