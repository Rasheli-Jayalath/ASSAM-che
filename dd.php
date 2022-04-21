<?php 
$total_progress=GetActualQtysOutputLevelG($parentgroup,$aweight);
$total_planned_progress= GetPlannedQtysOutputLevelG($parentgroup);
  $scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as total_baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$total_baseline=$reportdata_scale["total_baseline"];
	$remaining=$total_baseline-$total_progress;
	$last_date=GetlastDateOutput($parentgroup);
			 $actual_start_date=ActualStartDateOutput($parentgroup);
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
				 
				  $numberDaysElapsed  =CalculateElapsedDays($actual_finish_date,$reportdata_scale['startdate']);
				
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
                text: '<?php echo "Progress To-Date "; //.//date('d-m-Y',strtotime($current_date_c));?>'
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
				<?php //echo GetActualQtysPDOLevel($parentgroup,$aweight);?>
       
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned',
                data: [
				<?php //echo GetPlannedQtysPDOLevel($parentgroup,$aweight);?>
                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			
			]
        });
    });
    

		</script>
        <table width="100%"  align="left" border="0" style="margin:0">
  <!-- 
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   -->
</table></td>
</tr>
</table>