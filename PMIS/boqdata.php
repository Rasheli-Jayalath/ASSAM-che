<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= BOQDATA;


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
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$aorder_list=$_POST["aorder"];
	$item_list=$_POST["itemid"];
	$size_l=sizeof($item_list);
	$size_a=sizeof($aorder_list);
	$msg="";
	if($size_l==$size_a)
	{
	for($i=0; $i<$size_a;$i++)
	{
		$sq="Update boqdata SET aorder='".$aorder_list[$i]."' WHERE itemid=".$item_list[$i];
		mysql_query($sq);
	}
	$msg= "Order has been updated";
	}
	
}
$eSqls = "Select * from project_currency ";
  $objDb -> query($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->getCount();
	if($eeCount > 0){
	  $cur_1_rate 					= $objDb->getField(0,cur_1_rate);
	  $cur_2_rate 					= $objDb->getField(0,cur_2_rate);
	  $cur_3_rate 					= $objDb->getField(0,cur_3_rate);
	  $base_cur 				= $objDb->getField(0,base_cur);
	  $cur_1 					= $objDb->getField(0,cur_1);
	  $cur_2 					= $objDb->getField(0,cur_2);
	  $cur_3 					= $objDb->getField(0,cur_3);
	  
	  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
    <script type="text/javascript" src="scripts/JsCommon.js"></script>
<script>
function showResult(strmodule,strstage,stritemcode,stritemname,strisentry) {
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
  xmlhttp.open("GET","searchboq.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&isentry="+strisentry,true);
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

var txtboqcode = document.getElementById('txtboqcode').value;
var txtboqitem = document.getElementById('txtboqitem').value;
var txtboqunit = document.getElementById('txtboqunit').value;
var txtboqqty =  document.getElementById('txtboqqty').value;

var url_string="adddataboq.php?itemid="+id+"&boqcode="+txtboqcode+"&boqitem="+txtboqitem+"&boqunit="+txtboqunit+"&boqqty="+txtboqqty;
 <?php if($cur_1!="") {?>
var boq_cur_1_rate = document.getElementById('boq_cur_1_rate').value;
url_string +="&boq_cur_1_rate="+boq_cur_1_rate;
<?php }?>
 <?php if($cur_2!=""){?>
var boq_cur_2_rate = document.getElementById('boq_cur_2_rate').value;
url_string +="&boq_cur_2_rate="+boq_cur_2_rate;
<?php }?>
 <?php if($cur_3!=""){?>
var boq_cur_3_rate = document.getElementById('boq_cur_3_rate').value;
url_string +="&boq_cur_3_rate="+boq_cur_3_rate;
<?php }?>
xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	 document.getElementById("abc"+id).innerHTML=xmlhttp1.responseText;
		 document.getElementById("addnew"+id).style.display="block";
        
    }
  }

  xmlhttp1.open("GET",url_string,true);
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

  xmlhttp1.open("GET","editdataboq.php?boqid="+id+"&itemid="+itemid,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(boqid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtitemid = document.getElementById('itemid').value;
var txtboqcode = document.getElementById('txtboqcode').value;
var txtboqitem = document.getElementById('txtboqitem').value;
var txtboqunit = document.getElementById('txtboqunit').value;
var txtboqqty = document.getElementById('txtboqqty').value;

var url_string="updatedataboq.php?boqid="+boqid+"&itemid="+txtitemid+"&boqcode="+txtboqcode+"&boqitem="+txtboqitem+"&boqunit="+txtboqunit+"&boqqty="+txtboqqty;
<?php if($cur_1!="")
						  {?>
var boq_cur_1_rate = document.getElementById('boq_cur_1_rate').value;
url_string +="&boq_cur_1_rate="+boq_cur_1_rate;
<?php }?>
 <?php if($cur_2!="")
						  {?>
var boq_cur_2_rate = document.getElementById('boq_cur_2_rate').value;
url_string +="&boq_cur_2_rate="+boq_cur_2_rate;
<?php }?>
 <?php if($cur_3!="")
						  {?>
var boq_cur_3_rate = document.getElementById('boq_cur_3_rate').value;
url_string +="&boq_cur_3_rate="+boq_cur_3_rate;
<?php }?>

  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtitemid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp4.open("GET",url_string,true);
  xmlhttp4.send();
}

</script>
<script>
function remove_data(activityid,kpiid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+kpiid).innerHTML=xmlhttp4.responseText;
	 // document.getElementById("addnew"+milestoneid).style.display="block";
    }
  }

  xmlhttp4.open("GET","removedatakpi.php?activityid="+activityid+"&kpiid="+kpiid,true);
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

  xmlhttp1.open("GET","canceldataboq.php?itemid="+id,true);
  xmlhttp1.send();
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

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
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


	<script>
