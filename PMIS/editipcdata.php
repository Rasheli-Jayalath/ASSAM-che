<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}

$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$ipcvid 				= $_REQUEST['ipcvid'];
$pid 					= $_REQUEST['pid'];
$boqid 					= $_REQUEST['boqid'];
$ipcid	 				= $_REQUEST['ipcid'];
$progressdate1 			= $_REQUEST['progressdate'];

$objDb  = new Database( );
@require_once("get_url.php");

?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                         <th style="width:15%;"></th>
                        <th style="width:15%;"><?php echo "Code";?></th>
						<th style="width:25%;"><?php echo "Item";?></th>
						<th style="width:15%;"><?php echo "Unit";?></th>
						<th style="width:15%;"><?php echo "Quantity";?></th>
                        <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Rate&nbsp;<?php if($cur_1==$base_cur) { echo "<br/>(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_1_rate.")";}?></th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Rate&nbsp;<?php if($cur_2==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_2_rate.")";}?></th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Rate&nbsp;<?php if($cur_3==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_3_rate.")";}?></th>
						<?php }?>
					    <th style="width:15%;"><?php echo "IPC As on ".$progressdate1;?></th>
						<th style="width:10%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from boqdata where parentcd=$pid and isentry=1";
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
			<td><?php echo $row3_a['boqcode'];?></td>
			<td><?php echo $row3_a['boqitem'];?></td>
			<td><?php echo $row3_a['boqunit'];?></td>
			<td><?php echo $row3_a['boqqty'];?></td>
			  <?php if($cur_1!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_1_rate'];?></td>
            <?php }?>
             <?php if($cur_2!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_2_rate'];?></td>
            <?php }?>
             <?php if($cur_3!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_3_rate'];?></td>
            <?php }?>
			<?php
			$sql_d="Select * from ipcv where boqid=$boqid and ipcid=$ipcid";
			$res_d=mysql_query($sql_d);
			$row3_d=mysql_fetch_array($res_d);			
			$ipcqty=$row3_d['ipcqty'];
			$ipcvidd=$row3_d['ipcvid'];
			$ipcremarks=$row3_d['remarks'];
			$ipcattach_link=$row3_d['attach_link'];
			if($ipcvidd==$ipcvid)
			{
			?>
			
			<td>
			<input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  />			
			<input type="text" value="<?php echo $ipcqty;?>" name="txtprogress" id="txtprogress"  />
           <br/> Remarks: <input type="text" value="<?php echo $ipcremarks;?>" name="remarks" id="remarks"  />
           <br/> Attachment: <input type="file" value="<?php echo $ipcattach_link;?>" name="attach_link" id="attach_link"  /></td>			
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Update" name="update" id="update"  onclick="updateipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $boqid;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			?>
			<td><?php echo $ipcqty;?></td>
			<?php if(mysql_num_rows($res_d)>0)
			{
			?>
			
			<td><?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?><input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvidd; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $boqid;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			?>
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data1(<?php echo $boqid;?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			
			?>
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
