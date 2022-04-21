<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		="Baseline";
$edit= $_GET['edit'];

if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($res_flag==0) {
header("Location: index.php?init=3");
}
$objDb  = new Database( );
$objDbD  = new Database( );
$objDbI  = new Database( );
$objDbII  = new Database( );
$objDbB  = new Database( );
$objDbBQ  = new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$delete						= $_REQUEST['delete'];
$txtresource				= mysql_real_escape_string($_REQUEST['txtresource']);
$txtunit					= $_REQUEST['txtunit'];
$txtquantity				= $_REQUEST['txtquantity'];
$baseline_unit_id			= $_REQUEST['baseline_unit_id'];
$temp_id				    = $_REQUEST['temp_id'];
$boq_id				        = $_REQUEST['txtboqcode'];
$boq_ids				    = $_POST['txtboqcodem'];
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
	$sSQL = ("INSERT INTO baseline (base_desc,unit,quantity,unit_type,temp_id) VALUES ('$txtresource','$txtunit',$txtquantity, '$baseline_unit_id', '$temp_id')");
	$objDb->execute($sSQL);
	$txtid = $objDb->getAutoNumber();
	$resource_id = $txtid;
	$msg="Saved!";
	/*$log_module  = "resources Module";
	$log_title   = "Add Resource Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	*/
	if($baseline_unit_id!=3)
	{
	$sSQL = ("INSERT INTO baseline_mapping_boqs (rid, boqid) VALUES ('$resource_id','$boq_id')");
	$objDb->execute($sSQL);
	$boqcount=sizeof($boq_ids);
	if($boqcount>0)
	{
	foreach($boq_ids as $boq_id)
	{
		$sSQL = ("INSERT INTO baseline_mapping_boqs (rid, boqid) VALUES ('$resource_id','$boq_id')");
	    $objDb->execute($sSQL);
	}
	}
	}

}


if($updateBtn !=""){
	
 $uSql = "Update baseline SET 
		 base_desc           	= '$txtresource',
		 unit					= '$txtunit',
		 quantity				= $txtquantity,
		 unit_type				=  $baseline_unit_id,
		 temp_id				= '$temp_id'
		 where rid 				= $edit";
		  
 	if($objDb->execute($uSql)){
		

     $dSQL = ("DELETE FROM baseline_mapping_boqs where rid=$edit");
	$objDbD->execute($dSQL);  
	$bSQL = ("INSERT INTO baseline_mapping_boqs (rid, boqid) VALUES ('$edit','$boq_id')");
	$objDbB->execute($bSQL);
	if(!empty($boq_ids))
	{
	foreach($boq_ids as $boq_id)
	{
		$sbSQL = ("INSERT INTO baseline_mapping_boqs (rid, boqid) VALUES ('$edit','$boq_id')");
	    $objDbBQ->execute($sbSQL);
	}
	}
	}
	
	header("Location: baseline.php");
}


if($delete != ""){

$eSql_child2 = "update activity set rid=0, secheduleid='0' where rid=$delete";
mysql_query($eSql_child2);
$eSql_plrid= "delete from planned where rid=$delete";
mysql_query($eSql_plrid);
$eSql_pgrid = "delete from progress where rid=$delete";
mysql_query($eSql_pgrid);
$eSql_rid = "delete from baseline where rid=$delete";
mysql_query($eSql_rid);

header("Location: baseline.php");	
}


