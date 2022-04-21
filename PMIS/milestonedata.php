<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MDATA;

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
$act_s						= $_REQUEST['act'];
$length=count($act_s);

if($saveBtn != "")
{

if($length>0)
{
	
		for($i=0; $i<$length; $i++)
		{
		
		$eSql_l = "Select * from activity where itemid=".$act_s[$i];
  	$res_sql=mysql_query($eSql_l);
	 $numrows=mysql_num_rows($res_sql);
			if($numrows>0)
			{
				while($rows=mysql_fetch_array($res_sql))
				{
				$aid=$rows['aid'];
					$eSql_2 = "Select * from milestone_activity where milestoneid=$itemid and activityid=$aid";
					$res_sq2=mysql_query($eSql_2);
					if(mysql_num_rows($res_sq2)>0)
					{
					}
					else
					{
					$sSQL = ("INSERT INTO milestone_activity (milestoneid,activityid) VALUES ($itemid,$aid)");
					$objDb->execute($sSQL);
					}
				
				}
			}
			
		}
		
}
header("location: milestonedata.php");
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
  xmlhttp.open("GET","searchmilestone.php?module="+strmodule+"&stage="+strstage+"&itemcode="+stritemcode+"&itemname="+stritemname+"&weight="+strweight+"&isentry="+strisentry,true);
  xmlhttp.send();
}

</script>
<script>
function addactivities(itemid) {

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

  xmlhttp1.open("GET","addactivities.php?act="+activity+"&itemid="+itemid,true);
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

  xmlhttp1.open("GET","editdatamilestone.php?aid="+id+"&itemid="+itemid,true);
  xmlhttp1.send();
}

</script>
<script>
function update_data(maid) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }
var txtitemid = document.getElementById('itemid').value;
var maweight = document.getElementById('maweight').value;

  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+txtitemid).innerHTML=xmlhttp4.responseText;
	  document.getElementById("addnew"+txtitemid).style.display="block";
    }
  }

  xmlhttp4.open("GET","updatedatamilestone.php?maid="+maid+"&itemid="+txtitemid+"&maweight="+maweight,true);
  xmlhttp4.send();
}

</script>
<script>
function remove_data(activityid,milestoneid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp4=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  }


  xmlhttp4.onreadystatechange=function() {
    if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
      document.getElementById("abc"+milestoneid).innerHTML=xmlhttp4.responseText;
	 // document.getElementById("addnew"+milestoneid).style.display="block";
    }
  }

  xmlhttp4.open("GET","removedata.php?activityid="+activityid+"&milestoneid="+milestoneid,true);
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

  xmlhttp1.open("GET","canceldatamilestone.php?itemid="+id,true);
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
<h1> <?php echo $module; ?> Entry Control Panel</h1>

<form name="reports" id="reports"  method="post"   style="display:inline-block; width:100%; margin-top:10px;"> 
		<div style="margin-bottom:12px; width:100%">
		<?php  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?>
         <a class="button" href="javascript:void(null);" onclick="window.open('strategic_goal_milestone.php', 'Add Milestone Strategic Goal','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Milestone Strategic Goal</a>
		 <?php
		 }
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="button" >Add Milestone Strategic Goal</a>
		<?php
		}
		?>	
		 <!--<a class="button" href="javascript:void(null);" onclick="window.open('outcome_milestone.php', 'Add Milestone Outcome','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Milestone Outcome</a>
		  <a class="button" href="javascript:void(null);" onclick="window.open('output_milestone.php', 'Add Milestone Output','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Milestone Output</a>
		<a class="button" href="javascript:void(null);" onclick="window.open('milestone.php', 'Add Milestone','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Add Milestone</a>-->
		
		</div>
		
