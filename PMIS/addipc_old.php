<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= ADD_IPC;
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";



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
  xmlhttp.open("GET","searchipc.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&isentry="+strisentry,true);
  xmlhttp.send();
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
			
    }
  }

  xmlhttp1.open("GET","cancelipcdata.php?itemid="+id,true);
  xmlhttp1.send();
}

</script>

<script>
function editipc_data(ipcvid,pid,ipcid,boqid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");  }

var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

      	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }

  xmlhttp1.open("GET","editipcdata.php?ipcvid="+ipcvid+"&pid="+pid+"&boqid="+boqid+"&ipcid="+ipcid+"&progressdate="+txtprogressdate,true);
  xmlhttp1.send();
}

</script>
<script>
function editipc_data1(boqid,pid,ipcid,itemid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");  }

var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {

      	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }

  xmlhttp1.open("GET","editipcdatasave.php?boqid="+boqid+"&pid="+pid+"&itemid="+itemid+"&ipcid="+ipcid+"&progressdate="+txtprogressdate,true);
  xmlhttp1.send();
}

</script>
<script>
function saveipc_data(pid,boqid,ipcid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtprogress = document.getElementById('txtprogress').value;
var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
	     	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }
  xmlhttp1.open("GET","addipcdata.php?pid="+pid+"&boqid="+boqid+"&ipcid="+ipcid+"&progress="+txtprogress+"&progressdate="+txtprogressdate,true);
  xmlhttp1.send();
}

</script>
<script>
function updateipc_data(ipcvid,pid,ipcid,boqid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp1=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtprogress = document.getElementById('txtprogress').value;
var txtprogressdate = document.getElementById('txtprogressdate').value;
  xmlhttp1.onreadystatechange=function() {
    if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
		
      	document.getElementById("abc"+pid).innerHTML=xmlhttp1.responseText;
    }
  }
xmlhttp1.open("GET","updateipcdata.php?ipcvid="+ipcvid+"&pid="+pid+"&boqid="+boqid+"&ipcid="+ipcid+"&progress="+txtprogress+"&progressdate="+txtprogressdate,true);
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
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<br />
<h1> <?php echo $module; ?> Entry Control Panel</h1>
<form name="reports" id="reports"  method="post"   style="display:inline-block; width:100%;"> 
		<div style="margin-bottom:12px; width:100%">
		<!--<input type="submit" value="Add IPC Data" formaction="ipcdata.php"/>-->
		<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
		<a href="ipcdata.php" class="button">Add IPC Data</a>
		<?php
		}
		?>
		</div>
		
<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportipc.php"/>
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%">
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
      <th align="center" width="50%"><strong>Item Name</strong></th>
	  <th align="center" width="15%"><strong>Stage</span></strong></th>
	  <th align="center" width="15%"><strong>Item Code</strong></th>
	   <th align="center" width="15%"><strong>Isentry</strong></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reports"  onclick="group_checkbox();"/></strong></th>
	  	 
     </tr>

<?php
		 $sSQL = "SELECT * FROM maindata where stage='BOQ' and isentry=1  order by parentgroup, parentcd";
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
		$cdsql = "select * from maindata where stage='BOQ' and itemid = ".$cdlist[$items-1];
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
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:right; width:100px"/><input type="text" name="txtboqcode" id="txtboqcode"  size="25" style="text-align:right; width:100px"/>';
	var td3 = '<input type="text" name="txtboqitem" id="txtboqitem"  size="25" style="text-align:right; width:100px"/>';
	var td4 = '<input type="text" name="txtboqunit" id="txtboqunit"  size="25" style="text-align:right; width:100px"/>';
	var td5 = '<input type="text" name="txtboqrate" id="txtboqrate"  size="25" style="text-align:right; width:100px"/>';
	var td6 = '<input type="text" name="txtboqqty"  id="txtboqqty"  size="25" style="text-align:right; width:100px"/>';
	var td7 = '<input type="text" name="txtboqamount"  id="txtboqamount"  size="25" style="text-align:right; width:100px"/>';
	var td8 = '<input type="text" name="txtboqcurrency" id="txtboqcurrency"  size="25" style="text-align:right; width:100px"/>';
	var td9 = '<input type="text" name="txtboqcurrrate" id="txtboqcurrrate"  size="25" style="text-align:right; width:100px"/>';
	var td10 = '<input type="text" name="txtboqfamount" id="txtboqfamount"  size="25" style="text-align:right; width:100px"/>';
	var td11 = '<input type="text" name="txtboqfcurrency" id="txtboqfcurrency"  size="25" style="text-align:right; width:100px"/>';
	var td12 = '<input type="text" name="txtboqfrate" id="txtboqfrate"  size="25" style="text-align:right; width:100px"/>';
	var td13 = '<input type="text" name="txtboqfcurrate" id="txtboqfcurrate"  size="25" style="text-align:right; width:100px"/>';
	var td14 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	var arrTds = new Array(td1, td2, td3,td4, td5, td6,td7, td8, td9,td10,td11,td12,td13,td14);
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
		<?php /*?><td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td><?php */?>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">		</td>
		
		</tr>
		<tr>
		<td colspan="6">
			 <?php
		$cdsql_a = "select * from maindata where parentcd = '$cddata[itemid]' and isentry=1 and stage='BOQ'";
		$cdsqlresult_a = mysql_query($cdsql_a);
		if(mysql_num_rows($cdsqlresult_a)>0)
	
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
					
				}
			  }
			
			  xmlhttp3.open("GET","reloadipc.php?itemid="+id,true);
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

	
			</div>	
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancel_data(<?php echo $itemid; ?>)" />
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
