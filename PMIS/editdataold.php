<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
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
                       <th style="width:5%;"></th>
                        <th style="width:15%;"><?php echo "Code";?></th>
						<th style="width:25%;"><?php echo "Resource";?></th>
						 <th style="width:15%;"><?php echo "Start Date";?></th>
						<th style="width:25%;"><?php echo "End Date";?></th>
						 <th style="width:15%;"><?php echo "Actual Start Date";?></th>
						<th style="width:25%;"><?php echo "Actual End Date";?></th>
						 <th style="width:15%;"><?php echo "Order";?></th>
						<th style="width:25%;"><?php echo "Base Line";?></th>
						<th style="width:5%;"><?php echo "Weight";?></th>
						<th style="width:25%;"><?php echo "Remarks";?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
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
			while($row3g=mysql_fetch_array($resg))
			{
			
				if($row3g['schedulecode']==$row3['secheduleid'])
				{
				$sele = " selected" ;
				}
				else
				{
				$sele = "" ;
				}
				
				
			?>
			  <option value="<?php echo $row3g['schedulecode'];?>"  <?php echo $sele; ?>><?php echo $row3g['schedulecode']. ": ".$row3g['resource']; ?> </option>
			  <?php
			  }
			  ?>
			  </select></td>
			<td><input type="text"  name="txtstartdate" id="txtstartdate" value="<?php echo $row3['startdate']; ?>" /></td>
			<td ><input id="txtenddate" name="txtenddate" type="text" value="<?php echo $row3['enddate']; ?>"/></td>
			<td ><input id="txtastartdate" name="txtastartdate" type="text" value="<?php echo $row3['actualstartdate']; ?>"/></td>
			<td><input type="text"  name="txtaenddate" id="txtaenddate" value="<?php echo $row3['actualenddate']; ?>" /></td>
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
			<td><?=$row3['secheduleid'];?></td>
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
