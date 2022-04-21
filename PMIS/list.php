<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
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
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg	= "";
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
</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	  <br clear="all" />
	<h1> Main Data Entry Control Panel</h1>

	<form name="reports" id="reports"  method="post" target="_blank"  style="display:inline-block"> 
	
		<div> <input type="submit" value="Add Strategic Goal" formaction="strategic_goal.php" />
		<input type="submit" value="Add Outcome"  formaction="outcome.php"/>
		<input type="submit" value="Add Output" />
		<input type="submit" value="Add Activity" />
		<input type="submit" value="Add Milestone" />
		<input type="submit" value="Add KPI" />
		<input type="submit" value="Add Resources" />
		<input type="submit" value="Add BOQ" />
		<input type="submit" value="Add VOS" />
		<input type="submit" value="Add IPC" />
		<input type="submit" value="Assign Activities" />
		<input type="submit" value="Assign Resources" />
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
    
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
      <th align="center" width="3%"><strong>
	  <input  type="checkbox"  name="txtChkAll" id=
          "txtChkAll"   form="reports"  onclick="group_checkbox();"/>
	 </strong></th>
	 <th align="center" width="10%"><span class="label">Stage</span></th>
     <th align="center" width="10%"><span class="label">Item Code</span></th>
	 <th align="center" width="15%"><span class="label">Item Name</span></th>
	 <th width="5%"><strong>Weight</strong></th>
      <th width="10%"><strong>Activities</strong></th>
      <th align="center" width="10%"><span class="label">Isentry</span></th>
	 <th align="center" width="10%"><span class="label">Resources</span></th>
	 <th align="center" width="10%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
 $sSQL = " Select * from maindata";
 $objDb->query($sSQL);
 $iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
	  $itemid						= $objDb->getField($i,itemid);
	  $parentcd 					= $objDb->getField($i,parentcd);
	  $parentgroup	 				= $objDb->getField($i,parentgroup);
	  $stage						= $objDb->getField($i,stage);
	  $itemcode 					= $objDb->getField($i,itemcode);
	  $itemname 					= $objDb->getField($i,itemname);
	  $weight	 					= $objDb->getField($i,weight);
	  $activities					= $objDb->getField($i,activities);
	  $isentry 						= $objDb->getField($i,isentry);
	  $resources 					= $objDb->getField($i,resources);
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}

if($isentry==0)
{
$isentry1="No";
}
else
{
$isentry1="Yes";
}
?>
</strong>
<tr <?php echo $style; ?>>
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reports" onclick="group_checkbox();">
</td>
<td width="180px"  ><?=$stage;?></td>
<td width="180px"  ><?=$itemcode;?></td>
<td width="180px"  ><?=$itemname;?></td>
<td width="100px"><?=$weight;?></td>
<td width="210px" align="right"><?=$activities;?></td>
<td width="180px"  ><?=$isentry1;?></td>
<td width="180px"  ><?=$resources;?></td>
<?php if($stage=='Strategic Goal')
{
$editlink='outcome';
$txt=Outcome;
}
else if($stage=='Outcome')
{
$editlink='output';
$txt=Output;
}  ?>

<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
 <a href="strategic_level.php?edit=<?php echo $itemid;?>"  ><img src="images/edit.png" width="22" height="22" /></a> | 

<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink;?>.php?cat_cd=<?php echo $itemid;?>', 'INV','width=870,height=550,scrollbars=yes');" >Add <?php echo $txt;?></a></td>
 <td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $itemid ; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
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
