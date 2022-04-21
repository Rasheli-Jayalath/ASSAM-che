<?php 
if($adata["isentry"]==0&& isset($_REQUEST["outcome"]) && $_REQUEST["outcome"]!=0 && $_REQUEST["outcome"]==$data_level_id && $data_level_param ==
"outcome")
{?>

<div style="clear:both" ></div><div style="clear:both" ></div>
<table  cellpadding="0px" cellspacing="0px"   width="100%" align="center"  id="tblList" style="border-left:1px #000000 solid;">
<tr bgcolor="000066" style="color:#FFF">
<td colspan="17" align="left" style="font-size:14px"><strong><?php   echo  $adetail;?></strong></td>
</tr>
<tr>
  <th width="17" height="37" rowspan="2">#</th>
  <th width="58" rowspan="2">Code</th>
  <th width="139" rowspan="2">Activity</th>
  <th width="60" rowspan="2">Weight</th>
  <th width="60" rowspan="2">Indicator</th>
  <th colspan="2">Planned</th>
  <th width="53" rowspan="2">Upto Date</th>
  <th width="57" rowspan="2">Planned Days</th>
  <th width="53" rowspan="2">Days Elapsed</th>
  <th width="39" rowspan="2">Total Work</th>
  <th width="57" rowspan="2">Planned Work</th>
  <th width="47" rowspan="2">Actual Work</th>
  <th width="71" rowspan="2" title="Difference">&#916;</th>
  <th width="66" rowspan="2"> Required  Rate</th>
  <th width="75" rowspan="2">Projected Date</th>
  <th width="63" rowspan="2">Progress</th>
  <!--  <th width="110">Contract Amount</th> -->  
</tr>
<tr>
  <th width="85">Start</th>
  <th width="91">Finish</th>
  </tr>

<?php 
$average_progress=0;
$total_work_done=0;
$grand_total=0;
$pgrand_total=0;
$total_amount=0;
$i=0;
$today_qty=0;
$till_today_qty=0;
$work_done=0;
$p_work_done=0;
$numberDaysRemaining=0;
$timeDelayedDiff=0;
$numberDaysDelayed=0;
$start_date="";
$end_date="";
$difference=0;
$remaining=0;
$require_daily_rate=0;
$average_rate=0;
$projected_date="";
$totalNumberDays=0;
$actualEndTimeStamp =0;
$actualStartTimeStamp=0;
$actTimeDiff =0;
$ActualnumberDays = 0;
$days_remaining=0;
$current_daily_rate=0;
$count=0;
$case=0;
$tolerance=0.1;
$timeRemainingDiff=0;
$next_level_id=0;
?>
<?php if($data_level_id!=0&&$data_level_id!=""&&$data_level_param =="outcome")
		{
			
	$reportquery_act ="SELECT * from maindata where parentcd=".$data_level_id;
	$reportresult_act = mysql_query($reportquery_act);
	while ($reportdata_act = mysql_fetch_array($reportresult_act)) {
		
		$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
		$i++;
		$parent_group=$reportdata_act["parentgroup"];
		$act_name=$reportdata_act["itemname"];
	    $act_code=$reportdata_act["itemcode"];
		$act_weight=$reportdata_act["weight"];
		$wgt_query="select sum(weight) as weight  from maindata where parentcd=".$reportdata_act["itemid"];
		$wqtresult = mysql_query($wgt_query);
		$wgtdata= mysql_fetch_array($wqtresult);
		$w_eight=$wgtdata["weight"];
		if($reportdata_act["isentry"]==1)
		{
			////GetBaseLevel();	
		}
		else
		{
			$average_rate=0;
		    $projected_days=0;
		    $projected_date='';
		   // $next_level_id=GetNextLevel($reportdata_act["itemid"]);
			 $reportquery ="select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$reportdata_act["parentgroup"]."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
			//echo "<br/>";
	        $reportresult = mysql_query($reportquery);
			$reportdata = mysql_fetch_array($reportresult);
			
			 $numberDays=CalculateActualPlannedDays($reportdata['enddate'],$reportdata['startdate']);
			 $last_date=GetlastDateOutput($reportdata_act["parentgroup"]);
			 $current_date_c=$last_date;
			 $currentTimeStamp=strtotime($last_date);
			 if($current_date_c>$reportdata['enddate'])
			 {
				 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
				  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
				  $numberDaysDelayed = intval($numberDaysDelayed);
			 }
			 $till_today_qty=ActualProgressOutput($reportdata_act["parentgroup"]);
			 $planned_progress=PlannedProgressOutput($reportdata_act["parentgroup"],$current_date_c,$reportdata['startdate']);
			  if($reportdata['baseline']!=0)
			{
			//$work_done=$till_today_qty/$reportdata['baseline']*100;
			$work_done=$till_today_qty*$act_weight/100;
			$total_work_done +=$work_done;
			}
			else
			{
			$work_done=0;
			}
			if($planned_progress!=0)
			{
			$difference=$planned_progress-$till_today_qty;
			}
			else
			{
			$difference=0;
			}
			if($reportdata["baseline"]!=0)
			{
			$remaining=$reportdata["baseline"]-$till_today_qty;
			}
			else
			{
			$remaining=0;
			}
			$tolerance_check=$reportdata["baseline"]*$tolerance/100;
			if($remaining<0)
			{
				
				if(abs($remaining)<=$tolerance_check)
				{
					$remaining=0;
					
				}
				
			}
			if($current_date_c>$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
			{
			$case=1;
			$actual_finish_date=$current_date_c;
			}
			elseif($current_date_c>$reportdata["enddate"]&& $remaining==0 && $till_today_qty!=0)
			{
			$case=2;
			$actual_finish_date=ActualFinishDateActivity($next_level_id);
			}
			elseif($current_date_c<$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
			{
			$case=3;
			$actual_finish_date=$current_date_c;
			}
			elseif($current_date_c<$reportdata["enddate"]&&$remaining==0&&$till_today_qty!=0)
			{
			$case=4;
			$actual_finish_date=ActualFinishDateActivity($next_level_id);
			}
			elseif($remaining<0&&$till_today_qty!=0)
			{
			
			$case=5;
			$actual_finish_date=ActualFinishDateActivity($next_level_id);
			}
			elseif($till_today_qty==0)
			{
			
			$case=6;
			$actual_finish_date=$current_date_c;
			}
			else
			{
				$case=0;
				
				$actual_finish_date="";
			}
			if($actual_finish_date>$reportdata['startdate'])
			 {
			 $numberDaysElapsed  =CalculateElapsedDays($actual_finish_date,$reportdata['startdate']);
				
			  if($numberDays!=0)
			  {
				  
			  $time_elapsed_percent=($numberDaysElapsed/$numberDays)*100;
			  }
			  else
			  {
				  $time_elapsed_percent=0;
				   $numberDaysElapsed=0;
				 }
			 }
			 else
			 {
				 $time_elapsed_percent=0;
				 $numberDaysElapsed=0;
			}
				//////////////////// Remaining days
				if($actual_finish_date!=""&&$reportdata["enddate"]>=$actual_finish_date&& $remaining>0)
				 {
					
					  $timeRemainingDiff= abs($endTimeStamp - $ActualEndTimeStamp);
					  $numberDaysRemaining = ceil($timeRemainingDiff/86400);
					  $numberDaysRemaining = intval($numberDaysRemaining);
				 }
				 
				 //  Current Daily rate
				 
				 if($ActualnumberDays!=0&&$remaining!=0)
				 {
					 $current_daily_rate=$till_today_qty/$ActualnumberDays;
				 }
				 else
				 {
					 $current_daily_rate=0;
				 }
				if($numberDaysRemaining!=0&&$remaining!=0)
				{
				 $require_daily_rate=($remaining)/$numberDaysRemaining;
				}
				else
				{
				$require_daily_rate=0;
				//$bgcolor='#FF0';
				}
				if($current_daily_rate!=0&&$remaining>0)
				{
				$projected_days=$remaining/($current_daily_rate);
				}
				
				$projected_days=intval($projected_days);
				if($projected_days!=0)
				{
				$projected_date=date("Y-m-d", strtotime($actual_finish_date. "+".$projected_days." days" ));
				}
				else
				{
				$projected_date="";
				}
				$count++;
				
			 if($totalNumberDays!=0&&$totalNumberDays!="")
			 {
				$weight=($numberDays/$totalNumberDays);
			 }
			 else
			 {
				 $weight=0;
			 }
		}
		
	?>
  <tr style="background-color:<?php echo $bgcolor;?>; ">
<td height="20" style="text-align:center;"><?php echo $i;?></td>
<td style="text-align:left;"><span style="text-align:center;"><?php echo $act_code;?></span></td>
<td style="text-align:center;"><span style="text-align:left;"><?php echo $act_name;?></span></td>
<td style="text-align:center;"><?php echo $act_weight;?></td>
<td style="text-align:center;"><?php 
if($case==1)
									echo '<img src="images/indicators/red.png" width="25px" title="Delayed Against Schedule">';
								    elseif($case==2)
									echo '<img src="images/indicators/green.png" width="25px" title="Completed">';
									elseif($case==3)
									echo '<img src="images/indicators/yellow.png" width="25px" title="Continued">';
									elseif($case==4)
									echo '<img src="images/indicators/green.png" width="25px" title="Completed">';
									elseif($case==5)
									echo '<img src="images/indicators/pink.png" width="25px" title="Indicator for Quantity Overuse" >';
									elseif($case==6)
									echo '<img src="images/indicators/blue.png" width="25px" title="Not yet Started" >';
									?></td>
<td style="text-align:right;"><?php 
if(isset($reportdata["startdate"])&&$reportdata["startdate"]!=""&&$reportdata["startdate"]!="1970-01-01"&&$reportdata["startdate"]!="0000-00-00")
  	{
		echo date('d-m-Y',strtotime($reportdata["startdate"]));
		
	}
	else
	{
	echo "-";}?></td>
<td style="text-align:right;"><?php 
if(isset($reportdata["enddate"])&&$reportdata["enddate"]!=""&&$reportdata["enddate"]!="1970-01-01"&&$reportdata["enddate"]!="0000-00-00")
  	{
		echo date('d-m-Y',strtotime($reportdata["enddate"]));
		
		
	}
	else
	{
	echo "-";}?></td>
<td style="text-align:right;"><?php 
if(isset($actual_finish_date)&&$actual_finish_date!=""&&$actual_finish_date!="1970-01-31"&&$actual_finish_date!="0000-00-00")
  	{
		echo date('d-m-Y',strtotime($actual_finish_date));
		
		
	}
	else
	{
	echo "-";}?></td>
<td style="text-align:right;"><?php echo $numberDays;?></td>
<td style="text-align:right;"><?php echo $numberDaysElapsed;?></td>
<td style="text-align:right;"><?php echo number_format(($w_eight),2);?></td>
<td style="text-align:right;"><?php echo number_format($planned_progress,0);?></td>
<td style="text-align:right;"><?php echo number_format($till_today_qty,0);?></td>
<td style="text-align:right;"><?php echo number_format(($difference),0);?></td>
<td style="text-align:right;"><?php echo number_format(($require_daily_rate),0);?></td>
<td style="text-align:right;"><?php if($projected_date!=""&&$projected_date!="1970-01-01"&&$projected_date!="0000-00-00")
									echo date('d-m-Y',strtotime($projected_date));?></td>
<td style="text-align:right;"><?php echo number_format($work_done,2) ." %";?></td>
</tr>
<?php

	} // end inner loop
	
?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;" colspan="14">
<span >Completed:</span>
<img src="images/indicators/green.png" width="25px" title="Completed" style="vertical-align:middle">&nbsp;&nbsp;
<span s >Delayed Against Schedule:</span>
<img src="images/indicators/red.png" width="25px" title="Delayed Against Schedule" style="vertical-align:middle">&nbsp;&nbsp;
<span style="vertical-align:middle" >Continued:</span>
<img src="images/indicators/yellow.png" width="25px" title="Continued" style="vertical-align:middle">&nbsp;&nbsp;
<span style="vertical-align:middle" >Indicator for Quantity Overuse:</span>
<img src="images/indicators/pink.png" width="25px" title="Indicator for Quantity Overuse"  style="vertical-align:middle">&nbsp;&nbsp;
<span style="vertical-align:middle" >Not yet Started:</span>
<img src="images/indicators/blue.png" width="25px" title="Not yet Started" style="vertical-align:middle" >&nbsp;&nbsp;
</td>
<td height="20" style="text-align:right;" colspan="2"><strong>Progress:</strong></td>

<td style="text-align:right;" colspan="1"><strong><?php echo number_format($total_work_done,2) ." %";?></strong></td>
</tr>
<?php 
  
			
			}  // end if condition  ?>
            
            
</table>


<?php
$actual_finish_date="";
$case=0;
$numberDaysRemaining=0;

?>
<?php }?>





