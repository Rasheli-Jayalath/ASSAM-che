<?php 
if($adata["isentry"]==1)
{
?>
<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding:0; margin:0;"> 
<tr> 
<td align="left" valign="top" width="50%" >
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
$reportquery ="SELECT * FROM activity where itemid=".$data_level_id." order by  itemid ASC";
	$reportresult = mysql_query($reportquery);			
while ($reportdata = mysql_fetch_array($reportresult)) {
	$i++;
					  $average_rate=0;
					  $projected_days=0;
					  $projected_date='';
					  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
					  $last_date=GetlastDate($data_level_id);
					  $actual_start_date=ActualStartDate($data_level_id);
					  $start_date=$reportdata['startdate'];
					  $endTimeStamp =strtotime($reportdata['enddate']);
					  $startTimeStamp=strtotime($reportdata['startdate']);
					  $current_date_c=$last_date;
					  $currentTimeStamp=strtotime($last_date);
					 $numberDays=CalculateActualPlannedDays($reportdata['enddate'],$reportdata['startdate']);
					 /* $timeDiff = abs($endTimeStamp - $startTimeStamp);
					  $numberDays = ceil($timeDiff/86400);
					  $numberDays = intval($numberDays);*/
 
						if($current_date_c>$reportdata['enddate'])
						 {
							 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
							  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
							  $numberDaysDelayed = intval($numberDaysDelayed);
						 }
 
						  $today_qty=TodayProgress($reportdata['itemid'], $current_date_c);
						  $till_today_qty=ActualProgress($reportdata['itemid']);
						  
					  

	if($reportdata['baseline']!=0)
	{
	$work_done=$till_today_qty/$reportdata['baseline']*100;
	$total_work_done +=$work_done;
	}
	else
	{
	$work_done=0;
	}
	
	if($reportdata["baseline"]!=0)
	{
	$remaining=$reportdata["baseline"]-$till_today_qty;
	}
	else
	{
	$remaining=0;
	}
	/// Check for Actual Finish Date & Indicator
	
	//$current_date_c=date('Y-m-d');
	
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
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
	}
	elseif($current_date_c<$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
	{
	$case=3;
    $actual_finish_date=$current_date_c;
	}
	elseif($current_date_c<$reportdata["enddate"]&&$remaining==0&&$till_today_qty!=0)
	{
	$case=4;
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
	}
	elseif($remaining<0&&$till_today_qty!=0)
	{
	
	$case=5;
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
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
	
	/////////////////// Actual Days
	
	//echo $actual_finish_date;
	$ActualEndTimeStamp =strtotime($actual_finish_date);

  $ActualnumberDays=ActualDays($actual_start_date,$actual_finish_date,$reportdata['itemid']);
  
	if($actual_finish_date>$reportdata['startdate'])
 {
	 /*if($actual_finish_date>=$reportdata['end_date'])
	 {
		 $numberDaysElapsed=$numberDays;
	 }
	 else
	 {*/
	  $numberDaysElapsed  =CalculateElapsedDays($actual_finish_date,$reportdata['startdate']);
	 /* $timeElapsedDiff= abs($ActualEndTimeStamp - $startTimeStamp);
	  $numberDaysElapsed = ceil($timeElapsedDiff/86400);
	  $numberDaysElapsed = intval($numberDaysElapsed);*/
	 //}
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
		 //$numberDaysRemaining=$numberDays-$numberDaysElapsed;
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
	//echo $totalNumberDays;
	 $planned_progress=PlannedProgress($reportdata['itemid'],$current_date_c,$reportdata['startdate']);
	 if($planned_progress!=0)
	{
	$difference=$planned_progress-$till_today_qty;
	}
	else
	{
	$difference=0;
	}
	 if($totalNumberDays!=0&&$totalNumberDays!="")
	 {
		$weight=($numberDays/$totalNumberDays);
	 }
	 else
	 {
		 $weight=0;
	 }
?>

<?php
$numberDaysDelayed=0;
$projected_date="";
}
//echo GetPlannedQtysNew($activityid,$subactivityid);
?> 
        
        <script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<?php echo $adetail;?>'
            },
            subtitle: {
                text: '<?php echo "Progress To-Date ".date('d-m-Y',strtotime($current_date_c));?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                     month: '%m-%Y',
                	 year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '% Done'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' <?php echo $unit;?>';
                }
            },
            legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 50,
            floating: true/*,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
        },
            series: [
		{
                name: '<?php echo trim(stripslashes($reportdata['sdetail']));
				echo "Actual Progress";?>',
                
                data: [
				<?php echo GetProgressQtysDataLevel($data_level_id);?>
                    
                   
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned',
                data: [
				<?php echo GetPlannedQtysDataLevel($data_level_id,$current_date_c,$start_date);?>
                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			,
			{ name: 'Total Quantity: <?php echo $total_qty." ".$unit;?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
			,
			{ name: 'Completed Quantity: <?php echo round($till_today_qty)." ".$unit;;?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
			,
			{ name: 'Average Per Day: <?php echo round($current_daily_rate)." ".$unit;;?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Required Rate Per Day: <?php echo round($require_daily_rate)." ".$unit;;?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Projected Completion Date with Current Rate: <?php if($projected_date!=""&& $projected_date!="1997-01-01" && $projected_date!="0000-00-00") 
			{
				echo date('d-M-Y',strtotime($projected_date));
			}?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }},
				{ name: 'Planned Completion Date: <?php if($end_date!=""&& $end_date!="1997-01-01" && $end_date!="0000-00-00") 
			{
				echo date('d-M-Y',strtotime($end_date));
			}?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
			
			]
        });
    });
    

		</script>
        <table width="100%"  align="left" border="0" style="margin:0">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
<div style="clear:both" ></div><div style="clear:both" ></div>

<table  cellpadding="0px" cellspacing="0px"   width="100%" align="center"  id="tblList" 
style="border-left:1px #000000 solid;">

<tr bgcolor="000066" style="color:#FFF">
  <td colspan="20" align="left" style="font-size:14px"><strong><?php   echo  $adetail;?></strong></td>
</tr>
<tr>
  <th width="17" height="37" rowspan="2">#</th>
  <th width="145" rowspan="2">Activity</th>
  <th width="15" rowspan="2">Indicator</th>
  <th width="15" rowspan="2">Unit</th>
  <th colspan="2">Planned</th>
  <th width="53" colspan="2" rowspan="2">Upto Date</th>
  <th width="53" rowspan="2">Planned Days</th>
  <!--<th width="53" rowspan="2">Actual Days</th>-->
  <th width="53" rowspan="2">Days Elapsed</th>
<!--  <th width="39" rowspan="2">Days Remaining</th>-->
  <th width="39" rowspan="2">Total Work</th>
  <th width="57" rowspan="2">Planned Work</th>
  <th width="47" rowspan="2">Actual Work</th>
  <th width="71" rowspan="2" title="Difference">&#916;</th>
  <th width="66" rowspan="2">Current Work Rate</th>
  <th width="66" rowspan="2">Required  Rate</th>
  <th width="75" rowspan="2">Projected Date</th>
  <th width="59" rowspan="2">Progress</th>
  <!--  <th width="110">Contract Amount</th> -->  
</tr>
<tr>
  <th width="85">Start</th>
  <th width="91">Finish</th>
  </tr>

<?php 
/*$date_set=GetDates($data_level_id);
$minStartDate=$date_set["minStartDate"];
$maxEndDate=$date_set["maxEndDate"];
$maxEndTimeStamp =strtotime($maxEndDate);
$minStartTimeStamp=strtotime($minStartDate);
  
$t_timeDiff = abs($maxEndTimeStamp - $minStartTimeStamp);
$totalNumberDays=GetTotalDays($data_level_id);*/
?>
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
?>
<?php 
if($data_level_id!=0&&$data_level_id!="")
{
	$reportquery ="SELECT * FROM activity where itemid=".$data_level_id." order by  itemid ASC";
	$reportresult = mysql_query($reportquery);			
while ($reportdata = mysql_fetch_array($reportresult)) {
	$i++;
					  $average_rate=0;
					  $projected_days=0;
					  $projected_date='';
					  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
					  $last_date=GetlastDate($data_level_id);
					  $actual_start_date=ActualStartDate($data_level_id);
					  $endTimeStamp =strtotime($reportdata['enddate']);
					  $startTimeStamp=strtotime($reportdata['startdate']);
					  $current_date_c=$last_date;
					  $currentTimeStamp=strtotime($last_date);
					 $numberDays=CalculateActualPlannedDays($reportdata['enddate'],$reportdata['startdate']);
					 /* $timeDiff = abs($endTimeStamp - $startTimeStamp);
					  $numberDays = ceil($timeDiff/86400);
					  $numberDays = intval($numberDays);*/
 
						if($current_date_c>$reportdata['enddate'])
						 {
							 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
							  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
							  $numberDaysDelayed = intval($numberDaysDelayed);
						 }
 
						  $today_qty=TodayProgress($reportdata['itemid'], $current_date_c);
						  $till_today_qty=ActualProgress($reportdata['itemid']);
						  
					  

	if($reportdata['baseline']!=0)
	{
	$work_done=$till_today_qty/$reportdata['baseline']*100;
	$total_work_done +=$work_done;
	}
	else
	{
	$work_done=0;
	}
	
	if($reportdata["baseline"]!=0)
	{
	$remaining=$reportdata["baseline"]-$till_today_qty;
	}
	else
	{
	$remaining=0;
	}
	/// Check for Actual Finish Date & Indicator
	
	//$current_date_c=date('Y-m-d');
	
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
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
	}
	elseif($current_date_c<$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
	{
	$case=3;
    $actual_finish_date=$current_date_c;
	}
	elseif($current_date_c<$reportdata["enddate"]&&$remaining==0&&$till_today_qty!=0)
	{
	$case=4;
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
	}
	elseif($remaining<0&&$till_today_qty!=0)
	{
	
	$case=5;
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
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
	
	/////////////////// Actual Days
	
	//echo $actual_finish_date;
	$ActualEndTimeStamp =strtotime($actual_finish_date);

  $ActualnumberDays=ActualDays($actual_start_date,$actual_finish_date,$reportdata['itemid']);
  
	if($actual_finish_date>$reportdata['startdate'])
 {
	 /*if($actual_finish_date>=$reportdata['end_date'])
	 {
		 $numberDaysElapsed=$numberDays;
	 }
	 else
	 {*/
	  $numberDaysElapsed  =CalculateElapsedDays($actual_finish_date,$reportdata['startdate']);
	 /* $timeElapsedDiff= abs($ActualEndTimeStamp - $startTimeStamp);
	  $numberDaysElapsed = ceil($timeElapsedDiff/86400);
	  $numberDaysElapsed = intval($numberDaysElapsed);*/
	 //}
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
		 //$numberDaysRemaining=$numberDays-$numberDaysElapsed;
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
	//echo $totalNumberDays;
	 $planned_progress=PlannedProgress($reportdata['itemid'],$current_date_c,$reportdata['startdate']);
	 if($planned_progress!=0)
	{
	$difference=$planned_progress-$till_today_qty;
	}
	else
	{
	$difference=0;
	}
	 if($totalNumberDays!=0&&$totalNumberDays!="")
	 {
		$weight=($numberDays/$totalNumberDays);
	 }
	 else
	 {
		 $weight=0;
	 }
?>

<tr style="background-color:<?php echo $bgcolor;?>; ">
<td height="20" style="text-align:center;"><?php echo $i;?></td>
<td style="text-align:left;"><?php echo $reportdata["secheduleid"];?></td>
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
<td style="text-align:center;"><?php echo $reportdata["weight"];?></td>
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
<td style="text-align:right;" colspan="2"><?php 
if(isset($actual_finish_date)&&$actual_finish_date!=""&&$actual_finish_date!="1970-01-31"&&$actual_finish_date!="0000-00-00")
  	{
		$fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$finish_date=$fyear."-".$fmonth."-".$fmonth_days;
		echo date('d-m-Y',strtotime($finish_date));
		
		
	}
	else
	{
	echo "-";}?></td>

<td style="text-align:right;"><?php echo $numberDays;?></td>
<!--<td style="text-align:right;"><?php //echo $ActualnumberDays;?></td>-->
<td style="text-align:right;"><?php echo $numberDaysElapsed;?></td>
<?php /*?><td style="text-align:right;"><?php echo $numberDaysRemaining;?></td><?php */?>
<td style="text-align:right;"><?php echo number_format(($reportdata["baseline"]),0);?></td>
<td style="text-align:right;"><?php echo number_format($planned_progress,0);?></td>
<td style="text-align:right;"><?php echo number_format($till_today_qty,0);?></td>
<td style="text-align:right;"><?php echo number_format(($difference),0);?></td>
<td style="text-align:right;"><?php echo number_format(($current_daily_rate),0);?></td>
<td style="text-align:right;"><?php echo number_format(($require_daily_rate),0);?></td>
<td style="text-align:right;"><?php if($projected_date!=""&&$projected_date!="1970-01-01"&&$projected_date!="0000-00-00")
									echo date('d-m-Y',strtotime($projected_date));?></td>
<td style="text-align:right;"><?php echo number_format($work_done,2) ." %";?></td>
</tr>
<?php
$numberDaysDelayed=0;
$projected_date="";
}
if($count!=0)
{
$average_progress=$total_work_done/$count;
}
else
{
$average_progress=0;
}
?>
<tr style="background-color:<?php echo $bgcolor;?>;">
<td height="20" style="text-align:left;" colspan="15">
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
<td height="20" style="text-align:right;" colspan="2"><strong>Average Progress:</strong></td>

<td style="text-align:center;" colspan="1"><strong><?php echo number_format($average_progress,2) ." %";?></strong></td>
</tr>
<?php } // end if condition ?>
</table>
<?php
$actual_finish_date="";
$case=0;
$numberDaysRemaining=0;

?>
<?php }?>





