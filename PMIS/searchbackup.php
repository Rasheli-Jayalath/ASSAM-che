<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
if($module=="Resources")
	{
	$id="rid";
	$tbl_name="resources";
	$tbl_name1="resources_log";
	$file_name="resources.php";
	$valueresource		= $_REQUEST['resource'];
	$valueunit			= $_REQUEST['unit'];
	$valuequantity		= $_REQUEST['quantity'];
	$valueschedulecode 		= $_REQUEST['schedulecode'];
	$valueboqcode		= $_REQUEST['boqcode'];
	
	}
if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
$file_name="maindata.php";
$valuestage			= $_REQUEST['stage'];
$valueitemcode		= $_REQUEST['itemcode'];
$valueitemname 		= $_REQUEST['itemname'];
$valueweight 		= $_REQUEST['weight'];
$valueisentry		= $_REQUEST['isentry'];
}


if($module=="Activity Data")
{
$id="aid";
$tbl_name="activity";
$tbl_name1="activity_log";
$file_name="activity.php";
$valuecode			= $_REQUEST['code'];
$valueschdid		= $_REQUEST['schdid'];
$valuestartdate 	= $_REQUEST['startdate'];
$valueenddate 		= $_REQUEST['enddate'];
$valueastartdate		= $_REQUEST['astartdate'];
$valueaenddate 		= $_REQUEST['aenddate'];
$valueremarks		= $_REQUEST['remarks'];
}
$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';

if($module=="Resources")
{
if($valueresource!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (resource  like '%".$valueresource."%') ";
		}
		else
		{
		$sCondition=" (resource  like '%".$valueresource."%') ";
		}
	
}
if($valueunit!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (unit  like '%".$valueunit."%') ";
		}
		else
		{
		$sCondition=" (unit  like '%".$valueunit."%') ";
		}
	
}
if($valueschedulecode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (schedulecode  like '%".$valueschedulecode."%') ";
		}
		else
		{
		$sCondition=" (schedulecode  like '%".$valueschedulecode."%') ";
		}
	
}

if($valueboqcode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (boqcode  like '%".$valueboqcode."%') ";
		}
		else
		{
		$sCondition=" (boqcode  like '%".$valueboqcode."%') ";
		}
	
}

