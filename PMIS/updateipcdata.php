<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="Update IPC Entry";
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
$progress 				= $_REQUEST['progress'];
$progressdate1 			= $_REQUEST['progressdate'];
$remarks 			= $_REQUEST['remarks'];
$attach_link 		= $_REQUEST['attach_link'];
$progressdate=$progressdate1."-01";


$objDb  = new Database( );
$objDbI  = new Database( );
@require_once("get_url.php");
$file_path="project_data";
function genRandom($char = 5){
	$md5 = md5(time());
	return substr($md5, rand(5, 25), $char);
}
function getExtention($type){
	if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
		return "jpg";
	elseif($type == "image/png")
		return "png";
	elseif($type == "image/gif")
		return "gif";
	elseif($type == "application/pdf")
		return "pdf";
	elseif($type == "application/msword")
		return "doc";
	elseif($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		return "docx";
	elseif($type == "text/plain")
		return "doc";
		
		
}
if(isset($_FILES["attach_link"]["name"])&&$_FILES["attach_link"]["name"]!="")
	{
		
	$extension=getExtention($_FILES["attach_link"]["type"]);
	$file_name=genRandom(5)."-".$pid;
	if(($_FILES["attach_link"]["type"] == "application/pdf")|| ($_FILES["attach_link"]["type"] == "application/msword") || 
	($_FILES["attach_link"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
	($_FILES["attach_link"]["type"] == "text/plain") || 
	($_FILES["attach_link"]["type"] == "image/jpg")|| 
	($_FILES["attach_link"]["type"] == "image/jpeg")|| 
	($_FILES["attach_link"]["type"] == "image/gif") || 
	($_FILES["attach_link"]["type"] == "image/png"))
	{ 
	 
	if($attach_link!="")
	{
	 @unlink($file_path."/". $attach_link);
	 
	}
	else
	{
		$target_file=$file_path.$file_name;
	copy($_FILES['attach_link']['tmp_name'],"temp/".$_FILES['attach_link']['name']);	
	//include("imageResize.php");
	//$imagelink2 = "temp/".$_FILES['attach_link']['name'];
	//list($widtho, $heighto, $typeo, $attro) = getimagesize($imagelink2);
	
	$flink=$file_name.".".$flink;
	$sql_pro=mysql_query("UPDATE ipcv SET
		attach_link='$attach_link'
		where ipcvid=$ipcvid and ipcid=$ipcid and boqid=$boqid");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
	}
	}
	}
$sSQL = "UPDATE ipcv SET
		ipcqty			=$progress , remarks='$remarks', attach_link='$attach_link'
		where ipcvid=$ipcvid and ipcid=$ipcid and boqid=$boqid";  
	$objDb->execute($sSQL);
	$msg="Updated!";
	$tSql="Select * from baseline_template where use_data=1 OR use_data=2";
	$resbtemp=mysql_query($tSql);
	$tempcount=mysql_num_rows($resbtemp);
	if($tempcount>0)
	{
	while($row3tmpgb=mysql_fetch_array($resbtemp))
	{
	$boq_temp_id=$row3tmpgb["temp_id"];
    $ttSql="SELECT * FROM baseline a inner join baseline_mapping_boqs b on (a.rid=b.rid) where a.temp_id=".$boq_temp_id." AND b.boqid=".$boqid;
	$resttemp=mysql_query($ttSql);
	$checkboq=mysql_num_rows($resttemp);
	if($checkboq>0)
	{
	 $suSQL = "UPDATE template_progress SET update_flag=1 where temp_id=$boq_temp_id AND progress_type=1";  
		$objDbI->execute($suSQL);
	}
	}
	}
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
			$ipcvid=$row3_d['ipcvid'];
			$ipcremarks=$row3_d['remarks'];
			$ipcattach_link=$row3_d['attach_link'];
			?>
			
			
			
			
		<input type="hidden" value="<?php echo $progressdate1 ;?>" name="txtprogressdate" id="txtprogressdate"  />
			<td><?php echo $ipcqty;
			echo "<br/>";
			echo $ipcremarks;
			echo "<br/>";
			echo $ipcattach_link;?></td>
			<?php if(mysql_num_rows($res_d)>0)
			{
			?>
			
			<td>
			<?php
			if($ipcentry_flag==1 || $ipcadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  onclick="editipc_data(<?php echo $ipcvid; ?>,<?php echo $pid;?>,<?php echo $ipcid;?>,<?php echo $itm_id;?>)"/>
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
			</tr>
		
			<?php
			$j=$j+1;
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>