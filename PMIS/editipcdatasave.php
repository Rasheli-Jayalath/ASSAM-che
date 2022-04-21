<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$boqid 					= $_REQUEST['boqid'];
$pid 					= $_REQUEST['pid'];
$itemid 				= $_REQUEST['itemid'];
$ipcid	 				= $_REQUEST['ipcid'];
$progressdate1 			= $_REQUEST['progressdate'];

$objDb  = new Database( );
@require_once("get_url.php");
$eSqls = "Select * from project_currency ";
  $objDb -> query($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->getCount();
if($eeCount > 0){
  $cur_1_rate 				= $objDb->getField(0,cur_1_rate);
  $cur_2_rate 				= $objDb->getField(0,cur_2_rate);
  $cur_3_rate 				= $objDb->getField(0,cur_3_rate);
  $base_cur 				= $objDb->getField(0,base_cur);
  $cur_1 					= $objDb->getField(0,cur_1);
  $cur_2 					= $objDb->getField(0,cur_2);
  $cur_3 					= $objDb->getField(0,cur_3);
  
  }
?>

<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $pid; ?>">
                    <tr>
                        <th style="width:15%;"></th>
                        <th style="width:5%;"><?php echo "Code";?></th>
						<th style="width:15%;"><?php echo "Item";?></th>
						 <th style="width:5%;"><?php echo "Unit";?></th>
						 <th style="width:5%;"><?php echo "Quantity";?></th>
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
			$boqidd=$row3_a['boqid'];
			?>
			
			<tr>
			<td><?php echo $row3_b['itemname']; ?></td>
			<td><?php echo $row3_a['boqcode']; ?></td>
			<td><?php echo $row3_a['boqitem']; ?></td>
			<td><?php echo $row3_a['boqunit']; ?></td>
			<td><?php echo $row3_a['boqqty']; ?></td>
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
			
			if($boqidd==$boqid)
			{
			$ipcqty="";
			?>
			
			<td>
			<input type="hidden" value="<?php echo $progressdate1;?>" name="txtprogressdate" id="txtprogressdate"  />			
			<input type="text" value="<?php echo $ipcqty;?>" name="txtprogress" id="txtprogress"  />
            <br/> Remarks: <input type="text" value="" name="remarks" id="remarks"  />
           <br/> Attachment: <input type="text" value="" name="attach_link" id="attach_link"  /></td>			
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Update" name="save" id="save"  onclick="saveipc_data(<?php echo $pid;?>,<?php echo $boqidd;?>,<?php echo $ipcid;?>)"/>
			<?php
			}
			?></td>
			<?php
			}
			else
			{
			$sql_d="Select * from ipcv where boqid=$boqidd and ipcid=$ipcid";
			$res_d=mysql_query($sql_d);
			$row3_d=mysql_fetch_array($res_d);			
			$ipcqty=$row3_d['ipcqty'];
			$ipcvid=$row3_d['ipcvid'];
			?>
			
			<td><?php echo $ipcqty;?></td>
			<?php if(mysql_num_rows($res_d)>0)
			{
			?>
			
			<td><?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?><input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
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
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data1(<?php echo $boqidd;?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
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