if($valuequantity!="")
{
 $len = strlen($valuequantity);
 $pos = strpos($valuequantity,'-');
 $last = substr($valuequantity,-1);

if (strpos($valuequantity,'-') === 0) {
	$expstart = substr($valuequantity, 1, $len - $pos);
	//$sSQL1 = "SELECT * FROM tblcvmain WHERE totalExp <= ".$expstart;
	if($sCondition!="")
	{
		
	$sCondition.=" AND (quantity <= '$expstart') ";
	}
	else
	{
	$sCondition= " (quantity  <= '$expstart') ";
	}
} 
else if (strpos($valuequantity,'-') === false) {
	$expstart = substr($valuequantity, 0, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (quantity  = ".$expstart.") ";
	}
	else
	{
	$sCondition= " (quantity  = ".$expstart.") ";
	}
}
else if (strpos($valuequantity,'-') > 0 && $last =='-') {
	$expstart = substr($valuequantity, 0, $len - 1);
	if($sCondition!="")
	{
	$sCondition.=" AND (quantity >= ".$expstart.") ";
	}
	else
	{
	$sCondition= " (quantity >= ".$expstart.") ";
	}
} 
else if (strpos($valuequantity,'-') > 0) {
	$expstart = substr($valuequantity, 0, $pos);
	$expend = substr($valuequantity, $pos+1, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (quantity between ".$expstart." and ".$expend.") ";
	}
	else
	{
	$sCondition= " (quantity between ".$expstart." and ".$expend.") ";
	}
}	
}
}
if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{
if($module=="Strategic Goal")
{
if($sCondition!="")
		{
		$sCondition.=" AND (stage='Strategic Goal') ";
		}
		else
		{
		$sCondition=" (stage='Strategic Goal') ";
		}
}
else if($module=="Outcome")
{
if($sCondition!="")
		{
		$sCondition.=" AND (stage='Outcome') ";
		}
		else
		{
		$sCondition=" (stage='Outcome') ";
		}
}
else if($module=="Output")
{
if($sCondition!="")
		{
		$sCondition.=" AND (stage='Output') ";
		}
		else
		{
		$sCondition=" (stage='Output') ";
		}
}
else if($module=="Activity")
{
if($sCondition!="")
		{
		$sCondition.=" AND (stage='Activity') ";
		}
		else
		{
		$sCondition=" (stage='Activity') ";
		}
}


else
{
if($valuestage!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (stage  like '%".$valuestage."%') ";
		}
		else
		{
		$sCondition=" (stage  like '%".$valuestage."%') ";
		}
	
}
}
if($valueitemcode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemcode  like '%".$valueitemcode."%') ";
		}
		else
		{
		$sCondition=" (itemcode  like '%".$valueitemcode."%') ";
		}
	
}
if($valueitemname!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemname  like '%".$valueitemname."%') ";
		}
		else
		{
		$sCondition=" (itemname  like '%".$valueitemname."%') ";
		}
	
}
if($valueisentry !="")
{
if($valueisentry=='y' || $valueisentry=='ye' || $valueisentry=='yes' || $valueisentry=='e' || $valueisentry=='s' || $valueisentry=='es')
{
$valueisentry=1;
}
else if($valueisentry=='n' || $valueisentry=='no' || $valueisentry=='o')
{
$valueisentry=0;
}	
		if($sCondition!="")
		{
		$sCondition.=" AND (isentry=$valueisentry) ";
		}
		else
		{
		$sCondition=" (isentry=$valueisentry) ";
		}
	
}

