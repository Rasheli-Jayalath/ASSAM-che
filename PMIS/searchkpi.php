<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}

$module 			= $_REQUEST['module'];
if($module=="KPI Data")
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

$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';


if($module=="KPI Data")
{

if($valuestage!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (stage  like '%".$valuestage."%' and stage='KPI') ";
		}
		else
		{
		$sCondition=" (stage  like '%".$valuestage."%' and stage='KPI') ";
		}
	
}

if($valueitemcode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemcode  like '%".$valueitemcode."%' and stage='KPI') ";
		}
		else
		{
		$sCondition=" (itemcode  like '%".$valueitemcode."%' and stage='KPI') ";
		}
	
}
if($valueitemname!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemname  like '%".$valueitemname."%' and stage='KPI') ";
		}
		else
		{
		$sCondition=" (itemname  like '%".$valueitemname."%' and stage='KPI') ";
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
		$sCondition.=" AND (isentry=$valueisentry and stage='KPI') ";
		}
		else
		{
		$sCondition=" (isentry=$valueisentry and stage='KPI') ";
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
		
	$sCondition.=" AND (weight <= '$expstart' and stage='KPI') ";
	}
	else
	{
	$sCondition= " (weight  <= '$expstart' and stage='KPI') ";
	}
} 
else if (strpos($valueweight,'-') === false) {
	$expstart = substr($valueweight, 0, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight  = ".$expstart." and stage='KPI') ";
	}
	else
	{
	$sCondition= " (weight  = ".$expstart." and stage='KPI') ";
	}
}
else if (strpos($valueweight,'-') > 0 && $last =='-') {
	$expstart = substr($valueweight, 0, $len - 1);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight >= ".$expstart." and stage='KPI') ";
	}
	else
	{
	$sCondition= " (weight >= ".$expstart." and stage='KPI') ";
	}
} 
else if (strpos($valueweight,'-') > 0) {
	$expstart = substr($valueweight, 0, $pos);
	$expend = substr($valueweight, $pos+1, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight between ".$expstart." and ".$expend." and stage='KPI') ";
	}
	else
	{
	$sCondition= " (weight between ".$expstart." and ".$expend." and stage='KPI') ";
	}
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
	
	  <?php if($module=="KPI Data"){?>
    <th></th>
	 <?php
	  if($kpientry_flag==1 || $kpiadm_flag==1)
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
	  <th align="center" width="5%"><span class="label">Item Code</span></th>
	  <th width="5%"><strong>Weight</strong></th>
	   <th align="center" width="5%"><span class="label">Isentry</span></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll2" id=
          "txtChkAll2"   form="reports"  onclick="group_checkbox2();"/></strong></th>
      
	 	 	 
	  <?php
	  }
	  ?>
	   
	<?php
	  if($kpientry_flag==1 || $kpiadm_flag==1)
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
$sCondition="1=1 and stage='KPI'";
}
if($module=="KPI Data")
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
 if($module=="KPI Data")
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

		if($stage=='KPI' && $activitylevel>3)
		{ 
		$editlink='subkpi.php';
		$redirect="subkpi.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubKPI"; 
		}
	   else if($stage=='KPI' && $activitylevel==0)
		{
		$editlink='strategic_goal_kpi.php';
		$redirect="outcome_kpi.php?item=$itemid";
		$redirect_title="Add Outcome";
		}
		else if($stage=='KPI' && $activitylevel==1)
		{
		$editlink='outcome_kpi.php';
		$redirect="output_kpi.php?item=$itemid";
		$redirect_title="Add Output";
		}
		else if($stage=='KPI' && $activitylevel==2)
		{
		$editlink='output_kpi.php';
		$redirect="kpi.php?item=$itemid";
		$redirect_title="Add KPI";
		}
		else if($stage=='KPI' && $activitylevel=3)
		{
		$editlink='kpi.php';
		$redirect="subkpi.php?subaid=$itemid&levelid=$activitylevel";
		$redirect_title="Add SubKPI";
		}
		
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
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>&item=<?php echo $parentcd; ?>&levelid=<?php echo $activitylevel-1;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($kpiadm_flag==1)
		{
		?>
		
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>"   onclick="return confirm('Are you sure you want to delete this KPI and all of its child?')">Delete</a>
		<?php }}else{?>
		<a href="javascript:void(null);" onclick="window.open('<?php echo $editlink; ?>?edit=<?php echo $itemid;?>', '<?php echo "Edit ".$itemid; ?>','width=870,height=550,scrollbars=yes');" >Edit</a>
		<?php if($kpiadm_flag==1)
		{
		?>
		 | <a href="<?php echo $deletelink; ?>?del=<?php echo $itemid;?>" onclick="return confirm('Are you sure you want to delete this KPI and all of its child?')">Delete</a><?php } } ?>
		
		 	 </td>
			 <?php
			 }
			 ?>
<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><a href="logkpi.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
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
	

	
			</div>	
					
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php
				 if($kpientry_flag==1 || $kpiadm_flag==1)
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
