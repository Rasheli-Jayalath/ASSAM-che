<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$aid 				= $_REQUEST['aid'];
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
<?php $sql_a="Select * from activity where itemid=$itemid";
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3=mysql_fetch_array($res_a))
			{
			if($row3['aid']==$aid){
			?>
			<tr ><td><?php echo $i; ?></td>
			<td><input id="itemid" name="itemid" type="hidden" value="<?php echo $row3['itemid']; ?>"/><input id="txtcode" name="txtcode" type="text" value="<?php echo $row3['code']; ?>"/></td>
		<td><select name="txtscheduleid" id="txtscheduleid"  class="s4a" >
			   
			  <?php  
			  
			  
			 $sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			?>
			<option value="0">Select Resource</option>
			<?php
			while($row3g=mysql_fetch_array($resg))
			{
			
				if($row3g['rid']==$row3['rid'])
				{
				$sele = " selected" ;
				}
				else
				{
				$sele = "" ;
				}
				
				
			?>
			  <option value="<?php echo $row3g['rid'];?>"  <?php echo $sele; ?>><?php echo $row3g['schedulecode']. ": ".$row3g['resource']; ?> </option>
			  <?php
			  }
			  ?>
			  </select></td>
			<td><input type="text"  name="txtstartdate" id="txtstartdate" value="<?php echo $row3['startdate']; ?>" onClick="add_sd('txtstartdate')";/></td>
			<td ><input id="txtenddate" name="txtenddate" type="text" value="<?php echo $row3['enddate']; ?>" onClick="add_ed('txtenddate')";/></td>
			<td ><input id="txtastartdate" name="txtastartdate" type="text" value="<?php echo $row3['actualstartdate']; ?>" onClick="add_asd('txtastartdate')";/></td>
			<td><input type="text"  name="txtaenddate" id="txtaenddate" value="<?php echo $row3['actualenddate']; ?>" onClick="add_aed('txtaenddate')";/></td>
			<td><input id="txtorder" name="txtorder" type="text" value="<?php echo $row3['aorder']; ?>"/></td>
			<td><input id="txtbaseline" name="txtbaseline" type="text" value="<?php echo $row3['baseline']; ?>"/></td>
			<td><input id="txtweight" name="txtweight" type="text" value="<?php echo $row3['weight']; ?>"/></td>
			<td><textarea name="txtremarks" id="txtremarks" cols="25" rows="5"><?php echo $row3['remarks']; ?></textarea></td>
			<td><input type="button" value="Update" name="update" id="update"  onclick="update_data(<?php echo $aid;?>)"/></td>
			</tr>
			<?php

			}
			else
			{
			
			?>
			
			<tr ><td><?php echo $i; ?></td>
			<td><?=$row3['code'];?></td>
			
			 <?php  
			   if($row3['rid']==0)
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
				if($row3g['rid']==$row3['rid'])
					{
							
				?>
				
				<td><?=$row3['secheduleid'].": ".$row3g['resource'];?></td>
				<?php
				}
				}
			}
			?>
			
			<td><?=$row3['startdate'];?></td>
			<td ><?=$row3['enddate'];?></td>
			<td ><?=$row3['actualstartdate'];?></td>
			<td><?=$row3['actualenddate'];?></td>
			<td><?=$row3['aorder'];?></td>
			<td><?=$row3['baseline'];?></td>
			<td><?=$row3['weight'];?></td>
			<td><?=$row3['remarks'];?></td>
			<td><input type="button" value="Edit" name="edit" id="edit"  disabled="disabled" /></td>
			</tr>
			
			<?php
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>