if($edit != ""){
 $eSql = "Select * from baseline where rid='$edit'";
  $objDb -> query($eSql);
  $eCount = $objDb->getCount();
	if($eCount > 0){
	  $rid_e 					= $objDb->getField($i,rid);
	  $resource_e 					= $objDb->getField($i,base_desc);
	  $unit_e						= $objDb->getField($i,unit);
	  $quantity_e					= $objDb->getField($i,quantity);
	  $temp_id_e					= $objDb->getField($i,temp_id);
	  $unit_type_e					= $objDb->getField($i,unit_type);
	  $btemb="Select * from baseline_template where temp_id=$temp_id_e";
	  $resbtempb=mysql_query($btemb);
      $row3tmpgb=mysql_fetch_array($resbtempb);
	  $temp_id_e=$row3tmpgb["temp_id"];
	  $temp_title_e=$row3tmpgb["temp_title"];
	  $use_data_e=$row3tmpgb["use_data"];
	  $temp_is_default_e= $row3tmpgb["temp_is_default"];
	   //$temp_id_e					= $objDb->getField($i,temp_id);
	 	
	}
}
$pquery = "Select * from project";
				$presult = mysql_query($pquery);
				$presultd = mysql_fetch_array($presult);
				$pdata = mysql_num_rows($presult);
				$project_type=$presultd["ptype"];
	if(isset($_REQUEST["edit"])&&$_REQUEST["edit"]!=0)
	{
		$bcount="";
		$bquery = "Select * from boq where boqid=".$_REQUEST["edit"];
		$bresult = mysql_query($bquery);
		$bcount = mysql_num_rows($bresult);
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
function getBOQs(unit_type)
{
	 <?php if(!isset($_REQUEST['edit'])&&$_REQUEST['edit']=="")  
	 {?>
	 document.getElementById("txtresource").value="";
	 document.getElementById("txtunit").value="";
	 document.getElementById("txtquantity").value="";
	
	if(unit_type==1||unit_type==2)
	{
		document.getElementById("txtboqcode").disabled=false;
		document.getElementById("txtboqcodem").disabled=false;
		  var list = document.frmresources.txtboqcode;
  		  list.options[list.selectedIndex].selected=false;
		   document.getElementById("txtboqcode").setAttribute("style","opacity:1;");
		 document.getElementById("txtboqcodem").setAttribute("style","opacity:1;");
    }
   else if(unit_type==3)
   {
	   document.getElementById("txtboqcode").disabled=true;
		document.getElementById("txtboqcodem").disabled=true;
		 document.getElementById("txtboqcode").setAttribute("style","opacity:0.3;");
		 document.getElementById("txtboqcodem").setAttribute("style","opacity:0.3;");
		
 }
 if(unit_type==2)
	{
		document.getElementById("txtunit").value="Amount";
	}
	 <?php }?>
   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("additionalboqdiv").innerHTML=xmlhttp4.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
 var boq_id=document.getElementById("txtboqcode").value;
   <?php if(isset($_REQUEST['edit'])&&$_REQUEST['edit']!="")  
	 {
		 		$total_qty=0;
				$buSql = "Select * from `baseline_mapping_boqs` a inner join boq b on (a.boqid=b.boqid) where a.rid=".$_REQUEST['edit']; 
				$sqlresultbu = mysql_query($buSql); 
				$boq_rowsbbu = mysql_fetch_array($sqlresultbu);
				$unit_f=$boq_rowsbbu["boqunit"];
				$bssSql = "Select * from `baseline_mapping_boqs` a inner join boq b on (a.boqid=b.boqid) where a.rid=".$_REQUEST['edit']. " and b.boqunit='$unit_f' "; 
				$sqlresultbss = mysql_query($bssSql); 
				if(mysql_num_rows($sqlresultbss)>0)
				{
				while($boq_rowsbbns = mysql_fetch_array($sqlresultbss))
				{
					$total_qty+=$boq_rowsbbns["boqqty"];
					
				}
				
	 			}
				
				?>
		 if(unit_type==1)
			{
			document.getElementById("txtunit").value="<?php echo $unit_f; ?>";	
			document.getElementById("txtquantity").value="<?php echo $total_qty; ?>";	
			}
	   xmlhttp4.open("GET","getadditionalboqdata_unit.php?boq_id="+boq_id+"&type=Boq"+"&edit=<?php echo $_REQUEST['edit'];?>&unit=<?php echo $unit_f;?>",true);
	<?php } 
	else
	{?>
  xmlhttp4.open("GET","getadditionalboqdata_unit.php?boq_id="+boq_id,true);
  <?php }?>
  xmlhttp4.send();
}

function selectAllAdditionalBOQ(unit_type) {
	
	 <?php if(!isset($_REQUEST['edit'])&&$_REQUEST['edit']=="") 
	 {?>
	 document.getElementById("txtresource").value="";
	 document.getElementById("txtunit").value="";
	 document.getElementById("txtquantity").value="";
	if(unit_type==1||unit_type==2)
	{
		document.getElementById("txtboqcode").disabled=false;
		document.getElementById("txtboqcodem").disabled=false;
		  var list = document.frmresources.txtboqcode;
  		  list.options[list.selectedIndex].selected=false;
		 document.getElementById("txtboqcode").setAttribute("style","opacity:1;");
		 document.getElementById("txtboqcodem").setAttribute("style","opacity:1;");
		  
    }
	<?php 
	
	
	
	}
	else
	{
		$resid=$_REQUEST['edit'];
	if($resid!="")
	{
	$boq_amountb=0;
	$bSql = "Select * from `baseline_mapping_boqs` a inner join boq b on (a.boqid=b.boqid) where a.rid=".$resid; 
	$sqlresultb = mysql_query($bSql); 
	while($boq_rowsb = mysql_fetch_array($sqlresultb))
	{
	$qty=$boq_rowsb["boqqty"];
	    if($boq_rowsb["boq_cur_1"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_1_exchrate"]*$boq_rowsb["boq_cur_1_rate"]*$boq_rowsb["boqqty"];
		 }
		  if($boq_rowsb["boq_cur_2"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_2_exchrate"]*$boq_rowsb["boq_cur_2_rate"]*$boq_rowsb["boqqty"];
		 }
		  if($boq_rowsb["boq_cur_3"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_3_exchrate"]*$boq_rowsb["boq_cur_3_rate"]*$boq_rowsb["boqqty"];
		 }
		 
		 ?>
		 
	<?php }
	}?>
	var boq_id=document.getElementById("txtboqcode").value;
	 document.getElementById("txtquantity").value=<?php echo $boq_amountb;?>
	<?php }?>
   /*else if(unit_type==3)
   {
	    document.getElementById("txtboqcode").disabled=true;
		document.getElementById("txtboqcodem").disabled=true;
		 document.getElementById("txtboqcode").setAttribute("style","opacity:0.3;");
		 document.getElementById("txtboqcodem").setAttribute("style","opacity:0.3;");
 }*/
if(unit_type==2)
	{
		document.getElementById("txtunit").value="Amount";
	}
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("additionalboqdiv").innerHTML=xmlhttp4.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
   <?php if(isset($_REQUEST['edit'])&&$_REQUEST['edit']!="") 
	 {?>
	 xmlhttp4.open("GET","getadditionalboqdata_unit.php?type=All&boq_id="+boq_id+"&edit=<?php echo $_REQUEST['edit'];?>",true);
	<?php } 
	else
	{?>
  xmlhttp4.open("GET","getadditionalboqdata_unit.php?type=All&boq_id="+boq_id,true);
  <?php }?>
  xmlhttp4.send();
}

function selectAdditionalBOQ(boq_id) {
	
	
var unit_types = document.getElementsByName("baseline_unit_id");
var selectedunit_type;

for(var i = 0; i < unit_types.length; i++) {
   if(unit_types[i].checked)
       selectedunit_type = unit_types[i].value;
 }
	
	//alert(selectedunit_type);
	

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp5=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp5=new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp6=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp6=new ActiveXObject("Microsoft.XMLHTTP");
  }
   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp7=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp7=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("additionalboqdiv").innerHTML=xmlhttp4.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
 xmlhttp5.onreadystatechange=function() {
    if (xmlhttp5.readyState==4 && xmlhttp5.status==200) {
      document.getElementById("baselinediv").innerHTML=xmlhttp5.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
  xmlhttp6.onreadystatechange=function() {
    if (xmlhttp6.readyState==4 && xmlhttp6.status==200) {
      document.getElementById("baselineunitdiv").innerHTML=xmlhttp6.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
    xmlhttp7.onreadystatechange=function() {
    if (xmlhttp7.readyState==4 && xmlhttp7.status==200) {
      document.getElementById("baselineqtydiv").innerHTML=xmlhttp7.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
  if(selectedunit_type==2)
  {
	   <?php if(isset($_REQUEST['edit'])&&$_REQUEST['edit']!="") 
	 {?>
	 xmlhttp4.open("GET","getadditionalboqdata_unit.php?type=All&boq_id="+boq_id+"&edit=<?php echo $_REQUEST['edit'];?>",true);
	<?php } 
	else
	{?>
	   xmlhttp4.open("GET","getadditionalboqdata_unit.php?boq_id="+boq_id+"&type=All",true);
	  <?php }?>
  
  }
  else
  {
	
	  <?php if(isset($_REQUEST['edit'])&&$_REQUEST['edit']!="")  
	 {?>
	 xmlhttp4.open("GET","getadditionalboqdata_unit.php?type=Boq&boq_id="+boq_id+"&edit=<?php echo $_REQUEST['edit'];?>",true);
	<?php } 
	else
	{?>
	xmlhttp4.open("GET","getadditionalboqdata_unit.php?boq_id="+boq_id+"&type=Boq",true);
	<?php }?>
  }
  xmlhttp4.send();
  xmlhttp5.open("GET","getbaseline_desc.php?boq_id="+boq_id,true);
  xmlhttp5.send();
   if(selectedunit_type==2)
  {
  document.getElementById("txtunit").value="Amount";
  }
  else
  {
	xmlhttp6.open("GET","getbaseline_unit.php?boq_id="+boq_id,true);
  	xmlhttp6.send();
	}
  if(selectedunit_type==2)
  {
  xmlhttp7.open("GET","getbaseline_qty.php?boq_id="+boq_id+"&type=All",true);
  }
  else
  {
   xmlhttp7.open("GET","getbaseline_qty.php?boq_id="+boq_id+"&type=Boq",true);
  }
  xmlhttp7.send();
}
function get_sum_unit() {
	
var str="";
var qty="";
var type="";
var boq_id=document.getElementById("txtboqcode").value;
var unit_types = document.getElementsByName("baseline_unit_id");
var selectedunit_type;

for(var i = 0; i < unit_types.length; i++) {
   if(unit_types[i].checked)
       selectedunit_type = unit_types[i].value;
	   type =selectedunit_type;
 }
qty=document.getElementById('txtquantity').value;
var size=document.getElementById('txtboqcodem').options.length;
for (i=0;i<document.getElementById('txtboqcodem').options.length;i++) {
    if (document.getElementById('txtboqcodem').options[i].selected) {
		if(size>1)
		{
        str += document.getElementById('txtboqcodem').options[i].value + "_";
		document.getElementById("txtquantity").value=0;
		}
		else
		{
			str = document.getElementById('txtboqcodem').options[i].value;
		}
    }
}
if (str.charAt(str.length - 1) == '_') {
  str = str.substr(0, str.length - 1);
}

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp8=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp8=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp8.onreadystatechange=function() {
    if (xmlhttp8.readyState==4 && xmlhttp8.status==200) {
      document.getElementById("baselineqtydiv").innerHTML=xmlhttp8.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp8.open("GET","getbaseline_qtysum.php?boq_ids="+str+"&qty="+qty+"&type="+type+"&boq_id="+boq_id,true);
  xmlhttp8.send();

}

function GetDefaultTemplate(temp_id)
{
	
	var chck=false;

	chck=confirm('Are you sure to make it Active Template?');
	var radList = document.getElementsByName("temp_is_default");

	if(chck==false)
	{
		 document.getElementById("temp"+temp_id).checked = false;
	
	}
	else
	{
		  for (var i = 0; i < radList.length; i++) {
      if(radList[i].checked) document.getElementById(radList[i].id).checked = false;
    }
		 document.getElementById("temp"+temp_id).checked = true;
		 
		 
		 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("templatedescdiv").innerHTML=xmlhttp4.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
  xmlhttp4.open("GET","get_template.php?temp_id="+temp_id,true);
  xmlhttp4.send();
  
  
   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp5=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp5=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp5.onreadystatechange=function() {
    if (xmlhttp5.readyState==4 && xmlhttp5.status==200) {
      document.getElementById("templatedata").innerHTML=xmlhttp5.responseText;
	  //document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }
  xmlhttp5.open("GET","get_template_content.php?temp_id="+temp_id,true);
  xmlhttp5.send();
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
<style>
.label1
{
	text-align:left;
}
</style>
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmresources" id="frmresources" action=""  method="post" onsubmit="" enctype="multipart/form-data">
	  <table width="100%" border="0"  align="center" cellpadding="1" cellspacing="1" style="padding-left:10px" >
            <tr>
              <td valign="top"><table style="padding-top:10px" class="baseform" width="109%">
             <tr>
             
              <td colspan="3" style="padding:10px 10px 10px 150px"><a class="button"  href="javascript:void(null);" onclick="window.open('mapping_template.php', 'Add Mapping Template','width=730px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Manage Templates</a></td>
            </tr>
            <tr>
              <td class="label1">Active Template:</td>
              <td width="57%" colspan="2" > <?php $btemp="Select * from baseline_template where active_temp=1";
			$resbtemp=mysql_query($btemp);
			 $tempcount1=mysql_num_rows($resbtemp);
			 if($tempcount1>0){
			while($row3tmpg=mysql_fetch_array($resbtemp))
			{?>
             <label><input type="checkbox" name="temp_is_default" id="temp<?php echo $row3tmpg['temp_id']; ?>" 
             value="<?php echo $row3tmpg['temp_id']; ?>" <?php if($row3tmpg['active_temp']==1){?> checked="checked" <?php }?>  
             onchange="GetDefaultTemplate(this.value)"><?php echo $row3tmpg['temp_title']; ?></label> <br/>
              <?php }
			 }
			  else
			  {
				  echo "<label>No Template Added</label>";   
			   }?></td>
            </tr>
            <!--<tr>
              <td class="label1">Default Template:</td>
              <td colspan="2"><div id="templatedescdiv">--><?php 
			  $btemb="Select * from baseline_template where active_temp=1";
			  $resbtempb=mysql_query($btemb);
			 $tempcount=mysql_num_rows($resbtempb);
			  $row3tmpgb=mysql_fetch_array($resbtempb);
			   $row3tmpgb["temp_desc"];
			  $use_data=$row3tmpgb["use_data"];
			  $temp_id=$row3tmpgb["temp_id"];
			 if($tempcount>0)
			 {  ?><!--</div></td>
            </tr>-->
            
            <tr>
              <td colspan="2" class="label1"><h1>Add Baseline Mapping:</h1></td>
            </tr>
            <?php if(isset($_REQUEST["edit"])&&$_REQUEST["edit"]!="")
			{?>
              <input type="hidden" name="temp_id" id="temp_id"  value="<?php echo  $temp_id_e; ?>"/>
                 <?php if($use_data_e==1||$use_data_e==2)
			{?>
            <tr>
              <td class="label1">Baseline Unit Type:</td>
              <td colspan="2" class="label1"><input type="radio" name="baseline_unit_id"   id="baseline_unit_id" value="1" onclick="getBOQs(this.value);" <?php if($unit_type_e==1){?> checked="checked" <?php }?> />  Unit
              <input type="radio" name="baseline_unit_id" id="baseline_unit_id" value="2" onclick="selectAllAdditionalBOQ(this.value)" <?php if($unit_type_e==2){?> checked="checked" <?php }?>/>  Amount 
            <!--  <input type="radio" name="baseline_unit_id" id="baseline_unit_id" value="3"  checked="checked" onclick="getBOQs(this.value);"/> Custom--></td>
            </tr> 
            <tr>
              <td class="label1">Base Item:</td>
              <td width="57%" colspan="2" >
              <select name="txtboqcode" id="txtboqcode"   onchange="selectAdditionalBOQ(this.value)" >
			  <option value="0">Select BOQ Code:</option>
			  <?php $sqlg="Select * from boq";
			$resg=mysql_query($sqlg);
			
			while($row3g=mysql_fetch_array($resg))
			{
			$boqid=$row3g['boqid'];
			if(isset($_REQUEST["edit"])&&$_REQUEST["edit"]!=0)
			{
			
				$bSql = "Select boqid from `baseline_mapping_boqs` where rid=$rid_e"; 
				$sqlresultb = mysql_query($bSql); 
				if(mysql_num_rows($sqlresultb)>0)
				{
				$boq_rowsbb = mysql_fetch_array($sqlresultb);
				}
				$rid_e=$boq_rowsbb[0];
			}
			if($boqid==$rid_e)
			{
			$sel="selected='selected'";
			}
			
			else
			{
			$sel="";
			}
			?>
			  <option  value="<?php echo $boqid;?>" <?php echo $sel; ?> ><?php echo $row3g['boqid']. ": ".$row3g['boqcode']. " - ". $row3g['boqitem']. " (". $row3g['boqunit']. ")"; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
			   
        <!--      Note: <ul> <li>1. If no code is selected system will allow to enter unit and baseline manually.</li><li> 2. If some code is selected then unit autmatically fills with a drop downbox of selection between amount or unit of BOQ/Milestone. 
Multiple BOQs can be selected with same unit. the quantity or amount will be summed up and displayed automatically.  </li> 
<li>3. In any case qunatity can be modified. </li>
              </ul>-->
			  </td>
             </tr> 
            <tr>
              <td class="label1">Additional Items:</td>
              <td width="57%" colspan="2" >
                 
              <div id="additionalboqdiv">
              <select name="txtboqcodem[]" id="txtboqcodem" multiple="multiple" 
              onchange="get_sum_unit(this.value)" >
			  <?php 
			  $count_boq=count($boq_rowsbb);
			  if(isset($rid_e)&&$rid_e!=""&& $unit_type_e!=3&&$unit_type_e!=2)
			  {
			 	 $sqlg="SELECT * from boq where boqunit='$unit_e' and boqid<>$rid_e";
			  }
			   elseif(isset($rid_e)&&$rid_e!=""&& $unit_type_e==2)
			  {
				   $sqlg="SELECT * from boq where boqid<>$rid_e";
			  }
			  else
			  {
				   $sqlg="SELECT * from boq ";
			  }
				$resg=mysql_query($sqlg);
				while($row3g=mysql_fetch_array($resg))
				{
				$boqid=$row3g['boqid'];
				
				$i=1;
				if($count_boq>1)
				{
				$mbSql = "Select boqid from `baseline_mapping_boqs` where rid=".$_REQUEST['edit']; 
				$sqlresultbm = mysql_query($mbSql); 
				
				while($boq_rowsbm = mysql_fetch_array($sqlresultbm))
				{
					
				if($boqid==$boq_rowsbm["boqid"])
				{
				 $sel="selected='selected'";
				break;
				}
				else
				{
				$sel="";
				}
				
				}
				}
				
			?>
			  <option  value="<?php echo $boqid;?>" <?php echo $sel; ?> ><?php echo $row3g['boqid']. ": ".$row3g['boqcode']. " - ". $row3g['boqitem']. " (". $row3g['boqunit']. ")"; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
		      </div>
			  </td>
             </tr>  
             <?php }
			 else
			 {?>
              <input type="hidden" name="baseline_unit_id" id="baseline_unit_id"  value="3"/>
				 <?php }?>
            <?php }
			else
			{ ?>
         
            <input type="hidden" name="temp_id" id="temp_id"  value="<?php echo  $temp_id; ?>"/>
                       
            <?php if($use_data!=3)
			{?>
            <tr>
              <td class="label1">Baseline Unit Type:</td>
              <td colspan="2" class="label1"><input type="radio" name="baseline_unit_id"   id="baseline_unit_id" value="1" onclick="getBOQs(this.value);" checked="checked"/>  Unit
              <input type="radio" name="baseline_unit_id" id="baseline_unit_id" value="2" onclick="selectAllAdditionalBOQ(this.value)"/>  Amount 
            <!--  <input type="radio" name="baseline_unit_id" id="baseline_unit_id" value="3"  checked="checked" onclick="getBOQs(this.value);"/> Custom--></td>
            </tr> 
            <tr>
              <td class="label1">Base Item:</td>
              <td width="57%" colspan="2" >
              <select name="txtboqcode" id="txtboqcode"   onchange="selectAdditionalBOQ(this.value)" >
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
			  <option  value="<?php echo $boqid;?>" <?php echo $sel; ?> ><?php echo $row3g['boqid']. ": ".$row3g['boqcode']. " - ". $row3g['boqitem']. " (". $row3g['boqunit']. ")"; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
			   
        <!--      Note: <ul> <li>1. If no code is selected system will allow to enter unit and baseline manually.</li><li> 2. If some code is selected then unit autmatically fills with a drop downbox of selection between amount or unit of BOQ/Milestone. 
Multiple BOQs can be selected with same unit. the quantity or amount will be summed up and displayed automatically.  </li> 
<li>3. In any case qunatity can be modified. </li>
              </ul>-->
			  </td>
             </tr> 
            <tr>
              <td class="label1">Additional Items:</td>
              <td width="57%" colspan="2" >
              <div id="additionalboqdiv">
              <select name="txtboqcodem[]" id="txtboqcodem" multiple="multiple"  
              onchange="get_sum_unit(this.value)" >
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
			  <option  value="<?php echo $boqid;?>" <?php echo $sel; ?> ><?php echo $row3g['boqid']. ": ".$row3g['boqcode']. " - ". $row3g['boqitem']. " (". $row3g['boqunit']. ")"; ?> </option>
			  <?php
			  }
			  ?>
			  </select>
		      </div>
			  </td>
             </tr>  
             <?php }
			 else
			 {?>
              <input type="hidden" name="baseline_unit_id" id="baseline_unit_id"  value="3"/>
				 <?php }?>
                   
              <?php }?>
            
            <tr>
              <td width="43%" class="label1">Baseline Item:</td>
              <td colspan="2" >
                <div id="baselinediv">
			 <input type="text"  name="txtresource" id="txtresource" value="<?php echo $resource_e; ?>" /> 
             </div> </td>
             </tr>
			<tr>
			  <td class="label1">Baseline Unit:</td>
              <td colspan="2" >
              <div id="baselineunitdiv">
			 <input type="text"  name="txtunit" id="txtunit" value="<?php echo $unit_e; ?>" /> 
             </div>
              </td>
             </tr>
			<tr>
			  <td class="label1">Baseline Quantity/Amount:</td>
              <td colspan="2"  > <div id="baselineqtydiv">
              <input type="text"  name="txtquantity" id="txtquantity" value="<?php echo $quantity_e; ?>" /></div> </td>
            </tr>
        <?php /*?>    <tr>
              <td class="label1">&nbsp;</td>
              <td class="label1">Schedule Code:</td>
              <td ><input id="txtschedulecode" name="txtschedulecode" type="text" value="<?php echo $schedulecode; ?>"/></td>
             </tr><?php */?>
			 
			<tr>
			 <td height="39"></td>
			 <td align="left" colspan="3"  >
			 <?php
			  if($resentry_flag==1 || $resadm_flag==1)
				{
	
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save" />
			  &nbsp;&nbsp;<input type="submit" value="Clear" name="clear"  />
			  <?php }
			  
			  } ?></td>
			 </tr>
             <?php }
			?>
             </table></td>
              <td width="66%" rowspan="13" valign="top"><div id="templatedata" style="height:450px; overflow:scroll">
			  <table class="reference" style="width:100%" >
                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC; vertical-align:middle">
                  <th align="center" width="2%"><strong>#</strong></th>
                  <th align="center" width="5%">Code</th>
                  <th align="center" width="25%"><strong>Resource Name </strong></th>
                  <th width="10%"><strong>Unit</strong></th>
                  <th width="15%"><strong>Quantity</strong></th>
                  <th align="center" width="10%"><strong>Action </strong></th>
                  <?php /*?> <th align="center" width="10%"><strong>Log </strong></th><?php */?>
                </tr>
                <strong>
                <?php
 $sSQL = " Select * from baseline a inner join baseline_template b on(a.temp_id=b.temp_id) where b.active_temp";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $rid 							= $objDb->getField($i,rid);
	  $res_code 					= $objDb->getField($i,base_code);
	  $resource 					= $objDb->getField($i,base_desc);
	  $unit 						= $objDb->getField($i,unit);
	  $quantity 					= $objDb->getField($i,quantity);
	  //$schedulecode 				= $objDb->getField($i,schedulecode);
	 // $boqcode 						= $objDb->getField($i,boqcode);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
?>
                </strong>
                <tr <?php echo $style; ?>>
                  <td width="5px"><center>
                    <?php echo $i+1;?>
                  </center></td>
                  <td width="210px"><?php echo $res_code;?></td>
                  <td width="210px"><?php echo $resource;?></td>
                  <td width="100px"><?php echo $unit;?></td>
                  <td width="210px" align="right"><?php echo  number_format($quantity, 2, '.', '');?></td>
                  <td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
                    <?php  if($resentry_flag==1 || $resadm_flag==1)
	{
	?>
                    <a href="baseline.php?edit=<?php echo $rid;?>"  >Edit</a>
                    <?php } ?>
                    <?php  if($resadm_flag==1)
	{
	?>
                    | <a href="baseline.php?delete=<?php echo $rid;?>"  onclick="return confirm('Are you sure you want to delete this Baseline Item?')" >Delete</a>
                  <?php
  }
  ?></td>
                  <?php /*?><td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $rid ; ?>&amp;module=<?php echo $module?>" target="_blank">Log</a></td><?php */?>
                </tr>
                <?php        
	}
	}
?>
              </table></div></td>
            </tr>
            
 		</table>
     </form>
	
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
