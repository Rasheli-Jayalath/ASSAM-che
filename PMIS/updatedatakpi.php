<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="Activity Data Entry";
if ($uname==null)
{
	header("Location: index.php?init=3");
}

$kaid 					= $_REQUEST['kaid'];
$aid 					= $_REQUEST['aid'];
$rid 					= $_REQUEST['rid'];
$temp_id 				= $_REQUEST['temp_id'];
$temp_is_default	    = $_REQUEST['temp_is_default'];
$baseline				= $_REQUEST['baseline'];
$kpiid 				= $_REQUEST['kpiid'];
$kaweight				= $_REQUEST['kaweight'];



$objDb  = new Database();
$objDbI  = new Database();
$objDbII  = new Database();
@require_once("get_url.php");

/* $sqlr="Select rid from baseline where schedulecode='$secheduleid'";
			$resr=mysql_query($sqlr);
			$row3r=mysql_fetch_array($resr);
			$rid=$row3r['rid'];
*/
$squ="SELECT * from activity where aid=$aid";
$sqres=mysql_query($squ);
$sqrows=mysql_fetch_array($sqres);

 $sSQL5 = "UPDATE kpi_activity SET
		kaweight = $kaweight
		where kaid=$kaid and kpiid=$kpiid";
	$objDb->execute($sSQL5);
	 if($temp_is_default==0)
{
 $sSQL6 = "UPDATE activity SET
		rid = $rid,
		baseline = $baseline
		where aid=$aid AND temp_id=$temp_id";
	$objDbI->execute($sSQL6);
	
}

	$sSQLD = "DELETE FROM planned where itemid=".$sqrows["itemid"]." AND rid=".$sqrows['rid'];
	$objDbII->execute($sSQLD);
	 $sSQL_pln = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty,temp_id) select d.itemid, d.rid, d.pl_date,d.planned_qty,'.$temp_id.' as temp_id from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as pl_date, count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) a ,(select count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01")) as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01"))) e on (f.pl_date=e.pl_date) ) d');
	 mysql_query($sSQL_pln);
		
	$msg="Updated!";
	
	/*$log_module  = $module." Module";
	$log_title   = "Update ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO activity_log (log_module,log_title,log_ip, itemid, code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks,rid,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$code', '$secheduleid','$startdate', '$enddate','$actualstartdate','$actualenddate',$aorder,$baseline,'$remarks',$rid,$aid)");
	$objDb->execute($sSQL);*/

?>

<?php if($temp_is_default==1)
{?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $kpiid; ?>">
				<tr>
						<td colspan="13"><form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $kpiid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where  isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where a.kpiid=$kpiid)";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.activityid FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where b.itemid=".$itemidd;
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
			   <input type="hidden" value="<?php echo $kpiid; ?>" name="txtitemid" id="txtitemid" />
			    <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?>
				<input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $kpiid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
                        <th style="width:25%;">Activity</th>
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						<th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline";?></th>
						<th style="width:25%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php 
