<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
//$uname = $_SESSION['uname'];
$module="Update Progress Entry";
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$pgid 					= $_REQUEST['pgid'];
$pid 					= $_REQUEST['pid'];
$itemid 				= $_REQUEST['itemid'];
$rid	 				= $_REQUEST['rid'];
$temp_id	 			= $_REQUEST['temp_id'];
$progress 				= $_REQUEST['progress'];
$progressdate1 			= $_REQUEST['progressdate'];
$progressdate=$progressdate1."-01";
 $pdate=date('Y-m-d',strtotime($progressdate));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;									
$progressdate=$pdate;

$objDb  = new Database( );
@require_once("get_url.php");

$sSQL = "UPDATE progress SET
		progressqty			=$progress
		where pgid=$pgid and rid=$rid and itemid=$itemid and left(progressdate,7)='$progressdate1' and temp_id=$temp_id";  
	$objDb->execute($sSQL);
	$msg="Updated!";
	
	$log_module  = $module." Module";
	$log_title   = "Updated ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO progress_log (log_module,log_title,log_ip, itemid, rid, progressdate, progressqty,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,$rid,'$progressdate', $progress,$pgid)");
	$objDb->execute($sSQL);

?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                       <th style="width:20%;"></th>
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline";?></th>
						<th style="width:25%;"><?php echo "Progress As on ".$progressdate1;?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from maindata where parentcd=$pid and isentry=1";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$itm_id=$row3_b['itemid'];
			$sql_c="Select * from activity where itemid=$itm_id and temp_id=$temp_id";
			$res_c=mysql_query($sql_c);
			while($row3_c=mysql_fetch_array($res_c))
			{			
			$aid=$row3_c['aid'];
			$rid=$row3_c['rid'];
			?>
			
			<tr ><td><?php echo $row3_b['itemname']; ?></td>
			
			<?php
			 if($row3_c['rid']==0)
			{
			?>
			<td></td>
			<?php
			}
			else
			{   
				 $sqlg="Select * from baseline where temp_id=$temp_id";
				$resg=mysql_query($sqlg);
				while($row3g=mysql_fetch_array($resg))
				{
				if($row3g['rid']==$row3_c['rid'])
					{
							
				?>
				
				<td><?php echo  $row3g['base_desc'];?></td>
				<?php
				}
				}
			}
			?>
			<td><?php echo $row3_c['startdate'];?></td>
			<td ><?php echo $row3_c['enddate'];?></td>
			<td><?php echo $row3_c['baseline'];?></td>
			<?php
			$sql_d="Select * from progress where itemid=$itm_id and rid=$rid and left(progressdate,7)='$progressdate1' and temp_id=$temp_id";
			$res_d=mysql_query($sql_d);
			$row3_d=mysql_fetch_array($res_d);			
			$progressqty=$row3_d['progressqty'];
			$pgidd=$row3_d['pgid'];
			?>
			
			<td><input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  /><?php echo $progressqty;?></td>
			<?php if(mysql_num_rows($res_d)>0)
			{
			?>
			
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data(<?php echo $pgidd; ?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			?>
			<td>
			<?php  if($spgentry_flag==1 || $spgadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editp_data1(<?php echo $aid;?>,<?php echo $pid;?>,<?php echo $rid;?>,<?php echo $itm_id;?>, <?php echo $temp_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			
			?>
			
			</tr>
			<?php
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>