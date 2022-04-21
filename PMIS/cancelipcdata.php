<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$pid 				= $_REQUEST['itemid'];

$objDb  = new Database( );
@require_once("get_url.php");
 $sql_p="Select ipcid,left(ipcmonth,7) as ipcmmonth from ipc where status=0";
 $res_p=mysql_query($sql_p);
 $row3_p=mysql_fetch_array($res_p);
$ipcmonth=$row3_p['ipcmmonth'];
$ipcid=$row3_p['ipcid'];

?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                       <th style="width:5%;"></th>
                        <th style="width:15%;"><?php echo "BOQ Code";?></th>
						<th style="width:25%;"><?php echo "BOQ Item";?></th>
						 <th style="width:15%;"><?php echo "BOQ Unit";?></th>
						<th style="width:25%;"><?php echo "BOQ Rate";?></th>
						 <th style="width:15%;"><?php echo "BOQ Quantity";?></th>
						<th style="width:25%;"><?php echo "BOQ Amount";?></th>
						 <th style="width:15%;"><?php echo "BOQ Currency";?></th>
						<th style="width:25%;"><?php echo "BOQ Current Rate";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Amount";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Currency";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Rate";?></th>
						<th style="width:25%;"><?php echo "BOQ Foreign Current Rate";?></th>
						<th style="width:25%;"><?php echo "IPC As on ".$ipcmonth;?></th>
						<th style="width:25%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
				
			<?php 
			$sql_b="Select * from maindata where parentcd=$pid and isentry=1";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_b=mysql_fetch_array($res_b))
			{
			$itm_id=$row3_b['itemid'];			
			$sql_a="Select * from boq where itemid=$itm_id";
			$res_a=mysql_query($sql_a);
			$j=1;
			while($row3_a=mysql_fetch_array($res_a))
			{
			$boqid=$row3_a['boqid'];
			?>
			
			<tr >
			
			<td><?php echo $row3_b['itemname']; ?></td>
			<td><?=$row3_a['boqcode'];?></td>
			<td><?=$row3_a['boqitem'];?></td>
			<td><?=$row3_a['boqunit'];?></td>
			<td ><?=$row3_a['boqrate'];?></td>
			<td ><?=$row3_a['boqqty'];?></td>
			<td><?=$row3_a['boqamount'];?></td>
			<td><?=$row3_a['boqcurrency'];?></td>
			<td><?=$row3_a['boqcurrrate'];?></td>
			<td><?=$row3_a['boqfamount'];?></td>
			<td><?=$row3_a['boqfcurrency'];?></td>
			<td><?=$row3_a['boqfrate'];?></td>
			<td><?=$row3_a['boqfcurrate'];?></td>
			<?php
			$sql_d="Select * from ipcv where boqid=$boqid and ipcid=$ipcid";
			$res_d=mysql_query($sql_d);
			$row3_d=mysql_fetch_array($res_d);			
			$ipcqty=$row3_d['ipcqty'];
			$ipcvid=$row3_d['ipcvid'];
			?>
			
			
			
			
		<input type="hidden" value="<?php echo $ipcmonth;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $ipcqty;?></td>
			<?php if(mysql_num_rows($res_d)>0)
			{
			?>
			
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $boqid;?>)"/></td>
			<?php
			}
			else
			{
			?>
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data1(<?php echo $boqid;?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/></td>
			<?php
			}
			
			?>
			</tr>
		
			<?php
			$j=$j+1;
			}
			$i=$i+1;
			}
			?>	
					
                </tbody>
            </table>
