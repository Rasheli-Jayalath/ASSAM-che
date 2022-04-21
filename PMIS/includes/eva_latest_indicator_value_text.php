<div id="result1">
<div style="clear:both" ></div><div style="clear:both" ></div><div style="clear:both" ></div>
<br/>
<table  cellpadding="5px" cellspacing="0px"   width="90%" align="center"  id="tblList" style="border-left:1px #000000 solid;;margin-left:5px;margin-right:5px">
<tr bgcolor="000066" style="color:#FFF">
 
  <td  colspan="3" align="left" style="font-size:12px"><strong><?php   
  	//$start_forecast="2013-10-01";
	//$end_forecast="2015-10-01";
	$mi=date('m',strtotime($last));
	$yi=date('Y',strtotime($last));
	$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
	
	$last_date=$yi."-".$mi."-".$days;
		echo "Indicators as on ".date('M, d, Y',strtotime($last_date));
	?></strong></td>
</tr>

<tr>

  <th >Indicator</th>
  <th >Value</th>
  </tr>
<?php 
//$a_leb_down='<label style="color:#FF0000; font-size:30px; width:50px">&#11015;</label>';
//$a_leb_red_up='<label style="color:#FF0000; font-size:30px; width:50px">&#11014;</label>';
//$d_leb='<label style="color:#0F3; font-size:25px">&#9670;</label>';
//$a_leb_up='<label style="color:#0F3; font-size:25px; width:50px">&#11014;</label>';
//$a_leb_green_down='<label style="color:#0F3; font-size:30px; width:50px">&#11015;</label>';
$a_leb_up='<img src="images/green-up.png"  width="15" height="15"/>';
$a_leb_down='<img src="images/red-down.png"  width="15" height="15"/>';
$d_leb='<img src="images/diamond.png"  width="15" height="15"/>';
$a_leb_red_up='<img src="images/red-up.png"  width="15" height="15"/>';
$a_leb_green_down='<img src="images/green-down.png"  width="15" height="15"/>';

$i=1;
$bac_ev=0;
$RParameter = array("PV"=>"Planned Value", "EV"=>"Earned Value", "AC"=>"Actual Cost","BAC"=>"Budget at Completion", "CV"=>"Cost Variance", "SV"=>"Schedule Variance", "CPI"=>"Cost Performance Index","SPI"=>"Schedule Performance Index", "EAC-2"=>"Estimate at Completion Case-2","ETC-2"=>"Estimate to Completion","TCPI-1"=>"To Complete Performance Index - Case-1");
foreach($RParameter as $title =>$value) {
	
  //  echo "Key=" . $title . ", Value=" . $value;
$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF"; ?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<?php 


?>

<td style="text-align:left;"><strong><?php echo $title;?></strong></td>
<td style="text-align:left;"><?php echo $value;?></td>
<?php


?>
</tr>
<?php }?>
</table>

</div>