/*$(document).ready(function(){
	$(".msg_body").hide();
	alert("123");
	
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
	$(".msg_body").hide(); 
	$(this).next(".msg_body").slideToggle(600);
	});
	
});*/
</script>
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<br />
<h1> <?php echo BOQ_ENTRY_PANEL ;?></h1>
<form name="reports" id="reports"  method="post"   style="display:inline-block; width:100%;margin-top:10px;"> 
		<div style="margin-bottom:12px; width:100%">
		<?php  if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
		<a class="button" href="javascript:void(null);" onclick="window.open('subboq.php', '<?php echo ADD_BOQ;?>','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" ><?php echo ADD_BOQ;?></a>
		<?php
		}
		?>
		
		</div>
		
<?php /*?><input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportboq.php"/><?php */?>
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%">
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <?php
	   if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
      <th align="center" width="50%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  else
	  {
	  ?>
	   <th align="center" width="70%"><strong><?php echo NAME;?></strong></th>
	  <?php
	  }
	  ?>
	 <!-- <th align="center" width="5%"><strong>Stage</span></strong></th>-->
	  <th align="center" width="10%"><strong><?php echo CODE;?></strong></th>
	<!--  <th width="5%"><strong>Weight</strong></th>-->
	   <th align="center" width="5%"><strong><?php echo IS_ENTRY;?></strong></th>
            
      
	  <?php
	 if($boqentry_flag==1 || $boqadm_flag==1)
	{
	?>
	   <th align="center" width="30%"><strong><?php echo ACTION;?>
     </strong></th>
	 <?php
	 }
	 ?>
	 <th align="center" width="5%"><strong><?php echo LOG;?>
     </strong></th>
	 
     </tr>

