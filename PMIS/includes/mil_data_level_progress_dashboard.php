<?php 
if($adata["isentry"]==1)
{
?>
<div id="result4">
<?php 

$mob_weighted_progress=0;
$current=0;
$prev=0;
$current1=0;
$prev1=0;
$current2=0;
$prev2=0;
$latest_achieved=0;
$baseline=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline FROM maindata z inner join milestone_activity a on (z.itemid=a.milestoneid) inner join activity b on (a.activityid=b.aid) inner join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where a.milestoneid=".$data_level_id." Group by z.itemid";
$i=0;
$progress=0;
$pcurrent=0;
$pprev=0;
$reportresult = mysql_query($reportquery);
while ($reportdata = mysql_fetch_array($reportresult)) 
{
									 $baseline=$reportdata['baseline'];
									 $mdetail=$reportdata["code"];
									 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$gend."' order by scid 
									  ASC";
									 $scaleresult = mysql_query($scalesql);
									 $total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
										$i++;
									$scmonth=$scalerows['scmonth'];	
									 $pdate=date('Y-m-d',strtotime($scmonth));
									 $m=date('m',strtotime($pdate));
									 $y=date('Y',strtotime($pdate));
									 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
									 $pdate=$y."-".$m."-".$days;
									 $scmonth=$pdate;
									$month_mtargets=getMilestoneTargetsCCC($scmonth,$reportdata['itemid']);
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }
									$month_machieve=getMilestoneAchieveCCC($scmonth,$reportdata['itemid']);
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
																
							
									
									   $m=$m-1;
									$planned_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
									 ",".date('d',strtotime($pdate)). ") , ".number_format($month_targ,2)." ]";
									 
									 $actual_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
									 ",".date('d',strtotime($pdate)). ") , ".number_format($month_prog,2)." ]";
									 if($i<$total_months)
									 {
									 $planned_str .=" , ";
									 $actual_str .=" , ";
									  
									 }
									 $diff=$month_targ-$month_prog;
									}

}

	 ?>
        <script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<?php echo  trim($mdetail);?>'
            },
            subtitle: {
                text: '<?php echo "Milestone Progress (2017)";?>'
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
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' %';
                }
            },
             legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 30,
            floating: true/*,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
        },
            series: [
			<?php  			
				
			 ?> {
                name: '<?php echo "Actual Progress   :  ".number_format($month_prog,2) ." %";?>
				',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
			
                   <?php echo $actual_str;?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
            },
			{
                 name: '<?php echo "Planned Progress : ".number_format($month_targ,2)." %"; ?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
			
                  <?php echo $planned_str;?>
					
                    
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
			
            }
			,
			{
                name: '    <?php echo "    Gap : ".number_format(($month_targ-$month_prog),2)." %";?>',
				
				color: 'white',
                
				marker: {
               
                 enabled: false,
				 visible: false
            }
			
            }
			
			]
        });
    });
    

		</script>
        
        
<table width="90%"  align="right" border="0" style="margin:5px 5px 5px 5px">
      
      <tr>
        <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
          <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
        </td>
        
    </tr>
      
  </table>


<table  cellpadding="0px" cellspacing="0px"   width="98%" align="center"  id="tblList" style="border-left:1px #000000 solid;">
<tr bgcolor="000066" style=" color:#FFF">
<td colspan="21" align="center"><span class="white"><strong><?php echo $pdata["pdetail"];?> (Milestone Level)</strong></span></td>
</tr>
<tr>

  <th width="5%" ></th>
  <th width="40%"></th>
  <th  width="4%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
 <?php $scalesql = "SELECT DISTINCT(scquarter),scyear FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
 ?>
  <th colspan="3" width="9%">Quarter <?php echo $scalerows["scquarter"]." ".$scalerows["scyear"];?> </th>
<?php }?>
  </tr>
<tr >
<th width="5%" height="37">#</th>
<th width="40%"><div align="left">Indicators</div></th>
<th width="4%">UOM</th>
<th width="5%">Baseline</th>
<th width="5%">Total Achieved/Target</th>
<th width="5%">% Weighted</th>
<th width="5%">Achieved/Target</th>
<th>Aggregation</th>
<th>Till <?php echo $till_last_month=date("M Y",strtotime("$start -1 month")); ?></th>
 <?php 
$scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
//$lastMonth=$scalerows['lastMonth'];
//$lastMonth = str_replace("-","",$lastMonth);
$dprogress_month=date('M',strtotime($scalerows["scmonth"])); ?>
<th><?php echo $dprogress_month;?></th>
<?php }?>
<!--  <th width="110">Contract Amount</th> -->  
    </tr>

<?php 

$baseline=0;
$todate=0;
$tolast=0;
$ptodate=0;
$ptolast=0;
$scalesql_l = "select max(scmonth) as lastMonth from kpiscale";
$scaleresult_l= mysql_query($scalesql_l);
$scalerows_l= mysql_fetch_array($scaleresult_l);
$lastMonth=$scalerows_l['lastMonth'];
$lastMonth=date('Y-m-d',strtotime($lastMonth));
	 $m=date('m',strtotime($lastMonth));
	 $y=date('Y',strtotime($lastMonth));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $lastMonth=$y."-".$m."-".$days;
$lastMonth = str_replace("-","",$lastMonth);

$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline, b.rid FROM maindata z inner join milestone_activity a on (z.itemid=a.milestoneid) inner join activity b on (a.activityid=b.aid) inner join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where a.milestoneid=".$data_level_id." Group by z.itemid";
$i=0;
$progress=0;
$pcurrent=0;
$pprev=0;
$reportresult = mysql_query($reportquery);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 $progress=0;
	 $till_jan_prog=0;
	 $till_jan_targ=0;
	 $latest_targets=0;
	$ptolast=0;
	$tolast=0;
	$ptodate=0;
	$todate=0;
	$baseline=$reportdata['baseline'];
	 if($reportdata["rid"]!=""&&$reportdata["rid"]!=0)
	{
	$res_query="SELECT * from resources where rid=".$reportdata["rid"];
	$ress = mysql_query($res_query);
	$res_data=mysql_fetch_array($ress);
	}
  	$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";

?>


<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td rowspan="2" style="text-align:right;"><?php echo $reportdata['itemcode']; ?></td>
  <td rowspan="2" style="text-align:left;"><?php  echo $reportdata['itemname']; ?></td>
  <td rowspan="2" style="text-align:center;"><?php echo $res_data["unit"];?></td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['baseline'],0); ?></td>
  <td rowspan="2" style="text-align:right;">&nbsp;</td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'])."&nbsp;%"; ?></td>
  <td height="20" style="text-align:right;">Achieved:</td>
  <td style="text-align:right;">Accumulative</td>
  <?php 				
									$latest_month=$kpi_end;
									$last_month=$till_end;		
								
									$ptodate=getMilestoneTotalAchieveCLatest($latest_month,$reportdata['itemid']);
									$ptolast=getMilestoneTotalAchieveCLast($last_month,$reportdata['itemid']);
									$todate=getMilestoneTotalTargetsCLatest($latest_month,$reportdata['itemid']);
									$tolast=getMilestoneTotalTargetsCLast($last_month,$reportdata['itemid']);
									if($baseline!=0&&$tolast!=0)
									 {
										  $till_month_targ=($tolast/$baseline)*100;
									 }
									
									if($baseline!=0&&$ptolast!=0)
									 {
										
										$till_month_prog=($ptolast/$baseline)*100;
									 }
									if($baseline!=0&&$ptodate!=0)
									 {
										 $progress=($ptodate/$baseline)*100;
										
									 } ?>
  <td style="text-align:right;"><?php echo number_format($till_month_prog,2). "%";?></td>
   <?php 
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
	 $pdate=date('Y-m-d',strtotime($scmonth));
	 $m=date('m',strtotime($pdate));
	 $y=date('Y',strtotime($pdate));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $pdate=$y."-".$m."-".$days;
	 $scmonth=$pdate;
//$scmonth = str_replace("-","",$scmonth);
?>
     <?php 
									$month_machieve=getMilestoneAchieveCCC($scmonth,$reportdata['itemid']);
									
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
									
								 ?>
  <td style="text-align:right;"><?php echo number_format($month_prog,2). "%";?></td>
<?php }?>
  </tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:right;">Target:</td>
<td style="text-align:right;">Accumulative</td>
<td style="text-align:right;"><?php echo number_format($till_month_targ,2). "%";?></td>
   <?php 
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
	 $pdate=date('Y-m-d',strtotime($scmonth));
	 $m=date('m',strtotime($pdate));
	 $y=date('Y',strtotime($pdate));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $pdate=$y."-".$m."-".$days;
	 $scmonth=$pdate;

?>
     <?php
									$month_mtargets=getMilestoneTargetsCCC($scmonth,$reportdata['itemid']);
									
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }				
									 ?>
<td style="text-align:right;"><?php echo number_format($month_targ,2). "%";?></td>
<?php }?>
</tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
<td rowspan="2" style="text-align:right;">&nbsp;</td>
<td rowspan="2" style="text-align:right;">&nbsp;</td>
<td rowspan="2" style="text-align:left;">&nbsp;</td>
<td rowspan="2" style="text-align:left;">&nbsp;</td>
<td height="20" style="text-align:right;"><?php echo number_format($ptodate,2);?></td>
<td style="text-align:left;">&nbsp;</td>
<td style="text-align:right;"><strong>Achieved</strong>:</td>
<td style="text-align:right;"><strong>Monthly</strong></td>
<td style="text-align:right;"><?php echo number_format($ptolast,2);?></td>
 <?php 
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
 $pdate=date('Y-m-d',strtotime($scmonth));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y);
 $pdate=$y."-".$m."-".$days;
 $scmonth=$pdate;	
									 								

									
?>
 <?php 									
									$pmonth_machieve=getMilestoneAchievePC($scmonth,$reportdata['itemid']);
									
									 ?>
<td style="text-align:right;"><?php 
									echo number_format($pmonth_machieve,2);?></td>
<?php }?>

</tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td height="20" style="text-align:right;"><?php echo number_format($todate,2);?></td>
  <td style="text-align:left;">&nbsp;</td>
  <td style="text-align:right;"><strong>Target</strong>:</td>
  <td style="text-align:right;"><strong>Monthly</strong></td>
  <td style="text-align:right;"><?php echo number_format($tolast,2);?></td>
   <?php 
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
	 $pdate=date('Y-m-d',strtotime($scmonth));
									 $m=date('m',strtotime($pdate));
									 $y=date('Y',strtotime($pdate));
									 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
									 $pdate=$y."-".$m."-".$days;
									 $scmonth=$pdate;
?>
  <?php 								
									$pmonth_mtargets=getMilestoneTargetsPC($scmonth,$reportdata['itemid']);
									 ?>
  <td style="text-align:right;"><?php 
									echo number_format($pmonth_mtargets,2);?></td>
<?php }?>
</tr>
<?php
}
?>




<?php
/*$pprev=$reportdata['pid'];
$prev=$reportdata['cid'];
$prev1=$reportdata['s_id'];
$prev2=$reportdata['aid'];*/
}
?>
</table>

</div>