if($valueweight!="")
{
 $len = strlen($valueweight);
 $pos = strpos($valueweight,'-');
 $last = substr($valueweight,-1);

if (strpos($valueweight,'-') === 0) {
	$expstart = substr($valueweight, 1, $len - $pos);
	//$sSQL1 = "SELECT * FROM tblcvmain WHERE totalExp <= ".$expstart;
	if($sCondition!="")
	{
		
	$sCondition.=" AND (weight <= '$expstart') ";
	}
	else
	{
	$sCondition= " (weight  <= '$expstart') ";
	}
} 
else if (strpos($valueweight,'-') === false) {
	$expstart = substr($valueweight, 0, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight  = ".$expstart.") ";
	}
	else
	{
	$sCondition= " (weight  = ".$expstart.") ";
	}
}
else if (strpos($valueweight,'-') > 0 && $last =='-') {
	$expstart = substr($valueweight, 0, $len - 1);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight >= ".$expstart.") ";
	}
	else
	{
	$sCondition= " (weight >= ".$expstart.") ";
	}
} 
else if (strpos($valueweight,'-') > 0) {
	$expstart = substr($valueweight, 0, $pos);
	$expend = substr($valueweight, $pos+1, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight between ".$expstart." and ".$expend.") ";
	}
	else
	{
	$sCondition= " (weight between ".$expstart." and ".$expend.") ";
	}
}	
}
}
if($module=="Activity Data")
{
if($valuecode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (code  like '%".$valuecode."%') ";
		}
		else
		{
		$sCondition=" (code  like '%".$valuecode."%') ";
		}
	
}
if($valueschdid!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (secheduleid  like '%".$valueschdid."%') ";
		}
		else
		{
		$sCondition=" (secheduleid  like '%".$valueschdid."%') ";
		}
	
}
if($valuestartdate != "")
{
	
	// $valuett_1		= date('Y-m-d',strtotime($valuett));
	
	if($sCondition!="")
	{
	$sCondition.=" AND (startdate>='$valuestartdate')";
	}
	else
	{
	$sCondition=" (startdate>='$valuestartdate')";
	}
}
if($valueenddate != "")
{
	
	// $valuett_1		= date('Y-m-d',strtotime($valuett));
	
	if($sCondition!="")
	{
	$sCondition.=" AND (enddate<='$valueenddate')";
	}
	else
	{
	$sCondition=" (enddate<='$valueenddate')";
	}
}
if($valueastartdate != "")
{
	
	// $valuett_1		= date('Y-m-d',strtotime($valuett));
	
	if($sCondition!="")
	{
	$sCondition.=" AND (actualstartdate>='$valueastartdate')";
	}
	else
	{
	$sCondition=" (actualstartdate>='$valueastartdate')";
	}
}
if($valueaenddate != "")
{
	
	// $valuett_1		= date('Y-m-d',strtotime($valuett));
	
	if($sCondition!="")
	{
	$sCondition.=" AND (actualenddate<='$valueaenddate')";
	}
	else
	{
	$sCondition=" (actualenddate<='$valueaenddate')";
	}
}
if($valueremarks!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (remarks  like '%".$valueremarks."%') ";
		}
		else
		{
		$sCondition=" (remarks  like '%".$valueremarks."%') ";
		}
	
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $module; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
 <div class="with_search">
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	</strong></th>
	<?php if($module=="Resources"){?>
      <th align="center" width="20%"><strong>Resource Name</strong></th>	
      <th width="10%"><strong>Unit</strong></th>
      <th width="15%"><strong>Quantity</strong></th>
	  <th width="10%"><strong>Schedule Code</strong></th>
      <th width="10%"><strong>Boq Code</strong></th>
	  <?php
	  }
	  ?>
	  <?php if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity"){?>
    <th></th>
	 <th align="center" width="50%"><strong>Item Name</strong></th>
	  <th align="center" width="5%"><span class="label">Stage</span></th>
	  <th align="center" width="5%"><span class="label">Item Code</span></th>
	  <th width="5%"><strong>Weight</strong></th>
	   <th align="center" width="5%"><span class="label">Isentry</span></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll2" id=
          "txtChkAll2"   form="reports"  onclick="group_checkbox2();"/></strong></th>
      
	 	 	 
	  <?php
	  }
	  ?>
	   <?php if($module=="Activity Data"){?>
     
    <th align="center" width="5%"><span class="label">Code</span></th>
     <th align="center" width="5%"><span class="label">Schedule Id</span></th>
	 <th align="center" width="10%"><span class="label">Start Date</span></th>
	 <th align="center" width="10%"><span class="label">End Date</span></th>
	 <th align="center" width="10%"><span class="label">Actual Start Date</span></th>
	 <th align="center" width="10%"><span class="label">Actual End Date</span></th>
	 <th align="center" width="5%"><span class="label">Order</span></th>
	 <th align="center" width="10%"><span class="label">Baseline</span></th>
	 <th align="center" width="10%"><span class="label">Remarks</span></th>
		 
	  <?php
	  }
	  ?>
	<th align="center" width="20%"><strong>Action
    </strong></th>
	<th align="center" width="5%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
