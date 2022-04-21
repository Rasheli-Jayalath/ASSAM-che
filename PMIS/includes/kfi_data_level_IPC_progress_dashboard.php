<?php 
if(isset($data_level_id)&& $data_level_id!=""&&$data_level_id!=0)
{
?>
<div id="result4">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center" >
<tr  id="title">
  <td colspan="19" align="center"></tr>
<tr id="tblHeading">
  <th rowspan="2">Sr. No</th>
<th rowspan="2">Code</th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
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
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
   <th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
    <?php
	}?>
<?php }?>
</tr>
<?php
function getProgressAmountIPC($boqid)
{
	$amount=0;
 if($boqid!=0&&$boqid!='')
 {
    $sql="Select * from boq where boqid=".$boqid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM `ipcv`  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
	 
	 
 return $amount;
 }
}
function getProgressQTYIPC($boqid)
{
	$amount=0;
 if($boqid!=0&&$boqid!='')
 {
    $sql="Select * from boq where boqid=".$boqid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM `ipcv`  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"];
	 
	 
 return $amount;
 }
}
function getThisProgressAmount($boqid,$ipcid)
{
	$amount=0;
    if($boqid!=0&&$boqid!='')
    {
	 $sql="Select * from boq where boqid=".$boqid;
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	 $sql2="SELECT * FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
	
	 }
 return $amount;
 
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
	 $sql2="SELECT * FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"];
	 }
	
	 }
 return $amount;
 
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
 $reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight , b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate  FROM maindata a INNER JOIN boq b ON (a.itemid = b.itemid)
   where a.itemid=$data_level_id";
$i=1;
$grand_total=0;
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
	
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$todate_amount=getProgressAmount($reportdata_act['boqid']);
$todate_qty=getProgressQTY($reportdata_act['boqid']);
$this_qty=getThisProgressQTY($reportdata_act['boqid'],$ipcid);
//$this_amount=getThisProgressAmount($reportdata_act['boqid'],$ipcid);
 $total_amount_act=$reportdata_act['boqqty']*$reportdata_act['boqrate'];

$uptolast_amount=$todate_amount-$this_amount;
$uptolast_qty=$todate_qty-$this_qty;
$grand_last_amount+=$uptolast_amount;
$grand_this_amount+=$this_amount;
$grand_total+=$total_amount_act;
$total_month_total+=$todate_amount;
?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
  <td style="text-align:center;"><?php echo $i++;?></td>
<td style="text-align:center;"><?php echo $reportdata_act['boqcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['boqitem']; ?></td>
<td style="text-align:center;"><?php echo $reportdata_act['boqunit']; ?></td>
<td style="text-align:center;"><?php echo number_format($reportdata_act['boqqty'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format($reportdata_act['boqrate'],2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($reportdata_act['boqqty'] * $reportdata_act['boqrate']),2) ; ?></td>
<?php $query="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight , b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate  FROM maindata a INNER JOIN boq b ON (a.itemid = b.itemid)
   where a.itemid=$data_level_id";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{

$todate_amount=getProgressAmount($rows['boqid']);
$todate_qty=getProgressQTY($rows['boqid']);
?>
   <td><?php echo number_format($total_pqty,2);?></td>
   <td><?php echo number_format($total_ipc_amount,2);?></td> 
 <?php }}?> 


<td style="text-align:right;"><?php  echo number_format (($todate_amount),2) ; ?></td>
<td style="text-align:right;"><?php  if($todate_amount!=0 && $total_amount_act!=0)
{
echo number_format((($todate_amount / $total_amount_act)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>

<?php
}
?>


</table>
</div>
<?php }?>