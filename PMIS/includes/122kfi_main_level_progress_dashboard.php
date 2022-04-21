<?php 
/*if(isset($_REQUEST["obj"])&&$_REQUEST["obj"])
{
	$itemid=$_REQUEST["obj"];
}
else
{
$itemid=$data_level_idf;
}
*/

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

//SELECT DATE_SUB(max(ipcmonth),INTERVAL 1 MONTH) as ipcmonth from ipc
if(isset($itemid)&& $itemid!="" && $data_level_id==0)
{
function SECLAST_LastIPcNO()
{
	$data2="";
$sql="select (SELECT MAX(ipcmonth) FROM ipc) as maxmonth, (SELECT MAX(ipcmonth) FROM ipc WHERE ipcmonth NOT IN (SELECT MAX(ipcmonth) FROM ipc )) as secipcmonth";
$amountresult = mysql_query($sql);
$data=mysql_fetch_array($amountresult);
if($data["secipcmonth"]!=""|| $data["secipcmonth"]!=NULL)
{
$sql2="SELECT ipcno FROM ipc where ipcmonth='".$data["secipcmonth"]."'";
$amountresult2 = mysql_query($sql2);
$data2=mysql_fetch_array($amountresult2);
}
else
$data2=0;
return $data2;

}
function LastIPcNO()
{
$sql="SELECT ipcno FROM ipc where ipcmonth=(select max(ipcmonth) as ipcmonth  from ipc)";
$amountresult = mysql_query($sql);
$data=mysql_fetch_array($amountresult);
return $data;
}
$ipcnodatasec=SECLAST_LastIPcNO();
$ipcnodata=LastIPcNO();?>

<table id="tblList" cellpadding="0px" cellspacing="0px"    align="left" width="50%">
<tr  id="title">
  <td colspan="13" align="center" style="border-left:1px #000000 solid;border-top:1px #000000 solid; background-color:#000066"></tr>
<tr id="tblHeading">
  <th rowspan="2" style="border-left:1px #000000 solid;">Sr. No. </th>
<th rowspan="2"> Code </th>
<th rowspan="2">Description </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="2"> As Per Bid</th>
<th colspan="2">Paid Upto <?php if($ipcnodatasec!=0)echo $ipcnodatasec["ipcno"];?></th>
<th colspan="2">Paid in <?php echo $ipcnodata["ipcno"];?> </th>
<th colspan="2">Executed Upto <?php echo $ipcnodata["ipcno"];?> </th>
<th colspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
						 <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Amount</th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Amount</th>
						<?php }?>
                        <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Amount</th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Amount</th>
						<?php }?>
                        <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Amount</th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Amount</th>
						<?php }?>
                        <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Amount</th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?></th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?></th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?></th>
						<?php }?>
                        