if($sCondition=="")
{
$sCondition="1=1";
}
if($module=="Main Data")
{
$sSQL = " select * from $tbl_name where ".$sCondition." order by parentgroup, parentcd";
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

</strong>
<tr id="abcd<?php echo $cdlist[$items-1];?>">
<?php
		$cdsql = "select * from maindata where $id = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$id1 = $cddata[$id];
		$itemid=$id1;
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
	var td10 = '<input type="text" name="txtremarks" id="txtremarks"  size="25" style="text-align:right; width:100px"/>';
	var td11 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
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
	
	var arrTds = new Array(td1, td2, td3,td4, td5, td6,td7, td8, td9,td10,td11);
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
 if($module=="Main Data" || $module=="Strategic Goal" || $module=="Outcome" || $module=="Output" || $module=="Activity")
{?>
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
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"  ><?=$stage;?></td>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"  ><?=$cddata['itemcode'];?></td>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$isentry1;?></td>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox2" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$id1;?>"  onclick="group_checkbox2();" form="reports"></td>			
<?php
}
 if($stage=='Strategic Goal')
		{
		$editlink='strategic_goal.php';
		$redirect="outcome.php?item=$id1";
		$redirect_title="Add Outcome";
		}
		else if($stage=='Outcome')
		{
		$editlink='outcome.php';
		$redirect="output.php?item=$id1";
		$redirect_title="Add Output";
		}
		else if($stage=='Output')
		{
		$editlink='output.php';
		$redirect="activity.php?item=$id1";
		$redirect_title="Add Activity";
		}
		else if($stage=='Activity' && $activitylevel==0)
		{
		$editlink='activity.php';
		$redirect="subactivity.php?subaid=$id1&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}
		else if($stage=='Activity' && $activitylevel>0)
		{
		$editlink='subactivity.php';
		$redirect="subactivity.php?subaid=$id1&levelid=$activitylevel";
		$redirect_title="Add Subactivity";
		}

?>

<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" >&nbsp;
<?php  if($stage=='Activity' && $activitylevel>0) {?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $id1;?>&subaid=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$id1; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php }else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $id1;?>', '<?php echo "Edit ".$id1; ?>','width=870,height=550,scrollbars=yes');" >Edit</a><?php } ?>
		  |
		  <a href="javascript:void(null);" onclick="window.open('<?php echo $redirect; ?>', '<?php echo $redirect_title; ?>','width=870,height=550,scrollbars=yes');" >
		 <?php echo $redirect_title; ?></a></td>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><a href="log.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
</tr>
<tr>
		<td colspan="9">
			 <?php
	if($cddata['isentry']==1)
		{	
		?> 
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
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

	<table  width="100%" >
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
			<td><?=$row3_a['remarks'];?></td>
			<td><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?> )"  /></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			?>	
					
                </tbody>
            </table>
			</div>	
			 <div id="addnew<?php echo $itemid; ?>" style="float:right;">
			 <a onClick="AddNewSizeProject<?php echo $itemid; ?>();" href="javascript:void(null);">Add New</a></div>
			
			  <?php /*?><input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" /><?php */?>
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
}

			$sSQL = " select * from $tbl_name where ".$sCondition;
			$objDb->query($sSQL);
					$iCount = $objDb->getCount( );
					if($iCount>0)
					{
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$id1 					= $objDb->getField($i, $id);
		if($module=="Resources"){
		$resource  				= $objDb->getField($i, resource);
		$unit  					= $objDb->getField($i, unit);
		$quantity  				= $objDb->getField($i, quantity);
		$schedulecode  			= $objDb->getField($i, schedulecode);
		$boqcode  				= $objDb->getField($i, boqcode);
		}
		
	 if($module=="Activity Data"){
	  
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
	  }
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
$link=$file_name."?edit=".$id1;?>
<tr >
<?php if($module=="Resources")
{?>
<td width="140px"><?=$resource;?></td>
<td width="210px"><?=$unit;?></td>
<td width="210px"><?= number_format($quantity, 2, '.', '');?></td>
<td width="210px"><?=$schedulecode;?></td>
<td width="210px"><?=$boqcode;?></td>
<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
<a href="<?php echo $link;?>"  ><img src="images/edit.png" width="22" height="22" /></a></td>
<td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
<?php
}
?>


<?php

if($module=="Activity Data")
{?>

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
<a href="<?php echo $link;?>"  ><img src="images/edit.png" width="22" height="22" /></a></td>
<td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
<?php
}

?>



</tr>

<?php
}
}
?>
</table>
</div>
</td> 
</body>
</html>
