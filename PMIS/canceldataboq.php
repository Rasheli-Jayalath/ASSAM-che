<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$itemid 				= $_REQUEST['itemid'];

$objDb  = new Database( );
@require_once("get_url.php");


?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                    <tr>
                        <th style="width:2%;"></th>
                        <th style="width:5%;"><?php echo "BOQ Code";?><span style="color:red;">*</span></th>
						<th style="width:20%;"><?php echo "BOQ Item";?><span style="color:red;">*</span></th>
						 <th style="width:5%;"><?php echo "BOQ Unit";?><span style="color:red;">*</span></th>
						<th style="width:10%;"><?php echo "BOQ Rate";?><span style="color:red;">*</span></th>
						 <th style="width:10%;"><?php echo "BOQ Quantity";?><span style="color:red;">*</span></th>
						
						 <th style="width:5%;"><?php echo "BOQ Currency";?><span style="color:red;">*</span></th>
						<th style="width:5%;"><?php echo "BOQ Current Rate";?><span style="color:red;">*</span></th>
						
						<th style="width:5%;"><?php echo "BOQ Foreign Currency";?></th>
						<th style="width:5%;"><?php echo "BOQ Foreign Rate";?></th>
						<th style="width:5%;"><?php echo "BOQ Foreign Current Rate";?></th>
						<th style="width:3%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from boq where itemid=$itemid";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_a=mysql_fetch_array($res_b))
			{
			$boqid=$row3_a['boqid'];
			?>
			
			<tr><td><?php echo $i; ?></td>
			<td><?=$row3_a['boqcode'];?></td>
			<td><?=$row3_a['boqitem'];?></td>
			<td><?=$row3_a['boqunit'];?></td>
			<td ><?=$row3_a['boqrate'];?></td>
			<td ><?=$row3_a['boqqty'];?></td>
			
			<td><?=$row3_a['boqcurrency'];?></td>
			<td><?=$row3_a['boqcurrrate'];?></td>
			
			<td><?=$row3_a['boqfcurrency'];?></td>
			<td><?=$row3_a['boqfrate'];?></td>
			<td><?=$row3_a['boqfcurrate'];?></td>
			<td>
			<?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="edit_data(<?php echo $boqid;?>,<?php echo $itemid;?>)"/>
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
