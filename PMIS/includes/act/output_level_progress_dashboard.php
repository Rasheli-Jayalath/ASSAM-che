<?php 
if($adata["isentry"]==0&& isset($_REQUEST["output"]) && $_REQUEST["output"]!=0 && $_REQUEST["output"]==$data_level_id && $data_level_param ==
"output")
{
 $total_progress=GetActualQtysOutputLevelG($aparentgroup,$aweight);
 $total_planned_progress= GetPlannedQtysOutputLevelG($aparentgroup);
 $scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as total_baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$total_baseline=$reportdata_scale["total_baseline"];
	$remaining=$total_baseline-$total_progress;
	$last_date=GetlastDateOutput($aparentgroup);
			 $actual_start_date=ActualStartDateOutput($aparentgroup);
			 $current_date_c=$last_date;
			 $currentTimeStamp=strtotime($last_date);
			 $startTimeStamp=strtotime($reportdata_scale['startdate']);
			 $final_date=$reportdata_scale['enddate'];
			 $endTimeStamp =strtotime($reportdata_scale['enddate']);
			 $numberDays=CalculateActualPlannedDays($reportdata_scale['enddate'],$reportdata_scale['startdate']);
			 $actual_finish_date=$current_date_c;
			 $ActualEndTimeStamp =strtotime($actual_finish_date);
			 if($current_date_c>$reportdata_scale['enddate'])
			 {
				 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
				  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
				  $numberDaysDelayed = intval($numberDaysDelayed);
			 }
			 	if($actual_finish_date>$reportdata_scale['startdate'])
			 	{
				 
				  $numberDaysElapsed  =CalculateElapsedDays($actual_finish_date,$reportdata_scale[
				  'startdate']);
				
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
			if($actual_finish_date!=""&&$reportdata_scale["enddate"]>=$actual_finish_date&& $remaining>0)
	 {
	
		  $timeRemainingDiff= abs($endTimeStamp - $ActualEndTimeStamp);
		  $numberDaysRemaining = ceil($timeRemainingDiff/86400);
		 $numberDaysRemaining = intval($numberDaysRemaining);
	 }
	  if($numberDaysElapsed!=0&&$remaining!=0)
	 {
		 $current_daily_rateg=$total_progress/$numberDaysElapsed;
	 }
	 else
	 {
		 $current_daily_rateg=0;
	 }
	 if($numberDaysRemaining!=0&&$remaining!=0&&$numberDaysElapsed!=0)
	{
	
	$require_daily_rateg=($remaining)/$numberDaysRemaining;
	}
	elseif($numberDaysElapsed==0&& $current_date_c<$reportdata_scale['startdate'])
	{
	 	
	$require_daily_rateg=0;
	}
	else
	{
	$require_daily_rateg=0;
	//$bgcolor='#FF0';
	}
	if($current_daily_rateg!=0&&$remaining>0)
	{
	$projected_days=$remaining/($current_daily_rateg);
	}
	
	$projected_days=intval($projected_days);
	
	if($projected_days!=0&&$numberDaysElapsed!=0)
	{
	$projected_date=date("Y-m-d", strtotime($actual_finish_date. "+".$projected_days." days" ));
	}
	elseif($projected_days==0&&$numberDaysElapsed==0)
	{
		
	$projected_date=$end_date;
	}
	else
	{
	$projected_date="";
	}
	?>
<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding:0; margin:0;"> 
<tr> 
<td align="left" valign="top" width="50%" >
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
                text: '<?php echo "Progress To-Date "; ?>'
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
				echo "Actual Progress: ";?><?php echo '<span style="color:blue">'.number_format(round($total_progress)/$total_baseline*100,2).'%</span>';?>',
                
                data: [
				<?php echo GetActualQtysOutputLevel($aparentgroup,$aweight);?>
       
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned: <?php echo '<span style="color:blue">'.number_format( $total_planned_progress/$total_baseline*100,2).'%</span>';?>',
                data: [
				<?php echo GetPlannedQtysOutputLevel($aparentgroup,$aweight);?>
                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			,
			{ name: 'Current Work Rate (Per Day): <?php echo '<span style="color:blue">'.number_format(round($current_daily_rateg)/$total_baseline*100,2).'%</span>';?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Required Rate (Per Day): <?php echo '<span style="color:blue">'.number_format(round($require_daily_rateg)/$total_baseline*100,2).'%</span>';?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }}
				,
			{ name: 'Projected Completion Date with Current Rate: <?php 
			if($projected_date!=""&& $projected_date!="1997-01-01" && $projected_date!="0000-00-00") 
			{
				echo '<span style="color:blue">'.date('d-M-Y',strtotime($projected_date)).'</span>';
			}?>',
			  
			  marker: {
				   
                    enabled: false,
					radius : -1
                }},
				{ name: 'Planned Completion Date: <?php 
				if($final_date!=""&& $final_date!="1997-01-01" && $final_date!="0000-00-00") 
			{
				echo '<span style="color:blue">'.date('d-M-Y',strtotime($final_date)).'</span>';
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
$tolerance=0.5;
$timeRemainingDiff=0;
$next_level_id=0;
?>
<?php if($data_level_id!=0&&$data_level_id!=""&&$data_level_param =="output")
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
		
		
		if($reportdata_act["isentry"]==1)
		{
			
			////GetBaseLevel();
			$wgt_query="select sum(weight) as weight  from maindata where itemid=".$reportdata_act["itemid"];
		$wqtresult = mysql_query($wgt_query);
		$wgtdata= mysql_fetch_array($wqtresult);
		$w_eight=$wgtdata["weight"];	
			
			$average_rate=0;
		    $projected_days=0;
		    $projected_date='';
		   // $next_level_id=GetNextLevel($reportdata_act["itemid"]);
		$reportquery ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$reportdata_act["parentgroup"]."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
			//echo "<br/>";
	        $reportresult = mysql_query($reportquery);
			$reportdata = mysql_fetch_array($reportresult);
			
			 $numberDays=CalculateActualPlannedDays($reportdata['enddate'],$reportdata['startdate']);
			 //$last_date=GetlastDateOutput($reportdata_act["parentgroup"]);
			 $last_date=GetlastDate($reportdata['itemid']);
			  $actual_start_date=ActualStartDate($reportdata['itemid']);
			// $actual_start_date=ActualStartDateOutput($reportdata_act["parentgroup"]);
			 $current_date_c=$last_date;
			 $currentTimeStamp=strtotime($last_date);
			 $startTimeStamp=strtotime($reportdata['startdate']);
			 $endTimeStamp =strtotime($reportdata['enddate']);
			 if($current_date_c>$reportdata['enddate'])
			 {
				 $timeDelayedDiff= abs($currentTimeStamp - $endTimeStamp);
				  $numberDaysDelayed = ceil($timeDelayedDiff/86400);
				  $numberDaysDelayed = intval($numberDaysDelayed);
			 }
			 $till_today_qty=ActualProgressOutput($reportdata_act["parentgroup"]);
			 $till_today_qty=$till_today_qty;
			$planned_progress=PlannedProgressOutput($reportdata_act["parentgroup"],$current_date_c,$reportdata['startdate']);
			  $planned_progress=$planned_progress;
			 
			if($reportdata['baseline']!=0)
			{
			$work_done=$till_today_qty/$reportdata['baseline']*100;
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
			if($reportdata['baseline']!=0)
			{
				
			$remaining=$reportdata['baseline']-$till_today_qty;
			}
			else
			{
			$remaining=0;
			}
			$tolerance_check=$reportdata['baseline']*$tolerance/100;
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
	 $actual_finish_date=ActualFinishDate($reportdata['itemid']);
	}
	elseif($current_date_c>$reportdata["enddate"]&& $remaining==0 && $till_today_qty!=0)
	{
	$case=2;
	$actual_finish_date=ActualFinishDate($reportdata['itemid']);
	}
	elseif($current_date_c<$reportdata["enddate"]&&$remaining>0&&$till_today_qty!=0)
	{
		
	$case=3;
   //  $actual_finish_date=$current_date_c;
	 $actual_finish_date=ActualFinishDate($reportdata['itemid']);
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
		$actual_finish_date;
		 $reportdata["enddate"];
		 //$numberDaysRemaining=$numberDays-$numberDaysElapsed;
		   $timeRemainingDiff= abs($endTimeStamp - $ActualEndTimeStamp);
		  
		  $numberDaysRemaining = ceil($timeRemainingDiff/86400);
		 $numberDaysRemaining = intval($numberDaysRemaining);
	 }
				 
				 //  Current Daily rate
			
				if($numberDaysElapsed!=0&&$remaining!=0)
				 {
				$current_daily_rate=$till_today_qty/$numberDaysElapsed;
				 }
				 else
				 {
					 $current_daily_rate=0;
				 }
		
				
				if($numberDaysRemaining!=0&&$remaining!=0&&$numberDaysElapsed!=0)
				{
				 $require_daily_rate=($remaining)/$numberDaysRemaining;
				
				}
				elseif($numberDaysElapsed==0&& $current_date_c<$reportdata['startdate'])
				{	
				$require_daily_rate=0;
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
				
			/* if($totalNumberDays!=0&&$totalNumberDays!="")
			 {
				$weight=($numberDays/$totalNumberDays);
			 }
			 else
			 {
				 $weight=0;
			 }*/
		
		}
		else
		{
			$average_rate=0;
		    $projected_days=0;
		    $projected_date='';
		$wgt_query="select sum(weight) as weight  from maindata where parentcd=".$reportdata_act["itemid"];
		$wqtresult = mysql_query($wgt_query);
		$wgtdata= mysql_fetch_array($wqtresult);
		$w_eight=$wgtdata["weight"];	
		   // $next_level_id=GetNextLevel($reportdata_act["itemid"]);
		 $reportquery ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$reportdata_act["parentgroup"]."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
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
			 $planned_progress=PlannedProgressOutput($reportdata_act["parentgroup"],
			 $current_date_c,$reportdata['startdate']);
			if($reportdata['baseline']!=0)
			{
			$work_done=$till_today_qty/$reportdata['baseline']*100;
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
				
				$projected_days=$projected_days;
				if($projected_days!=0)
				{
				$projected_date=date("Y-m-d", strtotime($actual_finish_date. "+".$projected_days." days" ));
				}
				else
				{
				$projected_date="";
				}
				$count++;
				
			/* if($totalNumberDays!=0&&$totalNumberDays!="")
			 {
				$weight=($numberDays/$totalNumberDays);
			 }
			 else
			 {
				 $weight=0;
			 }*/
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
<td style="text-align:right;"><?php echo number_format(($reportdata['baseline']),0);?></td>
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
<td height="20" style="text-align:left;" colspan="18">
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





