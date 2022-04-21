<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$module 			= $_REQUEST['module'];

if($module=="BOQ Data")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
$file_name="maindata.php";
$valuestage			= $_REQUEST['stage'];
$valueitemcode		= $_REQUEST['itemcode'];
$valueitemname 		= $_REQUEST['itemname'];
$valueisentry		= $_REQUEST['isentry'];
}

$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';


if($module=="BOQ Data")
{

if($valuestage!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (stage  like '%".$valuestage."%' and stage='BOQ') ";
		}
		else
		{
		$sCondition=" (stage  like '%".$valuestage."%' and stage='BOQ') ";
		}
	
}

if($valueitemcode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemcode  like '%".$valueitemcode."%' and stage='BOQ') ";
		}
		else
		{
		$sCondition=" (itemcode  like '%".$valueitemcode."%' and stage='BOQ') ";
		}
	
}
if($valueitemname!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemname  like '%".$valueitemname."%' and stage='BOQ') ";
		}
		else
		{
		$sCondition=" (itemname  like '%".$valueitemname."%' and stage='BOQ') ";
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
		$sCondition.=" AND (isentry=$valueisentry and stage='BOQ') ";
		}
		else
		{
		$sCondition=" (isentry=$valueisentry and stage='BOQ') ";
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
	
	  <?php if($module=="BOQ Data"){?>
    <th></th>
	 <?php
	   if($boqentry_flag==1 || $boqadm_flag==1)
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
	  <th align="center" width="5%"><span class="label">Stage</span></th>
	  <th align="center" width="10%"><span class="label">Item Code</span></th>
	  <th align="center" width="5%"><span class="label">Isentry</span></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll2" id=
          "txtChkAll2"   form="reports"  onclick="group_checkbox2();"/></strong></th>
      
	 	 	 
	  <?php
	  }
	  ?>
	 
	 <?php
	 if($boqentry_flag==1 || $boqadm_flag==1)
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
<strong>
<?php
if($sCondition=="")
{
$sCondition="1=1 and stage='BOQ'";
}
if($module=="BOQ Data")
{
$sSQL = " select * from $tbl_name where  ".$sCondition." order by parentgroup, parentcd";
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
 if($module=="BOQ Data")
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
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$isentry1;?></td>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox2" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$id1;?>"  onclick="group_checkbox2();" form="reports"></td>			
<?php
}
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
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><a href="logboq.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
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
			<td>
			<?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo $boqid;?>,<?php echo $itemid;?> )"  />
			<?php
			}
			?></td>
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
			
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
				if($boqentry_flag==1 || $boqadm_flag==1)
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
}

			
?>
</table>
</div>
</td> 
</body>
</html>
