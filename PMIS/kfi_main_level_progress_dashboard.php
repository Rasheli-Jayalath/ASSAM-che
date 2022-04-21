<?php 
if(isset($_REQUEST["obj"])&&$_REQUEST["obj"])
{
	$itemid=$_REQUEST["obj"];
}
else
{
$itemid=$data_level_idf;
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
<div id="result4">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="48%" align="left" >
<tr  id="title">
  <td colspan="13" align="center"></tr>
<tr id="tblHeading">
  <th rowspan="2">Sr. No. </th>
<th rowspan="2"> Code </th>
<th rowspan="2">Description </th>
<!--<th colspan="3">As Per Estimate</th>-->
<th> As Per Bid</th>
<th>Paid Upto <?php echo $ipcnodatasec["ipcno"];?></th>
<th>Paid in <?php echo $ipcnodata["ipcno"];?> </th>
<th>Executed Upto <?php echo $ipcnodata["ipcno"];?> </th>
<th rowspan="2"> % in Progress</th>
</tr>
<tr id="tblHeading">
<th>Amount (Rs.) </th>
<th> Amount(Rs.)</th>
<th> Amount(Rs.)</th>
<th> Amount(Rs.)</th>
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
	
	 $sql2="SELECT sum(ipcqty) as ipcqty FROM `ipcv`  WHERE boqid=".$data["boqid"]." GROUP BY boqid";
	 
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
	 
	 
 return $amount;
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
	 $sql2="SELECT * FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
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
	  $amount +=$pdata["ipcqty"]*$data["boqrate"];
	  
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
	  $amount +=$pdata["ipcqty"]*$data["boqrate"];
	  
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
	 $sql2="SELECT * FROM `ipcv`  WHERE boqid=".$data["boqid"]." AND ipcid=".$ipcid." GROUP BY boqid";
	 $pamountresult3 = mysql_query($sql2)or die(mysql_error());
	 $pdata=mysql_fetch_array($pamountresult3);
	 $amount=$pdata["ipcqty"]*$data["boqrate"];
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
/*echo $reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty ,sum(b.boqqty* b.boqrate) as total_amount, b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by b.itemid";*/
if($actlevel==0)
{
$reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.isentry, a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid ";
}
else
{
 
$reportquery="SELECT b.itemid, a.parentcd ,a.parentgroup ,a.activitylevel , a.isentry, a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty ,sum(b.boqqty* b.boqrate) as total_amount, b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a INNER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by b.itemid ";
}
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) 
{
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
if($reportdata_act['isentry']==0)
{
$contract_amount=0;
$todate_amount=0;
$this_amount=0;
$uptolast_amount=0;
$reportquery_sub="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor , a.isentry, b.boqid,b.boqcode,b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency ,b.boqcurrrate , b.boqfamount, b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=".$reportdata_act['itemid'];

$reportresult_act_sub = mysql_query($reportquery_sub)or die(mysql_error());
while ($reportdata_act_sub = mysql_fetch_array($reportresult_act_sub)) 
{
if($reportdata_act_sub['isentry']==1)
{
$contract_amount+=$reportdata_act_sub['boqrate']*$reportdata_act_sub['boqqty'];
$todate_amount+=getProgressAmountD($reportdata_act_sub['boqid']);
$this_qty=getThisProgressQTY($reportdata_act_sub['boqid'],$ipcid);
$this_amount+=$this_qty*$reportdata_act_sub['boqrate'];

}
else
{
$contract_amount=$reportdata_act['boqrate']*$reportdata_act['boqqty'];
$todate_amount=getProgressAmount($reportdata_act_sub['itemid']);
$this_amount=getThisProgressAmount($reportdata_act_sub['itemid'],$ipcid);
}
}
}
else
{
$contract_amount=$reportdata_act['boqrate']*$reportdata_act['boqqty'];
$todate_amount=getProgressAmount($reportdata_act['itemid']);
$this_amount=getThisProgressAmount($reportdata_act['itemid'],$ipcid);

}
$uptolast_amount=$todate_amount-$this_amount;
$grand_last_amount+=$uptolast_amount;
$grand_this_amount+=$this_amount;
$grand_total+=$contract_amount;
$total_month_total+=$todate_amount;
?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
  <td style="text-align:center;"><?php echo $i++;?></td>
<td style="text-align:center;"><?php echo $reportdata_act['itemcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['itemname']; ?></td>
<td style="text-align:right;"><?php  echo number_format (($contract_amount),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($uptolast_amount),2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format($this_amount,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($todate_amount),2) ; ?></td>
<td style="text-align:right;"><?php  if($contract_amount!=0 && $todate_amount!=0)
{
echo number_format((($todate_amount / $contract_amount)*100),2);
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
<td style="text-align:right;" colspan="3"><strong><?php echo  "Grand Total:"; ?></strong></td>
<?php /*?><td style="text-align:center;"><?php echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;">&nbsp;</td>
<td style="text-align:right;">&nbsp;</td><?php */?>
<td style="text-align:right;"><?php  
echo number_format ($grand_total,2); ?></td>
<td style="text-align:right;"><?php  echo  number_format ($grand_last_amount,2) ; ?></td>
<td style="text-align:right;"><?php  echo number_format (($grand_this_amount),2) ; ?></td>
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



<div style="margin-top:20px;float:none">
<table id="tblList" cellpadding="0px" cellspacing="0px"   width="98%" align="center"  style="padding-top:40px">
<tr  id="title">
  <td colspan="201" align="center" style="background-color:#000066"><strong><span style="color:#FFF">IPC WISE Progress</span></strong></td>
 </tr>
<tr id="tblHeading">
  <th rowspan="2">Sr. No. </th>
<th rowspan="2">Code</th>
<th rowspan="2">Description </th>
<th> As Per Bid</th>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
    <th colspan="1"><?php echo date('F, Y',strtotime($rows["ipcmonth"]));?> </th>
    <?php
	}?>
<?php }?>
</tr>
<tr id="tblHeading">
<th>Amount (Rs.) </th>
<?php $query="SELECT * FROM ipc ";
$queryresult = mysql_query($query);
$numrows=mysql_num_rows($queryresult);
if($numrows>0)
{
	while($rows=mysql_fetch_array($queryresult))
	{?>
<th>Amount (Rs.) </th>
    <?php
	}?>
<?php }?>
</tr>
<?php 

if($actlevel==0)
{
 $reportquery="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.isentry, a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid ";
}
else
{
 
$reportquery="SELECT b.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor ,a.itemcode ,a.itemname ,a.weight, b.boqid , b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty ,sum(b.boqqty* b.boqrate) as total_amount, b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a INNER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=$itemid group by b.itemid";
}
$reportresult_act = mysql_query($reportquery)or die(mysql_error());
while ($reportdata_act = mysql_fetch_array($reportresult_act)) 
{
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
if($reportdata_act['isentry']==0)
{
$contract_amount=0;
$todate_amount=0;
$this_amount=0;
$uptolast_amount=0;
$reportquery_sub="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor , a.isentry, b.boqid,b.boqcode,b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency ,b.boqcurrrate , b.boqfamount, b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=".$reportdata_act['itemid'];

$reportresult_act_sub = mysql_query($reportquery_sub)or die(mysql_error());
while ($reportdata_act_sub = mysql_fetch_array($reportresult_act_sub)) 
{
if($reportdata_act_sub['isentry']==1)
{
$contract_amount+=$reportdata_act_sub['boqrate']*$reportdata_act_sub['boqqty'];
$todate_amount+=getProgressAmountD($reportdata_act_sub['boqid']);
$this_qty=getThisProgressQTY($reportdata_act_sub['boqid'],$ipcid);
$this_amount+=$this_qty*$reportdata_act_sub['boqrate'];

}
else
{
$contract_amount=$reportdata_act['boqrate']*$reportdata_act['boqqty'];
$todate_amount=getProgressAmount($reportdata_act_sub['itemid']);
$this_amount=getThisProgressAmount($reportdata_act_sub['itemid'],$ipcid);
}
}
}
else
{
$contract_amount=$reportdata_act['boqrate']*$reportdata_act['boqqty'];
$todate_amount=getProgressAmount($reportdata_act['itemid']);
$this_amount=getThisProgressAmount($reportdata_act['itemid'],$ipcid);

}
$uptolast_amount=$todate_amount-$this_amount;
$grand_last_amount+=$uptolast_amount;
$grand_this_amount+=$this_amount;
$grand_total+=$contract_amount;
$total_month_total+=$todate_amount;
?>
<?php ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
  <td style="text-align:center;">&nbsp;</td>
<td style="text-align:center;"><?php echo $reportdata_act['itemcode']; ?></td>
<td style="text-align:left;"><?php   echo $reportdata_act['itemname']; ?></td>
<td style="text-align:right;"><?php  echo number_format (($contract_amount),2) ; ?></td>
<?php 
if($reportdata_act['isentry']==0)
{
	$reportquery_sub="SELECT a.itemid, a.parentcd ,a.parentgroup ,a.activitylevel ,a.stage ,a.factor , a.isentry, b.boqid,b.boqcode,b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency ,b.boqcurrrate , b.boqfamount, b.boqfcurrency , b.boqfrate , b.boqfcurrate FROM maindata a LEFT OUTER JOIN boq b ON (a.itemid = b.itemid) where a.parentcd=".$reportdata_act['itemid'];

$reportresult_act_sub = mysql_query($reportquery_sub)or die(mysql_error());
while ($reportdata_act_sub = mysql_fetch_array($reportresult_act_sub)) 
{
if($reportdata_act_sub['isentry']==1)
{
$contract_amount+=$reportdata_act_sub['boqrate']*$reportdata_act_sub['boqqty'];
$todate_amount+=getProgressAmountD($reportdata_act_sub['boqid']);
$this_qty=getThisProgressQTY($reportdata_act_sub['boqid'],$ipcid);
$this_amount+=$this_qty*$reportdata_act_sub['boqrate'];

}
else
{
$contract_amount=$reportdata_act['boqrate']*$reportdata_act['boqqty'];
$todate_amount=getProgressAmount($reportdata_act_sub['itemid']);
$this_amount=getThisProgressAmount($reportdata_act_sub['itemid'],$ipcid);
}
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
$query2="
SELECT b.boqid , b.itemid, b.boqcode , b.boqitem , b.boqunit , b.boqrate , b.boqqty , b.boqamount , b.boqcurrency , b.boqcurrrate , b.boqfamount , b.boqfcurrency , b.boqfrate , b.boqfcurrate, c.ipcid,c.ipcqty FROM boq b LEFT OUTER JOIN ipcv c ON (b.boqid = c.boqid) where b.boqid=".$boqid." AND c.ipcid=".$rows['ipcid'];
$queryresult2 = mysql_query($query2);
$numrows2=mysql_num_rows($queryresult2);
if($numrows2>0)
{
	while($rows2=mysql_fetch_array($queryresult2))
	{

$todate_amount=getProgressAmountIPC($rows2['itemid'],$rows['ipcid']);
?>
   <td align="right"><?php echo number_format($todate_amount,2);?></td> 
 <?php $todate_amount=0;}}
 else
 {
 ?>
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