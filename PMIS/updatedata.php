<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="Activity Data Entry";
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$aid 					= $_REQUEST['aid'];
$itemid 				= $_REQUEST['itemid'];
$code	 				= $_REQUEST['code'];
$rid 			= $_REQUEST['secheduleid'];
$startdate				= $_REQUEST['startdate'];
$enddate				= $_REQUEST['enddate'];
$actualstartdate		= $_REQUEST['actualstartdate'];
$actualenddate			= $_REQUEST['actualenddate'];
$aorder					= $_REQUEST['aorder'];
$baseline				= $_REQUEST['baseline'];
$weight					= $_REQUEST['weight'];
$remarks				= $_REQUEST['remarks'];



$objDb  = new Database( );
@require_once("get_url.php");
if($rid==0)
{
$secheduleid='0';
}
else
{
 $sqlr="Select schedulecode from resources where rid=$rid";
			$resr=mysql_query($sqlr);
			$row3r=mysql_fetch_array($resr);
			$secheduleid=$row3r['schedulecode'];
}




$sSQL5 = "UPDATE activity SET
		code			= '$code', 
		secheduleid		='$secheduleid',
		startdate		='$startdate',
		enddate			='$enddate',
		actualstartdate	='$actualstartdate',
		actualenddate	='$actualenddate',
		aorder			=$aorder,
		baseline		=$baseline,
		remarks			='$remarks',		
		rid				=$rid,
		weight			=$weight
		where aid=$aid and itemid=$itemid";
	$objDb->execute($sSQL5);
	$msg="Updated!";
	
	$log_module  = $module." Module";
	$log_title   = "Update ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO activity_log (log_module,log_title,log_ip, itemid, code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks,rid,weight,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$code', '$secheduleid','$startdate', '$enddate','$actualstartdate','$actualenddate',$aorder,$baseline,'$remarks',$rid,$weight,$aid)");
	$objDb->execute($sSQL);
	$sSQLD = "DELETE FROM planned where itemid=".$itemid." AND rid=".$rid;
	$objDb->execute($sSQLD);
	 $sSQL_pln = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty) select d.itemid, d.rid, d.pl_date,d.planned_qty from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as pl_date, count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) a ,(select count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01")) as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01"))) e on (f.pl_date=e.pl_date) ) d');
	 mysql_query($sSQL_pln);

?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
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
<?php $sql_b="Select * from activity where itemid=$itemid";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$aid=$row3_b['aid'];
			?>
			
			<tr ><td><?php echo $i; ?></td>
			<td><?=$row3_b['code'];?></td>
			 <?php  
			  if($row3_b['rid']==0)
			{
			?>
			<td></td>
			<?php
			}
			else
			{    
			  
				 $sqlg="Select * from resources";
				$resg=mysql_query($sqlg);
				while($row3g=mysql_fetch_array($resg))
				{
				if($row3g['rid']==$row3_b['rid'])
					{
							
				?>
				
				<td><?=$row3_b['secheduleid'].": ".$row3g['resource'];?></td>
				<?php
				}
				}
			}
			?>
			
			<td><?=$row3_b['startdate'];?></td>
			<td ><?=$row3_b['enddate'];?></td>
			<td ><?=$row3_b['actualstartdate'];?></td>
			<td><?=$row3_b['actualenddate'];?></td>
			<td><?=$row3_b['aorder'];?></td>
			<td><?=$row3_b['baseline'];?></td>
			<td><?=$row3_b['weight'];?></td>
			<td><?=$row3_b['remarks'];?></td>
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $aid;?>,<?php echo $itemid;?>)"/></td>
			</tr>
			<?php
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>