</tr>
<?php
function getProgressAmountD($boqid)
{
	$amount=0;
 if($boqid!=0&&$boqid!='')
 {
    $sql="Select * from boq where boqid=".$boqid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM ipcv  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"];
	 
	 
 return $amount;
 }
}
function getProgressAmountD1($itemid)
{
	$todate_amount1=0;
 if($itemid!=0&&$itemid!='')
 {
    $sql="Select * from boq where itemid=".$itemid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM ipcv  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $todate_amount1+=$data['boq_cur_1_rate']*$data['cur_1_exchrate']*$pdata["ipcqty"];
	 
	 }
 return $todate_amount1;
 }
}
function getProgressAmountD2($itemid)
{
	$todate_amount2=0;
 if($itemid!=0&&$itemid!='')
 {
    $sql="Select * from boq where itemid=".$itemid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM ipcv  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $todate_amount2+=$data['boq_cur_2_rate']*$data['cur_2_exchrate']*$pdata["ipcqty"];
	 
	 }
 return $todate_amount2;
 }
}
function getProgressAmountD3($itemid)
{
	$todate_amount3=0;
 if($itemid!=0&&$itemid!='')
 {
    $sql="Select * from boq where itemid=".$itemid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM ipcv  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $todate_amount3+=$data['boq_cur_3_rate']*$data['cur_3_exchrate']*$pdata["ipcqty"];
	 
	 }
 return $todate_amount3;
 }
}
function getThisProgressQTY($boqid,$ipcid)
{
	$amount=0;
    if($boqid!=0&&$boqid!='')
    {
	 $sql="Select * from boq where boqid=".$boqid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	 if($data["boqid"]!=0&&$data["boqid"]!='')
	 {
	 $sql2="SELECT * FROM ipcv  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"];
	 }
	
	 }
 return $amount;
 
}
function getProgressAmountIPC($itemid,$ipcid)
{
	$sum=0;
	$i=1;
 if($itemid!=0&&$itemid!=0&&$itemid!='')
 {
	 $sql="Select * from boq where itemid=".$itemid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	// $sql2="SELECT * FROM ipcv  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	  $sql2="SELECT * FROM ipcv  WHERE boqid=".$data["boqid"]. " AND ipcid=".$ipcid;
	
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 while($pdata=mysql_fetch_array($pamountresult3))
	 {
	  $amount +=$pdata["ipcqty"];
	  
	 }
	  
	// echo  "QTY: ".$pdata["ipcqty"]. "Rate: ".$data["boqrate"]."= ".$amount;
	 // echo "<br/>";
	  $sum=$amount;
	  $i++;
	 }
	
	
 return $sum;
 }
}
function getProgressAmount($itemid)
{
	$sum=0;
	$i=1;
 if($itemid!=0&&$itemid!=0&&$itemid!='')
 {
	 $sql="Select * from boq where itemid=".$itemid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	// $sql2="SELECT * FROM ipcv  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	  $sql2="SELECT * FROM ipcv  WHERE boqid=".$data["boqid"];
	
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 while($pdata=mysql_fetch_array($pamountresult3))
	 {
	  $amount +=$pdata["ipcqty"];
	  
	 }
	  
	// echo  "QTY: ".$pdata["ipcqty"]. "Rate: ".$data["boqrate"]."= ".$amount;
	 // echo "<br/>";
	  $sum=$amount;
	  $i++;
	 }
	
	
 return $sum;
 }
}
function getThisProgressAmount($itemid,$ipcid)
{
	$sum=0;
 if($itemid!=0&&$itemid!=0&&$itemid!='')
 {
	 $sql="Select * from boq where itemid=".$itemid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 while($data=mysql_fetch_array($pamountresult))
	 {
	 $sql2="SELECT * FROM ipcv  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"];
	 $sum=$sum+$amount;
	 }
 return $sum;
 }
}
function LastIPcMonth()
{
$sql="SELECT ipcid FROM ipc where ipcmonth=(select max(ipcmonth) as ipcmonth  from ipc)";
$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
$data=mysql_fetch_array($amountresult);
return $data;
}
$ipciddata=LastIPcMonth();
$ipcid=$ipciddata["ipcid"];
$i=1;
$gtotal=0;
if($actlevel==0)
{
 echo $reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.isentry, a.factor ,a.itemcode ,a.itemname ,a.weight,  b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate) as contract_amount_1, sum(b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate) as contract_amount_2, sum(b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as contract_amount_3, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate+b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate+b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as total_amount FROM boqdata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by a.itemid,a.parentcd";
}
else
{
 $reportquery="SELECT b.itemid, a.parentcd ,a.parentgroup ,a.activitylevel , a.isentry, a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight,  b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate) as contract_amount_1, sum(b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate) as contract_amount_2, sum(b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as contract_amount_3, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate+b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate+b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as total_amount  FROM boqdata a INNER JOIN boq b ON (a.itemid = b.itemid) where a.itemid=$itemid group by b.itemid ";
}
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) 
{
$contract_amount1=0;
$contract_amount2=0;
$contract_amount3=0;
$todate_amount1=0;
$todate_amount2=0;
$todate_amount3=0;
$this_amount1=0;
$this_amount2=0;
$this_amount3=0;
$this_qty=0;

$uptolast_amount1=0;
$uptolast_amount2=0;
$uptolast_amount3=0;
$ipcqty=0;
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
if($reportdata_act['isentry']==0)
{
	
$reportquery_sub="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor , a.isentry,  b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate) as contract_amount_1, sum(b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate) as contract_amount_2, sum(b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as contract_amount_3, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate+b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate+b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as total_amount FROM boqdata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentgroup Like '%".$reportdata_act['parentgroup']."%' group by a.itemid, a.parentcd";
$reportresult_act_sub = mysql_query($reportquery_sub)or die(mysql_error());
while ($reportdata_act_sub = mysql_fetch_array($reportresult_act_sub)) 
{
if($reportdata_act_sub['isentry']==1)
{
$contract_amount1+=$reportdata_act_sub['contract_amount_1'];
$contract_amount2+=$reportdata_act_sub['contract_amount_2'];
$contract_amount3+=$reportdata_act_sub['contract_amount_3'];
$todate_amount1=getProgressAmountD1($reportdata_act_sub['itemid']);
$todate_amount2=getProgressAmountD2($reportdata_act_sub['itemid']);
$todate_amount3=getProgressAmountD3($reportdata_act_sub['itemid']);
/*$todate_amount1+=$reportdata_act_sub['boq_cur_1_rate']*$reportdata_act_sub['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$reportdata_act_sub['boq_cur_2_rate']*$reportdata_act_sub['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$reportdata_act_sub['boq_cur_3_rate']*$reportdata_act_sub['cur_3_exchrate']*$ipcqty;*/
$this_qty=getThisProgressQTY($reportdata_act_sub['boqid'],$ipcid);
$this_amount1+=$this_qty*$reportdata_act_sub['boq_cur_1_rate']*$reportdata_act_sub['cur_1_exchrate'];
$this_amount2+=$this_qty*$reportdata_act_sub['boq_cur_2_rate']*$reportdata_act_sub['cur_2_exchrate'];
$this_amount3+=$this_qty*$reportdata_act_sub['boq_cur_3_rate']*$reportdata_act_sub['cur_3_exchrate'];

}
else
{
$contract_amount1+=$reportdata_act['contract_amount_1'];
$contract_amount2+=$reportdata_act['contract_amount_2'];
$contract_amount3+=$reportdata_act['contract_amount_3'];
$ipcqty=getProgressAmount($reportdata_act_sub['itemid']);
$todate_amount1+=$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate']*$ipcqty;
$this_qty=getThisProgressAmount($reportdata_act_sub['itemid'],$ipcid);
$this_amount1+=$this_qty*$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate'];
$this_amount2+=$this_qty*$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate'];
$this_amount3+=$this_qty*$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate'];
}
}
}
else
{
$contract_amount1+=$reportdata_act['contract_amount_1'];
$contract_amount2+=$reportdata_act['contract_amount_2'];
$contract_amount3+=$reportdata_act['contract_amount_3'];
$ipcqty=getProgressAmount($reportdata_act['itemid']);
$todate_amount1+=$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate']*$ipcqty;
$this_qty=getThisProgressAmount($reportdata_act['itemid'],$ipcid);
$this_amount1+=$this_qty*$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate'];
$this_amount2+=$this_qty*$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate'];
$this_amount3+=$this_qty*$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate'];

}
$uptolast_amount1=$todate_amount1-$this_amount1;
$uptolast_amount2=$todate_amount2-$this_amount2;
$uptolast_amount3=$todate_amount3-$this_amount3;
$grand_last_amount1+=$uptolast_amount1;
$grand_last_amount2+=$uptolast_amount2;
$grand_last_amount3+=$uptolast_amount3;

$grand_this_amount1+=$this_amount1;
$grand_this_amount2+=$this_amount2;
$grand_this_amount3+=$this_amount3;

$grand_total1+=$contract_amount1;
$grand_total2+=$contract_amount2;
$grand_total3+=$contract_amount3;

$total_month_total1+=$todate_amount1;
$total_month_total2+=$todate_amount2;
$total_month_total3+=$todate_amount3;
 $gtotal+=$reportdata_act['total_amount'];

?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
  <td style="text-align:center;border-left:1px #000000 solid;"><?php echo $i++;?></td>
<td style="text-align:center;"><?php echo $reportdata_act['itemcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['itemname']; ?></td>

<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format ($contract_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($contract_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($contract_amount3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format ($uptolast_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($uptolast_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($uptolast_amount3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format ($this_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($this_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($this_amount3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format ($todate_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($todate_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($todate_amount3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  if($contract_amount1!=0 && $todate_amount1!=0)
{
echo number_format((($todate_amount1 / $contract_amount1)*100),2);
}
else
{
echo "0.0";
} ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  if($contract_amount2!=0 && $todate_amount2!=0)
{
echo number_format((($todate_amount2 / $contract_amount2)*100),2);
}
else
{
echo "0.0";
} ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  if($contract_amount3!=0 && $todate_amount3!=0)
{
echo number_format((($todate_amount3 / $contract_amount3)*100),2);
}
else
{
echo "0.0";
} ?></td>
<?php }?>
</tr>

<?php
}
?>
<tr align="right" id="grand_total">
<td style="text-align:right;border-left:1px #000000 solid;" colspan="3"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format($grand_total1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($grand_total2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($grand_total3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format($grand_last_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($grand_last_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($grand_last_amount3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format($grand_this_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($grand_this_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($grand_this_amount3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format($total_month_total1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($total_month_total2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format($total_month_total3,2) ; ?></td>
<?php }?>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  if($total_month_total1!=0&& $gtotal!=0)
{
echo number_format((($total_month_total1/ $gtotal)*100),2);
}
else
{
echo "0.0";
} ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  if($total_month_total2!=0&&$grand_total2!=0)
{
echo number_format((($total_month_total2/$grand_total2)*100),2);
}
else
{
echo "0.0";
} ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  if($total_month_total3!=0&&$grand_total3!=0)
{
echo number_format((($total_month_total3/$grand_total3)*100),2);
}
else
{
echo "0.0";
} ?></td>
<?php }?>

</tr>

</table>

<br/>
<div style="margin-top:40px;float:none">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center"  style="padding-top:40px">
<tr  id="title">
  <td colspan="201" align="center" style="background-color:#000066"><strong><span style="color:#FFF">IPC WISE Progress</span></strong></td>
 </tr>
<tr id="tblHeading">
  <th rowspan="2">Sr. No. </th>
<th rowspan="2">Code</th>
<th rowspan="2">Description </th>
<th colspan="2"> As Per Bid</th>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
    <th colspan="2"><?php echo date('F, Y',strtotime($rows["ipcmonth"]));?> </th>
    <?php
	}?>
<?php }?>
</tr>
<tr id="tblHeading">
 <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Amount</th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Amount</th>
						<?php }?>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
 <?php if($cur_1!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_1; ?>&nbsp;Amount</th>
						<?php }?>
						   <?php if($cur_2!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_2; ?>&nbsp;Amount</th>
						<?php }?>
                           <?php if($cur_3!="")
						  {?>
						 <th style="width:15%;"><?php echo $cur_3; ?>&nbsp;Amount</th>
						<?php }?>
    <?php
	}?>
<?php }?>
</tr>
<?php 

if($actlevel==0)
{
$reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.isentry, a.factor ,a.itemcode ,a.itemname ,a.weight,  b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate , sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate) as contract_amount_1, sum(b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate) as contract_amount_2, sum(b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as contract_amount_3, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate+b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate+b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as total_amount FROM boqdata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by a.itemid,a.parentcd";
}
else
{
$reportquery="SELECT b.itemid, a.parentcd ,a.parentgroup ,a.activitylevel , a.isentry, a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight,  b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate) as contract_amount_1, sum(b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate) as contract_amount_2, sum(b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as contract_amount_3, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate+b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate+b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as total_amount  FROM boqdata a INNER JOIN boq b ON (a.itemid = b.itemid) where a.itemid=$itemid group by b.itemid ";
}
$reportresult_act = mysql_query($reportquery)or die(mysql_error());

while ($reportdata_act = mysql_fetch_array($reportresult_act)) 
{
$contract_amount1=0;
$contract_amount2=0;
$contract_amount3=0;
$todate_amount1=0;
$todate_amount2=0;
$todate_amount3=0;
$this_amount1=0;
$this_amount2=0;
$this_amount3=0;
$this_qty=0;
$uptolast_amount1=0;
$uptolast_amount2=0;
$uptolast_amount3=0;
$ipcqty=0;
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
if($reportdata_act['isentry']==0)
{
$reportquery_sub="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor , a.isentry,  b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate) as contract_amount_1, sum(b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate) as contract_amount_2, sum(b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as contract_amount_3, sum(b.boqqty* b.boq_cur_1_rate*b.cur_1_exchrate+b.boqqty* b.boq_cur_2_rate*b.cur_2_exchrate+b.boqqty* b.boq_cur_3_rate*b.cur_3_exchrate) as total_amount FROM boqdata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentgroup Like '%".$reportdata_act['parentgroup']."%' group by a.itemid, a.parentcd";
$reportresult_act_sub = mysql_query($reportquery_sub)or die(mysql_error());
while ($reportdata_act_sub = mysql_fetch_array($reportresult_act_sub)) 
{
if($reportdata_act_sub['isentry']==1)
{
$contract_amount1+=$reportdata_act_sub['contract_amount_1'];
$contract_amount2+=$reportdata_act_sub['contract_amount_2'];
$contract_amount3+=$reportdata_act_sub['contract_amount_3'];
$ipcqty=getProgressAmountD($reportdata_act_sub['boqid']);
$todate_amount1+=$reportdata_act_sub['boq_cur_1_rate']*$reportdata_act_sub['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$reportdata_act_sub['boq_cur_2_rate']*$reportdata_act_sub['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$reportdata_act_sub['boq_cur_3_rate']*$reportdata_act_sub['cur_3_exchrate']*$ipcqty;
$this_qty=getThisProgressQTY($reportdata_act_sub['boqid'],$ipcid);
$this_amount1+=$this_qty*$reportdata_act_sub['boq_cur_1_rate']*$reportdata_act_sub['cur_1_exchrate'];
$this_amount2+=$this_qty*$reportdata_act_sub['boq_cur_2_rate']*$reportdata_act_sub['cur_2_exchrate'];
$this_amount3+=$this_qty*$reportdata_act_sub['boq_cur_3_rate']*$reportdata_act_sub['cur_3_exchrate'];

}
else
{
$contract_amount1+=$reportdata_act['contract_amount_1'];
$contract_amount2+=$reportdata_act['contract_amount_2'];
$contract_amount3+=$reportdata_act['contract_amount_3'];
$ipcqty=getProgressAmount($reportdata_act_sub['itemid']);
$todate_amount1+=$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate']*$ipcqty;
$this_qty=getThisProgressAmount($reportdata_act_sub['itemid'],$ipcid);
$this_amount1+=$this_qty*$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate'];
$this_amount2+=$this_qty*$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate'];
$this_amount3+=$this_qty*$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate'];
}
}
}
else
{
$contract_amount1+=$reportdata_act['contract_amount_1'];
$contract_amount2+=$reportdata_act['contract_amount_2'];
$contract_amount3+=$reportdata_act['contract_amount_3'];
$ipcqty=getProgressAmount($reportdata_act['itemid']);
$todate_amount1+=$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate']*$ipcqty;
$this_qty=getThisProgressAmount($reportdata_act['itemid'],$ipcid);
$this_amount1+=$this_qty*$reportdata_act['boq_cur_1_rate']*$reportdata_act['cur_1_exchrate'];
$this_amount2+=$this_qty*$reportdata_act['boq_cur_2_rate']*$reportdata_act['cur_2_exchrate'];
$this_amount3+=$this_qty*$reportdata_act['boq_cur_3_rate']*$reportdata_act['cur_3_exchrate'];

}
$uptolast_amount1=$todate_amount1-$this_amount1;
$uptolast_amount2=$todate_amount2-$this_amount2;
$uptolast_amount3=$todate_amount3-$this_amount3;
$grand_last_amount1+=$uptolast_amount1;
$grand_last_amount2+=$uptolast_amount2;
$grand_last_amount3+=$uptolast_amount3;

$grand_this_amount1+=$this_amount1;
$grand_this_amount2+=$this_amount2;
$grand_this_amount3+=$this_amount3;

$grand_total1+=$contract_amount1;
$grand_total2+=$contract_amount2;
$grand_total3+=$contract_amount3;

$total_month_total1+=$todate_amount1;
$total_month_total2+=$todate_amount2;
$total_month_total3+=$todate_amount3;
?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
  <td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;"><?php echo $reportdata_act['itemcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['itemname']; ?></td>
<?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format ($contract_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($contract_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($contract_amount3,2) ; ?></td>
<?php }?>
<?php 
if($reportdata_act['isentry']==0)
{
	//$reportquery_sub="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor , a.isentry, b.boqid,b.boqcode,b.boqitem , b.boqunit  , b.boqqty , b.boqamount , b.boqcurrency ,b.boqcurrrate , b.boqfamount, b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM boqdata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=".$reportdata_act['itemid'];

$reportresult_act_sub = mysql_query($reportquery_sub)or die(mysql_error());
while ($reportdata_act_sub = mysql_fetch_array($reportresult_act_sub)) 
{

if($actlevel==0)
{
$boqid=$reportdata_act_sub['boqid'];
}
}

if($actlevel!=0)
{
$boqid=$reportdata_act['boqid'];	
}

}
else
{
$boqid=$reportdata_act['boqid'];
}
$query_p="SELECT * FROM ipc ";
$queryresult_p = mysql_query($query_p);
$numrows_p=mysql_num_rows($queryresult_p);
///if($numrows_p>0)
//{
	while($rows=mysql_fetch_array($queryresult_p))
	{
$query2="SELECT b.boqid, b.itemid, b.boqcode, b.boqitem, b.boqunit, b.boq_base_currency, b.boqqty, b.boq_cur_1, b.cur_1_exchrate, b.boq_cur_1_rate, b.boq_cur_2, b.cur_2_exchrate, b.boq_cur_2_rate, b.boq_cur_3, b.cur_3_exchrate, b.boq_cur_3_rate, c.ipcid,c.ipcqty FROM boq b LEFT OUTER JOIN ipcv c ON (b.boqid = c.boqid) where b.boqid=".$boqid." AND c.ipcid=".$rows['ipcid'];
$queryresult2 = mysql_query($query2);
$numrows2=mysql_num_rows($queryresult2);
if($numrows2>0)
{
	while($rows2=mysql_fetch_array($queryresult2))
	{

$ipcqty=getProgressAmountIPC($rows2['itemid'],$rows['ipcid']);
$todate_amount1+=$rows2['boq_cur_1_rate']*$rows2['cur_1_exchrate']*$ipcqty;
$todate_amount2+=$rows2['boq_cur_2_rate']*$rows2['cur_2_exchrate']*$ipcqty;
$todate_amount3+=$rows2['boq_cur_3_rate']*$rows2['cur_3_exchrate']*$ipcqty;
?>
 <?php if($cur_1!="") {?>
<td style="text-align:right;"><?php  echo number_format ($todate_amount1,2) ; ?></td>
<?php }?>
<?php if($cur_2!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($todate_amount2,2) ; ?></td>
<?php }?>
<?php if($cur_3!="")
						  {?>
<td style="text-align:right;"><?php  echo number_format ($todate_amount3,2) ; ?></td>
<?php }?>
 <?php $todate_amount=0;
 }
 }
 else
 {
 ?>
  <td align="right">0.00</td>
  <td align="right">0.00</td>
 <?php } ?>
 <?php
 
	}}
?> 
</tr>

<?php
//}
?>


</table>
</div>
<?php }?>