<?php
	$sSQL = "SELECT * FROM boqdata where stage='BOQ' order by parentgroup, parentcd";
	$sqlresult = mysql_query($sSQL);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$aorder = $data['aorder'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from boqdata where itemid = ".$cdlist[0];
	$cdsqlresult12 = mysql_query($cdsql2);
	$cddata1 = mysql_fetch_array($cdsqlresult12);
	$itemname = $cddata1['itemname'];
	
				

				
?>

		<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from boqdata where stage='BOQ' and itemid = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$itemid = $cddata['itemid'];
		$parentcd = $cddata['parentcd'];
		$stage=$cddata['stage'];
		$activitylevel=$cddata['activitylevel'];
		if($cddata['isentry']==0)
				{
				$isentry1=NO;
				}
				else
				{
				$isentry1=YES;
				}

			?>
			<script>
function AddNewSizeProject<?php echo $itemid; ?>(){

    var count=0;
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:left; width:100px"/><input type="text" name="txtboqcode" id="txtboqcode"  size="25" style="text-align:left; width:100px"/>';
	var td3 = '<input type="text" name="txtboqitem" id="txtboqitem"  size="25" style="text-align:left; width:200px"/>';
	var td4 = '<input type="text" name="txtboqunit" id="txtboqunit"  size="25" style="text-align:left; width:100px"/>';
	var td6 = '<input type="text" name="txtboqqty"  id="txtboqqty"  size="25" style="text-align:left; width:100px"/>';
	<?php if($cur_1!="")
						  {?>
	var td8 = '<input type="text" name="boq_cur_1_rate" id="boq_cur_1_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php 
	}?>
	<?php if($cur_2!="")
						  {?>
	var td9 = '<input type="text" name="boq_cur_2_rate" id="boq_cur_2_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php }?>
	<?php if($cur_3!="")
						  {?>
	var td11 = '<input type="text" name="boq_cur_3_rate" id="boq_cur_3_rate"  size="25" style="text-align:left; width:100px"/>';
	count++;
	<?php }?>
	var td14 = '<input type="button" id="save" name="save" value="Save"  onClick=add_data(txtitemid.value); />'
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	if(count==1)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td14);
	}
	if(count==2)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td9,td14);
	}
	if(count==3)
	{
	var arrTds = new Array(td1, td2, td3,td4, td6, td8, td9,td11,td14);
	}
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
        <input type="hidden" id="itemid[]" name="itemid[]" value="<?php echo $itemid;?>" />
		<?php /*?><td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td><?php */?>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<?php /*?><td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td><?php */?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
         
		<?php 
		if($stage=='BOQ' && $activitylevel==0)
		{
		$editlink='boq.php';
		$redirect="subboq.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubBOQ";
		}
		else if($stage=='BOQ' && $activitylevel>0)
		{
		$editlink='subboq.php';
		$redirect="subboq.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubBOQ";
		}
		$deletelink='subboq.php';
		  ?>
		<?php
		if($boqentry_flag==1 || $boqadm_flag==1)
		{
		?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
	
		<?php if($cddata['isentry']==0)
		{	
		?>
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		 <?php
		 }?>
		 	<?php  if($stage=='BOQ' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a> 
		<?php
		if($boqadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this BOQ and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php
		if($boqadm_flag==1)
		{
		?>
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this BOQ and all of its child?')">Delete</a><?php } } ?>
		
		 	 </td>
			 <?php
			 }
			 ?>
		 <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="logboq.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" ><?php echo LOG;?></a>
	
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
			
			  xmlhttp3.open("GET","reloadboq.php?itemid="+id,true);
			  xmlhttp3.send();
			
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext"><?php echo ADD_DATA;?></span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 

	<?php /*?><table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                    <tr>
                       <th style="width:5%;"></th>
                        <th style="width:15%;"><?php echo "BOQ Code";?></th>
						<th style="width:25%;"><?php echo "BOQ Item";?></th>
						 <th style="width:15%;"><?php echo "BOQ Unit";?></th>
						<th style="width:25%;"><?php echo "BOQ Rate";?></th>
						 <th style="width:15%;"><?php echo "BOQ Quantity";?></th>
						<th style="width:25%;"><?php echo "BOQ Amount";?></th>
						 <th style="width:15%;"><?php echo "BOQ Currency";?></th>
						<th style="width:25%;"><?php echo "BOQ Current Rate";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Amount";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Currency";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Rate";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Current Rate";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
				
			<?php $sql_a="Select * from boq where itemid=$itemid";
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$boqid=$row3_a['boqid'];
			?>
			
			<tr >
			
			<td><?php echo $i; ?></td>
			<td><?=$row3_a['boqcode'];?></td>
			<td><?=$row3_a['boqitem'];?></td>
			<td><?=$row3_a['boqunit'];?></td>
			<td ><?=$row3_a['boqrate'];?></td>
			<td ><?=$row3_a['boqqty'];?></td>
			<td><?=$row3_a['boqamount'];?></td>
			<td><?=$row3_a['boqcurrency'];?></td>
			<td><?=$row3_a['boqcurrrate'];?></td>
			<td><?=$row3_a['boqfamount'];?></td>
			<td><?=$row3_a['boqfcurrency'];?></td>
			<td><?=$row3_a['boqfrate'];?></td>
			<td><?=$row3_a['boqfcurrate'];?></td>
			<td><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo $boqid;?>,<?php echo $itemid;?> )"  /></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			?>	
					
                </tbody>
            </table><?php */?>
			</div>	
			 <?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			 <div id="addnew<?php echo $itemid; ?>" style="float:right;">
			 <a onClick="AddNewSizeProject<?php echo $itemid; ?>();" href="javascript:void(null);"><?php echo ADD_NEW;?></a></div>
			 <?php
			 }
			 ?>
			
			  <input type="button" value="<?php echo CLOSE;?>" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			  <input type="button" value="<?php echo CANCEL;?>" name="cancel" id="cancel" onclick="cancel_data(<?php echo $itemid; ?>)" />
			  <?php
			  }
			  ?>

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
