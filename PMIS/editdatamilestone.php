<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
/*$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];*/
$aid 				= $_REQUEST['aid'];
$itemid 				= $_REQUEST['itemid'];




$objDb  = new Database( );
@require_once("get_url.php");
?>
<table  width="45%" >
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
						
                       <th style="width:5%;"></th>
                        <th style="width:15%;"><?php echo "Code";?></th>
						<th style="width:25%;"><?php echo "Resource";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						 <th style="width:15%;"><?php echo "Actual Start Date";?></th>
						<th style="width:25%;"><?php echo "Actual Start Date";?></th>
						 <th style="width:15%;"><?php echo "Order";?></th>
						<th style="width:25%;"><?php echo "Base Line";?></th>
						<th style="width:25%;"><?php echo "Remarks";?></th>
						<th style="width:25%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php 

$sql_a="SELECT b.aid,b.itemid,b.code,b.secheduleid,b.startdate,b.enddate,b.actualstartdate,b.actualenddate, b.aorder, b.baseline, b.remarks, b.rid FROM `milestone_activity` a inner join activity b on (a.activityid=b.aid) where a.milestoneid=".$itemid; 
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3=mysql_fetch_array($res_a))
			{
			$sql_n="Select * from maindata where itemid=".$row3['itemid'];
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			if($row3['aid']==$aid){
			?>
			<tr >
			
			<td><b><?php echo $itemname; ?></b></td>
			<td><input id="itemid" name="itemid" type="hidden" value="<?php echo $itemid; ?>"/><?php echo $row3['code']; ?></td>
			 <?php  
			  
			  
			 $sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			if($row3g['schedulecode']==$row3['secheduleid'])
				{
						
			?>
			
			<td><?=$row3['secheduleid'].": ".$row3g['resource'];?></td>
			<?php
			}
			}
			?>
			<td><?php echo $row3['startdate']; ?></td>
			<td ><?php echo $row3['enddate']; ?></td>
			<td ><?php echo $row3['actualstartdate']; ?></td>
			<td><?php echo $row3['actualenddate']; ?></td>
			<td><?php echo $row3['aorder']; ?></td>
			<td><?php echo $row3['baseline']; ?></td>
			<td><?php echo $row3['remarks']; ?></td>
			<?php
			$sqlga="Select * from milestone_activity where activityid=$row3[aid] and milestoneid=$itemid";
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			$maid=$rowa_a['maid'];
			?>
			
			<td><input id="maweight" name="maweight" type="text" value="<?=$rowa_a['maweight'];?>"/></td>
			<td>
			<?php  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?>
			<input type="button" value="Update" name="update" id="update"  onclick="update_data(<?php echo $maid;?>)"/>
			<?php
			}
			?></td>
			</tr>
			<?php

			}
			else
			{
			
			?>
			
			<tr ><td><b><?php echo $itemname; ?></b></td>
			<td><?=$row3['code'];?></td>
			<td><?=$row3['secheduleid'];?></td>
			<td><?=$row3['startdate'];?></td>
			<td ><?=$row3['enddate'];?></td>
			<td ><?=$row3['actualstartdate'];?></td>
			<td><?=$row3['actualenddate'];?></td>
			<td><?=$row3['aorder'];?></td>
			<td><?=$row3['baseline'];?></td>
			<td><?=$row3['remarks'];?></td><?php
			$sqlga1="Select * from milestone_activity where activityid=$row3[aid] and milestoneid=$itemid";
			$resga1=mysql_query($sqlga1);
			$rowa_a1=mysql_fetch_array($resga1);
			?>
			
			<td><?=$rowa_a1['maweight'];?></td>
			<td><?php  if($mileentry_flag==1 || $mileadm_flag==1)
	{
	?><input type="button" value="Edit" name="edit" id="edit"  disabled="disabled" /><?php } ?></td>
			</tr>
			
			<?php
			}
			$i=$i+1;
			}
			
			?>		
 </tbody>
            </table>