<input type="hidden" name="module" id="module" value="<?=$module ?>" onkeyup="showResult(this.value,valuestage.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valuestage"  id="valuestage" title="Stage" placeholder="Stage" style="width:100px"  onkeyup="showResult(module.value,this.value,valueitemcode.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemcode"  id="valueitemcode"  title="Item Code" placeholder="Item Code" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,this.value,valueitemname.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueitemname"  id="valueitemname" title="Item Name" placeholder="Item Name" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,this.value,valueweight.value,valueisentry.value)"/>
<input type="text" name="valueweight"  id="valueweight" title="Weight" placeholder="Weight" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,this.value,valueisentry.value)"/>
<input type="text" name="valueisentry"  id="valueisentry" title="Is Entry" placeholder="Is Entry" style="width:100px"    onkeyup="showResult(module.value,valuestage.value,valueitemcode.value,valueitemname.value,valueweight.value,this.value)"/>
<input name="submit" type="submit" value="Print List" formaction="reportmilestone.php"/>
<div id="search"></div>
<div id="without_search">
	<table class="reference" style="width:100%">
      <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	  <th></th>
     <?php
	  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?>
      <th align="center" width="50%"><strong>Item Name</strong></th>
	  <?php
	  }
	  else
	  {
	  ?>
	   <th align="center" width="70%"><strong>Item Name</strong></th>
	  <?php
	  }
	  ?>
	  <th align="center" width="5%"><strong>Stage</span></strong></th>
	  <th align="center" width="5%"><strong>Item Code</strong></th>
	  <th width="5%"><strong>Weight</strong></th>
	   <th align="center" width="5%"><strong>Isentry</strong></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll" id="txtChkAll"   form="reports"  onclick="group_checkbox();"/></strong></th>
	  <?php
	  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?>
	   <th align="center" width="20%"><strong>Action
     </strong></th>
	 <?php
	 }
	 ?>
	 <th align="center" width="5%"><strong>Log
     </strong></th>
	 
     </tr>

<?php
		 $sSQL = "SELECT * FROM maindata where stage='Milestone' order by parentgroup, parentcd";
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
		$cdsql = "select * from maindata where stage='Milestone' and itemid = ".$cdlist[$items-1];
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
		<?php 
		
		if($stage=='MILESTONE' && $activitylevel>3)
		{
		$editlink='submilestone.php';
		$redirect="submilestone.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Submilestone";
		}
	   else if($stage=='MILESTONE' && $activitylevel==0)
		{
		$editlink='strategic_goal_milestone.php';
		$redirect="outcome_milestone.php?item=$itemid";
		$redirect_title="Add Outcome";
		}
		else if($stage=='MILESTONE' && $activitylevel==1)
		{
		$editlink='outcome_milestone.php';
		$redirect="output_milestone.php?item=$itemid";
		$redirect_title="Add Output";
		}
		else if($stage=='MILESTONE' && $activitylevel==2)
		{
		$editlink='output_milestone.php';
		$redirect="milestone.php?item=$itemid";
		$redirect_title="Add Milestone";
		}
		else if($stage=='MILESTONE' && $activitylevel=3)
		{
		$editlink='milestone.php';
		$	$redirect="submilestone.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add Submilestone";
		}
		
		
		$deletelink='submilestone.php';
		  ?>
		
			 <?php
	  if($mileentry_flag==1 || $mileadm_flag==1)
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
		 <?php  if($stage=='MILESTONE' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&item=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		
		<?php if($mileadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Milestone and all of its child?')">Delete</a>
		<?php } }else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($mileadm_flag==1)
		{
		?>
		| <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this Milestone and all of its child?')">Delete</a>
		<?php
		}
		 } ?>
		
		 	 </td>
			 
		<?php
		}
		?>
		 <td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" >
		 <a href="logmilestone.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>">Log</a>
	
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
		// document.getElementById("addnew"+id).style.display="block";
		
     // document.getElementById("search").style.border="1px solid #A5ACB2";
	  
	
	 
    }
  }

  xmlhttp3.open("GET","reloadmilestone.php?itemid="+id,true);
  xmlhttp3.send();

	$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
	$(".msg_body<?php echo $itemid;?>").show(); 
	$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
	
}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <!--<div class="msg_head" >+
		   <span class="tooltiptext">Add Data</span>
		  </div>-->
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()" >+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
		 	<div id="abc<?php echo $itemid; ?>"> 
			</div>	
					
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php   if($mileentry_flag==1 || $mileadm_flag==1)
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
