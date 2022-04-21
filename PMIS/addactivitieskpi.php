<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="KPI Activity Data Entry";
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$itemid 				= $_REQUEST['itemid'];
$temp_id 				= $_REQUEST['temp_id'];
$temp_is_default	    = $_REQUEST['temp_is_default'];
 $act_s					= $_REQUEST['act'];
 $arr_act=explode("_",$act_s);

$length=count($arr_act);


$objDb  = new Database( );
$objDbI  = new Database( );
$objDbII  = new Database( );
@require_once("get_url.php");
if($temp_is_default==1 && $act_s!="" )
{?>
<?php if($length>0)
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
					$eSql_2 = "Select * from kpi_activity where kpiid=$itemid and activityid=$aid";
					$res_sq2=mysql_query($eSql_2);
					if(mysql_num_rows($res_sq2)>0)
					{
					}
					else
					{
					$sSQL = ("INSERT INTO kpi_activity (kpiid,activityid) VALUES ($itemid,$aid)");
					$objDb->execute($sSQL);
					}
				
				}
			}
			
		}
		
}
?>
<table  width="100%">
            	<tbody id="tblPrdSizesProject<?php echo  $itemid; ?>">
				<tr><td colspan="13">
				<form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo  $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo  $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where a.kpiid=$itemid)";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.activityid FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where b.itemid=".$itemidd;
			$sql_resw=mysql_query($sqlw);
			if(mysql_num_rows($sql_resw)>0)
			{
			?>
			<option value="<?php echo  $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
			  <option value="<?php echo  $row3g['itemid'];?>" ><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo  $itemid; ?>" name="txtitemid" id="txtitemid" />
			      <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo  $itemid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
						<th style="width:25%;"><?php echo  "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo  "Start Date";?></th>
						<th style="width:25%;"><?php echo  "End Date";?></th>
						<th style="width:25%;"><?php echo  "Baseline Qty";?></th>
						<th style="width:25%;"><?php echo  "Weight";?></th>
						<th style="width:25%;"><?php echo  "Action";?></th>
						
                        
                        
                    </tr>
				
			<?php
			$sql_a="SELECT b.aid,b.itemid,b.startdate,b.enddate, b.baseline,  b.rid FROM `kpi_activity` a inner join `activity` b on (a.activityid=b.aid) where a.kpiid=".$itemid; 
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$itemidd=$row3_a['itemid'];
			 $sql_n="Select * from maindata where itemid='$itemidd'";
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			/*$itemname_with_resource=$itemname." - ".$row3_a['secheduleid'];*/
			$aid=$row3_a['aid'];
			?>
			
			<tr >
			<td>
			  <?php  if($kpiadm_flag==1)
				{
				?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo  $aid; ?>,<?php echo  $itemid; ?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?> );" title="Remove size">[X]</a><?php
			}
			?></td>
			<td><b><?php echo  $itemname; ?></b></td>
			
			 <?php  
			  
			  
			 $sqlg="Select * from `baseline`";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			if($row3g['rid']==$row3_b['rid'])
				{
						
			?>
			
			<td><?php echo $row3g['base_desc'];?></td>
			<?php
				}
			}
			?>
			
			<td><?php echo $row3_a['startdate'];?></td>
			<td ><?php echo $row3_a['enddate'];?></td>
			
			<td><?php echo $row3_a['baseline'];?></td>
			
			<?php
			$sqlga="Select * from kpi_activity where activityid=$aid and kpiid=$itemid";
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			?>
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo  $aid;?>,<?php echo  $itemid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"  /><?php
				}
				?></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			
			?>	
					
                </tbody>
            </table>
<?php }
else
{?>
<?php if($length>0 && $act_s!="")
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
					$startdate=$rows["startdate"];
					$enddate=$rows["enddate"];
					$itemida=$rows["itemid"];
					$saSQL = ("INSERT INTO activity (itemid,startdate,enddate,temp_id) VALUES ($itemida,'$startdate','$enddate',$temp_id)");
					$objDbI->execute($saSQL);
					$aid = $objDbI->getAutoNumber();
					
					$eSql_2 = "Select * from kpi_activity where kpiid=$itemid and activityid=$aid";
					$res_sq2=mysql_query($eSql_2);
					if(mysql_num_rows($res_sq2)>0)
					{
					}
					else
					{
					$sSQL = ("INSERT INTO kpi_activity (kpiid,activityid) VALUES ($itemid,$aid)");
					$objDb->execute($sSQL);
					}
				
				}
			}
			
		}
		
}
?>
<table  width="100%">
            	<tbody id="tblPrdSizesProject<?php echo  $itemid; ?>">
				<tr><td colspan="13">
				<form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo  $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo  $itemid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where a.kpiid=$itemid )";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.activityid FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where b.itemid=".$itemidd. " AND b.temp_id=".$temp_id;
			$sql_resw=mysql_query($sqlw);
			if(mysql_num_rows($sql_resw)>0)
			{
			?>
			<option value="<?php echo  $row3g['itemid'];?>"  style="background-color:#FEC0C7; margin-bottom:1px"><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			<?php			
			}
			else
			{
			?>
			  <option value="<?php echo  $row3g['itemid'];?>" ><?php echo  $row3g['itemcode']." : ".$row3g['itemname']; ?> </option>
			  <?php
			  }
			  }
			  ?>
			  </select>
			   <input type="hidden" value="<?php echo  $itemid; ?>" name="txtitemid" id="txtitemid" />
			      <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo  $itemid; ?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
						<th style="width:25%;"><?php echo  "Activity";?></th>
						 <th style="width:15%;"><?php echo  "Start Date";?></th>
						<th style="width:25%;"><?php echo  "End Date";?></th>
                        <th style="width:25%;"><?php echo  "Baseline Item";?></th>
                        <th style="width:25%;"><?php echo  "Allocated";?></th>
						<th style="width:25%;"><?php echo  "Weight";?></th>
						<th style="width:25%;"><?php echo  "Action";?></th>
						
                        
                        
                    </tr>
				
			<?php
			$sql_a="SELECT b.aid,b.itemid,b.startdate,b.enddate, b.baseline,  b.rid FROM `kpi_activity` a inner join `activity` b on (a.activityid=b.aid) where a.kpiid=".$itemid." AND b.temp_id=$temp_id"; 
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$itemidd=$row3_a['itemid'];
			 $sql_n="Select * from maindata where itemid='$itemidd'";
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			/*$itemname_with_resource=$itemname." - ".$row3_a['secheduleid'];*/
			$aid=$row3_a['aid'];
			?>
			
			<tr >
			<td>
			  <?php  if($kpiadm_flag==1)
				{
				?>
			<a href="javascript:void(null);" onclick="remove_data(<?php echo  $aid; ?>,<?php echo  $itemid; ?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?> );" title="Remove size">[X]</a><?php
			}
			?></td>
			<td><b><?php echo  $itemname; ?></b></td>
			<td><?php echo $row3_a['startdate'];?></td>
			<td ><?php echo $row3_a['enddate'];?></td>
			 <?php 
			 if($row3_a['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
				if($row3g['rid']==$row3_a['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			<td><?php echo $row3_a['baseline'];?></td>
			<?php
			$sqlga="Select * from kpi_activity where activityid=$aid and kpiid=$itemid";
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			?>
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>  <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?><input type="button" value="Edit" name="edit" id="edit" onclick="edit_data(<?php echo  $aid;?>,<?php echo  $itemid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"  /><?php
				}
				?></td>
			</tr>
		
			<?php
			$i=$i+1;
			}
			
			?>	
					
                </tbody>
            </table>
			
<?php }?>