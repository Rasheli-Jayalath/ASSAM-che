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
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(z.startdate) as startdate, max(z.enddate) as enddate, sum(z.baseline) as baseline FROM  base_data_cube z  where kpiid=".$data_level_id." Group by z.itemid";
$i=0;
$progress=0;
$pcurrent=0;
$pprev=0;
$reportresult = mysql_query($reportquery);
while ($reportdata = mysql_fetch_array($reportresult)) 
{
									 $baseline=$reportdata['baseline'];
									 $mdetail=$reportdata["code"];
									 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$till_end."' AND scmonth<='".$gend."' 
									 order by scid ASC";
									 $scaleresult = mysql_query($scalesql);
									 $total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
										$i++;
									 $scmonth=$scalerows['scmonth'];	
									 $scid=$scalerows['scid'];	
									 $pdate=date('Y-m-d',strtotime($scmonth));
									 $m=date('m',strtotime($pdate));
									 $y=date('Y',strtotime($pdate));
									 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
									 $pdate=$y."-".$m."-".$days;
									 $scmonth=$pdate;
									$month_mtargets=getMilestoneTargetsCCC($scid,$reportdata['itemid']);
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }
									$month_machieve=getMilestoneAchieveCCC($scmonth,$reportdata['itemid']);
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
																
							
									 $pdate=date('Y-m-d',strtotime($scmonth));
									 $m=date('m',strtotime($pdate));
									 $y=date('Y',strtotime($pdate));
									 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
									 $pdate=$y."-".$m."-".$days;
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
                text: '<?php echo "(Milestone Progress ".date('Y',strtotime($lastMonth)).")";?>'
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
<td colspan="30" align="center"><span class="white"><strong><?php echo $pdata["pdetail"];?> (Milestone Level <?php echo date('Y',strtotime($till_end)); ?>)</strong></span></td>
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
<th width="5%">Achieved</th>
<th>Aggregation</th>
<th>Till <?php echo $till_last_month=$till_end; ?></th>
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
$reportquery ="SELECT * from kpi_base_level_report  where kpiid=".$data_level_id." Group by kpiid";

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
	
	$baseline=$reportdata['baseline'];
  	$bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";

?>


<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td rowspan="2" style="text-align:right;"><?php echo $reportdata['itemcode']; ?></td>
  <td rowspan="2" style="text-align:left;"><?php  echo $reportdata['itemname']; ?></td>
  <td rowspan="2" style="text-align:center;"><?php echo $reportdata["unit"];?></td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['baseline'],0); ?></td>
  <td rowspan="2" style="text-align:right;">&nbsp;</td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'])."&nbsp;%"; ?></td>
  <td height="20" style="text-align:right;">Achieved:</td>
  <td style="text-align:right;">Accumulative</td>
  <?php 				
									$latest_month=$end_scid;
									$last_month=$till_end_scid;		
								   
									$ptodate=getMilestoneTotalAchieveCLatest($latest_month,$reportdata['kpiid']);
									$ptolast=getMilestoneTotalAchieveCLast($last_month,$reportdata['kpiid']);
									$todate=getMilestoneTotalTargetsCLatest($latest_month,$reportdata['kpiid']);
									$tolast=getMilestoneTotalTargetsCLast($last_month,$reportdata['kpiid']);
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
 
 $scalesql = "SELECT scid FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scid=$scalerows['scid'];
 $month_machieve=0;
 $month_prog=0;
?>
     <?php 
									$month_machieve=getMilestoneAchieveCCC($scid,$reportdata['kpiid']);
									
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
									 	$month_mtargets=getMilestoneTargetsCCC($scid,$reportdata['kpiid']);
									
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }
									$pmonth_machieve=getMilestoneAchievePC($scid,$reportdata['kpiid']);
									$pmonth_mtargets=getMilestoneTargetsPC($scid,$reportdata['kpiid']);
								 ?>
  <td rowspan="4" style="text-align:right;"><table width="200" border="1">
    <tr>
      <td><?php echo $month_prog;?></td>
    </tr>
    <tr>
      <td><?php echo $month_targ;?></td>
    </tr>
    <tr>
      <td><?php echo $pmonth_machieve;?></td>
    </tr>
    <tr>
      <td><?php echo $pmonth_mtargets;?></td>
    </tr>
  </table></td>
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






