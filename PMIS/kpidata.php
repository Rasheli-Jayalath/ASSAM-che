<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= KPIDATA;
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
$kpiid						= $_REQUEST['txtitemid'];
$act_s						= $_REQUEST['act'];
$length=count($act_s);
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
		$sq="Update kpidata SET aorder='".$aorder_list[$i]."' WHERE itemid=".$item_list[$i];
		mysql_query($sq);
	}
	$msg= "Order has been updated";
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
    <script type="text/javascript" src="scripts/JsCommon.js"></script>
<?php /*?><script>
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
  xmlhttp.open("GET","searchkpi.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script><?php */?>
<script>
function addactivities(itemid,temp_id, temp_is_default) {

 var str="",i;
 var activity="";

for (i=0;i<document.getElementById('act'+itemid).options.length;i++) {
    if (document.getElementById('act'+itemid).options[i].selected) {
        str += document.getElementById('act'+itemid).options[i].value + "_";
    }
}
if (str.charAt(str.length - 1) == '_') {
  str = str.substr(0, str.length - 1);
}

var activity=str;

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

    }
  }

  xmlhttp1.open("GET","addactivitieskpi.php?act="+activity+"&itemid="+itemid+"&temp_id="+temp_id+"&temp_is_default="+temp_is_default,true);
  xmlhttp1.send();
}

</script>
<script>
function edit_data(id,kpiid,temp_id,temp_is_default) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
	
      document.getElementById("abc"+kpiid).innerHTML=xmlhttp1.responseText;
	   document.getElementById("addnew"+kpiid).style.display="none";
     // document.getElementById("search").style.border="1px solid #A5ACB2";

    }
  }

  xmlhttp1.open("GET","editdatakpi.php?aid="+id+"&kpiid="+kpiid+"&temp_id="+temp_id+"&temp_is_default="+temp_is_default,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(kaid,aid, rid, temp_id,temp_is_default) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtkpiid = document.getElementById('kpiid').value;
var kaweight = document.getElementById('kaweight').value;


  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtkpiid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtkpiid).style.display="block";
    }
  }
if(temp_is_default==1)
{
  xmlhttp4.open("GET","updatedatakpi.php?kaid="+kaid+"&kpiid="+txtkpiid+"&kaweight="+kaweight+"&aid="+aid+"&rid="+rid+'&temp_id='+temp_id+"&temp_is_default="+temp_is_default,true);
}
else
{
	var baseline = document.getElementById('used_quantity').value;
	xmlhttp4.open("GET","updatedatakpi.php?kaid="+kaid+"&kpiid="+txtkpiid+"&kaweight="+kaweight+"&aid="+aid+"&rid="+rid+'&temp_id='+temp_id+'&baseline='+baseline+"&temp_is_default="+temp_is_default,true);
}
  xmlhttp4.send();
}

</script>
<script>
function remove_data(activityid,kpiid, temp_id, temp_is_default) {
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

  xmlhttp4.open("GET","removedatakpi.php?activityid="+activityid+"&kpiid="+kpiid+'&temp_id='+temp_id+"&temp_is_default="+temp_is_default,true);
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

  xmlhttp1.open("GET","canceldatakpi.php?itemid="+id,true);
  xmlhttp1.send();
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

function closediv(id)
{
$('div[class^="msg_body"]').hide(); 
}
</script>
<script>
	function getQuantity(rid)
   {
	if(rid!=0)
	{
	 document.getElementById("used_quantity").value="";
		
			if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp2=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	
		
      	document.getElementById("h_remaining_quantity").value=xmlhttp1.responseText;
		document.getElementById("remaining_quantity").value=xmlhttp1.responseText;

    }
  }

  xmlhttp1.open("GET","getremainingqty.php?rid="+rid,true);
  xmlhttp1.send();
  xmlhttp2.onreadystatechange=function() {
    if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
	
		
      	document.getElementById("total_quantity").value=xmlhttp2.responseText;
		

    }
  }

  xmlhttp2.open("GET","gettotalqty.php?rid="+rid,true);
  xmlhttp2.send();
			
			
   	}
	else
	{
			document.getElementById("total_quantity").value="";	
			document.getElementById("h_remaining_quantity").value="";
			document.getElementById("remaining_quantity").value="";
			document.getElementById("used_quantity").value="";
			
			
			
	}
	
	}
	
	
	
	function showResult(remaining_quantity,used_quantity,hidden_value,u_r_quantity,itemid) {
		
		//alert(remaining_quantity);
		//alert(used_quantity);
		//alert(hidden_value);
		//alert(u_r_quantity);
	
	
	if(isNaN(used_quantity))
	{
	alert(used_quantity+" Is not a Number");
	document.getElementById("used_quantity").value="";
	document.getElementById("remaining_quantity").value=hidden_value;
	}
	else
	{
	t_q="";

if(u_r_quantity==0)
{
remaining_quantity=hidden_value-0;

}
else
{
remaining_quantity=u_r_quantity-0;

}

document.getElementById("remaining_quantity").value=remaining_quantity-used_quantity;

 } 
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
<h1> <?php echo $module; ?> Entry Control Panel</h1>
<form name="reports" id="reports"  method="post"   style="display:inline-block; width:100%; margin-top:10px;"> 
		
        <div style="margin-bottom:18px;">
		<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
		{
		?>
		<a class="button" href="javascript:void(null);" onclick="window.open('template_kpi.php', 'Add KPI Template','width=800px,height=550px,scrollbars=yes');" >Add KPI Template</a>
		<?php
		 }
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="button" >Add KPI Template</a>
		<?php
		}
		?>
	
		</div>
