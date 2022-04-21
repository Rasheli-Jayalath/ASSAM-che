<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$itemid 				= $_REQUEST['itemid'];

$objDb  = new Database( );
@require_once("get_url.php");


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
