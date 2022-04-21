<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="Add IPC-Entry";
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$pid 					= $_REQUEST['pid'];
$boqid 				= $_REQUEST['boqid'];
$ipcid	 				= $_REQUEST['ipcid'];
$progress 				= $_REQUEST['progress'];
$progressdate1 			= $_REQUEST['progressdate'];
$remarks 			= $_REQUEST['remarks'];
$attach_link 		= $_REQUEST['attach_link'];
$progressdate=$progressdate1."-01";


$objDb  = new Database( );
@require_once("get_url.php");
 
	$sSQL = ("INSERT INTO ipcv (boqid, ipcid, ipcqty, remarks, attach_link) VALUES ($boqid,$ipcid,$progress, '$remarks', '$attach_link' )");
	$objDb->execute($sSQL);
	$ipcvid = $objDb->getAutoNumber();
	$msg="Saved!";
	
/*	$log_module  = $module." Module";
	$log_title   = "Add ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL = ("INSERT INTO ipcv_log (log_module,log_title,log_ip, boqid, pcid,ipcqty,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$boqid,$pcid,$ipcqty,$ipcvid)");
	$objDb->execute($sSQL);*/

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
						
						<th style="width:10%;"><?php echo "IPC As on ".$progressdate1;?></th>
						<th style="width:10%;"><?php echo "Action";?></th>
                        
                    </tr>
<?php $sql_b="Select * from boqdata where parentcd=$pid";
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
			$sql_d="Select * from ipcv where boqid=$boqid and ipcid=$ipcid";
			$res_d=mysql_query($sql_d);
			$row3_d=mysql_fetch_array($res_d);			
			$ipcqty=$row3_d['ipcqty'];
			$ipcvid=$row3_d['ipcvid'];
			$ipcremarks=$row3_d['remarks'];
			$ipcattach_link=$row3_d['attach_link'];
			
			?>
			
			
			
			
		<input type="hidden" value="<?php echo $progressdate1 ;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $ipcqty;
			echo "<br/>";
			echo $ipcremarks;
			echo "<br/>";
			echo $ipcattach_link;
			?></td>
			<?php if(mysql_num_rows($res_d)>0)
			{
			?>
			
			<td><input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/></td>
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