<?php $btem="Select * from kpi_templates where 	is_active=1";
			  $resbtemp=mysql_query($btem);
			   $rowsnum=mysql_num_rows($resbtemp);
			 if($rowsnum>0) 
			 {
			  $row3tmpg=mysql_fetch_array($resbtemp);
			  $temp_id=$row3tmpg["temp_id"];
			?>
             <label><input type="checkbox" name="kpi_temp_id" id="kpi_temp<?php echo $row3tmpg['kpi_temp_id']; ?>" 
             value="<?php echo $row3tmpg['kpi_temp_id']; ?>" <?php if($row3tmpg['is_active']==1){?> checked="checked" <?php }?>   
              disabled="disabled" onchange="GetDefaultTemplate(this.value)" ><?php echo $row3tmpg['kpi_temp_title']; ?></label> <br/>
            <?php }?>
<div id="search"></div>
<div style="margin-bottom:12px; margin-top:12px">
<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
		{
		?>
		<a class="button" href="javascript:void(null);" onclick="window.open('kpi.php', 'Add KPI','width=480px,height=250px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add KPI</a>
		<?php
		 }
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="button" >Add KPI</a>
		<?php
		}
		?>
        </div>
<div id="without_search">
	<table class="reference" style="width:100%;">
      <tr style="text-decoration:inherit; color:#CCC; background-color:#333333">
	  <?php
	  if($kpientry_flag==1 || $kpiadm_flag==1)
	{
	?>
      <th align="center" width="50%"><strong>KPI Name</strong></th>
	  <?php
	  }
	 ?>
	<?php /*?>  <th align="center" width="5%"><strong>Stage</strong></th><?php */?>
	  <th align="center" width="5%"><strong>KPI Code</strong></th>
	  <th width="5%"><strong>Weight</strong></th>
	   <th align="center" width="5%"><strong>Isentry</strong></th>
      <?php /*?>  <th align="center" width="5%">Order <input type="submit" id="update_order" name="update_order"  value="Order"/></th><?php */?>
      <?php
	   if($kpientry_flag==1 || $kpiadm_flag==1)
	{
	?>
	   <th align="center" width="20%"><strong>Action
     </strong></th>
	 <?php
	 }
	 ?>
	<!-- <th align="center" width="5%"><strong>Log  </strong></th>	--> 
     </tr>

<?php 
if(isset($row3tmpg["kpi_temp_id"])&&$row3tmpg["kpi_temp_id"]!=""&&$row3tmpg["kpi_temp_id"]!=0)
{
$sSQL = "SELECT * FROM kpidata where stage='KPI' AND 	kpi_temp_id=".$row3tmpg["kpi_temp_id"]." order by aorder";
		$sqlresult = mysql_query($sSQL);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$aorder = $data['aorder'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from kpidata where kpiid = ".$cdlist[0];
	$cdsqlresult12 = mysql_query($cdsql2);
	$cddata1 = mysql_fetch_array($cdsqlresult12);
	$itemname = $cddata1['itemname'];
		
?>		
<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from kpidata where stage='KPI' and kpiid = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$kpiid = $cddata['kpiid'];
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
					
				}  
			}
			
			
			?>
			<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>">
			  <?php
		/*	if($parentcd==0){	
			echo "<b>".$itemname."</b>";
			}
			else
			{*/
			echo $h.$cddata['itemname'];
			//}
		   ?>
		    </td>
        <input type="hidden" id="itemid[]" name="itemid[]" value="<?php echo $kpiid;?>" />
		<?php /*?><td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td><?php */?>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $cddata['itemcode'];?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?php echo $cddata['weight'];?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $isentry1;?></td>
       <?php /*?> <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input type="text" value="<?php echo $aorder;?>"  id="aorder[]" name="aorder[]" style="width:25px"/></td><?php */?>
		<?php 
		if($stage=='KPI' && $activitylevel>=0)
		{ 
		$editlink='subkpi.php';
		$redirect="subkpi.php?subaid=$kpiid&levelid=$activitylevel";
		$redirect_title="Add SubKPI"; 
		}
