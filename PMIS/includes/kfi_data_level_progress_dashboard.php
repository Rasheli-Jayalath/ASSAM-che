<?php 
if(isset($data_level_id)&& $data_level_id!=""&&$data_level_id!=0)
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
<div id="result44" style="float:left">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="left" >
<tr  id="title">
  <td colspan="200" align="center" style="background-color:#000066"><strong><span style="color:#FFF">BILL LEVEL</span></strong></td>
 </tr>
<tr id="tblHeading">
  <th rowspan="2">Sr. No</th>
<th rowspan="2">Code</th>
<th rowspan="2">Description </th>
<th rowspan="2"> UOM </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th colspan="3"> As Per Bid</th>
<th colspan="2">Paid Upto  <?php echo $ipcnodatasec["ipcno"];?></th>
<th colspan="2">Paid in <?php echo $ipcnodata["ipcno"];?> </th>
<th colspan="2">Executed Upto <?php echo $ipcnodata["ipcno"];?></th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<!--<th>Qty. (Units) </th>
<th>Rate </th>
<th> Amount</th>-->
<th>Qty. (Units) </th>
<th>Rate (Rs.) </th>
<th>Amount (Rs.) </th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
<th> Qty. (Units)</th>
<th> Amount(Rs.)</th>
</tr>
<?php

function getProgressAmountIPC($boqid,$ipcid)
{
	$amount=0;
 if($boqid!=0&&$boqid!='')
 {
    $sql="Select * from boq where boqid=".$boqid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
	 
	 
 return $amount;
 }
}
function getProgressQTYIPC($boqid,$ipcid)
{
	$amount=0;
 if($boqid!=0&&$boqid!='')
 {
    $sql="Select * from boq where boqid=".$boqid;
	
	 $pamountresult = mysql_query($sql)or die(mysql_error());
	 $data=mysql_fetch_array($pamountresult);
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"];
	 
	 
 return $amount;
 }
}

function getProgressAmount($boqid)
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
function getProgressQTY($boqid)
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
 $reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight , b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate  FROM boqdata a INNER JOIN boq b ON (a.itemid = b.itemid)
   where a.itemid=$data_level_id";
$i=1;
$grand_total=0;
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
	
 $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
$todate_amount=getProgressAmount($reportdata_act['boqid']);
$todate_qty=getProgressQTY($reportdata_act['boqid']);
$this_qty=getThisProgressQTY($reportdata_act['boqid'],$ipcid);
$this_amount=$this_qty*$reportdata_act['boqrate'];
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
<td style="text-align:center;"><?php echo number_format ($uptolast_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format (($uptolast_amount),2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($this_qty,2); ?></td>
<td style="text-align:right;"><?php  echo number_format($this_amount,2) ; ?></td>
<td style="text-align:center;"><?php echo number_format ($todate_qty,2); ?></td>   
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
<tr align="right" id="grand_total">
<td style="text-align:right;" colspan="6"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo  number_format ($grand_last_amount,2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>
<td style="text-align:right;"><?php  echo number_format (($grand_this_amount),2) ; ?></td>
<td style="text-align:center;">&nbsp;</td>   
<td style="text-align:right;"><?php  echo  number_format ($total_month_total,2) ; ?></td>
<td style="text-align:right;"><?php  if($total_month_total!=0&&$grand_total!=0)
{
echo number_format((($total_month_total/$grand_total)*100),2);
}
else
{
echo "0.0";
} ?></td>
</tr>

</table>
</div>
<br/><br/>
<div style="margin-top:20px;float:none">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center"  style="padding-top:40px">
<tr  id="title">
  <td colspan="200" align="center" style="background-color:#000066"><strong><span style="color:#FFF">IPC WISE Progress</span></strong></td>
 </tr>
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
<?php $reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight , b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate  FROM boqdata a INNER JOIN boq b ON (a.itemid = b.itemid)
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
<?php 
$todate_amount=0;
 $todate_qty=0;
$query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{
$query2="
SELECT b.boqid , b.itemid, b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate, c.ipcid,c.ipcqty FROM boq b LEFT OUTER JOIN ipcv c ON (b.boqid = c.boqid) where b.boqid=".$reportdata_act['boqid']." AND c.ipcid=".$rows['ipcid'];
$queryresult2 = mysql_query($query2);
$numrows2=mysql_num_rows($queryresult2);
if($numrows2>0)
{
	while($rows2=mysql_fetch_array($queryresult2))
	{

$todate_amount=getProgressAmountIPC($rows2['boqid'],$rows['ipcid']);
$todate_qty=getProgressQTYIPC($rows2['boqid'],$rows['ipcid']);
?>
   <td align="right"><?php echo number_format($todate_qty,2);?></td>
   <td align="right"><?php echo number_format($todate_amount,2);?></td> 
 <?php 
 $todate_amount=0;
 $todate_qty=0;
 }}
 else
 {
 ?>
  <td>&nbsp;</td>
   <td>&nbsp;</td> 
 <?php } ?>
 <?php
 
	}}?> 
</tr>

<?php
}
?>


</table>
</div>
<?php }?>