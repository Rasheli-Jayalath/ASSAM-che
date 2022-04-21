<div id="result1">
<div style="clear:both" ></div>
<?php $month=date('m',strtotime($end));
	$year=date('Y',strtotime($end));
	$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
	$end_date=$days."-".$month."-".$year;
	$end_date=date('d-M-Y',strtotime($end_date));?>
<table  cellpadding="5px" cellspacing="0px"   width="100%" align="center"  id="tblList" style="border-left:1px #000000 solid;margin-left:10px">
<tr bgcolor="000066" style="color:#FFF">
 <?php $coulmns="";
  $coulmns=GetForecastingMonthsCount($start,$end);?>
  <td  colspan="<?php echo $coulmns+1;?>" align="left" style="font-size:14px"><strong><?php   
  	//$start_forecast="2013-10-01";
	//$end_forecast="2015-10-01";
		echo "Monthly Indicators ( From ".date('d-M-Y',strtotime($start))." To ". date('d-M-Y',strtotime($end_date))." )";
	?></strong></td>
</tr>
<tr>
<th style="width:50px">&nbsp;

</th>
 <?php echo GetForecastingMonths($start,$end);?>
</tr>
<!--<tr>
  <th>#</th>
  <th >Month</th>
  <th >EAC-2</th>
  <th >ETC-2</th>
  <th >TCPI-1</th>
 
</tr>-->
<?php 
$RParameter = array("PV"=>"pv", "EV"=>"ev", "AC"=>"ac","BAC"=>"bac", "CV"=>"cv", "SV"=>"sv", "CPI"=>"cpi","SPI"=>"spi");

foreach($RParameter as $title =>$value) {
  //  echo "Key=" . $title . ", Value=" . $value;
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF"; ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:left; width:50px"><strong><?php echo $title?></strong></td>
<?php 
$i=1;
$reportresult=GetMonthlyIndicators($start,$end);
if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				if($num>=1)
				{
while ($reportdata = mysql_fetch_array($reportresult)) {
	//$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
?>
<td style="text-align:right;"><?php echo number_format($reportdata[$value],2);?></td>
    <?php

} }
?>
</tr>
<?php }?>
</table>

</div>