/*	   else if($stage=='KPI' && $activitylevel==0)
		{
		$editlink='strategic_goal_kpi.php';
		$redirect="outcome_kpi.php?item=$kpiid";
		$redirect_title="Add Outcome";
		}
		else if($stage=='KPI' && $activitylevel==1)
		{
		$editlink='outcome_kpi.php';
		$redirect="output_kpi.php?item=$kpiid";
		$redirect_title="Add Output";
		}
		else if($stage=='KPI' && $activitylevel==2)
		{
		$editlink='output_kpi.php';
		$redirect="kpi.php?item=$kpiid";
		$redirect_title="Add KPI";
		}
		else if($stage=='KPI' && $activitylevel=3)
		{
		$editlink='kpi.php';
		$redirect="subkpi.php?subaid=$kpiid&levelid=$activitylevel";
		$redirect_title="Add SubKPI";
		}*/
		
			//echo $activitylevel;
		$deletelink='subkpi.php';
		  ?>
		
		<?php
	  if($kpientry_flag==1 || $kpiadm_flag==1)
	{
	?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		
		<?php if($cddata['isentry']==0)
		{	
		?>
		  		  
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a> | 
		 <?php
		 }?>
		 <?php  if($stage=='KPI' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $kpiid;?>&item=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$kpiid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($kpiadm_flag==1)
		{
		?>
		
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $kpiid;?>"   onclick="return confirm('Are you sure you want to delete this KPI and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $kpiid;?>&item=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel;?>', '<?php echo "Edit ".$kpiid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($kpiadm_flag==1)
		{
		?>
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $kpiid;?>" onclick="return confirm('Are you sure you want to delete this KPI and all of its child?')">Delete</a><?php } } ?>
		
		 	 </td>
			 <?php
			 }
			 ?>
		<?php /*?> <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="logkpi.php?trans_id=<?php echo $kpiid ; ?>&module=<?php echo $module?>" target="_blank">Log</a>
	
		 </td><?php */?>
	
		</tr>
		<tr>
		<td colspan="7">
			 <?php
	if($cddata['isentry']==1)
		{	
		?>
		<script>
		function callmsgbody<?php echo $kpiid; ?>()
		{
		var id=<?php echo $kpiid; ?>;
		var temp_id=<?php echo $temp_id; ?>;
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp3=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
			xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
		  }

  		xmlhttp3.onreadystatechange=function() {
    	if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
      	document.getElementById("abc"+id).innerHTML=xmlhttp3.responseText;
		}
  		}
    
	  xmlhttp3.open("GET","reloadkpi.php?kpiid="+id+"&temp_id="+temp_id,true);
	  xmlhttp3.send();

	$('div[class^="msg_body"]').not('.msg_body<?php echo $kpiid;?>').hide();
	$(".msg_body<?php echo $kpiid;?>").show(); 
	$(this).next(".msg_body<?php echo $kpiid;?>").slideToggle(600);
		}

		</script> 
		
		 <div class="msg_list" style="display:inline;">
		    <div class="msg_head" onclick="callmsgbody<?php echo $kpiid; ?>()" >+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $kpiid;?>" style="display:none" >
		 	<div id="abc<?php echo $kpiid;?>"> 
	

	
			</div>	
					
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $kpiid;?>)" />
			  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancel_data(<?php echo $kpiid;?>)" />
			  <?php
			  }
			  ?>

	</div>
		 </div>
		  <?php
		  }
		  ?>
		</td>
		</tr>
		
	
	<?php        
			}
}
else
{?>

<tr><tr><td colspan="12"> <?php echo $msg="Please Add KPI Template"; ?> </td></tr>
<?php }
	?>

	</table>
</div>
</form>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php $objDb -> close( );?>
