<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$boqid 				= $_REQUEST['boqid'];
$itemid 				= $_REQUEST['itemid'];

$objDb  = new Database( );
@require_once("get_url.php");
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
<?php $sql_a="Select * from boq where itemid=$itemid";
			$res_a=mysql_query($sql_a);
			$i=1;
			while($row3=mysql_fetch_array($res_a))
			{
			if($row3['boqid']==$boqid){
			?>
			<tr ><td><?php echo $i; ?></td>
			<td><input id="itemid" name="itemid" type="hidden" value="<?php echo $row3['itemid']; ?>"/><input id="txtboqcode" name="txtboqcode" type="text" value="<?php echo $row3['boqcode']; ?>" style="width:50px;"/></td>
			<td><input type="text"  name="txtboqitem" id="txtboqitem" value="<?php echo $row3['boqitem']; ?>"  style="width:250px;"/></td>
			<td><input type="text"  name="txtboqunit" id="txtboqunit" value="<?php echo $row3['boqunit']; ?>" style="width:80px;"/></td>
			<td ><input id="txtboqqty" name="txtboqqty" type="text" value="<?php echo $row3['boqqty']; ?>" style="width:80px;"></td>
             <?php if($cur_1!="")
						  {?>
			<td><input id="boq_cur_1_rate" name="boq_cur_1_rate" type="text" value="<?php echo $row3['boqrate']; ?>" style="width:80px;"/></td>
            <?php }?>
             <?php if($cur_2!="")
						  {?>
			<td><input id="boq_cur_2_rate" name="boq_cur_2_rate" type="text" value="<?php echo $row3['boqfcurrate']; ?>" style="width:80px;"/></td>
              <?php }?>
               <?php if($cur_3!="")
						  {?>
			<td><input id="boq_cur_3_rate" name="boq_cur_3_rate" type="text" value="<?php echo $row3['boq_cur_3_rate']; ?>"/></td>
            <?php }?>
			<td><input type="button" value="Update" name="update" id="update"  onclick="update_data(<?php echo $boqid;?>)"/></td>
			</tr>
			<?php

			}
			else
			{
			
			?>
			
			<tr ><td><?php echo $i; ?></td>
			<td><?php echo $row3['boqcode'];?></td>
			<td><?php echo $row3['boqitem'];?></td>
			<td><?php echo $row3['boqunit'];?></td>
			<td><?php echo $row3['boqqty'];?></td>
		 <?php if($cur_1!="")
						  {?>
			<td><?php echo $row3['boqrate'];?></td>
            <?php }?>
             <?php if($cur_2!="")
						  {?>
			<td><?php echo $row3['boqfcurrate'];?></td>
            <?php }?>
             <?php if($cur_3!="")
						  {?>
			<td><?php echo $row3['boq_cur_3_rate'];?></td>
            <?php }?>
			<td>
			<?php
			if($boqentry_flag==1 || $boqadm_flag==1)
			{
			?>
			<input type="button" value="Edit" name="edit" id="edit"  disabled="disabled" />
			<?php
			}
			?>
			</td>
			</tr>
			
			<?php
			}
			$i=$i+1;
			}
			?>		
 </tbody>
            </table>
