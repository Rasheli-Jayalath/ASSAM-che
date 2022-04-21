<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module="BOQ Activity Data Entry Update";
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$objDb  = new Database();
$admflag 				= $_SESSION['admflag'];
$superadmflag	 		= $_SESSION['superadmflag'];
$boqid 					= $_REQUEST['boqid'];
$itemid 				= $_REQUEST['itemid'];
$boqcode	 			= mysql_real_escape_string($_REQUEST['boqcode']);
$boqitem 				= mysql_real_escape_string($_REQUEST['boqitem']);
$boqunit				= $_REQUEST['boqunit'];
$boqqty					= $_REQUEST['boqqty'];
$boq_cur_1_rate			= $_REQUEST['boq_cur_1_rate'];
$boqamount=$boqqty*$boq_cur_1_rate;
$boq_cur_2_rate			= $_REQUEST['boq_cur_2_rate'];
$boqfamount =$boqqty*$boq_cur_2_rate;
$boq_cur_3_rate			= $_REQUEST['boq_cur_3_rate'];
$boqcurrrate=0;	
	$boqfrate=0;
$eSqls = "Select * from project_currency ";
  $objDb -> query($eSqls);
  $base_currFlag=false;
  $eeCount = $objDb->getCount();
if($eeCount > 0){
  $cur_1_rate 					= $objDb->getField(0,cur_1_rate);
  $cur_2_rate 					= $objDb->getField(0,cur_2_rate);
  $cur_3_rate 					= $objDb->getField(0,cur_3_rate);
  $base_cur 				= $objDb->getField(0,base_cur);
  $cur_1 					= $objDb->getField(0,cur_1);
  $cur_2 					= $objDb->getField(0,cur_2);
  $cur_3 					= $objDb->getField(0,cur_3);
  
  }


@require_once("get_url.php");

   $sSQL5 = "UPDATE boq SET
		boqcode			='".mysql_real_escape_string($boqcode)."', 
		boqitem			='".mysql_real_escape_string($boqitem)."',
		boqunit			='".mysql_real_escape_string($boqunit)."',
		boq_base_currency='$base_cur',
		boqqty			=$boqqty,
		boq_cur_1		='$cur_1',
		cur_1_exchrate	='$cur_1_rate',
		boq_cur_1_rate	='$boq_cur_1_rate',
		boq_cur_2		='$cur_2',
		cur_2_exchrate	='$cur_2_rate',
		boq_cur_2_rate	='$boq_cur_2_rate',
		boq_cur_3		='$cur_3',
		cur_3_exchrate ='$cur_3_rate',
		boq_cur_3_rate ='$boq_cur_3_rate'
		where boqid=$boqid and itemid=$itemid";
		
		 $sSQL5 = "UPDATE boq SET
		boqcode			= '$boqcode', 
		boqitem			='$boqitem',
		boqunit			='$boqunit',
		boqrate			=$boq_cur_1_rate,
		boqqty			=$boqqty,
		boqamount		=$boqamount,
		boqcurrency		='$base_cur',
		boqcurrrate		=$boqcurrrate,
		boqfamount		=$boqfamount,
		boqfcurrency	='$cur_2',
		boqfrate		=$boqfrate,
		boqfcurrate		=$boq_cur_1_rate
		where boqid=$boqid and itemid=$itemid";
	$objDb->execute($sSQL5);
	$msg="Updated!";
	
	$log_module  = $module." Module";
	$log_title   = "Update ".$module." Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	//$sSQL = ("INSERT INTO boq_log (log_module,log_title,log_ip, itemid,  boqcode,  boqitem, boqunit, boqrate, boqqty, boqamount, boqcurrency,boqcurrrate, boqfamount,boqfcurrency,boqfrate,boqfcurrate,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$boqcode', '$boqitem','$boqunit', $boqrate,$boqqty,$boqamount,'$boqcurrency',$boqcurrrate,$boqfamount,'$boqfcurrency',$boqfrate,$boqfcurrate,$boqid)");
	//$objDb->execute($sSQL);

?>
<table  width="100%" >
            	<tbody id="tblPrdSizesProject<?php echo $itemid; ?>">
                   <tr>
                       <th style="width:2%;"></th>
                        <th style="width:5%;"><?php echo "Code";?><span style="color:red;">*</span></th>
						<th style="width:15%;"><?php echo "Item";?><span style="color:red;">*</span></th>
						 <th style="width:5%;"><?php echo "Unit";?><span style="color:red;">*</span></th>
						 <th style="width:5%;"><?php echo "Quantity";?><span style="color:red;">*</span></th>
                         <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Rate<span style="color:red;">*</span>&nbsp;<?php if($cur_1==$base_cur) { echo "<br/>(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_1_rate.")";}?></th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Rate<span style="color:red;">*</span>&nbsp;<?php if($cur_2==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_2_rate.")";}?></th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Rate<span style="color:red;">*</span>&nbsp;<?php if($cur_3==$base_cur) { echo "(Base Currency)"; } else { echo "<br/>(Exchange Rate:".$cur_3_rate.")";}?></th>
						<?php }?>
						<th style="width:3%;"><?php echo "Action";?></th>
                        
                        
                    </tr>
<?php $sql_b="Select * from boq where itemid=$itemid";
			$res_b=mysql_query($sql_b);
			$i=1;
			while($row3_a=mysql_fetch_array($res_b))
			{
			$boqid=$row3_a['boqid'];
			?>
			
			<tr ><td><?php echo $i; ?></td>
			<td><?php echo $row3_a['boqcode'];?></td>
			<td><?php echo $row3_a['boqitem'];?></td>
			<td><?php echo $row3_a['boqunit'];?></td>
			<td><?php echo $row3_a['boqqty'];?></td>
			 <?php if($cur_1!="")
						  {?>
			<td><?php echo $row3_a['boqrate'];?></td>
            <?php }?>
             <?php if($cur_2!="")
						  {?>
			<td><?php echo $row3_a['boqfcurrate'];?></td>
            <?php }?>
             <?php if($cur_3!="")
						  {?>
			<td><?php echo $row3_a['boq_cur_3_rate'];?></td>
            <?php }?>
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
