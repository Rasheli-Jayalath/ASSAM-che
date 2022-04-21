<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}

$itemid 				= $_REQUEST['milestoneid'];
$activityid 				= $_REQUEST['activityid'];

$objDb  = new Database( );
@require_once("get_url.php");
	 $delsq3="delete from milestone_activity where milestoneid=$itemid and activityid=$activityid";
		mysql_query($delsq3);

?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
						<tr>
						<td colspan="13"><form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where stage='Activity' and isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM milestone_activity a inner join activity b on (a.activityid=b.aid) where a.milestoneid=$itemid)";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.activityid FROM milestone_activity a inner join activity b on (a.activityid=b.aid) where b.itemid=".$itemidd;
			$sql_resw=mysql_query($sqlw);
			if(mysql_num_rows($sql_resw)>0)
			{
			?>
			<option value="<?php echo $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
			  <option value="<?php echo $row3g['itemid'];?>" ><?php echo $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo $itemid; ?>" name="txtitemid" id="txtitemid" />
			    <?php  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?><input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $itemid; ?>)" />
	<?php
	}
	?>
				
			 </div>
			 </form></td></tr>
                    <tr>
					 <th style="width:2%;"></th>
                        <th style="width:10%;"><?php echo "Code";?><span style="color:red;">*</span></th>
						<th style="width:20%;"><?php echo "Resource";?><span style="color:red;">*</span></th>
						 <th style="width:10%;"><?php echo "Start Date";?><span style="color:red;">*</span><br />(yyyy-mm-dd)</th>
						<th style="width:10%;"><?php echo "End Date";?><span style="color:red;">*</span><br />(yyyy-mm-dd)</th>
						 <th style="width:10%;"><?php echo "Actual Start Date";?><br />(yyyy-mm-dd)</th>
						<th style="width:10%;"><?php echo "Actual End Date";?><br />(yyyy-mm-dd)</th>
						 <th style="width:5%;"><?php echo "Order";?></th>
						<th style="width:5%;"><?php echo "Baseline";?><span style="color:red;">*</span></th>
						<th style="width:5%;"><?php echo "Weight";?><span style="color:red;">*</span></th>
						<th style="width:10%;"><?php echo "Remarks";?></th>
						<th style="width:3%;"><?php echo "Action";?></th>
                        
                        
                        
                    </tr>
					
					
					<?php 
$sql_b="SELECT a.maid, b.aid,b.itemid,b.code,b.secheduleid,b.startdate,b.enddate,b.actualstartdate,b.actualenddate, b.aorder, b.baseline, b.remarks, b.rid FROM `milestone_activity` a inner join activity b on (a.activityid=b.aid) where a.milestoneid=".$itemid; 
$sql_d="Select * from milestone_activity where milestoneid=$itemid";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$sql_n="Select * from maindata where itemid=".$row3_b['itemid'];
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			$aid=$row3_b['aid'];
			$maid=$row3_b['maid']
			?>
			
			<tr >
			<td><?php  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?><a href="javascript:void(null);" onclick="remove_data(<?php echo $aid; ?>,<?php echo $itemid; ?> );" title="Remove size">[X]</a>
	<?php
	}
	?></td>
			<td><b><?php echo $itemname; ?></b></td>
			<td><?=$row3_b['code'];?></td>
			 <?php  
			  
			  
			 $sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			if($row3g['schedulecode']==$row3_b['secheduleid'])
				{
						
			?>
			
			<td><?=$row3_b['secheduleid'].": ".$row3g['resource'];?></td>
			<?php
			}
			}
			?>
			<td><?=$row3_b['startdate'];?></td>
			<td ><?=$row3_b['enddate'];?></td>
			<td ><?=$row3_b['actualstartdate'];?></td>
			<td><?=$row3_b['actualenddate'];?></td>
			<td><?=$row3_b['aorder'];?></td>
			<td><?=$row3_b['baseline'];?></td>
			<td><?=$row3_b['remarks'];?></td>
			<?php
			$sqlga="Select * from milestone_activity where maid=".$maid;
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			?>
			
			<td><?=$rowa_a['maweight'];?></td>
			<td><?php  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?><input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?>)"/>
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
