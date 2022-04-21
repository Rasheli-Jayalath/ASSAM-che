<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="EVA Activity Data Entry";
if ($uname==null)
{
	header("Location: index.php?init=3");
}

$itemid 				= $_REQUEST['itemid'];
$act_s					= $_REQUEST['act'];
$arr_act=explode("_",$act_s);
$length=count($arr_act);


$objDb  = new Database( );
@require_once("get_url.php");

if($length>0)
{
	
		for($i=0; $i<$length; $i++)
		{
		
		$eSql_l = "Select * from activity where itemid=".$arr_act[$i];
  		$res_sql=mysql_query($eSql_l);
	 	$numrows=mysql_num_rows($res_sql);
			if($numrows>0)
			{
				while($rows=mysql_fetch_array($res_sql))
				{
				$aid=$rows['aid'];
					$eSql_2 = "Select * from eva_activity where evaid=$itemid and activityid=$aid";
					$res_sq2=mysql_query($eSql_2);
					if(mysql_num_rows($res_sq2)>0)
					{
					}
					else
					{
					$sSQL = ("INSERT INTO eva_activity (evaid,activityid) VALUES ($itemid,$aid)");
					$objDb->execute($sSQL);
					}
				
				}
			}
			
		}
		
}
?>
<table  width="100%">
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
				<tr><td colspan="13">
				<form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where stage='Activity' and isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM eva_activity a inner join activity b on (a.activityid=b.aid) where a.evaid=$itemid)";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.activityid FROM eva_activity a inner join activity b on (a.activityid=b.aid) where b.itemid=".$itemidd;
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
			   <?php
			if($evaentry_flag==1 || $evaadm_flag==1)
			{
			?>
			    <input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $itemid; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
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
			$sql_a="SELECT b.aid,b.itemid,b.code,b.secheduleid,b.startdate,b.enddate,b.actualstartdate,b.actualenddate, b.aorder, b.baseline, b.remarks, b.rid FROM `eva_activity` a inner join activity b on (a.activityid=b.aid) where a.evaid=".$itemid; 
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$itemidd=$row3_a['itemid'];
			$sql_n="Select * from maindata where itemid=$itemidd";
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			/*$itemname_with_resource=$itemname." - ".$row3_a['secheduleid'];*/
			$aid=$row3_a['aid'];
			?>
			
			<tr >
			<td>
			<?php
			if($evaentry_flag==1 || $evaadm_flag==1)
			{
			?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo $aid; ?>,<?php echo $itemid; ?> );" title="Remove size">[X]</a>
			<?php
			}
			?></td>
			<td><b><?php echo $itemname; ?></b></td>
			<td><?=$row3_a['code'];?></td>
			<?php
			$sql_r="Select boqcode from resources where rid=".$row3_a['rid'];
			$res_r=mysql_query($sql_r);
			$row3_r=mysql_fetch_array($res_r);
			?>
			
			<td><?=$row3_r['boqcode']." : ".$row3_a['secheduleid'];?></td>
			<td><?=$row3_a['startdate'];?></td>
			<td ><?=$row3_a['enddate'];?></td>
			<td ><?=$row3_a['actualstartdate'];?></td>
			<td><?=$row3_a['actualenddate'];?></td>
			<td><?=$row3_a['aorder'];?></td>
			<td><?=$row3_a['baseline'];?></td>
			<td><?=$row3_a['remarks'];?></td>
			<?php
			$sqlga="Select * from eva_activity where activityid=$aid and evaid=$itemid";
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			?>
			<td><?=$rowa_a['eaweight'];?></td>
			<?php
			if($evaentry_flag==1 || $evaadm_flag==1)
			{
			?><td>
			<input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?>)"  />
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