$sql_b="SELECT a.kaid, b.aid,b.itemid,b.startdate,b.enddate, b.baseline, b.temp_id, b.rid FROM `kpi_activity` a inner join activity b on (a.activityid=b.aid) where a.kpiid=".$kpiid; 
/*$sql_d="Select * from kpi_activity where milestoneid=$itemid";*/
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$sql_n="Select * from maindata where itemid=".$row3_b['itemid'];
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			$aid=$row3_b['aid'];
			$kaid=$row3_b['kaid']
			?>
			
			<tr >
			<td><a href="javascript:void(null);" onclick="remove_data(<?php echo $aid; ?>,<?php echo $kpiid; ?> ,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>);" title="Remove size">[X]</a>
            </td>
			<td><b><?php echo $itemname; ?></b></td>
			 <?php 
			 if($row3_b['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
				if($row3g['rid']==$row3_b['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			<td><?php echo $row3_b['startdate'];?></td>
			<td ><?php echo $row3_b['enddate'];?></td>
			
			<td><?php echo $row3_b['baseline'];?></td>
			
			<?php
			$sqlga="Select * from kpi_activity where kaid=".$kaid;
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			?>
			
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $kpiid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"/>
			<?php
			}
			?>
			</td>
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
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $kpiid; ?>">
				<tr>
						<td colspan="13"><form name="form1" id="form1" method="post" >
		  <div id="activities"  <?php echo $style; ?>> 
			 
			 <select name="act[]" id="act<?php echo $kpiid;?>"  class="s4a" multiple="multiple"  style="width:630px; height:200px" >
			   
			  <?php 
		
			$sqlg="Select * from maindata where  isentry=1 and itemid not in(SELECT DISTINCT(b.itemid) as actid1 FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where a.kpiid=$kpiid)";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$itemidd=$row3g['itemid'];
			$sqlw="SELECT a.activityid FROM kpi_activity a inner join activity b on (a.activityid=b.aid) where b.itemid=".$itemidd;
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
			   <input type="hidden" value="<?php echo $kpiid; ?>" name="txtitemid" id="txtitemid" />
			    <?php  if($kpientry_flag==1 || $kpiadm_flag==1)
				{
				?>
				<input type="button" value="Add Activities" name="save" id="save" onclick="addactivities(<?php echo $kpiid; ?>,<?php echo $temp_id; ?>,<?php echo $temp_is_default; ?>)" />
				<?php
				}
				?>
				
			 </div>
			 </form></td></tr>
                    <tr>
						<th style="width:2%;"></th>
                        <th style="width:25%;">Activity</th>
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						<th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline";?></th>
						<th style="width:25%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php 
$sql_b="SELECT a.kaid, b.aid,b.itemid,b.startdate,b.enddate, b.baseline, b.temp_id, b.rid FROM `kpi_activity` a inner join activity b on (a.activityid=b.aid) where a.kpiid=".$kpiid; 
/*$sql_d="Select * from kpi_activity where milestoneid=$itemid";*/
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$sql_n="Select * from maindata where itemid=".$row3_b['itemid'];
			$res_n=mysql_query($sql_n);
			$row3_n=mysql_fetch_array($res_n);
			$itemname=$row3_n['itemname'];
			$aid=$row3_b['aid'];
			$kaid=$row3_b['kaid']
			?>
			
			<tr >
			<td><a href="javascript:void(null);" onclick="remove_data(<?php echo $aid; ?>,<?php echo $kpiid; ?> ,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>);" title="Remove size">[X]</a>
            </td>
			<td><b><?php echo $itemname; ?></b></td>
			 <?php 
			 if($row3_b['rid']==0) 
			 {?>
			<td><?php echo "No Base Item";?></td> 
			<?php  }
			 else
			 {
			 $sqlg="Select * from `baseline` ";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
				if($row3g['rid']==$row3_b['rid'])
				{
				?>
			<td><?php echo $row3g['base_desc'];?></td>
			<?php 
				}
			} }
			?>
			<td><?php echo $row3_b['startdate'];?></td>
			<td ><?php echo $row3_b['enddate'];?></td>
			
			<td><?php echo $row3_b['baseline'];?></td>
			
			<?php
			$sqlga="Select * from kpi_activity where kaid=".$kaid;
			$resga=mysql_query($sqlga);
			$rowa_a=mysql_fetch_array($resga);
			?>
			
			<td><?php echo $rowa_a['kaweight'];?></td>
			<td>
			<?php  if($kpientry_flag==1 || $kpiadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $kpiid;?>,<?php echo  $temp_id; ?>,<?php echo  $temp_is_default; ?>)"/>
			<?php
			}
			?>
			</td>
			</tr>
			<?php
			$i=$i+1;
			}
		
			?>		
 </tbody>
            </table>
<?php }?>