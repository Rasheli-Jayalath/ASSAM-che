<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$pid 				= $_REQUEST['itemid'];
$temp_id 				= $_REQUEST['temp_id'];

$objDb  = new Database( );
@require_once("get_url.php");
 $sql_p="Select left(pmonth,7) as pmmonth from progressmonth where status=0";
 $res_p=mysql_query($sql_p);
 $row3_p=mysql_fetch_array($res_p);
 $pmonth=$row3_p['pmmonth'];

?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                       <th style="width:20%;"></th>
						<th style="width:25%;"><?php echo "Baseline Item";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						<th style="width:25%;"><?php echo "Baseline";?></th>
						<th style="width:25%;"><?php echo "Progress As on ".$pmonth;?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from maindata where parentcd=$pid and isentry=1";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$itm_id=$row3_b['itemid'];
			$sql_c="Select * from activity where itemid=$itm_id AND temp_id=".$temp_id;
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
				 $sqlg="Select * from baseline where temp_id=".$temp_id;
				$resg=mysql_query($sqlg);
				while($row3g=mysql_fetch_array($resg))
				{
				if($row3g['rid']==$row3_c['rid'])
					{
							
				?>
				
				<td><?php echo $row3g['base_desc'];?></td>
				<?php
				}
				}
			}
			?>
			
			<td><?php echo $row3_c['startdate'];?></td>
			<td ><?php echo $row3_c['enddate'];?></td>
		    <td><?php echo $row3_c['baseline'];?></td>
			<?php
			$sql_d="Select * from progress where itemid=$itm_id and rid=$rid and left(progressdate,7)='$pmonth' AND temp_id=$temp_id";
			$res_d=mysql_query($sql_d);
			$row3_d=mysql_fetch_array($res_d);			
			$progressqty=$row3_d['progressqty'];
			$pgidd=$row3_d['pgid'];
			?>
			
			
			<input type="hidden" value="<?php echo $pmonth;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $progressqty;?></td>
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
			?>
			</td>
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
			?>
			</td>
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
